<?php
/**
 * Browse Movies Page
 * 
 * @package App\Views\guest
 * @author Anderson
 * @version 2.0.0
 */

session_start();

// Page configuration
$pageTitle = 'Explorar Filmes | Movies Database';
$pageDescription = 'Pesquise e explore filmes populares';
$currentPage = 'browse';
$isAuthenticated = isset($_SESSION['username']);
$username = $_SESSION['username'] ?? null;
$isAdmin = ($username && ($_SESSION['status'] ?? '') === 'admin');

// Include partials
$viewsPath = dirname(__DIR__) . '/';
include $viewsPath . 'partials/header.php';
include $viewsPath . 'partials/navbar.php';
?>

<!-- Browse Section -->
<section class="section" style="padding-top: 120px;">
    <div class="container">
        <div class="section-title">
            <h2><i class="fas fa-film text-primary"></i> Explorar Filmes</h2>
            <p>Pesquise por título ou explore os filmes populares</p>
        </div>
        
        <!-- Search Box -->
        <div class="search-container">
            <form id="searchForm" class="search-box">
                <input type="text" id="searchText" placeholder="Buscar filmes..." autocomplete="off">
                <button type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
        
        <!-- Movies Grid -->
        <div id="movies" class="movie-grid">
            <!-- Movies will be loaded here via JavaScript -->
            <div class="movie-card">
                <div class="skeleton skeleton-card"></div>
            </div>
            <div class="movie-card">
                <div class="skeleton skeleton-card"></div>
            </div>
            <div class="movie-card">
                <div class="skeleton skeleton-card"></div>
            </div>
            <div class="movie-card">
                <div class="skeleton skeleton-card"></div>
            </div>
        </div>
    </div>
</section>

<?php
if (!$isAuthenticated) {
    include $viewsPath . 'partials/modals.php';
}
include $viewsPath . 'partials/footer.php';
?>
