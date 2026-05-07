<?php
$title = 'Login';
include 'app/views/layout/header.php';
?>

<section class="page-section">
    <div class="login-wrapper">
        <div class="login-form-container">
            <h1>Admin Login</h1>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-error">
                    <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="contact-form">
                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" required
                           value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                </div>

                <div class="form-group">
                    <label for="password">Password *</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <button type="submit" class="btn btn-primary">Login</button>
            </form>

            <p class="login-info">
                Demo Credentials:<br>
                Email: admin@example.com<br>
                Password: admin123
            </p>

            <p class="auth-links">
                Don't have an account? <a href="?page=register">Register here</a>
            </p>
        </div>
    </div>
</section>

<?php include 'app/views/layout/footer.php'; ?>
