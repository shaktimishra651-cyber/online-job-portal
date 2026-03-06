-- Create Database
CREATE DATABASE IF NOT EXISTS jobportal;
USE jobportal;

-- ========================
-- USERS TABLE
-- ========================
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100),
    password VARCHAR(100),
    role ENUM('admin','employer','seeker') DEFAULT 'seeker'
);

-- ========================
-- JOBS TABLE
-- ========================
CREATE TABLE jobs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150),
    company VARCHAR(150),
    location VARCHAR(100),
    description TEXT,
    posted_by INT
);

-- ========================
-- RESUMES TABLE
-- ========================
CREATE TABLE resumes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    resume_file VARCHAR(255),
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ========================
-- APPLICATIONS TABLE
-- ========================
CREATE TABLE applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    job_id INT,
    user_id INT,
    applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);