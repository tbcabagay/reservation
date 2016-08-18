<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Gallery';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-gallery">

    <div class="row">
        <div class="col-lg-12">
            <h2 class="page-header"><?= Html::encode($model->title) ?></h2>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div id="blueimp-gallery" class="blueimp-gallery" data-use-bootstrap-modal="false">
                <div class="slides"></div>
                <h3 class="title"></h3>
                <a class="prev">‹</a>
                <a class="next">›</a>
                <a class="close">×</a>
                <a class="play-pause"></a>
                <ol class="indicator"></ol>
                <div class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" aria-hidden="true">&times;</button>
                                <h4 class="modal-title"></h4>
                            </div>
                            <div class="modal-body next"></div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default pull-left prev">
                                    <i class="glyphicon glyphicon-chevron-left"></i>
                                    Previous
                                </button>
                                <button type="button" class="btn btn-primary next">
                                    Next
                                    <i class="glyphicon glyphicon-chevron-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="links">
    <?php if (empty($packageItemGalleries) == false): ?>
    <?php foreach ($packageItemGalleries as $image): ?>
        <?= Html::a(Html::img($image->thumbnail)
        , $image->photo, ['data-gallery' => '']) ?>
    <?php endforeach; ?>
    <?php else: ?>
        <p>No gallery to display.</p>
    <?php endif; ?>
    </div>

</div>
