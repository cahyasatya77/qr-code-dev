<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
    ];
    public $js = [
        'js/main.js',
        'js/bootstrap-notify.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.2.0/socket.io.js',
        /*'js/camera.js',
        'js/scanner.js',
        'js/zxing.js',
        'js/instascan.min.js',
        'js/qr_packed.js',
        'js/reader.js'*/
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'rmrevin\yii\fontawesome\AssetBundle',
    ];
}
