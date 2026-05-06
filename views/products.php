<?php
$title = 'Products - Our Website';
include 'views/layout/header.php';
?>

<section class="page-section">
    <h1>Our Products</h1>
    
    <div class="products-grid">
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <div class="product-card">
                    <?php if ($product['image']): ?>
                        <img src="public/uploads/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['title']); ?>">
                    <?php endif; ?>
                    <h3><?php echo htmlspecialchars($product['title']); ?></h3>
                    <p><?php echo htmlspecialchars(substr($product['description'], 0, 150)); ?>...</p>
                    <a href="?page=products&id=<?php echo $product['id']; ?>" class="btn">View Details</a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No products available at the moment.</p>
        <?php endif; ?>
    </div>
</section>

<?php include 'views/layout/footer.php'; ?>
