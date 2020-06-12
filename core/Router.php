<?php

namespace Core;

class Router {
    private static array $static_routes = [
        "GET" => [],
        "POST" => [],
        "PUT" => [],
        "PATCH" => [],
        "DELETE" => [],
        "OPTIONS" => [],
    ];

    private static array $dynamic_routes = [
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
        if (isset(self::$static_routes[$method][$url])) {
            $controller = self::$static_routes[$method][$url];
            return [$controller, $params];
        }

        // check for dynamic routes
        $url_array = explode("/", substr($url, 1));
        $url_array_len = count($url_array);

        foreach (self::$dynamic_routes[$method] as $route => $route_controller) {
            $matched = 1;
            $route_split = explode("/", substr($route, 1));

            if (count($route_split) != $url_array_len) {
                continue;
            }

            for ($i = 0; $i < count($route_split); $i++) {
                if ($route_split[$i][0] == ":") {
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
                $controller = $route_controller;
                break;
            }
        }
        
        return [$controller, $params];
    }

    public static function add(string $method, string $url, callable $controller): void {
        $dynamic = strpos($url, ":") !== false;
        if ($dynamic) {
            self::$dynamic_routes[$method][$url] = $controller;
        } else {
            self::$static_routes[$method][$url] = $controller;
        }
    }

    public static function get(string $url, callable $controller): void {
        self::add("GET", $url, $controller);
    }

    public static function post(string $url, callable $controller): void {
        self::add("POST", $url, $controller);
    }

    public static function put(string $url, callable $controller): void {
        self::add("PUT", $url, $controller);
    }

    public static function patch(string $url, callable $controller): void {
        self::add("PATCH", $url, $controller);
    }

    public static function delete(string $url, callable $controller): void {
        self::add("DELETE", $url, $controller);
    }

    public static function options(string $url, callable $controller): void {
        self::add("OPTIONS", $url, $controller);
    }
}
