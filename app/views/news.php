<?php
$title = 'News - Our Website';
include 'app/views/layout/header.php';
?>

<section class="page-section">
    <h1>Latest News</h1>
    
    <div class="news-list">
        <?php if (!empty($newsList)): ?>
            <?php foreach ($newsList as $newsItem): ?>
                <article class="news-item">
                    <div class="news-header">
                        <h2><?php echo htmlspecialchars($newsItem['title']); ?></h2>
                        <span class="news-date"><?php echo date('M d, Y', strtotime($newsItem['created_at'])); ?></span>
                    </div>
                    
                    <?php if ($newsItem['image']): ?>
                        <img src="public/uploads/<?php echo htmlspecialchars($newsItem['image']); ?>" alt="<?php echo htmlspecialchars($newsItem['title']); ?>" class="news-image">
                    <?php endif; ?>
                    
                    <p><?php echo htmlspecialchars(substr($newsItem['content'], 0, 200)); ?>...</p>
                    <a href="?page=news&id=<?php echo $newsItem['id']; ?>" class="btn">Read Full Article</a>
                </article>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No news available at the moment.</p>
        <?php endif; ?>
    </div>
</section>

<?php include 'app/views/layout/footer.php'; ?>
