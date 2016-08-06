<?php

namespace app\models;

use Yii;

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
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property PackageItem $packageItem
 */
class Transaction extends \yii\db\ActiveRecord
{
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
            [['package_item_id', 'firstname', 'lastname', 'contact', 'email', 'status', 'quantity_of_guest', 'check_in', 'created_at', 'updated_at'], 'required'],
            [['package_item_id', 'status', 'quantity_of_guest', 'check_in', 'check_out', 'created_at', 'updated_at'], 'integer'],
            [['total_amount'], 'number'],
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
            'package_item_id' => Yii::t('app', 'Package Item ID'),
            'firstname' => Yii::t('app', 'Firstname'),
            'lastname' => Yii::t('app', 'Lastname'),
            'contact' => Yii::t('app', 'Contact'),
            'email' => Yii::t('app', 'Email'),
            'status' => Yii::t('app', 'Status'),
            'quantity_of_guest' => Yii::t('app', 'Quantity Of Guest'),
            'check_in' => Yii::t('app', 'Check In'),
            'check_out' => Yii::t('app', 'Check Out'),
            'total_amount' => Yii::t('app', 'Total Amount'),
            'address' => Yii::t('app', 'Address'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPackageItem()
    {
        return $this->hasOne(PackageItem::className(), ['id' => 'package_item_id']);
    }
}
