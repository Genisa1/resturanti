<?php
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ?page=login');
    exit;
}
$title = 'Manage News - Admin';
include 'app/views/layout/header.php';
?>

<section class="admin-section">
    <div class="admin-sidebar">
        <h2>Admin Menu</h2>
        <ul>
            <li><a href="?page=admin&action=dashboard">Dashboard</a></li>
            <li><a href="?page=admin&action=manageUsers">Users</a></li>
            <li><a href="?page=admin&action=manageProducts">Products</a></li>
            <li><a href="?page=admin&action=manageNews" class="active">News</a></li>
            <li><a href="?page=admin&action=managePages">Pages</a></li>
            <li><a href="?page=admin&action=viewContacts">Messages</a></li>
        </ul>
    </div>

    <div class="admin-content">
        <h1>Manage News</h1>
        
        <?php $task = $_GET['task'] ?? 'list'; ?>
        <?php if ($task === 'add' || $task === 'edit'): ?>
            <div class="form-wrapper">
                <h2><?php echo $task === 'add' ? 'Add News Article' : 'Edit News'; ?></h2>
                
                <?php if ($task === 'add'): ?>
                    <form method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        <div class="form-group">
                            <label for="title">Title *</label>
                            <input type="text" id="title" name="title" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="content">Content *</label>
                            <textarea id="content" name="content" class="form-control" rows="8" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" id="image" name="image" accept="image/*">
                        </div>

                        <button type="submit" class="btn btn-primary">Save News</button>
                        <a href="?page=admin&action=manageNews" class="btn">Cancel</a>
                    </form>
                <?php elseif ($task === 'edit' && isset($newsItem) && $newsItem): ?>
                    <form method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        
                        <div class="form-group">
                            <label for="title">Title *</label>
                            <input type="text" id="title" name="title" class="form-control" value="<?php echo htmlspecialchars($newsItem['title']); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="content">Content *</label>
                            <textarea id="content" name="content" class="form-control" rows="8" required><?php echo htmlspecialchars($newsItem['content']); ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" id="image" name="image" class="form-control" accept="image/*">
                            <?php if (!empty($newsItem['image'])): ?>
                                <p>Current file: <?php echo htmlspecialchars($newsItem['image']); ?></p>
                            <?php endif; ?>
                        </div>

                        <button type="submit" class="btn btn-primary">Save News</button>
                        <a href="?page=admin&action=manageNews" class="btn">Cancel</a>
                    </form>
                <?php else: ?>
                    <div class="alert alert-error">Unable to load news for editing.</div>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <a href="?page=admin&action=manageNews&task=add" class="btn btn-primary">+ Add News</a>
            
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Creator</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($newsList)): ?>
                        <?php foreach ($newsList as $newsItem): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($newsItem['title']); ?></td>
                                <td><?php echo htmlspecialchars($newsItem['creator_name']); ?></td>
                                <td><?php echo date('M d, Y', strtotime($newsItem['created_at'])); ?></td>
                                <td>
                                    <a href="?page=admin&action=manageNews&task=edit&id=<?php echo $newsItem['id']; ?>" class="btn-small">Edit</a>
                                    <a href="?page=admin&action=manageNews&task=delete&id=<?php echo $newsItem['id']; ?>" class="btn-small btn-danger" onclick="return confirm('Are you sure?');">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">No news articles found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</section>

<?php include 'app/views/layout/footer.php'; ?>
