<?php
// App
define("APP_NAME", "Minimal-PHP");
define("APP_DIR", dirname(dirname(__FILE__)));
define("APP_VERSION", "3.0");
define("APP_URL", "http://localhost");

// Enable cors
define("ENABLE_CORS", true);

// Removed Powered-by Header
define("REMOVE_POWERED_BY", true);

// Dev mode
define("DEV_MODE", true);

// Database
define("DB_DRIVER", "pgsql"); // mysql, pgsql, etc
//define("DB_PORT", 3306); // if usually a non default port
define("DB_HOST", "localhost");
define("DB_USER", "ritesh");
define("DB_PASSWORD", "password");
define("DB_NAME", "newdb");
