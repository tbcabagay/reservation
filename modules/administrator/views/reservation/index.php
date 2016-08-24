<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

use app\models\Reservation;
use yii\bootstrap\Modal;
use yii\helpers\Url;

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
                        ],
                        'id',

                        /*[
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{view}',
                        ],*/
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
                    'rowOptions' => function ($model, $key, $index, $grid) {
                        return ['data-id' => $model->id];
                    },
                ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>

<?php
    Modal::begin([
        'header' => '<h4>Reservation Window</h4>',
        'id' => 'modal-reservation',
        'size' => Modal::SIZE_LARGE,
    ]);
    echo '<div id="modal-reservation-content"></div>';
    Modal::end ();
?>

<?php
$this->registerJs('
    (function($) {
        $("td").click(function (e) {
            var id = $(this).closest("tr").data("id");
            if (e.target == this) {
                var url = "' . Url::to(['view']) . '?id=" + id;
                $("#modal-reservation").modal("show")
                    .find("#modal-reservation-content")
                    .load(url);
            }
        });/*
        $("#reservation-search-form").change(function() {
            $(this).submit();
        });*/
    })(jQuery);
');
?>
