<?php
// config
require_once "../config/config.php";

if (DEV_MODE) {
    ini_set("display_errors", 1);
    ini_set("display_startup_errors", 1);
    error_reporting(E_ALL);
}

// core libraries
require_once APP_DIR . "/core/Request.php";
require_once APP_DIR . "/core/Response.php";
require_once APP_DIR . "/core/Router.php";
require_once APP_DIR . "/core/Init.php";

// load database libraries
require_once APP_DIR . "/core/Database.php";
require_once APP_DIR . "/core/Model.php";

// load routes
require_once APP_DIR . "/config/routes.php";

// Init Core Library
$init = new \Core\Init();
