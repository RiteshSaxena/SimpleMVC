<?php
class Core {
    private $request_uri = "";

    public function __construct() {
        $this->init_query();
        $this->load_body();
        $router = new Router();
        $controller = $router->getController($this->request_uri);
        $this->load_controller($controller);
    }

    public function init_query() {
        $basename = dirname($_SERVER['SCRIPT_NAME']);
        $uri = explode("?", $_SERVER['REQUEST_URI']);
        if ($basename != '/') {
            $uri = explode("?", str_replace($basename, "", $_SERVER['REQUEST_URI']));
        }

        // process request uri
        $request_uri = explode('/', $uri[0]);
        $request_length = count($request_uri);
        for ($i=0; $i < $request_length; $i++) {
            if (empty($request_uri[$i])) {
                unset($request_uri[$i]);
            }
        }

        $this->request_uri = '/' . implode('/', $request_uri);

        // process url query
        global $query;
        $query = [];
        if (isset($uri[1])) {
            parse_str($uri[1], $query);
        }
    }

    public function load_body() {
        global $body;
        $body = [];
        if (!empty($_SERVER['CONTENT_TYPE'])) {
            $raw = file_get_contents('php://input');
            switch ($_SERVER['CONTENT_TYPE']) {
                case 'application/json':
                    $body = json_decode($raw, true);
                    break;
                case 'application/x-www-form-urlencoded':
                    parse_str($raw, $body);
                    break;
            }
        }
    }

    public function load_controller($controller_string) {
        if ($controller_string == "") {
            http_response_code(404);
            die("Error 404 - Page not found");
        }

        list($controller_name, $method_name) = explode("@", $controller_string);

        $controller_path = APP_DIR. '/controllers/' . $controller_name . '.php';

        if (file_exists($controller_path)) {
            require_once $controller_path;
            $controller = new $controller_name;
            if (method_exists($controller, $method_name)) {
                $controller->$method_name();
            } else {
                http_response_code(404);
                die("Error 404 - $method_name function not found");
            }
        } else {
            http_response_code(404);
            die("Error 404 - {$controller_name} not found");
        }
    }
}
