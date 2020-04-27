<?php

class Controller {
    public function __construct() {
        if (ENABLE_CORS) {
            $this->cors();
        }
        if (REMOVE_POWERED_BY) {
            $this->removed_powered_by();
        }
    }

    // Load model
    public function model($model) {
        // Require model file
        require_once APP_DIR . '/models/' . $model . '.php';

        // Instantiate model
        return new $model();
    }

    // Load view
    public function view($view, $data = []) {
        extract($data);
        // Check for view file
        $view_file = APP_DIR . '/views/' . $view . '.php';
        if (file_exists($view_file)) {
            require_once $view_file;
        } else {
            http_response_code(404);
            die("Error 404 - View $view does not exist");
        }
    }

    // redirect
    public function redirect($url, $permanent = false, $external = false) {
        if ($permanent) {
            $this->status(302);
        } else {
            $this->status(301);
        }
        if ($external)
            header("location: $url");
        else {
            header("location: " . APP_URL . $url);
        }
        die();
    }

    // cors
    public function cors(
        $origin = '*',
        $methods = 'PUT, PATCH, GET, POST, DELETE, OPTIONS',
        $allowed_headers = 'Origin, X-Requested-With, Content-Type'
    ) {
        header("Access-Control-Allow-Origin: $origin");
        header("Access-Control-Allow-Methods: $methods");
        header("Access-Control-Allow-Headers: $allowed_headers");
    }

    // remove powered by
    public function removed_powered_by() {
        header_remove('X-Powered-By');
    }

    // Set response code
    public function status($status_code) {
        http_response_code($status_code);
    }

    // JSON
    public function json($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        die();
    }

    public function asset_version() {
        return "?version=" . APP_VERSION;
    }
}
