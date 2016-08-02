<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */

$this->title = 'Explore';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-explore">

    <?php Pjax::begin(); ?>
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => 'item'],
            'itemView' => '_explore_item',
            'layout' => "{items}\n{pager}",
        ]) ?>
    <?php Pjax::end(); ?>

</div>
