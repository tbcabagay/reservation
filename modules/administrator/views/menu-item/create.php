<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MenuItem */

$this->title = Yii::t('app', 'Create Menu Item');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Menu Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-item-create">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?= Html::encode($this->title) ?></h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <?= $this->render('_form', [
                'model' => $model,
                'categories' => $categories,
                'packages' => $packages,
            ]) ?>
        </div>
    </div>

</div>
