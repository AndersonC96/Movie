<?php
/**
 * Main Entry Point
 * 
 * Redirects to appropriate view based on authentication.
 * 
 * @package App
 * @author Anderson
 * @version 2.0.0
 */

declare(strict_types=1);

session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to guest home
    require __DIR__ . '/../src/App/Views/guest/index.php';
    exit;
}

// Check user role
if ($_SESSION['status'] === 'admin') {
    header('Location: /Movie/public/admin/');
    exit;
}

// Regular user
header('Location: /Movie/public/user/');
exit;
