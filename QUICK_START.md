# 🚀 Quick Start Guide - PHP MVC Web Application

## ⏱️ 5 Minutes Setup

### Step 1: Copy Files to XAMPP
```
Copy the Restaurant folder to: C:\xampp\htdocs\
```

### Step 2: Create Database
1. Open http://localhost/phpmyadmin/
2. Go to SQL tab
3. Copy-paste contents of: `Restaurant/sql/database.sql`
4. Click "Go"

### Step 3: Start the Application
```
http://localhost/Restaurant/
```

### Step 4: Login to Admin
```
URL: http://localhost/Restaurant/?page=login
Email: admin@example.com
Password: admin123
```

---

## 📱 Accessing All Pages

| Page | URL | Type |
|------|-----|------|
| Home | `?page=home` | Public |
| About | `?page=about` | Public |
| Products | `?page=products` | Public |
| News | `?page=news` | Public |
| Contact | `?page=contact` | Public |
| Login | `?page=login` | Public |
| Admin Panel | `?page=admin` | Admin Only |

---

## 🎯 Quick Admin Tasks

### Add a Product
1. Login to Admin Panel
2. Click "Products" in left menu
3. Click "+ Add Product" button
4. Fill in details and upload image/PDF
5. Click "Save Product"

### Add News Article
1. Click "News" in left menu
2. Click "+ Add News" button
3. Fill title, content, and upload image
4. Click "Save News"

### Edit Page Content
1. Click "Pages" in left menu
2. Click "Edit" on a page
3. Update content
4. Click "Save Page"

### View Contact Messages
1. Click "Messages" in left menu
2. View all submissions
3. Mark as read or delete

---

## 🔑 Key Features

✅ Dynamic Content Management
✅ Product Catalog with PDFs
✅ News/Blog System
✅ Contact Form
✅ Admin Dashboard
✅ User Authentication
✅ File Upload Management
✅ Responsive Design
✅ OOP & MVC Architecture
✅ Secure Database Operations

---

## 📚 File Structure Summary

```
├── config/        → Database connection
├── controllers/   → Page logic
├── models/        → Database interaction
├── views/         → HTML templates
├── public/        → CSS, JS, uploads
├── sql/           → Database schema
└── index.php      → Router
```

---

## 🐛 Common Issues

### "Database connection failed"
- Start MySQL in XAMPP
- Run database.sql script
- Check credentials in config/Database.php

### Files not loading
- Clear browser cache (Ctrl+F5)
- Check file paths in views
- Verify public/ folder exists

### Login not working
- Clear browser cookies
- Check database user exists
- Verify password hash is correct

---

## 📧 Demo Credentials

```
Email: admin@example.com
Password: admin123
```

Change after first login for security!

---

## 🎨 Customization

### Change Website Title
Edit `views/layout/header.php` line with "Our Website"

### Change Logo/Branding
Edit navbar brand in `views/layout/header.php`

### Modify Styling
Edit `public/css/style.css`

### Change Colors
Search for color codes in style.css:
- `#2c3e50` - Primary dark
- `#3498db` - Primary blue
- `#27ae60` - Success green
- `#e74c3c` - Error red

---

## ✨ Next Steps

1. ✅ Set up application (done!)
2. 📝 Add your products/content
3. 🎨 Customize styling
4. 🔐 Change admin password
5. 🚀 Ready for production!

---

**For detailed documentation, see README.md**
