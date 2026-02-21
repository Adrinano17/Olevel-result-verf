# Database Setup Script for O-Level Result Verification System
Write-Host "Setting up database..." -ForegroundColor Green

# Check if .env exists
if (-not (Test-Path ".env")) {
    Write-Host "Creating .env file from .env.example..." -ForegroundColor Yellow
    if (Test-Path ".env.example") {
        Copy-Item ".env.example" ".env"
    } else {
        Write-Host "ERROR: .env.example not found. Please create .env manually." -ForegroundColor Red
        exit 1
    }
}

Write-Host "`nTo use SQLite (recommended for quick setup):" -ForegroundColor Cyan
Write-Host "1. Open .env file" -ForegroundColor Yellow
Write-Host "2. Change these lines:" -ForegroundColor Yellow
Write-Host "   DB_CONNECTION=sqlite" -ForegroundColor White
Write-Host "   # Comment out or remove DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD" -ForegroundColor White
Write-Host ""
Write-Host "OR to use MySQL:" -ForegroundColor Cyan
Write-Host "1. Make sure MySQL is running" -ForegroundColor Yellow
Write-Host "2. Open .env file" -ForegroundColor Yellow
Write-Host "3. Set these values:" -ForegroundColor Yellow
Write-Host "   DB_CONNECTION=mysql" -ForegroundColor White
Write-Host "   DB_HOST=127.0.0.1" -ForegroundColor White
Write-Host "   DB_PORT=3306" -ForegroundColor White
Write-Host "   DB_DATABASE=olevel_verification" -ForegroundColor White
Write-Host "   DB_USERNAME=root" -ForegroundColor White
Write-Host "   DB_PASSWORD=your_password" -ForegroundColor White
Write-Host ""
Write-Host "After configuring .env, run:" -ForegroundColor Green
Write-Host "  php artisan migrate" -ForegroundColor White
Write-Host "  php artisan admin:create admin@example.com password123" -ForegroundColor White

