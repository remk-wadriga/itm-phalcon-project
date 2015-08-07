<?php

namespace controllers;

use abstracts\ControllerAbstract;

class IndexController extends ControllerAbstract
{
    public function indexAction()
    {
        $this->render([
            'name' => 'World',
        ]);
    }
}

