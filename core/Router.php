<?php

namespace app\core;

/**
 * @author massisoft
 * @namespace app\core
 */
class Router
{

    public Request $request;
    protected array $routes = [];

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request ?? new Request();
    }


    public function get(String $path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = strtolower($this->request->getMethod());
        $callback = $this->routes[$method][$path] ?? false;

        if ($callback === false) {
          echo 'Url not found.';
          exit();
        }
        echo call_user_func($callback);
    }
}