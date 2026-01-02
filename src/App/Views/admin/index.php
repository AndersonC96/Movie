<?php
/**
 * Admin Dashboard
 * 
 * Main admin panel with overview.
 * 
 * @package App\Views\admin
 * @author Anderson
 * @version 2.0.0
 */

session_start();

// Require admin access
if (!isset($_SESSION['username']) || $_SESSION['status'] !== 'admin') {
    header('Location: /Movie/public/');
    exit;
}

require_once dirname(__DIR__, 4) . '/autoload.php';

$userModel = new \App\Models\User();
$requestModel = new \App\Models\Request();

$totalUsers = $userModel->count();
$totalRequests = $requestModel->count();
$recentUsers = $userModel->getAll(5, 0);
$recentRequests = $requestModel->getAll(5, 0);

// Page configuration
$pageTitle = 'Admin Dashboard | Movies Database';
$pageDescription = 'Painel administrativo';
$currentPage = 'home';
$isAuthenticated = true;
$username = $_SESSION['username'];
$isAdmin = true;

// Include partials
$viewsPath = dirname(__DIR__) . '/';
include $viewsPath . 'partials/header.php';
include $viewsPath . 'partials/navbar.php';
?>

<!-- Admin Dashboard -->
<section class="section" style="padding-top: 120px;">
    <div class="container">
        <div class="section-title">
            <h2><i class="fas fa-tachometer-alt text-primary"></i> Painel Administrativo</h2>
            <p>Visão geral do sistema</p>
        </div>
        
        <!-- Stats Cards -->
        <div class="row g-4 mb-5">
            <div class="col-md-6 col-lg-3">
                <div class="glass-card text-center">
                    <i class="fas fa-users fa-2x text-primary mb-3"></i>
                    <h3 class="mb-0"><?= $totalUsers ?></h3>
                    <p class="text-muted mb-0">Usuários</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="glass-card text-center">
                    <i class="fas fa-film fa-2x text-primary mb-3"></i>
                    <h3 class="mb-0"><?= $totalRequests ?></h3>
                    <p class="text-muted mb-0">Solicitações</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="glass-card text-center">
                    <i class="fas fa-check-circle fa-2x text-primary mb-3"></i>
                    <h3 class="mb-0">Online</h3>
                    <p class="text-muted mb-0">Status API</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="glass-card text-center">
                    <i class="fas fa-code fa-2x text-primary mb-3"></i>
                    <h3 class="mb-0">2.0</h3>
                    <p class="text-muted mb-0">Versão</p>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="row g-4 mb-5">
            <div class="col-md-6">
                <a href="/Movie/public/admin/users.php" class="glass-card d-block text-decoration-none">
                    <div class="d-flex align-items-center gap-3">
                        <i class="fas fa-users-cog fa-2x text-primary"></i>
                        <div>
                            <h4 class="mb-0 text-white">Gerenciar Usuários</h4>
                            <p class="text-muted mb-0">Visualizar, editar e remover usuários</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6">
                <a href="/Movie/public/admin/requests.php" class="glass-card d-block text-decoration-none">
                    <div class="d-flex align-items-center gap-3">
                        <i class="fas fa-list-alt fa-2x text-primary"></i>
                        <div>
                            <h4 class="mb-0 text-white">Solicitações de Filmes</h4>
                            <p class="text-muted mb-0">Ver solicitações dos usuários</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        
        <!-- Recent Activity -->
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="glass-card">
                    <h4 class="mb-4"><i class="fas fa-users text-primary me-2"></i> Usuários Recentes</h4>
                    <?php if (empty($recentUsers)): ?>
                        <p class="text-muted">Nenhum usuário cadastrado.</p>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-dark table-hover">
                                <thead>
                                    <tr>
                                        <th>Usuário</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recentUsers as $user): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($user['Username']) ?></td>
                                            <td><?= htmlspecialchars($user['Email']) ?></td>
                                            <td>
                                                <span class="badge bg-<?= $user['status'] === 'admin' ? 'primary' : 'secondary' ?>">
                                                    <?= htmlspecialchars($user['status']) ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="glass-card">
                    <h4 class="mb-4"><i class="fas fa-film text-primary me-2"></i> Solicitações Recentes</h4>
                    <?php if (empty($recentRequests)): ?>
                        <p class="text-muted">Nenhuma solicitação recebida.</p>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-dark table-hover">
                                <thead>
                                    <tr>
                                        <th>Filme</th>
                                        <th>Usuário</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recentRequests as $req): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($req['RequestTitle']) ?></td>
                                            <td><?= htmlspecialchars($req['RequestUser']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include $viewsPath . 'partials/footer.php'; ?>
