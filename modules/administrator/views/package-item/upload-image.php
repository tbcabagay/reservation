<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\News */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t('app', 'Upload Image');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Package Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="news-image">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?= Html::encode($this->title) ?></h1>
            <p class="lead"><?= Html::encode($model->package->title) ?> / <span class="text-muted"><?= Html::encode($model->title) ?></span></p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Form</h3>
                </div>
                <div class="panel-body">
                    <?php $form = ActiveForm::begin([
                        'options' => ['enctype' => 'multipart/form-data']
                    ]); ?>

                        <?= $form->field($model, 'photo_file')->widget(FileInput::classname(), [
                            'options' => ['accept' => 'image/*'],
                            'pluginOptions' => [
                                'uploadUrl' => Url::to(['upload-image', 'id' => $model->id]),
                            ],
                        ]) ?>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>

</div>
