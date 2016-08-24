<?php

namespace app\modules\administrator\controllers;

use Yii;
use app\models\Transaction;
use app\models\TransactionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use app\models\Reservation;
use app\models\PackageItem;

/**
 * TransactionController implements the CRUD actions for Transaction model.
 */
class TransactionController extends Controller
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
                        'roles' => ['@'],
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
     * Lists all Transaction models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TransactionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'packageItems' => PackageItem::getTitleDropdownList(),
        ]);
    }

    /**
     * Displays a single Transaction model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Transaction model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Transaction();
        $model->scenario = Transaction::SCENARIO_CHECK_IN;

        if ($model->load(Yii::$app->request->post()) && $model->checkIn()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'packageItems' => PackageItem::getTitleDropdownList(),
            ]);
        }
    }

    public function actionCheckIn($reservation_id = null)
    {
        $transaction = new Transaction();
        $transaction->scenario = Transaction::SCENARIO_CHECK_IN;
        $reservation = null;

        if (($reservation_id !== null) && ($reservation = Reservation::find()->where([
            'id' => $reservation_id, 'status' => Reservation::STATUS_CONFIRM
        ])->one()) !== null) {
            $transaction->setAttribute('package_item_id', $reservation->getAttribute('package_item_id'));
            $transaction->setAttribute('quantity_of_guest', $reservation->getAttribute('quantity_of_guest'));
            $transaction->setAttribute('firstname', $reservation->getAttribute('firstname'));
            $transaction->setAttribute('lastname', $reservation->getAttribute('lastname'));
            $transaction->setAttribute('contact', $reservation->getAttribute('contact'));
        }

        if ($transaction->load(Yii::$app->request->post()) && $transaction->checkIn()) {
            if ($reservation !== null) {
                $reservation->changeStatus(Reservation::STATUS_DONE);
            }
            return $this->redirect(['index']);
        } else {
            return $this->render('check-in', [
                'transaction' => $transaction,
                'reservation' => $reservation,
                'packageItems' => PackageItem::getTitleDropdownList(),
            ]);
        }
    }

    public function actionCheckOut($id)
    {
        $model = $this->findModel($id);
        $model->scenario = Transaction::SCENARIO_CHECK_OUT;

        if ($model->load(Yii::$app->request->post()) && $model->checkOut()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->renderAjax('check-out', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Transaction model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Transaction model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Transaction the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Transaction::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
