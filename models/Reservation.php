<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Url;
use yii\base\UserException;
use yii\helpers\Json;
use yii\db\Expression;

use PayPal\Api\CreditCard;
use PayPal\Api\CreditCardToken;
use PayPal\Api\FundingInstrument;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\Transaction;
use PayPal\Api\Amount;
use PayPal\Exception\PPConnectionException;
use PayPal\Exception\PayPalConnectionException;

/**
 * This is the model class for table "{{%reservation}}".
 *
 * @property integer $id
 * @property integer $package_item_id
 * @property string $firstname
 * @property string $lastname
 * @property string $contact
 * @property string $email
 * @property integer $status
 * @property string $check_in
 * @property string $check_out
 * @property integer $quantity_of_guest
 * @property string $remark
 * @property string $address
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $creditcard_id
 *
 * @property PackageItem $packageItem
 */
class Reservation extends \yii\db\ActiveRecord
{
    public $verifyCode;
    public $cc_type;
    public $cc_number;
    public $cc_cvv;
    public $cc_expiry_month;
    public $cc_expiry_year;

    const STATUS_FOR_VERIFICATION = 5;
    const STATUS_NEW = 10;
    const STATUS_CONFIRM = 15;
    const STATUS_DONE = 20;
    const STATUS_CANCEL = 50;
    const STATUS_DELETE = 60;

    const SCENARIO_NEW = 'new';
    const SCENARIO_CHANGE_STATUS = 'change_status';

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CHANGE_STATUS] = ['status'];
        $scenarios[self::SCENARIO_NEW] = ['firstname', 'lastname', 'contact', 'check_in', 'check_out', 'quantity_of_guest', 'email', 'address', 'remark', 'verifyCode', 'cc_type', 'cc_number', 'cc_cvv', 'cc_expiry_month', 'cc_expiry_year'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%reservation}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['package_item_id', 'firstname', 'lastname', 'contact', 'email', 'status', 'check_in', 'check_out', 'quantity_of_guest', 'created_at', 'updated_at', 'cc_type', 'cc_number', 'cc_cvv', 'cc_expiry_month', 'cc_expiry_year'], 'required'],
            [['package_item_id', 'status', 'quantity_of_guest', 'created_at', 'updated_at', 'cc_cvv', 'cc_expiry_month', 'cc_expiry_year'], 'integer'],
            [['contact'], 'match', 'pattern' => '/^[\d()\s-]+$/', 'message' => 'Contact should only contain numbers, spaces, dashes, and parentheses'],
            ['check_in', 'date', 'format' => 'php:Y-m-d'],
            ['check_out', 'date', 'format' => 'php:Y-m-d'],
            ['check_out', 'compare', 'compareAttribute' => 'check_in', 'operator' => '>='],
            [['check_in', 'check_out'], 'validateCheckDate'],
            ['checkin', 'compare', 'compareValue' => 'checkout', 'operator' => '<='],
            [['email'], 'email'],
            [['remark'], 'string'],
            [['verifyCode'], 'captcha', 'on' => self::SCENARIO_NEW],
            [['firstname', 'lastname'], 'string', 'max' => 25],
            [['contact'], 'string', 'max' => 50],
            [['email', 'address'], 'string', 'max' => 150],
            [['creditcard_id', 'cc_number'], 'string', 'max' => 40],
            [['package_item_id'], 'exist', 'skipOnError' => true, 'targetClass' => PackageItem::className(), 'targetAttribute' => ['package_item_id' => 'id']],
            [['firstname', 'lastname'], 'match', 'pattern' => '/^[A-Za-z]+$/'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'package_item_id' => Yii::t('app', 'Package Item'),
            'firstname' => Yii::t('app', 'First Name'),
            'lastname' => Yii::t('app', 'Last Name'),
            'contact' => Yii::t('app', 'Contact'),
            'email' => Yii::t('app', 'Email'),
            'status' => Yii::t('app', 'Status'),
            'check_in' => Yii::t('app', 'Check In'),
            'quantity_of_guest' => Yii::t('app', '# of Guest'),
            'remark' => Yii::t('app', 'Additional Details'),
            'address' => Yii::t('app', 'Address'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'verifyCode' => Yii::t('app', 'Verification Code'),
            'creditcard_id' => Yii::t('app', 'Creditcard ID'),
            'cc_type' => Yii::t('app', 'Type'),
            'cc_number' => Yii::t('app', 'Number'),
            'cc_cvv' => Yii::t('app', 'Cvv2'),
            'cc_expiry_month' => Yii::t('app', 'Expiry Month'),
            'cc_expiry_year' => Yii::t('app', 'Expiry Year'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPackageItem()
    {
        return $this->hasOne(PackageItem::className(), ['id' => 'package_item_id']);
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => time(),
            ],
        ];
    }

    public function placeReservation($packageItem)
    {
        if ($this->validate()) {
            $paypalContext = Yii::$app->myPaypalPayment->getContext();

            try {
                $card = new CreditCard();
                $card->setType($this->cc_type);
                $card->setNumber($this->cc_number);
                $card->setExpireMonth($this->cc_expiry_month);
                $card->setExpireYear($this->cc_expiry_year);
                $card->setCvv2($this->cc_cvv);
                $card->create($paypalContext);
            } catch (PayPalConnectionException $ex) {
                $exception = Json::decode($ex->getData());
                throw new UserException($exception['details'][0]['issue']);
            }

            $this->setAttribute('package_item_id', $packageItem->id);
            $this->setAttribute('status', self::STATUS_FOR_VERIFICATION);
            $this->setAttribute('creditcard_id', $card->getId());

            if ($this->save(false)) {
                $this->refresh();

                try {
                    $ccToken = new CreditCardToken();
                    $ccToken->setCreditCardId($this->getAttribute('creditcard_id'));

                    $fi = new FundingInstrument();
                    $fi->setCreditCardToken($ccToken);

                    $payer = new Payer();
                    $payer->setPaymentMethod("credit_card");
                    $payer->setFundingInstruments([$fi]);

                    $amount = new Amount();
                    $amount->setCurrency(Yii::$app->myPaypalPayment->getCurrency());
                    $amount->setTotal(($this->packageItem->rate * 0.5) / 46.52);

                    $transaction = new Transaction();
                    $transaction->setAmount($amount);
                    $transaction->setDescription('Hotel Reservation Fee - ' . $this->getAttribute(Yii::$app->formatter->asDateTime($this->getAttribute('check_in'))));

                    $payment = new Payment();
                    $payment->setIntent("sale");
                    $payment->setPayer($payer);
                    $payment->setTransactions(array($transaction));

                    $payment->create($paypalContext);
                } catch (PPConnectionException $ex) {
                    throw new UserException($ex->getData());
                } catch (\Exception $ex) {
                    throw new UserException($ex->getMessage());
                }

                $this->setAttribute('status', self::STATUS_NEW);
                $this->update(false);

                return true;
            }
        }
        return false;
    }

    public function changeStatus($status)
    {
        $this->setAttribute('status', $status);
        $this->scenario = self::SCENARIO_CHANGE_STATUS;
        return $this->save();
    }

    public static function getStatusDropdownList($template = 'raw')
    {
        if ($template === 'raw') {
            $model = [
                self::STATUS_FOR_VERIFICATION => 'Pending',
                self::STATUS_NEW => 'New',
                self::STATUS_CONFIRM => 'Confirmed',
                self::STATUS_DONE => 'Done',
                self::STATUS_CANCEL => 'Cancelled',
                self::STATUS_DELETE => 'Deleted',
            ];
        } else if ($template === 'html') {
            $model = [
                self::STATUS_FOR_VERIFICATION => '<span class="label label-warning">Pending</span>',
                self::STATUS_NEW => '<span class="label label-primary">New</span>',
                self::STATUS_CONFIRM => '<span class="label label-success">Confirmed</span>',
                self::STATUS_DONE => '<span class="label label-info">Done</span>',
                self::STATUS_CANCEL => '<span class="label label-danger">Cancelled</span>',
                self::STATUS_DELETE => '<span class="label label-default">Deleted</span>',
            ];
        }
        return $model;
    }

    public static function getStatusValue($id, $template = 'html')
    {
        $status = static::getStatusDropdownList($template);
        if (isset($status[$id])) {
            return $status[$id];
        }
    }

    public function getVacancyCount()
    {
        if (empty($this->check_in)) {
            return null;
        } else {
            $reservation = self::find()
                ->where(['<=', 'check_in', $this->check_in])
                ->andWhere(['>=', 'check_out', $this->check_out])
                ->andWhere(['status' => self::STATUS_CONFIRM])
                ->andWhere(['package_item_id' => $this->package_item_id])
                ->count();
            $transaction = \app\models\Transaction::find()
                ->where(['<=', 'check_in', $this->check_in])
                ->andWhere(['>=', 'check_out', $this->check_out])
                ->andWhere(['status' => \app\models\Transaction::STATUS_CHECK_IN])
                ->andWhere(['package_item_id' => $this->package_item_id])
                ->count();
            $packageItem = PackageItem::findOne($this->package_item_id);
            return $packageItem->quantity - ($reservation + $transaction);
        }
    }

    public function validateCheckDate($attribute, $params)
    {
        $dateToCompare = $this->$attribute;
        $now = date('Y-m-d');
        if (strtotime($dateToCompare) < strtotime($now)) {
            $this->addError($attribute, 'The ' . $this->getAttributeLabel($attribute) . ' should not set to period earlier than today.');
        }
        $reservation = self::find()
            ->where(['<=', 'check_in', $this->check_in])
            ->andWhere(['>=', 'check_out', $this->check_out])
            ->andWhere(['status' => self::STATUS_CONFIRM])
            ->andWhere(['package_item_id' => $this->package_item_id])
            ->count();
        $transaction = \app\models\Transaction::find()
            ->where(['<=', 'check_in', $this->check_in])
            ->andWhere(['>=', 'check_out', $this->check_out])
            ->andWhere(['status' => \app\models\Transaction::STATUS_CHECK_IN])
            ->andWhere(['package_item_id' => $this->package_item_id])
            ->count();
        $packageItem = PackageItem::findOne($this->package_item_id);
        $quantity = $packageItem->quantity - ($reservation + $transaction);
        if ($quantity < 1) {
            $this->addError($attribute, 'No available room.');
        }
    }

    public static function getStatusCount($status = null, $package_item_id = null, $checkInDate = null)
    {
        $model = self::find();
        if ($checkInDate !== null) {
            $model->where(['check_in' => $checkInDate]);
        } else {
            $model->where(['check_in' => date('Y-m-d')]);
        }
        if ($status !== null) {
            $model->andWhere(['status' => $status]);
        }
        if ($package_item_id !== null) {
            $model->andWhere(['package_item_id' => $package_item_id]);
        }
        return $model->count();
    }

    public static function deleteOldReservation()
    {
        self::updateAll(['status' => self::STATUS_DELETE], ['and', ['=', 'status', self::STATUS_NEW], ['<', 'check_in', date('Y-m-d')]]);
    }

    public static function getStatusColumnGraph()
    {
        $data = [
            ['name' => '', 'data' => array_fill(0, 12, 0)],
        ];
        $reservations = Yii::$app->db->createCommand('SELECT status, MONTH(check_in) AS month, COUNT(*) AS count FROM {{%reservation}} WHERE YEAR(check_in) = :year GROUP BY status')
            ->bindValue(':year', date('Y'))
            ->queryAll();
        if (!empty($reservations)) {
            for ($i = 0; $i < count($reservations); $i++) {
                $months = array_fill(0, 12, 0.0);
                $months[($reservations[$i]['month'] - 1)] = (float)$reservations[$i]['count'];
                $data[$i] = [
                    'name' => static::getStatusValue($reservations[$i]['status']),
                    'data' => $months,
                ];
            }
        }
        return $data;
    }
}
