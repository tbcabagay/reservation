<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Spa */

$this->title = Yii::t('app', 'Update {modelClass} ', [
    'modelClass' => 'Spa',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Spas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="spa-update">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?= Html::encode($this->title) ?></h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>

</div>
