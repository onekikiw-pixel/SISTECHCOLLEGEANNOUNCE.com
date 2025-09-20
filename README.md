School Announcements (PHP + MySQL)
==================================

What this package contains
- index.php            : Public homepage showing announcements (past, present, future)
- login.php            : Login page for users
- register.php         : Register new user
- admin.php            : Add announcements (protected)
- db.php               : Database connection (configure DB credentials here)
- logout.php           : Logout script
- style.css            : Basic styling
- init.sql             : SQL to create database & tables
- helpers.php          : Helper functions (auth check)

Quick setup (XAMPP on Windows)
1. Copy the folder into your XAMPP htdocs directory, e.g. C:\xampp\htdocs\school-announcements
2. Start Apache and MySQL from XAMPP Control Panel.
3. Create the database and tables:
   - Open phpMyAdmin (http://localhost/phpmyadmin)
   - Create database `school_announcements` (or create via the SQL file)
   - Or run the SQL in the provided init.sql file.
4. Edit db.php if your MySQL user/password is different (default: user=root, password=empty).
5. Visit:
   - Register: http://localhost/school-announcements/register.php
   - Login:    http://localhost/school-announcements/login.php
   - Home:     http://localhost/school-announcements/index.php
   - Admin:    http://localhost/school-announcements/admin.php (requires login)

Notes
- Passwords are securely hashed using password_hash().
- Announcements have start_date and end_date. The homepage groups them into Past / Present / Future.
- This is a lightweight example for learning and small deployments. For production, add CSRF protection, input validation, HTTPS, and stronger session handling.
