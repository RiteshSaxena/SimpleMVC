<?php
// APP Dir
define("APP_DIR", dirname(dirname(__FILE__)));
define("VIEWS_DIR", APP_DIR . "/views");

// config
require_once "../config/config.php";

if (DEV_MODE) {
    ini_set("display_errors", 1);
    ini_set("display_startup_errors", 1);
    error_reporting(E_ALL);
}

// core libraries
require_once "Request.php";
require_once "Response.php";
require_once "Router.php";
require_once "Init.php";

// load database libraries
require_once "Database.php";
require_once "Model.php";

// load includes
require_once "../config/includes.php";
for($i = 0; $i < count($includes); $i++) {
    $file = APP_DIR . $includes[$i];
    if (file_exists($file)) {
        require_once $file;
    }
}

// load routes
require_once "../config/routes.php";

// Init Core Library
$init = new \Core\Init();
