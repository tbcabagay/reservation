<?php
namespace app\commands;

use Yii;
use yii\console\Controller;
use app\models\User;

class UserController extends Controller
{
    public function actionCreateAdministrator($username, $email, $password, $role)
    {
        $model = new User();
        $model->scenario = User::SCENARIO_COMMAND;
        $model->username = $username;
        $model->email = $email;
        $model->password = $password;
        $model->role = $role;

        if ($model->save()) {
            echo "User successfully created.\n";
        }
    }
}