<?php
namespace app\commands;

use Yii;
use yii\console\Controller;
use app\models\User;

class UserController extends Controller
{
    public function actionCreate($username, $email, $password, $role)
    {
        $model = new User();
        $model->scenario = User::SCENARIO_COMMAND;
        $model->username = $username;
        $model->email = $email;
        $model->password = $password;
        $model->role = $role;

        if ($model->save()) {
            $auth = Yii::$app->authManager;
            $role = $auth->getRole($model->role);
            $auth->assign($role, $model->getId());
            echo "User successfully created.\n";
        }
    }
}