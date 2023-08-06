<?php

namespace app\controllers;

use app\core\Request;

class AuthController extends BaseController
{
  public function login(Request $request) {
    $this->render('login');
  }

  public function register(Request $request)
  {

  }
}