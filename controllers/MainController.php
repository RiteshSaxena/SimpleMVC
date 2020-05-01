<?php
namespace App;

use \Core\Controller;
use \Core\Request;
use \Core\Response;

class MainController extends Controller {
    // Route /
    // Method GET
    public function index(Request $req, Response $res){
        $res->render('index');
    }

    // Route /test
    // Method POST
    public function test_route_post(Request $req, Response $res) {
        $res->render('test_route_with_id', ['id' => $req->body['id']]);
    }

    // Route /test/:id
    // Method GET
    public function test_route_with_id(Request $req, Response $res) {
        $res->render('test_route_with_id', ['id' => $req->params['id']]);
    }

    // Route /test_query?id=3
    // Method GET
    public function test_route_with_query(Request $req, Response $res) {
        $res->render('test_route_with_id', ['id' => $req->query['id']]);
    }

    // Route /test/json
    // Method GET
    public function test_route_with_json(Request $req, Response $res) {
        $json = [
            'success' => true,
            'sample_data' => 'hello world'
        ];
        $res->status(200);
        $res->json($json);
    }
}
