<?php

namespace Core;

class Init {
    private Request $request;
    private Response $response;

    public function __construct() {
        $this->request = new Request();
        $this->response = new Response();
        $this->init_query();
        $this->load_body();
        list($controller, $this->request->params) = Router::getRoute($this->request->route);
        $this->load_defaults();
        $this->load_controller($controller);
    }

    public function init_query(): void {
        $basename = dirname($_SERVER["SCRIPT_NAME"]);
        if (substr($_SERVER["REQUEST_URI"], 0, strlen($basename)) === $basename) {
            $request_uri = substr($_SERVER["REQUEST_URI"], strlen($basename));
        } else {
            $request_uri = $_SERVER["REQUEST_URI"];
        }
        $request_uri_arr = explode("?", $request_uri);

        // process request uri
        $request_uri_cleaned = explode("/", trim($request_uri_arr[0]));
        for ($i = 0; $i < count($request_uri_cleaned); $i++) {
            if (empty($request_uri_cleaned[$i])) {
                unset($request_uri_cleaned[$i]);
            }
        }
        $request_uri_cleaned = array_values($request_uri_cleaned);
        $this->request->route = "/" . implode("/", $request_uri_cleaned);

        // process url query
        if (isset($request_uri_arr[1])) {
            parse_str($request_uri_arr[1], $this->request->query);
        }
    }

    public function load_body(): void {
        $body = [];
        if (!empty($_SERVER["CONTENT_TYPE"])) {
            $type = explode(";", $_SERVER["CONTENT_TYPE"])[0];
            $raw = file_get_contents("php://input");
            switch ($type) {
                case "application/json":
                    $body = json_decode($raw, true);
                    break;
                case "application/x-www-form-urlencoded":
                default:
                    $body = $_POST;
            }
        }
        $this->request->body = $body;
    }

    public function load_defaults(): void {
        if (REMOVE_POWERED_BY) {
            header_remove("X-Powered-By");
        }
        if (ENABLE_CORS) {
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Methods: PUT, PATCH, GET, POST, DELETE, OPTIONS");
            header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type");
        }
    }

    public function load_controller($controller): void {
        if (!$controller) {
            $this->response->render_error_page(404);
        }

        $controller($this->request, $this->response);
    }
}
