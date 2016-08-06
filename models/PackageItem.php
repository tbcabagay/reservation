<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\SluggableBehavior;
use yii\helpers\ArrayHelper;

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
 * @property string $slug
 *
 * @property Package $package
 * @property Reservation[] $reservations
 * @property Transaction[] $transactions
 */
class PackageItem extends \yii\db\ActiveRecord
{
    const SCENARIO_ADD = 'add';

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_ADD] = ['package_id', 'title', 'content', 'quantity', 'rate'];
        return $scenarios;
    }

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
            [['slug'], 'string', 'max' => 250],
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
            'package_id' => Yii::t('app', 'Package'),
            'title' => Yii::t('app', 'Title'),
            'content' => Yii::t('app', 'Content'),
            'quantity' => Yii::t('app', 'Quantity'),
            'rate' => Yii::t('app', 'Rate'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'slug' => Yii::t('app', 'Slug'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPackage()
    {
        return $this->hasOne(Package::className(), ['id' => 'package_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReservations()
    {
        return $this->hasMany(Reservation::className(), ['package_item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransactions()
    {
        return $this->hasMany(Transaction::className(), ['package_item_id' => 'id']);
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
}
