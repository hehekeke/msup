<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\widget;

use yii\web\AssetBundle;

/**
 * @author Storm Knight <410345759@qq.com>
 * @since 2.0
 */
class TimelySearchAsset extends AssetBundle
{
    public $sourcePath = "@plugin/timelysearch";
    public $js = [
        'js/timelysearch.js'
    ];
    public $css = [
     'css/timelysearch.css'
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
    // public $jsOptions = [
    //     'position' => \yii\web\View::POS_END,
    // ];
}
