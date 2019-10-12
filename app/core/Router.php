<?php
class Router{
    private static $static_routes = [];
    private static $dynamic_routes = [];

    public function __construct(){
        // static routes
    }

    public function getController($url){
        $controller['controller'] = '';
        $controller['data'] = [];

        // if its a static route
        if(isset(self::$static_routes[$url])) {
            $controller['controller'] = self::$static_routes[$url];
            return $controller;
        }

        // check for dynamic routes
        $url_array = explode('/',$url);

        foreach (self::$dynamic_routes as $route => $route_controller) {
            $matched = 1;
            $route_split = explode('/', $route);
            if(count($route_split) != count($url_array)){
                $matched = 0;
                continue;
            }
            $data = [];
            for($i = 0; $i < count($route_split); $i++){
                if($route_split[$i] == '{var}'){
                    $data[] = $url_array[$i];
                    continue;
                }
                if($route_split[$i] != $url_array[$i]){
                    $matched = 0;
                    break;
                }
            }

            if($matched == 1){
                $controller['controller'] = $route_controller;
                $controller['data'] = $data;
                return $controller;
            }
        }
        return $controller;
    }
    public static function add($url,$controller){
        $dynamic = false;
        if (strpos($url, '{var}') !== false) {
            $dynamic = true;
        }
        if($dynamic){
            self::$dynamic_routes[$url] = $controller;
        }else{
            self::$static_routes[$url] = $controller;
        }
    }
}
