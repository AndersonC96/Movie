<?php

/**
 * API Entry Point
 * 
 * Handles all API requests for movie data.
 * 
 * @package App
 * @author Anderson
 * @version 2.0.0
 */

declare(strict_types=1);

// Enable CORS for AJAX requests
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Load autoloader
require_once dirname(__DIR__) . '/autoload.php';

use App\Controllers\MovieApiController;

// Get action from query string
$action = $_GET['action'] ?? '';

// Create controller
$controller = new MovieApiController();

// Route to appropriate method
switch ($action) {
    case 'search':
        $controller->search();
        break;
    
    case 'popular':
        $controller->popular();
        break;
    
    case 'top-rated':
        $controller->topRated();
        break;
    
    case 'details':
        $controller->details();
        break;
    
    case 'reviews':
        $controller->reviews();
        break;
    
    case 'credits':
        $controller->credits();
        break;
    
    case 'popular-series':
        $controller->popularSeries();
        break;
    
    case 'series-details':
        $controller->seriesDetails();
        break;
    
    default:
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Invalid action']);
        break;
}
