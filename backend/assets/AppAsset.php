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
		'css/style.css',  
		'css/menu.css',  
		'css/AdminLTE.css',
		'css/font-awesome.min.css',
		'css/skins/_all-skins.min.css',
		'css/jquery.smartmenus.bootstrap.css',
		'css/pay.css', 
    ];
    public $js = [
	 'js/main.js',
	 'js/demo.js',
	 'js/adminlte.min.js',	
	 'js/jquery.smartmenus.js',
	 'js/jquery.smartmenus.bootstrap.js',
	 'js/jquery.table2excel.min.js',
	
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
