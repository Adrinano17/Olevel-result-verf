# Database Setup and Login Guide

## Issue: Database Connection Error

The error `SQLSTATE[HY000] [2002] No connection could be made because the target machine actively refused it` means your MySQL database server is not running or not properly configured.

## Step 1: Start MySQL Database Server

You need to start your MySQL server. Here are common ways:

### Option A: Using XAMPP/WAMP/MAMP
1. Open XAMPP/WAMP/MAMP Control Panel
2. Start MySQL service
3. Wait for it to show "Running" status

### Option B: Using Windows Services
1. Press `Win + R`, type `services.msc`
2. Find "MySQL" service
3. Right-click and select "Start"

### Option C: Using Command Line
```bash
# If MySQL is installed as a service
net start MySQL
```

## Step 2: Configure Database Connection

1. Open the `.env` file in the `olevel-result` folder
2. Update these database settings:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=olevel_verification
DB_USERNAME=root
DB_PASSWORD=
```

**Note:** 
- If your MySQL password is not empty, add it to `DB_PASSWORD=`
- If your MySQL uses a different port, update `DB_PORT=`
- If your database name is different, update `DB_DATABASE=`

## Step 3: Create the Database

1. Open MySQL command line or phpMyAdmin
2. Run this SQL command:

```sql
CREATE DATABASE IF NOT EXISTS olevel_verification;
```

Or using MySQL command line:
```bash
mysql -u root -p
CREATE DATABASE olevel_verification;
exit;
```

## Step 4: Run Migrations

Once the database is created and MySQL is running:

```bash
cd "C:\Users\ayinlab\Desktop\Olevel result\olevel-result"
php artisan migrate
```

This will create all the necessary tables.

## Step 5: Create Login Account

You have two options:

### Option A: Register a New Account (Regular User)
1. Go to: `http://127.0.0.1:8000/register`
2. Fill in:
   - Name: Your name
   - Email: Your email (e.g., semilogoayinla@gmail.com)
   - Password: Your password
   - Confirm Password: Same password
3. Click "Register"
4. You'll be automatically logged in

### Option B: Create Admin Account (Using Command)
Run this command to create an admin user:

```bash
php artisan admin:create your-email@example.com yourpassword
```

Example:
```bash
php artisan admin:create admin@example.com admin123
```

This will create an admin user with:
- Email: `admin@example.com` (or whatever you specify)
- Password: `admin123` (or whatever you specify)
- Role: `admin`

Then login at: `http://127.0.0.1:8000/login`

## Step 6: Login

1. Go to: `http://127.0.0.1:8000/login`
2. Enter your email and password
3. Click "Login"

## Quick Test

To verify your database connection is working:

```bash
php artisan tinker
```

Then in tinker:
```php
DB::connection()->getPdo();
```

If it returns a PDO object, your connection is working!

## Troubleshooting

### Still getting connection error?

1. **Check if MySQL is running:**
   ```bash
   # In MySQL command line
   mysql -u root -p
   ```

2. **Check your .env file:**
   - Make sure `DB_HOST=127.0.0.1` (or `localhost`)
   - Make sure `DB_PORT=3306` (or your MySQL port)
   - Make sure `DB_USERNAME` and `DB_PASSWORD` are correct

3. **Try using SQLite instead (for testing):**
   In `.env`:
   ```env
   DB_CONNECTION=sqlite
   DB_DATABASE=C:\Users\ayinlab\Desktop\Olevel result\olevel-result\database\database.sqlite
   ```
   
   Then create the SQLite file:
   ```bash
   New-Item -Path "database\database.sqlite" -ItemType File -Force
   php artisan migrate
   ```

4. **Clear config cache:**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   ```

## Default Login Credentials (After Setup)

If you use the admin command:
- **Email:** `admin@example.com` (or what you specified)
- **Password:** `password123` (or what you specified)

If you register:
- Use the email and password you registered with

