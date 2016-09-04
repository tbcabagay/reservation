<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%menu_category}}".
 *
 * @property integer $id
 * @property string $category
 * @property integer $status
 *
 * @property MenuItem[] $menuItems
 */
class MenuCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%menu_category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category', 'status'], 'required'],
            [['status'], 'integer'],
            [['category'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'category' => Yii::t('app', 'Category'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenuItems()
    {
        return $this->hasMany(MenuItem::className(), ['menu_category_id' => 'id']);
    }

    public static function getCategoryDropdownList()
    {
        $model = self::find()->asArray()->all();
        if (!empty($model)) {
            return ArrayHelper::map($model, 'id', 'category');
        } else {
            return [];
        }
    }
}
