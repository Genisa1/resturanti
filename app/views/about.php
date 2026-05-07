<?php
$title = 'About Us - Our Website';
include 'app/views/layout/header.php';
?>

<section class="page-section">
    <h1><?php echo isset($page) ? htmlspecialchars($page['title']) : 'About Us'; ?></h1>
    <div class="page-content">
        <?php if (isset($page)): ?>
            <?php echo $page['content']; ?>
        <?php else: ?>
            <p>Page content not found.</p>
        <?php endif; ?>
    </div>
</section>

<?php include 'app/views/layout/footer.php'; ?>
