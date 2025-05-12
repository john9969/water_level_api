<?php
// /api_project/config/db.php
class Database {
    private string $host = "localhost";
    private string $db_name = "don62637_water_lever";
    private string $username = "root";
    private string $password = "";
    private ?PDO $conn = null;

    public function getConnection(): ?PDO {
        if ($this->conn === null) {
            try {
                $this->conn = new PDO("mysql:host={$this->host};dbname={$this->db_name}",
                    $this->username, $this->password, [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                    ]);
                $this->conn->exec("SET NAMES utf8");
            } catch (PDOException $e) {
                error_log("Connection error: " . $e->getMessage());
                return null;
            }
        }
        return $this->conn;
    }
}


