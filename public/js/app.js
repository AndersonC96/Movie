/**
 * Movies Database - Main JavaScript
 * 
 * @author Anderson
 * @version 2.0.0
 * 
 * Uses backend API proxy to protect TMDb API key
 */

'use strict';

// API configuration - uses backend proxy
const API_BASE = '/Movie/public/api.php';
const IMAGE_BASE = 'https://image.tmdb.org/t/p';
const PLACEHOLDER_IMAGE = '/Movie/public/images/default-movie.png';

/**
 * MovieDB API Service
 */
const MovieAPI = {
    /**
     * Fetch data from API
     * @param {string} action - API action
     * @param {Object} params - Query parameters
     * @returns {Promise<Object>}
     */
    async fetch(action, params = {}) {
        const queryString = new URLSearchParams({ action, ...params }).toString();
        const url = `${API_BASE}?${queryString}`;

        try {
            const response = await fetch(url);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return await response.json();
        } catch (error) {
            console.error('API Error:', error);
            throw error;
        }
    },

    /**
     * Search movies by title
     * @param {string} query - Search query
     * @param {number} page - Page number
     * @returns {Promise<Object>}
     */
    searchMovies(query, page = 1) {
        return this.fetch('search', { query, page });
    },

    /**
     * Get popular movies
     * @param {number} page - Page number
     * @returns {Promise<Object>}
     */
    getPopularMovies(page = 1) {
        return this.fetch('popular', { page });
    },

    /**
     * Get top rated movies
     * @param {number} page - Page number
     * @returns {Promise<Object>}
     */
    getTopRatedMovies(page = 1) {
        return this.fetch('top-rated', { page });
    },

    /**
     * Get movie details
     * @param {number} id - Movie ID
     * @returns {Promise<Object>}
     */
    getMovieDetails(id) {
        return this.fetch('details', { id });
    },

    /**
     * Get movie reviews
     * @param {number} id - Movie ID
     * @param {number} page - Page number
     * @returns {Promise<Object>}
     */
    getMovieReviews(id, page = 1) {
        return this.fetch('reviews', { id, page });
    },

    /**
     * Get movie credits
     * @param {number} id - Movie ID
     * @returns {Promise<Object>}
     */
    getMovieCredits(id) {
        return this.fetch('credits', { id });
    },

    /**
     * Get popular TV shows
     * @param {number} page - Page number
     * @returns {Promise<Object>}
     */
    getPopularSeries(page = 1) {
        return this.fetch('popular-series', { page });
    },

    /**
     * Get TV show details
     * @param {number} id - TV show ID
     * @returns {Promise<Object>}
     */
    getSeriesDetails(id) {
        return this.fetch('series-details', { id });
    }
};

/**
 * UI Helper Functions
 */
const UI = {
    /**
     * Get poster image URL
     * @param {string|null} posterPath - Poster path from API
     * @param {string} size - Image size
     * @returns {string}
     */
    getPosterUrl(posterPath, size = 'w342') {
        if (!posterPath) return PLACEHOLDER_IMAGE;
        return `${IMAGE_BASE}/${size}${posterPath}`;
    },

    /**
     * Extract year from date string
     * @param {string} dateStr - Date string (YYYY-MM-DD)
     * @returns {string}
     */
    getYear(dateStr) {
        if (!dateStr) return 'N/A';
        return dateStr.substring(0, 4);
    },

    /**
     * Format rating
     * @param {number} rating - Rating value
     * @returns {string}
     */
    formatRating(rating) {
        return (rating || 0).toFixed(1);
    },

    /**
     * Create movie card HTML
     * @param {Object} movie - Movie data
     * @returns {string}
     */
    createMovieCard(movie) {
        const posterUrl = this.getPosterUrl(movie.poster_path);
        const year = this.getYear(movie.release_date || movie.first_air_date);
        const title = movie.title || movie.name;
        const rating = this.formatRating(movie.vote_average);

        return `
            <article class="movie-card" onclick="MovieApp.selectMovie(${movie.id})">
                <img 
                    src="${posterUrl}" 
                    alt="${title}" 
                    class="movie-card-poster"
                    loading="lazy"
                    onerror="this.src='${PLACEHOLDER_IMAGE}'"
                >
                <div class="movie-card-rating">
                    <i class="fas fa-star"></i>
                    <span>${rating}</span>
                </div>
                <div class="movie-card-overlay">
                    <h3 class="movie-card-title">${title}</h3>
                    <p class="movie-card-year">${year}</p>
                </div>
            </article>
        `;
    },

    /**
     * Create skeleton loading cards
     * @param {number} count - Number of skeletons
     * @returns {string}
     */
    createSkeletonCards(count = 4) {
        let html = '';
        for (let i = 0; i < count; i++) {
            html += `
                <div class="movie-card">
                    <div class="skeleton skeleton-card"></div>
                    <div style="padding: var(--spacing-md);">
                        <div class="skeleton skeleton-text"></div>
                        <div class="skeleton skeleton-text-sm"></div>
                    </div>
                </div>
            `;
        }
        return html;
    },

    /**
     * Show toast notification
     * @param {string} message - Message to show
     * @param {string} type - Toast type (success, error, info)
     */
    showToast(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'times-circle' : 'info-circle'}"></i>
            <span>${message}</span>
        `;

        document.body.appendChild(toast);

        setTimeout(() => toast.classList.add('show'), 100);
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }
};

/**
 * Main Application
 */
const MovieApp = {
    /**
     * Initialize application
     */
    init() {
        this.bindEvents();
        this.loadInitialContent();
    },

    /**
     * Bind event listeners
     */
    bindEvents() {
        // Search form
        const searchForm = document.getElementById('searchForm');
        if (searchForm) {
            searchForm.addEventListener('submit', (e) => {
                e.preventDefault();
                this.handleSearch();
            });

            // Live search with debounce
            const searchInput = document.getElementById('searchText');
            if (searchInput) {
                let debounceTimer;
                searchInput.addEventListener('input', () => {
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(() => this.handleSearch(), 500);
                });
            }
        }
    },

    /**
     * Load initial content
     */
    async loadInitialContent() {
        const topMoviesContainer = document.getElementById('topMovies1');
        const moviesContainer = document.getElementById('movies');

        if (topMoviesContainer) {
            await this.loadTopRatedMovies();
        }

        if (moviesContainer && !topMoviesContainer) {
            await this.loadPopularMovies();
        }
    },

    /**
     * Handle search
     */
    async handleSearch() {
        const searchInput = document.getElementById('searchText');
        const moviesContainer = document.getElementById('movies');

        if (!searchInput || !moviesContainer) return;

        const query = searchInput.value.trim();

        if (!query) {
            await this.loadPopularMovies();
            return;
        }

        moviesContainer.innerHTML = UI.createSkeletonCards(8);

        try {
            const data = await MovieAPI.searchMovies(query);
            this.displayMovies(data.results || []);
        } catch (error) {
            UI.showToast('Erro ao buscar filmes', 'error');
            moviesContainer.innerHTML = '<p class="text-center text-muted">Erro ao carregar filmes</p>';
        }
    },

    /**
     * Load popular movies
     */
    async loadPopularMovies() {
        const container = document.getElementById('movies');
        if (!container) return;

        container.innerHTML = UI.createSkeletonCards(8);

        try {
            const data = await MovieAPI.getPopularMovies();
            this.displayMovies(data.results || []);
        } catch (error) {
            UI.showToast('Erro ao carregar filmes populares', 'error');
        }
    },

    /**
     * Load top rated movies for carousel
     */
    async loadTopRatedMovies() {
        try {
            const data = await MovieAPI.getTopRatedMovies();
            const movies = data.results || [];

            // Distribute movies across carousel slides
            for (let slide = 1; slide <= 5; slide++) {
                const container = document.getElementById(`topMovies${slide}`);
                if (container) {
                    const startIndex = (slide - 1) * 4;
                    const slideMovies = movies.slice(startIndex, startIndex + 4);
                    container.innerHTML = slideMovies.map(m => UI.createMovieCard(m)).join('');
                }
            }
        } catch (error) {
            console.error('Error loading top rated movies:', error);
        }
    },

    /**
     * Display movies in grid
     * @param {Array} movies - Movies array
     */
    displayMovies(movies) {
        const container = document.getElementById('movies');
        if (!container) return;

        if (movies.length === 0) {
            container.innerHTML = '<p class="text-center text-muted mt-5">Nenhum filme encontrado</p>';
            return;
        }

        container.innerHTML = movies.map(m => UI.createMovieCard(m)).join('');
    },

    /**
     * Select movie and navigate to details
     * @param {number} id - Movie ID
     */
    selectMovie(id) {
        sessionStorage.setItem('movieId', id);
        window.location.href = 'movie.php';
    },

    /**
     * Load movie details page
     */
    async loadMovieDetails() {
        const movieId = sessionStorage.getItem('movieId');
        if (!movieId) {
            window.location.href = 'browse.php';
            return;
        }

        const container = document.getElementById('movie');
        if (!container) return;

        try {
            const [movie, credits] = await Promise.all([
                MovieAPI.getMovieDetails(movieId),
                MovieAPI.getMovieCredits(movieId)
            ]);

            this.displayMovieDetails(movie, credits);
        } catch (error) {
            UI.showToast('Erro ao carregar detalhes do filme', 'error');
        }
    },

    /**
     * Display movie details
     * @param {Object} movie - Movie data
     * @param {Object} credits - Credits data
     */
    displayMovieDetails(movie, credits) {
        const container = document.getElementById('movie');
        if (!container) return;

        const posterUrl = UI.getPosterUrl(movie.poster_path, 'w500');
        const backdropUrl = movie.backdrop_path
            ? `${IMAGE_BASE}/original${movie.backdrop_path}`
            : '';

        const year = UI.getYear(movie.release_date);
        const genres = (movie.genres || []).map(g => g.name).join(' / ');
        const languages = (movie.spoken_languages || []).map(l => l.name).join(', ');
        const countries = (movie.production_countries || []).map(c => c.name).join(', ');
        const companies = (movie.production_companies || []).map(c => c.name).join(', ');

        const budget = movie.budget > 0
            ? `$ ${(movie.budget / 1000000).toFixed(1)} milhões`
            : 'Não informado';
        const revenue = movie.revenue > 0
            ? `$ ${(movie.revenue / 1000000).toFixed(1)} milhões`
            : 'Não informado';

        container.innerHTML = `
            <div class="movie-details">
                ${backdropUrl ? `
                    <div class="movie-backdrop" style="background-image: url('${backdropUrl}')"></div>
                ` : ''}
                
                <div class="movie-content">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="${posterUrl}" alt="${movie.title}" class="movie-poster glass-card">
                        </div>
                        
                        <div class="col-md-8">
                            <h1 class="movie-title">${movie.title}</h1>
                            ${movie.tagline ? `<p class="movie-tagline fst-italic text-muted mb-2">"${movie.tagline}"</p>` : ''}
                            <p class="movie-meta">
                                <span class="movie-year">${year}</span>
                                <span class="movie-genres">${genres}</span>
                            </p>
                            
                            <div class="movie-rating-large">
                                <i class="fas fa-star"></i>
                                <span>${UI.formatRating(movie.vote_average)}</span>
                                <small>/ 10</small>
                            </div>
                            
                            <div class="glass-card mt-4">
                                <h3>Sinopse</h3>
                                <p>${movie.overview || 'Sinopse não disponível.'}</p>
                            </div>
                            
                            <div class="movie-info-grid mt-4">
                                <div class="info-item">
                                    <strong>Status</strong>
                                    <span>${movie.status}</span>
                                </div>
                                <div class="info-item">
                                    <strong>Duração</strong>
                                    <span>${movie.runtime || 0} min</span>
                                </div>
                                <div class="info-item">
                                    <strong>Orçamento</strong>
                                    <span>${budget}</span>
                                </div>
                                <div class="info-item">
                                    <strong>Receita</strong>
                                    <span>${revenue}</span>
                                </div>
                                <div class="info-item">
                                    <strong>Idiomas</strong>
                                    <span>${languages || 'N/A'}</span>
                                </div>
                                <div class="info-item">
                                    <strong>Países</strong>
                                    <span>${countries || 'N/A'}</span>
                                </div>
                                <div class="info-item" style="grid-column: span 2;">
                                    <strong>Produtoras</strong>
                                    <span>${companies || 'Não informado'}</span>
                                </div>
                            </div>
                            
                            <div class="btn-group mt-4">
                                ${movie.imdb_id ? `
                                    <a href="https://www.imdb.com/title/${movie.imdb_id}" 
                                       target="_blank" class="btn-primary-custom">
                                        <i class="fab fa-imdb"></i> Ver no IMDB
                                    </a>
                                ` : ''}
                                <a href="https://www.themoviedb.org/movie/${movie.id}/watch?locale=BR" 
                                   target="_blank" class="btn-secondary-custom">
                                    <i class="fas fa-play"></i> Onde Assistir
                                </a>
                                <a href="browse.php" class="btn-secondary-custom">
                                    <i class="fas fa-arrow-left"></i> Voltar
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    ${this.renderCastSection(movie.credits)}
                </div>
            </div>
        `;
    },

    /**
     * Render cast section
     * @param {Object} credits - Credits data with cast and crew
     * @returns {string} HTML string
     */
    renderCastSection(credits) {
        if (!credits || !credits.cast || credits.cast.length === 0) {
            return '';
        }

        // Get director(s)
        const directors = (credits.crew || [])
            .filter(c => c.job === 'Director')
            .map(d => d.name)
            .join(', ');

        // Get top 10 cast members
        const topCast = credits.cast.slice(0, 10);

        return `
            <div class="mt-5">
                ${directors ? `
                    <div class="glass-card mb-4">
                        <h4><i class="fas fa-video text-primary me-2"></i>Direção</h4>
                        <p class="mb-0 fs-5">${directors}</p>
                    </div>
                ` : ''}
                
                <div class="glass-card">
                    <h4 class="mb-4"><i class="fas fa-users text-primary me-2"></i>Elenco Principal</h4>
                    <div class="cast-grid">
                        ${topCast.map(actor => `
                            <div class="cast-card">
                                <img src="${actor.profile_path
                ? IMAGE_BASE + '/w185' + actor.profile_path
                : '/Movie/public/images/default-user.png'}" 
                                    alt="${actor.name}"
                                    class="cast-photo"
                                    onerror="this.src='/Movie/public/images/default-user.png'">
                                <div class="cast-info">
                                    <strong>${actor.name}</strong>
                                    <small>${actor.character || 'N/A'}</small>
                                </div>
                            </div>
                        `).join('')}
                    </div>
                </div>
            </div>
        `;
    }
};

// Initialize app when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    MovieApp.init();

    // Load movie details if on movie page
    if (document.getElementById('movie')) {
        MovieApp.loadMovieDetails();
    }
});

// Export for global access
window.MovieApp = MovieApp;
window.MovieAPI = MovieAPI;
