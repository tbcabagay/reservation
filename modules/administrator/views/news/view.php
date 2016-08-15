<?php

use yii\helpers\Html;
use kartik\markdown\Markdown;

/* @var $this yii\web\View */
/* @var $model app\models\News */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'News'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$formatter = Yii::$app->formatter;
?>
<div class="news-view">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?= Html::encode($this->title) ?></h1>
            <p class="text-muted"><i class="fa fa-clock-o"></i> <em><?= $formatter->asDateTime($model->created_at) ?></em></p>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-12">
            <p><?= Markdown::convert($model->content) ?></p>

            <p>
                <?= Html::a(Yii::t('app', 'Upload Image'), ['upload-image', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm']) ?>
            </p>
        </div>
    </div>

</div>
