<?php

class Database
{
    private $hostname;
    private $username;
    private $password;
    private $dbname;
    private $conn;

    // Constructor
    public function __construct()
    {
        $this->hostname = DB_HOSTNAME;
        $this->username = DB_USERNAME;
        $this->password = DB_PASSWORD;
        $this->dbname = DB_NAME;

        try {
            $this->conn = new PDO("mysql:host={$this->hostname};dbname={$this->dbname}", $this->username, $this->password);
            // set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function getConnection()
    {
        return $this->conn;
    }

    public function closeConnection()
    {
        $this->conn = null;
    }
}
