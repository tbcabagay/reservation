<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\widgets\TouchSpin;
use yii\bootstrap\Alert;

/* @var $this yii\web\View */
/* @var $order app\orders\Order */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-form">

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Form</h3>
        </div>
        <div class="panel-body">
            <?= Alert::widget([
                'options' => [
                    'id' => 'order-form-message',
                    'class' => 'alert-success',
                ],
            ]); ?>

            <?php $form = ActiveForm::begin([
                'id' => $order->formName(),
                'enableClientValidation' => false,
                'enableAjaxValidation' => true,
                'validationUrl' => ['ajax-validate'],
            ]); ?>

                <?= $form->field($order, 'menu_package_id')->radioButtonGroup($menuPackage, [
                    'class' => 'btn-group-md',
                    'itemOptions' => ['labelOptions' => ['class' => 'btn btn-primary']],
                ]) ?>

                <?= $form->field($order, 'quantity')->widget(TouchSpin::classname(), [
                    'pluginOptions' => [
                        'step' => 1,
                        'min' => 1,
                    ],
                ]) ?>

                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app', 'Place'), ['class' => 'btn btn-success']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<?php
$this->registerJs('
(function($) {
    var orderFormMessage = "#order-form-message";
    $(orderFormMessage).hide();
    $("form#' . $order->formName() . '").on("beforeSubmit", function(e) {
        $.post(
            $(this).attr("action"),
            $(this).serialize()
        ).done(function(result) {
            if (result.success) {
                $(orderFormMessage).html(result.message);
                $(orderFormMessage).show();
            }
        });
        return false;
    });
})(jQuery);
');
?>