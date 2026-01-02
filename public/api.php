<?php

/**
 * API Entry Point
 * 
 * Handles all API requests for movie data.
 * Using TMDb API v4 with Bearer token authentication.
 * 
 * Available endpoints:
 * - search: Search movies by query
 * - search-multi: Search movies, TV shows, and people
 * - popular: Get popular movies
 * - top-rated: Get top rated movies
 * - trending: Get trending movies (day/week)
 * - now-playing: Get movies now playing in theaters
 * - upcoming: Get upcoming movies
 * - details: Get movie details with videos, credits, recommendations, etc.
 * - videos: Get movie trailers and videos
 * - credits: Get movie cast and crew
 * - reviews: Get movie reviews
 * - genres: Get movie/TV genres list
 * - discover: Discover movies with filters (year, genre, rating)
 * - providers: Get streaming/watch providers
 * - popular-series: Get popular TV shows
 * - series-details: Get TV show details with extended info
 * - person: Get person details with movie/TV credits
 * 
 * @package App
 * @author Anderson
 * @version 3.0.0
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
    // Search
    case 'search':
        $controller->search();
        break;
    
    case 'search-multi':
        $controller->searchMulti();
        break;
    
    // Movie Lists
    case 'popular':
        $controller->popular();
        break;
    
    case 'top-rated':
        $controller->topRated();
        break;
    
    case 'trending':
        $controller->trending();
        break;
    
    case 'now-playing':
        $controller->nowPlaying();
        break;
    
    case 'upcoming':
        $controller->upcoming();
        break;
    
    // Movie Details
    case 'details':
        $controller->details();
        break;
    
    case 'videos':
        $controller->videos();
        break;
    
    case 'reviews':
        $controller->reviews();
        break;
    
    case 'credits':
        $controller->credits();
        break;
    
    // Discover & Filter
    case 'genres':
        $controller->genres();
        break;
    
    case 'discover':
        $controller->discover();
        break;
    
    case 'providers':
        $controller->providers();
        break;
    
    // TV Shows
    case 'popular-series':
        $controller->popularSeries();
        break;
    
    case 'series-details':
        $controller->seriesDetails();
        break;
    
    // People
    case 'person':
        $controller->person();
        break;
    
    default:
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode([
            'error' => 'Invalid action',
            'available_actions' => [
                'search' => 'Search movies by query',
                'search-multi' => 'Search movies, TV shows, people',
                'popular' => 'Get popular movies',
                'top-rated' => 'Get top rated movies',
                'trending' => 'Get trending movies (day/week)',
                'now-playing' => 'Get movies now playing',
                'upcoming' => 'Get upcoming movies',
                'details' => 'Get movie details (requires id)',
                'videos' => 'Get movie videos (requires id)',
                'credits' => 'Get movie credits (requires id)',
                'reviews' => 'Get movie reviews (requires id)',
                'genres' => 'Get genres list (type=movie|tv)',
                'discover' => 'Discover with filters',
                'providers' => 'Get watch providers (requires id)',
                'popular-series' => 'Get popular TV shows',
                'series-details' => 'Get TV show details (requires id)',
                'person' => 'Get person details (requires id)'
            ]
        ], JSON_PRETTY_PRINT);
        break;
}
