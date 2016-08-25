<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Order */
$this->title = Yii::t('app', 'Menu Order');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-create">

    <div class="row">
        <div class="col-lg-12">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <?= $this->render('_form', [
                'order' => $order,
                'transaction' => $transaction,
                'menuPackage' => $menuPackage,
            ]) ?>
        </div>
    </div>

</div>