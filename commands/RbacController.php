<?php
namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        $receptionist = $auth->createRole('receptionist');
        $auth->add($receptionist);

        $cashier = $auth->createRole('cashier');
        $auth->add($cashier);


        $manager = $auth->createRole('manager');
        $auth->add($manager);

        $administrator = $auth->createRole('administrator');
        $auth->add($administrator);
        $auth->addChild($administrator, $manager);
        $auth->addChild($administrator, $cashier);
        $auth->addChild($administrator, $receptionist);
    }
}