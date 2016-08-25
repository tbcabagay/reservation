<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\widgets\TouchSpin;
use yii\bootstrap\Alert;

/* @var $this yii\web\View */
/* @var $model app\services\Service */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="service-form">

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Form</h3>
        </div>
        <div class="panel-body">
            <?= Alert::widget([
                'options' => [
                    'id' => 'service-form-message',
                    'class' => 'alert-success',
                ],
            ]); ?>

            <?php $form = ActiveForm::begin([
                'id' => 'order-menu-form',
                        'enableClientValidation' => false,
                        'enableAjaxValidation' => true,
                        'validationUrl' => ['ajax-validate'],
            ]); ?>

                <?= $form->field($service, 'spa_id')->radioButtonGroup($spa, [
                    'class' => 'btn-group-md',
                    'itemOptions' => ['labelOptions' => ['class' => 'btn btn-primary']],
                ]) ?>

                <?= $form->field($service, 'quantity')->textInput() ?>

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
    $("#service-form-message").hide();
})(jQuery);
');
?>