<?php

namespace app\modules\administrator\controllers;

use Yii;
use app\models\Reservation;
use app\models\ReservationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

use app\models\PackageItem;

/**
 * ReservationController implements the CRUD actions for Reservation model.
 */
class ReservationController extends Controller
{
    /**
     * Lists all Reservation models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ReservationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'packageItems' => PackageItem::getTitleDropdownList(),
        ]);
    }

    /**
     * Displays a single Reservation model.
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
     * Finds the Reservation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Reservation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Reservation::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
