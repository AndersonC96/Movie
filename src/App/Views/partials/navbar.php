<?php
/**
 * Navbar Partial
 * 
 * @var string $currentPage Current page identifier
 * @var bool $isAuthenticated Whether user is logged in
 * @var string|null $username Current user's username
 * @var bool $isAdmin Whether user is admin
 */

$isAuthenticated = $isAuthenticated ?? false;
$username = $username ?? null;
$isAdmin = $isAdmin ?? false;
$currentPage = $currentPage ?? 'home';
?>

<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <!-- Brand -->
        <a class="navbar-brand" href="/Movie/public/">
            <img src="/Movie/public/images/icon.png" alt="Movies Database Logo">
            <span>Movies</span> Database
        </a>
        
        <!-- Mobile Toggle -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <!-- Nav Items -->
        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav ms-auto align-items-center gap-1">
                <li class="nav-item">
                    <a class="nav-link <?= $currentPage === 'home' ? 'active' : '' ?>" href="/Movie/public/">
                        <i class="fas fa-home"></i> Home
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link <?= $currentPage === 'browse' ? 'active' : '' ?>" href="/Movie/public/browse.php">
                        <i class="fas fa-film"></i> Filmes
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link <?= $currentPage === 'series' ? 'active' : '' ?>" href="/Movie/public/series.php">
                        <i class="fas fa-tv"></i> Séries
                    </a>
                </li>
                
                <?php if ($isAuthenticated && !$isAdmin): ?>
                    <li class="nav-item">
                        <a class="nav-link <?= $currentPage === 'request' ? 'active' : '' ?>" href="/Movie/public/request.php">
                            <i class="fas fa-plus-circle"></i> Solicitar
                        </a>
                    </li>
                <?php endif; ?>
                
                <?php if ($isAdmin): ?>
                    <li class="nav-item">
                        <a class="nav-link <?= $currentPage === 'users' ? 'active' : '' ?>" href="/Movie/public/admin/users.php">
                            <i class="fas fa-users"></i> Usuários
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $currentPage === 'requests' ? 'active' : '' ?>" href="/Movie/public/admin/requests.php">
                            <i class="fas fa-list"></i> Solicitações
                        </a>
                    </li>
                <?php endif; ?>
                
                <?php if ($isAuthenticated): ?>
                    <!-- User Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" 
                           href="#" role="button" data-bs-toggle="dropdown">
                            <img src="/Movie/public/images/default-user.png" 
                                 alt="<?= htmlspecialchars($username) ?>" 
                                 class="user-avatar">
                            <span class="d-none d-lg-inline"><?= htmlspecialchars($username) ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <span class="dropdown-item-text text-muted">
                                    <i class="fas fa-user me-2"></i>
                                    <?= htmlspecialchars($username) ?>
                                </span>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="/Movie/public/auth.php?action=logout">
                                    <i class="fas fa-sign-out-alt me-2"></i> Sair
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="#loginModal" data-bs-toggle="modal">
                            <i class="fas fa-sign-in-alt"></i> Entrar
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn-primary-custom btn-sm" href="#registerModal" data-bs-toggle="modal">
                            Cadastrar
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
