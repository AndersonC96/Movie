<?php
/**
 * Request Movie Page
 * 
 * Allows users to request new movies.
 * 
 * @package App\Views\user
 * @author Anderson
 * @version 2.0.0
 */

session_start();

// Redirect if not logged in
if (!isset($_SESSION['username'])) {
    header('Location: /Movie/public/');
    exit;
}

// Handle form submission
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once dirname(__DIR__, 4) . '/autoload.php';
    
    $requestModel = new \App\Models\Request();
    
    $data = [
        'user'    => $_SESSION['username'],
        'title'   => htmlspecialchars(trim($_POST['title'] ?? ''), ENT_QUOTES, 'UTF-8'),
        'message' => htmlspecialchars(trim($_POST['message'] ?? ''), ENT_QUOTES, 'UTF-8')
    ];
    
    if (empty($data['title'])) {
        $message = 'Por favor, informe o título do filme.';
        $messageType = 'danger';
    } else {
        $result = $requestModel->create($data);
        
        if ($result) {
            $message = 'Solicitação enviada com sucesso!';
            $messageType = 'success';
        } else {
            $message = 'Erro ao enviar solicitação. Tente novamente.';
            $messageType = 'danger';
        }
    }
}

// Page configuration
$pageTitle = 'Solicitar Filme | Movies Database';
$pageDescription = 'Solicite novos filmes para nossa base de dados';
$currentPage = 'request';
$isAuthenticated = true;
$username = $_SESSION['username'];
$isAdmin = ($_SESSION['status'] ?? '') === 'admin';

// Include partials
$viewsPath = dirname(__DIR__) . '/';
include $viewsPath . 'partials/header.php';
include $viewsPath . 'partials/navbar.php';
?>

<!-- Request Section -->
<section class="section" style="padding-top: 120px; min-height: 80vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="glass-card">
                    <div class="text-center mb-4">
                        <i class="fas fa-film fa-3x text-primary mb-3"></i>
                        <h2>Solicitar Filme</h2>
                        <p class="text-muted">Não encontrou o que procura? Solicite aqui!</p>
                    </div>
                    
                    <?php if ($message): ?>
                        <div class="alert alert-<?= $messageType ?> alert-dismissible fade show">
                            <i class="fas fa-<?= $messageType === 'success' ? 'check-circle' : 'exclamation-circle' ?> me-2"></i>
                            <?= $message ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST" action="">
                        <div class="form-group mb-3">
                            <label class="form-label text-muted">Título do Filme *</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-film"></i></span>
                                <input type="text" name="title" class="form-input" 
                                       placeholder="Ex: Avengers: Endgame" required>
                            </div>
                        </div>
                        
                        <div class="form-group mb-4">
                            <label class="form-label text-muted">Mensagem (opcional)</label>
                            <textarea name="message" class="form-input" rows="4" 
                                      placeholder="Informações adicionais sobre o filme..."></textarea>
                        </div>
                        
                        <button type="submit" class="form-btn">
                            <i class="fas fa-paper-plane me-2"></i> Enviar Solicitação
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include $viewsPath . 'partials/footer.php'; ?>
