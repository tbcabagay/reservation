<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\News */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t('app', 'Upload Gallery');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Package Items'), 'url' => ['package-item/index']];
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

                        <?= $form->field($model, 'gallery_file[]')->widget(FileInput::classname(), [
                            'options' => ['multiple' => true, 'accept' => 'image/*'],
                            'pluginOptions' => [
                                'uploadUrl' => Url::to(['upload-gallery', 'package_item_id' => $model->id]),
                            ],
                        ]) ?>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <?php Pjax::begin(); ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        [
                            'attribute' => 'thumbnail',
                            'value' => function($model, $key, $index, $column) {
                                return Html::img($model->thumbnail);
                            },
                            'format' => 'raw',
                        ],
                        'id',

                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{delete}',
                            'buttons' => [
                                'delete' => function ($url, $model, $key) {
                                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->id, 'package_item_id' => $model->package_item_id],
                                        [
                                            'title' => 'Delete', 'aria-label' => 'Delete',
                                            'data' => [
                                                'pjax' => 0,
                                                'method' => 'post',
                                                'confirm' => 'Are you sure you want to delete this item?',
                                            ],
                                        ]);
                                },
                            ],
                        ],
                    ],
                    'panel'=>[
                        'type' => GridView::TYPE_DEFAULT,
                        'heading' => 'Grid',
                    ],
                    'toolbar' => [
                        [
                            'content' =>
                            Html::a('<i class="fa fa-repeat"></i>', ['index'], [
                                'class' => 'btn btn-default', 
                                'title' => Yii::t('app', 'Reset Grid'),
                                'data-pjax' => 0,
                            ]),
                        ],
                        '{toggleData}',
                    ],
                    'hover' => true,
                ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>

</div>
