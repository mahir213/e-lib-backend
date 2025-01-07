<?php
class User {
    private $conn;
    private $table = 'users';

    public $id;
    public $username;
    public $email;
    public $avatar_url;
    public $password_hash;
    public $full_name;
    public $created_at;
    public $is_admin;
    public $password; // Added missing property

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = 'INSERT INTO ' . $this->table . ' SET username = :username, email = :email, password_hash = :password_hash';

        $stmt = $this->conn->prepare($query);

        $this->password_hash = password_hash($this->password, PASSWORD_BCRYPT);

        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password_hash', $this->password_hash);

        if ($stmt->execute()) {
            return true;
        }

        error_log("Error: " . implode(" ", $stmt->errorInfo()));

        return false;
    }

    public function updateProfile() {
        $query = "UPDATE users SET username = :username, full_name = :full_name, email = :email, avatar_url = :avatar_url WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':full_name', $this->full_name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':avatar_url', $this->avatar_url);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function verifyPassword($password) {
        $query = "SELECT password_hash FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return password_verify($password, $row['password_hash']);
    }

    public function updatePassword() {
        $hashedPassword = password_hash($this->password, PASSWORD_BCRYPT);
        $query = "UPDATE users SET password_hash = :password WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':id', $this->id);
        if ($stmt->execute()) {
            return true;
        } else {
            error_log("Error updating password: " . implode(" ", $stmt->errorInfo()));
            return false;
        }
    }

    public function changeUsername($newUsername) {
        $query = "UPDATE users SET username = :username WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $newUsername);
        $stmt->bindParam(':id', $this->id);
        if ($stmt->execute()) {
            return true;
        } else {
            error_log("Error updating username: " . implode(" ", $stmt->errorInfo()));
            return false;
        }
    }

    public function changeEmail($newEmail) {
        $query = "UPDATE users SET email = :email WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $newEmail);
        $stmt->bindParam(':id', $this->id);
        if ($stmt->execute()) {
            return true;
        } else {
            error_log("Error updating email: " . implode(" ", $stmt->errorInfo()));
            return false;
        }
    }

    public function deleteUser() {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function getUsers() {
        $query = 'SELECT id, username, email, avatar_url, full_name, created_at, is_admin FROM ' . $this->table;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }
}
?>
