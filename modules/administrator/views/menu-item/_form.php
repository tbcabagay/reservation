<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MenuItem */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="menu-item-form">

    <div class="row">
        <div class="col-lg-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Form</h3>
                </div>
                <div class="panel-body">
                    <?php $form = ActiveForm::begin(); ?>

                        <?= $form->field($model, 'menu_package_id')->dropdownList($packages, ['prompt' => '- Select -']) ?>

                        <?= $form->field($model, 'menu_category_id')->dropdownList($categories, ['prompt' => '- Select -']) ?>

                        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

                        <?php // $form->field($model, 'photo')->textInput(['maxlength' => true]) ?>

                    <div class="form-group">
                        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>

</div>
