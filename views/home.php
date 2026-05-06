<?php
$title = 'Home - Our Website';
include 'views/layout/header.php';
?>

<section class="hero">
    <h1>Welcome to Our Website</h1>
    <p><?php echo $page['content'] ?? 'Welcome to our website'; ?></p>
</section>

<section class="latest-news">
    <h2>Latest News</h2>
    <div class="news-grid">
        <?php if (!empty($latestNews)): ?>
            <?php foreach ($latestNews as $newsItem): ?>
                <article class="news-card">
                    <?php if ($newsItem['image']): ?>
                        <img src="public/uploads/<?php echo htmlspecialchars($newsItem['image']); ?>" alt="<?php echo htmlspecialchars($newsItem['title']); ?>">
                    <?php endif; ?>
                    <h3><?php echo htmlspecialchars($newsItem['title']); ?></h3>
                    <p><?php echo substr(htmlspecialchars($newsItem['content']), 0, 150) . '...'; ?></p>
                    <a href="?page=news&id=<?php echo $newsItem['id']; ?>" class="btn">Read More</a>
                </article>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No news available at the moment.</p>
        <?php endif; ?>
    </div>
</section>

<section class="featured-products">
    <h2>Our Products</h2>
    <div class="products-grid">
        <?php if (!empty($featuredProducts)): ?>
            <?php foreach (array_slice($featuredProducts, 0, 6) as $product): ?>
                <div class="product-card">
                    <?php if ($product['image']): ?>
                        <img src="public/uploads/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['title']); ?>">
                    <?php endif; ?>
                    <h3><?php echo htmlspecialchars($product['title']); ?></h3>
                    <p><?php echo substr(htmlspecialchars($product['description']), 0, 100) . '...'; ?></p>
                    <a href="?page=products&id=<?php echo $product['id']; ?>" class="btn">View Details</a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No products available at the moment.</p>
        <?php endif; ?>
    </div>
</section>

<?php include 'views/layout/footer.php'; ?>
