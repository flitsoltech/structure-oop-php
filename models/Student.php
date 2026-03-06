<?php

require_once __DIR__ . '/../config/Database.php';
 
interface CRUDInterface
{
    public function getAll(): array;
    public function getById(int $id): ?array;
    public function create(array $data): bool;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
}
 
abstract class BaseModel
{
    protected mysqli $db;
    protected string $table;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }
 
    protected function runQuery(string $sql, string $types = '', array $params = []): mysqli_stmt|false
    {
        $stmt = $this->db->prepare($sql);
        if (!$stmt) return false;

        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        return $stmt;
    }
 
    protected function fetchAll(string $sql, string $types = '', array $params = []): array
    {
        $stmt = $this->runQuery($sql, $types, $params);
        if (!$stmt) return [];
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
 
    protected function fetchOne(string $sql, string $types = '', array $params = []): ?array
    {
        $stmt = $this->runQuery($sql, $types, $params);
        if (!$stmt) return null;
        $result = $stmt->get_result();
        $row    = $result->fetch_assoc();
        return $row ?: null;
    }
 
    protected function execute(string $sql, string $types = '', array $params = []): bool
    {
        $stmt = $this->runQuery($sql, $types, $params);
        return $stmt !== false;
    }
}
 
class Student extends BaseModel implements CRUDInterface
{

    // Encapsulation — private properties
    private string $name;
    private string $email;
    private string $course;
    private int    $age;

    public function __construct()
    {
        parent::__construct();
        $this->table = 'students';
    }
 
    public function getName(): string
    {
        return $this->name;
    }
    public function getEmail(): string
    {
        return $this->email;
    }
    public function getCourse(): string
    {
        return $this->course;
    }
    public function getAge(): int
    {
        return $this->age;
    }
 
    public function setName(string $name): void
    {
        $this->name   = trim($name);
    }
    public function setEmail(string $email): void
    {
        $this->email  = trim($email);
    }
    public function setCourse(string $course): void
    {
        $this->course = trim($course);
    }
    public function setAge(int $age): void
    {
        $this->age    = $age;
    } 

    public function getAll(): array
    {
        return $this->fetchAll("SELECT * FROM {$this->table} ORDER BY id DESC");
    }

    public function getById(int $id): ?array
    {
        return $this->fetchOne(
            "SELECT * FROM {$this->table} WHERE id = ?",
            'i',
            [$id]
        );
    }

    public function create(array $data): bool
    {
        $sql = "INSERT INTO {$this->table} (name, email, course, age) VALUES (?, ?, ?, ?)";
        return $this->execute($sql, 'sssi', [
            $data['name'],
            $data['email'],
            $data['course'],
            $data['age'],
        ]);
    }

    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE {$this->table} SET name=?, email=?, course=?, age=? WHERE id=?";
        return $this->execute($sql, 'sssii', [
            $data['name'],
            $data['email'],
            $data['course'],
            $data['age'],
            $id,
        ]);
    }

    public function delete(int $id): bool
    {
        return $this->execute(
            "DELETE FROM {$this->table} WHERE id=?",
            'i',
            [$id]
        );
    }
 
    public function search(string $keyword): array
    {
        $kw = "%{$keyword}%";
        return $this->fetchAll(
            "SELECT * FROM {$this->table} WHERE name LIKE ? OR course LIKE ?",
            'ss',
            [$kw, $kw]
        );
    }
}
