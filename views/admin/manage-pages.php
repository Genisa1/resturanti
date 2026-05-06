<?php
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ?page=login');
    exit;
}
$title = 'Manage Pages - Admin';
include 'views/layout/header.php';
?>

<section class="admin-section">
    <div class="admin-sidebar">
        <h2>Admin Menu</h2>
        <ul>
            <li><a href="?page=admin&action=dashboard">Dashboard</a></li>
            <li><a href="?page=admin&action=manageProducts">Products</a></li>
            <li><a href="?page=admin&action=manageNews">News</a></li>
            <li><a href="?page=admin&action=managePages" class="active">Pages</a></li>
            <li><a href="?page=admin&action=viewContacts">Messages</a></li>
        </ul>
    </div>

    <div class="admin-content">
        <h1>Manage Pages</h1>
        
        <?php if (($_GET['action'] ?? 'list') === 'add' || ($_GET['action'] ?? 'list') === 'edit'): ?>
            <div class="form-wrapper">
                <h2><?php echo ($_GET['action'] ?? 'list') === 'add' ? 'Create New Page' : 'Edit Page'; ?></h2>
                
                <form method="POST">
                    <div class="form-group">
                        <label for="title">Title *</label>
                        <input type="text" id="title" name="title" required>
                    </div>

                    <div class="form-group">
                        <label for="content">Content *</label>
                        <textarea id="content" name="content" rows="10" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Save Page</button>
                    <a href="?page=admin&action=managePages" class="btn">Cancel</a>
                </form>
            </div>
        <?php else: ?>
            <a href="?page=admin&action=managePages&action=add" class="btn btn-primary">+ Add Page</a>
            
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Slug</th>
                        <th>Creator</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($pages)): ?>
                        <?php foreach ($pages as $pageItem): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($pageItem['title']); ?></td>
                                <td><?php echo htmlspecialchars($pageItem['slug']); ?></td>
                                <td><?php echo htmlspecialchars($pageItem['creator_name']); ?></td>
                                <td><?php echo date('M d, Y', strtotime($pageItem['created_at'])); ?></td>
                                <td>
                                    <a href="?page=admin&action=managePages&action=edit&id=<?php echo $pageItem['id']; ?>" class="btn-small">Edit</a>
                                    <a href="?page=admin&action=managePages&action=delete&id=<?php echo $pageItem['id']; ?>" class="btn-small btn-danger" onclick="return confirm('Are you sure?');">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">No pages found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</section>

<?php include 'views/layout/footer.php'; ?>
