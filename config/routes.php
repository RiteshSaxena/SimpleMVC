<?php
use Core\Router;

require APP_DIR . "/controllers/MainController.php";

Router::get("/", App\MainController::index());
Router::post("/test", App\MainController::test_route_post());
Router::get("/test_query", App\MainController::test_route_with_query());
Router::get("/test/json", App\MainController::test_route_with_json());
Router::get("/test/:id", App\MainController::test_route_with_id());
