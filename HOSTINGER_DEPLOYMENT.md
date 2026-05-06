# 🚀 Hostinger File Manager Deployment Guide

Yes! **This project can be hosted on Hostinger using File Manager.** Here's the complete step-by-step guide:

---

## ✅ Prerequisites on Hostinger

Before uploading, ensure your Hostinger plan includes:
- ✅ **PHP 7.4 or higher** (preferably 8.0+)
- ✅ **MySQL Database** (at least one database)
- ✅ **File Manager Access** (all Hostinger plans include this)
- ✅ **SSL Certificate** (free SSL available on Hostinger)

---

## 📋 Step-by-Step Deployment Instructions

### **Step 1: Prepare Your Files**

1. **Create a ZIP file** of your project:
   ```bash
   # In your local machine
   zip -r choshmazone.zip . -x "*.git*" -x "logs/*" -x "*.md"
   ```
   
   Or manually compress the folder excluding:
   - `.git` folder
   - `logs` folder (will be created automatically)
   - Documentation files (optional)

2. **Important folders to upload:**
   ```
   ✅ config/
   ✅ controllers/
   ✅ core/
   ✅ models/
   ✅ views/
   ✅ assets/
   ✅ database/
   ✅ index.php
   ✅ .htaccess (if exists)
   ```

---

### **Step 2: Create Database on Hostinger**

1. Login to **Hostinger hPanel**
2. Go to **Databases → MySQL Databases**
3. Click **Create New Database**
4. Fill in:
   - **Database Name**: `choshmazone_db` (or any name)
   - **Username**: Create new username
   - **Password**: Generate strong password
5. **Save credentials** (you'll need these!)

---

### **Step 3: Upload Files via File Manager**

1. Go to **Hosting → File Manager**
2. Navigate to **`public_html`** folder
3. **Upload** your ZIP file
4. **Extract** the ZIP file
5. Move all files to `public_html` root (if extracted in subfolder)

**Final structure should look like:**
```
public_html/
├── config/
├── controllers/
├── core/
├── models/
├── views/
├── assets/
├── database/
├── logs/ (create this folder)
└── index.php
```

---

### **Step 4: Configure Database Connection**

1. In File Manager, navigate to **`config/config.php`**
2. Click **Edit**
3. Update these values with your Hostinger database credentials:

```php
<?php
// Database Configuration - UPDATE THESE!
define('DB_HOST', 'localhost'); // Usually 'localhost' on Hostinger
define('DB_NAME', 'u123456789_choshmazone'); // Your actual database name
define('DB_USER', 'u123456789_admin'); // Your actual database username
define('DB_PASS', 'YourStrongPassword123!'); // Your actual database password

// Site Configuration - UPDATE THIS!
define('SITE_URL', 'https://yourdomain.com'); // Your actual domain
define('SITE_NAME', 'ChoshmaZone');
define('APP_PATH', __DIR__ . '/..');

// ... rest of the config stays the same
```

**📍 Where to find Hostinger database credentials:**
- Go to **hPanel → Databases → MySQL Databases**
- Click **Manage** next to your database
- Find **Database Details** section
- Copy: Database Name, Username, and use your created password

---

### **Step 5: Import Database Schema**

1. Go to **hPanel → Databases → phpMyAdmin**
2. Select your database
3. Click **Import** tab
4. Choose file: **`database/schema.sql`** (from your project)
5. Click **Go**

If you don't have schema.sql yet, run this SQL in phpMyAdmin:

```sql
-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    address TEXT,
    is_verified TINYINT(1) DEFAULT 0,
    verification_token VARCHAR(64),
    reset_token VARCHAR(64),
    reset_token_expires DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create products table
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    discount_price DECIMAL(10,2) DEFAULT 0,
    category_id INT,
    category_name VARCHAR(100),
    image_url VARCHAR(255),
    stock_quantity INT DEFAULT 0,
    is_featured TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create orders table
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    order_number VARCHAR(50) UNIQUE NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    status ENUM('pending','processing','shipped','delivered','cancelled') DEFAULT 'pending',
    payment_method VARCHAR(50),
    payment_status ENUM('pending','paid','failed') DEFAULT 'pending',
    shipping_address TEXT NOT NULL,
    billing_address TEXT,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Create order_items table
CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Create cart table
CREATE TABLE IF NOT EXISTS cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Insert sample admin user (password: admin123)
INSERT INTO users (name, email, password, is_verified) VALUES
('Admin', 'admin@choshmazone.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1);
```

---

### **Step 6: Set Folder Permissions**

In File Manager, right-click and change permissions:

1. **`logs/` folder**: `755` or `777` (for writing error logs)
2. **`assets/images/products/`**: `755` or `777` (for uploading product images)
3. **`config/config.php`**: `644` (read-only for security)

**How to change permissions:**
- Right-click folder/file → **Change Permissions**
- Enter numeric value or check boxes
- Click **Apply**

---

### **Step 7: Enable SSL (HTTPS)**

1. Go to **hPanel → Security → SSL**
2. Find your domain
3. Click **Install SSL Certificate** (Free SSL available)
4. Wait for activation (usually 5-10 minutes)
5. Update `SITE_URL` in config to use `https://`

---

### **Step 8: Create .htaccess File**

Create a file named **`.htaccess`** in `public_html` with:

```apache
RewriteEngine On

# Redirect to HTTPS
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

# Prevent directory browsing
Options -Indexes

# Protect sensitive files
<FilesMatch "\.(env|log|sql|ini)$">
    Order allow,deny
    Deny from all
</FilesMatch>

# Route all requests through index.php
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php?route=$1 [QSA,L]

# PHP Settings
php_value upload_max_filesize 10M
php_value post_max_size 10M
php_value max_execution_time 300
php_value max_input_time 300
```

---

### **Step 9: Test Your Website**

1. Visit your domain: `https://yourdomain.com`
2. Test these pages:
   - ✅ Homepage loads
   - ✅ Shop page works
   - ✅ Login/Register forms work
   - ✅ Product details page loads
   - ✅ Cart functionality works
   - ✅ Checkout process works

---

### **Step 10: Configure Email (Optional but Recommended)**

For email verification and password reset to work:

**Option A: Use Hostinger SMTP**
1. Go to **hPanel → Email → Configuration**
2. Get SMTP details
3. Update email configuration in your code

**Option B: Use Gmail SMTP**
Add to `config/config.php`:

```php
// Email Configuration
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'yourgmail@gmail.com');
define('SMTP_PASS', 'your-app-password');
define('SMTP_FROM_EMAIL', 'noreply@yourdomain.com');
define('SMTP_FROM_NAME', 'ChoshmaZone');
```

---

## 🔧 Troubleshooting Common Issues

### ❌ **Error: Database Connection Failed**
**Solution:**
- Double-check database credentials in `config/config.php`
- Ensure database user has proper permissions
- Verify database name is correct (Hostinger adds prefix like `u123456789_`)

### ❌ **Error: Permission Denied (logs)**
**Solution:**
```bash
# Change logs folder permissions to 777
chmod 777 logs/
```

### ❌ **Error: 500 Internal Server Error**
**Solution:**
- Check `logs/error.log` for details
- Verify PHP version (should be 7.4+)
- Check `.htaccess` syntax
- Enable error reporting temporarily in `index.php`

### ❌ **Error: CSRF Token Validation Failed**
**Solution:**
- Ensure sessions are working
- Check if cookies are enabled
- Verify `session_start()` is called before any output

### ❌ **Images Not Loading**
**Solution:**
- Check `assets/images/` folder permissions (755)
- Verify image paths in database
- Ensure `UPLOAD_PATH` is correct in config

### ❌ **Email Verification Not Working**
**Solution:**
- Configure SMTP settings
- Check spam folder
- Verify email functions are enabled on Hostinger

---

## 📊 Hostinger Plan Recommendations

| Feature | Single | Premium | Business |
|---------|--------|---------|----------|
| **Websites** | 1 | 100 | 100 |
| **SSL** | ✅ Free | ✅ Free | ✅ Free |
| **Database** | 1 | Unlimited | Unlimited |
| **Bandwidth** | 50GB | Unlimited | Unlimited |
| **Recommended** | For testing | ✅ Best Value | For high traffic |

**💡 Recommendation:** Start with **Premium plan** (~$2.99/month) for best value.

---

## 🎯 Post-Deployment Checklist

- [ ] Update `SITE_URL` in config
- [ ] Update database credentials
- [ ] Import database schema
- [ ] Set folder permissions (logs: 777)
- [ ] Enable SSL certificate
- [ ] Test all pages and features
- [ ] Configure email SMTP
- [ ] Create admin account
- [ ] Add sample products
- [ ] Test checkout process
- [ ] Setup backup schedule
- [ ] Enable Cloudflare (optional)

---

## 🔐 Security Tips for Hostinger

1. **Change default admin email/password**
2. **Enable Two-Factor Authentication** (if available)
3. **Regular backups** (Hostinger offers automatic backups)
4. **Keep PHP updated** (use latest stable version)
5. **Use strong database passwords**
6. **Enable firewall** in hPanel
7. **Monitor error logs** regularly
8. **Limit login attempts** (already implemented)

---

## 📞 Need Help?

- **Hostinger Support**: 24/7 Live Chat (available in hPanel)
- **Knowledge Base**: https://www.hostinger.com/tutorials
- **Community Forum**: https://www.hostinger.com/community

---

## 🎉 You're Done!

Your ChoshmaZone e-commerce site is now live on Hostinger! 🚀

**Next Steps:**
1. Add your products via admin panel
2. Customize theme/colors
3. Setup payment gateways (Stripe/PayPal)
4. Configure shipping rates
5. Launch marketing campaigns

---

**Last Updated:** May 2024  
**Compatible with:** Hostinger Single, Premium, Business, and Cloud plans
