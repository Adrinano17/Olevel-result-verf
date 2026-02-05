# Quick Start Guide - O-Level Result Verification System

## ✅ Will This Project Work?

**Yes, this project will work!** However, you need to complete the setup steps below first.

## Prerequisites Check

Before running, ensure you have:
- ✅ PHP 8.1 or higher
- ✅ Composer installed
- ✅ MySQL/PostgreSQL database server running
- ✅ Node.js and NPM installed

## Step-by-Step Setup Instructions

### Step 1: Install PHP Dependencies

```bash
cd olevel-result
composer install
```

### Step 2: Configure Environment

1. Copy the environment file:
```bash
copy .env.example .env
```
(On Linux/Mac: `cp .env.example .env`)

2. Generate application key:
```bash
php artisan key:generate
```

3. Edit `.env` file and update these settings:

```env
APP_NAME="O-Level Result Verification"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=olevel_verification
DB_USERNAME=root
DB_PASSWORD=your_password_here

# Mock API Configuration (for testing)
WAEC_API_URL=http://localhost:8000/api/mock/waec
WAEC_API_KEY=test_waec_key_123
NECO_API_URL=http://localhost:8000/api/mock/neco
NECO_API_KEY=test_neco_key_123

# API Timeout (in seconds)
API_TIMEOUT=30

# Rate Limiting
RATE_LIMIT_PER_MINUTE=10
```

### Step 3: Create Database

Create a MySQL database:

```sql
CREATE DATABASE olevel_verification;
```

Or use phpMyAdmin/MySQL Workbench to create the database.

### Step 4: Run Migrations

```bash
php artisan migrate
```

This will create all necessary tables:
- users
- verification_requests
- verification_results
- audit_logs

### Step 5: Install Frontend Dependencies (Optional but Recommended)

```bash
npm install
```

### Step 6: Create Storage Link

```bash
php artisan storage:link
```

### Step 7: Start the Development Server

```bash
php artisan serve
```

The application will be available at: **http://localhost:8000**

## First Time Setup - Create Admin User

After starting the server, create an admin user:

1. Open a new terminal/command prompt
2. Run:
```bash
php artisan tinker
```

3. In the tinker console, type:
```php
$user = new App\Models\User();
$user->name = 'Admin User';
$user->email = 'admin@example.com';
$user->password = Hash::make('password123');
$user->role = 'admin';
$user->save();
exit
```

4. Now you can login with:
   - Email: `admin@example.com`
   - Password: `password123`

## How to Use the Application

1. **Register/Login**: Go to http://localhost:8000 and register a new account or login
2. **Verify Result**: Click "Verify Result" and fill in the form:
   - Exam number (e.g., `12345678901`)
   - Exam year
   - Exam body (WAEC or NECO)
   - Result type
3. **View Results**: After verification, view the result details
4. **View History**: Check your verification history

## Testing the Mock API

The system includes mock API endpoints for testing. Test scenarios:

- **Valid Result**: Use exam number like `12345678901`
- **Invalid Exam Number**: Use `INVALID123` or any number less than 8 characters
- **Candidate Not Found**: Use exam number containing `NOTFOUND` or `NF`
- **Server Error**: Random 5% chance (just try again)
- **Timeout**: Random 3% chance (just try again)

## Troubleshooting

### Error: "Class 'App\Http\Controllers\VerificationController' not found"
**Solution**: Run `composer dump-autoload`

### Error: "SQLSTATE[HY000] [1045] Access denied"
**Solution**: Check your database credentials in `.env` file

### Error: "Route [login] not defined"
**Solution**: Make sure `routes/auth.php` exists (it should be created automatically)

### Error: "The stream or file could not be opened"
**Solution**: 
```bash
php artisan storage:link
chmod -R 775 storage bootstrap/cache
```

### Port Already in Use
**Solution**: Use a different port:
```bash
php artisan serve --port=8001
```

## Verification Checklist

Before running, verify:
- [ ] Composer dependencies installed (`composer install`)
- [ ] `.env` file created and configured
- [ ] Application key generated (`php artisan key:generate`)
- [ ] Database created
- [ ] Migrations run successfully (`php artisan migrate`)
- [ ] Storage link created (`php artisan storage:link`)

## Common Commands

```bash
# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Run migrations
php artisan migrate

# Rollback last migration
php artisan migrate:rollback

# Reset database (WARNING: deletes all data)
php artisan migrate:fresh

# Check routes
php artisan route:list
```

## Next Steps

1. ✅ Complete the setup steps above
2. ✅ Start the server: `php artisan serve`
3. ✅ Register/Login to the system
4. ✅ Test verification with mock data
5. ✅ Review the documentation files for more details

## Need Help?

- Check `SETUP_INSTRUCTIONS.md` for detailed setup
- Check `PROJECT_DOCUMENTATION.md` for complete documentation
- Check `SECURITY.md` for security features
- Check `SYSTEM_DEFENSE.md` for system defense explanation

---

**Ready to run!** Follow the steps above and your application will be working. 🚀




