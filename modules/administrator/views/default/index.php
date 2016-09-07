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
        <div class="col-lg-1">
            <div class="panel panel-warning text-center">
                <div class="panel-heading">
                    <?= Reservation::getStatusValue(Reservation::STATUS_FOR_VERIFICATION, 'raw') ?>
                </div>
                <div class="panel-body">
                    <i class="fa fa-hourglass"></i> <?= Reservation::getReservationStatusCount(Reservation::STATUS_FOR_VERIFICATION) ?>
                </div>
            </div>
        </div>
        <div class="col-lg-1">
            <div class="panel panel-primary text-center">
                <div class="panel-heading">
                    <?= Reservation::getStatusValue(Reservation::STATUS_NEW, 'raw') ?>
                </div>
                <div class="panel-body">
                    <i class="fa fa-file-o"></i> <?= Reservation::getReservationStatusCount(Reservation::STATUS_NEW) ?>
                </div>
            </div>
        </div>
        <div class="col-lg-1">
            <div class="panel panel-success text-center">
                <div class="panel-heading">
                    <?= Reservation::getStatusValue(Reservation::STATUS_CONFIRM, 'raw') ?>
                </div>
                <div class="panel-body">
                    <i class="fa fa-book"></i> <?= Reservation::getReservationStatusCount(Reservation::STATUS_CONFIRM) ?>
                </div>
            </div>
        </div>
        <div class="col-lg-1">
            <div class="panel panel-info text-center">
                <div class="panel-heading">
                    <?= Reservation::getStatusValue(Reservation::STATUS_DONE, 'raw') ?>
                </div>
                <div class="panel-body">
                    <i class="fa fa-check"></i> <?= Reservation::getReservationStatusCount(Reservation::STATUS_DONE) ?>
                </div>
            </div>
        </div>
        <div class="col-lg-1">
            <div class="panel panel-danger text-center">
                <div class="panel-heading">
                    <?= Reservation::getStatusValue(Reservation::STATUS_CANCEL, 'raw') ?>
                </div>
                <div class="panel-body">
                    <i class="fa fa-remove"></i> <?= Reservation::getReservationStatusCount(Reservation::STATUS_CANCEL) ?>
                </div>
            </div>
        </div>
        <div class="col-lg-1">
            <div class="panel panel-default text-center">
                <div class="panel-heading">
                    <?= Reservation::getStatusValue(Reservation::STATUS_DELETE, 'raw') ?>
                </div>
                <div class="panel-body">
                    <i class="fa fa-trash"></i> <?= Reservation::getReservationStatusCount(Reservation::STATUS_DELETE) ?>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="panel panel-primary text-center">
                <div class="panel-heading">
                    <?= Transaction::getStatusValue(Transaction::STATUS_CHECK_IN, 'raw') ?>
                </div>
                <div class="panel-body">
                    <i class="fa fa-sign-in"></i> <?= Transaction::getReservationStatusCount(Transaction::STATUS_CHECK_IN) ?>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="panel panel-success text-center">
                <div class="panel-heading">
                    <?= Transaction::getStatusValue(Transaction::STATUS_CHECK_OUT, 'raw') ?>
                </div>
                <div class="panel-body">
                    <i class="fa fa-sign-out"></i> <?= Transaction::getReservationStatusCount(Transaction::STATUS_CHECK_OUT) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?= HighCharts::widget([
                        'clientOptions' => [
                            'chart' => [
                                    'type' => 'column'
                            ],
                            'title' => [
                                 'text' => 'Reservation Status'
                                 ],
                            'xAxis' => [
                                'categories' => [
                                    'Jan',
                                    'Feb',
                                    'Mar',
                                    'Apr',
                                    'May',
                                    'Jun',
                                    'Jul',
                                    'Aug',
                                    'Sep',
                                    'Oct',
                                    'Nov',
                                    'Dec',
                                ],
                                'crosshair' => true,
                            ],
                            'yAxis' => [
                                'min' => 0,
                                'title' => [
                                    'text' => '# of Reservations',
                                ]
                            ],
                            'tooltip' => [
                                'headerFormat' => '<span style="font-size:10px">{point.key}</span><table>',
                                'pointFormat' => '<tr><td style="color:{series.color};padding:0">{series.name}: </td><td style="padding:0"><b>{point.y} Customers</b></td></tr>',
                                'footerFormat' => '</table>',
                                'shared' => true,
                                'useHTML' => true,
                            ],
                            'series' => Reservation::getStatusColumnGraph(),
                        ]
                    ]) ?>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?= HighCharts::widget([
                        'clientOptions' => [
                            'title' => [
                                 'text' => '# of Served Customers'
                                 ],
                            'xAxis' => [
                                'categories' => [
                                    'Jan',
                                    'Feb',
                                    'Mar',
                                    'Apr',
                                    'May',
                                    'Jun',
                                    'Jul',
                                    'Aug',
                                    'Sep',
                                    'Oct',
                                    'Nov',
                                    'Dec',
                                ],
                                'crosshair' => true,
                            ],
                            'yAxis' => [
                                'title' => [
                                    'text' => 'Customer Frequency',
                                ]
                            ],
                            'series' => Transaction::getStatusLineGraph(),
                        ]
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
