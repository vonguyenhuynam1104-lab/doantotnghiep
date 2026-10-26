<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CandidateDashboardController;
use App\Http\Controllers\CandidateProfileController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployerDashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - JobConnect Recruitment Platform
|--------------------------------------------------------------------------
*/

// Public Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/viec-lam', [JobController::class, 'index'])->name('jobs.index');
Route::get('/viec-lam/{slug}', [JobController::class, 'show'])->name('jobs.show');
Route::post('/viec-lam/{id}/ung-tuyen', [JobController::class, 'apply'])->name('jobs.apply');
Route::post('/viec-lam/{id}/luu-tin', [JobController::class, 'toggleSave'])->name('jobs.toggle_save');

Route::get('/cong-ty', [CompanyController::class, 'index'])->name('companies.index');
Route::get('/cong-ty/{slug}', [CompanyController::class, 'show'])->name('companies.show');

Route::get('/ung-vien', [CandidateProfileController::class, 'index'])->name('candidates.index');
Route::get('/ung-vien/{id}', [CandidateProfileController::class, 'show'])->name('candidates.show');

// Authentication Routes
Route::get('/dang-nhap', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/dang-nhap', [AuthController::class, 'login']);
Route::get('/dang-ky', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/dang-ky', [AuthController::class, 'register']);
Route::post('/dang-xuat', [AuthController::class, 'logout'])->name('logout');

// Candidate Portal
Route::middleware(['auth', 'role:candidate'])->prefix('candidate')->name('candidate.')->group(function () {
    Route::get('/dashboard', [CandidateDashboardController::class, 'index'])->name('dashboard');
    Route::get('/ho-so', [CandidateDashboardController::class, 'profile'])->name('profile');
    Route::post('/ho-so', [CandidateDashboardController::class, 'updateProfile'])->name('profile.update');
    Route::get('/don-ung-tuyen', [CandidateDashboardController::class, 'applications'])->name('applications');
    Route::get('/viec-lam-da-luu', [CandidateDashboardController::class, 'savedJobs'])->name('saved_jobs');
});

// Employer Portal
Route::middleware(['auth', 'role:employer'])->prefix('employer')->name('employer.')->group(function () {
    Route::get('/dashboard', [EmployerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/thong-tin-cong-ty', [EmployerDashboardController::class, 'companyProfile'])->name('company_profile');
    Route::post('/thong-tin-cong-ty', [EmployerDashboardController::class, 'updateCompany'])->name('company_profile.update');
    Route::get('/tin-tuyen-dung', [EmployerDashboardController::class, 'jobs'])->name('jobs.index');
    Route::get('/dang-tin', [EmployerDashboardController::class, 'createJob'])->name('jobs.create');
    Route::post('/dang-tin', [EmployerDashboardController::class, 'storeJob'])->name('jobs.store');
    Route::get('/tin-tuyen-dung/{id}/chinh-sua', [EmployerDashboardController::class, 'editJob'])->name('jobs.edit');
    Route::put('/tin-tuyen-dung/{id}', [EmployerDashboardController::class, 'updateJob'])->name('jobs.update');
    Route::post('/tin-tuyen-dung/{id}/chuyen-trang-thai', [EmployerDashboardController::class, 'toggleJobStatus'])->name('jobs.toggle_status');
    Route::delete('/tin-tuyen-dung/{id}', [EmployerDashboardController::class, 'deleteJob'])->name('jobs.delete');
    Route::get('/ho-so-ung-vien', [EmployerDashboardController::class, 'applications'])->name('applications.index');
    Route::post('/ho-so-ung-vien/{id}/cap-nhat-trang-thai', [EmployerDashboardController::class, 'updateApplicationStatus'])->name('applications.update_status');
});

// Admin Portal
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/nguoi-dung', [AdminDashboardController::class, 'users'])->name('users');
    Route::post('/nguoi-dung/{id}/chuyen-trang-thai', [AdminDashboardController::class, 'toggleUserStatus'])->name('users.toggle_status');
    Route::get('/doanh-nghiep', [AdminDashboardController::class, 'companies'])->name('companies');
    Route::post('/doanh-nghiep/{id}/xac-thuc', [AdminDashboardController::class, 'toggleCompanyVerified'])->name('companies.toggle_verified');
    Route::get('/tin-tuyen-dung', [AdminDashboardController::class, 'jobs'])->name('jobs');
    Route::delete('/tin-tuyen-dung/{id}', [AdminDashboardController::class, 'deleteJob'])->name('jobs.delete');
    Route::get('/danh-muc', [AdminDashboardController::class, 'categories'])->name('categories');
    Route::post('/danh-muc', [AdminDashboardController::class, 'storeCategory'])->name('categories.store');
    Route::delete('/danh-muc/{id}', [AdminDashboardController::class, 'deleteCategory'])->name('categories.delete');
});
