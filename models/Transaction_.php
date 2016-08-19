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
 * @property string $email
 * @property integer $status
 * @property integer $quantity_of_guest
 * @property integer $check_in
 * @property integer $check_out
 * @property string $total_amount
 * @property string $address
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $updatedBy
 * @property User $createdBy
 * @property PackageItem $packageItem
 */
class Transaction extends \yii\db\ActiveRecord
{
    const SCENARIO_CHECK_IN = 'check_in';

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CHECK_IN] = ['package_item_id', 'quantity_of_guest', 'check_in', 'firstname', 'lastname', 'contact', 'email', 'address'];
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
            [['package_item_id', 'firstname', 'lastname', 'contact', 'email', 'status', 'quantity_of_guest', 'check_in', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'required'],
            [['package_item_id', 'status', 'quantity_of_guest', /*'check_in', 'check_out',*/ 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['check_in', 'check_out'], 'safe'],
            [['total_amount'], 'number'],
            [['firstname', 'lastname'], 'string', 'max' => 25],
            [['contact'], 'string', 'max' => 50],
            [['email', 'address'], 'string', 'max' => 150],
            [['email'], 'email'],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
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
            'quantity_of_guest' => Yii::t('app', 'Quantity Of Guest'),
            'check_in' => Yii::t('app', 'Check In'),
            'check_out' => Yii::t('app', 'Check Out'),
            'total_amount' => Yii::t('app', 'Total Amount'),
            'address' => Yii::t('app', 'Address'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
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

    public function beforeSave($insert)
    {
        $this->setAttribute('check_in', strtotime($this->check_in));
        $this->setAttribute('check_out', strtotime($this->check_out));
        return parent::beforeSave($insert);
    }

    public function checkIn($reservation_id)
    {
        $transaction = self::getDb()->beginTransaction();
        try {
            $this->save();
            $reservation = Reservation::findOne($reservation_id)->checkIn();
            $transaction->commit();
            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            return false;
        }
    }
}
