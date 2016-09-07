<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;

use app\models\Transaction;

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
                        ['class' => 'kartik\grid\SerialColumn'],

                        [
                            'attribute' => 'package_item_id',
                            'value' => 'packageItem.title',
                            'filter' => $packageItems,
                        ],
                        'firstname',
                        'lastname',
                        [
                            'attribute' => 'status',
                            'value' => function ($model, $key, $index, $column) {
                                return Transaction::getStatusValue($model->status);
                            },
                            'format' => 'html',
                        ],
                        'check_in:datetime',
                        'check_out:datetime',
                        'id',

                        [
                            'class' => 'kartik\grid\ActionColumn',
                            'template' => '{view} {menu} {spa} {checkout}',
                            'buttons' => [
                                'menu' => function ($url, $model, $key) {
                                    return Html::a('<i class="fa fa-cutlery"></i>', ['order/create', 'transaction_id' => $model->id], ['title' => 'Menu', 'aria-label' => 'Menu', 'data-pjax' => 0, 'class' => 'transaction-gridview-button']);
                                },
                                'spa' => function ($url, $model, $key) {
                                    return Html::a('<i class="fa fa-paw"></i>', ['service/create', 'transaction_id' => $model->id], ['title' => 'Spa', 'aria-label' => 'Menu', 'data-pjax' => 0, 'class' => 'transaction-gridview-button']);
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
    var orderFormMessage = "#order-form-message";
    var serviceFormMessage = "#service-form-message";
    $(document).on("click", ".transaction-gridview-button", function(e) {
        modalLink = this.href;
        $("#modal-transaction").modal("show")
            .find("#modal-transaction-content")
            .load(modalLink);
        e.preventDefault();
    });
    $(document).on("beforeSubmit", "#order-menu-form", function(e) {
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
    $(document).on("beforeSubmit", "#service-spa-form", function(e) {
        $.post(
            $(this).attr("action"),
            $(this).serialize()
        ).done(function(result) {
            if (result.success) {
                $(serviceFormMessage).html(result.message);
                $(serviceFormMessage).show();
            }
        });
        return false;
    });
})(jQuery);
');
?>