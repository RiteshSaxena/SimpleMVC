<?php
namespace Core;

class Response {
    // Load view
    public function render(string $view, array $data = []) {
        extract($data);
        // Check for view file
        $view_file = APP_DIR . '/views/' . $view . '.php';
        if (file_exists($view_file)) {
            require_once $view_file;
        } else {
            $this->status(404);
            die("Error 404 - View $view does not exist");
        }
    }

    // Load view
    public function render_error_page(int $error_code, string $error_msg = "") {
        // Check for view file
        $view_file = APP_DIR . '/views/errors/' . $error_code . '.php';
        $this->status($error_code);
        if (file_exists($view_file)) {
            require_once $view_file;
            die();
        } else {
            die("Error $error_code");
        }
    }

    // set headers
    public function header(string $name, string $value) {
        header("$name: $value");
    }

    // Set response code
    public function status(int $status_code) {
        http_response_code($status_code);
    }

    // JSON
    public function json(array $data) {
        $this->header('Content-Type', 'application/json; charset=utf-8');
        echo json_encode($data);
        die();
    }
}