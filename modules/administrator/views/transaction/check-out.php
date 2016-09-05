<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\widgets\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Transaction */

$this->title = Yii::t('app', 'Check Out');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Transactions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$model->toggle_date_time = ($model->toggle_date_time === null) ? 'system' : $model->toggle_date_time;
?>
<div class="transaction-check-out">

    <div class="row">
        <div class="col-lg-12">
            <?php $form = ActiveForm::begin([
                'id' => 'check-out-form',
                'enableClientValidation' => false,
                'enableAjaxValidation' => true,
                'validationUrl' => ['ajax-check-out-validate', 'id' => $model->id],
            ]); ?>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <legend>Customer Information</legend>
                        <?= $form->field($model, 'check_out')->widget(DateTimePicker::classname(), [
                            'pluginOptions' => [
                                'autoclose' => true,
                                'todayHighlight' => true,
                                'format' => 'yyyy-mm-dd hh:ii:ss',
                            ]
                        ]) ?>

                        <?= $form->field($model, 'toggle_date_time')->radioList(['system' => 'Use System Clock', 'manual' => 'Set Manually'], ['inline' => true])->label(false) ?>

                        <div class="form-group">
                            <?= Html::submitButton(Yii::t('app', 'Check Out'), ['class' => 'btn btn-success']) ?>
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
    var checkOut = "#' . Html::getInputId($model, 'check_out') . '";
    var toggleDateTimeValue = $(\'input:radio[name="' . Html::getInputName($model, 'toggle_date_time') . '"]:checked\').val();
    if (toggleDateTimeValue == "manual") {
        $(checkOut).prop("disabled", false);
    } else if (toggleDateTimeValue == "system") {
        $(checkOut).prop("disabled", true);
    }
    $(\'input:radio[name="' . Html::getInputName($model, 'toggle_date_time') . '"]\').change(function() {
        if (this.value == "manual") {
            $(checkOut).prop("disabled", false);
        } else if (this.value == "system") {
            $(checkOut).prop("disabled", true);
        }
    });
})(jQuery);
');
?>
