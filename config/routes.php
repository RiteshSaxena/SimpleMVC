<?php
use Core\Router;

Router::get("/", [
    \App\MainController::index(),
    function (\Core\Request $req, \Core\Response $res) {
        echo "Hello";
    }
]);
Router::post("/test", \App\MainController::test_route_post());
Router::get("/test_query", \App\MainController::test_route_with_query());
Router::get("/test/json", \App\MainController::test_route_with_json());
Router::get("/test/:id", \App\MainController::test_route_with_id());
