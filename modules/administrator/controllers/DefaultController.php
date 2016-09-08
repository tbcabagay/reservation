<?php

namespace app\modules\administrator\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;

use app\models\PackageItem;

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
        return $this->render('index', [
            'packageItems' => PackageItem::find()->asArray()->all(),
        ]);
    }
}
