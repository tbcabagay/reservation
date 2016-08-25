<?php

use yii\helpers\Html;
use app\models\Reservation;

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
        <div class="panel panel-default">
            <div class="panel-heading">Reservation</div>
            <div class="panel-body">
                <div class="col-lg-4">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-book fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?= Reservation::getReservationStatusCount(Reservation::STATUS_NEW) ?></div>
                                    <div>New</div>
                                </div>
                            </div>
                        </div>
                        <?= Html::a('<div class="panel-footer"><span class="text-primary pull-left">View Details</span><span class="pull-right"><i class="fa fa-arrow-circle-right text-primary"></i></span><div class="clearfix"></div></div>', ['reservation/index']) ?>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-book fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?= Reservation::getReservationStatusCount(Reservation::STATUS_CONFIRM) ?></div>
                                    <div>Confirmed</div>
                                </div>
                            </div>
                        </div>
                        <?= Html::a('<div class="panel-footer"><span class="text-success pull-left">View Details</span><span class="pull-right"><i class="fa fa-arrow-circle-right text-success"></i></span><div class="clearfix"></div></div>', ['reservation/index']) ?>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-book fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?= Reservation::getReservationStatusCount(Reservation::STATUS_CANCEL) ?></div>
                                    <div>Cancelled</div>
                                </div>
                            </div>
                        </div>
                        <?= Html::a('<div class="panel-footer"><span class="text-danger pull-left">View Details</span><span class="pull-right"><i class="fa fa-arrow-circle-right text-danger"></i></span><div class="clearfix"></div></div>', ['reservation/index']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
