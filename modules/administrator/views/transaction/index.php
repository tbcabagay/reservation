<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\models\TransactionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Transactions');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaction-index">

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
                ]); ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <?php Pjax::begin(); ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    /*'filterModel' => $searchModel,*/
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        [
                            'attribute' => 'package_item_id',
                            'value' => 'packageItem.title',
                            'filter' => $packageItems,
                        ],
                        'firstname',
                        'lastname',
                        'status',
                        'check_in:datetime',
                        'check_out:datetime',
                        'total_amount',
                        'id',

                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{menu} {checkout}',
                            'buttons' => [
                                'menu' => function ($url, $model, $key) {
                                    return Html::a('<i class="fa fa-cutlery"></i>', ['order/create', 'transaction_id' => $model->id], ['title' => 'Menu', 'aria-label' => 'Menu', 'data-pjax' => 0, 'class' => 'transaction-gridview-button']);
                                },
                                'checkout' => function ($url, $model, $key) {
                                    return Html::a('<i class="fa fa-shopping-cart"></i>', ['check-out', 'id' => $model->id], ['title' => 'Check Out', 'aria-label' => 'Menu', 'data-pjax' => 0, 'class' => 'transaction-gridview-button']);
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
                            Html::a('<i class="fa fa-plus"></i>', ['create'], [
                                'title' => Yii::t('app', 'Add Transaction'), 
                                'class' => 'btn btn-success',
                                'data-pjax' => 0,
                            ]) . ' ' .
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
        'header' => '<h4>Transaction Window</h4>',
        'id' => 'modal-transaction',
        'size' => Modal::SIZE_LARGE,
    ]);
    echo '<div id="modal-transaction-content"></div>';
    Modal::end ();
?>

<?php
$this->registerJs('
(function($) {
    $(".transaction-gridview-button").click(function(e) {
        $("#modal-transaction").modal("show")
            .find("#modal-transaction-content")
            .load(this.href);
        e.preventDefault();
    });
})(jQuery);
');
?>