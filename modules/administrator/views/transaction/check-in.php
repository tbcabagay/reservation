<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\widgets\DateTimePicker;
use kartik\widgets\TouchSpin;

/* @var $this yii\web\View */
/* @var $transaction app\transactions\Transaction */

$this->title = Yii::t('app', 'Check In');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Transactions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$transaction->toggle_date_time = ($transaction->toggle_date_time === null) ? 'system' : $transaction->toggle_date_time;
?>
<div class="transaction-check-in">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?= Html::encode($this->title) ?></h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <?php $form = ActiveForm::begin(); ?>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <legend>Details</legend>

                        <?= $form->field($transaction, 'package_item_id')->dropdownList($packageItems) ?>

                        <?= $form->field($transaction, 'quantity_of_guest')->widget(TouchSpin::classname(), [
                            'pluginOptions' => [
                                'step' => 1,
                                'min' => 1,
                                'max' => $transaction->packageItem->max_person_per_room,
                            ],
                        ]) ?>

                        <?= $form->field($transaction, 'check_in')->widget(DateTimePicker::classname(), [
                            'pluginOptions' => [
                                'autoclose' => true,
                                'todayHighlight' => true,
                                'format' => 'yyyy-mm-dd hh:ii:ss',
                            ]
                        ]) ?>

                        <?= $form->field($transaction, 'toggle_date_time')->radioList(['system' => 'Use System Clock', 'manual' => 'Set Manually'], ['inline' => true])->label(false) ?>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-body">
                        <legend>Customer Information</legend>

                        <?= $form->field($transaction, 'firstname')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($transaction, 'lastname')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($transaction, 'contact')->textInput(['maxlength' => true]) ?>

                        <div class="form-group">
                            <?= Html::submitButton(Yii::t('app', 'Check In'), ['class' => 'btn btn-primary']) ?>
                        </div>
                    </div>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>

<?php
$this->registerJs('
(function($) {
    var checkIn = "#' . Html::getInputId($transaction, 'check_in') . '";
    var toggleDateTimeValue = $(\'input:radio[name="' . Html::getInputName($transaction, 'toggle_date_time') . '"]:checked\').val();
    if (toggleDateTimeValue == "manual") {
        $(checkIn).prop("disabled", false);
    } else if (toggleDateTimeValue == "system") {
        $(checkIn).prop("disabled", true);
    }
    $(\'input:radio[name="' . Html::getInputName($transaction, 'toggle_date_time') . '"]\').change(function() {
        if (this.value == "manual") {
            $(checkIn).prop("disabled", false);
        } else if (this.value == "system") {
            $(checkIn).prop("disabled", true);
        }
    });
})(jQuery);
');
?>
