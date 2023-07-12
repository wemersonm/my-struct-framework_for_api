<?php

namespace app\models;

use PDO;
use PDOException;

class Connection
{
    private static ?Connection $instance = null;
    private PDO $connection;

    private function __construct()
    {
        $database = $_ENV['DATABASE_NAME'];
        $hostname = $_ENV['DATABASE_HOST'];
        $user = $_ENV['DATABASE_USER'];
        $password = $_ENV['DATABASE_PASS'];
        $charset = "utf8";

        $dsn = "mysql:host={$hostname}; dbname={$database}; charset={$charset}";
        $this->connection = new PDO($dsn, $user, $password);
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    public static function getInsance()
    {
        if (self::$instance == null) {
            self::$instance = new Connection();
        }
        return self::$instance;
    }
    public function getConnection()
    {
        return $this->connection;
    }
}
