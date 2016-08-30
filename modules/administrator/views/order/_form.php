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
                'id' => 'order-menu-form',
                'enableClientValidation' => false,
                'enableAjaxValidation' => true,
                'validationUrl' => ['ajax-validate'],
            ]); ?>

                <?= $form->field($order, 'menu_package_id')->radioList($menuPackage) ?>

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
    $("#order-form-message").hide();
})(jQuery);
');
?>