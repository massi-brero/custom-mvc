<?php

namespace app\core;

/**
 * @author massisoft
 * @namespace app\core
 */
class Router
{

  public Request $request;
  public Response $response;
  protected array $routes = [];

  /**
   * @param Request $request
   * @param Response $response
   */
  public function __construct(Request $request, Response $response)
  {
    $this->request = $request ?? new Request();
    $this->response = $response ?? new Response();
  }


  public function get(string $path, $callback)
  {
    $this->routes['get'][$path] = $callback;
  }

  public function post(string $path, $callback)
  {
    $this->routes['post'][$path] = $callback;
  }

  public function resolve(): void
  {
    $path = $this->request->getPath();
    $method = strtolower($this->request->getMethod());
    $callback = $this->routes[$method][$path] ?? false;

    if ($callback === false) {
      $this->response->setStatusCode(404);
      return $this->renderView('404');
    }

    if (is_string($callback)) {
      return $this->renderView($callback);
    }

    if(is_array($callback) && count($callback) > 0) {
      $callback[0] = $this->instantiateClass($callback[0]);
    }

    echo call_user_func($callback, $this->request);
  }

  public function renderView(string $view, array $params = [])
  {

    $layout = $this->getLayout();
    $content = $this->renderContent($view, $params);

    return str_replace('{{content}}', $content, $layout);
  }

  protected function getLayout(): String
  {
    ob_start();
    include_once Application::$ROOT_DIR . "/views/layouts/main.php";
    return ob_get_clean();
  }

  protected function renderContent(String $view, array $params): String
  {
    foreach ( $params as $key => $val) {
      $$key = $val;
    }

    ob_start();
    include_once Application::$ROOT_DIR . "/views/$view.php";
    return ob_get_clean();
  }

  private function instantiateClass($class)
  {
    return new $class();
  }
}