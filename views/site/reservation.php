<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\widgets\TouchSpin;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $reservation app\reservations\Reservation */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Place Reservation';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-reservation">
<?php if (Yii::$app->session->hasFlash('reservationFormSubmitted')): ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-success">Thank you. We received your payment. The owner will contact you as soon as possible.</div>
        </div>
    </div>

<?php else: ?>
    <div class="row">
        <div class="col-lg-8">
            <?php $form = ActiveForm::begin([
                'id' => 'reservation-form',
            ]); ?>

                <div class="panel panel-default">
                    <div class="panel-body">
                        <legend>Contact Information</legend>

                        <?= $form->field($reservation, 'firstname')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($reservation, 'lastname')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($reservation, 'contact')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($reservation, 'email')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($reservation, 'address')->textArea(['rows' => 5]) ?>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-body">
                        <legend>Guest Details</legend>

                        <?= $form->field($reservation, 'check_in')->widget(DatePicker::classname(), [
                            'pluginOptions' => [
                                'autoclose' => true,
                                'todayHighlight' => true,
                                'format' => 'yyyy-mm-dd',
                            ],
                        ]) ?>

                        <?= $form->field($reservation, 'check_out')->widget(DatePicker::classname(), [
                            'pluginOptions' => [
                                'autoclose' => true,
                                'todayHighlight' => true,
                                'format' => 'yyyy-mm-dd',
                            ],
                            'pluginEvents' => [
                                'changeDate' => '
                                    function(e) {
                                        var spinner = \'<i class="fa fa-spinner fa-spin fa-fw"></i>\';
                                        $("#check-in-date-verification").html(spinner).show();
                                        // var data = {date: e.format(0), item: ' . $packageItem->id . '};
                                        setTimeout(function() {
                                            $.post("' . Url::to(['site/check-room-availability', 'package_item_id' => $packageItem->id]) . '",
                                                $("#reservation-form").serialize(),
                                                function(data) {
                                                    var message = \'<div class="alert alert-\' + data.status + \'" role="alert">\' + data.message + \'</div>\';
                                                    $("#check-in-date-verification").html(message);
                                                }
                                            );
                                        }, 0);
                                    }
                                ',
                            ],
                        ]) ?>

                        <p id="check-in-date-verification"></p>

                        <?= $form->field($reservation, 'quantity_of_guest')->widget(TouchSpin::classname(), [
                            'pluginOptions' => [
                                'step' => 1,
                                'min' => 1,
                                'max' => $packageItem->max_person_per_room,
                            ],
                        ]) ?>

                        <?= $form->field($reservation, 'remark')->textarea(['rows' => 6]) ?>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-body">
                        <legend>Credit Card Details</legend>

                        <?= $form->field($reservation, 'cc_type')->radioList([
                            'visa' => '<i class="fa fa-cc-visa fa-4x" aria-hidden="true"></i>',
                            'mastercard' => '<i class="fa fa-cc-mastercard fa-4x" aria-hidden="true"></i>',
                            'discover' => '<i class="fa fa-cc-discover fa-4x" aria-hidden="true"></i>',
                            'amex' =>  '<i class="fa fa-cc-amex fa-4x" aria-hidden="true"></i>',
                        ]) ?>

                        <?= $form->field($reservation, 'cc_number')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($reservation, 'cc_cvv')->textInput(['maxlength' => true]) ?>

                        <p><?= Html::a('<i class="fa fa-exclamation-circle"></i> What is CVV?', '#', [
                            'title' => Html::img('@web/img/cvv2.png'),
                            'class' => 'btn btn-danger btn-xs',
                            'data' => [
                                'toggle' => 'tooltip',
                                'placement' => 'right',
                                'container' => 'body',
                            ],
                        ]) ?></p>

                        <?= $form->field($reservation, 'cc_expiry_month')->widget(TouchSpin::classname(), [
                            'pluginOptions' => [
                                'step' => 1,
                                'min' => 1,
                                'max' => 12,
                            ],
                        ]) ?>

                        <?= $form->field($reservation, 'cc_expiry_year')->widget(TouchSpin::classname(), [
                            'pluginOptions' => [
                                'step' => 1,
                                'initval' => 2016,
                                'min' => 2016,
                                'max' => 2030,
                            ],
                        ]) ?>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-body">
                        <?= $form->field($reservation, 'verifyCode')->widget(Captcha::className()) ?>
                    </div>
                </div>

                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
                    <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>

        <div class="col-lg-4">
            <div class="panel panel-success">
                <div class="panel-heading text-success">
                    <h3 class="panel-title">Package Details</h3>
                </div>
                <div class="panel-body">
                    <p><?= Html::encode($packageItem->title) ?></p>
                    <p>Available: <?php echo ($packageItem->quantity > 0) ? 'Yes' : 'No'; ?></p>
                    <p>Rate: <?= Html::encode(\Yii::$app->formatter->asCurrency($packageItem->rate)) ?></p>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">Contact Us</h3>
                </div>
                <div class="panel-body text-info">
                    <?= app\components\ContactWidget::widget() ?>
                </div>
            </div>
        </div>
    </div>

<?php endif; ?>
</div>

<?php
$this->registerJs('
    (function($) {
        $("#check-in-date-verification").hide();
        $(\'a[data-toggle="tooltip"]\').tooltip({ html: true }).on("click", function() { return false; });
    })(jQuery);
');
?>
