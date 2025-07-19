#!/bin/bash

echo "🚀 Setting up Centralized Canteen E-Commerce Management System..."

# Copy .env file if it doesn't exist
if [ ! -f .env ]; then
    cp .env.example .env
    echo "✅ Created .env file"
fi

# Generate application key
php artisan key:generate
echo "✅ Generated application key"

# Run migrations
php artisan migrate --force
echo "✅ Database migrations completed"

# Publish Spatie permissions migration and run it
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan migrate --force
echo "✅ Spatie permissions setup completed"

# Seed roles and permissions
php artisan db:seed --class=RoleSeeder
echo "✅ Roles and permissions seeded"

# Create storage symlink
php artisan storage:link
echo "✅ Storage symlink created"

# Install and build frontend assets
npm install
npm run build
echo "✅ Frontend assets built"

# Create Filament admin user
php artisan make:filament-user
echo "✅ Filament admin user creation prompt completed"

echo ""
echo "🎉 Setup completed successfully!"
echo ""
echo "📋 Next steps:"
echo "1. Configure your database in the .env file"
echo "2. Set up Laravel Reverb for real-time features: php artisan reverb:start"
echo "3. Start the development server: php artisan serve"
echo "4. Access the admin panel at: /admin"
echo "5. Access the public menu at: /menu"
echo ""
echo "🔧 Development commands:"
echo "- Run migrations: php artisan migrate"
echo "- Start Reverb: php artisan reverb:start"
echo "- Start queue worker: php artisan queue:work"
echo "- Seed sample data: php artisan db:seed"