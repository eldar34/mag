<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class MyAssetv extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
       // 'template/css/bootstrap.min.css',
        'template/css/font-awesome.min.css',
        'template/css/prettyPhoto.css',
        'template/css/price-range.css',
        'template/css/animate.css',
        'template/css/main.css',
        'template/css/responsive.css',
        
    ];
    public $js = [
       // 'template/js/jquery.js',
       // 'template/js/bootstrap.min.js',
        'template/js/jquery.scrollUp.min.js',
        'template/js/price-range.js',
        'template/js/jquery.prettyPhoto.js',
        'template/js/jquery.cookie.js',
        'template/js/jquery.accordion.js',
        'template/js/mainv.js',        
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
