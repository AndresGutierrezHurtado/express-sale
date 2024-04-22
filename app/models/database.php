<?php

class Database {
    private $hostname;
    private $username;
    private $password;
    private $dbname;
    private $conn;

    // Constructor
    public function __construct() {
        require_once(__DIR__ . "/../config.php");
        $this->hostname = DB_HOSTNAME;
        $this->username = DB_USERNAME;
        $this->password = DB_PASSWORD;
        $this->dbname = DB_NAME;

        $this->conn = new mysqli($this->hostname, $this->username, $this->password, $this->dbname);

        if ($this->conn->connect_error) {
            die("Error de conexión: " . $this->conn->connect_error);
        }
    }

    public function getConnection() {
        return $this->conn;
    }

    public function closeConnection() {
        $this->conn->close();
    }

    public function isConnected() {
        return $this->conn->ping();
    }
}

