<?php
/**
 * Manage Users Page
 * 
 * Admin interface for user management.
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

require_once dirname(__DIR__, 3) . '/../../autoload.php';

$userModel = new \App\Models\User();

// Handle delete action
$message = '';
$messageType = '';

if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $userId = (int) $_GET['delete'];
    
    // Don't allow deleting yourself
    $userToDelete = $userModel->findById($userId);
    if ($userToDelete && strtolower($userToDelete['Username']) !== strtolower($_SESSION['username'])) {
        if ($userModel->delete($userId)) {
            $message = 'Usuário removido com sucesso!';
            $messageType = 'success';
        } else {
            $message = 'Erro ao remover usuário.';
            $messageType = 'danger';
        }
    } else {
        $message = 'Você não pode remover sua própria conta.';
        $messageType = 'warning';
    }
}

$users = $userModel->getAll(100, 0);

// Page configuration
$pageTitle = 'Gerenciar Usuários | Movies Database';
$pageDescription = 'Gerenciamento de usuários';
$currentPage = 'users';
$isAuthenticated = true;
$username = $_SESSION['username'];
$isAdmin = true;

// Include partials
$viewsPath = dirname(__DIR__) . '/';
include $viewsPath . 'partials/header.php';
include $viewsPath . 'partials/navbar.php';
?>

<!-- Users Management -->
<section class="section" style="padding-top: 120px;">
    <div class="container">
        <div class="section-title">
            <h2><i class="fas fa-users-cog text-primary"></i> Gerenciar Usuários</h2>
            <p>Visualize e gerencie os usuários do sistema</p>
        </div>
        
        <?php if ($message): ?>
            <div class="alert alert-<?= $messageType ?> alert-dismissible fade show">
                <i class="fas fa-<?= $messageType === 'success' ? 'check-circle' : ($messageType === 'warning' ? 'exclamation-triangle' : 'times-circle') ?> me-2"></i>
                <?= $message ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <div class="glass-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0"><i class="fas fa-list me-2"></i> Lista de Usuários</h4>
                <span class="badge bg-primary"><?= count($users) ?> usuários</span>
            </div>
            
            <?php if (empty($users)): ?>
                <p class="text-muted text-center">Nenhum usuário cadastrado.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Usuário</th>
                                <th>Nome Completo</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?= $user['UserId'] ?></td>
                                    <td>
                                        <i class="fas fa-user text-primary me-2"></i>
                                        <?= htmlspecialchars($user['Username']) ?>
                                    </td>
                                    <td><?= htmlspecialchars($user['Fullname']) ?></td>
                                    <td><?= htmlspecialchars($user['Email']) ?></td>
                                    <td>
                                        <span class="badge bg-<?= $user['status'] === 'admin' ? 'primary' : 'secondary' ?>">
                                            <?= htmlspecialchars($user['status']) ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <?php if (strtolower($user['Username']) !== strtolower($_SESSION['username'])): ?>
                                            <a href="?delete=<?= $user['UserId'] ?>" 
                                               class="btn btn-sm btn-outline-danger"
                                               onclick="return confirm('Tem certeza que deseja remover este usuário?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">
                                                <i class="fas fa-user-shield"></i> Você
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
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
