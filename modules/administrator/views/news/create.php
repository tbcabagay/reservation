<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\News */

$this->title = Yii::t('app', 'Create News');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'News'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-create">

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
