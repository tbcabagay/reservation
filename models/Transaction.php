<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "{{%transaction}}".
 *
 * @property integer $id
 * @property integer $package_item_id
 * @property string $firstname
 * @property string $lastname
 * @property string $contact
 * @property integer $status
 * @property integer $quantity_of_guest
 * @property string $check_in
 * @property string $check_out
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $penalty_from_excess_hour
 * @property string $order_total
 * @property string $service_total
 * @property string $package_fee
 *
 * @property Order[] $orders
 * @property Service[] $services
 * @property User $createdBy
 * @property PackageItem $packageItem
 * @property User $updatedBy
 */
class Transaction extends \yii\db\ActiveRecord
{
    public $toggle_date_time;

    const STATUS_CHECK_IN = 5;
    const STATUS_CHECK_OUT = 10;

    const SCENARIO_CHECK_IN = 'check_in';
    const SCENARIO_CHECK_OUT = 'check_out';

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CHECK_OUT] = ['toggle_date_time', 'check_out'];
        $scenarios[self::SCENARIO_CHECK_IN] = ['package_item_id', 'quantity_of_guest', 'check_in', 'firstname', 'lastname', 'contact', 'toggle_date_time'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%transaction}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['package_item_id', 'firstname', 'lastname', 'contact', 'status', 'quantity_of_guest', 'check_in', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'required'],
            [['package_item_id', 'status', 'quantity_of_guest', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['check_out'], 'required', 'on' => self::SCENARIO_CHECK_OUT],
            [['check_out'], 'validateTransactionDate', 'on' => self::SCENARIO_CHECK_OUT],
            [['check_in'], 'date', 'format' => 'php:Y-m-d H:i:s', 'on' => self::SCENARIO_CHECK_OUT],
            [['penalty_from_excess_hour', 'order_total', 'service_total', 'package_fee'], 'number'],
            [['package_item_id'], 'checkVacancy'],
            [['check_in'], 'date', 'format' => 'php:Y-m-d H:i:s'],
            [['check_in'], 'validateTransactionDate'],
            [['toggle_date_time'], 'string', 'max' => 6],
            [['firstname', 'lastname'], 'string', 'max' => 25],
            [['contact'], 'string', 'max' => 50],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['package_item_id'], 'exist', 'skipOnError' => true, 'targetClass' => PackageItem::className(), 'targetAttribute' => ['package_item_id' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
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
            'status' => Yii::t('app', 'Status'),
            'quantity_of_guest' => Yii::t('app', '# Of Guest'),
            'check_in' => Yii::t('app', 'Check In'),
            'check_out' => Yii::t('app', 'Check Out'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'penalty_from_excess_hour' => Yii::t('app', 'Penalty From Excess Hour'),
            'order_total' => Yii::t('app', 'Order Total'),
            'service_total' => Yii::t('app', 'Service Total'),
            'package_fee' => Yii::t('app', 'Package Fee'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['transaction_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServices()
    {
        return $this->hasMany(Service::className(), ['transaction_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPackageItem()
    {
        return $this->hasOne(PackageItem::className(), ['id' => 'package_item_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => time(),
            ],
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
        ];
    }

    public function checkIn()
    {
        if ($this->isNewRecord) {
            if ($this->toggle_date_time === 'system') {
                $this->setAttribute('check_in', date('Y-m-d H:i:s'));
            } else if ($this->toggle_date_time === 'manual') {
                $this->setAttribute('check_in', date('Y-m-d H:i:s', (strtotime($this->check_in . ' Asia/Manila'))));
            }
            $this->setAttribute('status', self::STATUS_CHECK_IN);
            return $this->save();
        }
        return false;
    }

    public function checkOut()
    {
        $result = true;
        if ($this->toggle_date_time === 'system') {
            $this->setAttribute('check_out', date('Y-m-d H:i:s'));
        } else if ($this->toggle_date_time === 'manual') {
            $this->setAttribute('check_out', date('Y-m-d H:i:s', (strtotime($this->check_out . ' Asia/Manila'))));
        }

        $this->setAttribute('status', self::STATUS_CHECK_OUT);
        $this->_computeTotalAmount();

        if ($result = $result && $this->save()) {
            $this->refresh();
            $checkInPlusOneDay = date('Y-m-d', strtotime($this->check_in . ' +1 day'));
            $properCheckOutTime = $checkInPlusOneDay . ' 13:00:00';
            $checkOut = Yii::$app->formatter->asDateTime($this->check_out, 'php:Y-m-d H:i:s');
            echo $penaltyHour = floor((strtotime($checkOut) - strtotime($properCheckOutTime)) / 3600);
            $penalty = ($penaltyHour > 0) ? ($penaltyHour * $this->packageItem->penalty_per_excess_hour) : 0;
            
            $this->setAttribute('penalty_from_excess_hour', $penalty);
            $result = $result && $this->save();

            return $result;
        }
    }

    private function _computeTotalAmount()
    {
        $order = Order::find()->where(['transaction_id' => $this->id])->sum('total');
        $service = Service::find()->where(['transaction_id' => $this->id])->sum('total');

        $order = is_null($order) ? 0 : $order;
        $service = is_null($service) ? 0 : $service;
        $package = $this->packageItem->rate / 2;

        $this->setAttribute('order_total', $order);
        $this->setAttribute('service_total', $service);
        $this->setAttribute('package_fee', $package);
    }

    public function validateTransactionDate($attribute, $params)
    {
        $dateToCompare = $this->$attribute;
        $now = date('Y-m-d H:i:s');
        if (strtotime($dateToCompare) < strtotime($now)) {
            $this->addError($attribute, 'The date should not be set to earlier period.');
        }
    }

    public static function getStatusCount($status = null, $package_item_id = null)
    {
        $model = self::find();
        if ($status !== null) {
            $model->where(['status' => $status]);
        }
        if ($package_item_id !== null) {
            $model->andWhere(['package_item_id' => $package_item_id]);
        }
        return $model->count();
    }

    public static function getStatusLineGraph()
    {
        $data = [
            ['name' => '', 'data' => array_fill(0, 12, 0)],
        ];
        $transactions = Yii::$app->db->createCommand('SELECT status, MONTH(check_out) AS month, COUNT(*) AS count FROM {{%transaction}} WHERE YEAR(check_out) = :year AND status=:status GROUP BY status')
            ->bindValue(':year', date('Y'))
            ->bindValue(':status', self::STATUS_CHECK_OUT)
            ->queryAll();
        if (!empty($transactions)) {
            for ($i = 0; $i < count($transactions); $i++) {
                $months = array_fill(0, 12, 0.0);
                $months[($transactions[$i]['month'] - 1)] = (float)$transactions[$i]['count'];
                $data[$i] = [
                    'name' => 'Count',
                    'data' => $months,
                ];
            }
        }
        return $data;
    }

    public static function getStatusDropdownList($template = 'raw')
    {
        if ($template === 'raw') {
            $model = [
                self::STATUS_CHECK_IN => 'Check In',
                self::STATUS_CHECK_OUT => 'Check Out',
            ];
        } else if ($template === 'html') {
            $model = [
                self::STATUS_CHECK_IN => '<span class="label label-primary">Check In</span>',
                self::STATUS_CHECK_OUT => '<span class="label label-success">Check Out</span>',
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

    public function checkVacancy($attribute, $params)
    {
        if (PackageItem::getVacancyCount($this->$attribute) === 0) {
            $this->addError($attribute, 'There is no vacant room.');
        }
    }
}
