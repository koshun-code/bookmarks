<?php

namespace BM\Model;

use PDO;

class DBConnect
{
    private $config;

    public function __construct($path = './../config/db.php')
    {
         $this->config = require $path;
    }

    public function setConnection(): PDO
    {

        [ 
            'driver' => $driver,
            'host' => $host,
            'dbname' => $dbname,
            'user' => $user,
            'password' => $password
        ] = $this->config;
    
        $dsn = "{$driver}:host={$host};dbname={$dbname}";
        $pdo = new PDO($dsn, $user, $password);
        return $pdo;
    }
}