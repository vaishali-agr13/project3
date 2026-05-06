<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\JobController; // Yeh line add karein
use App\Http\Controllers\HomeController; 
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\CandidateController;




Route::prefix('admin')->group(function () {

        Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AuthController::class, 'loginAdmin']);
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        Route::middleware('auth', 'can:isAdmin')->group(function () {
                
            Route::get('/candidate-list', [CandidateController::class, 'candidateList']);

            Route::get('/profile', [AuthController::class, 'profile']);
            Route::post('/profile/store', [AuthController::class, 'storeProfile'])->name('profile.store');
            Route::put('/profile/{id}', [AuthController::class, 'updateProfile'])->name('profile.update');
            Route::get('/jobs/create', [JobController::class, 'create'])->name('admin.jobs.create');
            Route::get('/applications', [JobController::class, 'applications'])->name('applications.index');
            Route::post('/jobs/store', [JobController::class, 'store'])->name('admin.jobs.store');
            Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
            Route::get('/jobs/edit/{id}', [JobController::class, 'edit'])->name('jobs.edit');
            Route::delete('/jobs/delete/{id}', [JobController::class, 'destroy'])->name('jobs.delete');
            Route::post('/jobs/update/{id}', [JobController::class, 'update'])->name('jobs.update');
            Route::get('/companies/jobs', [JobController::class, 'companiesJob']);
            Route::post('/applications/{id}/status', [JobController::class, 'updateApplicationStatus'])->name('applications.updateStatus');
            Route::get('/categories', [CategoryController::class, 'index']);
            Route::get('/categories/create', [CategoryController::class, 'create']);
            Route::post('/categories/store', [CategoryController::class, 'store']);

            Route::get('/categories/edit/{id}', [CategoryController::class, 'edit']);
            Route::get('/dashboard', [JobController::class, 'dashboard'])->name('admin.dashboard');

            Route::post('/categories/update/{id}', [CategoryController::class, 'update']);
            Route::delete('/categories/delete/{id}', [CategoryController::class, 'destroy']);
            Route::get('/job-status/{id}/{status}', [JobController::class, 'updateStatus'])->name('job.status');
            Route::delete('/applications/{id}', [JobController::class, 'destroyApplication'])->name('applications.delete');
            Route::get('/applications/export', [JobController::class, 'export'])->name('applications.export');
        });
    
});

Route::middleware(['auth', 'can:isCandidate'])->group(function () {

        Route::get('/candidate/dashboard', [CandidateController::class, 'dashboard'])->name('candidate.dashboard');
        Route::get('/candidate/profile', [CandidateController::class, 'index'])->name('candidate.profile');
        Route::post('/candidate/profile', [CandidateController::class, 'store'])->name('candidate.profile.store');
        Route::get('/candidate/jobs', [JobController::class, 'index']);
        Route::get('/candidate/applications', [JobController::class, 'applications']);



 });

Route::get('candidate/login', [AuthController::class, 'showLogin']);
Route::post('candidate/login', [AuthController::class, 'loginCandidate']);

Route::get('candidate/register', [CandidateController::class, 'showForm'])->name('register');
Route::post('/register', [CandidateController::class, 'register']);

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/categories', function () { return view('categories'); });
Route::get('/categories/{slug}', [CategoryController::class, 'show']);
Route::post('/jobs/store', [JobController::class, 'store']);

Route::get('/find-jobs', [JobController::class, 'find_job']);
Route::get('/about', [HomeController::class, 'about']);
Route::get('/services', [HomeController::class, 'services']);
Route::get('/companies', [HomeController::class, 'companies']);
Route::get('/privacy-policy', [HomeController::class, 'privacy_policy']);
Route::get('/jobs/{id}/apply', [JobController::class, 'applyForm'])->name('jobs.apply.form');


Route::get('/jobs/{id}', [JobController::class, 'show'])->name('jobs.show');
Route::get('/about', function () { return view('about'); });

Route::post('/jobs/{id}/apply', [JobController::class, 'apply'])->name('jobs.apply');

// Route::post('jobs/{id}/apply', [JobController::class, 'apply'])
//     ->middleware('auth')
//     ->name('jobs.apply');

