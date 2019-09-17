<?php

namespace app\user\controllers;

use app\components\base\BaseController;

class UserController extends BaseController
{

    public function indexAction()
    {
        echo "<h1>UserController, indexAction</h1>";
    }
}