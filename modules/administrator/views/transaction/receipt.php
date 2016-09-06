<?php

use yii\helpers\Html;

$formatter = Yii::$app->formatter;
$grandTotal = $model->order_total + $model->service_total + $model->penalty_from_excess_hour;
?>

<p><?= Yii::$app->params['appName'] ?><br>
<?= Html::encode($model->packageItem->title) ?></p>

<hr>

<dl>
    <dt><?= Yii::t('app', 'Customer Name') ?></dt>
    <dd><?= Html::encode($model->lastname) ?>, <?= Html::encode($model->firstname) ?></dd>
    <dt><?= Yii::t('app', 'Check In Time') ?></dt>
    <dd><?= Html::encode($formatter->asDateTime($model->check_in)) ?></dd>
    <dt><?= Yii::t('app', 'Check Out Time') ?></dt>
    <dd><?= Html::encode($formatter->asDateTime($model->check_out)) ?></dd>
    <dt><?= Yii::t('app', '# of {n, plural, =1{Guest} other{Guests}}', ['n' => $model->quantity_of_guest]) ?></dt>
    <dd><?= Html::encode($model->quantity_of_guest) ?></dd>
    <dt><?= Yii::t('app', 'Order Total Amount') ?></dt>
    <dd><?= Html::encode($formatter->asCurrency($model->order_total)) ?></dd>
    <dt><?= Yii::t('app', 'Service Total Amount') ?></dt>
    <dd><?= Html::encode($formatter->asCurrency($model->service_total)) ?></dd>
    <dt><?= Yii::t('app', 'Penalty From Excess Hour') ?></dt>
    <dd><?= Html::encode($formatter->asCurrency($model->penalty_from_excess_hour)) ?></dd>
    <dt><?= Yii::t('app', 'Grand Total') ?></dt>
    <dd><?= Html::encode($formatter->asCurrency($grandTotal)) ?></dd>
</dl>