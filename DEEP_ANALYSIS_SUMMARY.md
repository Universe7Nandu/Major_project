# QRQuest Project - Deep Analysis Summary & Prompts

## 📋 Project Executive Brief

### Project Identity

- **Name**: QRQuest - Tourist Spot Management System
- **Type**: Full-Stack PHP + MySQL Web Application
- **Purpose**: Digitize, manage, and promote tourist attractions with QR code integration
- **Status**: Active Development ✅
- **Repository**: https://github.com/Universe7Nandu/Major_project

---

## 🎯 PROJECT OVERVIEW & CONTEXT

### What is QRQuest?

**QRQuest** is a comprehensive tourist spot management platform designed for heritage sites and local attractions. The application digitizes tourist information with automated QR code generation, enabling both administrators and public users to discover, manage, and explore tourist destinations.

### Target Domain

- **Location**: Solapur, Maharashtra, India
- **Focus**: Religious & historical sites (temples, forts, cultural centers)
- **Scale**: Managing 15+ tourist spots with multimedia content
- **Users**:
  - Admins (2 users managing content)
  - Public (unlimited tourists accessing information)

### Real-World Application

Solapur has multiple world-class heritage sites (Siddheshwar Temple, Grishneshwar Jyotirlinga, Bhuikot Fort) that deserve digital promotion. QRQuest solves this by:

1. Creating digital profiles for each site
2. Generating scannable QR codes for offline/online access
3. Hosting multimedia guides (images, videos, descriptions)
4. Centralizing tourist information
5. Tracking popular spots via QR analytics (future feature)

---

## 🏗️ TECHNICAL DEEP DIVE

### Architecture Pattern

- **Paradigm**: Server-side rendering (SSR) with file-based routing
- **Session Model**: Stateful (PHP sessions)
- **Database**: Relational (MySQL with 3 tables)
- **Frontend**: Responsive HTML5 + CSS3 + Bootstrap
- **QR System**: Automatic generation with PHP QRCode library

### Tech Stack Breakdown

#### Backend Layer (PHP 8.1.12)

```
Database Abstraction: MySQLi (Object-Oriented)
Password Hashing: bcrypt ($2y$10$)
Session Handler: PHP native
File Upload: HTML5 + PHP file handling
Query Format: Raw SQL with prepared statements
```

#### Frontend Layer (Bootstrap 5.3.0)

```
Framework: Bootstrap grid system
CSS: Custom + Bootstrap utilities
JavaScript: Vanilla (no jQuery, no frameworks)
Icons: Font Awesome 6
Typography: Google Fonts (Poppins)
Responsiveness: Mobile-first approach
```

#### Data Layer (MySQL 10.4.27 MariaDB)

```
Tables: 3 (admin, spots, spot)
Relationships: Foreign keys not used
Indexing: Primary keys only
Transactions: Not implemented
Data Volume: 541 files, 23 MB
```

---

## 📊 FUNCTIONAL REQUIREMENTS MATRIX

### Admin Operations (CRUD)

| Operation          | File                      | Database          | Security                       |
| ------------------ | ------------------------- | ----------------- | ------------------------------ |
| **Create Spot**    | addspot.php               | INSERT into spots | File upload validation missing |
| **Read Spot**      | viewspot.php, spot.php    | SELECT from spots | Query escaping present         |
| **Update Spot**    | editspot.php → update.php | UPDATE spots      | Prepared statements used       |
| **Delete Spot**    | deletespot.php            | DELETE from spots | Session validation required    |
| **Authentication** | adminlogin.php            | SELECT from admin | bcrypt password verify ✅      |
| **Registration**   | Adminregister.php         | INSERT into admin | Hash password before insert    |

### Public Operations

| Operation        | File                | Database           | Output                    |
| ---------------- | ------------------- | ------------------ | ------------------------- |
| **View Spot**    | spot.php?id=<id>    | SELECT from spots  | Full details with media   |
| **Browse QR**    | spot.php display    | QR from qrcodes/   | PNG image for sharing     |
| **Access Links** | spot.php links      | s_other_link field | External website redirect |
| **View Media**   | HTML img/video tags | upload/, videos/   | Images & videos display   |

---

## 🗄️ DATABASE SCHEMA DEEP ANALYSIS

### Table: `admin` (User Management)

```sql
┌─────────────────────────────────────────┐
│ admin TABLE                             │
├─────────────────────────────────────────┤
│ PK │ a_id (INT AUTO_INCREMENT)         │
├────┼─────────────────────────────────────┤
│    │ a_name (VARCHAR 255)              │
│    │ a_cont (BIGINT 15) - Phone       │
│    │ a_email (VARCHAR 255) - UNIQUE   │
│    │ a_pass (VARCHAR 255) - bcrypt    │
│    │ a_address (VARCHAR 255)          │
│    │ a_photo (VARCHAR 255)            │
│    │ a_flag (INT) - Status/Roles      │
└─────────────────────────────────────────┘

Current Records: 2 admins
- Vinayak Madgundi (9960414433)
- Vinayak Ambadas Madgundi (9960414430)

Queries:
- Login: SELECT a_id, a_email, a_pass FROM admin WHERE a_email = ? OR a_cont = ?
- Verify: password_verify($input_pass, $db_hash)
```

### Table: `spots` (Primary - Recommended)

```sql
┌──────────────────────────────────────────┐
│ spots TABLE (ACTIVE)                     │
├──────────────────────────────────────────┤
│ PK │ s_id (VARCHAR 255) hex ID        │
├────┼──────────────────────────────────────┤
│    │ s_name (VARCHAR 255) - Location  │
│    │ s_discription (TEXT) - History   │
│    │ s_img (VARCHAR 255) - Image file │
│    │ s_link (VARCHAR 255) - QR link  │
│    │ s_qrcode (VARCHAR 255) - QR path│
│    │ s_other_link (VARCHAR 255) - URL │
│    │ s_video (VARCHAR 255) - Video   │
│    │ s_contact (VARCHAR 255) - Phone  │
└──────────────────────────────────────────┘

Current Records: 15+ tourist spots
Examples:
- Grishneshwar Temple (Jyotirlinga)
- Siddheshwar Temple (Main landmark)
- Solapur Bhuikot Fort (Historical)
- Manacha Panives Ganpati (Cultural)
- Swami Samarth Temple (Religious)

ID Generation: bin2hex(random_bytes(10))
Result: 20-character hex string (e.g., "01c957b2bbc2197564a9")

Queries:
- Create: INSERT INTO spots VALUES (...)
- Read: SELECT * FROM spots WHERE s_id = ?
- Update: UPDATE spots SET ... WHERE s_id = ?
- Delete: DELETE FROM spots WHERE s_id = ?
- List: SELECT * FROM spots
```

### Table: `spot` (Legacy - Deprecated)

```sql
┌──────────────────────────────────────────┐
│ spot TABLE (DEPRECATED)                  │
├──────────────────────────────────────────┤
│ PK │ s_id (INT AUTO_INCREMENT)        │
├────┼──────────────────────────────────────┤
│    │ s_name, s_discription (LONGBLOB)│
│    │ s_img, s_link, s_qrcode         │
│    │ s_flag (INT)                     │
└──────────────────────────────────────────┘

Note: Keep for backward compatibility
Migration: Not required for this version
```

---

## 🔒 SECURITY ASSESSMENT

### Current Security Posture

#### ✅ Implemented Safeguards

| Feature                  | Status | Implementation              |
| ------------------------ | ------ | --------------------------- |
| Password Hashing         | ✅     | bcrypt $2y$10$ with salt    |
| SQL Injection Prevention | ✅     | MySQLi prepared statements  |
| Session Management       | ✅     | alock.php middleware check  |
| Input Escaping           | ✅     | mysqli_real_escape_string() |
| Error Handling           | ✅     | Try-catch blocks            |
| Login Validation         | ✅     | Credential verification     |

#### 🔴 Security Gaps (Critical)

| Vulnerability                  | Risk   | Solution                 |
| ------------------------------ | ------ | ------------------------ |
| No CSRF Tokens                 | High   | Add hidden form tokens   |
| File Upload Validation         | High   | MIME type checking       |
| No Rate Limiting               | High   | Add login attempt limits |
| No HTTPS                       | Medium | Enable SSL/TLS           |
| Hardcoded URLs                 | Medium | Config-based URLs        |
| No Audit Logging               | Medium | Log all admin actions    |
| SQL Injection (Query builder)  | Medium | Use ORM or query builder |
| No Input Validation (Frontend) | Low    | Add form validation      |

---

## 📁 FILE STRUCTURE & ROLE ANALYSIS

### Core Application Files (13 PHP files)

```
1. config.php
   ├─ Purpose: Database connection centralization
   ├─ Key Code: $DBcon = new MySQLi($host, $user, $pass, $db);
   ├─ Security: Contains hardcoded credentials (⚠️ move to env)
   └─ Used By: Every PHP file that queries database

2. adminlogin.php (341 lines)
   ├─ Purpose: Admin authentication form & logic
   ├─ Methods: POST with form submission
   ├─ Security: password_verify() with bcrypt
   ├─ Session: Sets $_SESSION['login_admin'] = $admin_id
   └─ Redirect: → adminhome.php on success

3. Adminregister.php
   ├─ Purpose: Create new admin accounts
   ├─ Methods: Form submission with data insertion
   ├─ Security: Password hashing before INSERT
   ├─ Validation: Email uniqueness check
   └─ Output: Confirmation message

4. alock.php (Session Middleware)
   ├─ Purpose: Check session on every admin page
   ├─ Logic: Verify $_SESSION['login_admin'] exists
   ├─ Action: Redirect to login if session invalid
   ├─ Include: require_once("alock.php"); at top of file
   └─ Coverage: Used in all admin pages

5. alogout.php
   ├─ Purpose: Destroy user session
   ├─ Action: session_destroy()
   ├─ Redirect: → adminlogin.php
   └─ Usage: Click logout button

6. adminhome.php (82+ lines)
   ├─ Purpose: Admin dashboard home page
   ├─ Features: Navigation, quick stats, buttons
   ├─ UI: Bootstrap cards with gradients
   ├─ Links: Add, Edit, Delete, View operations
   └─ Security: alock.php check at start

7. addspot.php (305+ lines)
   ├─ Purpose: Add new tourist spot with files
   ├─ Process:
   │  ├─ Form submission (POST)
   │  ├─ File upload (image, video)
   │  ├─ QR code generation
   │  ├─ Database INSERT
   │  └─ Display confirmation
   ├─ Uploads: upload/, videos/, qrcodes/
   ├─ QR: Using PHP QRCode library (QRcode::png)
   └─ Validation: File type checking (basic)

8. editspot.php
   ├─ Purpose: Modify existing spot details
   ├─ Process: Fetch current data → Form pre-fill → Update
   ├─ Security: ID validation required
   ├─ Files: Can update image/video
   └─ Output: Update confirmation

9. deletespot.php
   ├─ Purpose: Remove tourist spot record
   ├─ Process: Delete from database + clean files
   ├─ Files Removed: Image, video, QR code
   ├─ Security: alock.php + session check
   └─ Redirect: → viewspot.php

10. viewspot.php
    ├─ Purpose: List all spots (admin view)
    ├─ Display: Table format with edit/delete buttons
    ├─ Query: SELECT * FROM spots
    ├─ Pagination: None (all records shown)
    └─ Actions: Edit, Delete, View Details

11. spot.php (206+ lines)
    ├─ Purpose: Public spot details view
    ├─ Access: No authentication required
    ├─ Input: ?id=<spot_id> (GET parameter)
    ├─ Display:
    │  ├─ Image (from upload/)
    │  ├─ Video (from videos/)
    │  ├─ Description
    │  ├─ QR Code
    │  ├─ Contact info
    │  └─ External links
    ├─ Security: GET parameter validation
    └─ Responsive: Bootstrap responsive grid

12. update.php
    ├─ Purpose: Handle database updates (generic handler)
    ├─ Usage: Called by various operations
    ├─ Methods: POST with _method parameter
    ├─ Processing: UPDATE/INSERT/DELETE
    └─ Redirect: Back to calling page

13. styles.css
    ├─ Purpose: Global styling & customization
    ├─ Features: Bootstrap overrides, gradients, animations
    ├─ Colors: Purple (#667eea), pink (#764ba2) gradients
    ├─ Components: Cards, buttons, forms, responsive
    └─ Responsive: Mobile, tablet, desktop breakpoints
```

### Supporting Directories

```
phpqrcode/ (QR Code Library)
├─ Purpose: Generate QR codes for spot links
├─ Key Files:
│  ├─ qrlib.php (Main library)
│  ├─ qrtools.php (Utility functions)
│  ├─ cache/ (1000+ cached frames)
│  └─ bindings/tcpdf/ (TCPDF integration)
├─ Usage: QRcode::png($url, $filename, $level, $size)
└─ Output: PNG files in qrcodes/

qrcodes/ (Generated QR Codes)
├─ Contents: 30+ PNG QR code images
├─ Naming: <spot_id>.png (e.g., "01c957b2bbc2197564a9.png")
├─ Size: ~50 KB each
├─ Generated By: addspot.php, editspot.php
└─ Displayed In: spot.php public view

upload/ (Spot Images)
├─ Contents: 68 image files (JPG, PNG)
├─ Size: ~45 MB total
├─ Naming: <timestamp>_<original_name>
├─ Examples: "1740674679_giri.jpeg", "1740657951_Shri.jpeg"
├─ Uploaded Via: addspot.php file input
└─ Displayed In: spot.php, adminhome.php

videos/ (Spot Videos)
├─ Contents: 2 video files (MP4)
├─ Size: ~500 MB (large!)
├─ Naming: <timestamp>_<original_name>
├─ Example: "1740684995_vinayakV.mp4"
├─ Uploaded Via: addspot.php file input
└─ Displayed In: spot.php <video> tag

admin_images/ (Dashboard Assets)
├─ Contents: 1 image file
├─ Size: Small (~100 KB)
├─ Usage: Admin panel branding/decoration
└─ Displayed In: adminhome.php
```

---

## 💻 CODE PATTERNS & CONVENTIONS

### Database Query Pattern (MySQLi)

#### Pattern 1: Prepared Statement (Recommended)

```php
// Safe against SQL injection
$sql = "SELECT * FROM spots WHERE s_id = ?";
$stmt = $DBcon->prepare($sql);
$stmt->bind_param("s", $spot_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Use $row data
}
$stmt->close();
```

#### Pattern 2: Direct Query (Used in Code - Less Safe)

```php
// Used in current code (with escaping)
$qry = $DBcon->query("SELECT * FROM spots WHERE s_id='$spot_id'");
if ($qry->num_rows > 0) {
    $row = $qry->fetch_assoc();
}
```

### Authentication Pattern

```php
// In adminlogin.php
if (isset($_POST['btn-login'])) {
    $credential = trim($_POST['credential']);
    $password = trim($_POST['password']);

    $sql = "SELECT a_id, a_email, a_pass FROM admin WHERE a_email = ? OR a_cont = ?";
    $stmt = $DBcon->prepare($sql);
    $stmt->bind_param("ss", $credential, $credential);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['a_pass'])) {
            $_SESSION['login_admin'] = $row['a_id'];
            header("Location: adminhome.php");
            exit();
        }
    }
    $stmt->close();
}
```

### File Upload Pattern

```php
// In addspot.php
if (!empty($_FILES['upimg']['name'][0])) {
    foreach ($_FILES['upimg']['tmp_name'] as $key => $value) {
        $filename = $_FILES['upimg']['name'][$key];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);

        if (in_array(strtolower($ext), $valid_formats)) {
            $new_name = time() . "_" . $filename;
            if (move_uploaded_file($value, "upload/" . $new_name)) {
                // Success
            }
        }
    }
}
```

### QR Code Generation Pattern

```php
// In addspot.php
require_once("phpqrcode/qrlib.php");

$generated_link = "http://localhost/major/spot.php?id=" . $spot_id;
$qrFilename = "qrcodes/" . $spot_id . ".png";
QRcode::png($generated_link, $qrFilename, QR_ECLEVEL_L, 10);
```

---

## 📈 PERFORMANCE ANALYSIS

### Current Performance Metrics

| Metric                 | Status      | Value                           |
| ---------------------- | ----------- | ------------------------------- |
| **Database Queries**   | Unoptimized | Full table scans on SELECT      |
| **Page Load**          | Slow        | No caching, full re-renders     |
| **Image Optimization** | Poor        | Original sizes uploaded (45 MB) |
| **QR Cache**           | Growing     | 1000+ cache files not cleaned   |
| **Database Indexing**  | Minimal     | Only primary keys indexed       |

### Bottlenecks Identified 🔴

1. **Database**

   - No indexes on frequently queried columns (s_name, s_id)
   - No pagination → loads all spots at once
   - No caching layer (Redis, Memcached)

2. **Frontend**

   - Full page reloads for every operation
   - No AJAX or dynamic updates
   - Large video files (500 MB total)
   - Images not compressed

3. **Backend**
   - No query optimization
   - File upload not size-limited
   - QR cache grows indefinitely
   - No asset minification

### Quick Wins for Performance 🚀

```sql
-- Add indexes
CREATE INDEX idx_spot_name ON spots(s_name);
CREATE INDEX idx_spot_id ON spots(s_id);

-- Add pagination
SELECT * FROM spots LIMIT 10 OFFSET 0;

-- Add image optimization on upload
// Compress images to 800x600 max
// Convert to WebP format
// Use thumbnails for listings
```

---

## 🚀 DEPLOYMENT ARCHITECTURE

### Local Development Setup

```
localhost:8000 or 127.0.0.1:8000
├─ PHP Built-in Server
├─ Database: Local MySQL/MariaDB
├─ Files: Local filesystem
└─ QR Codes: Local generation
```

### Production Deployment Checklist

#### Pre-Deployment

- [ ] Update config.php with production database
- [ ] Change hardcoded localhost to domain name
- [ ] Update admin passwords
- [ ] Enable HTTPS/SSL certificate
- [ ] Configure error logging (not error display)
- [ ] Set up database backups
- [ ] Test all CRUD operations
- [ ] Optimize images
- [ ] Add rate limiting

#### Server Configuration

```apache
# .htaccess for Apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    # Enforce HTTPS
    RewriteCond %{HTTPS} off
    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

    # Prevent direct file access to sensitive files
    <FilesMatch "\.(sql|json)$">
        Deny from all
    </FilesMatch>
</IfModule>
```

#### File Permissions (Linux/Unix)

```bash
chmod 755 ./
chmod 755 qrcodes/ upload/ videos/ admin_images/
chmod 644 *.php *.css *.sql
chmod 600 config.php  # Most sensitive
```

---

## 📊 PROJECT STATISTICS

| Category               | Count    | Notes                       |
| ---------------------- | -------- | --------------------------- |
| **Total Files**        | 541      | Including libraries & cache |
| **PHP Files**          | 13       | Core application code       |
| **Database Tables**    | 3        | admin, spots, spot (legacy) |
| **Tourist Spots**      | 15+      | Active entries in database  |
| **Admin Users**        | 2        | Vinayak Madgundi accounts   |
| **Generated QR Codes** | 30+      | PNG format in qrcodes/      |
| **Uploaded Images**    | 68       | JPG/PNG in upload/          |
| **Uploaded Videos**    | 2        | MP4 format in videos/       |
| **Cache Files**        | 1000+    | QR library frames in cache/ |
| **Total Size**         | ~23 MB   | Excluding video files       |
| **Code Comments**      | Moderate | ~10-15% commented           |
| **Test Coverage**      | 0%       | No unit/integration tests   |

---

## 🎓 STRONG PROMPT FOR AI AGENTS

### Meta-Prompt (For Generating Great Prompts)

When asked to work on QRQuest, use this strong prompt:

---

### **STRONG PROMPT TEMPLATE**

```markdown
# QRQuest Project Development Request

## Project Context

You are working on QRQuest, a **PHP + MySQL full-stack tourist spot management system**
with QR code generation. The application manages 15+ tourist attractions in Solapur, India,
with admin controls and public access.

## Technical Constraints

- **Backend**: PHP 8.1.12 with MySQLi prepared statements
- **Database**: MySQL 10.4.27 (MariaDB) with 3 tables (admin, spots, spot)
- **Frontend**: Bootstrap 5.3.0 with vanilla JavaScript
- **Libraries**: PHP QRCode for QR generation
- **Architecture**: Server-side rendering with file-based routing

## Code Quality Standards

1. **Security**: Use prepared statements for ALL SQL queries
2. **Authentication**: Check sessions via `require_once("alock.php");` on admin pages
3. **File Handling**: Validate MIME types and size for uploads
4. **Database**: Use MySQLi prepared statements, never raw concatenation
5. **Password**: Hash passwords with bcrypt before storing
6. **Documentation**: Add comments for complex logic

## Directory Structure Rules

- Core PHP files: `/major_project/*.php`
- Uploaded images: `/major_project/upload/`
- Uploaded videos: `/major_project/videos/`
- Generated QR codes: `/major_project/qrcodes/`
- Libraries: `/major_project/phpqrcode/`
- Styling: `/major_project/styles.css`

## Testing Checklist

Before finishing any task:

- [ ] CRUD operations work correctly
- [ ] File uploads function properly
- [ ] QR codes generate and display
- [ ] Admin authentication validates
- [ ] Public pages accessible without login
- [ ] Responsive design works (mobile/tablet)
- [ ] No SQL injection vulnerabilities
- [ ] No session hijacking possible
- [ ] Error messages don't leak data

## Task Requirements

Your task: [SPECIFIC TASK HERE]

Expected deliverables:

1. Working code following project patterns
2. Updated documentation if schema changes
3. Deployment instructions if new dependencies
4. Security review comments
5. Performance optimization suggestions
```

---

## 🎯 SPECIFIC STRONG PROMPTS

### Prompt 1: Adding New Feature

```markdown
# Add [FEATURE NAME] to QRQuest

## Feature Requirements

- [Requirement 1]
- [Requirement 2]
- [Requirement 3]

## Implementation Details

1. **Database Changes**
   - Query: ALTER TABLE spots ADD COLUMN [new_field] [type];
   - Reason: [Why needed]
2. **Admin Page** (new file: `[name].php`)
   - Include: `require_once("alock.php");` at top
   - Form: Bootstrap form with input fields
   - Process: POST handler with validation
   - Query: Prepared statement using `$DBcon->prepare()`
3. **Public Page** (if applicable)

   - Access: No authentication required
   - Display: Responsive Bootstrap layout
   - Security: Input validation and escaping

4. **Files/Directories**
   - New directories: Create with 755 permissions
   - New files: Follow naming convention

## Testing Requirements

- Test with valid/invalid inputs
- Test SQL injection attempts
- Verify responsive design
- Check file upload handling
- Validate QR code generation

## Security Checklist

- [ ] Prepared statements used
- [ ] Input validated
- [ ] Session checked (if admin)
- [ ] File permissions set correctly
- [ ] No hardcoded credentials
```

### Prompt 2: Database Schema Changes

````markdown
# Modify QRQuest Database Schema

## Changes Required

```sql
-- Add new field
ALTER TABLE spots ADD COLUMN rating INT DEFAULT 0;
ALTER TABLE spots ADD COLUMN views INT DEFAULT 0;

-- Add new table
CREATE TABLE spot_ratings (
    r_id INT PRIMARY KEY AUTO_INCREMENT,
    s_id VARCHAR(255) FOREIGN KEY,
    r_rating INT,
    r_date TIMESTAMP
);
```
````

## Impact Analysis

- **Backward Compatibility**: Existing queries still work
- **Migration Path**: Non-destructive, adds columns
- **Performance**: Add indexes if needed
- **Code Updates**: Update 3 files (addspot, editspot, viewspot)

## Testing

- [ ] Schema migration successful
- [ ] Old data preserved
- [ ] New fields accept data
- [ ] Queries work with new schema
- [ ] Deployment script tested

````

### Prompt 3: Security Audit

```markdown
# Security Review of QRQuest

## Audit Scope
Review the following for vulnerabilities:
1. Authentication flow (adminlogin.php)
2. File upload handling (addspot.php)
3. Database queries (all PHP files)
4. Session management (alock.php)
5. Public endpoints (spot.php)

## Check For
- [ ] SQL Injection risks
- [ ] XSS vulnerabilities
- [ ] CSRF attack vectors
- [ ] File upload bypass
- [ ] Session hijacking
- [ ] Hardcoded secrets
- [ ] Insecure passwords
- [ ] Missing validations

## Recommendations
For each finding:
1. Risk level (Critical/High/Medium/Low)
2. Current implementation
3. Vulnerable code snippet
4. Fix/Mitigation
5. Testing approach
````

---

## 📚 REFERENCE DOCUMENTATION

### Key Files Quick Reference

```
config.php ............ DB credentials (UPDATE FOR PROD)
adminlogin.php ........ Login logic
alock.php ............. Session middleware (INCLUDE IN ADMIN FILES)
addspot.php ........... Spot creation + QR generation
spot.php .............. Public spot view
styles.css ............ CSS customization
major (1).sql ......... Database schema
```

### Common Queries

```php
// Get all spots
$qry = $DBcon->query("SELECT * FROM spots");

// Get specific spot
$stmt = $DBcon->prepare("SELECT * FROM spots WHERE s_id = ?");
$stmt->bind_param("s", $spot_id);
$stmt->execute();
$result = $stmt->get_result();

// Create spot
$stmt = $DBcon->prepare("INSERT INTO spots VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssssss", $s_id, $s_name, $s_desc, $s_img, $s_link, $s_qr, $s_other, $s_video, $s_contact);
$stmt->execute();

// Delete spot
$stmt = $DBcon->prepare("DELETE FROM spots WHERE s_id = ?");
$stmt->bind_param("s", $spot_id);
$stmt->execute();
```

---

## ✅ DELIVERABLES CHECKLIST

When completing ANY task on QRQuest:

- [ ] Code follows existing patterns
- [ ] Security validated (no SQL injection)
- [ ] HTTPS ready (if applicable)
- [ ] Comments added for clarity
- [ ] File permissions set correctly
- [ ] Database queries optimized
- [ ] Error handling implemented
- [ ] Tests written or manual verification done
- [ ] Documentation updated
- [ ] Git commits meaningful
- [ ] README updated if needed
- [ ] No hardcoded values (except config.php)

---

**Document Version**: 1.0  
**Created**: December 15, 2025  
**Purpose**: AI Agent Development Guidance  
**Status**: Complete ✅
