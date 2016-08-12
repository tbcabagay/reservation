<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AdminAsset;
use app\assets\FontAwesomeAsset;
use app\assets\RespondAsset;

AdminAsset::register($this);
FontAwesomeAsset::register($this);
RespondAsset::register($this);

$identity = Yii::$app->user->identity;
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
    <style>
        a.asc:after, a.desc:after {
            position: relative;
            top: 1px;
            display: inline-block;
            font-family: 'Glyphicons Halflings';
            font-style: normal;
            font-weight: normal;
            line-height: 1;
            padding-left: 5px;
        }

        a.asc:after {
            content: /*"\e113"*/ "\e151";
        }

        a.desc:after {
            content: /*"\e114"*/ "\e152";
        }

        .sort-numerical a.asc:after {
            content: "\e153";
        }

        .sort-numerical a.desc:after {
            content: "\e154";
        }

        .sort-ordinal a.asc:after {
            content: "\e155";
        }

        .sort-ordinal a.desc:after {
            content: "\e156";
        }

        .grid-view th {
            white-space: nowrap;
        }
    </style>
</head>
<body>
<?php $this->beginBody() ?>

<div id="wrapper">
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <?= Html::a(Yii::$app->params['appName'], ['/administrator'], ['class' => 'navbar-brand']) ?>
        </div>
        <!-- /.navbar-header -->

        <ul class="nav navbar-top-links navbar-right">
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-envelope fa-fw"></i>  <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-messages">
                    <li>
                        <a href="#">
                            <div>
                                <strong>John Smith</strong>
                                <span class="pull-right text-muted">
                                    <em>Yesterday</em>
                                </span>
                            </div>
                            <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#">
                            <div>
                                <strong>John Smith</strong>
                                <span class="pull-right text-muted">
                                    <em>Yesterday</em>
                                </span>
                            </div>
                            <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#">
                            <div>
                                <strong>John Smith</strong>
                                <span class="pull-right text-muted">
                                    <em>Yesterday</em>
                                </span>
                            </div>
                            <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a class="text-center" href="#">
                            <strong>Read All Messages</strong>
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><?= Html::a('<i class="fa fa-user fa-fw"></i> View Profile', ['/administrator/user/view', 'id' => $identity->id]) ?></li>
                    <li class="divider"></li>
                    <li><?= Html::a('<i class="fa fa-sign-out fa-fw"></i> Logout (' . $identity->username . ')', '/site/logout', ['data-method' => 'post']) ?></li>
                    </li>
                </ul>
            </li>
        </ul>

        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li class="sidebar-search">
                        <div class="input-group custom-search-form">
                            <input type="text" class="form-control" placeholder="Search...">
                            <span class="input-group-btn">
                            <button class="btn btn-default" type="button">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                        </div>
                    </li>
                    <li>
                        <?= Html::a('<i class="fa fa-cog fa-fw"></i> Settings<span class="fa arrow"></span>', '#') ?>
                        <ul class="nav nav-second-level">
                            <li><?= Html::a('Users', ['user/index']) ?></li>
                        </ul>
                    </li>
                    <li><?= Html::a('<i class="fa fa-newspaper-o fa-fw"></i> News', ['news/index']) ?></li>
                    <li>
                        <?= Html::a('<i class="fa fa-gift fa-fw"></i> Packages<span class="fa arrow"></span>', '#') ?>
                        <ul class="nav nav-second-level">
                            <li><?= Html::a('Categories', ['package/index']) ?></li>
                            <li><?= Html::a('Items', ['package-item/index']) ?></li>
                        </ul>
                    </li>
                    <li>
                        <?= Html::a('<i class="fa fa-cutlery fa-fw"></i> Menus<span class="fa arrow"></span>', '#') ?>
                        <ul class="nav nav-second-level">
                            <li><?= Html::a('Categories', ['menu-category/index']) ?></li>
                            <li><?= Html::a('Packages', ['menu-package/index']) ?></li>
                            <li><?= Html::a('Items', ['menu-item/index']) ?></li>
                        </ul>
                    </li>
                    <li><?= Html::a('<i class="fa fa-book fa-fw"></i> Reservations', ['reservation/index']) ?></li>
                    <li><?= Html::a('<i class="fa fa-tasks fa-fw"></i> Transactions', ['transaction/index']) ?></li>
                </ul>
            </div>
        </div>
    </nav>

    <div id="page-wrapper">
        <div class="row">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
        </div>
        <?= $content ?>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
