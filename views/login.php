<?php
$title = 'Login';
include 'views/layout/header.php';
?>

<section class="page-section">
    <div class="login-wrapper">
        <div class="login-form-container">
            <h1>Admin Login</h1>
            
            <form method="POST" class="contact-form">
                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" required>
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
        </div>
    </div>
</section>

<?php include 'views/layout/footer.php'; ?>
