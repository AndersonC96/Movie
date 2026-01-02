<?php
/**
 * Movie Details Page
 * 
 * @package App\Views\guest
 * @author Anderson
 * @version 2.0.0
 */

session_start();

// Page configuration
$pageTitle = 'Detalhes do Filme | Movies Database';
$pageDescription = 'Informações detalhadas sobre o filme';
$currentPage = 'browse';
$isAuthenticated = isset($_SESSION['username']);
$username = $_SESSION['username'] ?? null;
$isAdmin = ($username && ($_SESSION['status'] ?? '') === 'admin');

// Additional CSS for movie details
$additionalCss = '<style>
.movie-details {
    position: relative;
    min-height: 100vh;
    padding-top: 80px;
}

.movie-backdrop {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 60vh;
    background-size: cover;
    background-position: center top;
    z-index: -1;
}

.movie-backdrop::after {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(
        to bottom,
        rgba(13, 13, 13, 0.6) 0%,
        rgba(13, 13, 13, 0.9) 70%,
        var(--bg-primary) 100%
    );
}

.movie-content {
    position: relative;
    padding: var(--spacing-xxl);
}

.movie-poster {
    width: 100%;
    max-width: 350px;
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-lg);
}

.movie-title {
    font-size: 2.5rem;
    margin-bottom: var(--spacing-sm);
}

.movie-meta {
    display: flex;
    gap: var(--spacing-md);
    color: var(--text-secondary);
    margin-bottom: var(--spacing-md);
}

.movie-rating-large {
    display: inline-flex;
    align-items: center;
    gap: var(--spacing-sm);
    font-size: 1.5rem;
    font-weight: 700;
}

.movie-rating-large i {
    color: #FFD700;
    font-size: 1.8rem;
}

.movie-rating-large small {
    font-weight: 400;
    color: var(--text-muted);
}

.movie-info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: var(--spacing-md);
}

.info-item {
    background: var(--glass-bg);
    padding: var(--spacing-md);
    border-radius: var(--radius-sm);
    border: 1px solid var(--glass-border);
}

.info-item strong {
    display: block;
    color: var(--text-muted);
    font-size: 0.875rem;
    margin-bottom: var(--spacing-xs);
}

.info-item span {
    color: var(--text-primary);
}

@media (max-width: 768px) {
    .movie-poster {
        margin: 0 auto var(--spacing-xl);
        display: block;
    }
    
    .movie-title {
        font-size: 1.75rem;
    }
}
</style>';

// Include partials
$viewsPath = dirname(__DIR__) . '/';
include $viewsPath . 'partials/header.php';
include $viewsPath . 'partials/navbar.php';
?>

<!-- Movie Details Section -->
<section id="movie" class="movie-details">
    <!-- Content will be loaded via JavaScript -->
    <div class="container text-center py-5">
        <div class="skeleton" style="width: 200px; height: 300px; margin: 0 auto;"></div>
        <div class="skeleton skeleton-text mt-4 mx-auto" style="width: 300px;"></div>
        <div class="skeleton skeleton-text-sm mt-2 mx-auto" style="width: 200px;"></div>
    </div>
</section>

<?php
if (!$isAuthenticated) {
    include $viewsPath . 'partials/modals.php';
}
include $viewsPath . 'partials/footer.php';
?>
