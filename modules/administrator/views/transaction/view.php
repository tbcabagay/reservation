<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\widgets\Pjax;

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
                    'total_amount:currency',
                ],
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Avail of Services</h3>
                </div>
                <div class="panel-body">
                    <?php Pjax::begin(); ?>
                        <?= GridView::widget([
                            'dataProvider' => $serviceDataProvider,
                            /*'filterModel' => $serviceSearchModel,*/
                            'columns' => [
                                /*['class' => 'yii\grid\SerialColumn'],*/
                                ['class' => 'yii\grid\CheckboxColumn'],

                                [
                                    'attribute' => 'spa',
                                    'value' => 'spa.title',
                                ],
                                'quantity',
                                'amount',
                                'id',

                                ['class' => 'yii\grid\ActionColumn'],
                            ],
                        ]); ?>
                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Order Menu</h3>
                </div>
                <div class="panel-body">
                    <?php Pjax::begin(); ?>
                        <?= GridView::widget([
                            'dataProvider' => $orderDataProvider,
                            /*'filterModel' => $serviceSearchModel,*/
                            'columns' => [
                                /*['class' => 'yii\grid\SerialColumn'],*/
                                ['class' => 'yii\grid\CheckboxColumn'],

                                [
                                    'attribute' => 'menu',
                                    'value' => 'menu.title',
                                ],
                                'quantity',
                                'amount',
                                'id',

                                ['class' => 'yii\grid\ActionColumn'],
                            ],
                        ]); ?>
                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
    </div>

</div>
