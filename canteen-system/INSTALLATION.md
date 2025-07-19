# 🍽️ Canteen System - Installation Guide

## 📋 **Prerequisites**

Before installing, make sure you have:

- **PHP 8.2+** (with extensions: mbstring, xml, bcmath, curl, zip, gd, sqlite3)
- **Composer** (PHP package manager)
- **Node.js 16+** and **npm**
- **Git** (optional, for version control)

### **Install Prerequisites on Different Systems:**

#### **Windows:**
1. Download PHP from https://windows.php.net/download
2. Download Composer from https://getcomposer.org/download
3. Download Node.js from https://nodejs.org

#### **macOS:**
```bash
# Using Homebrew
brew install php composer node
```

#### **Ubuntu/Debian:**
```bash
sudo apt update
sudo apt install php8.2 php8.2-cli php8.2-mbstring php8.2-xml php8.2-bcmath php8.2-curl php8.2-zip php8.2-gd php8.2-sqlite3 composer nodejs npm
```

## 📥 **Installation Methods**

### **Method 1: Download ZIP**
1. Download the project ZIP file
2. Extract to your desired location
3. Follow the setup steps below

### **Method 2: Git Clone** (if available)
```bash
git clone <repository-url> canteen-system
cd canteen-system
```

## ⚙️ **Setup Steps**

### **1. Install Dependencies**
```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### **2. Environment Configuration**
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### **3. Database Setup**
```bash
# Run migrations (creates all tables)
php artisan migrate

# Seed roles and permissions
php artisan db:seed --class=RoleSeeder
```

### **4. Build Frontend Assets**
```bash
# Build for production
npm run build

# OR for development (with file watching)
npm run dev
```

### **5. Create Admin User**
```bash
# Create your first admin user
php artisan make:filament-user
```
Follow the prompts to enter your name, email, and password.

### **6. Assign Admin Role**
```bash
php artisan tinker
>>> $user = \App\Models\User::where('email', 'your@email.com')->first();
>>> $user->assignRole('admin');
>>> exit
```

### **7. Start the Application**
```bash
# Start Laravel development server
php artisan serve

# The application will be available at:
# http://localhost:8000
```

## 🎯 **First Steps After Installation**

### **1. Access the Application**
- **Public Menu**: http://localhost:8000/menu
- **Admin Panel**: http://localhost:8000/admin
- **Dashboard**: http://localhost:8000/dashboard

### **2. Create Sample Data**

#### **Create a Tenant (Vendor):**
```bash
php artisan tinker
>>> $tenant = \App\Models\User::create([
...     'name' => 'Pizza Corner',
...     'email' => 'pizza@example.com', 
...     'password' => bcrypt('password')
... ]);
>>> $tenant->assignRole('tenant');
>>> exit
```

#### **Add Menu Items:**
1. Login to admin panel as tenant
2. Go to "Menu Items" → "Create"
3. Add sample items:
   - **Margherita Pizza** - $12.99 (Main Course)
   - **Caesar Salad** - $8.99 (Appetizer)
   - **Chocolate Cake** - $5.99 (Dessert)

### **3. Test the System**
1. Visit the public menu: http://localhost:8000/menu
2. Add items to cart
3. Go through checkout process
4. Check admin panel for orders

## 🔧 **Development Setup**

### **Recommended VS Code Extensions:**
- PHP Intelephense
- Laravel Extension Pack
- Tailwind CSS IntelliSense
- Blade Formatter

### **Development Commands:**
```bash
# Start development server
php artisan serve

# Watch for file changes (frontend)
npm run dev

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Run migrations
php artisan migrate

# Fresh install (reset database)
php artisan migrate:fresh --seed
```

## 🚨 **Troubleshooting**

### **Common Issues:**

#### **1. Permission Errors:**
```bash
# Fix storage permissions
chmod -R 775 storage bootstrap/cache
```

#### **2. Database Issues:**
```bash
# Reset database
php artisan migrate:fresh --seed
```

#### **3. Missing Extensions:**
Make sure PHP has all required extensions:
```bash
php -m | grep -E "(mbstring|xml|bcmath|curl|zip|gd|sqlite3)"
```

#### **4. Port Already in Use:**
```bash
# Use different port
php artisan serve --port=8080
```

#### **5. Styles Not Loading:**
```bash
# Rebuild assets
npm run build
php artisan view:clear
```

## 🌐 **Production Deployment**

### **Environment Variables (.env):**
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=your-db-host
DB_PORT=3306
DB_DATABASE=your-database
DB_USERNAME=your-username
DB_PASSWORD=your-password

MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password
```

### **Production Commands:**
```bash
# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set proper permissions
chmod -R 755 .
chmod -R 775 storage bootstrap/cache
```

## 📞 **Support**

If you encounter any issues:
1. Check the troubleshooting section above
2. Review Laravel documentation: https://laravel.com/docs
3. Check Filament documentation: https://filamentphp.com/docs

## 🎉 **You're Ready!**

Your Centralized Canteen E-Commerce Management System is now installed and ready to use!

**Key Features Available:**
- ✅ Multi-tenant canteen management
- ✅ Real-time shopping cart
- ✅ Order management system
- ✅ Expense and staff tracking
- ✅ Role-based access control
- ✅ Modern responsive UI

**Happy coding! 🚀**