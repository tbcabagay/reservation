<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%hits}}".
 *
 * @property integer $hit_id
 * @property string $user_agent
 * @property string $ip
 * @property string $target_group
 * @property string $target_pk
 * @property integer $created_at
 */
class Hits extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%hits}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_agent', 'ip', 'target_group', 'target_pk', 'created_at'], 'required'],
            [['created_at'], 'integer'],
            [['user_agent', 'ip', 'target_group', 'target_pk'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'hit_id' => Yii::t('app', 'Hit ID'),
            'user_agent' => Yii::t('app', 'User Agent'),
            'ip' => Yii::t('app', 'Ip'),
            'target_group' => Yii::t('app', 'Target Group'),
            'target_pk' => Yii::t('app', 'Target Pk'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }
}
