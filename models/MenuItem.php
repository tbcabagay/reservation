<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%menu_item}}".
 *
 * @property integer $id
 * @property integer $menu_package_id
 * @property integer $menu_category_id
 * @property string $title
 * @property string $description
 * @property string $photo
 * @property integer $status
 *
 * @property MenuCategory $menuCategory
 * @property MenuPackage $menuPackage
 */
class MenuItem extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 5;
    const STATUS_DELETE = 10;

    const SCENARIO_ADD = 'add';
    const SCENARIO_TOGGLE_STATUS = 'toggle_status';

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_ADD] = ['menu_category_id', 'menu_package_id', 'title', 'description'];
        $scenarios[self::SCENARIO_TOGGLE_STATUS] = ['status'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%menu_item}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['menu_package_id', 'menu_category_id', 'title', 'status'], 'required'],
            [['menu_package_id', 'menu_category_id', 'status'], 'integer'],
            [['title'], 'string', 'max' => 30],
            [['description'], 'string', 'max' => 50],
            [['photo'], 'string', 'max' => 255],
            [['menu_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => MenuCategory::className(), 'targetAttribute' => ['menu_category_id' => 'id']],
            [['menu_package_id'], 'exist', 'skipOnError' => true, 'targetClass' => MenuPackage::className(), 'targetAttribute' => ['menu_package_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'menu_package_id' => Yii::t('app', 'Package'),
            'menu_category_id' => Yii::t('app', 'Category'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'photo' => Yii::t('app', 'Photo'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenuCategory()
    {
        return $this->hasOne(MenuCategory::className(), ['id' => 'menu_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenuPackage()
    {
        return $this->hasOne(MenuPackage::className(), ['id' => 'menu_package_id']);
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->setAttribute('status', self::STATUS_ACTIVE);
        }
        return parent::beforeSave($insert);
    }
}
