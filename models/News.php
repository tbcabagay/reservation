<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\SluggableBehavior;
use yii\helpers\BaseFileHelper;
use yii\imagine\Image;

/**
 * This is the model class for table "{{%news}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $content
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $slug
 * @property string $photo
 *
 * @property User $user
 */
class News extends \yii\db\ActiveRecord
{
    public $photo_file;

    const SCENARIO_ADD = 'add';
    const SCENARIO_EDIT = 'edit';
    const SCENARIO_UPLOAD_IMAGE = 'upload_image';

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_ADD] = ['title', 'content'];
        $scenarios[self::SCENARIO_EDIT] = ['title', 'content'];
        $scenarios[self::SCENARIO_UPLOAD_IMAGE] = ['photo', 'photo_file'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%news}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'title', 'content', 'created_at', 'updated_at', 'slug'], 'required'],
            [['user_id', 'created_at', 'updated_at'], 'integer'],
            [['content'], 'string'],
            [['title'], 'string', 'max' => 100],
            [['slug'], 'string', 'max' => 250],
            [['photo'], 'string', 'max' => 255],
            [['photo_file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, svg'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User'),
            'title' => Yii::t('app', 'Title'),
            'content' => Yii::t('app', 'Content'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'slug' => Yii::t('app', 'Slug'),
            'photo' => Yii::t('app', 'Photo'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->setAttribute('photo', 'http://placehold.it/1200x1200');
            $this->setAttribute('user_id', Yii::$app->user->identity->id);
        }
        return parent::beforeSave($insert);
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

    public function upload()
    {
        if ($this->validate()) {
            $this->deleteOldPhoto();

            $absolutePath = Yii::getAlias('@webroot') . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'media' . DIRECTORY_SEPARATOR . 'news' . DIRECTORY_SEPARATOR . $this->id;
            $relativePath = Yii::getAlias('@web') . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'media' . DIRECTORY_SEPARATOR . 'news' . DIRECTORY_SEPARATOR . $this->id;
            $fileName = $this->photo_file->baseName . '.' . $this->photo_file->extension;
            $this->photo = $relativePath . DIRECTORY_SEPARATOR . $fileName;
            if ($this->save()) {
                if (file_exists($absolutePath) === false) {
                    BaseFileHelper::createDirectory($absolutePath, 0755, true);
                }
                $absoluteImagePath = $absolutePath . DIRECTORY_SEPARATOR . $fileName;
                $this->photo_file->saveAs($absoluteImagePath);
                Image::thumbnail($absoluteImagePath, 240, 240)->save($absoluteImagePath, ['quality' => 100]);
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
