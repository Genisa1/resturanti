<?php
$title = 'Contact Us - Our Website';
include 'app/views/layout/header.php';
?>

<section class="page-section">
    <h1>Contact Us</h1>
    
    <div class="contact-wrapper">
        <form class="contact-form needs-validation" method="POST" action="?page=contact&action=submit" novalidate>
            <div class="form-group">
                <label for="name">Name *</label>
                <input type="text" id="name" name="name" class="form-control" required>
                <div class="invalid-feedback">Please enter your name.</div>
            </div>

            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" id="email" name="email" class="form-control" required>
                <div class="invalid-feedback">Please enter a valid email address.</div>
            </div>

            <div class="form-group">
                <label for="message">Message *</label>
                <textarea id="message" name="message" rows="8" class="form-control" required></textarea>
                <div class="invalid-feedback">Please enter a message.</div>
            </div>

            <button type="submit" class="btn btn-primary">Send Message</button>
        </form>

        <div class="contact-info">
            <h3>Other Ways to Reach Us</h3>
            <p>
                <strong>Email:</strong> info@example.com<br>
                <strong>Phone:</strong> +1 (555) 123-4567<br>
                <strong>Address:</strong> 123 Main Street, City, State 12345
            </p>
        </div>
    </div>
</section>

<?php include 'app/views/layout/footer.php'; ?>
