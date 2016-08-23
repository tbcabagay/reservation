<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\markdown\MarkdownEditor;
use kartik\widgets\TouchSpin;

/* @var $this yii\web\View */
/* @var $model app\models\PackageItem */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="package-item-form">

    <div class="row">
        <div class="col-lg-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Form</h3>
                </div>
                <div class="panel-body">
                    <?php $form = ActiveForm::begin(); ?>

                        <?= $form->field($model, 'package_id')->dropdownList($packages, ['prompt' => '- Select -']) ?>

                        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'quantity')->widget(TouchSpin::classname(), [
                            'pluginOptions' => [
                                'min' => 1,
                            ],
                        ]) ?>

                        <?= $form->field($model, 'rate', [
                            'addon' => [
                                'prepend' => ['content' => 'PHP'],
                            ],
                        ])->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'max_person_per_room')->widget(TouchSpin::classname(), [
                            'pluginOptions' => [
                                'min' => 1,
                            ],
                        ]) ?>

                        <?= $form->field($model, 'discount_rate', [
                            'addon' => [
                                'append' => ['content' => '%'],
                            ],
                        ])->textInput() ?>

                        <?= $form->field($model, 'penalty_per_excess_person', [
                            'addon' => [
                                'append' => ['content' => 'per person'],
                                'prepend' => ['content' => 'PHP'],
                            ],
                        ])->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'penalty_per_excess_hour', [
                            'addon' => [
                                'append' => ['content' => 'per hour'],
                                'prepend' => ['content' => 'PHP'],
                            ],
                        ])->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'content')->widget(MarkdownEditor::classname(), [
                            'height' => 300,
                        ]) ?>

                        <?= $form->field($model, 'thumbnail_file')->fileInput() ?>

                        <div class="form-group">
                            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                        </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>

</div>
