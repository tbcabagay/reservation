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
            <h1 class="page-header"><?= Html::encode($model->title) ?></h1>
            <p class="text-muted"><i class="fa fa-user"></i> <em><?= Html::encode($model->user->username) ?></em> <i class="fa fa-clock-o"></i> <em><?= $formatter->asDateTime($model->created_at) ?></em></p>
            <?= Html::img($model->photo, ['class' => 'img-responsive pull-left col-lg-3']) ?>
            <?= Markdown::convert($model->content) ?>
        </div>
    </div>

</div>
