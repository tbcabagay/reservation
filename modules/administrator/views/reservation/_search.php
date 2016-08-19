<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\ReservationSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reservation-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'id' => 'reservation-search-form',
    ]); ?>

    <div class="col-lg-6">
        <?= $form->field($model, 'package_item_id')->dropdownList($packageItems, ['prompt' => '- Select -']) ?>

        <?= $form->field($model, 'firstname') ?>

        <?= $form->field($model, 'lastname') ?>
    </div>

    <div class="col-lg-6">
        <?= $form->field($model, 'check_in')->widget(DatePicker::classname(), [
            'pluginOptions' => [
                'autoclose' => true,
                'todayHighlight' => true,
                'format' => 'yyyy-mm-dd',
            ]
        ]) ?>

        <?= $form->field($model, 'status')->dropdownList($status, ['prompt' => '- Select -']) ?>

        <div class="form-group">
            <small>
                <ul class="list-inline">
                    <li><strong>NEW</strong> - New</li>
                    <li><strong>CIN</strong> - Checked In</li>
                    <li><strong>OUT</strong> - Checked Out</li>
                    <li><strong>CAN</strong> - Cancelled</li>
                </ul>
            </small>
            <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Reset'), ['index'], ['class' => 'btn btn-default']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
