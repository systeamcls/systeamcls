# 🍽️ Centralized Canteen E-Commerce Management System

A comprehensive Laravel-based multi-tenant canteen management system with real-time features, role-based access control, and modern UI/UX design.

## 🚀 Features

### 👨‍💼 **Admin (Concessionaire)**
- **Complete Dashboard**: Revenue analytics, expense tracking, staff management
- **Multi-Tenant Management**: Oversee all tenant operations and orders
- **Financial Control**: Track expenses, collect rental payments, manage staff salaries
- **Real-time Monitoring**: Live order notifications from all tenants

### 🧑‍💼 **Tenants (Vendors)**
- **Individual Panel**: Dedicated Filament admin interface
- **Menu Management**: Create, edit, and manage menu items with images
- **Order Processing**: Real-time order notifications and status updates
- **Business Analytics**: Sales performance, revenue tracking, expense management

### 👤 **Customers**
- **Modern Menu Browser**: McDonald's-style product catalog with search and filtering
- **Smart Shopping Cart**: Slide-out cart with real-time updates
- **Flexible Checkout**: Multiple delivery options and payment methods
- **Guest-Friendly**: Non-registered users can order with online payment

## 🛠️ Technology Stack

- **Backend**: Laravel 12.20
- **Admin Panel**: Filament v3 with multi-panel architecture
- **Authentication**: Laravel Jetstream (teams disabled)
- **Permissions**: Spatie Laravel-Permission
- **Real-time**: Laravel Reverb + Livewire
- **Database**: SQLite (development) / MySQL (production)
- **Frontend**: Livewire + Tailwind CSS + Alpine.js
- **UI Components**: Heroicons, responsive design

## 📦 Installation

### Prerequisites
- PHP 8.2+
- Composer
- Node.js & NPM
- SQLite or MySQL

### Quick Setup
```bash
# Clone the repository
git clone <repository-url>
cd canteen-system

# Run the setup script
chmod +x setup.sh
./setup.sh
```

### Manual Setup
```bash
# Install PHP dependencies
composer install

# Install and build frontend assets
npm install && npm run build

# Environment setup
cp .env.example .env
php artisan key:generate

# Database setup
php artisan migrate
php artisan db:seed --class=RoleSeeder

# Create admin user
php artisan make:filament-user

# Create storage symlink
php artisan storage:link

# Start the application
php artisan serve
```

## 🎯 Quick Start Guide

### 1. **Access the Application**
- **Public Menu**: `http://localhost:8000/menu`
- **Admin Panel**: `http://localhost:8000/admin`
- **Checkout**: `http://localhost:8000/checkout`

### 2. **Create Your First Tenant**
```bash
# Create a tenant user
php artisan tinker
>>> $user = \App\Models\User::create(['name' => 'Pizza Corner', 'email' => 'pizza@example.com', 'password' => bcrypt('password')]);
>>> $user->assignRole('tenant');
```

### 3. **Add Menu Items**
- Login to admin panel as the tenant
- Navigate to "Menu Items" → "Create"
- Add product details, images, and pricing

### 4. **Start Real-time Features**
```bash
# In a separate terminal
php artisan reverb:start

# Start queue worker (optional, for background jobs)
php artisan queue:work
```

## 📊 Database Schema

### Core Tables
- **users**: Multi-role user management (admin, tenant, customer)
- **menu_items**: Product catalog with categories and availability
- **orders**: Customer orders with delivery and payment tracking
- **order_items**: Individual items within orders
- **expenses**: Business expense tracking with receipts
- **staff**: Employee management with salary information
- **staff_attendance**: Time tracking and payroll calculation
- **tenant_rentals**: Rental payment management

### Relationships
```
Users (1:N) MenuItems
Users (1:N) Orders  
Users (1:N) Expenses
Orders (1:N) OrderItems
MenuItems (1:N) OrderItems
Staff (1:N) StaffAttendance
```

## 🎨 UI/UX Features

### **Modern Menu Browser**
- Grid layout with high-quality images
- Category filtering and search
- Real-time availability status
- Responsive design for all devices

### **Smart Shopping Cart**
- Slide-out panel with smooth animations
- Quantity management with +/- controls
- Real-time total calculation
- Persistent cart across sessions

### **Comprehensive Checkout**
- Multi-step form with validation
- Delivery vs pickup options
- Online and on-site payment methods
- Guest checkout with restrictions

## 🔐 Security & Permissions

### **Role-Based Access Control**
- **Admin**: Full system access, multi-tenant management
- **Tenant**: Own data only, menu and order management
- **Customer**: Public access, order placement

### **Security Features**
- CSRF protection on all forms
- Input validation and sanitization
- Role-based route protection
- Secure file uploads with validation

## 📈 Analytics & Reporting

### **Admin Dashboard**
- Total revenue across all tenants
- Monthly sales trends (Chart.js)
- Expense tracking and profit analysis
- Staff payroll summaries

### **Tenant Dashboard**
- Individual sales performance
- Popular menu items analysis
- Order status distribution
- Revenue vs expenses comparison

## 🔄 Real-time Features

### **Broadcasting Events**
- **OrderPlaced**: Notifies admin and relevant tenants
- **OrderStatusUpdated**: Updates customers and staff
- **Multi-channel**: Public and private channels

### **Live Updates**
- Order notifications in admin panel
- Cart updates without page refresh
- Real-time order status changes

## 🛡️ Testing

```bash
# Run PHP tests
php artisan test

# Run feature tests
php artisan test --testsuite=Feature

# Run unit tests
php artisan test --testsuite=Unit
```

## 📝 API Documentation

The system includes RESTful API endpoints for:
- Menu item retrieval
- Order placement and tracking
- User authentication
- Real-time notifications

## 🚀 Deployment

### **Production Setup**
1. Configure MySQL database
2. Set up Laravel Reverb server
3. Configure queue workers
4. Set up SSL certificates
5. Configure file storage (S3/local)

### **Environment Variables**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=canteen_system

BROADCAST_DRIVER=reverb
QUEUE_CONNECTION=database

REVERB_APP_ID=your-app-id
REVERB_APP_KEY=your-app-key
REVERB_APP_SECRET=your-app-secret
```

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📄 License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details.

## 🆘 Support

- **Documentation**: Check the `DEVELOPMENT_PROGRESS.md` file
- **Issues**: Create an issue on GitHub
- **Email**: support@canteen-system.com

## 🎉 Acknowledgments

- Laravel Team for the amazing framework
- Filament Team for the beautiful admin panel
- Tailwind CSS for the utility-first styling
- Livewire for reactive components

---

**Built with ❤️ using Laravel, Filament, and modern web technologies.**
