<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%menu_package}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $amount
 * @property string $unit
 * @property integer $status
 *
 * @property MenuItem[] $menuItems
 * @property Order[] $orders
 */
class MenuPackage extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 5;
    const STATUS_DELETE = 10;

    const SCENARIO_ADD = 'add';
    const SCENARIO_TOGGLE_STATUS = 'toggle_status';

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_ADD] = ['title', 'amount', 'unit'];
        $scenarios[self::SCENARIO_TOGGLE_STATUS] = ['status'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%menu_package}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'amount', 'unit', 'status'], 'required'],
            [['amount'], 'number'],
            [['status'], 'integer'],
            [['title'], 'string', 'max' => 50],
            [['unit'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'amount' => Yii::t('app', 'Amount'),
            'unit' => Yii::t('app', 'Unit'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenuItems()
    {
        return $this->hasMany(MenuItem::className(), ['menu_package_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['menu_package_id' => 'id']);
    }

    public static function getTitleDropdownList()
    {
        $model = self::find()->asArray()->all();
        if (!empty($model)) {
            return ArrayHelper::map($model, 'id', 'title');
        } else {
            return [];
        }
    }

    public static function getRadioList()
    {
        $model = self::find()->asArray()->all();
        if (!empty($model)) {
            return ArrayHelper::map($model,
                'id',
                function($model, $defaultValue) {
                    return '<strong>' . $model['title'] . '</strong>' . ' (' . Yii::$app->formatter->asCurrency($model['amount']) . ')';
                });
        } else {
            return [];
        }
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->setAttribute('status', self::STATUS_ACTIVE);
        }
        return parent::beforeSave($insert);
    }
}
