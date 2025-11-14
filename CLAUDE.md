# CLAUDE.md - AI Assistant Guide for QuizApp

## Project Overview

**QuizApp** is a Laravel 10 quiz application built on the TALL stack (Tailwind, Alpine.js, Laravel, Livewire) with FilamentPHP 3 providing a dual-panel admin interface. The application was developed as a learning project to understand web application security principles including identification, authentication, authorization, audit trails, and session management.

**Primary Purpose**: Educational quiz platform with role-based access, allowing admins to manage quiz content and users to take quizzes, track progress, and earn certifications.

**License**: MIT

---

## Technology Stack

### Backend
- **Framework**: Laravel 10.10 (PHP 8.1+)
- **Database**: MySQL 8.0
- **Admin Panel**: FilamentPHP 3.0
- **Authentication**: Laravel Sanctum + Filament Breezy (2FA support)
- **Authorization**: Spatie Laravel Permission + Filament Shield
- **Media**: Spatie Laravel Media Library
- **Development Environment**: Laravel Sail (Docker)

### Frontend
- **Stack**: TALL (Tailwind, Alpine.js, Laravel, Livewire)
- **CSS Framework**: TailwindCSS 3.3.3
- **Build Tool**: Vite 4.0
- **Reactive Components**: Livewire (no separate JavaScript framework)

### Key Packages
- `filament/filament` - Admin panel framework
- `bezhansalleh/filament-shield` - Role/permission management
- `jeffgreco13/filament-breezy` - Authentication & 2FA
- `spatie/laravel-permission` - Roles and permissions
- `flowframe/laravel-trend` - Charting/trending data
- `pxlrbt/filament-excel` - Excel export functionality

---

## Architecture

### Dual Panel System

The application has **two separate Filament panels**:

1. **Admin Panel** (`/admin`)
   - Accessed by users with `super_admin` role
   - Full CRUD operations on all resources
   - User management
   - Quiz content management
   - Role and permission management

2. **Member Panel** (`/member`)
   - Accessed by users with `user` or `super_admin` role
   - Quiz taking interface
   - Subscription management
   - Quiz history and results
   - Profile management

**Access Control**: `/home/user/quizapp/app/Models/User.php:110-126`
```php
public function canAccessPanel(Panel $panel): bool {
    return match($panel->getId()) {
        'admin' => (auth()->user()->hasRole(['super_admin']) &&
                    auth()->user()->is_active),
        'member' => (auth()->user()->hasAnyRole(['super_admin|user']) &&
                     auth()->user()->is_active),
    };
}
```

### Application Layers

1. **Presentation Layer**: Livewire components + Blade views
2. **Business Logic**: Laravel Models, Policies, Observers
3. **Data Access**: Eloquent ORM
4. **Authorization**: Spatie Permission + Filament Shield

---

## Directory Structure

### Core Application Directories

```
/app
├── /Filament
│   ├── /Resources          # Filament admin CRUD resources
│   │   ├── SectionResource.php
│   │   ├── CertificationResource.php
│   │   ├── DomainResource.php
│   │   ├── QuestionResource.php
│   │   ├── AnswerResource.php
│   │   ├── QuizResource.php
│   │   ├── QuizHeaderResource.php
│   │   ├── UserResource.php
│   │   └── QuoteResource.php
│   ├── /Pages              # Custom Filament pages
│   └── /Widgets            # Dashboard widgets
├── /Http
│   ├── /Controllers        # Traditional Laravel controllers
│   ├── /Middleware         # HTTP middleware
│   └── Kernel.php
├── /Livewire               # Livewire components
│   ├── UserQuiz.php        # Main quiz-taking component
│   ├── RandomQuoteWidget.php
│   └── QuizDetailPage.php
├── /Models                 # Eloquent models
│   ├── User.php
│   ├── Quiz.php
│   ├── QuizHeader.php
│   ├── Question.php
│   ├── Answer.php
│   ├── Certification.php
│   ├── Section.php
│   └── Domain.php
├── /Policies               # Authorization policies
├── /Observers              # Model observers
│   ├── UserObserver.php
│   ├── CertificationObserver.php
│   └── SectionObserver.php
└── /Providers              # Service providers
    ├── /Filament
    │   ├── AdminPanelProvider.php
    │   └── MemberPanelProvider.php
    └── AppServiceProvider.php

/database
├── /migrations             # Database migrations
├── /seeders                # Database seeders
└── /factories              # Model factories

/resources
├── /views                  # Blade templates
│   ├── /components         # Blade components
│   └── /livewire           # Livewire views
├── /css                    # CSS files
│   └── /filament
│       └── /member         # Member panel theme
└── /js                     # JavaScript files

/routes
├── web.php                 # Web routes (minimal, Filament handles most)
├── api.php                 # API routes
└── console.php             # Console commands

/tests
├── /Feature                # Feature tests
└── /Unit                   # Unit tests

/config                     # Configuration files
/storage                    # Application storage
/public                     # Public assets
```

---

## Database Schema

### Core Models and Relationships

**Hierarchy**: Section → Certification → Domain → Question → Answer

#### Primary Tables

**users** - User accounts with role-based access
- Fields: id, name, email, password, is_admin, is_active, email_verified_at
- Relationships: HasMany → quizzes, quiz_headers; BelongsToMany → sections, certifications

**sections** - Top-level categorization (e.g., "IT Certifications")
- Fields: id, name, description, is_active, details, user_id
- Relationships: HasMany → certifications; BelongsToMany → users (subscriptions)

**certifications** - Certification programs (e.g., "AWS Solutions Architect")
- Fields: id, name, description, is_active, details, user_id, section_id
- Relationships: BelongsTo → section; HasMany → domains; BelongsToMany → users

**domains** - Topics within certifications (e.g., "Storage Services")
- Fields: id, name, description, is_active, details, user_id, certification_id
- Relationships: BelongsTo → certification; HasMany → questions

**questions** - Quiz questions with media support
- Fields: id, question (text), explanation (text), is_active, level (1=Easy, 2=Medium, 3=Hard), user_id, domain_id
- Relationships: BelongsTo → domain; HasMany → answers
- Media: Images via Spatie Media Library

**answers** - Multiple choice answers
- Fields: id, answer, is_checked (boolean - marks correct answer), question_id
- Relationships: BelongsTo → question

**quiz_headers** - Quiz session metadata
- Fields: id, user_id, section_id, certification_id, domains (serialized array), difficulty (serialized array), learningmode, completed, quiz_size, questions_taken (serialized array), score
- Relationships: BelongsTo → user, section, certification; HasMany → quizzes

**quizzes** - Individual question attempts
- Fields: id, user_id, quiz_header_id, section_id, certification_id, domain_id, question_id, answer_id, is_correct
- Relationships: BelongsTo → user, quiz_header, question, answer, domain

**quotes** - Motivational quotes
- Fields: id, quote, author, is_active

#### Supporting Tables
- `section_user` - User subscriptions to sections
- `certification_user` - User subscriptions to certifications
- `sessions` - Database sessions
- `notifications` - Database notifications
- `media` - Spatie media library
- `personal_access_tokens` - Sanctum API tokens
- Spatie permission tables (roles, permissions, model_has_roles, etc.)

---

## Key Concepts and Patterns

### 1. Filament Resource Pattern

All CRUD operations use Filament Resources. Each resource defines:
- Form schema (create/edit forms)
- Table schema (list view)
- Relation managers (nested resources)
- Navigation configuration
- Policies (authorization)

**Example**: `/home/user/quizapp/app/Filament/Resources/SectionResource.php`

### 2. Quiz-Taking Flow

The core quiz functionality is in `/home/user/quizapp/app/Livewire/UserQuiz.php:1-249`

**Flow**:
1. User selects certification, domains, difficulty, quiz size, and learning mode
2. System creates `QuizHeader` record (quiz session)
3. For each question:
   - Query random question matching criteria
   - Exclude already-answered questions from this session
   - Present question with answers
   - Record user's answer in `Quiz` table
   - In learning mode, show explanation immediately
4. Calculate final score and mark `QuizHeader` as completed
5. Redirect to quiz detail page for review

### 3. Observer Pattern

Model observers handle lifecycle events:
- **UserObserver**: Auto-assign roles, send notifications
- **CertificationObserver**: Cascade operations
- **SectionObserver**: Business logic on section changes

Registered in: `/home/user/quizapp/app/Providers/AppServiceProvider.php`

### 4. Policy-Based Authorization

Every major model has a policy:
- Policies determine who can view/create/update/delete records
- Integrated with Filament Shield for UI-level permissions
- Example: `/home/user/quizapp/app/Policies/QuestionPolicy.php`

### 5. Subscription Pattern

Users subscribe to sections and certifications via many-to-many relationships:
- Only subscribed certifications appear in quiz selection
- Managed via Filament relation managers
- Pivot tables: `section_user`, `certification_user`

### 6. Media Handling

Questions, sections, certifications, and domains can have images:
- Uses Spatie Media Library
- Images stored in collections
- Preview conversions for thumbnails
- Access via `$model->getFirstMediaUrl('collection')`

---

## Development Workflow

### Initial Setup

```bash
# Clone and setup
git clone <repo>
cd quizapp
alias sail=./vendor/bin/sail

# Environment configuration
cp .env.example .env

# Install dependencies
composer install
sail up -d
sail npm install

# Build assets
sail npm run build

# Database setup
sail artisan migrate:fresh
sail artisan make:filament-user  # Create admin user
sail artisan db:seed

# Configure roles and permissions
sail artisan shield:super-admin  # Select admin user
sail artisan db:seed --class=ShieldSeeder

# Development server (keep running)
sail npm run dev
```

### Daily Development

```bash
# Start Docker containers
sail up -d

# Start Vite dev server (for hot reload)
sail npm run dev

# Access application
# Admin: http://localhost/admin
# Member: http://localhost/member
```

### Common Artisan Commands

```bash
# Database
sail artisan migrate                 # Run migrations
sail artisan migrate:fresh --seed    # Fresh migration with seeding
sail artisan db:seed                 # Run seeders

# Filament
sail artisan make:filament-resource ModelName  # Create new resource
sail artisan make:filament-page PageName       # Create new page
sail artisan make:filament-widget WidgetName   # Create new widget
sail artisan make:filament-user                # Create Filament user

# Shield (Permissions)
sail artisan shield:generate         # Generate permissions for resources
sail artisan shield:super-admin      # Assign super admin role

# Cache
sail artisan optimize                # Optimize the framework
sail artisan optimize:clear          # Clear all caches
sail artisan route:cache             # Cache routes
sail artisan config:cache            # Cache configuration

# Code Quality
sail artisan pint                    # Fix code style issues

# Tinker (REPL)
sail artisan tinker                  # Interactive shell
```

### Asset Building

```bash
# Development (with HMR)
sail npm run dev

# Production build
sail npm run build
```

---

## Common Development Tasks

### Adding a New Resource

1. **Create the Filament Resource**:
   ```bash
   sail artisan make:filament-resource ModelName --generate
   ```

2. **Configure the Resource**:
   - Edit form schema in `form()` method
   - Edit table schema in `table()` method
   - Add navigation icon and group
   - Configure policies

3. **Generate Permissions**:
   ```bash
   sail artisan shield:generate
   ```

4. **Test in both panels** (if applicable)

### Adding a New Question

1. Navigate to Admin Panel → Domains
2. Select a domain
3. Click "Questions" relation manager tab
4. Create new question
5. Set difficulty level (1=Easy, 2=Medium, 3=Hard)
6. Add explanation (shown in learning mode)
7. Optionally attach image
8. Add at least 2 answers, mark correct one with "Is Checked"

### Modifying Quiz Logic

The main quiz component is: `/home/user/quizapp/app/Livewire/UserQuiz.php`

Key methods:
- `mount()` - Component initialization
- `create()` - Quiz configuration form submission
- `nextQuestion()` - Load next question
- `submitAnswer()` - Process answer submission
- `calculateScore()` - Calculate final score

### Customizing Panel Themes

**Admin Panel Theme**: Default Filament theme with custom primary color (#002C6A)

**Member Panel Theme**: `/home/user/quizapp/resources/css/filament/member/theme.css`
- Vite entry point configured in `vite.config.js`
- Custom colors defined in panel provider

To modify:
1. Edit `/home/user/quizapp/resources/css/filament/member/theme.css`
2. Update panel provider if changing colors
3. Rebuild assets: `sail npm run build`

---

## Testing

### Test Structure

```
/tests
├── /Feature      # Feature tests (HTTP, database)
└── /Unit         # Unit tests (isolated logic)
```

### Running Tests

```bash
# Run all tests
sail artisan test
# or
sail test

# Run specific test file
sail artisan test --filter=ExampleTest

# Run with coverage
sail artisan test --coverage
```

### Test Configuration

- Environment: `testing` (configured in `phpunit.xml`)
- Database: Separate testing database
- Sessions: Array driver (no persistence)
- Cache: Array driver (no persistence)
- Queue: Sync (immediate execution)

### Writing Tests

Example feature test:
```php
use Tests\TestCase;

class QuizTest extends TestCase
{
    public function test_user_can_take_quiz()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/member/quiz')
            ->assertStatus(200);
    }
}
```

---

## Security Considerations

This application was built with security as a primary focus. Key security features:

### Authentication
- Session-based authentication (database driver)
- CSRF protection enabled
- Email verification required
- Optional Two-Factor Authentication (2FA via Filament Breezy)
- Password hashing (bcrypt)
- Remember me functionality
- Last login tracking

### Authorization
- Role-based access control (RBAC) via Spatie Permission
- Policy-based authorization on all models
- Panel-level access control (`canAccessPanel()` method)
- Resource-level permissions via Filament Shield
- Fine-grained permission checks (view, create, update, delete, etc.)

### Data Protection
- Input validation via Filament form schemas
- SQL injection protection (Eloquent ORM)
- XSS protection (Blade escaping)
- File upload validation
- Encrypted session data
- API authentication via Sanctum tokens

### Best Practices
- All user inputs validated
- Sensitive operations require authentication
- Active status checks (`is_active` field)
- Admin actions logged via model observers
- Database transactions for critical operations

**Important**: When modifying security-related code:
- Always validate user input
- Check authorization before operations
- Test with different role levels
- Review policy changes carefully
- Never bypass authentication/authorization

---

## Code Conventions

### PHP Code Style

The project uses **Laravel Pint** for code style enforcement:

```bash
sail artisan pint          # Fix code style
sail artisan pint --test   # Check without fixing
```

**Standards**:
- PSR-12 code style
- StudlyCase for class names
- camelCase for method names
- snake_case for variables (Laravel convention)

### Database Conventions

- Table names: plural snake_case (e.g., `quiz_headers`)
- Model names: singular StudlyCase (e.g., `QuizHeader`)
- Foreign keys: `{model}_id` (e.g., `user_id`)
- Pivot tables: alphabetically ordered (e.g., `certification_user`)
- Timestamps: `created_at`, `updated_at` on all tables
- Soft deletes: Not used (cascade deletes instead)
- Status fields: `is_active` (boolean)

### Naming Conventions

**Models**: Singular, StudlyCase (e.g., `QuizHeader`)
**Controllers**: Singular + "Controller" (e.g., `QuizController`)
**Resources**: Singular + "Resource" (e.g., `SectionResource`)
**Policies**: Singular + "Policy" (e.g., `QuizPolicy`)
**Observers**: Singular + "Observer" (e.g., `UserObserver`)
**Migrations**: Descriptive with timestamp prefix
**Livewire Components**: StudlyCase (e.g., `UserQuiz`)

### Blade/View Conventions

- Views: kebab-case (e.g., `quiz-detail.blade.php`)
- Components: kebab-case in usage (e.g., `<x-button />`)
- Sections: lowercase (e.g., `@section('content')`)

---

## Important Files Reference

### Configuration
- `/home/user/quizapp/.env.example` - Environment variables template
- `/home/user/quizapp/config/filament.php` - Filament configuration
- `/home/user/quizapp/config/filament-shield.php` - Shield configuration
- `/home/user/quizapp/config/permission.php` - Spatie permission configuration

### Panel Providers
- `/home/user/quizapp/app/Providers/Filament/AdminPanelProvider.php` - Admin panel setup
- `/home/user/quizapp/app/Providers/Filament/MemberPanelProvider.php` - Member panel setup

### Core Models
- `/home/user/quizapp/app/Models/User.php` - User model with panel access logic
- `/home/user/quizapp/app/Models/QuizHeader.php` - Quiz session model
- `/home/user/quizapp/app/Models/Quiz.php` - Individual answer records
- `/home/user/quizapp/app/Models/Question.php` - Question model with media

### Core Livewire Components
- `/home/user/quizapp/app/Livewire/UserQuiz.php` - Main quiz-taking component (249 lines)
- `/home/user/quizapp/app/Livewire/RandomQuoteWidget.php` - Quote widget
- `/home/user/quizapp/app/Livewire/QuizDetailPage.php` - Quiz results page

### Routes
- `/home/user/quizapp/routes/web.php` - Web routes
- `/home/user/quizapp/routes/api.php` - API routes

### Build Configuration
- `/home/user/quizapp/vite.config.js` - Vite bundler config
- `/home/user/quizapp/tailwind.config.js` - Tailwind CSS config
- `/home/user/quizapp/composer.json` - PHP dependencies
- `/home/user/quizapp/package.json` - Node dependencies

---

## Common Pitfalls and Gotchas

### 1. Admin User Setup

After creating a user with `sail artisan make:filament-user`:
- The user needs the `super_admin` role assigned via `sail artisan shield:super-admin`
- The user must have `is_active = true` to access any panel
- Edit the user in admin panel to enable panel switching via `is_admin` field

### 2. Quiz Subscriptions

Users must subscribe to certifications before they appear in quiz selection:
- Navigate to Member Panel → Subscriptions
- Subscribe to desired certifications
- Only subscribed certifications show in quiz dropdown

### 3. Question Requirements

Questions must have:
- At least 2 answers
- Exactly one answer marked as correct (`is_checked = true`)
- A valid domain assignment
- `is_active = true` to appear in quizzes

### 4. Asset Building

When modifying CSS/JS:
- Run `sail npm run dev` for development (HMR)
- Keep the dev server running while developing
- Run `sail npm run build` for production
- Clear browser cache if changes don't appear

### 5. Permission Sync

After adding new Filament resources:
```bash
sail artisan shield:generate  # Generate new permissions
```
Then assign permissions to roles in Admin Panel → Roles

### 6. Database Sessions

Sessions are stored in database:
- Requires `sessions` table migration
- Session lifetime configured in `config/session.php`
- Clear sessions: `sail artisan session:table` then truncate table

### 7. Media Library

File uploads require:
- Storage link: `sail artisan storage:link`
- Proper permissions on `storage/app/public`
- Media library migrations run
- Collection names match in code

### 8. Two-Factor Authentication

2FA is optional by default:
- Configured in panel providers (`'force' => false`)
- Users enable it from profile menu
- QR code requires HTTPS in production

### 9. Quiz Data Structure

- `quiz_headers.domains` and `quiz_headers.difficulty` are **serialized arrays**
- `quiz_headers.questions_taken` tracks answered question IDs
- Always query fresh questions not in `questions_taken` array

### 10. Panel Access

Panel access is controlled by `User::canAccessPanel()`:
- Both role check AND `is_active` check required
- Changing logic here affects all authentication
- Location: `/home/user/quizapp/app/Models/User.php:110-126`

---

## API Endpoints

### API Authentication

Uses Laravel Sanctum for token-based authentication:
- Tokens stored in `personal_access_tokens` table
- Middleware: `auth:sanctum`

### Available Endpoints

**Web Routes** (`routes/web.php`):
```
GET / → Welcome page
```

**API Routes** (`routes/api.php`):
```
GET /api/user [auth:sanctum] → Returns authenticated user
```

**Filament Panel Routes** (Auto-generated):
- Admin: `/admin/*`
- Member: `/member/*`

All Filament CRUD operations are handled via Livewire, not traditional REST APIs.

---

## Docker Services

Configured in `/home/user/quizapp/docker-compose.yml`:

### Services

1. **laravel.test** (Application)
   - Image: sail-8.2/app
   - Ports: 80 (APP_PORT), 5173 (Vite)
   - Volumes: Application code
   - Depends on: mysql, mailpit

2. **mysql**
   - Image: mysql/mysql-server:8.0
   - Port: 3306 (FORWARD_DB_PORT)
   - Volume: sail-mysql (persistent)
   - Health checks enabled

3. **mailpit** (Mail testing)
   - Image: axllent/mailpit:latest
   - Port: 1025 (SMTP), 8025 (Web UI)
   - Access mail UI: http://localhost:8025

### Docker Commands

```bash
# Start services
sail up -d

# Stop services
sail down

# View logs
sail logs -f

# Access application container
sail shell

# Access MySQL
sail mysql

# Execute artisan command
sail artisan {command}

# Execute composer
sail composer {command}

# Execute npm
sail npm {command}
```

---

## Environment Variables

Key environment variables (from `.env.example`):

### Application
```
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:...          # Generate: php artisan key:generate
APP_DEBUG=true
APP_URL=http://localhost
```

### Database
```
DB_CONNECTION=mysql
DB_HOST=mysql               # Docker service name
DB_PORT=3306
DB_DATABASE=quizapp
DB_USERNAME=sail
DB_PASSWORD=password
```

### Session & Cache
```
SESSION_DRIVER=database     # Security best practice
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
```

### Mail (Development)
```
MAIL_MAILER=smtp
MAIL_HOST=mailpit           # Docker service
MAIL_PORT=1025
```

### Filesystem
```
FILESYSTEM_DISK=local
```

---

## Troubleshooting

### Common Issues

**Issue**: Cannot access admin/member panel
- **Solution**: Check user has correct role (`super_admin` or `user`) and `is_active = true`

**Issue**: Quiz doesn't show any certifications
- **Solution**: User must subscribe to certifications via Member Panel → Subscriptions

**Issue**: Questions don't appear in quiz
- **Solution**: Check questions have `is_active = true`, at least 2 answers, and correct domain assignment

**Issue**: CSS/JS changes not reflecting
- **Solution**: Ensure `sail npm run dev` is running, clear browser cache, rebuild assets

**Issue**: Permission denied errors in Filament
- **Solution**: Run `sail artisan shield:generate` and assign permissions to roles

**Issue**: File uploads failing
- **Solution**: Run `sail artisan storage:link` and check storage permissions

**Issue**: Database connection errors
- **Solution**: Ensure MySQL container is running (`sail up -d`), check `.env` DB credentials

**Issue**: Vite not building assets
- **Solution**: Check `vite.config.js` input paths, ensure `sail npm install` completed successfully

---

## Additional Resources

### Documentation Links
- [Laravel 10 Documentation](https://laravel.com/docs/10.x)
- [FilamentPHP 3 Documentation](https://filamentphp.com/docs/3.x)
- [Livewire 3 Documentation](https://livewire.laravel.com/docs/3.x)
- [TailwindCSS Documentation](https://tailwindcss.com/docs)
- [Laravel Sail Documentation](https://laravel.com/docs/10.x/sail)
- [Spatie Permission Documentation](https://spatie.be/docs/laravel-permission)
- [Filament Shield Documentation](https://github.com/bezhanSalleh/filament-shield)

### Project-Specific Documentation
- `/home/user/quizapp/README.md` - Setup instructions and screenshots

---

## Quick Reference

### File Locations Cheat Sheet

```
Models:                    /home/user/quizapp/app/Models/
Filament Resources:        /home/user/quizapp/app/Filament/Resources/
Livewire Components:       /home/user/quizapp/app/Livewire/
Policies:                  /home/user/quizapp/app/Policies/
Observers:                 /home/user/quizapp/app/Observers/
Migrations:                /home/user/quizapp/database/migrations/
Seeders:                   /home/user/quizapp/database/seeders/
Views:                     /home/user/quizapp/resources/views/
Panel Providers:           /home/user/quizapp/app/Providers/Filament/
Routes:                    /home/user/quizapp/routes/
Configuration:             /home/user/quizapp/config/
Tests:                     /home/user/quizapp/tests/
```

### Command Cheat Sheet

```bash
# Development
sail up -d                              # Start Docker
sail npm run dev                        # Start Vite dev server
sail artisan serve                      # Not needed with Sail

# Database
sail artisan migrate                    # Run migrations
sail artisan migrate:fresh --seed       # Fresh DB with seed data
sail artisan db:seed                    # Seed only

# Filament
sail artisan make:filament-resource X   # Create resource
sail artisan make:filament-user         # Create admin user
sail artisan shield:generate            # Generate permissions
sail artisan shield:super-admin         # Assign super admin

# Cache
sail artisan optimize:clear             # Clear all caches
sail artisan config:cache               # Cache config

# Code Quality
sail artisan pint                       # Fix code style

# Testing
sail artisan test                       # Run tests

# Assets
sail npm run build                      # Build for production
```

---

## Notes for AI Assistants

### When Working with This Codebase

1. **Respect the Dual Panel Architecture**: Always consider which panel (Admin vs Member) changes affect

2. **Use Filament Patterns**: Don't create traditional controllers for CRUD - use Filament Resources

3. **Follow Security Best Practices**: This is a security-focused project - always validate, authorize, and sanitize

4. **Maintain Database Relationships**: The hierarchy (Section → Certification → Domain → Question → Answer) is critical

5. **Test Role-Based Access**: Changes should be tested with different user roles

6. **Use Observers for Side Effects**: Don't put business logic in controllers - use Model Observers

7. **Leverage Livewire**: For reactive UI, use Livewire instead of Vue/React

8. **Generate Permissions**: After adding resources, always run `shield:generate`

9. **Update Both Panels**: If adding features, consider if they apply to both Admin and Member panels

10. **Follow Laravel Conventions**: This project uses standard Laravel patterns - don't deviate without reason

### Code Modification Guidelines

- **Adding Features**: Use Filament resources, not traditional CRUD
- **Authentication Changes**: Modify panel providers and User model carefully
- **Quiz Logic**: Main component is UserQuiz.php - all quiz logic should go there
- **Database Changes**: Create migrations, don't modify existing ones
- **UI Changes**: Use Filament form/table builders, not raw HTML
- **Authorization**: Always use policies and permissions, never hardcode
- **File Uploads**: Use Spatie Media Library, not direct file handling
- **Validation**: Use Filament form validation, not request classes

---

**Last Updated**: 2025-11-14
**Application Version**: Laravel 10.10 | FilamentPHP 3.0
**Generated by**: Claude AI Assistant
