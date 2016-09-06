<?php

namespace app\modules\administrator\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;

/**
 * Default controller for the `administrator` module
 */
class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['manager'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        \app\models\Reservation::getStatusColumnGraph();
        return $this->render('index');
    }
}
