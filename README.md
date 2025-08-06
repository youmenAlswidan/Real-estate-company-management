<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel Logo">
  </a>
</p>

<h1 align="center">real-estate-company-management</h1>

<p align="center">
  A simple and organized admin dashboard for managing real estate properties and visit reservations. It provides a clean interface for customers to browse properties, request visit appointments, and interact with the company team.
</p>

---

## 🏠 Project Overview

A complete real estate company management system built with Laravel 12.  
Admins and employees use a Blade-based dashboard, while customers access property listings and book visits via a RESTful API.

---

## 🚀 Key Features

- ✅ JWT authentication for customers
- ✅ Laravel UI session-based authentication for admin panel
- ✅ Role and permission management using Spatie
- ✅ Admin dashboard built with Blade
- ✅ Public API for guests and customers
- ✅ Property management with types (Apartment, Villa, Land, Shop)
- ✅ Optional extra services per property
- ✅ Visit booking, customer reviews, and booking history
- ✅ Email notifications for visit 

---

## 👥 User Roles

| Role | Capabilities |
|------|--------------|
| 👑 Admin | Manage properties, types, users, staff, permissions, and reports |
| 🧑‍💼 Employee | Manage bookings, confirm/reschedule/cancel appointments, view customer notes |
| 👤 Customer | Register/login, browse properties, book visits, submit reviews |
| 🌐 Guest | Browse properties without registration |

---

## 🏡 Property Attributes

- Name  
- Type (Apartment, Villa, Land, Shop)  
- Location (City, District, Address)  
- Number of rooms  
- Area (square meters)  
- Price  
- Status (Available / Sold / Rented)  
- Images  
- Description  
- Extra services (Furnished, AC, Garden, Garage, Elevator)

---

## ✅ Functional Requirements

### 👤 Customer
- Register (Full name, Email, Password)
- Login and logout
- Browse properties by type
- View property details
- Request visit (date & time)
- View booking history
- Submit reviews or notes after visits

### 🧑‍💼 Employee
- Login
- View & manage bookings (confirm, cancel, reschedule)
- Communicate with customers to confirm appointments
- View customer notes about properties

### 👑 Admin
- Login
- Manage property types
- Create, update, delete properties
- Manage property data (images, description, status)
- Manage employees and users
- Manage roles and permissions
- View system reports:
  - Total properties
  - Most viewed or booked properties
  - Bookings over time
  - Confirmed / cancelled bookings

---

## ⚙️ Non-Functional Requirements

- User-friendly and intuitive admin interface(usability)
- Data security (authentication, permissions, password hashing)(scurity)
- Good performance and fast response time
- Email notifications (via Laravel Mail)
- Clean code using Laravel MVC architecture(maintinability)
- Secure image uploads (stored in `storage/app/public`)

---

## 📬 Mailing

The system uses Laravel Mail to send booking confirmation emails to customers once appointments are approved by employees.

---

## 🛡️ Roles & Permissions

The system uses [Spatie Laravel Permission](https://github.com/spatie/laravel-permission) to manage roles and permissions.  
Seeders are included to create a sample admin account for testing purposes.

---

## 🛠️ Installation & Setup

```bash
# Clone the project
git clone https://github.com/youmen_alswidan/real-estate-company-management.git
cd real-estate-company-management

# Install dependencies
composer install
npm install && npm run dev

# Configure environment
cp .env.example .env
php artisan key:generate

# Run migrations and seed the database
php artisan migrate --seed

# Start the local development server
php artisan serve
