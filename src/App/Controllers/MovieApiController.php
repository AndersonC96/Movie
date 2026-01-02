<?php

declare(strict_types=1);

namespace App\Controllers;

use Core\Controller;

/**
 * Movie API Controller
 * 
 * Handles TMDb API requests from backend to protect API key.
 * 
 * @package App\Controllers
 * @author Anderson
 * @version 2.0.0
 */
class MovieApiController extends Controller
{
    /**
     * @var array API configuration
     */
    private array $config;

    /**
     * @var string API key
     */
    private string $apiKey;

    /**
     * @var string Base URL
     */
    private string $baseUrl;

    /**
     * MovieApiController constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->config = require dirname(__DIR__, 2) . '/config/api.php';
        $this->apiKey = $this->config['tmdb']['api_key'];
        $this->baseUrl = $this->config['tmdb']['base_url'];
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

        $url = "{$this->baseUrl}/search/movie?" . http_build_query([
            'api_key' => $this->apiKey,
            'query'   => $query,
            'page'    => $page,
            'language' => 'pt-BR'
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

        $url = "{$this->baseUrl}/movie/popular?" . http_build_query([
            'api_key'  => $this->apiKey,
            'page'     => $page,
            'language' => 'pt-BR'
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

        $url = "{$this->baseUrl}/movie/top_rated?" . http_build_query([
            'api_key'  => $this->apiKey,
            'page'     => $page,
            'language' => 'pt-BR'
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

        $url = "{$this->baseUrl}/movie/{$id}?" . http_build_query([
            'api_key'  => $this->apiKey,
            'language' => 'pt-BR'
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

        $url = "{$this->baseUrl}/movie/{$id}/reviews?" . http_build_query([
            'api_key'  => $this->apiKey,
            'page'     => $page,
            'language' => 'pt-BR'
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

        $url = "{$this->baseUrl}/movie/{$id}/credits?" . http_build_query([
            'api_key'  => $this->apiKey,
            'language' => 'pt-BR'
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

        $url = "{$this->baseUrl}/tv/popular?" . http_build_query([
            'api_key'  => $this->apiKey,
            'page'     => $page,
            'language' => 'pt-BR'
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

        $url = "{$this->baseUrl}/tv/{$id}?" . http_build_query([
            'api_key'  => $this->apiKey,
            'language' => 'pt-BR'
        ]);

        $this->fetchAndReturn($url);
    }

    /**
     * Fetch data from TMDb API and return as JSON
     * 
     * @param string $url API URL
     * @return void
     */
    private function fetchAndReturn(string $url): void
    {
        $context = stream_context_create([
            'http' => [
                'method' => 'GET',
                'header' => 'Accept: application/json',
                'timeout' => 10
            ]
        ]);

        $response = @file_get_contents($url, false, $context);

        if ($response === false) {
            $this->json(['error' => 'Failed to fetch data from API'], 500);
            return;
        }

        $data = json_decode($response, true);
        
        if ($data === null) {
            $this->json(['error' => 'Invalid response from API'], 500);
            return;
        }

        $this->json($data);
    }
}
