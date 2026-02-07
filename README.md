# Mini Contact Website (PHP)

A clean, secure, and professional contact website built with **PHP** and **MySQL**.
This project includes an **admin panel** for managing messages and demonstrates
real-world backend development and deployment workflow.

---

## 🔗 Live Demo
- Website: https://minicontact.rf.gd
- Admin Panel: https://minicontact.rf.gd/admin

---

## ✨ Features

### 🔹 Frontend
- Contact form (Name, Email, Message)
- Clean, modern, and responsive UI
- User-friendly design

### 🔹 Backend
- PHP form handling
- MySQL database integration
- Secure data storage
- Input validation

### 🔹 Admin Panel
- Admin login system
- Secure password hashing (`password_hash`)
- Reset password functionality
- View contact messages
- Delete messages
- Logout system

---

## 🗄️ Database Structure

- **admins**
  - id
  - username
  - password (hashed)
  - created_at

- **messages**
  - id
  - name
  - email
  - message
  - created_at

---

## 🛠 Technologies Used
- PHP (Core PHP)
- MySQL
- HTML5
- CSS3
- phpMyAdmin
- InfinityFree Hosting

---

## 🚀 Deployment
- Local development using **Laragon**
- Database exported via phpMyAdmin
- Uploaded project as ZIP file
- Deployed on **InfinityFree**
- Connected to production MySQL database

---

## 🧠 Challenges & Learning Outcomes

### Problems Faced
- Reset password PHP TypeError
- Database mismatch (localhost vs production)
- File structure issues after ZIP upload
- Unexpected default `index2.html`

### Solutions
- Fixed PHP variable handling
- Proper database export & import
- Corrected `/htdocs` directory structure
- Removed unused default files

### Lessons Learned
- Secure authentication using password hashing
- Difference between local and production environments
- PHP debugging and error handling
- Real-world deployment workflow
- Database migration process

---

## 🎯 Project Purpose
This project was built as part of my learning journey as an **IT student**
to strengthen my skills in backend development, security, and deployment.
It also serves as a **portfolio project**.

---

## 👤 Author
**Pich Chanthorn**  
IT Student | Web Developer  
Founder & CEO at PCTN  
Phnom Penh, Cambodia

---

## 📅 Year
2026
