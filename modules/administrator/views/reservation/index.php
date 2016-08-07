<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

use app\models\Reservation;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ReservationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Reservations');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reservation-index">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?= Html::encode($this->title) ?></h1>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <?= $this->render('_search', [
                    'model' => $searchModel,
                    'packageItems' => $packageItems,
                    'status' => $status,
                ]); ?>
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
                            'attribute' => 'package_item_id',
                            'value' => 'packageItem.title',
                            'filter' => $packageItems,
                        ],
                        'firstname',
                        'lastname',
                        [
                            'attribute' => 'check_in',
                            'format' => 'date',
                            'hAlign' => GridView::ALIGN_CENTER,
                        ],
                        [
                            'attribute' => 'status',
                            'value' => function ($model, $key, $index, $column) {
                                return Reservation::getStatusValue($model->status);
                            },
                            'format' => 'html',
                            'hAlign' => GridView::ALIGN_CENTER,
                        ],
                        'id',

                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{view}',
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
                ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
