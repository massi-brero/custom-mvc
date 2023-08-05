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

  public function resolve()
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

    echo call_user_func($callback);
  }

  protected function renderView(string $view)
  {

    $layout = $this->getLayout();
    $content = $this->renderContent($view);

    return str_replace('{{content}}', $content, $layout);
  }

  protected function getLayout(): String
  {
    ob_start();
    include_once Application::$ROOT_DIR . "/views/layouts/main.php";
    return ob_get_clean();
  }

  protected function renderContent(String $view): String
  {
    ob_start();
    include_once Application::$ROOT_DIR . "/views/$view.php";
    return ob_get_clean();
  }
}