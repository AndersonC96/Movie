<?php

/**
 * API Configuration
 * 
 * IMPORTANT: In production, use environment variables instead
 * 
 * TMDb API v4 uses Bearer token authentication
 * Get your access token at: https://www.themoviedb.org/settings/api
 * 
 * @package App\Config
 */

return [
    'tmdb' => [
        // API Read Access Token (v4) - Bearer token authentication
        'access_token' => 'eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI4MGI3NDc3MjMxMTNjZTgyYWY1ODM1NzI0MmM2MTAzNSIsIm5iZiI6MTYxNTQwNzA4MS41Mzc5OTk5LCJzdWIiOiI2MDQ5MjdlOWQ4ZTIyNTAwMjVkZmMzZTQiLCJzY29wZXMiOlsiYXBpX3JlYWQiXSwidmVyc2lvbiI6MX0.7c651-fwNFwNx2r6E9BHTF3xlXtRxTHz8aKNFriEtpY',
        
        // Legacy API Key (v3) - kept for compatibility
        'api_key' => '80b747723113ce82af58357242c61035',
        
        // API URLs
        'base_url_v4' => 'https://api.themoviedb.org/4',
        'base_url_v3' => 'https://api.themoviedb.org/3',
        'image_base_url' => 'https://image.tmdb.org/t/p',
        
        // Default settings
        'language' => 'pt-BR'
    ]
];
