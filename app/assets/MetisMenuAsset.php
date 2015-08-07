<?php
/**
 * Created by Rem.
 * Author: Dmitry Kushneriv
 * Email: remkwadriga@yandex.ua
 * Date: 05-08-2015
 * Time: 12:46 PM
 */

namespace assets;

use abstracts\AssetAbstract;

class MetisMenuAsset extends AssetAbstract
{
    public $cssPath = '/metis-menu';
    public $jsPath = '/metis-menu';

    public $js = [
        'metisMenu.min',
    ];

    public $css = [
        'metisMenu.min',
    ];
}