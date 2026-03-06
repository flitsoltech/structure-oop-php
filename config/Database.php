<?php

class Database {
    private static ?Database $instance = null;
    private mysqli $connection;
 
    private string $host     = 'localhost';
    private string $dbname   = 'student_db';
    private string $username = 'root';
    private string $password = '';
 
    private function __construct() {
        $this->connection = new mysqli(
            $this->host,
            $this->username,
            $this->password,
            $this->dbname
        );

        if ($this->connection->connect_error) {
            die("❌ DB Connection Failed: " . $this->connection->connect_error);
        }

        $this->connection->set_charset('utf8mb4');
    }
 
    public static function getInstance(): Database {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection(): mysqli {
        return $this->connection;
    }
 
    private function __clone() {}
    public function __wakeup() {}

    
}