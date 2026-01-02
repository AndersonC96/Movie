<?php

/**
 * Authentication Handler
 * 
 * Routes authentication requests to AuthController.
 * 
 * @package App
 * @author Anderson
 * @version 2.0.0
 */

declare(strict_types=1);

// Load autoloader
require_once dirname(__DIR__) . '/autoload.php';

use App\Controllers\AuthController;

// Get action from query string
$action = $_GET['action'] ?? '';

// Create controller
$controller = new AuthController();

// Route to appropriate method
switch ($action) {
    case 'login':
        $controller->login();
        break;
    
    case 'logout':
        $controller->logout();
        break;
    
    case 'register':
        $controller->register();
        break;
    
    default:
        header('Location: /Movie/public/guest');
        exit;
}
