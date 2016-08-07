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

                        <?= $form->field($transaction, 'package_item_id')->dropdownList($packageItems) ?>

                        <?= $form->field($transaction, 'quantity_of_guest')->widget(TouchSpin::classname(), [
                            'pluginOptions' => [
                                'step' => 1,
                                'min' => 1,
                            ],
                        ]) ?>

                        <?= $form->field($transaction, 'check_in')->widget(DateTimePicker::classname(), [
                            'pluginOptions' => [
                                'autoclose' => true,
                                'todayHighlight' => true,
                                'format' => 'yyyy-mm-dd hh:ii',
                            ]
                        ]) ?>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-body">
                        <legend>Customer Information</legend>

                        <?= $form->field($transaction, 'firstname')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($transaction, 'lastname')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($transaction, 'contact')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($transaction, 'email')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($transaction, 'address')->textInput(['maxlength' => true]) ?>

                        <div class="form-group">
                            <?= Html::submitButton(Yii::t('app', 'Check In'), ['class' => 'btn btn-primary']) ?>
                        </div>
                    </div>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
