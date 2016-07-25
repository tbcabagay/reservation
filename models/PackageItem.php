<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%package_item}}".
 *
 * @property integer $id
 * @property integer $package_id
 * @property string $title
 * @property string $content
 * @property integer $quantity
 * @property string $rate
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Package $package
 */
class PackageItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%package_item}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['package_id', 'title', 'content', 'quantity', 'rate', 'created_at', 'updated_at'], 'required'],
            [['package_id', 'quantity', 'created_at', 'updated_at'], 'integer'],
            [['content'], 'string'],
            [['rate'], 'number'],
            [['title'], 'string', 'max' => 100],
            [['package_id'], 'exist', 'skipOnError' => true, 'targetClass' => Package::className(), 'targetAttribute' => ['package_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'package_id' => Yii::t('app', 'Package ID'),
            'title' => Yii::t('app', 'Title'),
            'content' => Yii::t('app', 'Content'),
            'quantity' => Yii::t('app', 'Quantity'),
            'rate' => Yii::t('app', 'Rate'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPackage()
    {
        return $this->hasOne(Package::className(), ['id' => 'package_id']);
    }
}
