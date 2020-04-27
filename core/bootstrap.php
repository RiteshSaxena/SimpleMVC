<?php
// config
require_once '../config/config.php';

if (ENABLE_ERROR_REPORTING) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

// core libraries
require_once APP_DIR . '/core/Controller.php';
require_once APP_DIR . '/core/Database.php';
require_once APP_DIR . '/core/Model.php';
require_once APP_DIR . '/core/Router.php';
require_once APP_DIR . '/core/Core.php';

// routes
require_once APP_DIR . '/config/routes.php';
