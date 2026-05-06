# 💡 Developer Tips & Advanced Configuration

## OOP & MVC Best Practices Used

### Model-View-Controller Pattern
```
User Request → Router (index.php) → Controller → Model → Database
                ↓                                    ↑
            View (HTML) ←─────────────────────────────
```

### Object-Oriented Programming Principles

#### 1. Encapsulation
Each class has private properties and public methods:
```php
class Product {
    private $db;           // Private - not accessible outside
    public $title;         // Public - accessible property
    
    public function getAll() { }  // Public method
    private function validate() { } // Private helper method
}
```

#### 2. Abstraction
Classes hide complexity:
```php
// User doesn't need to know SQL details
$product = new Product($db);
$products = $product->getAll();  // Simple interface
```

#### 3. Inheritance Concept (Expandable)
You can create base controller:
```php
abstract class BaseController {
    protected $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
}

class ProductController extends BaseController { }
```

#### 4. Polymorphism
Different models implement same pattern:
```php
$product->create();  // Product CRUD
$news->create();     // News CRUD
$page->create();     // Page CRUD
```

---

## Code Organization Philosophy

### Models Responsibility
- Database operations only
- Data validation
- Business logic for data
```php
class User extends Model {
    public function verifyPassword($email, $password) {
        // Only handles user-related logic
    }
}
```

### Controllers Responsibility
- Handle HTTP requests
- Call appropriate models
- Control flow logic
```php
class ProductController {
    public function index() {
        $products = $this->productModel->getAll();
        require_once 'views/products.php';
    }
}
```

### Views Responsibility
- Display data only
- HTML structure
- User interface
```php
<!-- No PHP logic, just display -->
<?php foreach ($products as $product): ?>
    <h3><?php echo $product['title']; ?></h3>
<?php endforeach; ?>
```

---

## Advanced Features & How to Use

### 1. Adding New Features

#### Example: Add Author Profile Page

**Step 1: Create Model** (`models/Author.php`)
```php
<?php
class Author {
    private $db;
    private $table = 'users';

    public function getById($id) {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE id = ?';
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getArticles($userId) {
        $query = 'SELECT * FROM news WHERE created_by = ? ORDER BY created_at DESC';
        $stmt = $this->db->prepare($query);
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
}
```

**Step 2: Create Controller** (`controllers/AuthorController.php`)
```php
<?php
class AuthorController {
    private $db;
    private $authorModel;
    private $newsModel;

    public function __construct($db) {
        $this->db = $db;
        require_once 'models/Author.php';
        require_once 'models/News.php';
        
        $this->authorModel = new Author($db);
        $this->newsModel = new News($db);
    }

    public function profile($id) {
        $author = $this->authorModel->getById($id);
        $articles = $this->authorModel->getArticles($id);
        require_once 'views/author-profile.php';
    }
}
```

**Step 3: Create View** (`views/author-profile.php`)
```php
<?php
$title = htmlspecialchars($author['name']) . ' - Profile';
include 'views/layout/header.php';
?>

<section class="page-section">
    <h1><?php echo htmlspecialchars($author['name']); ?></h1>
    <p>Email: <?php echo htmlspecialchars($author['email']); ?></p>
    
    <h2>Articles by this Author</h2>
    <ul>
        <?php foreach ($articles as $article): ?>
            <li>
                <a href="?page=news&id=<?php echo $article['id']; ?>">
                    <?php echo htmlspecialchars($article['title']); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</section>

<?php include 'views/layout/footer.php'; ?>
```

**Step 4: Add Route** (in `index.php`)
```php
case 'author':
    require_once 'controllers/AuthorController.php';
    $controller = new AuthorController($db);
    if ($id) {
        $controller->profile($id);
    } else {
        header('Location: ?page=home');
    }
    break;
```

**Step 5: Update Navigation** (`views/layout/header.php`)
```php
<li><a href="?page=author&id=<?php echo $author['id']; ?>">
    <?php echo htmlspecialchars($author['name']); ?>
</a></li>
```

---

### 2. API Endpoints (Future Enhancement)

Create API routes in `index.php`:
```php
if ($_GET['api'] ?? false) {
    header('Content-Type: application/json');
    
    switch ($_GET['api']) {
        case 'products':
            require_once 'models/Product.php';
            $product = new Product($db);
            echo json_encode($product->getAll());
            break;
        
        case 'news':
            require_once 'models/News.php';
            $news = new News($db);
            echo json_encode($news->getLatest(10));
            break;
    }
    exit;
}
```

Usage: `http://localhost/Resturant/index.php?api=products`

---

### 3. Implement Categories

**Add to Products Table:**
```sql
ALTER TABLE products ADD COLUMN category VARCHAR(100);
ALTER TABLE products ADD INDEX category_idx (category);
```

**Update Product Model:**
```php
public function getByCategory($category) {
    $query = 'SELECT * FROM products WHERE category = ? ORDER BY created_at DESC';
    $stmt = $this->db->prepare($query);
    $stmt->execute([$category]);
    return $stmt->fetchAll();
}
```

---

### 4. Search Functionality

**Add to Product Model:**
```php
public function search($query) {
    $searchTerm = '%' . $query . '%';
    $querySQL = 'SELECT * FROM products 
                 WHERE title LIKE ? OR description LIKE ? 
                 ORDER BY created_at DESC';
    $stmt = $this->db->prepare($querySQL);
    $stmt->execute([$searchTerm, $searchTerm]);
    return $stmt->fetchAll();
}
```

**Add Route:**
```php
case 'search':
    require_once 'controllers/ProductController.php';
    $controller = new ProductController($db);
    $searchTerm = $_GET['q'] ?? '';
    $results = $controller->search($searchTerm);
    require_once 'views/search-results.php';
    break;
```

---

### 5. Pagination

**Add to Product Model:**
```php
public function getPaginated($page = 1, $perPage = 10) {
    $offset = ($page - 1) * $perPage;
    
    $query = 'SELECT p.*, u.name as creator_name 
              FROM products p
              LEFT JOIN users u ON p.created_by = u.id
              ORDER BY p.created_at DESC
              LIMIT ? OFFSET ?';
    
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(1, (int)$perPage, PDO::PARAM_INT);
    $stmt->bindValue(2, (int)$offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

public function getTotalCount() {
    $query = 'SELECT COUNT(*) as total FROM products';
    $stmt = $this->db->prepare($query);
    $stmt->execute();
    return $stmt->fetch()['total'];
}
```

---

## Testing & Debugging

### Enable Error Display (Development Only)
Add to `config/Database.php`:
```php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
```

### Debug Variable
```php
// Print array/object for inspection
echo '<pre>';
var_dump($products);
echo '</pre>';

// Print and stop execution
die(var_dump($product));
```

### Check Query Execution
```php
$stmt = $this->db->prepare($query);
$result = $stmt->execute($params);
echo 'Rows affected: ' . $stmt->rowCount();
```

---

## Performance Optimization

### 1. Database Indexes
```sql
-- Speed up queries
ALTER TABLE products ADD INDEX title_idx (title);
ALTER TABLE news ADD INDEX created_idx (created_at);
ALTER TABLE contacts ADD INDEX status_idx (status);
```

### 2. Query Optimization
```php
// BAD: Multiple queries in loop
foreach ($products as $product) {
    $user = getUserById($product['created_by']); // 100+ queries
}

// GOOD: Join in SQL
public function getWithCreators() {
    $query = 'SELECT p.*, u.name 
              FROM products p
              LEFT JOIN users u ON p.created_by = u.id';
}
```

### 3. Caching (Future)
```php
// Simple cache
if (file_exists('cache/products.json')) {
    $products = json_decode(file_get_contents('cache/products.json'));
} else {
    $products = $this->productModel->getAll();
    file_put_contents('cache/products.json', json_encode($products));
}
```

---

## Security Hardening

### 1. CSRF Protection
```php
// Add to forms
<input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

// Validate in controller
if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die('Invalid request');
}
```

### 2. Rate Limiting
```php
public function checkRateLimit($email, $maxAttempts = 5) {
    if (!isset($_SESSION['login_attempts'][$email])) {
        $_SESSION['login_attempts'][$email] = 0;
    }
    
    $_SESSION['login_attempts'][$email]++;
    
    if ($_SESSION['login_attempts'][$email] > $maxAttempts) {
        sleep(10); // Slow down attackers
    }
}
```

### 3. Validation Library
```php
class Validator {
    public static function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
    
    public static function validateURL($url) {
        return filter_var($url, FILTER_VALIDATE_URL);
    }
}
```

---

## Deployment Checklist

- [ ] Change default admin credentials
- [ ] Disable error display: `display_errors = Off`
- [ ] Enable HTTPS with SSL certificate
- [ ] Set up database backups
- [ ] Remove QUICK_START.md and PROJECT_SUMMARY.md
- [ ] Set proper file permissions (644 files, 755 folders)
- [ ] Add .env for sensitive configuration
- [ ] Enable database query logging
- [ ] Set up error logging to file
- [ ] Configure email for notifications
- [ ] Test all functionality on staging

---

## Common Code Patterns

### Model Pattern
```php
class Model {
    protected $db;
    protected $table;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    public function getAll() {
        $query = "SELECT * FROM {$this->table}";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
```

### Controller Pattern
```php
class Controller {
    protected $db;
    protected $model;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    protected function render($view, $data = []) {
        extract($data);
        require_once "views/{$view}.php";
    }
}
```

---

## Resources & Documentation

- **PHP Manual**: https://www.php.net/manual/
- **PDO**: https://www.php.net/manual/en/book.pdo.php
- **OOP**: https://www.php.net/manual/en/language.oop5.php
- **MySQL**: https://dev.mysql.com/doc/
- **Web Security**: https://owasp.org/

---

**Happy Development! 🚀**
