<?php

namespace elfinder;

use yii\web\AssetBundle;

class ELFinderAsset extends AssetBundle
{
    public $sourcePath = '@vendor/sonicgd/yii2-elfinder/assets';
    public $css = [
        'css/elfinder.min.css',
        'css/theme.css',
    ];

    public $js = [
        "js/elfinder.full.js",
        "js/i18n/elfinder.ru.js",
    ];

    public $depends = [
        'yii\jui\JuiAsset'
    ];
}