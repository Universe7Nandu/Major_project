# QRQuest - Tourist Spot Management System 🎯

![QRQuest Banner](./admin_images/banner.jpg)

A comprehensive **web-based application** for managing tourist spots with QR code generation, admin authentication, multimedia support, and interactive spot discovery features.

---

## 📋 Project Overview

**QRQuest** is a full-stack tourist spot management platform designed to digitize local heritage sites and tourist attractions. It enables **administrators** to manage tourist spots with rich media content, while providing **public users** with an interactive, QR-code-based discovery mechanism.

### Key Use Case
Solapur, India, hosts multiple historical and religious sites (Siddheshwar Temple, Grishneshwar Temple, etc.). QRQuest digitizes these locations, making them discoverable via QR codes, enabling detailed information access, multimedia guides, and visitor tracking.

---

## ✨ Features

### 🔐 Admin Panel
- **Secure Authentication**: Email/contact-based login with bcrypt password hashing
- **Spot Management**: Create, Read, Update, Delete (CRUD) operations for tourist spots
- **Multimedia Upload**: Upload images and videos for each spot
- **QR Code Generation**: Automatic QR code creation for each spot (links to spot details)
- **Dashboard**: Admin home page with quick access to all operations
- **Session Management**: Secure session-based authentication with logout functionality

### 🌍 Public Features
- **Spot Discovery**: Browse all registered tourist spots
- **Detailed Spot View**: Access comprehensive information including:
  - Images and videos
  - Descriptions and history
  - Contact information
  - External links
  - QR codes for offline sharing
- **Responsive Design**: Mobile-friendly interface using Bootstrap 5
- **Search & Navigation**: Find spots by name and category

### 🛠️ Technical Features
- **Database Management**: MySQL database with optimized schema
- **File Organization**: Separate directories for uploads, videos, and QR codes
- **QR Code Support**: PHP QR Code library for dynamic QR generation
- **Secure Queries**: MySQLi prepared statements for SQL injection prevention

---

## 🏗️ Project Architecture

```
major_project/
├── index.php                 # Landing page (public)
├── adminlogin.php           # Admin authentication
├── Adminregister.php        # Admin registration
├── adminhome.php            # Admin dashboard
├── addspot.php              # Add new tourist spot
├── editspot.php             # Edit existing spot
├── deletespot.php           # Delete spot
├── spot.php                 # Public spot details view
├── viewspot.php             # Admin spot viewer
├── update.php               # Data update handler
├── alock.php                # Session authentication middleware
├── alogout.php              # Logout handler
├── config.php               # Database configuration
├── styles.css               # Global CSS styling
├── major (1).sql            # Database schema & seed data
├── phpqrcode/               # QR Code library (PHP QRCode)
│   ├── qrlib.php           # QR library core
│   ├── phpqrcode.php       # QR encoder
│   ├── cache/              # QR cache files
│   └── tools/              # Merge and compilation tools
├── qrcodes/                 # Generated QR code images
├── upload/                  # User-uploaded images
├── videos/                  # User-uploaded videos
└── admin_images/            # Admin panel images
```

---

## 💾 Database Schema

### Tables

#### 1. **admin** (Admin Users)
```sql
CREATE TABLE admin (
  a_id INT PRIMARY KEY AUTO_INCREMENT,
  a_name VARCHAR(255),
  a_cont BIGINT(15),              -- Contact number
  a_email VARCHAR(255),
  a_pass VARCHAR(255),            -- Bcrypt hashed password
  a_address VARCHAR(255),
  a_photo VARCHAR(255),
  a_flag INT                      -- Status flag
);
```

#### 2. **spots** (Tourist Spots - Main Table)
```sql
CREATE TABLE spots (
  s_id VARCHAR(255) PRIMARY KEY,  -- Unique hex ID (bin2hex)
  s_name VARCHAR(255),            -- Spot name
  s_discription TEXT,             -- Description
  s_img VARCHAR(255),             -- Image filename
  s_link VARCHAR(255),            -- Generated QR link
  s_qrcode VARCHAR(255),          -- QR code file path
  s_other_link VARCHAR(255),      -- External website link
  s_video VARCHAR(255),           -- Video filename
  s_contact VARCHAR(255)          -- Contact info
);
```

#### 3. **spot** (Legacy Table)
- Older structure (retained for backward compatibility)
- Fields: s_id, s_name, s_discription, s_img, s_link, s_qrcode, s_flag

---

## 🛡️ Security Features

| Feature | Implementation |
|---------|-----------------|
| **Password Hashing** | bcrypt ($2y$10$) with proper salt |
| **SQL Injection Prevention** | MySQLi prepared statements |
| **Session Management** | PHP session tokens (alock.php checks) |
| **Input Validation** | mysqli_real_escape_string for user inputs |
| **CORS Protection** | Server-side request handling |

---

## 🔧 Tech Stack

### Backend
| Technology | Purpose | Version |
|-----------|---------|---------|
| **PHP** | Server-side scripting | 8.1.12 |
| **MySQL** | Relational database | 10.4.27 (MariaDB) |
| **MySQLi** | Database abstraction | Native |
| **PHP QRCode** | QR code generation | Latest |

### Frontend
| Technology | Purpose |
|-----------|---------|
| **HTML5** | Semantic markup |
| **CSS3** | Styling & animations |
| **Bootstrap 5** | Responsive framework |
| **JavaScript** | Interactivity |
| **Font Awesome 6** | Icon library |
| **Google Fonts (Poppins)** | Typography |

### Server & Infrastructure
| Component | Specification |
|-----------|---------------|
| **Server** | Apache/PHP Development Server |
| **Database** | MySQL/MariaDB |
| **Version Control** | Git |
| **Hosting** | Ready for shared/VPS hosting |

---

## 📦 Installation Guide

### Prerequisites
- **PHP** 7.4+ (tested on 8.1.12)
- **MySQL** 5.7+ or **MariaDB** 10.4+
- **Web Server** (Apache/Nginx)
- **Git**

### Setup Steps

#### 1. Clone Repository
```bash
git clone https://github.com/Universe7Nandu/Major_project.git
cd Major_project
```

#### 2. Database Setup
```bash
# Open phpMyAdmin or MySQL CLI
mysql -u root -p

# Create database
CREATE DATABASE major;
USE major;

# Import schema
SOURCE major_project/major\ \(1\).sql;
```

#### 3. Configure Database
Edit `config.php`:
```php
$DBhost = "localhost";
$DBuser = "root";
$DBpass = "your_password";  # Update this
$DBname = "major";
```

#### 4. Directory Permissions
```bash
chmod 755 qrcodes/
chmod 755 upload/
chmod 755 videos/
chmod 755 admin_images/
chmod 755 phpqrcode/cache/
```

#### 5. Start Development Server
```bash
# Option A: Built-in PHP server
php -S localhost:8000

# Option B: Apache with XAMPP/WAMP
# Place in htdocs/ and access via http://localhost/major/
```

#### 6. Access Application
- **Admin Panel**: `http://localhost:8000/adminlogin.php`
- **Public View**: `http://localhost:8000/spot.php`

---

## 👥 Default Credentials

**Admin Accounts** (from database):

| Email | Contact | Password | Name |
|-------|---------|----------|------|
| vinayakm2410@gmail.com | 9960414433 | bcrypt hash | VINAYAK MADGUNDI |
| madgundivinayak2002@gmail.com | 9960414430 | bcrypt hash | Vinayak Ambadas Madgundi |

> ⚠️ **Note**: Change these credentials before production deployment!

---

## 📖 Usage Guide

### For Admin Users

#### Login
1. Navigate to `adminlogin.php`
2. Enter email/contact number and password
3. Click "Login" button

#### Add Tourist Spot
1. Click "Add Spot" in dashboard
2. Fill form:
   - **Spot Name**: e.g., "Siddheshwar Temple"
   - **Description**: Detailed history/information
   - **Image**: Upload main image (JPG, PNG, GIF, BMP)
   - **Video**: Optional video upload (MP4, AVI, MOV, MKV)
   - **External Link**: Link to official website
   - **Contact**: Phone number or email
3. Submit form → QR code auto-generated
4. Spot is live and accessible via generated link

#### Edit/Delete Spot
1. View all spots in dashboard
2. Click "Edit" to modify details
3. Click "Delete" to remove spot

### For Public Users

#### View Spots
1. Navigate to `spot.php?id=<spot_id>`
2. View:
   - Spot image and details
   - Description and history
   - Contact information
   - External links
   - QR code for sharing

#### Scan QR Code
- Use any QR code scanner
- Automatically redirects to spot details page

---

## 🎨 UI/UX Features

- **Responsive Design**: Works on desktop, tablet, mobile
- **Modern Styling**: Gradient backgrounds, smooth animations
- **Interactive Elements**: Hover effects, transitions
- **Accessibility**: Semantic HTML, proper contrast
- **Performance**: Optimized image loading, CSS minification ready

---

## 🐛 Known Issues & Limitations

| Issue | Impact | Workaround |
|-------|--------|-----------|
| **Hardcoded localhost URLs** | Links break on production | Update `config.php` URLs for production domain |
| **File uploads without validation** | Security risk | Add MIME type validation |
| **No email notifications** | Admin doesn't get alerts | Implement PHPMailer for email features |
| **QR code cache not cleaned** | Disk space growth | Implement cache cleanup script |
| **No user rate limiting** | Brute force possible | Add login attempt limiting |

---

## 🚀 Deployment Checklist

- [ ] Update database credentials in `config.php`
- [ ] Change hardcoded URLs from `localhost` to production domain
- [ ] Update admin email/passwords
- [ ] Enable HTTPS/SSL certificate
- [ ] Set proper file permissions (644 for files, 755 for directories)
- [ ] Enable PHP error logging, disable error display
- [ ] Set up automated database backups
- [ ] Implement rate limiting on admin login
- [ ] Add file upload MIME validation
- [ ] Test all CRUD operations
- [ ] Monitor disk space for uploads/QR codes

---

## 📊 File Statistics

| Directory | Files | Size | Purpose |
|-----------|-------|------|---------|
| phpqrcode/ | 42 | ~5 MB | QR code library & cache |
| upload/ | 68 | ~45 MB | User-uploaded images |
| videos/ | 2 | ~500 MB | User-uploaded videos |
| qrcodes/ | 30+ | ~2 MB | Generated QR codes |
| Root | 13 | ~100 KB | PHP files & config |

**Total**: 541 files, ~23 MB (excluding large video files)

---

## 🔐 Environment Variables (Recommended for Production)

```bash
DB_HOST=localhost
DB_USER=admin_user
DB_PASS=secure_password
DB_NAME=major
APP_URL=https://yourdomain.com
ADMIN_EMAIL=admin@yourdomain.com
```

---

## 📝 Code Quality Notes

### Strengths ✅
- Clean file organization
- Proper database schema design
- Session-based authentication
- QR code automation
- Responsive UI

### Areas for Improvement 🔧
- Add form validation on frontend
- Implement CSRF tokens
- Add error handling middleware
- Create API layer for mobile apps
- Add unit tests
- Implement logging system
- Add admin audit trail

---

## 🤝 Contributing

1. Fork the repository
2. Create feature branch: `git checkout -b feature/YourFeature`
3. Commit changes: `git commit -m 'Add YourFeature'`
4. Push to branch: `git push origin feature/YourFeature`
5. Open Pull Request

---

## 📜 License

This project is provided as-is for educational and commercial use. 

---

## 👨‍💼 Author

**Vinayak Ambadas Madgundi**
- Email: madgundivinayak2002@gmail.com | vinayakm2410@gmail.com
- Contact: 9960414433 | 9960414430
- Location: Solapur, Maharashtra, India
- Role: Full Stack Web Developer, Gen AI Developer

---

## 📞 Support & Contact

For issues, features, or questions:
- 📧 Email: madgundivinayak2002@gmail.com
- 📱 Phone: 9960414433
- 🐙 GitHub: [Universe7Nandu](https://github.com/Universe7Nandu)

---

## 📚 Additional Resources

- [PHP QRCode Documentation](https://tcpdf.org/)
- [Bootstrap 5 Docs](https://getbootstrap.com/docs/5.0/)
- [MySQL Query Optimization](https://dev.mysql.com/doc/)
- [OWASP PHP Security](https://owasp.org/)

---

**Last Updated**: December 15, 2025  
**Repository**: https://github.com/Universe7Nandu/Major_project  
**Status**: Active Development ✅

