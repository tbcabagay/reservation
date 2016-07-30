<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\markdown\MarkdownEditor;
use kartik\widgets\TouchSpin;
use pendalf89\filemanager\widgets\FileInput;

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

                        <?= $form->field($model, 'content')->widget(MarkdownEditor::classname(), [
                            'height' => 300,
                        ]) ?>

                        <?= $form->field($model, 'file_identifier')->widget(FileInput::className(), [
                            'name' => 'mediafile',
                            'buttonTag' => 'button',
                            'buttonName' => 'Browse',
                            'buttonOptions' => ['class' => 'btn btn-default'],
                            'options' => ['class' => 'form-control'],
                            // Widget template
                            'template' => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                            // Optional, if set, only this image can be selected by user
                            'thumb' => 'original',
                            // Optional, if set, in container will be inserted selected image
                            'imageContainer' => '.img',
                            // Default to FileInput::DATA_IDL. This data will be inserted in input field
                            'pasteData' => FileInput::DATA_ID,
                        ]) ?>

                        <div class="form-group">
                            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                        </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>

</div>
