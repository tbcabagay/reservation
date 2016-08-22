<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Services';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-services">
    
    <?php if (empty($model)): ?>
    <div class="row">
        <div class="col-lg-12">
            <p>No services to display.</p>
        </div>
    </div>
    <?php else: ?>
    <div class="row">
        <div class="col-lg-12">
            <p class="lead text-center">
                The Spa has the following amenities:<br>
                <small><em>Dry Sauna, Shower Room, Lounge, Couples Room, &amp; Scrub Room. Jacuzzi is located by the poolside.</em></small>
            </p>
            <p class="text-center"><strong><i class="fa fa-clock-o"></i> Operating hours 12:00 noon to 8:00PM</strong></p>
            <hr>
        </div>
    </div>
    <div class="row">
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
    </div>
    <?php endif; ?>

</div>