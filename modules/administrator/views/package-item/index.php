<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\PackageItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Package Items');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="package-item-index">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?= Html::encode($this->title) ?></h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <?php Pjax::begin(); ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'kartik\grid\SerialColumn'],

                        'title',
                        [
                            'attribute' => 'package_id',
                            'filter' => $packages,
                            'value' => 'package.title',
                        ],
                        'quantity',
                        'rate:currency',
                        'id',

                        ['class' => 'kartik\grid\ActionColumn'],
                    ],
                    'panel'=>[
                        'type' => GridView::TYPE_DEFAULT,
                        'heading' => 'Grid',
                    ],
                    'toolbar' => [
                        [
                            'content' =>
                            Html::a('<i class="fa fa-plus"></i>', ['create'], [
                                'title' => Yii::t('app', 'Add Library'), 
                                'class' => 'btn btn-success',
                                'data-pjax' => 0,
                            ]) . ' ' .
                            Html::a('<i class="fa fa-repeat"></i>', ['index'], [
                                'class' => 'btn btn-default', 
                                'title' => Yii::t('app', 'Reset Grid'),
                                'data-pjax' => 0,
                            ]),
                        ],
                        '{toggleData}',
                    ],
                ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
