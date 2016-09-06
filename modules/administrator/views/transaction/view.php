<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use app\models\Transaction;

/* @var $this yii\web\View */
/* @var $model app\models\Transaction */

$this->title = Yii::t('app', 'Transaction #') . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Transactions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaction-view">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="col-lg-12">
            <p>
                <?= Html::a('<i class="fa fa-arrow-left"></i> Go Back', ['index'], ['class' => 'btn btn-primary']) ?>
                <?php if ($model->status === Transaction::STATUS_CHECK_IN): ?>
                <?= Html::a(' <i class="fa fa-shopping-cart"></i> Check Out', ['check-out', 'id' => $model->id], ['class' => 'btn btn-success check-out-button']) ?>
                <?php endif; ?>
                </p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'label' => 'Package',
                        'value' => $model->packageItem->title,
                    ],
                    [
                        'label' => 'Name',
                        'value' => $model->lastname . ', ' . $model->firstname,
                    ],
                    'contact',
                    'status',
                    [
                        'label' => '# of Guest',
                        'value' => $model->quantity_of_guest,
                    ],
                    'check_in:datetime',
                    'check_out:datetime',
                    'order_total:currency',
                    'service_total:currency',
                    'penalty_from_excess_hour:currency',
                ],
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <?php Pjax::begin(); ?>
                <?= GridView::widget([
                    'dataProvider' => $serviceDataProvider,
                    'columns' => [
                        ['class' => 'kartik\grid\SerialColumn'],

                        [
                            'attribute' => 'spa',
                            'value' => 'spa.title',
                            'width' => '200px;',
                            'pageSummary' => 'Total',
                        ],
                        [
                            'attribute' => 'quantity',
                            'pageSummary' => true,
                            'pageSummaryFunc'=>GridView::F_SUM,
                        ],
                        [
                            'attribute' => 'amount',
                            'format' => 'currency',
                            'pageSummary' => true,
                            'pageSummaryFunc'=>GridView::F_SUM,
                        ],
                        [
                            'attribute' => 'total',
                            'format' => 'currency',
                            'pageSummary' => true,
                            'pageSummaryFunc'=>GridView::F_SUM,
                        ],
                        'created_at:datetime',
                        'id',

                        [
                            'class' => 'kartik\grid\ActionColumn',
                            'template' => '{delete}',
                            'buttons' => [
                                'delete' => function ($url, $model, $key) {
                                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['service/delete', 'id' => $model->id, 'transaction_id' => $model->transaction_id], ['title' => 'Delete', 'aria-label' => 'Delete', 'data-pjax' => 0, 'data-method' => 'post']);
                                },
                            ],
                        ],
                    ],
                    'showPageSummary' => true,
                    'panel'=>[
                        'type' => GridView::TYPE_DEFAULT,
                        'heading' => 'Service Grid',
                    ],
                    'toolbar' => [
                        '{toggleData}',
                    ],
                ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <?php Pjax::begin(); ?>
                <?= GridView::widget([
                    'dataProvider' => $orderDataProvider,
                    'columns' => [
                        ['class' => 'kartik\grid\SerialColumn'],

                        [
                            'attribute' => 'menuPackage',
                            'value' => 'menuPackage.title',
                            'width' => '200px;',
                            'pageSummary' => 'Total',
                        ],
                        [
                            'attribute' => 'quantity',
                            'pageSummary' => true,
                            'pageSummaryFunc'=>GridView::F_SUM,
                        ],
                        [
                            'attribute' => 'amount',
                            'format' => 'currency',
                            'pageSummary' => true,
                            'pageSummaryFunc'=>GridView::F_SUM,
                        ],
                        [
                            'attribute' => 'total',
                            'format' => 'currency',
                            'pageSummary' => true,
                            'pageSummaryFunc'=>GridView::F_SUM,
                        ],
                        'created_at:datetime',
                        'id',

                        [
                            'class' => 'kartik\grid\ActionColumn',
                            'template' => '{delete}',
                            'buttons' => [
                                'delete' => function ($url, $model, $key) {
                                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['order/delete', 'id' => $model->id, 'transaction_id' => $model->transaction_id], ['title' => 'Delete', 'aria-label' => 'Delete', 'data-pjax' => 0, 'data-method' => 'post']);
                                },
                            ],
                        ],
                    ],
                    'showPageSummary' => true,
                    'panel'=>[
                        'type' => GridView::TYPE_DEFAULT,
                        'heading' => 'Order Grid',
                    ],
                    'toolbar' => [
                        '{toggleData}',
                    ],
                ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>

</div>

<?php
    Modal::begin([
        'header' => '<h4>Check Out Window</h4>',
        'id' => 'modal-check-out',
        'size' => Modal::SIZE_LARGE,
    ]);
    echo '<div id="modal-check-out-content"></div>';
    Modal::end ();
?>

<?php
$this->registerJs('
(function($) {
    $(document).on("click", ".check-out-button", function(e) {
        modalLink = this.href;
        $("#modal-check-out").modal("show")
            .find("#modal-check-out-content")
            .load(modalLink);
        e.preventDefault();
    });
    $(document).on("beforeSubmit", "#check-out-form", function(e) {
        $.post(
            $(this).attr("action"),
            $(this).serialize()
        ).done(function(result) {
            if (result.success) {
                $(orderFormMessage).html(result.message);
                $(orderFormMessage).show();
            }
        });
        return false;
    });
})(jQuery);
');
?>