<?php include 'app/views/layout/header.php'; ?>

<div class="auth-container">
    <div class="auth-form">
        <h2>Register</h2>

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

        <form method="POST" action="?page=register">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" required
                       value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required
                       value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required
                       minlength="6">
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required
                       minlength="6">
            </div>

            <button type="submit" class="btn btn-primary">Register</button>
        </form>

        <p class="auth-links">
            Already have an account? <a href="?page=login">Login here</a>
        </p>
    </div>
</div>

<?php include 'app/views/layout/footer.php'; ?>