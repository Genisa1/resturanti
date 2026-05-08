<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Our Website'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="navbar-brand">
                <a href="?page=home" class="logo">KosovaSot</a>
            </div>
            <ul class="navbar-menu">
                <li><a href="?page=home">Home</a></li>
                <li><a href="?page=about">About Us</a></li>
                <li><a href="?page=products">Products</a></li>
                <li><a href="?page=news">News</a></li>
                <li><a href="?page=contact">Contact Us</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if ($_SESSION['role'] === 'admin'): ?>
                        <li><a href="?page=admin">Admin Panel</a></li>
                    <?php endif; ?>
                    <li><a href="?page=logout">Logout</a></li>
                <?php else: ?>
                    <li><a href="?page=login" class="nav-button">Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error">
            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <main class="container">
