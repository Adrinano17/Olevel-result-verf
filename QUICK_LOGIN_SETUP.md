# Quick Login Setup Guide

## Problem: Database Connection Error

The error `SQLSTATE[HY000] [2002] No connection could be made because the target machine actively refused it` means MySQL is not running or not configured.

## Solution: Choose One Option

### Option 1: Use SQLite (Easiest - No MySQL needed)

1. **Edit your `.env` file** and change:
   ```
   DB_CONNECTION=sqlite
   ```
   
2. **Comment out or remove** these MySQL lines:
   ```
   # DB_HOST=127.0.0.1
   # DB_PORT=3306
   # DB_DATABASE=olevel_verification
   # DB_USERNAME=root
   # DB_PASSWORD=
   ```

3. **Run migrations:**
   ```bash
   php artisan migrate
   ```

4. **Create admin user:**
   ```bash
   php artisan admin:create admin@example.com password123
   ```

5. **Login with:**
   - Email: `admin@example.com`
   - Password: `password123`

### Option 2: Use MySQL (If you have MySQL installed)

1. **Start MySQL service:**
   - Windows: Open Services, find MySQL, and start it
   - Or use XAMPP/WAMP and start MySQL

2. **Create database:**
   ```sql
   CREATE DATABASE olevel_verification;
   ```

3. **Edit your `.env` file:**
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=olevel_verification
   DB_USERNAME=root
   DB_PASSWORD=your_mysql_password
   ```

4. **Run migrations:**
   ```bash
   php artisan migrate
   ```

5. **Create admin user:**
   ```bash
   php artisan admin:create admin@example.com password123
   ```

## Default Login Credentials (After Setup)

After running `php artisan admin:create`, you can login with:

**Admin Account:**
- Email: `admin@example.com`
- Password: `password123`

Or create your own:
```bash
php artisan admin:create your-email@example.com your-password
```

## Regular User Registration

Regular users can register themselves at:
- URL: `http://127.0.0.1:8000/register`
- They will have role: `user` (not admin)

## Troubleshooting

### If migrations fail:
```bash
php artisan migrate:fresh
```

### If you can't find .env file:
```bash
copy .env.example .env
php artisan key:generate
```

### To check database connection:
```bash
php artisan tinker
>>> DB::connection()->getPdo();
```

If this works, your database is connected!

