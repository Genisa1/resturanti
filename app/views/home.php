<?php
$title = 'Home - Our Website';
include 'app/views/layout/header.php';
?>

<section class="hero text-center py-5 hero-bg">
    <div class="hero-overlay"></div>
    <div class="container hero-content">
        <h1>Kosova Sot</h1>
        <p class="lead mx-auto" style="max-width:760px">Këtu mund të gjeni lajmet më të fundit nga Kosova.</p>
        <div class="hero-actions">
            <a href="?page=news" class="btn btn-outline">Shfleto të gjitha lajmet</a>
        </div>
    </div>
</section>

<?php if (!empty($featuredProducts)): ?>
<section class="home-slider-section">
    <div class="swiper mySwiper">
        <div class="swiper-wrapper">
            <?php foreach (array_slice($featuredProducts, 0, 5) as $slideProduct): ?>
                <div class="swiper-slide">
                    <?php if ($slideProduct['image']): ?>
                        <img src="public/uploads/<?php echo htmlspecialchars($slideProduct['image']); ?>" alt="<?php echo htmlspecialchars($slideProduct['title']); ?>">
                    <?php endif; ?>
                    <div class="slide-caption">
                        <span>Featured Product</span>
                        <h2><?php echo htmlspecialchars($slideProduct['title']); ?></h2>
                        <p><?php echo substr(htmlspecialchars($slideProduct['description']), 0, 120); ?>...</p>
                        <a href="?page=products&id=<?php echo $slideProduct['id']; ?>" class="btn btn-primary">View Product</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
    </div>
</section>
<?php endif; ?>

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

<?php include 'app/views/layout/footer.php'; ?>
