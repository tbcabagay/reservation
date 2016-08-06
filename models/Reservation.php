<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

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

    const STATUS_NEW = 5;
    const STATUS_CHECK_IN = 10;
    const STATUS_CANCEL = 50;

    const SCENARIO_NEW = 'new';
    const SCENARIO_CANCEL = 'cancel';

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CANCEL] = ['status'];
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
            [['check_in'], 'safe'],
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

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->setAttribute('status', self::STATUS_NEW);
        }
        return parent::beforeSave($insert);
    }

    public function placeReservation($packageItem)
    {
        $this->package_item_id = $packageItem->id;
        return $this->save();
    }

    public function cancel()
    {
        $this->setAttribute('status', self::STATUS_CANCEL);
        $this->save();
    }
}
