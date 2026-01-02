<?php

declare(strict_types=1);

namespace App\Models;

use Core\Database;
use PDO;

/**
 * User Model
 * 
 * Handles all user-related database operations with secure practices.
 * 
 * @package App\Models
 * @author Anderson
 * @version 2.0.0
 */
class User
{
    /**
     * @var PDO Database connection
     */
    private PDO $db;

    /**
     * @var string Table name
     */
    private const TABLE = 'userdata';

    /**
     * User constructor
     */
    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Find user by ID
     * 
     * @param int $id User ID
     * @return array|null User data or null if not found
     */
    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT UserId, Username, Fullname, Email, status 
             FROM " . self::TABLE . " 
             WHERE UserId = :id"
        );
        $stmt->execute(['id' => $id]);
        
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Find user by username
     * 
     * @param string $username Username
     * @return array|null User data or null if not found
     */
    public function findByUsername(string $username): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM " . self::TABLE . " WHERE Username = :username"
        );
        $stmt->execute(['username' => strtolower($username)]);
        
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Find user by email
     * 
     * @param string $email User email
     * @return array|null User data or null if not found
     */
    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM " . self::TABLE . " WHERE Email = :email"
        );
        $stmt->execute(['email' => $email]);
        
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Authenticate user with username and password
     * 
     * @param string $username Username
     * @param string $password Plain text password
     * @return array|null User data if authenticated, null otherwise
     */
    public function authenticate(string $username, string $password): ?array
    {
        $user = $this->findByUsername($username);
        
        if ($user === null) {
            return null;
        }

        // Verify password with hash
        if (password_verify($password, $user['Pass'])) {
            // Remove password from returned data
            unset($user['Pass']);
            return $user;
        }

        // Legacy: Check plain text password for migration
        if ($user['Pass'] === $password) {
            // Update to hashed password
            $this->updatePassword($user['UserId'], $password);
            unset($user['Pass']);
            return $user;
        }

        return null;
    }

    /**
     * Create new user
     * 
     * @param array $data User data
     * @return int|false New user ID or false on failure
     */
    public function create(array $data): int|false
    {
        // Check if username or email already exists
        if ($this->findByUsername($data['username']) || $this->findByEmail($data['email'])) {
            return false;
        }

        // Hash password securely
        $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT, ['cost' => 12]);

        $stmt = $this->db->prepare(
            "INSERT INTO " . self::TABLE . " 
             (Username, Pass, Fullname, Email, status) 
             VALUES (:username, :password, :fullname, :email, :status)"
        );

        $success = $stmt->execute([
            'username' => strtolower($data['username']),
            'password' => $hashedPassword,
            'fullname' => $data['fullname'],
            'email'    => $data['email'],
            'status'   => $data['status'] ?? 'user'
        ]);

        return $success ? (int) $this->db->lastInsertId() : false;
    }

    /**
     * Update user
     * 
     * @param int $id User ID
     * @param array $data Data to update
     * @return bool Success status
     */
    public function update(int $id, array $data): bool
    {
        $fields = [];
        $params = ['id' => $id];

        foreach ($data as $key => $value) {
            if (in_array($key, ['Username', 'Fullname', 'Email', 'status'])) {
                $fields[] = "{$key} = :{$key}";
                $params[$key] = $value;
            }
        }

        if (empty($fields)) {
            return false;
        }

        $sql = "UPDATE " . self::TABLE . " SET " . implode(', ', $fields) . " WHERE UserId = :id";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute($params);
    }

    /**
     * Update user password
     * 
     * @param int $id User ID
     * @param string $password New plain text password
     * @return bool Success status
     */
    public function updatePassword(int $id, string $password): bool
    {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
        
        $stmt = $this->db->prepare(
            "UPDATE " . self::TABLE . " SET Pass = :password WHERE UserId = :id"
        );

        return $stmt->execute([
            'id'       => $id,
            'password' => $hashedPassword
        ]);
    }

    /**
     * Delete user
     * 
     * @param int $id User ID
     * @return bool Success status
     */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare(
            "DELETE FROM " . self::TABLE . " WHERE UserId = :id"
        );

        return $stmt->execute(['id' => $id]);
    }

    /**
     * Get all users (for admin)
     * 
     * @param int $limit Result limit
     * @param int $offset Result offset
     * @return array List of users
     */
    public function getAll(int $limit = 100, int $offset = 0): array
    {
        $stmt = $this->db->prepare(
            "SELECT UserId, Username, Fullname, Email, status 
             FROM " . self::TABLE . " 
             ORDER BY UserId DESC 
             LIMIT :limit OFFSET :offset"
        );
        $stmt->bindValue('limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue('offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Count total users
     * 
     * @return int Total user count
     */
    public function count(): int
    {
        $stmt = $this->db->query("SELECT COUNT(*) FROM " . self::TABLE);
        return (int) $stmt->fetchColumn();
    }
}
