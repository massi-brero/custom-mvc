<?php

namespace app\core;

/**
 * @author massisoft
 * @namespace app\core
 */
class Application
{
  public static $ROOT_DIR;
  public Router $router;
  public Request $request;
  public Response $response;
  public static Application $app;

  public function __construct(String $rootPath)
  {
    self::$ROOT_DIR = $rootPath;
    self::$app = $this;
    $this->request = new Request();
    $this->response = new Response();
    $this->router = new Router($this->request, $this->response);
  }

  public function run()
  {
    echo $this->router->resolve();
  }
}