# FoodFusion - Culinary Community Platform

## Academic Purpose

This project was developed for **academic purposes** as a fulfillment of an assignment requirement for a web development course. It demonstrates the implementation of a full-stack PHP application using modern best practices, including Object-Oriented Programming (OOP), secure session management, and database integration.

---

## Project Overview

FoodFusion is a comprehensive web platform designed for culinary enthusiasts to discover, share, and learn about cooking. It provides a seamless experience for both guest users and registered members to explore recipes, access educational resources, and participate in a community-driven culinary environment.

### Key Features

- **Dynamic Landing Page**: Features a responsive hero section, a "Join Us" modal for quick registration, and a carousel highlighting upcoming events.
- **Secure Authentication**: Robust login and registration system featuring:
  - Secure password hashing.
  - Session-based user states.
  - **Account Lockout**: Automated security mechanism that temporarily disables logins after multiple failed attempts.
- **Profile Management**: Users can manage their personal information (Name, Email, Phone, Address) and upload a profile picture.
- **Admin Dashboard**: A comprehensive management interface for authorized users (Admins/Managers) to:
  - Manage user accounts (Ban/Unban users).
  - Modify user roles (User, Manager, Admin).
  - Add new recipes and educational resources directly to the platform.
- **Content Library**: Categorized sections for:
  - **Featured Recipes**: Community and curated culinary trends.
  - **Educational Resources**: Guides on nutrition, food safety, and sustainable cooking.
  - **Culinary Resources**: Practical guides like knife skills and sauce mastering.
- **Responsive Design**: Fully optimized for mobile, tablet, and desktop using Bootstrap 5.
- **Privacy & Compliance**: Integrated cookie consent banner and privacy policy placeholders.

---

## Technology Stack

- **Backend**: PHP 8.x (utilizing OOP principles and PDO for database interaction).
- **Frontend**: HTML5, Vanilla CSS, Bootstrap 5.2.3, JavaScript.
- **Database**: MySQL / MariaDB.
- **Dependency Management**: Composer.
- **Environment Configuration**: Dotenv for secure credential management.

---

## Installation & Setup

### Prerequisites

- PHP 8.0 or higher.
- Composer.
- MySQL/MariaDB server.

### Steps to Run Locally

1.  **Clone the Repository**:

    ```bash
    git clone https://github.com/YanMyoaung/Profile.git
    cd foodfusion
    ```

2.  **Install Dependencies**:

    ```bash
    composer install
    ```

3.  **Configure Environment**:
    Rename `.env.example` to `.env` and update your database credentials:

    ```bash
    DB_HOST=127.0.0.1
    DB_USER=root
    DB_PASS=your_password
    DB_NAME=food_fusion
    ```

4.  **Initialize the Database**:
    Run the automated script to create the database schema and seed initial data:

    ```bash
    composer run db:reset
    ```

5.  **Preparation for Uploads**:
    Ensure the profile photo directory exists and has correct permissions:

    ```bash
    mkdir -p actions/photos
    ```

6.  **Start the Application**:
    You can use the built-in PHP server:
    ```bash
    php -S localhost:8000
    ```
    Access the site at `http://localhost:8000`.

---

## Disclaimer

This project is intended for educational use. The placeholder images and content are used for demonstration purposes.
