<?php
class Database {
    private $host = "localhost";
    private $dbname = "ucc";
    private $username = "mky";
    private $userpass = "admin";
    private $conn;

    public function getConnection() {
        $conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $host . ";dbname=" . $dbname . "," . $username . "," . $userpass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            header("/index.php");
        }
    }
}
