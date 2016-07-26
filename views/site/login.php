<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use kartik\form\ActiveForm;

$this->title = 'Login';
?>
<div class="site-login">
    <div class="login-panel panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Please Sign In</h3>
        </div>
        <div class="panel-body">
            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'formConfig' => [
                    'showLabels' => false,
                    'autoPlaceholder' => true,
                ],
            ]); ?>

                <?= $form->field($model, 'username', [
                    'feedbackIcon' => [
                        'prefix' => 'fa fa-',
                        'default' => 'user',
                        'success' => 'user-plus',
                        'error' => 'user-times',
                    ],
                ])->textInput(['autofocus' => true, 'placeholder' => 'Username']) ?>

                <?= $form->field($model, 'password', [
                    'feedbackIcon' => [
                        'prefix' => 'fa fa-',
                        'default' => 'lock',
                        'success' => 'check',
                        'error' => 'exclamation',
                    ],
                ])->passwordInput(['placeholder' => 'Password']) ?>

                <div class="form-group">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
