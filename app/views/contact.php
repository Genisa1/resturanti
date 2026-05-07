<?php
$title = 'Contact Us - Our Website';
include 'app/views/layout/header.php';
?>

<section class="page-section">
    <h1>Contact Us</h1>
    
    <div class="contact-wrapper">
        <form class="contact-form" method="POST" action="?page=contact&action=submit">
            <div class="form-group">
                <label for="name">Name *</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="message">Message *</label>
                <textarea id="message" name="message" rows="8" required></textarea>
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
