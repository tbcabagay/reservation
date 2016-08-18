<?php

namespace app\assets;

use yii\web\AssetBundle;

class BlueImpAsset extends AssetBundle
{
    public $sourcePath = '@bower/blueimp-gallery';
    public $css = [
        'css/blueimp-gallery.min.css',
    ];
    public $js = [
        'js/jquery.blueimp-gallery.min.js',
    ];
    public $depends = [
        'app\assets\AppAsset',
    ];
}
