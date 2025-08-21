# Coding Exam

This is Coding Exam for the Laravel Developer Position - Red Core Information Technology Solutions Incorporated.

---

## 📌 Features

### **Laravel Backend**
- User and Role management with 1-to-1 relationship
- CRUD API endpoints for **Users**
- CRUD API endpoints for **Roles**
- Login API endpoint using Laravel Sanctum

**Users Table**
- Full Name  
- Email Address  
- Password (with confirmation)  
- Role  

**Roles Table**
- Role Name  
- Description  

---

### **Vue.js Frontend**
- Simple **Login Form**
  - Accepts Email & Password
  - Redirects to Homepage after successful login
  - Displays Full Name of logged-in user
  - Logout option
  - Shows validation errors
- **Role CRUD** operations (consuming Laravel API)
- **User CRUD** operations (consuming Laravel API)
  - Validates duplicate email/name
  - Password rules:
    - Minimum length: 8 characters
    - Confirm password must match
  - Assign Role to User

---

## 🚀 Installation & Setup

### **Backend (Laravel)**

1. Clone the repository:
   ```bash
   git clone https://github.com/ian1219/coding-exam.git
   cd coding-exam/backend
2. composer install
   composer dump-autoload

Test it in postman first because need to create role first before creating user
# Coding Exam

This project is a **Laravel (Backend) + Vue.js with TypeScript (Frontend)** application that demonstrates a simple **User-Role-Permissions API** with authentication and CRUD operations.

---

## 📌 Features

### **Laravel Backend**
- User and Role management with 1-to-1 relationship
- CRUD API endpoints for **Users**
- CRUD API endpoints for **Roles**
- Login API endpoint using Laravel Sanctum

**Users Table**
- Full Name  
- Email Address  
- Password (with confirmation)  
- Role  

**Roles Table**
- Role Name  
- Description  

---

### **Vue.js Frontend**
- Simple **Login Form**
  - Accepts Email & Password
  - Redirects to Homepage after successful login
  - Displays Full Name of logged-in user
  - Logout option
  - Shows validation errors
- **Role CRUD** operations (consuming Laravel API)
- **User CRUD** operations (consuming Laravel API)
  - Validates duplicate email/name
  - Password rules:
    - Minimum length: 8 characters
    - Confirm password must match
  - Assign Role to User

---

## 🚀 Installation & Setup

### **Backend (Laravel)**

1. Clone the repository:
   ```bash
   git clone https://github.com/ian1219/coding-exam.git
   cd coding-exam/backend
2. composer install
   composer dump-autoload

3. php artisan key:generate

4. composer require laravel/sanctum

5. php artisan migrate

6. php artisan serve

7. cd coding-exam/frontend
    npm install

8. npm run dev


Test it in postman first because need to create role first before creating user

curl --location 'http://localhost:8000/api/role/register' \
--header 'Content-Type: application/json' \
--data '{
    "role_name": "Junior Fullstack Developer",
    "description": "Handle both Front-end and Back-end"
}'
