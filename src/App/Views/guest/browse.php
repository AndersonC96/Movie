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

        <!-- Filters -->
        <div class="row mb-4 align-items-center">
            <div class="col-md-6 mb-3 mb-md-0">
                <div class="d-flex gap-2">
                    <select id="genreSelect" class="form-select bg-dark text-white border-secondary">
                        <option value="">Todos os Gêneros</option>
                        <!-- Populated via JS -->
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-md-end align-items-center gap-2">
                    <label class="text-muted small text-nowrap">Ordenar por:</label>
                    <select id="sortSelect" class="form-select bg-dark text-white border-secondary w-auto">
                        <option value="popularity.desc">Mais Populares</option>
                        <option value="vote_average.desc">Melhor Avaliados</option>
                        <option value="primary_release_date.desc">Lançamentos</option>
                        <option value="title.asc">A-Z</option>
                    </select>
                </div>
            </div>
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

        <!-- Load More -->
        <div class="text-center mt-5 mb-5">
            <button id="loadMoreBtn" class="btn btn-outline-custom rounded-pill px-5 py-2" style="display: none;">
                Carregar Mais
            </button>
        </div>
    </div>
</section>

<?php
if (!$isAuthenticated) {
    include $viewsPath . 'partials/modals.php';
}
include $viewsPath . 'partials/footer.php';
?>
