<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */

$this->title = Yii::$app->params['appName'];
?>
<div class="site-index">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Welcome to <?= Yii::$app->params['appName'] ?></h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="well well-sm">
                <h2 class="page-header">News</h2>

                <?php Pjax::begin(); ?>
                    <?= ListView::widget([
                        'dataProvider' => $dataProvider,
                        'itemOptions' => ['class' => 'item'],
                        'itemView' => '_news_item',
                        'layout' => "{items}\n{pager}",
                    ]) ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>

</div>
