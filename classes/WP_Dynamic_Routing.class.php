<?php

namespace WP_Dynamic_Routing;

if(!defined('ABSPATH'))
    exit;

class WP_Dynamic_Routing {

    private static $allowed_methods = ['GET', 'POST'];
    private static $instance = null;
    private $registered_routes = [];

    public static function get_instance() {
        if (self::$instance == null)
            self::$instance = new self();

        return self::$instance;
    }

    private function __construct() {
        $this->init_hooks();
    }

    private function __clone() {}

    private function __wakeup() {}

    public function template_redirect() {

        $request_method = filter_input( \INPUT_SERVER, 'REQUEST_METHOD', \FILTER_SANITIZE_SPECIAL_CHARS );
        $request_path = explode('?', $_SERVER['REQUEST_URI'])[0];

        return $this->dispatch_request($request_method, $request_path);
    }

    public function add_route(string $method, string $path, mixed $callback) {
        $method = strtoupper($method);
        
        if(!in_array($method, self::$allowed_methods))
            return false;
        
        $existing_routes = $this->getRegisteredRoutes();
        
        foreach($existing_routes as $existing_route) {
            if($existing_route->getMethod() === $method && $existing_route->getPath() === $path)
                return false;
        }

        $route = new WP_Dynamic_Route($method, $path, $callback);
        $this->registered_routes[$route->getPath()] = $route; 
        return true;
    }

    public function getRegisteredRoutes() {
        return $this->registered_routes;
    }

    private function init_hooks() {
        add_action('template_redirect', [$this, 'template_redirect'], 99);
    }

    private function dispatch_request(string $method, string $path) {

        if(!in_array($method, self::$allowed_methods))
            return true;

        $existing_routes = $this->getRegisteredRoutes();
        $route = null;
        $params = [];
    
        foreach($existing_routes as $existing_route) {

            if($existing_route->getMethod() != $method)
                return false;

            if(!$this->request_matches($existing_route->getPath(), $path, $params))
                continue;

            $route = $existing_route;
        }


        if(!$route)
            return true;
        
        foreach($params as $key => $val) {
            if($method === 'GET') {
                $_GET[$key] = $val;
            } else {
                $_POST[$key] = $val;
            }
        }

        $callback = $route->getCallback();

        if(is_array($callback) && count($callback) == 2) {
            $class = $callback[0];
            $method = $callback[1];

            if(!class_exists($class)) 
                return false;

            if(!method_exists($class, $method) || !is_callable([$class, $method]))
                return false;
        
            call_user_func([$class, $method], $params);
            exit;
        }

        if(is_string($callback) && is_callable($callback)) {
            call_user_func($callback, $params);
            exit;
        }

        if ($callback instanceof \Closure) {
            $callback($params);
            exit;
        }

        return false;
    }

    private function request_matches($route_path, $request_path, &$params) {
        if($route_path === $request_path)
            return true;
        
        $route_regex = preg_replace('/\{\{(\w+)\}\}/', '(?P<$1>[^/]+)', $route_path);
        $route_regex = str_replace('/', '\/', $route_regex);
        $route_regex = '/^' . $route_regex . '$/';

        if(!preg_match($route_regex, $request_path, $matches))
            return false;
    
        foreach ($matches as $key => $value) {
            if (!is_numeric($key))
                $params[$key] = $value;
        }

        return true;
    }
}

