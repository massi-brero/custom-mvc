<?php

namespace app\controllers;

use app\core\Application;
use app\core\Request;

/**
 * @author massisoft
 * @namespace app\controllers
 */
class SiteController extends BaseController
{
  public static function handleContact(Request $request)
  {
    $body = $request->getBody();
  }

  public function contact()
  {
    return $this->render('contact');
  }


  public function home()
  {
    $params = [
      'name' => 'Massi'
    ];
    return $this->render('home', $params);
  }


}