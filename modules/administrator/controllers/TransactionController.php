<?php

namespace app\modules\administrator\controllers;

use Yii;
use app\models\Transaction;
use app\models\TransactionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Transaction model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCheckIn($reservation_id)
    {
        if (($reservation = Reservation::find()->where([
            'id' => $reservation_id, 'status' => Reservation::STATUS_NEW
        ])->one()) === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        } else {
            $transaction = new Transaction();
            $transaction->scenario = Transaction::SCENARIO_CHECK_IN;
            $transaction->setAttribute('package_item_id', $reservation->getAttribute('package_item_id'));
            $transaction->setAttribute('quantity_of_guest', $reservation->getAttribute('quantity_of_guest'));
            $transaction->setAttribute('firstname', $reservation->getAttribute('firstname'));
            $transaction->setAttribute('lastname', $reservation->getAttribute('lastname'));
            $transaction->setAttribute('contact', $reservation->getAttribute('contact'));
            $transaction->setAttribute('email', $reservation->getAttribute('email'));
            $transaction->setAttribute('address', $reservation->getAttribute('address'));

            if ($transaction->load(Yii::$app->request->post()) && $transaction->checkIn($reservation_id)) {
                return $this->redirect(['index']);
            } else {
                return $this->render('check-in', [
                    'transaction' => $transaction,
                    'reservation' => $reservation,
                    'packageItems' => PackageItem::getTitleDropdownList(),
                ]);
            }
        }
    }

    /**
     * Updates an existing Transaction model.
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
