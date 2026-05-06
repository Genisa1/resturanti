<?php
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ?page=login');
    exit;
}
$title = 'View Messages - Admin';
include 'views/layout/header.php';
?>

<section class="admin-section">
    <div class="admin-sidebar">
        <h2>Admin Menu</h2>
        <ul>
            <li><a href="?page=admin&action=dashboard">Dashboard</a></li>
            <li><a href="?page=admin&action=manageProducts">Products</a></li>
            <li><a href="?page=admin&action=manageNews">News</a></li>
            <li><a href="?page=admin&action=managePages">Pages</a></li>
            <li><a href="?page=admin&action=viewContacts" class="active">Messages</a></li>
        </ul>
    </div>

    <div class="admin-content">
        <h1>Contact Messages</h1>
        
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($contacts)): ?>
                    <?php foreach ($contacts as $contact): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($contact['name']); ?></td>
                            <td><?php echo htmlspecialchars($contact['email']); ?></td>
                            <td><?php echo htmlspecialchars(substr($contact['message'], 0, 50)); ?>...</td>
                            <td><span class="status-badge status-<?php echo $contact['status']; ?>"><?php echo ucfirst($contact['status']); ?></span></td>
                            <td><?php echo date('M d, Y', strtotime($contact['created_at'])); ?></td>
                            <td>
                                <a href="?page=admin&action=viewContactDetail&id=<?php echo $contact['id']; ?>" class="btn-small">View</a>
                                <a href="?page=admin&action=deleteContact&id=<?php echo $contact['id']; ?>" class="btn-small btn-danger" onclick="return confirm('Are you sure?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">No messages found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<?php include 'views/layout/footer.php'; ?>
