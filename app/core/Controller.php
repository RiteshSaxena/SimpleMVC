<?php
class Controller{
    // Call a method by name
    public function call_by_method_name($method, $data = []){
        if (method_exists($this, $method)) {
            call_user_func_array(array($this,$method), $data);
        } else {
            http_response_code(404);
            die("Error 404 - $method function not found");
        }
    }

    // Load model
    public function model($model){
        // Require model file
        require_once APP_ROOT . '/models/' . $model . '.php';

        // Instatiate model
        return new $model();
    }
    // Load view
    public function view($view, $data = []){
        // Check for view file
        $view_file = APP_ROOT. '/views/' . $view . '.php';
        if(file_exists($view_file)){
            require_once $view_file;
        } else {
            http_response_code(404);
            die("Error 404 - View $view does not exist");
        }
    }

    // redirect
    public function redirect($url, $external = false){
        if($external)
            header("location: $url");
        else{
            if ($url == "/" )
                header("location:" . URL_ROOT . "/");
            else
                header("location:" . URL_ROOT . "/" .$url);
        }
        die();
    }

    // response
    public function json_response($code, $message, $data = []){
        $response = [
            "status" => $code,
            "message" => $message,
            "data" => $data
        ];
        echo json_encode($response);
    }
}
