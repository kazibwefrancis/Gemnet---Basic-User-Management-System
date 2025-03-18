# Gemnet 💎 User Management System

Welcome to **Gemnet 💎**, a robust and user-friendly **User Management System** built using **plain PHP** and **MySQL**. This system provides essential user authentication and profile management functionalities while ensuring security best practices.

---

## Features

- **User Registration**: Users can register by providing a username, email, password, and uploading a profile picture (max 5MB).
- **Secure Login & Logout**: Authentication using PHP sessions with password hashing.
- **Profile Management**: Users can edit their username, email, and profile picture.
- **Account Deletion**: Users can delete their accounts, removing their profile picture from the server.
- **File Upload Handling**: Profile pictures are validated for size (max 5MB) and format (JPG, JPEG, PNG).
- **Security Features**:
  - Input validation to prevent SQL injection and XSS attacks.
  - Password hashing using `password_hash()` and `password_verify()`.
  - Secure session management.
- **Persistent Login**: "Remember Me" functionality using cookies.
- **Password Reset**: Users can reset their password via email (optional implementation).

---

## Project Structure

The project follows a clean and modular structure:

```
user-management-system/
│
├── config/
│   ├── db.php          # Database connection
│   └── auth.php        # Authentication functions
│
├── includes/
│   ├── header.php      # Common header
│   ├── footer.php      # Common footer
│   └── functions.php   # Helper functions
│
├── css/
│   └── style.css       # Custom styles
│
├── js/
│   └── script.js       # Custom JavaScript
│
├── uploads/            # Folder for profile pictures
│
├── index.php           # Home page
├── register.php        # Registration form and processing
├── login.php           # Login form and processing
├── dashboard.php       # User dashboard
├── edit-profile.php    # Profile editing
├── delete-account.php  # Account deletion
├── logout.php          # Logout functionality
├── reset-password.php  # Password reset
└── remember-me.php     # "Remember Me" feature
```

---

## Setup Instructions

### 1. **Database Setup**

- Create a MySQL database named `user_management`.
- Run the following SQL command to create the `users` table:

```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    profile_picture VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### 2. **Database Connection**

- Update `config/db.php` with your MySQL credentials:

```php
<?php
$host = 'localhost';      // Database host
$dbname = 'user_management'; // Database name
$username = 'root';       // Database username
$password = '';           // Database password

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
```

### 3. **File Upload Permissions**

- Ensure the `uploads/` directory has the correct permissions:

```bash
chmod 755 uploads/
```

### 4. **Running the Application**

- Place the project folder in your web server's root directory (`htdocs` for XAMPP, `www` for WAMP).
- Open your browser and visit: `http://localhost/user-management-system/`.

---

## Usage Guide

1. **Register an Account**: Visit `register.php` and fill in your details.
2. **Log In**: Use `login.php` with your credentials.
3. **Dashboard**: Upon login, access `dashboard.php` to manage your profile.
4. **Edit Profile**: Update your details at `edit-profile.php`.
5. **Delete Account**: Remove your account via `delete-account.php`.
6. **Logout**: End your session using `logout.php`.

---

## Security Considerations

- **Input Validation**: Sanitization to prevent SQL injection and XSS.
- **Password Hashing**: Secure storage using `password_hash()`.
- **Session Management**: Prevents session hijacking and unauthorized access.
- **File Upload Validation**: Only allows JPG, JPEG, and PNG formats up to 5MB.

---

##

---

## Contributors

- Bantrobusa kazibwe FZ
- Jemimah Tendo


---

## License

This project is open-source and available under the [MIT License](LICENSE).

---

##

---

##

