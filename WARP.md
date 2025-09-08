# WARP.md

This file provides guidance to WARP (warp.dev) when working with code in this repository.

## Project Overview

This is a **Test Taking System** built with Laravel 12 and Bootstrap 5. It's a comprehensive examination platform with separate admin and user interfaces, supporting role-based access control, timed tests, and detailed result tracking.

## Development Commands

### Initial Setup
```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies  
npm install

# Generate application key
php artisan key:generate

# Create and seed database
php artisan migrate --seed

# Start development server
php artisan serve
```

### Development Workflow
```bash
# Start all development services (recommended)
composer dev

# Or start services individually:
php artisan serve                    # Development server
php artisan queue:listen --tries=1   # Queue worker
php artisan pail --timeout=0        # Log viewer
npm run dev                          # Vite dev server
```

### Testing
```bash
# Run all tests
composer test
# OR
php artisan test

# Run specific test suites
php artisan test tests/Unit
php artisan test tests/Feature

# Run with coverage (if configured)
php artisan test --coverage
```

### Code Quality
```bash
# Format code with Laravel Pint
./vendor/bin/pint

# Clear application caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

### Database Operations
```bash
# Fresh migration with seeding
php artisan migrate:fresh --seed

# Create new migration
php artisan make:migration create_table_name

# Create new seeder
php artisan make:seeder TableNameSeeder
```

## Architecture Overview

### Core Structure
This is a **role-based testing system** with two main user types:
- **Admin**: Manages categories, questions, tests, and users
- **User**: Takes tests and views results

### Key Components

#### Authentication & Authorization
- Custom middleware: `AdminMiddleware` and `UserMiddleware`
- Role-based access control through User model (`isAdmin()`, `isUser()`)
- Routes are grouped by role with middleware protection

#### Database Schema
- **Categories**: Test subject categories
- **Questions**: Multiple-choice questions with 4 options (a,b,c,d)
- **Tests**: Test configurations with category-question mapping
- **TestResults**: Individual test attempts and answers
- **UserTestAttempts**: Tracks attempt counts per user/test
- **Users**: Authentication with role and active status

#### Controllers Architecture
```
Admin Controllers (CRUD operations):
├── AdminController - Dashboard and statistics
├── CategoryController - Category management + question import
├── QuestionController - Question management
├── TestController - Test configuration
└── UserController - User management

User Controllers:
├── DashboardController - Available tests listing
└── TestTakingController - Test execution, timing, results

Auth Controllers:
└── LoginController - Authentication
```

#### Models & Business Logic
- **Test Model**: Contains complex test availability logic (`isAvailable()`, `canUserTakeTest()`)
- **Question Model**: Has shuffled options functionality for randomization
- **User Model**: Role checking methods
- All models use proper relationships and casting

### Key Features Implementation

#### Test Randomization
- Questions are randomly selected from specified categories
- Question order is shuffled for each attempt
- Answer options are shuffled within each question
- Implementation in `Test::generateQuestions()` and `Question::getShuffledOptionsAttribute()`

#### Timing System
- JavaScript-based countdown timer
- AJAX auto-save of answers
- Automatic test completion when time expires
- Duration stored in minutes, converted to seconds for frontend

#### Attempt Limiting
- `UserTestAttempt` model tracks attempts per user/test combination
- `max_attempts` field in Test model
- Validation in `Test::canUserTakeTest()` method

#### Question Import
- `QuestionImportService` handles bulk question import
- Supports various file formats through PHPOffice/PHPWord
- Located in `app/Services/QuestionImportService.php`

## Test Credentials

The system seeds with default accounts:
- **Admin**: admin@test.uz / 12345678
- **User**: user@test.uz / 12345678

## Important Implementation Details

### Route Structure
- Admin routes: `/admin/*` with `auth,admin` middleware
- User routes: `/user/*` with `auth,user` middleware  
- Public routes: `/login` only (root redirects to login)

### Frontend Technology
- Bootstrap 5.1.3 for responsive design
- jQuery for AJAX functionality
- Font Awesome 6 for icons
- Custom JavaScript for timer and auto-save functionality

### Database Configuration
- Uses SQLite by default (`database/database.sqlite`)
- Configured for MySQL compatibility
- Migrations handle both SQLite and MySQL differences

### Security Features
- CSRF protection on all forms
- Role-based middleware protection
- Input validation in all controllers
- Bcrypt password hashing
- SQL injection protection through Eloquent ORM

## Recent Updates

### Questions Form Modernization (Latest)
The questions create and edit forms have been updated with modern design:
- **Modern Layout**: Using `layouts.admin` instead of old `layouts.app`
- **Enhanced UI**: Modern form cards with gradient headers and improved styling
- **Better UX**: Visual indicators for correct answers, auto-resize textareas
- **Form Validation**: Client-side validation with duplicate option checking
- **Interactive Elements**: Color-coded option badges (A=blue, B=info, C=warning, D=success)
- **Visual Feedback**: Correct answer highlighting with success borders and checkmark icons

### Form Features
- **Auto-resize textarea** for question text
- **Dynamic placeholders** that change based on selected category
- **Duplicate validation** prevents identical answer options
- **Visual correct answer indication** with green borders and checkmarks
- **Responsive design** that works on all screen sizes

## Development Notes

- The system uses Laravel 12's latest features and structure
- Vite is configured for asset compilation
- PHPUnit tests cover authentication, admin panel, and test-taking functionality
- Code follows PSR-4 autoloading standards
- Custom services are placed in `app/Services/` directory
- Modern CSS classes are defined in `public/css/admin-modern.css`
- Admin forms use modern design patterns with enhanced user experience
