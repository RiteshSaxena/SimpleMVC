<?php
class MainController extends Controller {
    function __construct(){
    }

    public function index(){
        $this->view('index');
    }

    public function test_route() {
        $this->view('test_route');
    }

    public function test_route_with_var($var) {
        $this->view('test_route_with_var', ['id' => $var]);
    }

    // this route will output the get_data (url) into json format
    public function test_route_with_json() {
        global $get_data;
        $this->json_response(200, '$_GET Data', $get_data);
    }
}
