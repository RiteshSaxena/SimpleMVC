<?php

class Router {
    private static $static_routes = [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
        'PATCH' => [],
        'DELETE' => [],
        'OPTIONS' => [],
    ];
    private static $dynamic_routes = [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
        'PATCH' => [],
        'DELETE' => [],
        'OPTIONS' => [],
    ];

    public function getController($url) {
        $controller = "";
        $method = $_SERVER['REQUEST_METHOD'];

        // if its a static route
        if (isset(self::$static_routes[$method][$url])) {
            return self::$static_routes[$method][$url];
        }

        // check for dynamic routes
        $url_array = explode('/', $url);

        foreach (self::$dynamic_routes[$method] as $route => $route_controller) {
            $matched = 1;
            $route_split = explode('/', $route);

            if (count($route_split) != count($url_array)) {
                continue;
            }

            global $params;
            $params = [];
            for ($i = 0; $i < count($route_split); $i++) {
                if ($route_split[$i][0] == ':') {
                    $param_name = substr($route_split[$i], 1);
                    $params[$param_name] = $url_array[$i];
                    continue;
                }
                if ($route_split[$i] != $url_array[$i]) {
                    $matched = 0;
                    break;
                }
            }

            if ($matched == 1) {
                return $route_controller;
            }
        }
        return $controller;
    }

    public static function add($method, $url, $controller) {
        $dynamic = false;
        if (strpos($url, ':') !== false) {
            $dynamic = true;
        }
        if ($dynamic) {
            self::$dynamic_routes[$method][$url] = $controller;
        } else {
            self::$static_routes[$method][$url] = $controller;
        }
    }

    public static function get($url, $controller) {
        self::add('GET', $url, $controller);
    }

    public static function post($url, $controller) {
        self::add('POST', $url, $controller);
    }

    public static function put($url, $controller) {
        self::add('PUT', $url, $controller);
    }

    public static function patch($url, $controller) {
        self::add('PATCH', $url, $controller);
    }

    public static function delete($url, $controller) {
        self::add('DELETE', $url, $controller);
    }

    public static function options($url, $controller) {
        self::add('OPTIONS', $url, $controller);
    }
}
