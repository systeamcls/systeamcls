# 🚀 Quick Start Guide - Visual Studio Code

## ✅ **System is FULLY WORKING!**

The Centralized Canteen E-Commerce Management System is now running successfully.

## 📂 **Opening in Visual Studio Code**

### Method 1: From Terminal
```bash
cd /workspace/canteen-system
code .
```

### Method 2: From VS Code
1. Open VS Code
2. File → Open Folder
3. Navigate to `/workspace/canteen-system`
4. Click "Open"

## 🌐 **Access the Application**

The server is now running at: **http://localhost:8000**

### **Available URLs:**
- **🏠 Homepage**: http://localhost:8000 (redirects to menu)
- **🍽️ Menu Browser**: http://localhost:8000/menu
- **🛒 Checkout**: http://localhost:8000/checkout
- **⚙️ Admin Panel**: http://localhost:8000/admin (need to create admin user first)

## 👤 **Create Admin User**

Run this command to create your first admin user:
```bash
php artisan make:filament-user
```

Follow the prompts to enter:
- Name: Your name
- Email: your@email.com
- Password: Choose a secure password

Then assign admin role:
```bash
php artisan tinker
>>> $user = \App\Models\User::where('email', 'your@email.com')->first();
>>> $user->assignRole('admin');
>>> exit
```

## 🧪 **Create Sample Data**

### Create a Tenant User:
```bash
php artisan tinker
>>> $tenant = \App\Models\User::create(['name' => 'Pizza Corner', 'email' => 'pizza@example.com', 'password' => bcrypt('password')]);
>>> $tenant->assignRole('tenant');
>>> exit
```

### Add Sample Menu Items:
1. Login to admin panel as the tenant
2. Go to "Menu Items" → "Create"
3. Add items like:
   - **Margherita Pizza** - $12.99 (Main Course)
   - **Caesar Salad** - $8.99 (Appetizer)
   - **Chocolate Cake** - $5.99 (Dessert)

## 🛠️ **VS Code Extensions (Recommended)**

Install these extensions for better development experience:
- **PHP Intelephense** - PHP language support
- **Laravel Extension Pack** - Laravel development tools
- **Tailwind CSS IntelliSense** - CSS class autocomplete
- **Blade Formatter** - Laravel Blade template formatting

## 📁 **Key Files to Explore**

### **Models** (app/Models/)
- `User.php` - User management with roles
- `MenuItem.php` - Product catalog
- `Order.php` - Order management
- `Expense.php` - Business expenses

### **Filament Resources** (app/Filament/Resources/)
- `MenuItemResource.php` - Menu management interface
- `OrderResource.php` - Order management interface
- `ExpenseResource.php` - Expense tracking interface

### **Livewire Components** (app/Livewire/)
- `MenuBrowser.php` - Public menu display
- `ShoppingCart.php` - Cart functionality
- `Checkout.php` - Order processing

### **Views** (resources/views/)
- `menu/index.blade.php` - Main menu page
- `livewire/` - Livewire component templates

## 🎨 **Making Changes**

### **1. Modify Menu Layout**
Edit: `resources/views/menu/index.blade.php`
- Change colors, layout, hero section
- Add new categories or sections

### **2. Customize Cart Behavior**
Edit: `app/Livewire/ShoppingCart.php`
- Modify cart logic, add features
- Change cart UI in `resources/views/livewire/shopping-cart.blade.php`

### **3. Add New Fields to Menu Items**
1. Create migration: `php artisan make:migration add_field_to_menu_items_table`
2. Update model: `app/Models/MenuItem.php`
3. Update Filament resource: `app/Filament/Resources/MenuItemResource.php`

### **4. Customize Admin Panel**
Edit Filament resources in `app/Filament/Resources/`
- Add new fields, change layouts
- Modify table columns, filters

### **5. Add New Features**
- Create new Livewire components: `php artisan make:livewire ComponentName`
- Add new models: `php artisan make:model ModelName -m`
- Create new Filament resources: `php artisan make:filament-resource ResourceName`

## 🔧 **Development Commands**

```bash
# Start development server
php artisan serve

# Watch for file changes (frontend)
npm run dev

# Run migrations
php artisan migrate

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Generate new components
php artisan make:livewire ComponentName
php artisan make:filament-resource ResourceName
```

## 🎯 **Testing the System**

1. **Browse Menu**: Go to http://localhost:8000/menu
2. **Add to Cart**: Click "Add to Cart" on menu items
3. **View Cart**: Click the cart button (bottom right)
4. **Checkout**: Click "Checkout" in cart
5. **Admin Panel**: Login at http://localhost:8000/admin

## 🚨 **Troubleshooting**

### **If you get permission errors:**
```bash
chmod -R 775 storage bootstrap/cache
```

### **If styles don't load:**
```bash
npm run build
php artisan view:clear
```

### **If database issues:**
```bash
php artisan migrate:fresh --seed
```

## 🎉 **You're Ready to Go!**

The system is fully functional with:
- ✅ Modern menu browser
- ✅ Shopping cart with real-time updates
- ✅ Complete checkout process
- ✅ Admin panel for management
- ✅ Role-based access control
- ✅ Expense and staff tracking

**Happy coding! 🚀**