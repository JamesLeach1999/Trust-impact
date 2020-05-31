<?php
class Database {
    // DB paramas
    private $host = "localhost";
    private $db_name = "trust";
    private $username = "USERNAME";
    private $password = "PASSWORD";
    private $conn;

    // db connect

    public function connect(){
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch(PDOException $e){
            echo "connection error" . $e->getMessage();
        }
        return $this->conn;
    }
}