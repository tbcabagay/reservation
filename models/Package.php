<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\SluggableBehavior;

/**
 * This is the model class for table "{{%package}}".
 *
 * @property integer $id
 * @property string $title
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $slug
 * @property string $agreement
 * @property integer $status
 *
 * @property PackageItem[] $packageItems
 */
class Package extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 5;
    const STATUS_DELETE = 10;

    const SCENARIO_TOGGLE_STATUS = 'status';

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_TOGGLE_STATUS] = ['status'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%package}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'created_at', 'updated_at', 'slug', 'agreement', 'status'], 'required'],
            [['created_at', 'updated_at', 'status'], 'integer'],
            [['agreement'], 'string'],
            [['title'], 'string', 'max' => 100],
            [['slug'], 'string', 'max' => 250],
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
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'slug' => Yii::t('app', 'Slug'),
            'agreement' => Yii::t('app', 'Agreement'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPackageItems()
    {
        return $this->hasMany(PackageItem::className(), ['package_id' => 'id']);
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
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
                'immutable' => true,
                'ensureUnique' => true,
            ],
        ];
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

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->setAttribute('title', ucwords(strtolower($this->title)));
                $this->setAttribute('status', self::STATUS_ACTIVE);
            }
            return true;
        }
        return false;
    }
}
