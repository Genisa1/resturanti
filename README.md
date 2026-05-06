# PHP OOP MVC Web Application

A complete, professional PHP web application using Object-Oriented Programming (OOP) and Model-View-Controller (MVC) architecture designed to run on XAMPP localhost.

## 📋 Table of Contents

- [Features](#features)
- [Project Structure](#project-structure)
- [Installation & Setup](#installation--setup)
- [Configuration](#configuration)
- [Usage](#usage)
- [Database](#database)
- [Features Documentation](#features-documentation)
- [API Routes](#api-routes)
- [Security Considerations](#security-considerations)

## ✨ Features

### Public Pages
- **Home Page** - Dynamic content with latest news and featured products
- **About Us** - Dynamically loaded page content
- **Products** - Product listing with details and PDF downloads
- **News** - News articles with images and full content
- **Contact Us** - Contact form with message storage

### Admin Panel
- **Dashboard** - Overview statistics
- **Products Management** - Create, edit, and delete products with file uploads
- **News Management** - Create, edit, and delete news articles
- **Pages Management** - Create and edit dynamic pages
- **Contact Messages** - View and manage contact form submissions

### Technical Features
- **OOP Architecture** - Fully object-oriented code structure
- **MVC Pattern** - Separation of concerns with Models, Views, Controllers
- **PDO Database** - Secure database operations using PDO
- **Password Hashing** - BCrypt password hashing for security
- **Session Management** - User authentication and authorization
- **File Uploads** - Secure image and PDF file uploads
- **Responsive Design** - Mobile-friendly interface with CSS Grid/Flexbox
- **Error Handling** - Try-catch blocks and proper error management

## 📁 Project Structure

```
Restaurant/
├── config/
│   └── Database.php              # Database connection class
├── controllers/
│   ├── HomeController.php        # Home page logic
│   ├── AboutController.php       # About page logic
│   ├── ProductController.php     # Products page logic
│   ├── NewsController.php        # News page logic
│   ├── ContactController.php     # Contact form logic
│   ├── AdminController.php       # Admin panel logic
│   └── AuthController.php        # Login/logout logic
├── models/
│   ├── User.php                  # User model
│   ├── Product.php               # Product model
│   ├── News.php                  # News model
│   ├── Contact.php               # Contact model
│   └── Page.php                  # Page model
├── views/
│   ├── layout/
│   │   ├── header.php            # Page header/navigation
│   │   └── footer.php            # Page footer
│   ├── home.php                  # Home page view
│   ├── about.php                 # About page view
│   ├── products.php              # Products listing view
│   ├── product-detail.php        # Single product view
│   ├── news.php                  # News listing view
│   ├── news-detail.php           # Single news view
│   ├── contact.php               # Contact form view
│   ├── login.php                 # Login view
│   └── admin/
│       ├── dashboard.php         # Admin dashboard
│       ├── manage-products.php   # Product management
│       ├── manage-news.php       # News management
│       ├── manage-pages.php      # Page management
│       └── view-contacts.php     # Contact messages
├── public/
│   ├── css/
│   │   └── style.css            # Main stylesheet
│   ├── js/
│   │   └── script.js            # JavaScript utilities
│   └── uploads/                 # User uploaded files
├── sql/
│   └── database.sql             # Database schema
├── index.php                    # Main routing file
└── README.md                    # This file
```

## 🚀 Installation & Setup

### Prerequisites
- XAMPP installed on your computer
- PHP 7.4 or higher
- MySQL/MariaDB
- Web browser

### Step 1: Copy Project Files

1. Open XAMPP Control Panel
2. Click "Explorer" to open the htdocs folder
3. Copy the entire `Restaurant` folder to `C:\xampp\htdocs\`

### Step 2: Create Database

1. Start Apache and MySQL in XAMPP Control Panel
2. Open phpMyAdmin: `http://localhost/phpmyadmin/`
3. Click on the SQL tab
4. Open the file: `Restaurant/sql/database.sql`
5. Copy and paste the entire SQL code into phpMyAdmin's SQL textarea
6. Click "Go" to execute

### Step 3: Access the Application

- Open your browser and go to: `http://localhost/Restaurant/`
- Home page should load successfully

### Step 4: Login to Admin Panel

1. Go to: `http://localhost/Restaurant/?page=login`
2. Use these credentials:
   - **Email:** admin@example.com
   - **Password:** admin123
3. Click "Login" to access the admin dashboard

## ⚙️ Configuration

### Database Connection

Edit `config/Database.php` if needed:

```php
private $host = 'localhost';      // Database host
private $db_name = 'website_db';  // Database name
private $username = 'root';       // MySQL username
private $password = '';           // MySQL password
```

### Default Admin User

Email: `admin@example.com`
Password: `admin123` (hashed with BCrypt)

To change the password, update the hash in the database:

```sql
UPDATE users SET password = '$2y$10$...' WHERE email = 'admin@example.com';
```

Generate new hash using: `password_hash('newpassword', PASSWORD_BCRYPT)`

## 📖 Usage

### Public Website

#### Home Page (`?page=home`)
- Displays dynamic home page content
- Shows latest news articles (3 most recent)
- Displays featured products

#### About Us (`?page=about`)
- Shows dynamically managed page content
- Editable through admin panel

#### Products (`?page=products`)
- Lists all products from database
- Click product to view details
- Download PDF files attached to products

#### News (`?page=news`)
- Lists all news articles
- Click article to read full content
- Each article can have an image

#### Contact Us (`?page=contact`)
- Contact form to submit messages
- Messages saved to database
- Admin can view all submissions

### Admin Panel

#### Dashboard (`?page=admin`)
- Overview of all content
- Quick statistics

#### Products Management
- Add new products with image and PDF
- Edit product details
- Delete products
- File uploads handled securely

#### News Management
- Create news articles with images
- Edit existing articles
- Delete articles
- WYSIWYG support for content

#### Pages Management
- Create custom pages
- Edit page content
- Auto-generated URL slugs
- Can't delete default pages

#### Contact Messages
- View all contact submissions
- Mark as read/responded
- Delete old messages

## 🗄️ Database

### Tables Overview

#### users
- `id` - User ID (Primary Key, Auto Increment)
- `name` - User full name
- `email` - User email (Unique)
- `password` - Hashed password
- `role` - admin/user
- `created_at` - Creation timestamp
- `updated_at` - Last update timestamp

#### products
- `id` - Product ID
- `title` - Product title
- `description` - Product description
- `image` - Image file path
- `pdf` - PDF file path
- `created_by` - User ID who created it
- `created_at` - Creation timestamp

#### news
- `id` - News ID
- `title` - Article title
- `content` - Article content
- `image` - Article image path
- `created_by` - Author user ID
- `created_at` - Publication timestamp

#### contacts
- `id` - Contact ID
- `name` - Sender name
- `email` - Sender email
- `message` - Message content
- `status` - new/read/responded
- `created_at` - Submission timestamp

#### pages
- `id` - Page ID
- `title` - Page title
- `slug` - URL-friendly slug
- `content` - Page content
- `created_by` - Creator user ID
- `created_at` - Creation timestamp

## 🔗 API Routes

### Navigation Routes

```
Home:              ?page=home
About:             ?page=about
Products:          ?page=products
Product Detail:    ?page=products&id=1
News:              ?page=news
News Detail:       ?page=news&id=1
Contact:           ?page=contact
Login:             ?page=login
Logout:            ?page=logout
Admin Dashboard:   ?page=admin
Admin Products:    ?page=admin&action=manageProducts
Admin News:        ?page=admin&action=manageNews
Admin Pages:       ?page=admin&action=managePages
Admin Messages:    ?page=admin&action=viewContacts
```

### Form Submission

```
Contact Form:      POST ?page=contact&action=submit
Login:             POST ?page=login
Add Product:       POST ?page=admin&action=manageProducts
Edit Product:      POST ?page=admin&action=manageProducts&action=edit&id=1
Delete Product:    GET ?page=admin&action=manageProducts&action=delete&id=1
```

## 🔒 Security Considerations

### Implemented Security Features

1. **Password Hashing**
   - Uses BCrypt algorithm
   - Passwords never stored in plain text

2. **SQL Injection Prevention**
   - Uses PDO prepared statements
   - All user input parameterized

3. **XSS Prevention**
   - Uses `htmlspecialchars()` for output
   - Input validation and sanitization

4. **Session Management**
   - Session-based authentication
   - User role-based access control

5. **File Upload Security**
   - Files stored outside web root
   - Unique filenames to prevent overwrites
   - File type validation

### Recommendations for Production

1. **Change Default Credentials**
   ```sql
   UPDATE users SET password = '$2y$10$...' WHERE email = 'admin@example.com';
   ```

2. **Enable HTTPS**
   - Use SSL certificates in production

3. **Add CSRF Protection**
   - Implement CSRF tokens in forms

4. **Database Backups**
   - Set up regular automated backups

5. **Error Logging**
   - Log errors to file instead of displaying
   - Hide database errors from users

6. **Input Validation**
   - Validate all user inputs
   - Use whitelist approach for accepted values

7. **Rate Limiting**
   - Implement login attempt limiting
   - Add CAPTCHA to contact form

## 📝 Creating New Features

### Creating a New Page

1. **Create Controller** (`controllers/NewPageController.php`)
```php
<?php
class NewPageController {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    public function index() {
        require_once 'views/newpage.php';
    }
}
```

2. **Create View** (`views/newpage.php`)
```php
<?php
$title = 'New Page Title';
include 'views/layout/header.php';
?>
<!-- Page content -->
<?php include 'views/layout/footer.php'; ?>
```

3. **Add Route** (in `index.php`)
```php
case 'newpage':
    require_once 'controllers/NewPageController.php';
    $controller = new NewPageController($db);
    $controller->index();
    break;
```

4. **Update Navigation** (`views/layout/header.php`)
```php
<li><a href="?page=newpage">New Page</a></li>
```

### Creating a New Model

1. Create file in `models/NewModel.php`
2. Define class with CRUD methods
3. Use in controllers to interact with database

## 🐛 Troubleshooting

### Database Connection Error
- Check MySQL is running in XAMPP
- Verify credentials in `config/Database.php`
- Ensure `website_db` database exists

### File Upload Not Working
- Check `public/uploads/` folder permissions
- Ensure folder exists and is writable
- Check PHP upload limits in `php.ini`

### Login Redirects to Login Page
- Clear browser cookies/cache
- Check session directory permissions
- Verify user exists in database

### CSS/JS Not Loading
- Clear browser cache
- Check file paths are correct
- Verify files exist in `public/` folder

## 📚 Learning Resources

- [PHP OOP](https://www.php.net/manual/en/language.oop5.php)
- [MVC Pattern](https://en.wikipedia.org/wiki/Model%E2%80%93view%E2%80%93controller)
- [PDO Database](https://www.php.net/manual/en/book.pdo.php)
- [HTML Forms](https://developer.mozilla.org/en-US/docs/Learn/Forms)

## 📄 License

This project is provided as-is for educational and commercial purposes.

## 🤝 Support

For questions or issues:
1. Check this README
2. Review the code comments
3. Check the troubleshooting section
4. Verify database schema matches sql/database.sql

## 🎉 Getting Started Checklist

- [ ] Copy project to htdocs
- [ ] Create database from SQL file
- [ ] Access http://localhost/Restaurant/
- [ ] Login with admin@example.com / admin123
- [ ] Add some sample products and news
- [ ] Test all public pages
- [ ] Test contact form

---

**Happy Coding!** 🚀
