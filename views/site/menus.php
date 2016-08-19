<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Menus';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-menu">

    <div class="row">
    <?php if (empty($model)): ?>
        <div class="col-lg-12">
            <p>No menu to display.</p>
        </div>
    <? else: ?>
    <?php foreach ($model['package'] as $package): ?>
        <div class="col-lg-3">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h2 class="text-center page-header"><?= Html::encode($package['title']) ?></h2>
                <?php foreach ($package['menu'] as $menu): ?>
                    <ul class="list-unstyled">
                        <li>
                            <strong><?= Html::encode($menu['category']) ?></strong>
                        </li>
                        <li>
                        <?php foreach ($menu['items'] as $item): ?>
                            <ul class="fa-ul menu-item">
                                <li class="clearfix">
                                    <?php // Html::img($item['photo'], ['class' => 'pull-left']) ?>
                                    <u><?= Html::encode($item['title']) ?></u>
                                <?php if (!empty($item['description'])): ?>
                                    <br><em><?= Html::encode($item['description']) ?></em>
                                <?php endif; ?>
                                </li>
                            </ul>
                        <?php endforeach; ?>
                        </li>
                    </ul>
                <?php endforeach; ?>
                </div>
                <div class="panel-footer">
                    <h3 class="text-center"><span class="label label-success"><?= Html::encode(Yii::$app->formatter->asCurrency($package['amount'])) ?></span></h3>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <?php endif; ?>
    </div>

</div>