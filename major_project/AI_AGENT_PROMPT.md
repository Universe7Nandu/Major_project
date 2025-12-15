# QRQuest Project - AI Agent Prompt Documentation

## 🎯 Executive Summary

**Project Name**: QRQuest - Tourist Spot Management System  
**Type**: Full-Stack Web Application  
**Purpose**: Digitize and manage tourist attractions with QR code-based discovery  
**Target Users**: Admin (tourist board/museum staff), Public (visitors/tourists)  
**Repository**: https://github.com/Universe7Nandu/Major_project  

---

## 📊 Complete Project Analysis

### 1. **Project Scope**
This is a **PHP + MySQL web application** that enables:
- Administrative management of tourist spots (CRUD operations)
- Automatic QR code generation for each spot
- Multimedia support (images, videos, descriptions)
- Public access to spot information via QR codes or direct links
- Secure admin authentication with bcrypt passwords
- Responsive, modern UI using Bootstrap 5

### 2. **Tech Stack (Comprehensive)**

#### Backend Stack
```
Language: PHP 8.1.12
Server: Apache / Built-in PHP Server
Database: MySQL 10.4.27 (MariaDB) / MySQL 5.7+
Database Driver: MySQLi (Object-Oriented)
ORM: None (Raw MySQLi queries)
Authentication: bcrypt ($2y$10$)
Session Handler: PHP native $_SESSION
```

#### Frontend Stack
```
HTML: HTML5 with semantic markup
CSS: CSS3 with custom styling
Framework: Bootstrap 5.3.0
JavaScript: Vanilla JS (no frameworks)
Icons: Font Awesome 6.0.0
Typography: Google Fonts (Poppins family)
Responsiveness: Mobile-first Bootstrap grid
```

#### Libraries & Extensions
```
QR Code: PHP QRCode library (phpqrcode/)
Image Processing: PHP GD Library
File Upload: HTML5 File API + PHP upload
Session Management: PHP session_start()
```

#### Infrastructure
```
Version Control: Git
Repository Hosting: GitHub
Directory Structure: File-based organization
```

### 3. **Core Features Breakdown**

#### Authentication & Authorization
- **Login System**: Email/Contact-based credentials
- **Password Security**: bcrypt hashing with salt
- **Session Management**: PHP $_SESSION with middleware (alock.php)
- **Logout**: Session destruction with alogout.php
- **Registration**: Admin account creation (Adminregister.php)

#### Admin Dashboard Features
- Dashboard home (adminhome.php)
- Add tourist spots (addspot.php)
- Edit existing spots (editspot.php)
- Delete spots (deletespot.php)
- View all spots (viewspot.php)
- Update operations (update.php)

#### Public Features
- Browse spot details (spot.php with ID parameter)
- View images and videos
- Access descriptions and history
- View contact information
- Access QR codes
- Click external links

#### QR Code System
- Automatic generation on spot creation
- Links: `http://localhost/major/spot.php?id=<unique_hex_id>`
- Storage: qrcodes/ directory
- Format: PNG images
- Generation Library: PHP QRCode

### 4. **Database Architecture**

#### Database: `major`

**Table 1: admin**
```
Structure:
- a_id (INT, PRIMARY KEY, AUTO_INCREMENT)
- a_name (VARCHAR 255)
- a_cont (BIGINT 15) - Contact number
- a_email (VARCHAR 255) - Unique email
- a_pass (VARCHAR 255) - Bcrypt hash
- a_address (VARCHAR 255)
- a_photo (VARCHAR 255)
- a_flag (INT) - Status/permission flag

Sample Data: 2 admin accounts
- Vinayak Madgundi (vinayakm2410@gmail.com)
- Vinayak Ambadas Madgundi (madgundivinayak2002@gmail.com)
```

**Table 2: spots (PRIMARY)**
```
Structure:
- s_id (VARCHAR 255, PRIMARY KEY) - Unique hex ID
- s_name (VARCHAR 255) - Spot name
- s_discription (TEXT) - Description/history
- s_img (VARCHAR 255) - Image filename
- s_link (VARCHAR 255) - Generated QR link
- s_qrcode (VARCHAR 255) - QR code path
- s_other_link (VARCHAR 255) - External URL
- s_video (VARCHAR 255) - Video filename
- s_contact (VARCHAR 255) - Contact info

Sample Data: ~15 tourist spots
- Siddheshwar Temple
- Grishneshwar Temple
- Solapur Bhuikot Fort
- Panives Ganpati
- Various local landmarks
```

**Table 3: spot (LEGACY)**
```
Structure:
- s_id (INT, PRIMARY KEY)
- s_name (VARCHAR 255)
- s_discription (LONGBLOB)
- s_img (VARCHAR 255)
- s_link (VARCHAR 255)
- s_qrcode (VARCHAR 255)
- s_flag (INT)

Note: Retained for backward compatibility, contains older data
```

### 5. **File Structure & Organization**

```
major_project/
│
├── Core PHP Files
│   ├── config.php ..................... Database connection config
│   ├── adminlogin.php ................ Admin authentication page
│   ├── Adminregister.php ............ Admin registration
│   ├── alock.php ..................... Session middleware check
│   ├── alogout.php .................. Logout handler
│   │
│   ├── Admin Operations
│   ├── adminhome.php ............... Admin dashboard
│   ├── addspot.php ................. Add tourist spot (with QR generation)
│   ├── editspot.php ................ Edit spot details
│   ├── deletespot.php .............. Delete spot
│   ├── viewspot.php ................ View all spots (admin)
│   ├── update.php .................. Data update handler
│   │
│   ├── Public Interface
│   └── spot.php .................... Public spot details view
│
├── Styling
│   └── styles.css ................... Global CSS styling
│
├── Database
│   └── major (1).sql ............... Database schema + seed data
│
├── Third-party Libraries
│   └── phpqrcode/ ................... QR Code generation library
│       ├── qrlib.php
│       ├── phpqrcode.php
│       ├── qrconfig.php
│       ├── qrencode.php
│       ├── qrimage.php
│       ├── qrinput.php
│       ├── qrtools.php
│       ├── cache/ .................. QR cache files (1000+)
│       ├── bindings/tcpdf/
│       └── tools/
│
├── Data Directories
│   ├── qrcodes/ ................... Generated QR code images
│   ├── upload/ .................... Uploaded spot images (68 files)
│   ├── videos/ .................... Uploaded videos (2 files)
│   └── admin_images/ .............. Admin panel images
│
└── Git
    └── .git/ ...................... Version control
```

### 6. **Security Implementation**

#### Current Security Measures ✅
- **Password Hashing**: bcrypt with $2y$10$ prefix
- **SQL Injection Prevention**: MySQLi prepared statements
- **Session Validation**: alock.php checks session before allowing access
- **Input Escaping**: mysqli_real_escape_string() usage
- **Error Handling**: Try-catch and conditional checks

#### Security Gaps 🔴
- No CSRF tokens
- File upload lacks MIME validation
- No rate limiting on login
- No input validation on frontend
- URLs hardcoded with localhost
- No HTTPS enforcement
- Session timeout not implemented
- No audit logging
- No SQL query optimization for injection

### 7. **Key File Functionality**

| File | Purpose | Key Functions |
|------|---------|----------------|
| config.php | DB connection | mysqli connection setup |
| adminlogin.php | Auth form | Login validation, password verify |
| adminhome.php | Admin panel | Dashboard display, UI |
| addspot.php | Create spot | Form submission, file upload, QR generation |
| editspot.php | Update spot | Edit form, database update |
| deletespot.php | Remove spot | Delete record, cleanup files |
| spot.php | Public view | Display spot details, media |
| viewspot.php | Admin view | List all spots |
| alock.php | Middleware | Session check on every admin page |
| styles.css | Styling | Bootstrap customization, animations |

### 8. **Data Flow Architecture**

```
Admin Flow:
┌─────────────────┐
│  adminlogin.php │ ──→ validate credentials ──→ $_SESSION['login_admin']
└─────────────────┘
         ↓
    session stored
         ↓
┌─────────────────┐
│   alock.php     │ ──→ check session on every admin action
└─────────────────┘
         ↓
    ┌─────────────────────────────────────┐
    │   Admin Dashboard (adminhome.php)   │
    │   - Add Spot (addspot.php)          │
    │   - Edit Spot (editspot.php)        │
    │   - Delete Spot (deletespot.php)    │
    │   - View Spots (viewspot.php)       │
    └─────────────────────────────────────┘
         ↓
    ┌────────────────────────────────┐
    │  Database Operations via update.php
    │  File Upload → qrcodes/, upload/, videos/
    │  QR Code Generation (phpqrcode)
    └────────────────────────────────┘

Public Flow:
┌──────────────────────┐
│   spot.php?id=123    │ ──→ Query spots table
└──────────────────────┘
         ↓
    Fetch spot record
         ↓
    ┌──────────────────────────────────┐
    │  Display:
    │  - Image (upload/)
    │  - Video (videos/)
    │  - Description
    │  - QR Code
    │  - Links
    │  - Contact Info
    └──────────────────────────────────┘
```

### 9. **Functionality Matrix**

| Module | Create | Read | Update | Delete | Notes |
|--------|--------|------|--------|--------|-------|
| **Spots** | ✅ addspot.php | ✅ spot.php, viewspot.php | ✅ editspot.php | ✅ deletespot.php | Full CRUD |
| **Admin Users** | ✅ Adminregister.php | ✅ adminlogin.php | ❌ No edit | ❌ No delete | Login only |
| **Files** | ✅ Upload | ✅ Retrieve | ❌ No update | ✅ Delete | Image, video, QR |
| **QR Codes** | ✅ Auto-generate | ✅ Display | ❌ Regenerate | ✅ Delete | PHP QRCode lib |

### 10. **Performance Considerations**

#### Current Performance Issues ⚠️
- No database indexing on frequently queried fields
- QR cache can grow indefinitely
- No pagination on spot listings
- Images not optimized
- No CDN setup
- Full-page reloads for operations

#### Optimization Opportunities 🚀
- Add database indexes on s_id, s_name
- Implement pagination (LIMIT, OFFSET)
- Image compression on upload
- Caching headers for static files
- AJAX for operations (no full reload)
- Database query optimization

### 11. **Deployment Readiness**

#### Requirements for Production 📋
- Change localhost URLs
- Update database credentials
- Update admin passwords
- Enable HTTPS/SSL
- Set proper file permissions
- Configure error logging
- Set up automated backups
- Implement rate limiting
- Add file validation
- Test all operations

#### Hosting Options 🌐
- Shared Hosting (cPanel, Plesk)
- VPS (DigitalOcean, Linode)
- Cloud (AWS, Google Cloud)
- Docker containerization possible

---

## 🎓 AI Agent Instructions

### When Asked to Extend Project:

1. **Follow Existing Patterns**
   - Use MySQLi for database operations
   - Maintain file organization structure
   - Follow current naming conventions
   - Use existing CSS/Bootstrap framework

2. **Maintain Security**
   - Use prepared statements for all SQL
   - Validate all user inputs
   - Hash passwords with bcrypt
   - Check sessions via alock.php

3. **Documentation Requirements**
   - Update README.md with new features
   - Add code comments for complex logic
   - Document database schema changes
   - Update deployment checklist

4. **Testing Checklist**
   - Verify CRUD operations work
   - Check file uploads function
   - Test QR code generation
   - Validate authentication flows
   - Test responsive design

### Common Development Tasks:

```php
// Task: Add new field to spots table
ALTER TABLE spots ADD COLUMN new_field VARCHAR(255);

// Task: Create new admin page
// File: project_new_feature.php
// Include: require_once("alock.php");
// Query: Use prepared statements
$stmt = $DBcon->prepare("SELECT * FROM spots WHERE condition = ?");
$stmt->bind_param("s", $param);
```

---

## 📈 Project Metrics

| Metric | Value |
|--------|-------|
| Total Files | 541 |
| Total Size | ~23 MB (excl. videos) |
| PHP Files | 13 |
| Database Tables | 3 |
| Tourist Spots | 15+ |
| Admin Users | 2 |
| QR Codes Generated | 30+ |
| Uploaded Images | 68 |
| Libraries Used | 1 (PHP QRCode) |
| Code Comments | Moderate |
| Test Coverage | None (No tests) |

---

## 🔗 Quick Reference Links

- **GitHub**: https://github.com/Universe7Nandu/Major_project
- **Admin Login**: `/adminlogin.php`
- **Public View**: `/spot.php?id=<id>`
- **Database File**: `/major (1).sql`
- **Config File**: `/config.php`

---

## 📝 Important Notes for AI Agents

1. **Database ID Format**: Spots use `VARCHAR(255)` with hex values (bin2hex), NOT auto-increment
2. **QR Code Links**: Always generated as `http://localhost/major/spot.php?id=<hex_id>`
3. **File Uploads**: Stored in separate directories (upload/, videos/, qrcodes/)
4. **Session Check**: Every admin page must include `require_once("alock.php");`
5. **Bootstrap Classes**: Uses Bootstrap 5.3.0, not v4 or custom classes
6. **Authentication**: Uses bcrypt, verify with `password_verify()`
7. **Queries**: Always use prepared statements for safety

---

## 🚀 Future Enhancement Opportunities

### Short-term (v1.1)
- [ ] Add spot search/filter functionality
- [ ] Implement spot categories/tags
- [ ] Add user ratings/reviews
- [ ] Email notifications for admins
- [ ] Two-factor authentication
- [ ] API endpoints for mobile app

### Mid-term (v2.0)
- [ ] User registration for visitors
- [ ] Spot recommendations based on preferences
- [ ] Map integration (Google Maps)
- [ ] Audio guides for spots
- [ ] Mobile app (iOS/Android)
- [ ] Analytics dashboard

### Long-term (v3.0)
- [ ] AI-powered spot suggestions
- [ ] Multilingual support
- [ ] Augmented Reality (AR) features
- [ ] Blockchain-based ticketing
- [ ] Real-time visitor tracking
- [ ] Micro-services architecture

---

**Document Version**: 1.0  
**Last Updated**: December 15, 2025  
**Status**: Production Ready with Notes  
**Audience**: AI Agents, Developers, DevOps Engineers

