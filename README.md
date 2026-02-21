# O-Level Result Verification System

A comprehensive Laravel-based web application for verifying WAEC and NECO O-Level examination results through integration with mock examination provider APIs.

## Features

- ✅ Secure result verification for WAEC and NECO
- ✅ User authentication and authorization
- ✅ Comprehensive audit logging
- ✅ Rate limiting and security features
- ✅ Mock API endpoints for testing
- ✅ Beautiful and responsive UI
- ✅ Verification history tracking
- ✅ Role-based access control

## Quick Start

### Prerequisites
- PHP 8.1 or higher
- Composer
- MySQL/PostgreSQL
- Node.js and NPM

### Installation

1. **Clone the repository**
```bash
git clone <repository-url>
cd olevel-result-verification
```

2. **Install dependencies**
```bash
composer install
npm install
```

3. **Configure environment**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Update `.env` file**
```env
DB_DATABASE=olevel_verification
DB_USERNAME=your_username
DB_PASSWORD=your_password

WAEC_API_URL=http://localhost:8000/api/mock/waec
WAEC_API_KEY=your_waec_api_key_here
NECO_API_URL=http://localhost:8000/api/mock/neco
NECO_API_KEY=your_neco_api_key_here
```

5. **Run migrations**
```bash
php artisan migrate
```

6. **Start the server**
```bash
php artisan serve
```

Visit `http://localhost:8000` in your browser.

## Documentation

- **[Requirements](REQUIREMENTS.md)** - Functional and non-functional requirements
- **[Database Schema](DATABASE_SCHEMA.md)** - Complete database design
- **[Setup Instructions](SETUP_INSTRUCTIONS.md)** - Detailed setup guide
- **[Security Features](SECURITY.md)** - Security implementation details
- **[Project Documentation](PROJECT_DOCUMENTATION.md)** - Complete project documentation
- **[System Defense](SYSTEM_DEFENSE.md)** - System defense explanation

## Project Structure

```
olevel-result-verification/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── VerificationController.php
│   │   │   └── MockApiController.php
│   │   └── Middleware/
│   │       └── RateLimitVerification.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── VerificationRequest.php
│   │   ├── VerificationResult.php
│   │   └── AuditLog.php
│   └── Services/
│       ├── ExaminationApiService.php
│       └── AuditLogService.php
├── database/
│   └── migrations/
│       ├── create_verification_requests_table.php
│       ├── create_verification_results_table.php
│       └── create_audit_logs_table.php
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php
│       └── verification/
│           ├── index.blade.php
│           ├── result.blade.php
│           └── history.blade.php
└── routes/
    ├── web.php
    └── api.php
```

## Usage

### Verifying a Result

1. Register/Login to the system
2. Fill in the verification form:
   - Exam number
   - Examination year
   - Examination body (WAEC/NECO)
   - Result type
3. Click "Verify Result"
4. View the verification result

### Mock API Testing

The system includes mock API endpoints for testing:

- **WAEC**: `POST /api/mock/waec`
- **NECO**: `POST /api/mock/neco`

#### Test Scenarios

- **Valid Result**: Use any exam number (e.g., "12345678901")
- **Invalid Exam Number**: Use "INVALID" in exam number
- **Candidate Not Found**: Use "NOTFOUND" in exam number
- **Server Error**: Random 5% chance
- **Timeout**: Random 3% chance

## Security Features

- ✅ Input validation and sanitization
- ✅ Rate limiting (10 requests/minute)
- ✅ API authentication with keys
- ✅ HTTPS enforcement
- ✅ CSRF protection
- ✅ XSS prevention
- ✅ SQL injection prevention
- ✅ Comprehensive audit logging
- ✅ Role-based access control

## API Documentation

### Mock API Endpoint

**POST** `/api/mock/waec` or `/api/mock/neco`

**Headers:**
```
Authorization: Bearer {api_key}
Content-Type: application/json
```

**Request:**
```json
{
    "exam_number": "12345678901",
    "year": 2023,
    "result_type": "SSCE"
}
```

**Response (Success):**
```json
{
    "success": true,
    "code": "SUCCESS",
    "message": "Result verified successfully",
    "data": {
        "candidate_name": "John Doe",
        "exam_number": "12345678901",
        "subjects": [
            {
                "subject": "Mathematics",
                "grade": "A1"
            }
        ]
    }
}
```

## Testing

### Manual Testing Checklist

- [ ] User registration
- [ ] User login
- [ ] Form validation
- [ ] Successful verification
- [ ] Error handling (invalid exam number)
- [ ] Error handling (candidate not found)
- [ ] Rate limiting
- [ ] Audit logging
- [ ] Authorization checks
- [ ] Verification history

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## License

This project is proprietary software.

## Support

For questions or support, please contact the development team.

---

**Version**: 1.0.0  
**Last Updated**: 2024





$admin = App\Models\User::where('role', 'admin')->first();
if ($admin) {
    $admin->password = Hash::make('newpassword123');
    $admin->save();
    echo "Password reset for: " . $admin->email . "\n";
} else {
    echo "No admin user found\n";
}
exit

$user = new App\Models\User();
$user->name = 'Admin User';
$user->email = 'admin@example.com';
$user->password = Hash::make('password123');
$user->role = 'admin';
$user->save();
echo "Admin created: admin@example.com / password123\n";
exit




