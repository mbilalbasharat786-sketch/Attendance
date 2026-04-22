<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return redirect('/register');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // NAYE ROUTES YAHAN HAIN
    Route::get('/dashboard', [AttendanceController::class, 'dashboard'])->name('dashboard');
    Route::post('/mark-attendance', [AttendanceController::class, 'markAttendance'])->name('attendance.mark');
    Route::post('/submit-leave', [LeaveController::class, 'submitLeave'])->name('leave.submit');
    Route::post('/tasks/{id}/submit', [TaskController::class, 'submitResponse'])->name('student.task.submit');


    Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    // NAYE ROUTES: Leave Management
    Route::get('/leaves', [AdminController::class, 'viewLeaves'])->name('admin.leaves');
    Route::post('/leaves/{id}/status', [AdminController::class, 'updateLeaveStatus'])->name('admin.leaves.status');
    Route::get('/students', [AdminController::class, 'manageStudents'])->name('admin.students');
    // Tasks Module
    Route::get('/tasks', [AdminController::class, 'manageTasks'])->name('admin.tasks');
    Route::post('/tasks/store', [AdminController::class, 'storeTask'])->name('admin.tasks.store');
    Route::post('/tasks/{id}/review', [AdminController::class, 'reviewTask'])->name('admin.tasks.review');
    // Attendance Reports & Editing
    Route::get('/reports', [AdminController::class, 'viewReports'])->name('admin.reports');
    Route::post('/attendance/manual', [AdminController::class, 'storeManualAttendance'])->name('admin.attendance.manual');
    Route::delete('/attendance/{id}', [AdminController::class, 'deleteAttendance'])->name('admin.attendance.delete');


// Yeh route auth middleware wale group ke andar aayega

});

// 2. SECRET JADOO ROUTE: Apne aap ko admin banane ke liye (Testing ke liye)
Route::get('/make-me-admin', function() {
    $user = auth()->user();
    $user->role = 'admin';
    $user->save();
    return redirect()->route('admin.dashboard')->with('success', 'Mubarak ho! Aap ab Admin hain.');
})->middleware('auth');
});

require __DIR__.'/auth.php';
