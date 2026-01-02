<?php
/**
 * Home Page - User View
 * 
 * Dashboard for authenticated regular users.
 * 
 * @package App\Views\user
 * @author Anderson
 * @version 2.0.0
 */

session_start();

// Redirect if not logged in or is admin
if (!isset($_SESSION['username'])) {
    header('Location: /Movie/public/');
    exit;
}

if ($_SESSION['status'] === 'admin') {
    header('Location: /Movie/public/admin/');
    exit;
}

// Page configuration
$pageTitle = 'Dashboard | Movies Database';
$pageDescription = 'Seu painel de controle';
$currentPage = 'home';
$isAuthenticated = true;
$username = $_SESSION['username'];
$isAdmin = false;

// Include partials
$viewsPath = dirname(__DIR__) . '/';
include $viewsPath . 'partials/header.php';
include $viewsPath . 'partials/navbar.php';
?>

<!-- Hero Section -->
<section class="hero" style="min-height: 60vh;">
    <div class="hero-content">
        <h1>Bem-vindo, <span><?= htmlspecialchars(ucfirst($username)) ?></span>!</h1>
        <p class="hero-description">
            Explore nosso catálogo de filmes, faça solicitações e descubra novos títulos.
        </p>
        <div class="btn-group">
            <a href="/Movie/public/browse.php" class="btn-primary-custom">
                <i class="fas fa-film"></i> Explorar Filmes
            </a>
            <a href="/Movie/public/request.php" class="btn-secondary-custom">
                <i class="fas fa-plus-circle"></i> Solicitar Filme
            </a>
        </div>
    </div>
</section>

<!-- Top Rated Movies Carousel -->
<section class="section carousel-section">
    <div class="container">
        <div class="section-title">
            <h2><i class="fas fa-trophy text-primary"></i> Filmes Mais Bem Avaliados</h2>
            <p>Os clássicos que você precisa assistir</p>
        </div>
        
        <div id="topMoviesCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#topMoviesCarousel" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#topMoviesCarousel" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#topMoviesCarousel" data-bs-slide-to="2"></button>
                <button type="button" data-bs-target="#topMoviesCarousel" data-bs-slide-to="3"></button>
                <button type="button" data-bs-target="#topMoviesCarousel" data-bs-slide-to="4"></button>
            </div>
            
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div id="topMovies1" class="movie-grid"></div>
                </div>
                <div class="carousel-item">
                    <div id="topMovies2" class="movie-grid"></div>
                </div>
                <div class="carousel-item">
                    <div id="topMovies3" class="movie-grid"></div>
                </div>
                <div class="carousel-item">
                    <div id="topMovies4" class="movie-grid"></div>
                </div>
                <div class="carousel-item">
                    <div id="topMovies5" class="movie-grid"></div>
                </div>
            </div>
            
            <button class="carousel-control-prev" type="button" data-bs-target="#topMoviesCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#topMoviesCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </div>
</section>

<?php include $viewsPath . 'partials/footer.php'; ?>
