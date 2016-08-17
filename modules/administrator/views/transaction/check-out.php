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
$model->toggle_discount = ($model->toggle_discount === null) ? false : $model->toggle_discount;
?>
<div class="transaction-check-out">

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
                        <legend>Customer Information</legend>
                        <?= $form->field($model, 'check_out')->widget(DateTimePicker::classname(), [
                            'pluginOptions' => [
                                'autoclose' => true,
                                'todayHighlight' => true,
                                'format' => 'yyyy-mm-dd hh:ii:ss',
                            ]
                        ]) ?>

                        <?= $form->field($model, 'toggle_date_time')->radioList(['system' => 'Use System Clock', 'manual' => 'Set Manually'], ['inline' => true])->label(false) ?>

                        <?= $form->field($model, 'discount', [
                            'addon' => ['append' => ['content' => '%']]
                        ])->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'toggle_discount')->checkBox() ?>

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
    var discount = "#' . Html::getInputId($model, 'discount') .'";
    var toggleDateTimeValue = $(\'input:radio[name="' . Html::getInputName($model, 'toggle_date_time') . '"]:checked\').val();
    var toggleDiscount = "#' . Html::getInputId($model, 'toggle_discount') .'";
    $(discount).prop("disabled", true);
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
    $(toggleDiscount).change(function() {
        $(discount).prop("disabled", !$(this).is(":checked"));
    });
})(jQuery);
');
?>
