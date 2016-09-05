<?php

namespace app\modules\administrator\controllers;

use Yii;
use app\models\PackageItem;
use app\models\PackageItemSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use app\models\Package;
use yii\web\UploadedFile;
use yii\web\Response;

/**
 * PackageItemController implements the CRUD actions for PackageItem model.
 */
class PackageItemController extends Controller
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
     * Lists all PackageItem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PackageItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'packages' => Package::getTitleDropdownList(),
        ]);
    }

    /**
     * Displays a single News model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PackageItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PackageItem();
        $model->scenario = PackageItem::SCENARIO_ADD;

        if ($model->load(Yii::$app->request->post())) {
            $model->thumbnail_file = UploadedFile::getInstance($model, 'thumbnail_file');
            if ($model->add()) {
                return $this->redirect(['index']);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'packages' => Package::getTitleDropdownList(),
            ]);
        }
    }

    /**
     * Updates an existing PackageItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = PackageItem::SCENARIO_EDIT;

        if ($model->load(Yii::$app->request->post())) {
            $model->thumbnail_file = UploadedFile::getInstance($model, 'thumbnail_file');
            if ($model->add()) {
                return $this->redirect(['index']);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'packages' => Package::getTitleDropdownList(),
            ]);
        }
    }

    /**
     * Deletes an existing PackageItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->scenario = PackageItem::SCENARIO_TOGGLE_STATUS;
        $model->setAttribute('status', PackageItem::STATUS_DELETE);
        $model->save();

        return $this->redirect(['index']);
    }

    /*public function actionUploadThumbnail($id)
    {
        $model = $this->findModel($id);
        $model->scenario = PackageItem::SCENARIO_UPLOAD_THUMBNAIL;

        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $model->thumbnail_file = UploadedFile::getInstance($model, 'thumbnail_file');
            if ($model->uploadThumbnail()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('upload-thumbnail', [
                'model' => $model,
            ]);
        }
    }*/

    /**
     * Finds the PackageItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PackageItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PackageItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
