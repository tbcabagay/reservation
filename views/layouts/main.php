<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\assets\FontAwesomeAsset;
use app\assets\RespondAsset;
use yii\bootstrap\Carousel;
use app\assets\BlueImpAsset;
use app\assets\BootstrapImageGalleryAsset;

raoul2000\bootswatch\BootswatchAsset::$theme = 'yeti';
AppAsset::register($this);
BlueImpAsset::register($this);
BootstrapImageGalleryAsset::register($this);
FontAwesomeAsset::register($this);
RespondAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<?php
NavBar::begin([
    'brandLabel' => Yii::$app->params['appName'],
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top',
    ],
]);
echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => [
        ['label' => 'Home', 'url' => ['/site/index']],
        ['label' => 'Explore', 'url' => ['/site/explore']],
        ['label' => 'Contact', 'url' => ['/site/contact']],
    ],
]);
NavBar::end();
?>

<?php if (($this->context->id === 'site') && ($this->context->action->id === 'index')): ?>
<?= Carousel::widget([
    'items' => [
        [
            'content' => '<div class="fill" style="background-image:url(\'/carousel/1.jpg\');"></div>',
            'caption' => '<h4>Welcome to ' . Yii::$app->params['appName'] .'</h4>'
        ],
        [
            'content' => '<div class="fill" style="background-image:url(\'/carousel/2.jpg\');"></div>',
            'caption' => '<h4>Our De Luxe Room</h4>'
        ],
        [
            'content' => '<div class="fill" style="background-image:url(\'/carousel/3.jpg\');"></div>',
            'caption' => '<h4>Our Cottage</h4>'
        ],
        [
            'content' => '<div class="fill" style="background-image:url(\'/carousel/4.jpg\');"></div>',
            'caption' => '<h4>Our Pool Side Massage Area</h4>'
        ],
        [
            'content' => '<div class="fill" style="background-image:url(\'/carousel/5.jpg\');"></div>',
            'caption' => '<h4>Our Reception Hall</h4>'
        ],
    ],
    'options' => ['id' => 'myCarousel', 'class' => 'slide'],
    'controls' => ['<span class="icon-prev"></span>', '<span class="icon-next"></span>'],
]) ?>
<?php endif; ?>

<div class="container">
<?php if (($this->context->id === 'site') && ($this->context->action->id !== 'index')): ?>
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?= Html::encode($this->title) ?></h1>
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
        </div>
    </div>
<?php endif; ?>

    <?= $content ?>

    <hr>

    <footer>
        <div class="row">
            <div class="col-lg-12">
                <p>Copyright &copy; <?= Yii::$app->params['appName'] ?> <?= date('Y') ?></p>
            </div>
        </div>
    </footer>

</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
