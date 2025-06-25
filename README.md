# AuthEncrypt 🔐

A modern, secure authentication system built with PHP and MySQL, featuring elegant design and advanced security practices.

## ✨ Features

- **Secure Authentication**: Password hashing using PHP's `password_hash()` and `password_verify()`
- **Session Management**: Secure session handling with proper logout functionality
- **MySQL Database**: Uses MySQL/MariaDB for reliable data storage
- **Modern UI**: Beautiful, responsive design with gradient backgrounds and smooth animations
- **User Dashboard**: Clean dashboard interface with user information and activity
- **Registration System**: New user registration with email validation
- **Security-First**: Built with security best practices in mind

## 🚀 Quick Start

### Prerequisites

- **Laragon** (or XAMPP/WAMP) with PHP 7.4+ and MySQL
- Web browser
- Git (for cloning)

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/ifjames/authencrypt.git
   cd authencrypt
   ```

2. **Setup Database**
   - Ensure Laragon's MySQL service is running
   - Run the setup script: `http://localhost/authencrypt/setup_mysql.php`
   - This will create the `authencrypt` database and `users` table

3. **Access the Application**
   - Open `http://localhost/authencrypt/` in your browser
   - Register a new account or login with existing credentials

## 📁 Project Structure

```
authencrypt/
├── index.php           # Landing page
├── login.php           # User login
├── register.php        # User registration
├── dashboard.php       # User dashboard
├── logout.php          # Logout functionality
├── config.php          # Database configuration
├── setup_mysql.php     # Database setup script
├── users.sql           # Database schema
└── config/
    └── database.php    # Database connection class
```

## 🛡️ Security Features

- **Password Hashing**: Uses `PASSWORD_DEFAULT` algorithm
- **SQL Injection Prevention**: Prepared statements throughout
- **Session Security**: Proper session management and cleanup
- **Input Validation**: Server-side validation for all inputs
- **XSS Protection**: HTML escaping for user output

## 🎨 Design Features

- **Responsive Design**: Works on desktop and mobile devices
- **Modern UI**: Clean, professional interface
- **Smooth Animations**: CSS transitions and hover effects
- **Gradient Backgrounds**: Beautiful color schemes
- **Font Awesome Icons**: Consistent iconography

## 🔧 Configuration

### Database Settings (Laragon Default)
- **Host**: localhost
- **Port**: 3306
- **Database**: authencrypt
- **Username**: root
- **Password**: (empty)

### Customization

You can modify the database configuration in `config/database.php`:

```php
private $host = 'localhost';
private $port = '3306';
private $db_name = 'authencrypt';
private $username = 'root';
private $password = '';
```

## 🚦 Usage

1. **Registration**: Create a new account with name, email, and password
2. **Login**: Sign in with your email and password
3. **Dashboard**: View your profile information and account stats
4. **Logout**: Securely end your session

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📝 License

This project is open source and available under the [MIT License](LICENSE).

## 🙏 Acknowledgments

- Built with PHP and MySQL
- Styled with custom CSS and Font Awesome icons
- Designed for Laragon development environment

---

**Made with ❤️ for secure web authentication**
