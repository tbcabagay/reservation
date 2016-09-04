<?php

namespace app\modules\administrator\controllers;

use Yii;
use app\models\PackageItemGallery;
use app\models\PackageItemGallerySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use app\models\PackageItem;
use yii\web\UploadedFile;
use yii\web\Response;

/**
 * PackageItemGalleryController implements the CRUD actions for PackageItemGallery model.
 */
class PackageItemGalleryController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['administrator'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Deletes an existing PackageItemGallery model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id, $package_item_id)
    {
        $model = $this->findModel($id);
        $photoAbsolutePath = Yii::getAlias('@webroot') . DIRECTORY_SEPARATOR . $model->photo;
        $thumbnailAbsolutePath = Yii::getAlias('@webroot') . DIRECTORY_SEPARATOR . $model->thumbnail;
        if (file_exists($photoAbsolutePath) === true) {
            unlink($photoAbsolutePath);
        }
        if (file_exists($thumbnailAbsolutePath) === true) {
            unlink($thumbnailAbsolutePath);
        }
        $model->delete();

        return $this->redirect(['upload-gallery', 'package_item_id' => $package_item_id]);
    }

    public function actionUploadGallery($package_item_id)
    {
        $model = $this->findPackageItemModel($package_item_id);
        $model->scenario = PackageItem::SCENARIO_UPLOAD_GALLERY;
        $searchModel = new PackageItemGallerySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $model->gallery_file = UploadedFile::getInstances($model, 'gallery_file');
            if ($model->uploadGallery()) {
                return $this->redirect(['upload-gallery', 'package_item_id' => $model->id]);
            }
        } else {
            return $this->render('upload-gallery', [
                'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    /**
     * Finds the PackageItemGallery model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PackageItemGallery the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PackageItemGallery::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findPackageItemModel($id)
    {
        if (($model = PackageItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
