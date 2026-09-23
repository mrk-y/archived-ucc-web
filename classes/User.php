<?php
class User {
    private $conn;
    private $table_name = 'users';

    private $id;
    private $username;
    private $password;
    private $role;
    private $active;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getRole() {
        return $this->role;
    }

    public function setRole($role) {
        $this->role = $role;
    }

    public function create() {
        if (empty($this->username) || empty($this->password) || empty($this->role)) {
            echo 'username, password, or role empty';
            return false;
        }

        try {
            $sql = 'SELECT username FROM ' . $this->table_name . ' WHERE username = :username';
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':username', $this->username);

            $stmt->execute();
            $user_exists = $stmt->fetch();

            if ($user_exists) {
                // username alredy exists
                echo 'Error: username alredy exists<br>';
                return false;
            }

            $sql = 'INSERT INTO ' . $this->table_name . ' (username, password, role) 
                VALUES (:username, :password, :role)';
            $stmt = $this->conn->prepare($sql);

            $this->username = htmlspecialchars(strip_tags($this->username));
            $this->password = password_hash($this->password, PASSWORD_BCRYPT);
            $this->role = htmlspecialchars(strip_tags($this->role));
        
            $stmt->bindParam(':username', $this->username);
            $stmt->bindParam(':password', $this->password);
            $stmt->bindParam(':role', $this->role);
        
            return $stmt->execute();
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage() . '<br>';
            header('Location: ../404.php');
        }
    }

    public function login() {
        if (empty($this->username) || empty($this->password)) {
            echo 'Error: username or password empty<br>';
            return false;
        }

        try {
            $sql = 'SELECT * FROM ' . $this->table_name . ' WHERE username = :username';
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':username', $this->username);

            $stmt->execute();
            $query_result = $stmt->fetchAll();

            if (!$query_result) {
                // user doesn\'t exist
                echo 'Error: username doesn\'t exists<br>';
                return false;
            }

            if (!password_verify($this->password, $query_result[0]['password'])) {
                // incorrect password
                echo 'Error: incorrect password<br>';
                return false;
            }

            $this->id = $query_result[0]['id'];
            $this->username = $query_result[0]['username'];
            $this->password = $query_result[0]['password'];
            $this->role = $query_result[0]['role'];
            $this->active = $query_result[0]['active'];

            echo 'logging in!<br>';
            return true;

        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            header('Location: ../404.php');
        }
    }




}
