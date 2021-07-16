<?php
require('vendor/autoload.php');
$dotenv = Dotenv\Dotenv::createImmutable('./');
$dotenv->load();
defined("DB_CONNECTION") or define('DB_CONNECTION', $_ENV['DB_CONNECTION']);
defined("DB_HOST") or define('DB_HOST', $_ENV['DB_HOST']);
defined("DB_DATABASE") or define('DB_DATABASE', $_ENV['DB_DATABASE']);
defined("DB_USERNAME") or define('DB_USERNAME', $_ENV['DB_USERNAME']);
defined("DB_PASSWORD") or define('DB_PASSWORD', $_ENV['DB_PASSWORD']);
defined("DB_PORT") or define('DB_PORT', $_ENV['DB_PORT']);