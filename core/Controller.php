<?php
namespace Core;

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
    public function model(string $model): Model {
        // Require model file
        require_once APP_DIR . '/models/' . $model . '.php';

        // Instantiate model
        return new $model();
    }

    // cors
    public function cors(
        string $origin = '*',
        string $methods = 'PUT, PATCH, GET, POST, DELETE, OPTIONS',
        string $allowed_headers = 'Origin, X-Requested-With, Content-Type'
    ): void {
        header("Access-Control-Allow-Origin: $origin");
        header("Access-Control-Allow-Methods: $methods");
        header("Access-Control-Allow-Headers: $allowed_headers");
    }

    // remove powered by
    public function removed_powered_by(): void {
        header_remove('X-Powered-By');
    }
}
