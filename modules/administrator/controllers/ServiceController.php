<?php

namespace app\modules\administrator\controllers;

use Yii;
use app\models\Service;
use app\models\ServiceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\Transaction;
use app\models\Spa;
use yii\web\Response;
use kartik\form\ActiveForm;

/**
 * ServiceController implements the CRUD actions for Service model.
 */
class ServiceController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Service models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ServiceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Service model.
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
     * Creates a new Service model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($transaction_id)
    {
        if (Yii::$app->request->isAjax) {
            if (($transaction = Transaction::findOne($transaction_id)) === null) {
                throw new NotFoundHttpException('The requested page does not exist.');
            } else {
                $service = new Service();
                $service->scenario = Service::SCENARIO_TRANSACTION_SERVICE;

                if ($service->load(Yii::$app->request->post())) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    if ($service->add()) {
                        return [
                            'success' => true,
                            'message' => 'The order has been successfully placed. The total amount is ' . Yii::$app->formatter->asCurrency($service->total) . '.',
                        ];
                    } else {
                        return [
                            'success' => false,
                            'message' => 'Something nasty happened!',
                        ];
                    }
                } else {
                    return $this->renderAjax('create', [
                        'service' => $service,
                        'transaction' => $transaction,
                        'spa' => Spa::getRadioList(),
                    ]);
                }
            }
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionAjaxValidate()
    {
        $model = new Service();
        $model->scenario = Service::SCENARIO_TRANSACTION_SERVICE;
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
    }

    /**
     * Updates an existing Service model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Service model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id, $transaction_id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['transaction/view', 'id' => $transaction_id]);
    }

    /**
     * Finds the Service model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Service the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Service::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
