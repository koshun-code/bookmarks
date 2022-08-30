<?php

namespace BM\Model;

use PDO;
use PDOException;

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
    
        try {
            $dsn = "{$driver}:host={$host};dbname={$dbname}";
            $pdo = new PDO($dsn, $user, $password);
        } catch( PDOException $e){
            $e->getMessage();
        }
        return $pdo;
    }
}