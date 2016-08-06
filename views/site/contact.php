<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Contact';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
<?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-success">Thank you for contacting us. We will respond to you as soon as possible.</div>
        </div>
    </div>

<?php else: ?>

    <div class="row">
        <div class="col-lg-8">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3870.3498646885855!2d121.3325269153785!3d14.05650589015074!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33bd4333702be959%3A0x26152f04d27829ef!2sSanctuario+de+San+Pablo+Resort+Spa!5e0!3m2!1sen!2sph!4v1469607130790" width="100%" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>
        </div>
        <div class="col-lg-4">
            <?= app\components\ContactWidget::widget() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <h2>Send us a Message</h2>

            <p>If you have business inquiries or other questions, please fill out the following form to contact us. Thank you.</p>

            <div class="well">
                <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                    <?= $form->field($model, 'name')->textInput() ?>

                    <?= $form->field($model, 'email') ?>

                    <?= $form->field($model, 'subject') ?>

                    <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

                    <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                        'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                    ]) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                    </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>

<?php endif; ?>
</div>
