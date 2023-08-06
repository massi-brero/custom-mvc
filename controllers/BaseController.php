<?php

namespace app\controllers;

use app\core\Application;

/**
 * @author massisoft
 * @namespace app\controllers
 */
class BaseController
{
  protected function render(string $view, array $params = [])
  {
    return Application::$app->router->renderView($view, $params);
  }
}