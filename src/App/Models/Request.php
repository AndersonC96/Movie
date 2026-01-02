<?php

declare(strict_types=1);

namespace App\Models;

use Core\Database;
use PDO;

/**
 * Request Model
 * 
 * Handles movie request operations.
 * 
 * @package App\Models
 * @author Anderson
 * @version 2.0.0
 */
class Request
{
    /**
     * @var PDO Database connection
     */
    private PDO $db;

    /**
     * @var string Table name
     */
    private const TABLE = 'request';

    /**
     * Request constructor
     */
    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Create new request
     * 
     * @param array $data Request data
     * @return int|false New request ID or false on failure
     */
    public function create(array $data): int|false
    {
        $stmt = $this->db->prepare(
            "INSERT INTO " . self::TABLE . " 
             (RequestUser, RequestTitle, RequestMessage) 
             VALUES (:user, :title, :message)"
        );

        $success = $stmt->execute([
            'user'    => $data['user'],
            'title'   => $data['title'],
            'message' => $data['message'] ?? null
        ]);

        return $success ? (int) $this->db->lastInsertId() : false;
    }

    /**
     * Find request by ID
     * 
     * @param int $id Request ID
     * @return array|null Request data or null if not found
     */
    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM " . self::TABLE . " WHERE RequestId = :id"
        );
        $stmt->execute(['id' => $id]);
        
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Get all requests
     * 
     * @param int $limit Result limit
     * @param int $offset Result offset
     * @return array List of requests
     */
    public function getAll(int $limit = 100, int $offset = 0): array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM " . self::TABLE . " 
             ORDER BY RequestId DESC 
             LIMIT :limit OFFSET :offset"
        );
        $stmt->bindValue('limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue('offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Get requests by user
     * 
     * @param string $username Username
     * @return array List of requests
     */
    public function getByUser(string $username): array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM " . self::TABLE . " 
             WHERE RequestUser = :user 
             ORDER BY RequestId DESC"
        );
        $stmt->execute(['user' => $username]);

        return $stmt->fetchAll();
    }

    /**
     * Delete request
     * 
     * @param int $id Request ID
     * @return bool Success status
     */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare(
            "DELETE FROM " . self::TABLE . " WHERE RequestId = :id"
        );

        return $stmt->execute(['id' => $id]);
    }

    /**
     * Count total requests
     * 
     * @return int Total request count
     */
    public function count(): int
    {
        $stmt = $this->db->query("SELECT COUNT(*) FROM " . self::TABLE);
        return (int) $stmt->fetchColumn();
    }
}
