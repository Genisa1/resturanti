<?php
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ?page=login');
    exit;
}
$title = 'Manage Products - Admin';
include 'views/layout/header.php';
?>

<section class="admin-section">
    <div class="admin-sidebar">
        <h2>Admin Menu</h2>
        <ul>
            <li><a href="?page=admin&action=dashboard">Dashboard</a></li>
            <li><a href="?page=admin&action=manageProducts" class="active">Products</a></li>
            <li><a href="?page=admin&action=manageNews">News</a></li>
            <li><a href="?page=admin&action=managePages">Pages</a></li>
            <li><a href="?page=admin&action=viewContacts">Messages</a></li>
        </ul>
    </div>

    <div class="admin-content">
        <h1>Manage Products</h1>
        
        <?php if (($_GET['action'] ?? 'list') === 'add' || ($_GET['action'] ?? 'list') === 'edit'): ?>
            <div class="form-wrapper">
                <h2><?php echo ($_GET['action'] ?? 'list') === 'add' ? 'Add New Product' : 'Edit Product'; ?></h2>
                
                <?php if (($_GET['action'] ?? 'list') === 'edit' && isset($_GET['id'])): 
                    // In a real app, you'd fetch the product here
                ?>
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="title">Title *</label>
                        <input type="text" id="title" name="title" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description *</label>
                        <textarea id="description" name="description" rows="8" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" id="image" name="image" accept="image/*">
                    </div>

                    <div class="form-group">
                        <label for="pdf">PDF</label>
                        <input type="file" id="pdf" name="pdf" accept=".pdf">
                    </div>

                    <button type="submit" class="btn btn-primary">Save Product</button>
                    <a href="?page=admin&action=manageProducts" class="btn">Cancel</a>
                </form>
                <?php else: ?>
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="title">Title *</label>
                        <input type="text" id="title" name="title" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description *</label>
                        <textarea id="description" name="description" rows="8" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" id="image" name="image" accept="image/*">
                    </div>

                    <div class="form-group">
                        <label for="pdf">PDF</label>
                        <input type="file" id="pdf" name="pdf" accept=".pdf">
                    </div>

                    <button type="submit" class="btn btn-primary">Save Product</button>
                    <a href="?page=admin&action=manageProducts" class="btn">Cancel</a>
                </form>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <a href="?page=admin&action=manageProducts&action=add" class="btn btn-primary">+ Add Product</a>
            
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
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($product['title']); ?></td>
                                <td><?php echo htmlspecialchars($product['creator_name']); ?></td>
                                <td><?php echo date('M d, Y', strtotime($product['created_at'])); ?></td>
                                <td>
                                    <a href="?page=admin&action=manageProducts&action=edit&id=<?php echo $product['id']; ?>" class="btn-small">Edit</a>
                                    <a href="?page=admin&action=manageProducts&action=delete&id=<?php echo $product['id']; ?>" class="btn-small btn-danger" onclick="return confirm('Are you sure?');">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">No products found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</section>

<?php include 'views/layout/footer.php'; ?>
