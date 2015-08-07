<?php
/**
 * Created by Rem.
 * Author: Dmitry Kushneriv
 * Email: remkwadriga@yandex.ua
 * Date: 06-08-2015
 * Time: 10:55 AM
 */

namespace widgets\accordion\assets;

use abstracts\AssetAbstract;

class AccordionAsset extends AssetAbstract
{
    public $basePath = '/../app/widgets/accordion/public';
    public $jsPath = '/js';

    public function init()
    {
        $this->cssPos = self::POS_TOP;
        $this->priority = self::PRIORITY_MAIN;
    }

    public $js = [
        'accordion',
    ];

    public $scripts = [
        'Accordion.init()',
    ];

    public $depending = [
        'metisMenu',
    ];
}