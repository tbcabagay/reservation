<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\widgets\DateTimePicker;
use kartik\widgets\TouchSpin;

/* @var $this yii\web\View */
/* @var $model app\models\Transaction */

$this->title = Yii::t('app', 'Check In');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Transactions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$model->toggle_date_time = ($model->toggle_date_time === null) ? 'system' : $model->toggle_date_time;
?>
<div class="transaction-create">

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

                        <?= $form->field($model, 'package_item_id')->dropdownList($packageItems) ?>

                        <?= $form->field($model, 'quantity_of_guest')->widget(TouchSpin::classname(), [
                            'pluginOptions' => [
                                'step' => 1,
                                'min' => 1,
                            ],
                        ]) ?>

                        <?= $form->field($model, 'check_in')->widget(DateTimePicker::classname(), [
                            'pluginOptions' => [
                                'autoclose' => true,
                                'todayHighlight' => true,
                                'format' => 'yyyy-mm-dd hh:ii:ss',
                            ]
                        ]) ?>

                        <?= $form->field($model, 'toggle_date_time')->radioList(['system' => 'Use System Clock', 'manual' => 'Set Manually'], ['inline' => true])->label(false) ?>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-body">
                        <legend>Customer Information</legend>

                        <?= $form->field($model, 'firstname')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'lastname')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'contact')->textInput(['maxlength' => true]) ?>

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
    var checkIn = "#' . Html::getInputId($model, 'check_in') . '";
    var toggleDateTimeValue = $(\'input:radio[name="' . Html::getInputName($model, 'toggle_date_time') . '"]:checked\').val();
    if (toggleDateTimeValue == "manual") {
        $(checkIn).prop("disabled", false);
    } else if (toggleDateTimeValue == "system") {
        $(checkIn).prop("disabled", true);
    }
    $(\'input:radio[name="' . Html::getInputName($model, 'toggle_date_time') . '"]\').change(function() {
        if (this.value == "manual") {
            $(checkIn).prop("disabled", false);
        } else if (this.value == "system") {
            $(checkIn).prop("disabled", true);
        }
    });
})(jQuery);
');
?>