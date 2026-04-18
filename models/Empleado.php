<?php
require_once dirname(__DIR__) . '/config/Database.php';

class Empleado {
    private $conn;
    private $table = 'empleado';

    public $id;
    public $nombre;
    public $apellido;
    public $dni;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    // READ ALL
    public function getAll(): array {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // READ ONE
    public function getById(int $id): array|false {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE id = :id LIMIT 1");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    // CREATE
    public function create(): bool {
        $sql = "INSERT INTO {$this->table} (nombre, apellido, dni) VALUES (:nombre, :apellido, :dni)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nombre',   $this->nombre);
        $stmt->bindParam(':apellido', $this->apellido);
        $stmt->bindParam(':dni',      $this->dni);
        return $stmt->execute();
    }

    // UPDATE
    public function update(): bool {
        $sql = "UPDATE {$this->table} SET nombre=:nombre, apellido=:apellido, dni=:dni WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nombre',   $this->nombre);
        $stmt->bindParam(':apellido', $this->apellido);
        $stmt->bindParam(':dni',      $this->dni);
        $stmt->bindParam(':id',       $this->id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // DELETE
    public function delete(int $id): bool {
        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // SEARCH
    public function search(string $query): array {
        $q = "%{$query}%";
        $sql = "SELECT * FROM {$this->table}
                WHERE nombre LIKE :q OR apellido LIKE :q OR dni LIKE :q
                ORDER BY id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':q', $q);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
