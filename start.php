<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
$method = $_SERVER['REQUEST_METHOD'];
if ($method == "OPTIONS") {
    die();
}
require 'Configuracion/configBD.php';
require 'vendor/autoload.php';
require 'app/Middleware/JwtMiddleware.php';
require 'app/Middleware/StartSession.php';
require 'Configuracion/JWT/config.php';

use Models\Database;

new Database();