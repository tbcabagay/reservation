<?php

use yii\helpers\Html;
use app\models\Reservation;
use app\models\Transaction;
use dosamigos\highcharts\HighCharts;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TransactionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Dashboard');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="default-index">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?= Html::encode($this->title) ?></h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-book fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?= Reservation::getReservationStatusCount() ?></div>
                            <div>Total Reservations</div>
                        </div>
                    </div>
                </div>
                <?= Html::a('<div class="panel-footer"><span class="text-primary pull-left">View Details</span><span class="pull-right"><i class="fa fa-arrow-circle-right text-primary"></i></span><div class="clearfix"></div></div>', ['reservation/index']) ?>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-tasks fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?= Transaction::getReservationStatusCount() ?></div>
                            <div>Total Transactions</div>
                        </div>
                    </div>
                </div>
                <?= Html::a('<div class="panel-footer"><span class="text-primary pull-left">View Details</span><span class="pull-right"><i class="fa fa-arrow-circle-right text-primary"></i></span><div class="clearfix"></div></div>', ['reservation/index']) ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?= HighCharts::widget([
                        'clientOptions' => [
                            'chart' => [
                                    'type' => 'bar'
                            ],
                            'title' => [
                                 'text' => 'Reservation Status'
                                 ],
                            'xAxis' => [
                                'categories' => [
                                    'Confirmed',
                                    'Completed',
                                    'Cancelled'
                                ]
                            ],
                            'yAxis' => [
                                'title' => [
                                    'text' => 'Fruit eaten'
                                ]
                            ],
                            'series' => [
                                ['name' => 'Jane', 'data' => [1, 0, 4]],
                                ['name' => 'John', 'data' => [5, 7, 3]]
                            ]
                        ]
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
