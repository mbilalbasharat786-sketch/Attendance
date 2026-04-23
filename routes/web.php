<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\RoleController; // 👈 NAYA CONTROLLER ADD KIYA

Route::get('/', function () {
    return redirect('/register');
});

// NAYA: Admin Login Page Ke Routes (Bina Login Kiye Access Honge)
Route::get('/admin', [AdminController::class, 'showLoginForm'])->name('admin.login.view');
Route::post('/admin/login-submit', [AdminController::class, 'adminLogin'])->name('admin.login.submit');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [AttendanceController::class, 'dashboard'])->name('dashboard');
    Route::post('/mark-attendance', [AttendanceController::class, 'markAttendance'])->name('attendance.mark');
    Route::post('/submit-leave', [LeaveController::class, 'submitLeave'])->name('leave.submit');
    Route::post('/tasks/{id}/submit', [TaskController::class, 'submitResponse'])->name('student.task.submit');

    // Admin Panel Ke Protected Routes
    Route::middleware(['admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/leaves', [AdminController::class, 'viewLeaves'])->name('admin.leaves');
        Route::post('/leaves/{id}/status', [AdminController::class, 'updateLeaveStatus'])->name('admin.leaves.status');
        Route::get('/students', [AdminController::class, 'manageStudents'])->name('admin.students');
        Route::get('/tasks', [AdminController::class, 'manageTasks'])->name('admin.tasks');
        Route::post('/tasks/store', [AdminController::class, 'storeTask'])->name('admin.tasks.store');
        Route::post('/tasks/{id}/review', [AdminController::class, 'reviewTask'])->name('admin.tasks.review');
        Route::get('/reports', [AdminController::class, 'viewReports'])->name('admin.reports');
        Route::post('/attendance/manual', [AdminController::class, 'storeManualAttendance'])->name('admin.attendance.manual');
        Route::delete('/attendance/{id}', [AdminController::class, 'deleteAttendance'])->name('admin.attendance.delete');
        
        // 👇 NAYE ROLES & PERMISSIONS WALE ROUTES 👇
        Route::get('/roles', [RoleController::class, 'index'])->name('admin.roles.index');
        Route::get('/roles/create', [RoleController::class, 'create'])->name('admin.roles.create');
        Route::post('/roles', [RoleController::class, 'store'])->name('admin.roles.store');
        Route::get('/roles/{id}/edit', [RoleController::class, 'edit'])->name('admin.roles.edit');
        Route::put('/roles/{id}', [RoleController::class, 'update'])->name('admin.roles.update');
        Route::delete('/roles/{id}', [RoleController::class, 'destroy'])->name('admin.roles.destroy');
        Route::post('/users/{id}/assign-role', [RoleController::class, 'assignRole'])->name('admin.users.assign_role');
    });
});

require __DIR__.'/auth.php';