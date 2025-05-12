<?php
require_once __DIR__ . '/../config/db.php';

class WaterLevelModel {
    private ?PDO $conn;

    public function __construct() {
        $this->conn = (new Database())->getConnection();
    }

    public function getDataFollowDate(string $table_name, string $serial_number, string $date_begin, string $date_end): array {
        if (!$this->conn) return [];

        $sql = "SELECT id, serial_number, date_time, water_lever_0, water_lever_1, water_lever_2, vol 
                FROM $table_name 
                WHERE serial_number = :serial_number 
                AND date_time BETWEEN :date_begin AND :date_end";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":serial_number", $serial_number);
        $stmt->bindParam(":date_begin", $date_begin);
        $stmt->bindParam(":date_end", $date_end);
        $stmt->execute();

        return $stmt->fetchAll();
    }
        // Check if table exists in DB
    public function tableExists(string $table_name): bool {
        if (!$this->conn) return false;
        $stmt = $this->conn->prepare("SHOW TABLES LIKE :table");
        $stmt->bindParam(':table', $table_name);
        $stmt->execute();
        return (bool)$stmt->fetch();
    }

    // Check if serial exists in table
    public function serialExists(string $table_name, string $serial_number): bool {
        if (!$this->conn) return false;
        $sql = "SELECT 1 FROM {$table_name} WHERE serial_number = :serial_number LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':serial_number', $serial_number);
        $stmt->execute();
        return (bool)$stmt->fetch();
    }
    // New function using polymorphism to fetch limited number of entries from a date
    public function getDataFollowNumber(string $table_name,string $serial_number, string $date_begin, int $numberOfValues): array {
        if (!$this->conn) return [];

        $sql = "SELECT id, serial_number, date_time, water_lever_0, water_lever_1, water_lever_2, vol 
                FROM $table_name 
                WHERE serial_number = :serial_number 
                AND date_time >= :date_begin 
                ORDER BY date_time ASC 
                LIMIT :limit";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":serial_number", $serial_number);
        $stmt->bindParam(":date_begin", $date_begin);
        $stmt->bindValue(":limit", $numberOfValues, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
?>