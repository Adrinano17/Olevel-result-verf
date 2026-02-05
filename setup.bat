@echo off
echo ========================================
echo O-Level Result Verification System Setup
echo ========================================
echo.

echo [1/6] Installing PHP dependencies...
call composer install
if errorlevel 1 (
    echo ERROR: Composer install failed!
    pause
    exit /b 1
)
echo.

echo [2/6] Checking .env file...
if not exist .env (
    echo Creating .env file from .env.example...
    copy .env.example .env
    echo.
    echo IMPORTANT: Please edit .env file and configure:
    echo   - Database credentials
    echo   - API keys
    echo   - Other settings
    echo.
    pause
) else (
    echo .env file already exists.
)
echo.

echo [3/6] Generating application key...
call php artisan key:generate
echo.

echo [4/6] Creating storage link...
call php artisan storage:link
echo.

echo [5/6] Installing frontend dependencies...
call npm install
echo.

echo [6/6] Setup complete!
echo.
echo NEXT STEPS:
echo 1. Edit .env file with your database credentials
echo 2. Create your database: CREATE DATABASE olevel_verification;
echo 3. Run migrations: php artisan migrate
echo 4. Start server: php artisan serve
echo.
echo For detailed instructions, see QUICK_START.md
echo.
pause




