<?php
/**
 * Home Page - Guest View
 * 
 * Landing page for non-authenticated users.
 * 
 * @package App\Views\guest
 * @author Anderson
 * @version 2.0.0
 */

session_start();

// Redirect if already logged in
if (isset($_SESSION['username'])) {
    if ($_SESSION['status'] === 'admin') {
        header('Location: /Movie/public/admin/');
        exit;
    }
    header('Location: /Movie/public/user/');
    exit;
}

// Page configuration
$pageTitle = 'Bem-vindo | Movies Database';
$pageDescription = 'Explore informações sobre seus filmes favoritos';
$currentPage = 'home';
$isAuthenticated = false;

// Include partials
$viewsPath = dirname(__DIR__) . '/';
include $viewsPath . 'partials/header.php';
include $viewsPath . 'partials/navbar.php';
?>

<!-- Hero Section -->
<section class="hero">
    <div class="hero-content">
        <h1>Bem-vindo ao <span>Movies Database</span></h1>
        <p class="hero-description">
            Descubra informações detalhadas sobre seus filmes favoritos. 
            Explore avaliações, elenco, sinopses e muito mais, tudo em um só lugar.
        </p>
        <div class="btn-group">
            <a href="#loginModal" class="btn-primary-custom" data-bs-toggle="modal">
                <i class="fas fa-sign-in-alt"></i> Entrar
            </a>
            <a href="#registerModal" class="btn-secondary-custom" data-bs-toggle="modal">
                <i class="fas fa-user-plus"></i> Cadastrar
            </a>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="section about-section">
    <div class="container">
        <div class="section-title">
            <h2>Sobre o Projeto</h2>
            <p>Seu portal definitivo para informações sobre cinema</p>
        </div>
        <div class="about-content glass-card">
            <p>
                O <strong class="text-primary">Movies Database</strong> é uma aplicação web desenvolvida 
                para proporcionar uma experiência completa na exploração de filmes e séries. 
                Utilizamos a API do <strong>The Movie Database (TMDb)</strong> para fornecer 
                informações atualizadas e detalhadas.
            </p>
            <div class="row mt-4 text-center g-4">
                <div class="col-md-4">
                    <div class="feature-item">
                        <i class="fas fa-search fa-2x text-primary mb-3"></i>
                        <h4>Busca Avançada</h4>
                        <p class="text-muted">Encontre qualquer filme pelo título em segundos</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-item">
                        <i class="fas fa-info-circle fa-2x text-primary mb-3"></i>
                        <h4>Detalhes Completos</h4>
                        <p class="text-muted">Elenco, sinopse, avaliações e streaming</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-item">
                        <i class="fas fa-star fa-2x text-primary mb-3"></i>
                        <h4>Top Avaliados</h4>
                        <p class="text-muted">Descubra os melhores filmes de todos os tempos</p>
                    </div>
                </div>
            </div>
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

<?php
include $viewsPath . 'partials/modals.php';
include $viewsPath . 'partials/footer.php';
?>
