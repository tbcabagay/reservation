<?php

use yii\helpers\Html;
use kartik\markdown\Markdown;
use yii\bootstrap\Modal;

?>

<h2 class="page-header"><?= Html::encode($model->title) ?></h2>

<?php foreach ($model->packageItems as $packageItem): ?>
<div class="row">
    <div class="col-lg-4">
        <div class="hovereffect">
            <?= Html::img($packageItem->photo, ['class' => 'img-responsive']) ?>
        </div>
    </div>
    <div class="col-lg-8">
        <h3 class="page-header"><?= Html::encode($packageItem->title) ?></h3>
        <?= Markdown::convert($packageItem->content) ?>
        <p>
            <?= Html::a('<i class="fa fa-book""></i> Place Reservation', ['/site/agreement', 'package_id' => $packageItem->package->id, 'slug' => $packageItem->slug], ['class' => 'btn btn-success agreement-button']) ?>
            <?= Html::a('<i class="fa fa-picture-o""></i> View Gallery', ['/site/gallery', 'slug' => $packageItem->slug], ['class' => 'btn btn-info']) ?>
        </p>
    </div>
</div>
<?php endforeach; ?>

<?php
    Modal::begin([
        'header' => '<h4>Package Agreement</h4>',
        'id' => 'modal-transaction',
        'size' => Modal::SIZE_LARGE,
    ]);
    echo '<div id="modal-transaction-content"></div>';
    Modal::end ();
?>

<?php
$this->registerJs('
(function($) {
    $(document).on("click", ".agreement-button", function(e) {
        $("#modal-transaction").modal("show")
            .find("#modal-transaction-content")
            .load(this.href);
        e.preventDefault();
    });
    $(document).on("click", ".agreement-close-button", function(e) {
        $("#modal-transaction").modal("hide");
        e.preventDefault();
    });
})(jQuery);
');
?>