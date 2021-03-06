<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\markdown\MarkdownEditor;

/* @var $this yii\web\View */
/* @var $model app\models\Spa */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="spa-form">

    <div class="row">
        <div class="col-lg-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Form</h3>
                </div>
                <div class="panel-body">
                    <?php $form = ActiveForm::begin(
                        ['options' => ['enctype' => 'multipart/form-data']]
                    ); ?>

                        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'description')->textArea(['rows' => 5]) ?>

                        <?= $form->field($model, 'photo_file')->fileInput() ?>

                        <div class="form-group">
                            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                        </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>

</div>
