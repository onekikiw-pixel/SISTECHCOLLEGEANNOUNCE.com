-- Run this in phpMyAdmin or via MySQL CLI to set up database and tables
CREATE DATABASE IF NOT EXISTS school_announcements CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE school_announcements;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  display_name VARCHAR(255) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS announcements (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  content TEXT NOT NULL,
  start_date DATE NOT NULL,
  end_date DATE NOT NULL,
  created_by INT DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Optional: create an admin user (username: admin, password: admin123)
INSERT INTO users (username, password, display_name)
VALUES ('admin', '$2y$10$u1J1dZ0b8CR5z3b6u0y4Eu2eZc0W8lq1mQye5oF8f0J6G6xZk1q6a', 'Administrator');
-- Password above is a bcrypt hash for "admin123" (only for demo). Change in production.
