<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;
use yii\helpers\BaseFileHelper;
use yii\imagine\Image;

/**
 * This is the model class for table "{{%spa}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $amount
 * @property string $description
 * @property string $photo
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Service[] $services
 */
class Spa extends \yii\db\ActiveRecord
{
    public $photo_file;

    const SCENARIO_COMMAND = 'command';
    const SCENARIO_ADD = 'add';
    const SCENARIO_EDIT = 'edit';

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_COMMAND] = ['title', 'amount', 'description', 'photo'];
        $scenarios[self::SCENARIO_ADD] = ['title', 'amount', 'description', 'photo_file'];
        $scenarios[self::SCENARIO_EDIT] = ['title', 'amount', 'description', 'photo', 'photo_file'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%spa}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'amount', 'created_at', 'updated_at'], 'required'],
            [['amount'], 'number'],
            [['description'], 'string'],
            [['photo_file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, svg', 'on' => self::SCENARIO_ADD],
            [['photo_file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, svg', 'on' => self::SCENARIO_EDIT],
            [['created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 100],
            [['photo'], 'string', 'max' => 255],
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
            'description' => Yii::t('app', 'Description'),
            'photo' => Yii::t('app', 'Photo'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServices()
    {
        return $this->hasMany(Service::className(), ['spa_id' => 'id']);
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
        ];
    }

    public function add()
    {
        if ($this->validate()) {
            if ($this->photo_file !== null) {
                $this->deleteOldPhoto();
            }

            $absolutePath = Yii::getAlias('@webroot') . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'media' . DIRECTORY_SEPARATOR . 'spa';
            $relativePath = Yii::getAlias('@web') . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'media' . DIRECTORY_SEPARATOR . 'spa';
            if ($this->photo_file !== null) {
                $fileName = $this->photo_file->basename . '.' . $this->photo_file->extension;
                $this->photo = $relativePath . DIRECTORY_SEPARATOR . $fileName;
            }

            if ($this->save(false)) {
                if (file_exists($absolutePath) === false) {
                    BaseFileHelper::createDirectory($absolutePath, 0755, true);
                }
                if ($this->photo_file !== null) {
                    $absoluteImagePath = $absolutePath . DIRECTORY_SEPARATOR . $fileName;
                    $this->photo_file->saveAs($absoluteImagePath);
                    Image::thumbnail($absoluteImagePath, 360, 360)->save($absoluteImagePath, ['quality' => 100]);
                }
                return true;
            }
        }
        return false;
    }

    public function deleteOldPhoto()
    {
        if ((file_exists(Yii::getAlias('@webroot') . $this->photo)) && ($this->photo !== null)) {
            unlink(Yii::getAlias('@webroot') . $this->photo);
        }
    }
}
