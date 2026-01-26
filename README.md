# MyShop - E-Commerce Platform

<div align="center">

![Ir Teguh Solution Logo](https://postimg.cc/wyr9Sfk6)

**Created by [Ir Teguh Solution](https://github.com/synysmike)**

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
- [Authentication & User Management](#-authentication--user-management)
- [Usage](#usage)
- [Application Workflows](#-application-workflows)
- [Technical Implementation Details](#-technical-implementation-details)
- [Technologies Used](#️-technologies-used)
- [Repository Structure](#-repository-structure)
- [Important Notes](#-important-notes)
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

### 4. Configure Database and API

Edit `.env` file and set your database credentials and API base URL:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=myshop
DB_USERNAME=your_username
DB_PASSWORD=your_password

# API Configuration
API_BASE_URL=http://your-api-server.com:4340
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

### API Configuration

The application uses an external API for authentication and data management. Configure the API base URL in your `.env` file:

```env
API_BASE_URL=http://your-api-server.com:4340
```

**Important Notes:**
- The API base URL is used throughout the application for all API calls
- When deploying to production, simply update the `API_BASE_URL` value in your `.env` file
- All API endpoints are defined in `config/api.php` for easy maintenance
- Replace `your-api-server.com:4340` with your actual API server URL

**API Endpoints:**
- Authentication: `/api/v1/auth/login`, `/api/v1/auth/logout`
- Profile Settings: `/api/v1/settings/update-profile`, `/api/v1/settings/change-password`
- Shipping Address: `/api/v1/settings/shipping-address/*`
- World Data: `/api/v1/world/countries`, `/api/v1/world/states`, `/api/v1/world/cities`

For a complete list of endpoints, see `config/api.php`.

### Profile Management & Image Upload

The application includes a comprehensive profile management system with image upload capabilities.

#### Profile Features
- **Profile Settings**: Update name, email, phone number, tax ID, and privacy settings
- **Change Password**: Secure password change functionality
- **Shipping Address Management**: Full CRUD operations for shipping addresses
- **Profile Picture & Cover Image**: Upload and manage profile images

#### Image Upload Flow

1. **Client-Side Processing**:
   - User selects an image file (JPEG, PNG, GIF, WebP only)
   - File is validated (max 1MB, image type only)
   - Image is converted to base64 string (without data URL prefix)
   - Base64 string is stored in form data attribute

2. **Server-Side Processing**:
   - Base64 string is received from frontend
   - Base64 is validated (format, size, image type via magic bytes)
   - Clean base64 string (without prefix) is sent to API
   - API saves image to storage and returns storage path/URL

3. **Image Display**:
   - Storage path from API is saved in session
   - Path is converted to full URL with `/storage` prefix
   - Images are displayed from API storage: `{API_BASE_URL}/storage/{path}`

#### Image Storage Structure

Images are stored on the API server and accessed via:
- **Cover Images**: `{API_BASE_URL}/storage/cover_images/{filename}`
- **Profile Pictures**: `{API_BASE_URL}/storage/profile_pictures/{filename}`

**Important**: The API server must have:
- Symlink created: `php artisan storage:link` (creates `public/storage` → `storage/app/public`)
- Proper web server configuration to serve static files from `/storage/` path
- Correct file permissions (755 for directories, 644 for files)

#### Session Management

User data and authentication tokens are stored in Laravel sessions:
- **Authentication Token**: Stored as `sanctum_token` in session
- **User Data**: Stored as `user_data` in session (includes profile info, images paths)
- **Session Persistence**: Sessions are saved immediately after updates
- **Image Paths**: Storage paths from API are stored in session for display

#### Profile Update Workflow

1. User fills profile form and selects images
2. Frontend converts images to base64 and validates
3. Form data (including base64 images) is sent to backend via AJAX
4. Backend validates base64 images (type, size, format)
5. Backend sends clean base64 to API endpoint
6. API saves images and returns storage paths
7. Backend updates session with new data and image paths
8. Frontend displays success message and refreshes display

#### Shipping Address Management

The shipping address feature includes:
- **List Addresses**: Display all user shipping addresses
- **Add Address**: Create new shipping address with full validation
- **Edit Address**: Update existing address
- **Delete Address**: Remove address with confirmation
- **World Data Integration**: Dynamic country, state, and city dropdowns using Select2
- **Profile Data Integration**: Option to auto-fill name and phone from profile

**World Data Endpoints**:
- Countries: `GET /api/v1/world/countries`
- States: `POST /api/v1/world/states` (requires `country_id`)
- Cities: `POST /api/v1/world/cities` (requires `state_id`)

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

## 🔐 Authentication & User Management

### Login Flow

1. User enters email and password
2. Frontend sends credentials to API: `POST /api/v1/auth/login`
3. API returns token, user data, and profile data
4. Frontend stores token in Laravel session via `/api/store-token` endpoint
5. Session stores:
   - `sanctum_token`: Bearer token for API authentication
   - `user_data`: Merged user and profile data (including image paths)
6. User is redirected to homepage
7. Navbar displays user info and profile picture

### Registration Flow

1. User fills registration form (name, email, password, confirm password)
2. Frontend validates password match and strength
3. Registration data is sent to API: `POST /api/v1/auth/register`
4. API returns token and user data
5. Token and user data are stored in session
6. User is automatically logged in

### Logout Flow

1. User clicks logout button
2. Backend calls API logout endpoint: `POST /api/v1/auth/logout`
3. Session is cleared (`sanctum_token` and `user_data`)
4. User is redirected to login page

### Session Security

- Sessions are regenerated after login for security
- Session cookies are configured with proper security settings
- Guest middleware prevents logged-in users from accessing login/register pages
- Auth middleware protects authenticated routes

## 📖 Usage

### Accessing the Application

- **Home Page**: `http://localhost:8000/`
- **Products**: `http://localhost:8000/products`
- **Login**: `http://localhost:8000/login`
- **Profile**: `http://localhost:8000/profile` (requires authentication)

### Available Routes

#### Public Routes
- `/` - Home page
- `/products` - Product listing
- `/category/{category}` - Category products
- `/product/{id}` - Product details
- `/login` - Login page

#### Authenticated Routes
- `/profile` - User profile management (Profile Settings, Change Password, Shipping Addresses)
- `/api/store-token` - Store authentication token in session (POST)
- `/logout` - User logout (POST)

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
- **Alpine.js** - Lightweight JavaScript framework (for tabs, modals, dropdowns)
- **jQuery** - JavaScript library (for AJAX requests)
- **Blade Templates** - Laravel templating engine
- **Select2** - Enhanced dropdowns for country/state/city selection
- **SweetAlert2** - Modern alert and confirmation dialogs

### Development Tools
- **Composer** - PHP dependency manager
- **NPM** - Node package manager
- **Vite** - Build tool
- **Docker** - Containerization (optional)

## 📂 Repository Structure

### Main Directories

- **`app/`** - Application core (Controllers, Models, Providers)
  - **`Http/Controllers/`**:
    - `ProfileController.php` - Profile management, password change, shipping addresses
    - `login.php` - Authentication (login, logout, token storage)
    - `Dashboard.php` - Homepage controller
    - `ProductController.php` - Product listing and details
    - `PageController.php` - Static pages controller
- **`bootstrap/`** - Application bootstrap files
- **`config/`** - Configuration files
  - **`api.php`** - API configuration (base URL, endpoints)
- **`database/`** - Migrations and seeders
- **`public/`** - Public assets and entry point
- **`resources/views/`** - Blade templates
  - **`public/`**:
    - `login.blade.php` - Login/Register/Forgot Password page
    - `profile.blade.php` - Profile management page (tabs: Profile, Password, Shipping Addresses)
  - **`public/layouts/`**:
    - `app.blade.php` - Main layout with navbar (displays user profile picture)
- **`routes/`** - Application routes
- **`storage/`** - File storage (not used for user images - images stored on API server)
- **`tests/`** - Test files
- **`vendor/`** - Composer dependencies

### Key Files

- **`composer.json`** - PHP dependencies
- **`package.json`** - Node.js dependencies
- **`tailwind.config.js`** - Tailwind CSS configuration
- **`vite.config.js`** - Vite build configuration
- **`.env`** - Environment variables (not in repo, contains `API_BASE_URL`)
- **`config/api.php`** - API endpoints configuration
- **`routes/web.php`** - Web routes definition

## 🔄 Application Workflows

### Image Upload & Display Workflow

```
User selects image
    ↓
Frontend validates (type, size)
    ↓
Convert to base64 (remove data URL prefix)
    ↓
Send base64 to backend via AJAX
    ↓
Backend validates base64 (format, size, image type)
    ↓
Send clean base64 to API: POST /api/v1/settings/update-profile
    ↓
API saves image to storage/app/public/{folder}/
    ↓
API returns storage path (e.g., "cover_images/filename.png")
    ↓
Backend saves path to session
    ↓
Frontend displays: {API_BASE_URL}/storage/{path}
```

### Authentication Workflow

```
User login
    ↓
Frontend: POST /api/v1/auth/login
    ↓
API returns: { token, user, profile }
    ↓
Frontend: POST /api/store-token
    ↓
Backend stores in session:
    - sanctum_token
    - user_data (merged user + profile)
    ↓
If profile has images, download from API and save locally (for display)
    ↓
Session regenerated for security
    ↓
Redirect to homepage
    ↓
Navbar displays user info and profile picture
```

### Profile Update Workflow

```
User edits profile form
    ↓
If images selected:
    - Convert to base64
    - Validate (type, size)
    - Store in form data
    ↓
Submit form via AJAX
    ↓
Backend validates all data
    ↓
Send to API: POST /api/v1/settings/update-profile
    ↓
API processes and saves images
    ↓
API returns updated profile data (with image paths)
    ↓
Backend updates session with new data
    ↓
Frontend shows success message (SweetAlert2)
    ↓
Display refreshes with new data
```

### Shipping Address Workflow

```
User navigates to Shipping Address tab
    ↓
Frontend: GET /profile/shipping-address
    ↓
Backend: POST /api/v1/settings/shipping-address (to API)
    ↓
API returns list of addresses
    ↓
Frontend displays addresses with Edit/Delete buttons
    ↓
For Add/Edit:
    - Load countries (GET /api/v1/world/countries)
    - User selects country → Load states (POST /api/v1/world/states)
    - User selects state → Load cities (POST /api/v1/world/cities)
    - All using Select2 for better UX
    ↓
Submit form → Backend → API
    ↓
API saves/updates address
    ↓
Frontend refreshes list
```

## 🔧 Technical Implementation Details

### Image Handling

- **File Validation**: Only JPEG, PNG, GIF, WebP allowed
- **Size Limit**: Maximum 1MB per image
- **Base64 Encoding**: Images converted to base64 without data URL prefix
- **Storage**: Images stored on API server, not in local Laravel storage
- **Display**: Images accessed via `{API_BASE_URL}/storage/{path}`

### API Integration

- **Configuration**: All API URLs configured in `config/api.php`
- **Base URL**: Set via `API_BASE_URL` in `.env` file
- **Authentication**: Bearer token in `Authorization` header
- **Request Format**: JSON for all API requests
- **Response Handling**: JSON responses parsed and handled appropriately

### Session Management

- **Storage**: Database sessions (configurable in `config/session.php`)
- **Lifetime**: 120 minutes (configurable)
- **Security**: Session regeneration after login
- **Data Structure**:
  ```php
  session([
      'sanctum_token' => 'bearer_token_string',
      'user_data' => [
          'name' => 'User Name',
          'email' => 'user@example.com',
          'profile_picture' => 'profile_pictures/filename.png',
          'cover_image' => 'cover_images/filename.png',
          // ... other profile data
      ]
  ])
  ```

### Frontend Libraries

- **Alpine.js**: Used for tab navigation, modals, dropdowns
- **jQuery**: Used for AJAX requests and DOM manipulation
- **Select2**: Enhanced dropdowns for country/state/city selection
- **SweetAlert2**: Modern alert dialogs (replaces native `alert()` and `confirm()`)
- **FileReader API**: Client-side image to base64 conversion

## 🚨 Important Notes

### Security Considerations

- **Environment Variables**: Never commit `.env` file to repository
- **API Tokens**: Stored securely in server-side sessions, not in localStorage
- **Image Validation**: Both client-side and server-side validation
- **CSRF Protection**: All forms include CSRF tokens
- **Session Security**: Sessions regenerated after authentication

### API Server Requirements

The API server must be properly configured:
1. **Storage Symlink**: Run `php artisan storage:link` on API server
2. **Web Server Config**: Configure Nginx/Apache to serve files from `/storage/` path
3. **File Permissions**: Ensure proper permissions (755 for directories, 644 for files)
4. **CORS**: Configure CORS if accessing from different domain

### Development vs Production

- **Development**: Use development API URL in `.env`
- **Production**: Update `API_BASE_URL` in `.env` to production API URL
- **No Code Changes**: All API URLs are configured via `.env`, no code changes needed



## 📄 License

This project is open-sourced software licensed under the [MIT license](LICENSE).

## 👨‍💻 Credits

**Project Creator & Developer**

<div align="center">

### Ir Teguh Solution

![Ir Teguh Solution Logo](https://postimg.cc/wyr9Sfk6)

**Website**: [Ir Teguh Solution](https://irteguhsolution.com)  
**GitHub**: [@irteguhsolution](https://github.com/synysmike)

</div>

---

<div align="center">

Made with ❤️ by **Ir Teguh Solution**

[![GitHub](https://img.shields.io/badge/GitHub-100000?style=for-the-badge&logo=github&logoColor=white)](https://github.com/irteguhsolution)
[![Website](https://img.shields.io/badge/Website-000000?style=for-the-badge&logo=About.me&logoColor=white)](https://irteguhsolution.com)

</div>
