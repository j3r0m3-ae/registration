<?php

namespace app\controllers;

use app\core\base\BaseController;

class SiteController extends BaseController
{

    public function indexAction()
    {
        echo '<h1>SiteController, indexAction</h1>';
    }

    public function testAction(int $id)
    {
        echo "<h1>SiteController, testAction, id = $id</h1>";
    }

    public function listAction()
    {
        echo '<h1>SiteController, listAction</h1>';
    }
}