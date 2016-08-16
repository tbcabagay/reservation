<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\widgets\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Transaction */

$this->title = Yii::t('app', 'Check Out');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Transactions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
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

                        <div class="form-group">
                            <?= Html::submitButton(Yii::t('app', 'Check Out'), ['class' => 'btn btn-success']) ?>
                        </div>
                    </div>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
