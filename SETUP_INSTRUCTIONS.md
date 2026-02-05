# Laravel Setup Instructions - O-Level Result Verification System

## Prerequisites

- PHP 8.1 or higher
- Composer
- MySQL/PostgreSQL database
- Node.js and NPM (for frontend assets)

## Step 1: Install Laravel

If you haven't already installed Laravel, run:

```bash
composer create-project laravel/laravel olevel-result-verification
cd olevel-result-verification
```

## Step 2: Environment Configuration

1. Copy the `.env.example` file to `.env`:
```bash
cp .env.example .env
```

2. Generate application key:
```bash
php artisan key:generate
```

3. Update `.env` file with your database credentials:

```env
APP_NAME="O-Level Result Verification"
APP_ENV=local
APP_KEY=base64:YOUR_GENERATED_KEY
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=olevel_verification
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Mock API Configuration
WAEC_API_URL=http://localhost:8000/api/mock/waec
WAEC_API_KEY=your_waec_api_key_here
NECO_API_URL=http://localhost:8000/api/mock/neco
NECO_API_KEY=your_neco_api_key_here

# API Timeout (in seconds)
API_TIMEOUT=30

# Rate Limiting
RATE_LIMIT_PER_MINUTE=10
```

## Step 3: Database Setup

1. Create the database:
```sql
CREATE DATABASE olevel_verification;
```

2. Run migrations:
```bash
php artisan migrate
```

3. (Optional) Seed the database with test data:
```bash
php artisan db:seed
```

## Step 4: Install Dependencies

Install frontend dependencies:
```bash
npm install
```

Build assets:
```bash
npm run build
```

Or for development:
```bash
npm run dev
```

## Step 5: Configure Authentication

Laravel's authentication scaffolding is already included. To publish authentication views (if needed):

```bash
php artisan ui bootstrap --auth
# or
php artisan ui vue --auth
```

## Step 6: Set Up Storage Link

Create a symbolic link for storage:
```bash
php artisan storage:link
```

## Step 7: Configure Logging

Ensure logging is configured in `config/logging.php`. The default configuration should work, but you can customize it for audit logs.

## Step 8: Set Up Queue (Optional, for async processing)

If you want to process verifications asynchronously:

1. Configure queue driver in `.env`:
```env
QUEUE_CONNECTION=database
```

2. Create queue table:
```bash
php artisan queue:table
php artisan migrate
```

## Step 9: Run the Application

Start the development server:
```bash
php artisan serve
```

The application will be available at `http://localhost:8000`

## Step 10: Create Admin User (Optional)

You can create an admin user using Tinker:

```bash
php artisan tinker
```

Then run:
```php
$user = new App\Models\User();
$user->name = 'Admin User';
$user->email = 'admin@example.com';
$user->password = Hash::make('password');
$user->role = 'admin';
$user->save();
```

## Verification Checklist

- [ ] Laravel installed successfully
- [ ] `.env` file configured
- [ ] Database created and migrations run
- [ ] Application key generated
- [ ] Storage link created
- [ ] Server running on `http://localhost:8000`
- [ ] Can access login/register pages

## Troubleshooting

### Permission Issues
If you encounter permission issues:
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### Database Connection Error
- Verify database credentials in `.env`
- Ensure database server is running
- Check database user has proper permissions

### Migration Errors
- Ensure all migrations are in correct order
- Check for syntax errors in migration files
- Run `php artisan migrate:fresh` to reset (WARNING: deletes all data)

## Next Steps

After setup, proceed to:
1. Configure routes
2. Set up controllers
3. Create views
4. Implement API integration
5. Set up security features






