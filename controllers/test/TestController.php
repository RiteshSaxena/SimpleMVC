<?php
namespace App\test;

use \Core\Controller;
use \Core\Request;
use \Core\Response;

// Controller under a namespace
class TestController extends Controller {
    // Route /test
    // Method GET
    public function test_route(Request $req, Response $res){
        $res->render("index");
    }
}
