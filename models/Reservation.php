<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Url;

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
 * @property integer $quantity_of_guest
 * @property string $remark
 * @property string $address
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property PackageItem $packageItem
 */
class Reservation extends \yii\db\ActiveRecord
{
    public $verifyCode;

    const STATUS_FOR_VERIFICATION = 5;
    const STATUS_NEW = 10;
    const STATUS_CHECK_IN = 15;
    const STATUS_CHECK_OUT = 20;
    const STATUS_CANCEL = 50;

    const SCENARIO_NEW = 'new';
    const SCENARIO_CHANGE_STATUS = 'change_status';

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CHANGE_STATUS] = ['status'];
        $scenarios[self::SCENARIO_NEW] = ['firstname', 'lastname', 'contact', 'check_in', 'quantity_of_guest', 'email', 'address', 'remark', 'verifyCode'];
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
            [['package_item_id', 'firstname', 'lastname', 'contact', 'email', 'status', 'check_in', 'quantity_of_guest', 'created_at', 'updated_at'], 'required'],
            [['package_item_id', 'status', 'quantity_of_guest', 'created_at', 'updated_at'], 'integer'],
            [['contact'], 'match', 'pattern' => '/^[\d()\s-]+$/', 'message' => 'Contact should only contain numbers, spaces, dashes, and parentheses'],
            [['check_in'], 'safe'],
            [['check_in'], 'validateCheckIn'],
            [['email'], 'email'],
            [['remark'], 'string'],
            [['verifyCode'], 'captcha', 'on' => self::SCENARIO_NEW],
            [['firstname', 'lastname'], 'string', 'max' => 25],
            [['contact'], 'string', 'max' => 50],
            [['email', 'address'], 'string', 'max' => 150],
            [['package_item_id'], 'exist', 'skipOnError' => true, 'targetClass' => PackageItem::className(), 'targetAttribute' => ['package_item_id' => 'id']],
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

    /*public function beforeSave($insert)
    {
        if ($insert) {
            $this->setAttribute('status', self::STATUS_NEW);
        }
        return parent::beforeSave($insert);
    }*/

    public function placeReservation($packageItem)
    {
        $this->setAttribute('package_item_id', $packageItem->id);
        $this->setAttribute('status', self::STATUS_FOR_VERIFICATION);
        if ($this->save()) {
            $message = '<p>You just placed a reservation to our resort using this email. In order for us to process this request, please click the link below to activate it.</p><p><a href="' . Url::to(['site/confirm-reservation', 'id' => $this->id], true) .'">Confirm reservation</a></p>';
            Yii::$app->mailer->compose()
                ->setFrom(Yii::$app->user->identity->email)
                ->setTo($this->email)
                ->setSubject(Yii::$app->params['appName'] . ' - Confirm Your Reservation')
                ->setHtmlBody($message)
                ->send();
            return true;
        }
        return false;
    }

    public function confirmReservation()
    {
        $this->setAttribute('status', self::STATUS_NEW);
        $this->scenario = self::SCENARIO_CHANGE_STATUS;
        return $this->save();
    }

    public function cancel()
    {
        $this->scenario = self::SCENARIO_CHANGE_STATUS;
        $this->setAttribute('status', self::STATUS_CANCEL);
        return $this->save();
    }

    public function checkIn()
    {
        $this->scenario = self::SCENARIO_CHANGE_STATUS;
        $this->setAttribute('status', self::STATUS_CHECK_IN);
        return $this->save();
    }

    public static function getStatusDropdownList($template = 'raw')
    {
        if ($template === 'raw') {
            $model = [
                self::STATUS_NEW => 'NEW',
                self::STATUS_CHECK_IN => 'CIN',
                self::STATUS_CHECK_OUT => 'OUT',
                self::STATUS_CANCEL => 'CAN',
            ];
        } else if ($template === 'html') {
            $model = [
                self::STATUS_NEW => '<span class="label label-primary">NEW</span>',
                self::STATUS_CHECK_IN => '<span class="label label-success">CIN</span>',
                self::STATUS_CHECK_OUT => '<span class="label label-warning">OUT</span>',
                self::STATUS_CANCEL => '<span class="label label-danger">CAN</span>',
            ];
        }
        return $model;
    }

    public static function getStatusValue($id)
    {
        $status = self::getStatusDropdownList('html');
        if (isset($status[$id])) {
            return $status[$id];
        }
    }

    public function validateCheckIn($attribute, $params)
    {
        $dateToCompare = $this->$attribute;
        $now = date('Y-m-d');
        if (strtotime($dateToCompare) < strtotime($now)) {
            $this->addError($attribute, 'The check-in date should not set to period earlier than today.');
        }
    }

    public static function getReservationCount($status)
    {
        return self::find()->where(['status' => $status])->count();
    }
}
