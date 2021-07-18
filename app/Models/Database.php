<?php

namespace Models;

use Illuminate\Database\Capsule\Manager as Capsule;

class Database
{

    function __construct()
    {
        date_default_timezone_set('America/Mexico_City');
        $capsule = new Capsule;
        $capsule->addConnection([
            'driver' => DB_CONNECTION,
            'host' => DB_HOST,
            'database' => DB_DATABASE,
            'username' => DB_USERNAME,
            'password' => DB_PASSWORD,
            'port' => DB_PORT,
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ]);
        $capsule->bootEloquent();
    }

}