<?php

use yii\helpers\Html;
use kartik\markdown\Markdown;

?>

<h2><?= $model->title ?></h2>

<?php if (empty($model->header) === false): ?>
<div class="well well-sm">
    <?= Markdown::convert($model->header) ?>
</div>
<?php endif; ?>

<?php foreach ($model->packageItems as $packageItem): ?>
    <h3><?= $packageItem->title ?></h3>

    <?= Markdown::convert($packageItem->content) ?>
<?php endforeach; ?>

<?php if (empty($model->footer) === false): ?>
<div class="well well-sm">
    <?= Markdown::convert($model->footer) ?>
</div>
<?php endif; ?>