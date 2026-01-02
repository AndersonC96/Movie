    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>
                <i class="fas fa-code"></i> Desenvolvido com 
                <i class="fas fa-heart text-primary"></i> por 
                <a href="https://github.com/AndersonC96" target="_blank">Anderson</a>
            </p>
            <p class="text-muted small">
                Dados fornecidos por 
                <a href="https://www.themoviedb.org/" target="_blank">TMDb</a>
            </p>
        </div>
    </footer>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script src="/Movie/public/js/app.js"></script>
    
    <?php if (isset($additionalJs)): ?>
        <?= $additionalJs ?>
    <?php endif; ?>
</body>
</html>
