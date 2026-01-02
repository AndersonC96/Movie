<?php

declare(strict_types=1);

namespace App\Controllers;

use Core\Controller;
use App\Models\User;

/**
 * Authentication Controller
 * 
 * Handles login, logout, and registration.
 * 
 * @package App\Controllers
 * @author Anderson
 * @version 2.0.0
 */
class AuthController extends Controller
{
    /**
     * @var User User model
     */
    private User $userModel;

    /**
     * AuthController constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();
    }

    /**
     * Handle login request
     * 
     * @return void
     */
    public function login(): void
    {
        $this->startSession();

        if (!$this->isPost()) {
            $this->redirect('/Movie/public/guest');
            return;
        }

        $username = $this->post('username', '');
        $password = isset($_POST['password']) ? trim($_POST['password']) : '';

        // Validate inputs
        if (empty($username) || empty($password)) {
            $this->redirect('/Movie/public/#error1');
            return;
        }

        // Authenticate user
        $user = $this->userModel->authenticate($username, $password);

        if ($user === null) {
            $this->redirect('/Movie/public/#error1');
            return;
        }

        // Set session data
        $this->setSession('username', strtolower($user['Username']));
        $this->setSession('status', $user['status']);
        $this->setSession('user_id', $user['UserId']);

        // Redirect based on role
        if ($user['status'] === 'admin') {
            $this->redirect('/Movie/public/admin');
        } else {
            $this->redirect('/Movie/public/user');
        }
    }

    /**
     * Handle logout request
     * 
     * @return void
     */
    public function logout(): void
    {
        $this->startSession();
        
        // Clear all session data
        $_SESSION = [];

        // Destroy session cookie
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        // Destroy session
        session_destroy();

        $this->redirect('/Movie/public/guest');
    }

    /**
     * Handle registration request
     * 
     * @return void
     */
    public function register(): void
    {
        $this->startSession();

        if (!$this->isPost()) {
            $this->redirect('/Movie/public/guest');
            return;
        }

        $data = [
            'fullname' => $this->post('fullname', ''),
            'email'    => $this->post('email', ''),
            'username' => $this->post('username', ''),
            'password' => $this->post('password', ''),
            'status'   => 'user'
        ];

        // Validate inputs
        if (empty($data['fullname']) || empty($data['email']) || 
            empty($data['username']) || empty($data['password'])) {
            $this->redirect('/Movie/public/guest#error');
            return;
        }

        // Validate email format
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->redirect('/Movie/public/guest#error');
            return;
        }

        // Validate password length
        if (strlen($data['password']) < 6) {
            $this->redirect('/Movie/public/guest#error');
            return;
        }

        // Create user
        $userId = $this->userModel->create($data);

        if ($userId === false) {
            // Username or email already exists
            if ($this->isAdmin()) {
                $this->redirect('/Movie/public/admin/users#error');
            } else {
                $this->redirect('/Movie/public/guest#error');
            }
            return;
        }

        // Success
        if ($this->isAdmin()) {
            $this->redirect('/Movie/public/admin/users#success');
        } else {
            $this->redirect('/Movie/public/guest#success');
        }
    }
}
