<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MenuCategory */

$this->title = Yii::t('app', 'Create Menu Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Menu Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-category-create">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?= Html::encode($this->title) ?></h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>

</div>
