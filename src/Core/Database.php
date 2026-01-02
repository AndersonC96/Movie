<?php

declare(strict_types=1);

namespace Core;

use PDO;
use PDOException;

/**
 * Database Connection Class
 * 
 * Implements Singleton pattern for PDO connection with prepared statements.
 * 
 * @package Core
 * @author Anderson
 * @version 2.0.0
 */
class Database
{
    /**
     * @var PDO|null Singleton instance
     */
    private static ?PDO $instance = null;

    /**
     * @var array Database configuration
     */
    private static array $config = [];

    /**
     * Prevent direct instantiation
     */
    private function __construct()
    {
    }

    /**
     * Prevent cloning
     */
    private function __clone()
    {
    }

    /**
     * Get database connection instance
     * 
     * @return PDO
     * @throws PDOException
     */
    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            self::loadConfig();
            self::connect();
        }

        return self::$instance;
    }

    /**
     * Load database configuration
     * 
     * @return void
     */
    private static function loadConfig(): void
    {
        $configPath = dirname(__DIR__, 2) . '/config/database.php';
        
        if (!file_exists($configPath)) {
            throw new PDOException('Database configuration file not found.');
        }

        self::$config = require $configPath;
    }

    /**
     * Establish database connection
     * 
     * @return void
     * @throws PDOException
     */
    private static function connect(): void
    {
        $dsn = sprintf(
            'mysql:host=%s;dbname=%s;charset=%s',
            self::$config['host'],
            self::$config['database'],
            self::$config['charset']
        );

        try {
            self::$instance = new PDO(
                $dsn,
                self::$config['username'],
                self::$config['password'],
                self::$config['options']
            );
        } catch (PDOException $e) {
            throw new PDOException('Database connection failed: ' . $e->getMessage());
        }
    }

    /**
     * Close database connection
     * 
     * @return void
     */
    public static function close(): void
    {
        self::$instance = null;
    }
}
