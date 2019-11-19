<?php
Router::add("/","MainController@index");
Router::add("/test_route","MainController@test_route");
Router::add("/test_route/{var}","MainController@test_route_with_var");
Router::add("/test_route_with_json","MainController@test_route_with_json");
