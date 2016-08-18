<?php

namespace app\assets;

use yii\web\AssetBundle;

class BootstrapImageGalleryAsset extends AssetBundle
{
    public $sourcePath = '@bower/Bootstrap-Image-Gallery';
    public $css = [
        'css/bootstrap-image-gallery.min.css',
    ];
    public $js = [
        'js/bootstrap-image-gallery.js',
    ];
    public $depends = [
        'app\assets\BlueImpAsset',
    ];
}
