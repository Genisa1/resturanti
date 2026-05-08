<?php
$title = isset($product) ? htmlspecialchars($product['title']) . ' - Our Website' : 'Product Detail';
include 'app/views/layout/header.php';
?>

<section class="page-section">
    <?php if (isset($product)): ?>
        <div class="product-detail">
            <?php if ($product['image']): ?>
                <img src="public/uploads/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['title']); ?>" class="product-image">
            <?php endif; ?>
            
            <h1><?php echo htmlspecialchars($product['title']); ?></h1>
            <p class="product-creator">Created by: <?php echo htmlspecialchars($product['creator_name']); ?></p>
            
            <div class="product-description">
                <?php echo nl2br(htmlspecialchars($product['description'])); ?>
            </div>

            <?php if ($product['pdf']): ?>
                <a href="public/uploads/<?php echo htmlspecialchars($product['pdf']); ?>" class="btn btn-primary" download>Download PDF</a>
            <?php endif; ?>

            <a href="?page=products" class="btn">Back to Products</a>
        </div>
    <?php else: ?>
        <p>Product not found.</p>
        <a href="?page=products" class="btn">Back to Products</a>
    <?php endif; ?>
</section>

<?php include 'app/views/layout/footer.php'; ?>
