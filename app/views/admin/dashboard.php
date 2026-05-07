<?php
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ?page=login');
    exit;
}
$title = 'Admin Dashboard';
include 'app/views/layout/header.php';
?>

<section class="admin-section">
    <div class="admin-sidebar">
        <h2>Admin Menu</h2>
        <ul>
            <li><a href="?page=admin&action=dashboard" class="active">Dashboard</a></li>
            <li><a href="?page=admin&action=manageUsers">Users</a></li>
            <li><a href="?page=admin&action=manageProducts">Products</a></li>
            <li><a href="?page=admin&action=manageNews">News</a></li>
            <li><a href="?page=admin&action=managePages">Pages</a></li>
            <li><a href="?page=admin&action=viewContacts">Messages</a></li>
        </ul>
    </div>

    <div class="admin-content">
        <h1>Admin Dashboard</h1>
        <p>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!</p>

        <div class="dashboard-stats">
            <div class="stat-card">
                <h3>Total Users</h3>
                <p class="stat-number"><?php echo count($this->userModel->getAll()); ?></p>
            </div>
            <div class="stat-card">
                <h3>Total Products</h3>
                <p class="stat-number"><?php echo count($this->productModel->getAll()); ?></p>
            </div>
            <div class="stat-card">
                <h3>Total News</h3>
                <p class="stat-number"><?php echo count($this->newsModel->getAll()); ?></p>
            </div>
            <div class="stat-card">
                <h3>New Messages</h3>
                <p class="stat-number"><?php echo count(array_filter($this->contactModel->getAll(), function($c) { return $c['status'] === 'new'; })); ?></p>
            </div>
        </div>
    </div>
</section>

<?php include 'app/views/layout/footer.php'; ?>
