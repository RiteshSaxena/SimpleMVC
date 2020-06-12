<?php
namespace App;

use \Core\Request;
use \Core\Response;

class MainController {
    // Route /
    // Method GET
    public static function index(): callable {
        return function (Request $req, Response $res) {
            $res->render("index");
        };
    }

    // Route /test
    // Method POST
    public static function test_route_post(): callable {
        return function (Request $req, Response $res) {
            $res->render("test_route_with_id", ["id" => $req->body["id"]]);
        };
    }

    // Route /test/:id
    // Method GET
    public static function test_route_with_id(): callable {
        return function (Request $req, Response $res) {
            $res->render("test_route_with_id", [
                "id" => $req->params["id"]
            ]);
        };

    }

    // Route /test_query?id=3
    // Method GET
    public static function test_route_with_query(): callable {
        return function (Request $req, Response $res) {
            $res->render("test_route_with_id", [
                "id" => $req->query["id"]
            ]);
        };
    }

    // Route /test/json
    // Method GET
    public static function test_route_with_json() {
        return function (Request $req, Response $res) {
            $json = [
                "success" => true,
                "sample_data" => "hello world"
            ];
            $res->status(200);
            $res->json($json);
        };
    }
}
