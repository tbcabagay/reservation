<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\PackageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Packages');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="package-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Package'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'title',
            'created_at',
            'updated_at',
            [
                'attribute' => 'id',
                'filter' => false,
            ],

            ['class' => 'yii\grid\ActionColumn'],
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
