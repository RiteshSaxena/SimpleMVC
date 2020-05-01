<?php
// App
define("APP_NAME", "Minimal-PHP");
define("APP_DIR", dirname(dirname(__FILE__)));
define("APP_VERSION", "2.1");
define("APP_URL", "http://localhost");

// Enable cors
define('ENABLE_CORS', false);

// Removed Powered-by Header
define('REMOVE_POWERED_BY', false);

// Enable Errors
define('ERROR_REPORTING', false);

// Dev mode
define('DEV_MODE', false);

// Database
define("DB_DRIVER", "mysql"); // mysql, pgsql, etc
//define("DB_PORT", 3306); // if usually a non default port
define("DB_HOST", "localhost");
define("DB_USER", "user");
define("DB_PASSWORD", "password");
define("DB_NAME", "dbname");
