# O-Level Result Verification System - Requirements Document

## 1. Functional Requirements

### 1.1 User Management
- **FR-1.1**: System shall allow users to register and authenticate
- **FR-1.2**: System shall support role-based access control (Admin, User)
- **FR-1.3**: System shall maintain user profiles with basic information

### 1.2 Result Verification
- **FR-2.1**: System shall accept verification requests with:
  - Candidate exam number
  - Examination year
  - Examination body (WAEC or NECO)
  - Result type (SSCE, GCE, etc.)
- **FR-2.2**: System shall validate all input parameters before processing
- **FR-2.3**: System shall communicate with mock WAEC/NECO API to verify results
- **FR-2.4**: System shall handle API responses:
  - Valid result found
  - Invalid exam number
  - Candidate not found
  - Server errors/timeouts
- **FR-2.5**: System shall return formatted verification results to users
- **FR-2.6**: System shall display verification results clearly with:
  - Candidate name
  - Exam number
  - Subjects and grades
  - Verification status
  - Timestamp

### 1.3 Audit and Logging
- **FR-3.1**: System shall log all verification requests with:
  - User ID
  - Request parameters
  - API response
  - Timestamp
  - IP address
- **FR-3.2**: System shall maintain audit logs for security and compliance
- **FR-3.3**: System shall allow administrators to view audit logs

### 1.4 Mock API
- **FR-4.1**: System shall provide mock WAEC/NECO API endpoints
- **FR-4.2**: Mock API shall simulate various response scenarios:
  - Successful verification
  - Invalid exam number
  - Candidate not found
  - Server errors

### 1.5 JAMB Result Management (Phase 2)
- **FR-5.1**: System shall accept JAMB result submissions with:
  - JAMB registration number
  - JAMB score (0-400)
  - JAMB subjects and scores (4 subjects)
  - Examination year
  - Course choices (first, second, third choice)
- **FR-5.2**: System shall validate JAMB results against course requirements
- **FR-5.3**: System shall store and retrieve JAMB results for users
- **FR-5.4**: System shall provide mock JAMB API endpoint

### 1.6 Post-UTME Result Management (Phase 2)
- **FR-6.1**: System shall accept Post-UTME result submissions with:
  - Post-UTME registration number
  - Post-UTME score (0-100)
  - Examination year
  - Course applied for
- **FR-6.2**: System shall validate Post-UTME results against course cutoffs
- **FR-6.3**: System shall link Post-UTME results to JAMB results
- **FR-6.4**: System shall verify Post-UTME course matches JAMB course choice
- **FR-6.5**: System shall provide mock Post-UTME API endpoint

### 1.7 Admission Validation System (Phase 2)
- **FR-7.1**: System shall perform comprehensive admission validation combining:
  - JAMB result validation
  - O-Level result validation (uses existing FR-2.1 to FR-2.6)
  - Post-UTME result validation (optional)
- **FR-7.2**: System shall validate course-specific requirements:
  - JAMB subject combinations
  - O-Level subject combinations
  - Minimum grades per subject
  - Minimum scores (JAMB and Post-UTME)
- **FR-7.3**: System shall determine admission eligibility based on all validations
- **FR-7.4**: System shall display detailed validation results showing:
  - What passed/failed
  - Specific rejection reasons
  - Overall eligibility status
- **FR-7.5**: System shall allow users to link existing O-Level verification to admission validation

### 1.8 Course Management (Phase 2)
- **FR-8.1**: System shall maintain a database of courses (20 courses across 5 faculties)
- **FR-8.2**: System shall define course-specific requirements:
  - Required JAMB subjects
  - Required O-Level subjects
  - Minimum grades
  - Cutoff scores (JAMB and Post-UTME)
- **FR-8.3**: System shall support multiple faculties (Engineering, Sciences, Medicine & Health Sciences, Social Sciences, Management Sciences)

## 2. Non-Functional Requirements

### 2.1 Performance
- **NFR-1.1**: System shall respond to verification requests within 5 seconds
- **NFR-1.2**: System shall handle at least 100 concurrent users
- **NFR-1.3**: Database queries shall be optimized with proper indexing

### 2.2 Security
- **NFR-2.1**: System shall implement input validation and sanitization
- **NFR-2.2**: System shall enforce rate limiting (e.g., 10 requests per minute per user)
- **NFR-2.3**: System shall use HTTPS for all communications
- **NFR-2.4**: System shall authenticate API requests using API keys stored securely
- **NFR-2.5**: System shall protect against SQL injection, XSS, and CSRF attacks
- **NFR-2.6**: System shall implement secure password storage (hashing)

### 2.3 Reliability
- **NFR-3.1**: System shall handle API timeouts gracefully (30-second timeout)
- **NFR-3.2**: System shall implement retry logic for failed API calls (max 2 retries)
- **NFR-3.3**: System shall maintain 99% uptime

### 2.4 Usability
- **NFR-4.1**: System shall provide intuitive user interface
- **NFR-4.2**: System shall display clear error messages
- **NFR-4.3**: System shall be responsive and mobile-friendly

### 2.5 Maintainability
- **NFR-5.1**: System shall follow Laravel best practices
- **NFR-5.2**: System shall include comprehensive documentation
- **NFR-5.3**: System shall have proper error handling and logging

### 2.6 Scalability
- **NFR-6.1**: System architecture shall support horizontal scaling
- **NFR-6.2**: Database design shall support future enhancements

## 3. System Constraints

- **SC-1**: System must use Laravel framework (PHP 8.1+)
- **SC-2**: System must use MySQL/PostgreSQL database
- **SC-3**: System must integrate with mock examination provider API
- **SC-4**: System must comply with data protection regulations

## 4. Assumptions

- **AS-1**: Mock API will be available and accessible
- **AS-2**: Users have internet connectivity
- **AS-3**: Examination bodies (WAEC/NECO) provide API access
- **AS-4**: API keys will be provided by examination providers
- **AS-5**: Users will have verified O-Level results before admission validation
- **AS-6**: JAMB and Post-UTME results are submitted by users (not verified via external API)
- **AS-7**: Course requirements are predefined and maintained by administrators






