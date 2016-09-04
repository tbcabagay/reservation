<?php

namespace app\modules\administrator\controllers;

use Yii;
use app\models\Order;
use app\models\OrderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use app\models\Transaction;
use app\models\MenuPackage;
use yii\web\Response;
use kartik\form\ActiveForm;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller
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
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($transaction_id)
    {
        if (Yii::$app->request->isAjax) {
            if (($transaction = Transaction::findOne($transaction_id)) === null) {
                throw new NotFoundHttpException('The requested page does not exist.');
            } else {
                $order = new Order();
                $order->scenario = Order::SCENARIO_TRANSACTION_ORDER;

                if ($order->load(Yii::$app->request->post())) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    if ($order->add()) {
                        return [
                            'success' => true,
                            'message' => 'The order has been successfully placed. The total amount is ' . Yii::$app->formatter->asCurrency($order->total) . '.',
                        ];
                    } else {
                        return [
                            'success' => false,
                            'message' => 'Something nasty happened!',
                        ];
                    }
                } else {
                    return $this->renderAjax('create', [
                        'order' => $order,
                        'transaction' => $transaction,
                        'menuPackage' => MenuPackage::getRadioList(),
                    ]);
                }
            }
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionAjaxValidate()
    {
        $model = new Order();
        $model->scenario = Order::SCENARIO_TRANSACTION_ORDER;
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
    }

    /**
     * Deletes an existing Order model.
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
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
