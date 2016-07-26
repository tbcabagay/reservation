<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
$this->context->layout = 'error';
?>
<div class="site-error">

    <div class="jumbotron">
        <h1 class="page-header"><i class="fa fa-ban text-danger" aria-hidden="true"></i> <?= Html::encode($this->title) ?></h1>

        <div class="alert alert-danger">
            <?= nl2br(Html::encode($message)) ?>
        </div>

        <p>The above error occurred while the Web server was processing your request.</p>
        <p>Please contact us if you think this is a server error. Thank you.</p>
        <p><?php
            if (Yii::$app->user->isGuest) {
                echo Html::a('Take Me To The Home Page', ['/site/index'], ['btn btn-default']);
            } else {
                echo Html::a('Take Me To The Home Page', ['/administrator/default/index'], ['class' => 'btn btn-lg btn-primary']);
            }
        ?></p>
    </div>

</div>
