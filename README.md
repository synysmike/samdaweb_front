# MyShop - E-Commerce Platform

<div align="center">

![Ir Teguh Solution Logo](./logo.png)

**Created by [Ir Teguh Solution](https://github.com/irteguhsolution)**

A modern, full-featured e-commerce platform built with Laravel 11 and Tailwind CSS.

[![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=flat-square&logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat-square&logo=php)](https://www.php.net/)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?style=flat-square&logo=tailwind-css)](https://tailwindcss.com/)
[![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)](LICENSE)

</div>

---

## 📋 Table of Contents

- [About](#about)
- [Features](#features)
- [Project Structure](#project-structure)
- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [Technologies Used](#technologies-used)
- [Repository Structure](#repository-structure)
- [Contributing](#contributing)
- [License](#license)
- [Credits](#credits)

## 🎯 About

MyShop is a comprehensive e-commerce solution designed to provide a seamless shopping experience for both buyers and sellers. The platform features a modern, responsive design with intuitive navigation, secure payment processing, and robust seller management capabilities.

### Key Highlights

- 🛍️ **Complete E-Commerce Solution** - Full shopping cart, product catalog, and checkout system
- 👥 **User Authentication** - Secure login and registration system
- 🏪 **Seller Dashboard** - Comprehensive seller management tools
- 📱 **Responsive Design** - Mobile-first approach with Tailwind CSS
- 🔒 **Secure Payments** - Multiple payment gateway support
- 📄 **Comprehensive Policies** - Terms, privacy, shipping, and return policies

## ✨ Features

### For Buyers
- Browse products by category
- Advanced product search
- Product detail pages with images and descriptions
- Shopping cart functionality
- Wishlist feature
- Secure checkout process
- Order tracking
- Multiple payment methods (PayPal, Visa, Mastercard, Amex, Discover)

### For Sellers
- Seller account registration
- Product listing management
- Inventory management
- Order management
- Commission and fee tracking
- Sales analytics

### General Features
- Responsive mobile design
- Fast page loading
- SEO-friendly structure
- Social media integration
- Newsletter subscription
- Help center and FAQ
- Contact support system

## 📁 Project Structure

```
myshop/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── Dashboard.php
│   │       ├── PageController.php
│   │       ├── ProductController.php
│   │       └── login.php
│   ├── Models/
│   │   └── User.php
│   └── Providers/
│       └── AppServiceProvider.php
├── bootstrap/
│   └── app.php
├── config/
│   ├── app.php
│   ├── auth.php
│   ├── database.php
│   └── ...
├── database/
│   ├── migrations/
│   └── seeders/
├── public/
│   ├── assets/
│   │   └── images/
│   │       └── payments/
│   ├── index.php
│   └── ...
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   ├── app.blade.php
│   │   │   └── footer.blade.php
│   │   ├── pages/
│   │   │   ├── home.blade.php
│   │   │   ├── products.blade.php
│   │   │   ├── category.blade.php
│   │   │   └── product-detail.blade.php
│   │   └── footer/
│   │       ├── contact-us.blade.php
│   │       ├── about-us.blade.php
│   │       ├── faq.blade.php
│   │       └── ... (19 footer pages)
│   ├── css/
│   └── js/
├── routes/
│   └── web.php
├── storage/
├── tests/
├── .env.example
├── composer.json
├── package.json
├── tailwind.config.js
└── README.md
```

## 🔧 Requirements

- **PHP**: >= 8.2
- **Composer**: Latest version
- **Node.js**: >= 18.x
- **NPM**: Latest version
- **Database**: MySQL 5.7+ / PostgreSQL / SQLite
- **Web Server**: Apache / Nginx / Caddy

## 🚀 Installation

### 1. Clone the Repository

```bash
git clone https://github.com/yourusername/myshop.git
cd myshop
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### 3. Environment Configuration

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Configure Database

Edit `.env` file and set your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=myshop
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 5. Run Migrations

```bash
php artisan migrate
```

### 6. Build Assets

```bash
# Development
npm run dev

# Production
npm run build
```

### 7. Start Development Server

```bash
php artisan serve
```

Visit `http://localhost:8000` in your browser.

## ⚙️ Configuration

### Payment Method Logos

Place your payment method logo images in:
```
public/assets/images/payments/
```

Required files:
- `paypal.png`
- `visa.png`
- `mastercard.png`
- `amex.png`
- `discover.png`

### Logo

Place the project logo as `logo.png` in the root directory for the README display.

## 📖 Usage

### Accessing the Application

- **Home Page**: `http://localhost:8000/`
- **Products**: `http://localhost:8000/products`
- **Login**: `http://localhost:8000/login`

### Available Routes

#### Public Routes
- `/` - Home page
- `/products` - Product listing
- `/category/{category}` - Category products
- `/product/{id}` - Product details
- `/login` - Login page

#### Footer Pages
- `/contact-us` - Contact page
- `/about-us` - About page
- `/faq` - FAQ page
- `/blog` - Blog page
- `/how-it-works` - How it works
- `/help-center` - Help center
- `/terms-conditions` - Terms & Conditions
- `/privacy-policy` - Privacy Policy
- `/return-refund-policy` - Return & Refund Policy
- `/shipping-policy` - Shipping Policy
- `/payment-policy` - Payment Policy
- `/cookie-policy` - Cookie Policy
- `/buyer-protection-policy` - Buyer Protection Policy
- `/intellectual-property-policy` - Intellectual Property Policy
- `/sell-on-begja` - Sell on MyShop
- `/seller-agreement` - Seller Agreement
- `/fees-commission` - Fees & Commission
- `/listing-guidelines` - Listing Guidelines

## 🛠️ Technologies Used

### Backend
- **Laravel 11** - PHP Framework
- **PHP 8.2+** - Programming Language
- **MySQL/PostgreSQL/SQLite** - Database

### Frontend
- **Tailwind CSS 3.x** - Utility-first CSS framework
- **Alpine.js** - Lightweight JavaScript framework
- **jQuery** - JavaScript library
- **Blade Templates** - Laravel templating engine

### Development Tools
- **Composer** - PHP dependency manager
- **NPM** - Node package manager
- **Vite** - Build tool
- **Docker** - Containerization (optional)

## 📂 Repository Structure

### Main Directories

- **`app/`** - Application core (Controllers, Models, Providers)
- **`bootstrap/`** - Application bootstrap files
- **`config/`** - Configuration files
- **`database/`** - Migrations and seeders
- **`public/`** - Public assets and entry point
- **`resources/`** - Views, CSS, and JavaScript
- **`routes/`** - Application routes
- **`storage/`** - File storage
- **`tests/`** - Test files
- **`vendor/`** - Composer dependencies

### Key Files

- **`composer.json`** - PHP dependencies
- **`package.json`** - Node.js dependencies
- **`tailwind.config.js`** - Tailwind CSS configuration
- **`vite.config.js`** - Vite build configuration
- **`.env`** - Environment variables (not in repo)
- **`routes/web.php`** - Web routes definition

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📄 License

This project is open-sourced software licensed under the [MIT license](LICENSE).

## 👨‍💻 Credits

**Project Creator & Developer**

<div align="center">

### Ir Teguh Solution

![Ir Teguh Solution Logo](./logo.png)

**Website**: [Ir Teguh Solution](https://irteguhsolution.com)  
**GitHub**: [@irteguhsolution](https://github.com/irteguhsolution)

</div>

---

<div align="center">

Made with ❤️ by **Ir Teguh Solution**

[![GitHub](https://img.shields.io/badge/GitHub-100000?style=for-the-badge&logo=github&logoColor=white)](https://github.com/irteguhsolution)
[![Website](https://img.shields.io/badge/Website-000000?style=for-the-badge&logo=About.me&logoColor=white)](https://irteguhsolution.com)

</div>
