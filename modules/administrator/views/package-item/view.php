<?php

use yii\helpers\Html;
use kartik\markdown\Markdown;

/* @var $this yii\web\View */
/* @var $model app\models\PackageItem */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Package Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="package-item-view">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?= Html::encode($model->title) ?></h1>
            <?= Html::img($model->photo, ['class' => 'img-responsive pull-left col-lg-3']) ?>
            <?= Markdown::convert($model->content) ?>

            <hr>
            <p>
                <?php // Html::a(Yii::t('app', '<i class="fa fa-upload"></i> Thumbnail'), ['upload-thumbnail', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm']) ?>
                <?= Html::a(Yii::t('app', '<i class="fa fa-upload"></i> Gallery'), ['package-item-gallery/upload-gallery', 'package_item_id' => $model->id], ['class' => 'btn btn-info btn-sm']) ?>
            </p>
        </div>
    </div>

</div>
