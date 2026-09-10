<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminPaymentController;
use App\Http\Controllers\AdminAcademicsController;
use App\Http\Controllers\AdminNotificationsController;
use App\Http\Controllers\AdminApplicationsController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SubjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/catalog', [PublicController::class, 'catalog'])->name('catalog');
Route::get('/subjects/{id}', [PublicController::class, 'subject'])->whereNumber('id')->name('subjects.show');
Route::get('/teachers', [PublicController::class, 'teachers'])->name('teachers');
Route::get('/teachers/{id}', [PublicController::class, 'teacher'])->whereNumber('id')->name('teachers.show');
Route::get('/api/home-teachers', [PublicController::class, 'homeTeachers'])->name('api.home-teachers');
Route::get('/about', fn () => app(PublicController::class)->page('about'))->name('about');
Route::get('/contact', fn () => app(PublicController::class)->page('contact'))->name('contact');
Route::get('/policies', fn () => app(PublicController::class)->page('policies'))->name('policies');
Route::get('/pricing', fn () => app(PublicController::class)->page('pricing'))->name('pricing');

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::middleware('auth')->group(function (): void {
    Route::get('/dashboard', [SubjectController::class, 'dashboard'])->middleware('role:student')->name('dashboard');
    Route::get('/subjects', [SubjectController::class, 'index'])->name('subjects.index');
    Route::post('/enrollments', [SubjectController::class, 'enroll'])->name('enrollments.store');
    Route::get('/payment', [PaymentController::class, 'create'])->middleware('role:student')->name('payment.create');
    Route::post('/payment', [PaymentController::class, 'store'])->middleware('role:student')->name('payment.store');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/admin', [AdminController::class, 'dashboard'])->middleware('role:admin')->name('admin.dashboard');
    Route::get('/admin/payments', [AdminPaymentController::class, 'index'])->middleware('role:admin')->name('admin.payments');
    Route::post('/admin/payments', [AdminPaymentController::class, 'update'])->middleware('role:admin')->name('admin.payments.update');
    Route::get('/admin/students', [AdminController::class, 'students'])->middleware('role:admin')->name('admin.students');
    Route::post('/admin/students/enroll', [AdminController::class, 'enrollStudent'])->middleware('role:admin')->name('admin.students.enroll');
    Route::get('/admin/teachers', [AdminController::class, 'teachers'])->middleware('role:admin')->name('admin.teachers');
    Route::post('/admin/teachers', [AdminController::class, 'storeTeacher'])->middleware('role:admin')->name('admin.teachers.store');
    Route::post('/admin/teachers/{id}', [AdminController::class, 'updateTeacher'])->middleware('role:admin')->name('admin.teachers.update');
    Route::get('/admin/academics', [AdminAcademicsController::class, 'index'])->middleware('role:admin')->name('admin.academics');
    Route::post('/admin/academics/grades', [AdminAcademicsController::class, 'storeGrade'])->middleware('role:admin')->name('admin.grades.store');
    Route::post('/admin/academics/subjects', [AdminAcademicsController::class, 'storeSubject'])->middleware('role:admin')->name('admin.subjects.store');
    Route::get('/admin/notifications', [AdminNotificationsController::class, 'index'])->middleware('role:admin')->name('admin.notifications');
    Route::post('/admin/notifications/read', [AdminNotificationsController::class, 'read'])->middleware('role:admin')->name('admin.notifications.read');
    Route::get('/admin/applications', [AdminApplicationsController::class, 'index'])->middleware('role:admin')->name('admin.applications');
    Route::get('/admin/schedule', [AdminController::class, 'schedule'])->middleware('role:admin')->name('admin.schedule');
    Route::post('/admin/schedule', [AdminController::class, 'storeSchedule'])->middleware('role:admin')->name('admin.schedule.store');
    Route::post('/admin/schedule/{id}/toggle', [AdminController::class, 'toggleSchedule'])->middleware('role:admin')->name('admin.schedule.toggle');
    Route::delete('/admin/schedule/{id}', [AdminController::class, 'deleteSchedule'])->middleware('role:admin')->name('admin.schedule.delete');
    Route::get('/admin/accounts', [AdminController::class, 'accounts'])->middleware('role:admin')->name('admin.accounts');
    Route::post('/admin/accounts/{id}', [AdminController::class, 'updateAccount'])->middleware('role:admin')->name('admin.accounts.update');
    Route::get('/teacher', [TeacherController::class, 'dashboard'])->middleware('role:teacher')->name('teacher.dashboard');
    Route::post('/teacher/profile', [TeacherController::class, 'updateProfile'])->middleware('role:teacher')->name('teacher.profile.update');
});
