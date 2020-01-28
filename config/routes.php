<?php
Router::get("/","MainController@index");
Router::get("/test","MainController@test_route");
Router::post("/test","MainController@test_route_post");
Router::get("/test_query","MainController@test_route_with_query");
Router::get("/test/:id","MainController@test_route_with_id");
Router::get("/test/json","MainController@test_route_with_json");
