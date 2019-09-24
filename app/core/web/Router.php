<?php

namespace app\core\web;

use app\core\exception\InvalidConfigException;
use app\core\exception\HttpErrorException;
use app\core\factories\ControllerFactory;
use ReflectionClass;

class Router
{
    /**
     * @var array
     */
    private $routes = [];

    /**
     * @var ControllerFactory
     */
    private $controllerFactory;

    /**
     * Router constructor
     *
     * @param array $routes
     * @param ControllerFactory $controllerFactory
     * @throws InvalidConfigException
     */
    public function __construct(array $routes, ControllerFactory $controllerFactory)
    {
        if (empty($routes) || !isset($routes['home'])) {
            throw new InvalidConfigException('Invalid routing configuration: empty configuration file or missing route to home page');
        }
        $this->routes = $routes;
        $this->controllerFactory = $controllerFactory;
    }

    /**
     * Run routing
     *
     * @return void
     * @throws InvalidConfigException
     */
    public function run()
    {
        try {
            $requestUri = $this->getUri();
            if(!empty($requestUri)) {
                list('route' => $route, 'parameter' => $param) = $this->getRouteByUri($requestUri);
                $this->execute($route, $param);
                return;
            } else {
                $this->execute($this->routes['home']);
                return;
            }
        } catch (HttpErrorException $e) {
            header("HTTP/1.1 404 Not Found");
            header("Status: 404");
            include ROOT.'/app/views/error.php';
            die();
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
     * Get route by request uri
     *
     * @param string $uri
     * @return array
     * @throws HttpErrorException
     */
    private function getRouteByUri(string $uri)
    {
        foreach ($this->routes as $pattern => $route) {
            if(preg_match("#^$pattern$#", $uri, $matches)) {
                $routeConfig['route'] = $route;
                $routeConfig['parameter'] = isset($matches[1]) ? $matches[1] : null;
                return $routeConfig;
            }
        }
        throw new HttpErrorException(404);
    }

    /**
     * Execute action of route
     *
     * @param string $route
     * @param mixed $param
     * @return void
     * @throws InvalidConfigException
     * @throws \Exception
     */
    private function execute(string $route, $param = null)
    {
        $segments = explode('/', strtolower($route));
        if (is_string($segments)) {
            throw new InvalidConfigException("Invalid routing configuration: route must contain controller name and action name");
        }
        $firstSegment = array_shift($segments);
        if (is_dir(ROOT.'/app/modules/'.$firstSegment)) {
            $controllerName = $firstSegment.'/'.ucfirst(array_shift($segments)).'Controller';
        } else {
            $controllerName = ucfirst($firstSegment).'Controller';
        }
        $controller = $this->controllerFactory->factory($controllerName);
        $action = array_shift($segments).'Action';
        $reflectedController = new ReflectionClass($controller);
        if ($reflectedController->hasMethod($action)) {
            $reflectedMethod = $reflectedController->getMethod($action);
            $countArgs = $reflectedMethod->getNumberOfParameters();
            if ($countArgs == 0 && $param == null) {
                $reflectedMethod->invoke($controller);
                return;
            } elseif ($countArgs == 1 && $param != null) {
                $reflectedMethod->invoke($controller, $param);
                return;
            }
            throw new \Exception("Incorrect number of parameters");
        }
        throw new \Exception("Method [$action] not declared in [".get_class($controller)."]");
    }
}