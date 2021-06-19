<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class PearAsset extends AssetBundle
{
    public $basePath = '@webroot';  // 资源文件并可Web访问的目录、物理路径
    public $baseUrl = '@web';       // Web访问资源文件的URL
    //public $sourcePath = '/tmp/src';
    public $css = [                 // 资源包文件数组
        'plugins/component/pear/css/pear.css',
        'plugins/admin/css/load.css',
        'plugins/admin/css/admin.css',
        'plugins/admin/css/other/console.css',
        'plugins/admin/css/main.css',
    ];
    public $js = [                  // 资源包文件数组
        'plugins/component/layui/layui.js',
        'plugins/component/pear/pear.js'
    ];
    public $jsOptions = [           // 加载JS文件使用的选项
        //'condition'=>'lte IE9',
        'position'=> \yii\web\View::POS_HEAD
    ];

    public $cssOptions = [          // 加载CSS文件使用的选项
        //'noscript' => true,
    ];
    public $depends = [             // 该资源包依赖的其他资源包
    ];

    public $publishOptions = [
    ];
}
