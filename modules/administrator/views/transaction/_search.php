<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\TransactionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transaction-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="col-lg-6">
        <?= $form->field($model, 'package_item_id')->dropdownList($packageItems, ['prompt' => '- Select -']) ?>

        <?= $form->field($model, 'firstname') ?>

        <?= $form->field($model, 'lastname') ?>
    </div>

    <div class="col-lg-6">
        <?= $form->field($model, 'status') ?>

        <?= $form->field($model, 'check_in')->widget(DatePicker::classname(), [
            'pluginOptions' => [
                'autoclose' => true,
                'todayHighlight' => true,
                'format' => 'yyyy-mm-dd',
            ]
        ]) ?>

        <?= $form->field($model, 'check_out')->widget(DatePicker::classname(), [
            'pluginOptions' => [
                'autoclose' => true,
                'todayHighlight' => true,
                'format' => 'yyyy-mm-dd',
            ]
        ]) ?>
    </div>

    <div class="col-lg-12">
        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Reset'), ['index'], ['class' => 'btn btn-default']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
