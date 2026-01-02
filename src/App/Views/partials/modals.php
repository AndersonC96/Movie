<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="loginModalLabel">
                    <i class="fas fa-sign-in-alt me-2"></i> Entrar
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <form action="/Movie/public/auth.php?action=login" method="POST">
                    <div class="form-group mb-3">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" name="username" class="form-input" 
                                   placeholder="Usuário" required autocomplete="username">
                        </div>
                    </div>
                    
                    <div class="form-group mb-3">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" name="password" class="form-input" 
                                   placeholder="Senha" required autocomplete="current-password">
                        </div>
                    </div>
                    
                    <button type="submit" class="form-btn">
                        <i class="fas fa-arrow-right me-2"></i> Entrar
                    </button>
                </form>
                
                <div class="text-center mt-4">
                    <p class="text-muted">
                        Não tem conta? 
                        <a href="#registerModal" data-bs-toggle="modal" data-bs-dismiss="modal">
                            Cadastre-se
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Register Modal -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="registerModalLabel">
                    <i class="fas fa-user-plus me-2"></i> Cadastrar
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <form action="/Movie/public/auth.php?action=register" method="POST">
                    <div class="form-group mb-3">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" name="fullname" class="form-input" 
                                   placeholder="Nome completo" required>
                        </div>
                    </div>
                    
                    <div class="form-group mb-3">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" name="email" class="form-input" 
                                   placeholder="Email" required autocomplete="email">
                        </div>
                    </div>
                    
                    <div class="form-group mb-3">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-at"></i></span>
                            <input type="text" name="username" class="form-input" 
                                   placeholder="Nome de usuário" required autocomplete="username">
                        </div>
                    </div>
                    
                    <div class="form-group mb-3">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" name="password" class="form-input" 
                                   placeholder="Senha (mínimo 6 caracteres)" required 
                                   minlength="6" autocomplete="new-password">
                        </div>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label class="form-checkbox">
                            <input type="checkbox" name="terms" required>
                            Li e aceito os <a href="#">Termos de Uso</a>
                        </label>
                    </div>
                    
                    <button type="submit" class="form-btn">
                        <i class="fas fa-check me-2"></i> Criar Conta
                    </button>
                </form>
                
                <div class="text-center mt-4">
                    <p class="text-muted">
                        Já tem conta? 
                        <a href="#loginModal" data-bs-toggle="modal" data-bs-dismiss="modal">
                            Entrar
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content text-center">
            <div class="modal-body py-5">
                <i class="fas fa-check-circle text-primary fa-4x mb-3"></i>
                <h5>Conta criada com sucesso!</h5>
                <p class="text-muted">Agora você pode fazer login.</p>
                <a href="#loginModal" class="btn-primary-custom" data-bs-toggle="modal" data-bs-dismiss="modal">
                    Entrar
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Error Modal -->
<div class="modal fade" id="errorModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content text-center">
            <div class="modal-body py-5">
                <i class="fas fa-exclamation-circle text-danger fa-4x mb-3"></i>
                <h5>Erro!</h5>
                <p class="text-muted" id="errorMessage">Usuário ou email já existe.</p>
                <button type="button" class="btn-secondary-custom" data-bs-dismiss="modal">
                    Fechar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Show modals based on URL hash
document.addEventListener('DOMContentLoaded', function() {
    const hash = window.location.hash;
    
    if (hash === '#success') {
        new bootstrap.Modal(document.getElementById('successModal')).show();
        history.replaceState(null, null, ' ');
    } else if (hash === '#error') {
        document.getElementById('errorMessage').textContent = 'Usuário ou email já existe.';
        new bootstrap.Modal(document.getElementById('errorModal')).show();
        history.replaceState(null, null, ' ');
    } else if (hash === '#error1') {
        document.getElementById('errorMessage').textContent = 'Usuário ou senha inválidos.';
        new bootstrap.Modal(document.getElementById('errorModal')).show();
        history.replaceState(null, null, ' ');
    }
});
</script>
