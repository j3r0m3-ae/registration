<?php

namespace app\components;

class Router
{
    /**
     * @var array
     */
    private $routes = [];

    /**
     * @var \app\components\ControllerFactory
     */
    private $controllerFactory;

    /**
     * @param array $routes
     * @param \app\components\ControllerFactory $controllerFactory
     */
    public function __construct(array $routes, ControllerFactory $controllerFactory)
    {
        $this->routes = $routes;
        $this->controllerFactory = $controllerFactory;
    }

    /**
     * Run routing
     *
     * @return void
     */
    public function run()
    {
        $requestUri = $this->getUri();

        if(!empty($requestUri)) {
            foreach ($this->routes as $pattern => $route) {
                if(preg_match("#^$pattern$#", $requestUri, $matches)) {
                    empty($matches[1]) ? $this->execute($route) : $this->execute($route, $matches[1]);
                    return;
                }
            }
            $this->errorPage();
        } else {
            $this->execute($this->routes['home']);
            return;
        }
    }

    /**
     * Execute action of current route
     *
     * @param string $route
     * @param string $parameter
     *
     * @return void
     */
    private function execute(string $route, string $parameter = '')
    {
        $segments = explode('/', $route);
        if (count($segments) == 3) {
            $controllerName = array_shift($segments).'/'.
                ucfirst(array_shift($segments)).'Controller';
        } else {
            $controllerName = ucfirst(array_shift($segments)).'Controller';
        }
        $controller = $this->controllerFactory->factory($controllerName);
        if ($controller) {
            $action = array_shift($segments).'Action';
            if (method_exists($controller, $action)) {
                empty($parameter) ? call_user_func([$controller, $action]) : call_user_func([$controller, $action], $parameter);
            }
        }
    }

    /**
     * Get request uri
     *
     * @return string
     */
    private function getUri()
    {
        return trim($_SERVER['REQUEST_URI'], '/');
    }

    /**
     * Error page
     *
     * @return void
     */
    private function errorPage()
    {
        header("HTTP/1.1 404 Not Found");
        include ROOT.'/app/views/error.php';
        die();
    }
}