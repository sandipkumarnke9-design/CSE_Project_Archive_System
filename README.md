# Academic Project Management System (APMS)

A web-based Academic Project Management System (APMS) developed as a Major Project for the Bachelor of Technology (B.Tech) in Computer Science and Engineering at Baba Ghulam Shah Badshah University, Rajouri (J&K).

## 📖 Project Overview

The Academic Project Management System (APMS) is a centralized web-based platform designed to manage academic project records and industrial training records for Computer Science and Engineering departments.

The system solves the problem of decentralized project storage, repeated project topics, inefficient manual record handling, and limited access to previous academic work.

It acts as a secure institutional repository where students can:

- Search previous academic projects
- Explore industrial training records
- Submit new project details
- Upload multimedia project resources
- Avoid topic duplication
- Access historical academic references

Administrators can:

- Manage project submissions
- Approve or reject records
- Edit project details
- Delete invalid entries
- Monitor industrial training records
- Maintain system integrity

---

## 🎯 Problem Statement

Educational institutions often face challenges in managing academic project and industrial training records due to:

- Repetition of project topics
- Fragmented data storage
- Manual administrative workflows
- Lack of searchable archives
- Poor accessibility to historical academic records
- Data integrity and security concerns

APMS addresses these issues by providing a centralized, searchable, secure digital repository.

---

## ✨ Key Features

### User Module
- User Registration & Login
- Secure Authentication
- Search Previous Projects
- Search Industrial Training Records
- Add New Academic Projects
- Upload Audio Project Presentation
- Upload Video Demonstration
- View Approved Records
- Personalized User Dashboard

### Admin Module
- Admin Login Dashboard
- Add New Projects
- Manage All Projects
- Approve / Reject Submissions
- Edit Project Records
- Delete Records
- Search Projects
- Manage Industrial Training Data
- Role-Based Access Management

---

## 🏗 System Architecture

APMS follows a **Three-Tier Architecture**:

### 1. Presentation Layer
Frontend user interface built using:

- HTML5
- CSS3
- JavaScript

Responsible for:
- Forms
- Dashboards
- Search interfaces
- Navigation components

### 2. Application Layer
Backend logic implemented using:

- PHP

Handles:
- Authentication
- Session Management
- Role-based access control
- CRUD operations
- File uploads
- Data validation

### 3. Data Layer
Database management using:

- MySQL

Stores:
- Users
- Projects
- Industrial Training Records
- Authentication data

---

## 🛠 Technology Stack

| Technology | Purpose |
|----------|---------|
| HTML5 | Frontend structure |
| CSS3 | Styling |
| JavaScript | Interactivity |
| PHP | Backend logic |
| MySQL | Database |
| XAMPP | Local development server |
| Apache | Web server |

---

## 📂 Project Modules

### Authentication Module
- User Registration
- Login
- Logout
- Session Control

### User Dashboard Module
- Welcome dashboard
- Search options
- Project browsing

### Project Management Module
- Add Project
- Edit Project
- Delete Project
- Search Projects

### Industrial Training Module
- Add Training Records
- Search Training Records
- Manage submissions

### Admin Control Module
- Dashboard management
- Project approval workflow
- Record moderation

---

## 📁 Project Structure

```bash
CSE_Project_Archive_System/
│
├── api/
│   ├── login_api.php
│   ├── register_api.php
│   └── projects_api.php
│
├── assets/
│   ├── css/
│   ├── js/
│   └── images/
│
├── dashboard/
│   ├── admin_dashboard.php
│   └── user_dashboard.php
│
├── database/
│   └── db.php
│
├── middleware/
│   └── auth.php
│
├── projects/
│   ├── add_project.php
│   ├── edit_project.php
│   ├── delete_project.php
│   ├── manage_projects.php
│   ├── search.php
│   ├── training.php
│   └── edit_training.php
│
├── public/
│   ├── index.php
│   ├── login.php
│   ├── register.php
│   └── logout.php
│
└── uploads/

🔐 Security Features

Password Hashing
Session-Based Authentication
Role-Based Access Control (RBAC)
Protected Admin Routes
Input Validation
Secure Login System
Controlled Record Approval Workflow

⚙ Installation Guide
Prerequisites

Install:

XAMPP
PHP
MySQL
Apache Server
Web Browser

Setup Steps
1. Clone Repository
git clone https://github.com/sandipkumarnke9-design/CSE_Project_Archive_System.git

2. Move Project
Copy project folder to:
C:\xampp\htdocs\

3. Start XAMPP
Start:
Apache
MySQL

4. Create Database
Open:
http://localhost/phpmyadmin

Create database:
cse_project_archive
Import SQL file.

5. Configure Database Connection
Edit:
database/db.php

Update:
$host = "localhost";
$username = "root";
$password = "";
$database = "cse_project_archive";

6. Run Project
Open browser:
http://localhost/CSE_Project_Archive_System/public/

📸 System Screenshots

Include screenshots for:

Home Page
Registration Page
Login Page
User Dashboard
Search Projects
Industrial Training
Admin Dashboard
Manage Projects
Edit Project Page

🚀 Future Scope

Possible enhancements:

Email notifications
AI-based duplicate topic detection
Advanced analytics dashboard
Previous year question paper repository
Learning resources module
Mobile application
University ERP integration
Multi-department support
Cloud deployment
🎓 Academic Information

Project Title: Academic Project Management System
Degree: Bachelor of Technology (B.Tech)
Branch: Computer Science and Engineering
University: Baba Ghulam Shah Badshah University, Rajouri (J&K)
Academic Year: 2022–2026

👨‍💻 Contributors
Sandip Kumar
Ahsan Noorani

Project Guide: Mrs. Rukhsana Thaker

🙏 Acknowledgement

This project was developed as part of the B.Tech Major Project submission for academic fulfillment at Baba Ghulam Shah Badshah University.

Special thanks to:

Mrs. Rukhsana Thaker
Department of Computer Science & Engineering
Baba Ghulam Shah Badshah University
📄 License

This project is developed for academic and educational purposes.





