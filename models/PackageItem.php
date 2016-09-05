<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\SluggableBehavior;
use yii\helpers\ArrayHelper;
use yii\helpers\BaseFileHelper;
use yii\imagine\Image;

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
 * @property string $photo
 * @property integer $max_person_per_room
 * @property double $discount_rate
 * @property string $penalty_per_excess_person
 * @property string $penalty_per_excess_hour
 * @property integer $status
 *
 * @property Package $package
 * @property PackageItemGallery[] $packageItemGalleries
 * @property Reservation[] $reservations
 * @property Transaction[] $transactions
 */
class PackageItem extends \yii\db\ActiveRecord
{
    public $thumbnail_file;
    public $gallery_file;

    const STATUS_ACTIVE = 5;
    const STATUS_DELETE = 10;

    const SCENARIO_ADD = 'add';
    const SCENARIO_EDIT = 'edit';
    const SCENARIO_UPLOAD_THUMBNAIL = 'upload_thumbnail';
    const SCENARIO_UPLOAD_GALLERY = 'upload_gallery';
    const SCENARIO_COMMAND = 'command';
    const SCENARIO_TOGGLE_STATUS = 'toggle_status';

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_ADD] = ['package_id', 'title', 'content', 'quantity', 'rate', 'max_person_per_room', 'discount_rate', 'penalty_per_excess_person', 'penalty_per_excess_hour', 'photo', 'thumbnail_file'];
        $scenarios[self::SCENARIO_EDIT] = ['package_id', 'title', 'content', 'quantity', 'rate', 'max_person_per_room', 'discount_rate', 'penalty_per_excess_person', 'penalty_per_excess_hour', 'photo', 'thumbnail_file'];
        $scenarios[self::SCENARIO_UPLOAD_THUMBNAIL] = ['photo', 'thumbnail_file'];
        $scenarios[self::SCENARIO_UPLOAD_GALLERY] = ['photo', 'gallery_file'];
        $scenarios[self::SCENARIO_COMMAND] = ['package_id', 'title', 'content', 'quantity', 'rate', 'max_person_per_room', 'discount_rate', 'penalty_per_excess_person', 'penalty_per_excess_hour', 'photo'];
        $scenarios[self::SCENARIO_TOGGLE_STATUS] = ['status'];
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
            [['package_id', 'title', 'content', 'quantity', 'rate', 'created_at', 'updated_at', 'slug', 'max_person_per_room', 'discount_rate', 'penalty_per_excess_person', 'penalty_per_excess_hour', 'status'], 'required'],
            [['package_id', 'quantity', 'created_at', 'updated_at', 'max_person_per_room', 'status'], 'integer'],
            [['content'], 'string'],
            [['rate', 'discount_rate', 'penalty_per_excess_person', 'penalty_per_excess_hour'], 'number'],
            [['title'], 'string', 'max' => 100],
            [['slug'], 'string', 'max' => 250],
            [['photo'], 'string', 'max' => 255],
            [['thumbnail_file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, svg', 'on' => self::SCENARIO_ADD],
            [['thumbnail_file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, svg', 'on' => self::SCENARIO_EDIT],
            [['gallery_file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, svg', 'maxFiles' => 50],
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
            'photo' => Yii::t('app', 'Photo'),
            'max_person_per_room' => Yii::t('app', 'Max Person Per Room'),
            'discount_rate' => Yii::t('app', 'Discount Rate'),
            'penalty_per_excess_person' => Yii::t('app', 'Penalty Per Excess Person'),
            'penalty_per_excess_hour' => Yii::t('app', 'Penalty Per Excess Hour'),
            'status' => Yii::t('app', 'Status'),
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
    public function getPackageItemGalleries()
    {
        return $this->hasMany(PackageItemGallery::className(), ['package_item_id' => 'id']);
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

    public function add()
    {
        if ($this->validate()) {
            if ($this->thumbnail_file !== null) {
                $this->deleteOldPhoto();
            }

            $absolutePath = Yii::getAlias('@webroot') . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'media' . DIRECTORY_SEPARATOR . 'package_item' . DIRECTORY_SEPARATOR . 'thumbnail';
            $relativePath = Yii::getAlias('@web') . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'media' . DIRECTORY_SEPARATOR . 'package_item' . DIRECTORY_SEPARATOR . 'thumbnail';
            if ($this->thumbnail_file !== null) {
                $fileName = $this->thumbnail_file->basename . '.' . $this->thumbnail_file->extension;
                $this->photo = $relativePath . DIRECTORY_SEPARATOR . $fileName;
            }

            $this->setAttribute('status', self::STATUS_ACTIVE);

            if ($this->save(false)) {
                if (file_exists($absolutePath) === false) {
                    BaseFileHelper::createDirectory($absolutePath, 0755, true);
                }
                if ($this->thumbnail_file !== null) {
                    $absoluteImagePath = $absolutePath . DIRECTORY_SEPARATOR . $fileName;
                    $this->thumbnail_file->saveAs($absoluteImagePath);
                    Image::thumbnail($absoluteImagePath, 360, 360)->save($absoluteImagePath, ['quality' => 100]);
                }
                return true;
            }
        }
        return false;
    }

    public function uploadGallery()
    {
        if ($this->validate()) {
            $result = true;
            $absolutePath = Yii::getAlias('@webroot') . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'media' . DIRECTORY_SEPARATOR . 'package_item' . DIRECTORY_SEPARATOR . 'gallery' . DIRECTORY_SEPARATOR . $this->id;
            $relativePath = Yii::getAlias('@web') . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'media' . DIRECTORY_SEPARATOR . 'package_item' . DIRECTORY_SEPARATOR . 'gallery' . DIRECTORY_SEPARATOR . $this->id;
            $thumbnailAbsolutePath = Yii::getAlias('@webroot') . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'media' . DIRECTORY_SEPARATOR . 'package_item' . DIRECTORY_SEPARATOR . 'gallery' . DIRECTORY_SEPARATOR . $this->id . DIRECTORY_SEPARATOR . 'thumbnail';
            $thumbnailRelativePath = Yii::getAlias('@web') . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'media' . DIRECTORY_SEPARATOR . 'package_item' . DIRECTORY_SEPARATOR . 'gallery' . DIRECTORY_SEPARATOR . $this->id . DIRECTORY_SEPARATOR . 'thumbnail';
            if (file_exists($absolutePath) === false) {
                BaseFileHelper::createDirectory($absolutePath, 0755, true);
            }
            if (file_exists($thumbnailAbsolutePath) === false) {
                BaseFileHelper::createDirectory($thumbnailAbsolutePath, 0755, true);
            }
            foreach ($this->gallery_file as $image) {
                $fileName = $image->baseName . '.' . $image->extension;
                $photo = $relativePath . DIRECTORY_SEPARATOR . $fileName;
                $thumbnail = $thumbnailRelativePath . DIRECTORY_SEPARATOR . $fileName;

                $model = new PackageItemGallery([
                    'package_item_id' => $this->id,
                    'thumbnail' => $thumbnail,
                    'photo' => $photo,
                ]);
                if ($result = $model->save(false)) {
                    echo json_encode([]);
                    $absoluteImagePath = $absolutePath . DIRECTORY_SEPARATOR . $fileName;
                    $absoluteThumbnailPath = $thumbnailAbsolutePath . DIRECTORY_SEPARATOR . $fileName;
                    $image->saveAs($absoluteImagePath);
                    Image::thumbnail($absoluteImagePath, 120, 120)->save($absoluteThumbnailPath, ['quality' => 100]);
                }
            }
            return $result;
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
