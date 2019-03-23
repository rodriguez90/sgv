<?php
/**
 * Created by PhpStorm.
 * User: pedro
 * Date: 23/03/2019
 * Time: 1:27
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 *
 * ChartPluginAsset
 */
class ChartAsset extends AssetBundle
{
    public $depends = [
        'dosamigos\chartjs\ChartJsAsset',
        'app\assets\AppAsset',
    ];
}