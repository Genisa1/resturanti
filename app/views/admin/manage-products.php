<?php
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ?page=login');
    exit;
}
$title = 'Manage Products - Admin';
include 'app/views/layout/header.php';
?>

<section class="admin-section">
    <div class="admin-sidebar">
        <h2>Admin Menu</h2>
        <ul>
            <li><a href="?page=admin&action=dashboard">Dashboard</a></li>
            <li><a href="?page=admin&action=manageUsers">Users</a></li>
            <li><a href="?page=admin&action=manageProducts" class="active">Products</a></li>
            <li><a href="?page=admin&action=manageNews">News</a></li>
            <li><a href="?page=admin&action=managePages">Pages</a></li>
            <li><a href="?page=admin&action=viewContacts">Messages</a></li>
        </ul>
    </div>

    <div class="admin-content">
        <h1>Manage Products</h1>
        
        <?php $task = $_GET['task'] ?? 'list'; ?>
        <?php if ($task === 'add' || $task === 'edit'): ?>
            <div class="form-wrapper">
                <h2><?php echo $task === 'add' ? 'Add New Product' : 'Edit Product'; ?></h2>
                
                <?php if ($task === 'add'): ?>
                    <form method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        <div class="form-group">
                            <label for="title">Title *</label>
                            <input type="text" id="title" name="title" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="description">Description *</label>
                            <textarea id="description" name="description" class="form-control" rows="8" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" id="image" name="image" class="form-control" accept="image/*">
                        </div>

                        <div class="form-group">
                            <label for="pdf">PDF</label>
                            <input type="file" id="pdf" name="pdf" accept=".pdf">
                        </div>

                        <button type="submit" class="btn btn-primary">Save Product</button>
                        <a href="?page=admin&action=manageProducts" class="btn">Cancel</a>
                    </form>
                <?php elseif ($task === 'edit' && isset($product) && $product): ?>
                    <form method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        <div class="form-group">
                            <label for="title">Title *</label>
                            <input type="text" id="title" name="title" class="form-control" value="<?php echo htmlspecialchars($product['title']); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="description">Description *</label>
                            <textarea id="description" name="description" class="form-control" rows="8" required><?php echo htmlspecialchars($product['description']); ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" id="image" name="image" class="form-control" accept="image/*">
                            <?php if (!empty($product['image'])): ?>
                                <p>Current file: <?php echo htmlspecialchars($product['image']); ?></p>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="pdf">PDF</label>
                            <input type="file" id="pdf" name="pdf" class="form-control" accept=".pdf">
                            <?php if (!empty($product['pdf'])): ?>
                                <p>Current file: <?php echo htmlspecialchars($product['pdf']); ?></p>
                            <?php endif; ?>
                        </div>

                        <button type="submit" class="btn btn-primary">Save Product</button>
                        <a href="?page=admin&action=manageProducts" class="btn">Cancel</a>
                    </form>
                <?php else: ?>
                    <div class="alert alert-error">Unable to load product for editing.</div>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <a href="?page=admin&action=manageProducts&task=add" class="btn btn-primary">+ Add Product</a>
            
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
                                    <a href="?page=admin&action=manageProducts&task=edit&id=<?php echo $product['id']; ?>" class="btn-small">Edit</a>
                                    <a href="?page=admin&action=manageProducts&task=delete&id=<?php echo $product['id']; ?>" class="btn-small btn-danger" onclick="return confirm('Are you sure?');">Delete</a>
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

<?php include 'app/views/layout/footer.php'; ?>
