<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "{{%service}}".
 *
 * @property integer $id
 * @property integer $transaction_id
 * @property integer $spa_id
 * @property integer $quantity
 * @property string $amount
 * @property string $total
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $updatedBy
 * @property User $createdBy
 * @property Spa $spa
 * @property Transaction $transaction
 */
class Service extends \yii\db\ActiveRecord
{
    const SCENARIO_TRANSACTION_SERVICE = 'transaction_service';

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_TRANSACTION_SERVICE] = ['spa_id', 'quantity'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%service}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['transaction_id', 'spa_id', 'quantity', 'amount', 'total', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'required'],
            [['transaction_id', 'spa_id', 'quantity', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['amount', 'total'], 'number'],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['spa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Spa::className(), 'targetAttribute' => ['spa_id' => 'id']],
            [['transaction_id'], 'exist', 'skipOnError' => true, 'targetClass' => Transaction::className(), 'targetAttribute' => ['transaction_id' => 'id']],
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
            'spa_id' => Yii::t('app', 'Spa Service'),
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
    public function getSpa()
    {
        return $this->hasOne(Spa::className(), ['id' => 'spa_id']);
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

            $spa = Spa::findOne($this->spa_id);
            if ($spa === null) {
                return false;
            } else {
                $this->amount = $spa->amount;
                $this->total = $this->quantity * $this->amount;
                return $this->save();
            }
        }
        return false;
    }
}
