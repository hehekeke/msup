<?php

/**
 *
 * @link   www.msup.com.cn
 * @author stromKnight <410345759@qq.com>
 * @since  1.0 
 */
     
namespace backend\widget;

use yii\web\AssetBundle;


class UploadFileAsset extends AssetBundle
{
    public $sourcePath = '@plugin';
    public $basePath = '@webroot';
    public $baseUrl = '@web/Public/plugin/uploadFile/';
    public $pluginsUrl = '@web/Public/plugin/uploadFile/';
    public $js = [
     //    '../jqueryUi/jquery.ui.min.js',
    //     'js/plupload.full.min.js',
    //     'js/jquery.ui.plupload/jquery.ui.plupload.js',
    //     'js/index.js',
    //     'js/i18n/zh_CN.js'
    /******以上是plupload.js插件引用JS******/
            'js/vendor/jquery.ui.widget.js',
            'js/jquery.iframe-transport.js',
            'js/jquery.fileupload.js',
            'js/jquery.fileupload-process.js',
            'js/jquery.fileupload-image.js',
            'js/jquery.fileupload-audio.js',
            'js/jquery.fileupload-video.js',
            'js/jquery.fileupload-validate.js',
            'js/index.js'
    /*****以上是JqueryFileUpload插件引用JS*****/
    ];

    public $css = [
        'css/style.css',
        'css/jquery.fileupload.css',
        // '../jqueryUi/jquery.ui.css',
        // 
        // 'js/jquery.ui.plupload/css/jquery.ui.plupload.css',
    ];
    public $jsOptions = [
        'position' => \yii\web\View::POS_END
    ];
    public $depends = [
        'backend\assets\AppAsset',

    ];
}
