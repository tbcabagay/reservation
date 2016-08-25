<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Service */

$this->title = Yii::t('app', 'Avail of Spa Service');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Services'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="service-create">

    <div class="row">
        <div class="col-lg-12">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <?= $this->render('_form', [
                'service' => $service,
                'transaction' => $transaction,
                'spa' => $spa,
            ]) ?>
        </div>
    </div>

</div>
