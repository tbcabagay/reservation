<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

use app\models\User;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

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
                        ['class' => 'yii\grid\SerialColumn'],

                        'username',
                        'email:email',
                        'registration_ip',
                        [
                            'attribute' => 'status',
                            'filter' => $searchModel->getStatusDropdownList(),
                            'value' => function ($model, $key, $index, $column) {
                                $status = '';
                                if ($model->status === User::STATUS_ACTIVE) {
                                    $status = '<span class="label label-success">STATUS_ACTIVE</span>';
                                } else if ($model->status === User::STATUS_INACTIVE) {
                                    $status = '<span class="label label-warning">STATUS_INACTIVE</span>';
                                }
                                return $status;
                            },
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'created_at',
                            'filter' => false,
                            'value' => function ($model, $key, $index, $column) {
                                return Yii::$app->formatter->asDateTime($model->created_at);
                            }
                        ],
                        [
                            'attribute' => 'updated_at',
                            'filter' => false,
                            'value' => function ($model, $key, $index, $column) {
                                return Yii::$app->formatter->asDateTime($model->updated_at);
                            }
                        ],
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
    </div>

</div>
