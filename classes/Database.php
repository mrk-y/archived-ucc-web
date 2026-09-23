<?php
class Database {
    private $host = "localhost";
    private $dbname = "ucc";
    private $username = "mky";
    private $userpass = "admin";

    public function getConnection() {
        $conn = null;

        try {
            $conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbname, $this->username, $this->userpass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            header("Location: ../404.php");
        }

        return $conn;
    }
}
