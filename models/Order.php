<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "{{%order}}".
 *
 * @property integer $id
 * @property integer $transaction_id
 * @property integer $menu_package_id
 * @property integer $quantity
 * @property string $amount
 * @property string $total
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $createdBy
 * @property MenuPackage $menuPackage
 * @property Transaction $transaction
 * @property User $updatedBy
 */
class Order extends \yii\db\ActiveRecord
{
    const SCENARIO_TRANSACTION_ORDER = 'transaction_order';

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_TRANSACTION_ORDER] = ['menu_package_id', 'quantity'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['transaction_id', 'menu_package_id', 'quantity', 'amount', 'total', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'required'],
            [['transaction_id', 'menu_package_id', 'quantity', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['amount', 'total'], 'number'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['menu_package_id'], 'exist', 'skipOnError' => true, 'targetClass' => MenuPackage::className(), 'targetAttribute' => ['menu_package_id' => 'id']],
            [['transaction_id'], 'exist', 'skipOnError' => true, 'targetClass' => Transaction::className(), 'targetAttribute' => ['transaction_id' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'transaction_id' => Yii::t('app', 'Transaction'),
            'menu_package_id' => Yii::t('app', 'Menu Package'),
            'quantity' => Yii::t('app', 'Quantity'),
            'amount' => Yii::t('app', 'Amount'),
            'total' => Yii::t('app', 'Total'),
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
    public function getMenuPackage()
    {
        return $this->hasOne(MenuPackage::className(), ['id' => 'menu_package_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransaction()
    {
        return $this->hasOne(Transaction::className(), ['id' => 'transaction_id']);
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

    public function add()
    {
        if ($this->isNewRecord) {
            $this->transaction_id = Yii::$app->request->get('transaction_id');

            $menuPackage = MenuPackage::findOne($this->menu_package_id);
            if ($menuPackage === null) {
                return false;
            } else {
                $this->amount = $menuPackage->amount;
                $this->total = $this->quantity * $this->amount;
            }

            return $this->save();
        }
        return false;
    }
}
