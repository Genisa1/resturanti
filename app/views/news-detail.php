<?php
$title = isset($newsItem) ? htmlspecialchars($newsItem['title']) . ' - Our Website' : 'News Detail';
include 'app/views/layout/header.php';
?>

<section class="page-section">
    <?php if (isset($newsItem)): ?>
        <article class="news-detail">
            <h1><?php echo htmlspecialchars($newsItem['title']); ?></h1>
            
            <div class="news-meta">
                <span class="news-date"><?php echo date('M d, Y', strtotime($newsItem['created_at'])); ?></span>
                <span class="news-author">By: <?php echo htmlspecialchars($newsItem['creator_name']); ?></span>
            </div>

            <?php if ($newsItem['image']): ?>
                <img src="public/uploads/<?php echo htmlspecialchars($newsItem['image']); ?>" alt="<?php echo htmlspecialchars($newsItem['title']); ?>" class="news-image">
            <?php endif; ?>
            
            <div class="news-content">
                <?php echo $newsItem['content']; ?>
            </div>

            <a href="?page=news" class="btn">Back to News</a>
        </article>
    <?php else: ?>
        <p>News article not found.</p>
        <a href="?page=news" class="btn">Back to News</a>
    <?php endif; ?>
</section>

<?php include 'app/views/layout/footer.php'; ?>
