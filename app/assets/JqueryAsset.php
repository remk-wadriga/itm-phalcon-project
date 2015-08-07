<?php
/**
 * Created by Rem.
 * Author: Dmitry Kushneriv
 * Email: remkwadriga@yandex.ua
 * Date: 04-08-2015
 * Time: 15:28 PM
 */

namespace assets;

use abstracts\AssetAbstract;

class JqueryAsset extends AssetAbstract
{
    public $jsPath = '/jquery';

    public $js = [
        'jquery-2.1.4.min',
    ];
}