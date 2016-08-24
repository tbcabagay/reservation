<?php

use yii\helpers\Html;
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
            <div class="alert alert-info">An email has been sent to your inbox. Please check and follow the instructions provided. The administrator will respond to you after.</div>
        </div>
    </div>

<?php else: ?>
    <div class="row">
        <div class="col-lg-8">
            <?php $form = ActiveForm::begin(); ?>

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
                            ]
                        ]) ?>

                        <?= $form->field($reservation, 'quantity_of_guest')->widget(TouchSpin::classname(), [
                            'pluginOptions' => [
                                'step' => 1,
                                'min' => 1,
                            ],
                        ]) ?>

                        <?= $form->field($reservation, 'remark')->textarea(['rows' => 6]) ?>
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