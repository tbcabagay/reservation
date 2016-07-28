<?php

use yii\helpers\Html;
use kartik\markdown\Markdown;

$formatter = Yii::$app->formatter;
?>

<h3><?= Html::encode($model->title) ?><br><small><small><i class="fa fa-clock-o" aria-hidden="true"></i> <?= $formatter->asDateTime($model->created_at) ?><?php echo ($model->created_at === $model->updated_at) ? '' : ' (Last updated: ' . $formatter->asDateTime($model->updated_at) . ')' ?></small></small></h3>

<?= Markdown::convert($model->content) ?>