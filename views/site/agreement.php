<?php

use yii\helpers\Html;
use kartik\markdown\Markdown;

?>

<div class="site-agreement">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?= Markdown::convert($package->agreement) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="pull-right">
                <?= Html::a('I Agree', ['site/reservation', 'slug' => $packageItem->slug], ['class' => 'btn btn-success']) ?>
                <?= Html::a('Decline', ['#'], ['class' => 'btn btn-danger agreement-close-button']) ?>
            </div>
        </div>
    </div>
</div>