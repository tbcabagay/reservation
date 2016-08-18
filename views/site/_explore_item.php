<?php

use yii\helpers\Html;
use kartik\markdown\Markdown;

?>

<h2><?= Html::encode($model->title) ?></h2>

<?php if (empty($model->header) === false): ?>
<div class="row">
    <div class="col-lg-12">
        <div class="well well-sm">
            <?= Markdown::convert($model->header) ?>
        </div>
    </div>
</div>
<?php endif; ?>

<?php foreach ($model->packageItems as $packageItem): ?>
<div class="row">
    <div class="col-lg-4">
        <div class="hovereffect">
            <?= Html::img($packageItem->photo, ['class' => 'img-responsive']) ?>
        </div>
    </div>
    <div class="col-lg-8">
        <h3 class="page-header"><?= Html::encode($packageItem->title) ?></h3>
        <?= Markdown::convert($packageItem->content) ?>
        <p>
            <?= Html::a('<i class="fa fa-book""></i> Place Reservation', ['/site/reservation', 'slug' => $packageItem->slug], ['class' => 'btn btn-success']) ?>
            <?= Html::a('<i class="fa fa-picture-o""></i> View Gallery', ['/site/gallery', 'slug' => $packageItem->slug], ['class' => 'btn btn-info']) ?>
        </p>
    </div>
</div>
<?php endforeach; ?>

<?php if (empty($model->footer) === false): ?>
<div class="row">
    <div class="col-lg-12">
        <div class="well well-sm">
            <?= Markdown::convert($model->footer) ?>
        </div>
    </div>
</div>
<?php endif; ?>