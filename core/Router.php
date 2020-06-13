<?php

namespace Core;

class Router {
    private static array $routes = [
        "GET" => [],
        "POST" => [],
        "PUT" => [],
        "PATCH" => [],
        "DELETE" => [],
        "OPTIONS" => [],
    ];

    public static function getRoute(string $url): array {
        $controller = null;

        $params = [];
        $method = $_SERVER["REQUEST_METHOD"];

        // if its a static route
        if (isset(self::$routes[$method][$url])) {
            $controller = self::$routes[$method][$url];
            return [true, $controller, $params];
        }

        // check for dynamic routes
        $url_array = explode("/", substr($url, 1));
        $url_array_len = count($url_array);

        $matched = false;
        foreach (self::$routes[$method] as $route => $route_controller) {
            $route_split = explode("/", substr($route, 1));

            if (count($route_split) != $url_array_len) {
                continue;
            }

            $matched = true;
            for ($i = 0; $i < count($route_split); $i++) {
                if ($route_split[$i][0] == ":") {
                    $param_name = substr($route_split[$i], 1);
                    $params[$param_name] = $url_array[$i];
                    continue;
                }
                if ($route_split[$i] != $url_array[$i]) {
                    $matched = false;
                    break;
                }
            }

            if ($matched) {
                $controller = $route_controller;
                break;
            }
        }
        
        return [$matched, $controller, $params];
    }

    public static function add(string $method, string $url, $controller): void {
        self::$routes[$method][$url] = $controller;
    }

    public static function get(string $url, $controller): void {
        self::add("GET", $url, $controller);
    }

    public static function post(string $url, $controller): void {
        self::add("POST", $url, $controller);
    }

    public static function put(string $url, $controller): void {
        self::add("PUT", $url, $controller);
    }

    public static function patch(string $url, $controller): void {
        self::add("PATCH", $url, $controller);
    }

    public static function delete(string $url, $controller): void {
        self::add("DELETE", $url, $controller);
    }

    public static function options(string $url, $controller): void {
        self::add("OPTIONS", $url, $controller);
    }
}
