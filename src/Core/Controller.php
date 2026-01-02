<?php

declare(strict_types=1);

namespace Core;

/**
 * Base Controller
 * 
 * Provides common functionality for all controllers.
 * 
 * @package Core
 * @author Anderson
 * @version 2.0.0
 */
abstract class Controller
{
    /**
     * @var string Base path for views
     */
    protected string $viewPath;

    /**
     * Controller constructor
     */
    public function __construct()
    {
        $this->viewPath = dirname(__DIR__) . '/App/Views/';
    }

    /**
     * Render a view
     * 
     * @param string $view View name (e.g., 'guest/index')
     * @param array $data Data to pass to view
     * @return void
     */
    protected function view(string $view, array $data = []): void
    {
        // Extract data to variables
        extract($data);

        // Build view path
        $viewFile = $this->viewPath . str_replace('.', '/', $view) . '.php';

        if (!file_exists($viewFile)) {
            throw new \RuntimeException("View not found: {$view}");
        }

        require $viewFile;
    }

    /**
     * Redirect to another URL
     * 
     * @param string $url URL to redirect to
     * @return void
     */
    protected function redirect(string $url): void
    {
        header("Location: {$url}");
        exit;
    }

    /**
     * Return JSON response
     * 
     * @param mixed $data Data to encode
     * @param int $statusCode HTTP status code
     * @return void
     */
    protected function json(mixed $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    /**
     * Get POST data with optional sanitization
     * 
     * @param string $key Key name
     * @param mixed $default Default value
     * @return mixed
     */
    protected function post(string $key, mixed $default = null): mixed
    {
        return isset($_POST[$key]) ? htmlspecialchars(trim($_POST[$key]), ENT_QUOTES, 'UTF-8') : $default;
    }

    /**
     * Get GET data with optional sanitization
     * 
     * @param string $key Key name
     * @param mixed $default Default value
     * @return mixed
     */
    protected function get(string $key, mixed $default = null): mixed
    {
        return isset($_GET[$key]) ? htmlspecialchars(trim($_GET[$key]), ENT_QUOTES, 'UTF-8') : $default;
    }

    /**
     * Check if request is POST
     * 
     * @return bool
     */
    protected function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    /**
     * Check if request is AJAX
     * 
     * @return bool
     */
    protected function isAjax(): bool
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) 
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    /**
     * Start or resume session
     * 
     * @return void
     */
    protected function startSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Get session value
     * 
     * @param string $key Session key
     * @param mixed $default Default value
     * @return mixed
     */
    protected function session(string $key, mixed $default = null): mixed
    {
        return $_SESSION[$key] ?? $default;
    }

    /**
     * Set session value
     * 
     * @param string $key Session key
     * @param mixed $value Value to set
     * @return void
     */
    protected function setSession(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Check if user is authenticated
     * 
     * @return bool
     */
    protected function isAuthenticated(): bool
    {
        $this->startSession();
        return isset($_SESSION['username']);
    }

    /**
     * Check if user is admin
     * 
     * @return bool
     */
    protected function isAdmin(): bool
    {
        $this->startSession();
        return ($this->session('status') === 'admin');
    }

    /**
     * Require authentication
     * 
     * @param string $redirectTo URL to redirect if not authenticated
     * @return void
     */
    protected function requireAuth(string $redirectTo = '/Movie/public/guest'): void
    {
        if (!$this->isAuthenticated()) {
            $this->redirect($redirectTo);
        }
    }

    /**
     * Require admin role
     * 
     * @param string $redirectTo URL to redirect if not admin
     * @return void
     */
    protected function requireAdmin(string $redirectTo = '/Movie/public/user'): void
    {
        $this->requireAuth();
        
        if (!$this->isAdmin()) {
            $this->redirect($redirectTo);
        }
    }
}
