<?php

declare(strict_types=1);

namespace App\Controllers;

use Core\Controller;

/**
 * Movie API Controller
 * 
 * Handles TMDb API v4 requests from backend to protect API key.
 * Uses Bearer token authentication for API v4.
 * 
 * @package App\Controllers
 * @author Anderson
 * @version 3.0.0
 */
class MovieApiController extends Controller
{
    /**
     * @var array API configuration
     */
    private array $config;

    /**
     * @var string Access token for Bearer auth
     */
    private string $accessToken;

    /**
     * @var string Base URL for API v3 (still used for most endpoints)
     */
    private string $baseUrlV3;

    /**
     * @var string Base URL for API v4
     */
    private string $baseUrlV4;

    /**
     * @var string Default language
     */
    private string $language;

    /**
     * MovieApiController constructor
     */
    public function __construct()
    {
        parent::__construct();
        $configPath = dirname(__DIR__, 3) . '/config/api.php';
        $this->config = require $configPath;
        $this->accessToken = $this->config['tmdb']['access_token'];
        $this->baseUrlV3 = $this->config['tmdb']['base_url_v3'];
        $this->baseUrlV4 = $this->config['tmdb']['base_url_v4'];
        $this->language = $this->config['tmdb']['language'];
    }

    /**
     * Search movies
     * 
     * @return void
     */
    public function search(): void
    {
        $query = $this->get('query', '');
        $page = (int) $this->get('page', '1');

        if (empty($query)) {
            $this->json(['error' => 'Query parameter is required'], 400);
            return;
        }

        $url = "{$this->baseUrlV3}/search/movie?" . http_build_query([
            'query'   => $query,
            'page'    => $page,
            'language' => $this->language
        ]);

        $this->fetchAndReturn($url);
    }

    /**
     * Get popular movies
     * 
     * @return void
     */
    public function popular(): void
    {
        $page = (int) $this->get('page', '1');

        $url = "{$this->baseUrlV3}/movie/popular?" . http_build_query([
            'page'     => $page,
            'language' => $this->language
        ]);

        $this->fetchAndReturn($url);
    }

    /**
     * Get top rated movies
     * 
     * @return void
     */
    public function topRated(): void
    {
        $page = (int) $this->get('page', '1');

        $url = "{$this->baseUrlV3}/movie/top_rated?" . http_build_query([
            'page'     => $page,
            'language' => $this->language
        ]);

        $this->fetchAndReturn($url);
    }

    /**
     * Get movie details
     * 
     * @return void
     */
    public function details(): void
    {
        $id = (int) $this->get('id', '0');

        if ($id <= 0) {
            $this->json(['error' => 'Valid movie ID is required'], 400);
            return;
        }

        $url = "{$this->baseUrlV3}/movie/{$id}?" . http_build_query([
            'language' => $this->language
        ]);

        $this->fetchAndReturn($url);
    }

    /**
     * Get movie reviews
     * 
     * @return void
     */
    public function reviews(): void
    {
        $id = (int) $this->get('id', '0');
        $page = (int) $this->get('page', '1');

        if ($id <= 0) {
            $this->json(['error' => 'Valid movie ID is required'], 400);
            return;
        }

        $url = "{$this->baseUrlV3}/movie/{$id}/reviews?" . http_build_query([
            'page'     => $page,
            'language' => $this->language
        ]);

        $this->fetchAndReturn($url);
    }

    /**
     * Get movie credits (cast & crew)
     * 
     * @return void
     */
    public function credits(): void
    {
        $id = (int) $this->get('id', '0');

        if ($id <= 0) {
            $this->json(['error' => 'Valid movie ID is required'], 400);
            return;
        }

        $url = "{$this->baseUrlV3}/movie/{$id}/credits?" . http_build_query([
            'language' => $this->language
        ]);

        $this->fetchAndReturn($url);
    }

    /**
     * Get popular TV shows
     * 
     * @return void
     */
    public function popularSeries(): void
    {
        $page = (int) $this->get('page', '1');

        $url = "{$this->baseUrlV3}/tv/popular?" . http_build_query([
            'page'     => $page,
            'language' => $this->language
        ]);

        $this->fetchAndReturn($url);
    }

    /**
     * Get TV show details
     * 
     * @return void
     */
    public function seriesDetails(): void
    {
        $id = (int) $this->get('id', '0');

        if ($id <= 0) {
            $this->json(['error' => 'Valid TV show ID is required'], 400);
            return;
        }

        $url = "{$this->baseUrlV3}/tv/{$id}?" . http_build_query([
            'language' => $this->language
        ]);

        $this->fetchAndReturn($url);
    }

    /**
     * Get trending movies (v4 feature)
     * 
     * @return void
     */
    public function trending(): void
    {
        $timeWindow = $this->get('time_window', 'week'); // day or week
        $page = (int) $this->get('page', '1');

        $url = "{$this->baseUrlV3}/trending/movie/{$timeWindow}?" . http_build_query([
            'page'     => $page,
            'language' => $this->language
        ]);

        $this->fetchAndReturn($url);
    }

    /**
     * Get now playing movies
     * 
     * @return void
     */
    public function nowPlaying(): void
    {
        $page = (int) $this->get('page', '1');

        $url = "{$this->baseUrlV3}/movie/now_playing?" . http_build_query([
            'page'     => $page,
            'language' => $this->language
        ]);

        $this->fetchAndReturn($url);
    }

    /**
     * Get upcoming movies
     * 
     * @return void
     */
    public function upcoming(): void
    {
        $page = (int) $this->get('page', '1');

        $url = "{$this->baseUrlV3}/movie/upcoming?" . http_build_query([
            'page'     => $page,
            'language' => $this->language
        ]);

        $this->fetchAndReturn($url);
    }

    /**
     * Fetch data from TMDb API using Bearer token authentication
     * 
     * @param string $url API URL
     * @return void
     */
    private function fetchAndReturn(string $url): void
    {
        $context = stream_context_create([
            'http' => [
                'method' => 'GET',
                'header' => [
                    'Accept: application/json',
                    'Authorization: Bearer ' . $this->accessToken
                ],
                'timeout' => 15,
                'ignore_errors' => true
            ],
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false
            ]
        ]);

        $response = @file_get_contents($url, false, $context);

        if ($response === false) {
            $this->json(['error' => 'Failed to fetch data from API', 'url' => $url], 500);
            return;
        }

        $data = json_decode($response, true);
        
        if ($data === null) {
            $this->json(['error' => 'Invalid response from API'], 500);
            return;
        }

        // Check for API errors
        if (isset($data['success']) && $data['success'] === false) {
            $this->json(['error' => $data['status_message'] ?? 'API Error'], 400);
            return;
        }

        $this->json($data);
    }
}
