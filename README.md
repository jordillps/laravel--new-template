# Laravel Enterprise Template

A comprehensive Laravel application template with advanced security features, role-based access control, and corporate branding capabilities.

## 🚀 Features

### 🔐 Advanced Security & Authentication
- **Multi-Factor Authentication (2FA)** - Two-factor authentication using TOTP
- **Enhanced Password Security** - Strong password requirements and validation
- **Account Lockout Protection** - Automatic account lockout after failed login attempts
- **Session Management** - Secure session handling with proper timeouts
- **CSRF Protection** - Full Cross-Site Request Forgery protection

### 👥 Role-Based Access Control (RBAC)
- **Dynamic Role Management** - Create and manage user roles
- **Permission System** - Granular permission control for resources
- **User Assignment** - Assign multiple roles and permissions to users
- **Resource Protection** - Protect application resources based on permissions

### 🎨 Admin Panel with Filament
- **Modern Interface** - Clean and intuitive admin panel using Filament v4
- **Custom Branding** - Corporate logo and color scheme integration
- **User Management** - Complete user administration interface
- **Role & Permission Management** - Visual management of RBAC system
- **Dashboard Analytics** - User statistics and system overview

### 📧 Custom Email System
- **Branded Email Templates** - Corporate-styled email notifications
- **Multi-language Support** - Spanish and English email templates
- **Custom Notifications** - Personalized email verification, password reset, and 2FA
- **Logo Integration** - Company logo in all email communications
- **Email Testing Tools** - Development commands for email testing and preview

### 🎨 Visual Customization
- **Custom Color Palette** - 11-tone green corporate color scheme
- **Responsive Design** - Mobile-friendly interface across all components
- **Brand Integration** - Consistent corporate branding throughout the application

## 📦 Tech Stack

- **Framework**: Laravel 12.33.0
- **Admin Panel**: Filament v4.0
- **Authentication**: Laravel Fortify
- **RBAC**: Spatie Laravel Permission + Filament Shield
- **Frontend**: Vite + Tailwind CSS
- **Database**: MySQL/PostgreSQL compatible
- **Testing**: PHPUnit with Feature and Unit tests

## 🛠️ Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd laravel-template
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database configuration**
   ```bash
   # Configure your database in .env file
   php artisan migrate
   php artisan db:seed
   ```

5. **Build assets**
   ```bash
   npm run build
   ```

6. **Create admin user**
   ```bash
   php artisan make:filament-user
   ```

## 🔧 Configuration

### Email Configuration
Configure your email settings in `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourcompany.com
MAIL_FROM_NAME="Your Company Name"
```

### 2FA Configuration
Two-factor authentication is enabled by default. Users can enable it from their profile settings.

### Logo Configuration
Place your company logo in `public/media/avatars/logo.png` for email templates.

## 🧪 Testing

### Email Testing Commands
```bash
# Test email functionality
php artisan email:test user@example.com

# Preview email templates
php artisan email:preview
```

### Run Tests
```bash
# Run all tests
php artisan test

# Run specific test suites
php artisan test --testsuite=Feature
php artisan test --testsuite=Unit
```

## 🔒 Security Features

### Account Protection
- Maximum 5 login attempts before account lockout
- 15-minute lockout duration
- Automatic unlock after timeout

### Password Requirements
- Minimum 8 characters
- At least one uppercase letter
- At least one lowercase letter
- At least one number
- At least one special character

### Session Security
- Secure session cookies
- CSRF token validation
- Session regeneration on login

## 📱 Admin Panel Access

Access the admin panel at `/admin` with your administrator credentials.

### Default Features
- User management and role assignment
- Permission management
- System dashboard with analytics
- Profile management with 2FA setup

## 🌍 Localization

The application supports multiple languages:
- **Spanish** (`es`) - Default language
- **English** (`en`) - Available for interface and emails

Switch languages through the application settings or modify `config/app.php`.

## 🚀 Development

### Email Development
Use the provided artisan commands for email development:
```bash
php artisan email:preview  # Preview all email templates
php artisan email:test user@example.com  # Test email delivery
```

### Custom Commands
The template includes custom artisan commands for:
- Email testing and preview
- User role management
- Permission synchronization

## 📄 License

This Laravel template is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 🤝 Support

For support and questions, please refer to the Laravel documentation or create an issue in this repository.
