<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%package_item_gallery}}".
 *
 * @property integer $id
 * @property integer $package_item_id
 * @property string $thumbnail
 * @property string $photo
 *
 * @property PackageItem $packageItem
 */
class PackageItemGallery extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%package_item_gallery}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['package_item_id', 'thumbnail', 'photo'], 'required'],
            [['package_item_id'], 'integer'],
            [['thumbnail', 'photo'], 'string', 'max' => 255],
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
            'thumbnail' => Yii::t('app', 'Thumbnail'),
            'photo' => Yii::t('app', 'Photo'),
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
