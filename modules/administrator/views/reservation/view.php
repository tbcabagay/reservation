<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use app\models\Reservation;

/* @var $this yii\web\View */
/* @var $model app\models\Reservation */

$this->title = Yii::t('app', 'Reservation # ') . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Reservations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$formatter = Yii::$app->formatter;
?>
<div class="reservation-view">

    <div class="row">
        <div class="col-lg-12">
            <h1><?= Html::encode($this->title) ?></h1>

        <?php if ($model->status === Reservation::STATUS_NEW): ?>
            <p>
                <?= Html::a(Yii::t('app', 'Check In'), ['transaction/check-in', 'reservation_id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a(Yii::t('app', 'Cancel'), ['cancel', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to cancel this item?'),
                        'method' => 'post',
                    ],
                ]) ?>
            </p>
        <?php endif; ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'attribute' => 'package_item_id',
                        'value' => $model->packageItem->title,
                    ],
                    'firstname',
                    'lastname',
                    'contact',
                    'email:email',
                    'check_in:date',
                    'quantity_of_guest',
                    'address',
                    'remark:ntext',
                    'created_at:datetime',
                    'updated_at:datetime',
                ],
            ]) ?>
        </div>
    </div>

</div>
