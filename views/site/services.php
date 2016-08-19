<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Services';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-services">
    
    <div class="row">
    <?php if (empty($model)): ?>
        <div class="col-lg-12">
            <p>No services to display.</p>
        </div>
    <?php else: ?>
    <?php foreach ($model as $spa): ?>
        <div class="col-lg-4 spa-gallery">
            <div class="hovereffect-2">
                <?= Html::img($spa->photo, ['class' => 'img-responsive']); ?>
                <div class="overlay">
                    <h2>
                        <?= Html::encode($spa->title) ?>
                    <?php if (!empty($spa->description)): ?>
                        <br><small><em><?= Html::encode($spa->description) ?></em></small>
                    <?php endif; ?>
                        <br><small><?= Html::encode(Yii::$app->formatter->asCurrency($spa->amount)) ?></small>
                    </h2>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <?php endif; ?>
    </div>

</div>