# Database Schema Design - O-Level Result Verification System

## Overview
This document describes the relational database schema for the O-Level Result Verification System using Laravel.

## Tables

### 1. users
Stores user account information.

| Field | Type | Constraints | Description |
|-------|------|------------|-------------|
| id | bigint | PRIMARY KEY, AUTO_INCREMENT | User ID |
| name | varchar(255) | NOT NULL | User full name |
| email | varchar(255) | UNIQUE, NOT NULL | User email address |
| email_verified_at | timestamp | NULLABLE | Email verification timestamp |
| password | varchar(255) | NOT NULL | Hashed password |
| role | enum('user', 'admin') | DEFAULT 'user' | User role |
| remember_token | varchar(100) | NULLABLE | Remember me token |
| created_at | timestamp | NULLABLE | Record creation timestamp |
| updated_at | timestamp | NULLABLE | Record update timestamp |

**Relationships:**
- One-to-Many: users → verification_requests
- One-to-Many: users → audit_logs

---

### 2. verification_requests
Stores all verification requests made by users.

| Field | Type | Constraints | Description |
|-------|------|------------|-------------|
| id | bigint | PRIMARY KEY, AUTO_INCREMENT | Request ID |
| user_id | bigint | FOREIGN KEY → users.id, NULLABLE | User who made the request |
| exam_number | varchar(50) | NOT NULL | Candidate exam number |
| exam_year | year | NOT NULL | Examination year |
| exam_body | enum('WAEC', 'NECO') | NOT NULL | Examination body |
| result_type | varchar(50) | NOT NULL | Result type (SSCE, GCE, etc.) |
| status | enum('pending', 'success', 'failed', 'timeout') | DEFAULT 'pending' | Request status |
| ip_address | varchar(45) | NULLABLE | IP address of requester |
| created_at | timestamp | NULLABLE | Request timestamp |
| updated_at | timestamp | NULLABLE | Update timestamp |

**Relationships:**
- Many-to-One: verification_requests → users
- One-to-One: verification_requests → verification_results

**Indexes:**
- INDEX on user_id
- INDEX on exam_number
- INDEX on exam_year
- INDEX on exam_body
- INDEX on status
- INDEX on created_at

---

### 3. verification_results
Stores the results of verification requests.

| Field | Type | Constraints | Description |
|-------|------|------------|-------------|
| id | bigint | PRIMARY KEY, AUTO_INCREMENT | Result ID |
| verification_request_id | bigint | FOREIGN KEY → verification_requests.id, UNIQUE, NOT NULL | Associated request |
| candidate_name | varchar(255) | NULLABLE | Candidate name from API |
| response_code | varchar(20) | NOT NULL | API response code |
| response_message | text | NULLABLE | API response message |
| subjects | json | NULLABLE | Array of subjects and grades |
| raw_response | json | NULLABLE | Complete API response |
| verified_at | timestamp | NULLABLE | Verification timestamp |
| created_at | timestamp | NULLABLE | Record creation timestamp |
| updated_at | timestamp | NULLABLE | Record update timestamp |

**Relationships:**
- One-to-One: verification_results → verification_requests

**Indexes:**
- INDEX on verification_request_id
- INDEX on response_code
- INDEX on verified_at

---

### 4. audit_logs
Stores audit trail for security and compliance.

| Field | Type | Constraints | Description |
|-------|------|------------|-------------|
| id | bigint | PRIMARY KEY, AUTO_INCREMENT | Log ID |
| user_id | bigint | FOREIGN KEY → users.id, NULLABLE | User who performed action |
| action | varchar(100) | NOT NULL | Action performed |
| model_type | varchar(255) | NULLABLE | Model type (e.g., VerificationRequest) |
| model_id | bigint | NULLABLE | Model ID |
| description | text | NULLABLE | Action description |
| ip_address | varchar(45) | NULLABLE | IP address |
| user_agent | text | NULLABLE | User agent string |
| request_data | json | NULLABLE | Request data |
| response_data | json | NULLABLE | Response data |
| created_at | timestamp | NULLABLE | Log timestamp |

**Relationships:**
- Many-to-One: audit_logs → users

**Indexes:**
- INDEX on user_id
- INDEX on action
- INDEX on model_type
- INDEX on model_id
- INDEX on created_at

---

## Entity Relationship Diagram (ERD)

```
users
  ├── id (PK)
  └── ...
  
verification_requests
  ├── id (PK)
  ├── user_id (FK → users.id)
  └── ...
  
verification_results
  ├── id (PK)
  ├── verification_request_id (FK → verification_requests.id, UNIQUE)
  └── ...
  
audit_logs
  ├── id (PK)
  ├── user_id (FK → users.id)
  └── ...
```

## Relationships Summary

1. **users → verification_requests**: One-to-Many
   - One user can make multiple verification requests
   - A verification request belongs to one user (nullable for guest requests)

2. **verification_requests → verification_results**: One-to-One
   - Each verification request has one result
   - Each result belongs to one verification request

3. **users → audit_logs**: One-to-Many
   - One user can have multiple audit log entries
   - Each audit log entry belongs to one user (nullable for system actions)

## Migration Files

The following Laravel migrations will be created:
- `create_users_table.php` (usually exists in Laravel)
- `create_verification_requests_table.php`
- `create_verification_results_table.php`
- `create_audit_logs_table.php`






