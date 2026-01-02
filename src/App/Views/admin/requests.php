<?php
/**
 * Movie Requests Page (Admin)
 * 
 * View and manage movie requests.
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

$requestModel = new \App\Models\Request();

// Handle delete action
$message = '';
$messageType = '';

if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $requestId = (int) $_GET['delete'];
    
    if ($requestModel->delete($requestId)) {
        $message = 'Solicitação removida com sucesso!';
        $messageType = 'success';
    } else {
        $message = 'Erro ao remover solicitação.';
        $messageType = 'danger';
    }
}

$requests = $requestModel->getAll(100, 0);

// Page configuration
$pageTitle = 'Solicitações de Filmes | Movies Database';
$pageDescription = 'Gerenciar solicitações de filmes';
$currentPage = 'requests';
$isAuthenticated = true;
$username = $_SESSION['username'];
$isAdmin = true;

// Include partials
$viewsPath = dirname(__DIR__) . '/';
include $viewsPath . 'partials/header.php';
include $viewsPath . 'partials/navbar.php';
?>

<!-- Requests Management -->
<section class="section" style="padding-top: 120px;">
    <div class="container">
        <div class="section-title">
            <h2><i class="fas fa-list-alt text-primary"></i> Solicitações de Filmes</h2>
            <p>Visualize as solicitações enviadas pelos usuários</p>
        </div>
        
        <?php if ($message): ?>
            <div class="alert alert-<?= $messageType ?> alert-dismissible fade show">
                <i class="fas fa-<?= $messageType === 'success' ? 'check-circle' : 'times-circle' ?> me-2"></i>
                <?= $message ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <div class="glass-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0"><i class="fas fa-film me-2"></i> Lista de Solicitações</h4>
                <span class="badge bg-primary"><?= count($requests) ?> solicitações</span>
            </div>
            
            <?php if (empty($requests)): ?>
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Nenhuma solicitação recebida ainda.</p>
                </div>
            <?php else: ?>
                <div class="row g-4">
                    <?php foreach ($requests as $req): ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="glass-card h-100" style="background: rgba(255,255,255,0.02);">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <h5 class="mb-0 text-primary">
                                        <i class="fas fa-film me-2"></i>
                                        <?= htmlspecialchars($req['RequestTitle']) ?>
                                    </h5>
                                    <a href="?delete=<?= $req['RequestId'] ?>" 
                                       class="btn btn-sm btn-outline-danger"
                                       onclick="return confirm('Remover esta solicitação?')">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </div>
                                
                                <?php if (!empty($req['RequestMessage'])): ?>
                                    <p class="text-muted small mb-3">
                                        "<?= htmlspecialchars($req['RequestMessage']) ?>"
                                    </p>
                                <?php endif; ?>
                                
                                <div class="d-flex align-items-center gap-2">
                                    <img src="/Movie/public/images/default-user.png" 
                                         alt="user" class="user-avatar" style="width: 24px; height: 24px;">
                                    <span class="text-muted small">
                                        <?= htmlspecialchars($req['RequestUser']) ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="text-center mt-4">
            <a href="/Movie/public/admin/" class="btn-secondary-custom">
                <i class="fas fa-arrow-left me-2"></i> Voltar ao Dashboard
            </a>
        </div>
    </div>
</section>

<?php include $viewsPath . 'partials/footer.php'; ?>
