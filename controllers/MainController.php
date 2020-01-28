<?php
class MainController extends Controller {
    public function __construct(){
        parent::__construct();
    }

    // Route /
    // Method GET
    public function index(){
        $this->view('index');
    }

    // Route /test
    // Method GET
    public function test_route() {
        $this->view('test_route');
    }

    // Route /test
    // Method POST
    public function test_route_post() {
        global $body;
        $this->view('test_route_with_id', ['id' => $body['id']]);
    }

    // Route /test/:id
    // Method GET
    public function test_route_with_id() {
        global $params;
        $this->view('test_route_with_id', ['id' => $params['id']]);
    }

    // Route /test_query?id=3
    // Method GET
    public function test_route_with_query() {
        global $query;
        $this->view('test_route_with_id', ['id' => $query['id']]);
    }

    // Route /test/json
    // Method GET
    public function test_route_with_json() {
        $json = [
            'success' => true,
            'sample_data' => 'hello world'
        ];
        $this->status(200);
        $this->json($json);
    }
}
