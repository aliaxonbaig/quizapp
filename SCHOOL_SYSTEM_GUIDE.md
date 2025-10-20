# School Quiz System - Implementation Guide

## 🎓 Overview
This quiz application has been transformed into a school-focused system where:
- **Teachers (Admins)** manage majors, semesters, and approve student-created quizzes
- **Students (Users)** can take quizzes, create private quizzes, and submit them for approval

## 🎨 Branding Colors
- **Primary (Green)**: `#007241` - Main school color
- **Secondary (Yellow)**: `#f9c432` - Accent color

## 📚 Terminology Changes
| Old Term | New Term | Description |
|----------|----------|-------------|
| Certification | Major | Student's field of study |
| Section | Semester | Time period grouping |
| User | Student | Student account |
| Admin | Teacher | Teacher/Administrator account |

## ✨ New Features Implemented

### 1. Database Schema Changes
✅ **Quiz Visibility & Ownership**
- `is_private` - Quiz is private to the student
- `is_student_created` - Quiz was created by a student
- `is_approved` - Quiz has been approved by a teacher
- `approved_at` - Timestamp of approval
- `approved_by` - Teacher who approved it

✅ **Quiz Approval System**
New table: `quiz_approval_requests`
- Tracks student requests to make quizzes public
- Stores approval/rejection status
- Records teacher review messages

### 2. Models Updated
✅ **QuizHeader Model**
- Added visibility and approval fields
- New relationships: `approvalRequests()`, `approver()`

✅ **QuizApprovalRequest Model** (NEW)
- Manages approval workflow
- Relationships: `quizHeader()`, `user()`, `reviewer()`

### 3. Color Scheme
✅ Updated `tailwind.config.js` with school colors
- Primary palette (green shades)
- Secondary palette (yellow shades)

## 🚀 Next Steps - What You Need to Do

### Step 1: Update Role Names (Optional but Recommended)
The system currently uses:
- `super_admin` → Should be `teacher`
- `user` → Should be `student`

Run this script to update roles:

```php
<?php
// update_roles.php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\\Contracts\\Console\\Kernel')->bootstrap();

use Spatie\\Permission\\Models\\Role;

// Rename super_admin to teacher
$superAdmin = Role::where('name', 'super_admin')->first();
if ($superAdmin) {
    $superAdmin->update(['name' => 'teacher']);
    echo "✅ Renamed super_admin to teacher\\n";
}

// Ensure student role exists
$student = Role::firstOrCreate(['name' => 'student', 'guard_name' => 'web']);
echo "✅ Student role ready\\n";
```

### Step 2: Update User Model Access Control
Edit `app/Models/User.php` and update the `canAccessPanel` method:

```php
public function canAccessPanel(Panel $panel): bool
{
    $panelGetId = $panel->getId();

    return match($panelGetId) {
        'admin' => (auth()->user()->hasRole(['teacher']) &&
                    auth()->user()->is_active
                ),
        'member' => (auth()->user()->hasAnyRole(['teacher|student']) &&
                     auth()->user()->is_active
                    ),
    };
}
```

### Step 3: Create Filament Resources for New Features

#### A. Quiz Approval Resource (for Teachers)
Create: `app/Filament/Resources/QuizApprovalRequestResource.php`

```bash
php artisan make:filament-resource QuizApprovalRequest --generate
```

This will allow teachers to:
- View pending approval requests
- Approve/reject student quizzes
- Add review messages

#### B. Update Quiz Resources
Modify existing quiz resources to:
- Show privacy toggle for students
- Add "Request Publication" button for private student quizzes
- Filter quizzes by type (teacher-made, student-made public, my private)

### Step 4: Update Seeders
Edit `database/seeders/DatabaseSeeder.php` to use new terminology:

```php
// Rename sections to semesters
$this->call(SemestersTableSeeder::class);

// Rename certifications to majors  
$this->call(MajorsTableSeeder::class);
```

### Step 5: Create Student Quiz Creation Interface

In `app/Filament/Member/Resources/`:
- Allow students to create custom quizzes
- Add privacy toggle
- Add "Submit for Approval" action

### Step 6: Rebuild Assets
After color changes, rebuild the frontend:

```bash
npm run build
```

For development with hot reload:
```bash
npm run dev
```

## 📋 Features Checklist

### Core Features (Database Ready ✅)
- ✅ Private/Public quiz system
- ✅ Student-created quiz tracking
- ✅ Quiz approval workflow
- ✅ School color scheme

### UI Features (To Implement)
- ⏳ Quiz creation form for students
- ⏳ Approval request submission
- ⏳ Teacher approval dashboard
- ⏳ Student-made quizzes category
- ⏳ Major-based quiz filtering
- ⏳ Semester organization

### Access Control
- ⏳ Students can only see approved public quizzes + their own
- ⏳ Teachers can see all quizzes
- ⏳ Major-based access (students see quizzes for their majors)

## 🎯 User Workflows

### Student Workflow
1. **Login** → Member panel
2. **View Majors** → See assigned majors (subscriptions)
3. **Take Quizzes** → 
   - Teacher-created quizzes
   - Approved student-created quizzes
   - Own private quizzes
4. **Create Quiz** → Design custom quiz (private by default)
5. **Request Publication** → Submit for teacher approval
6. **Track Requests** → View approval status

### Teacher Workflow
1. **Login** → Admin panel
2. **Manage Majors** → Create/edit majors
3. **Manage Semesters** → Organize by academic periods
4. **Assign Students** → Subscribe students to majors
5. **Review Requests** → Approve/reject student quiz publications
6. **Manage All Quizzes** → Full access to all content

## 🔧 Configuration Files Modified

1. **`tailwind.config.js`** - School colors added
2. **`database/migrations/`** - New fields and tables
3. **`app/Models/QuizHeader.php`** - Extended functionality
4. **`app/Models/QuizApprovalRequest.php`** - New model

## 📖 API Endpoints to Create (Optional)

If you want to add API support:

```php
// routes/api.php
Route::middleware('auth:sanctum')->group(function () {
    // Student quiz management
    Route::post('/quizzes', [QuizController::class, 'create']);
    Route::post('/quizzes/{quiz}/request-approval', [QuizController::class, 'requestApproval']);
    
    // Teacher approvals
    Route::get('/approval-requests', [ApprovalController::class, 'index']);
    Route::post('/approval-requests/{request}/approve', [ApprovalController::class, 'approve']);
    Route::post('/approval-requests/{request}/reject', [ApprovalController::class, 'reject']);
});
```

## 🎨 Branding Customization

### Logo Placement
Update logo in: `public/images/logo.png`
- Recommended size: 200x200px
- Include both green (#007241) and yellow (#f9c432) colors

### Color Usage Guidelines
- **Primary Green (#007241)**: Headers, primary buttons, active states
- **Secondary Yellow (#f9c432)**: Accents, badges, highlights, hover states
- Use yellow sparingly for emphasis

## 📝 Notes

- All database migrations have been run successfully
- Models are updated and ready
- Tailwind configuration includes school colors
- Frontend assets need to be rebuilt (`npm run build`)
- Filament resources need to be created for new features

## 🆘 Support

For questions about implementation:
1. Check Filament documentation: https://filamentphp.com
2. Review Laravel relationships: https://laravel.com/docs/eloquent-relationships
3. Consult Spatie Permission docs: https://spatie.be/docs/laravel-permission

---

**Status**: Database layer complete ✅ | UI layer pending ⏳ | Ready for Filament resource development
