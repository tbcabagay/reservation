<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use yii\base\UserException;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property string $password_hash
 * @property string $auth_key
 * @property string $registration_ip
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property News[] $news
 * @property Order[] $orders
 * @property Order[] $orders0
 * @property Service[] $services
 * @property Service[] $services0
 * @property Transaction[] $transactions
 * @property Transaction[] $transactions0
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public $password;
    public $confirm_password;
    public $role;

    const SCENARIO_REGISTER = 'register';
    const SCENARIO_COMMAND = 'command';
    const SCENARIO_LOGIN = 'login';
    const SCENARIO_TOGGLE_STATUS = 'toggle_status';

    const STATUS_ACTIVE = 10;
    const STATUS_INACTIVE = 15;
    const STATUS_DELETE = 20;

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_LOGIN] = ['username', 'password'];
        $scenarios[self::SCENARIO_COMMAND] = ['username', 'email', 'password', 'role'];
        $scenarios[self::SCENARIO_REGISTER] = ['username', 'email', 'password', 'confirm_password', 'role'];
        $scenarios[self::SCENARIO_TOGGLE_STATUS] = ['status'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email', 'password_hash', 'auth_key', 'registration_ip', 'status', 'created_at', 'updated_at', 'password', 'confirm_password', 'role'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['confirm_password'], 'compare', 'compareAttribute' => 'password', 'message' => "Passwords don't match" ],
            [['email'], 'email'],
            [['username', 'email'], 'unique'],
            [['username'], 'string', 'max' => 25],
            [['email'], 'string', 'max' => 255],
            [['password_hash', 'password', 'confirm_password'], 'string', 'max' => 60],
            [['auth_key'], 'string', 'max' => 32],
            [['registration_ip'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'email' => Yii::t('app', 'Email'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'registration_ip' => Yii::t('app', 'Registration IP'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'Password' => Yii::t('app', 'Password'),
            'Confirm Password' => Yii::t('app', 'Confirm Password'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNews()
    {
        return $this->hasMany(News::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders0()
    {
        return $this->hasMany(Order::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServices()
    {
        return $this->hasMany(Service::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServices0()
    {
        return $this->hasMany(Service::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransactions()
    {
        return $this->hasMany(Transaction::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransactions0()
    {
        return $this->hasMany(Transaction::className(), ['updated_by' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password_hash);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $model = self::find()->where([
            'username' => $username,
            'status' => self::STATUS_ACTIVE,
        ])->one();
        return $model;
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
        ];
    }

    public function getRoleDropdownList()
    {
        $auth = Yii::$app->authManager;
        $roles = $auth->getRoles();
        return ArrayHelper::map($roles, 'name', 'name');
    }

    public function getStatusDropdownList()
    {
        return [
            self::STATUS_ACTIVE => 'STATUS_ACTIVE',
            self::STATUS_INACTIVE => 'STATUS_INACTIVE',
            self::STATUS_DELETE => 'STATUS_DELETE',
        ];
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            if ($this->role === 'administrator') {
                $roles = $this->findByRole('administrator');
                if (!empty($roles)) {
                    throw new UserException('Administrator account already exists.');
                }
            }

            $this->setAttribute('auth_key', \Yii::$app->security->generateRandomString());
            $this->setAttribute('status', self::STATUS_ACTIVE);
            if (\Yii::$app instanceof WebApplication) {
                $this->setAttribute('registration_ip', \Yii::$app->request->userIP);
            }
        }
        if (!empty($this->password)) {
            $this->setAttribute('password_hash', Yii::$app->getSecurity()->generatePasswordHash($this->password));
        }
        return parent::beforeSave($insert);
    }

    public function findByRole($role)
    {
        return self::find()
            ->join('LEFT JOIN','{{%auth_assignment}}', '{{%auth_assignment}}.user_id = id')
            ->where(['{{%auth_assignment}}.item_name' => $role])
            ->all();
    }

}
