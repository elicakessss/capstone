<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Redirect root to dashboard or login
Route::get('/', function () {
    return Auth::check() ? redirect()->route('dashboard') : redirect()->route('login');
});

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');
    Route::get('/profile', fn() => view('profile.edit'))->name('profile.edit');

    // Portfolio
    Route::prefix('portfolio')->name('portfolio.')->group(function () {
        Route::get('/', fn() => view('portfolio.index'))->name('index');
        Route::get('/documents', fn() => view('portfolio.documents'))->name('documents');
    });

    // Councils (all roles)
    Route::prefix('councils')->name('councils.')->group(function () {
        Route::get('/', fn() => view('councils.index'))->name('index');
        Route::get('/create', fn() => view('councils.create'))->name('create')->middleware('role:admin,adviser');
        Route::get('/{id}/edit', fn($id) => view('councils.edit', compact('id')))->name('edit')->middleware('role:admin,adviser');
    });

    // Evaluations (all roles)
    Route::prefix('evaluations')->name('evaluations.')->group(function () {
        Route::get('/', fn() => view('evaluations.index'))->name('index');
        Route::get('/pending', fn() => view('evaluations.pending'))->name('pending');
        Route::get('/completed', fn() => view('evaluations.completed'))->name('completed');
    });

    // Student
    Route::prefix('student')->name('student.')->middleware('role:student')->group(function () {
        Route::get('/memberships', fn() => view('student.memberships'))->name('memberships');
    });

    // Adviser
    Route::prefix('adviser')->name('adviser.')->middleware('role:adviser,admin')->group(function () {
        Route::get('/organizations', fn() => view('adviser.organizations'))->name('organizations');
        Route::get('/evaluations', fn() => view('adviser.evaluations'))->name('evaluations');
    });

    // Admin
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/departments', fn() => view('admin.departments'))->name('departments');
        Route::get('/councils', fn() => view('admin.councils'))->name('councils');


        // User management
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\UsersController::class, 'index'])->name('index');
            Route::get('/create', [App\Http\Controllers\Admin\UsersController::class, 'create'])->name('create');
            Route::post('/', [App\Http\Controllers\Admin\UsersController::class, 'store'])->name('store');
            Route::get('/{user}', [App\Http\Controllers\Admin\UsersController::class, 'show'])->name('show');
            Route::get('/{user}/edit', [App\Http\Controllers\Admin\UsersController::class, 'edit'])->name('edit');
            Route::put('/{user}', [App\Http\Controllers\Admin\UsersController::class, 'update'])->name('update');
            Route::delete('/{user}', [App\Http\Controllers\Admin\UsersController::class, 'destroy'])->name('destroy');
        });
        Route::prefix('user-requests')->name('user-requests.')->group(function () {
            Route::post('/{userRequest}/approve', [App\Http\Controllers\UserRequestController::class, 'approve'])->name('approve');
            Route::post('/{userRequest}/reject', [App\Http\Controllers\UserRequestController::class, 'reject'])->name('reject');
        });

        // Organization management
        Route::prefix('orgs')->name('orgs.')->group(function () {
            Route::get('/', [App\Http\Controllers\OrgController::class, 'index'])->name('index');
            Route::post('/', [App\Http\Controllers\OrgController::class, 'store'])->name('store');
            Route::get('/{org}', [App\Http\Controllers\OrgController::class, 'show'])->name('show');
            Route::get('/{org}/edit', [App\Http\Controllers\OrgController::class, 'edit'])->name('edit');
            Route::put('/{org}', [App\Http\Controllers\OrgController::class, 'update'])->name('update');
            Route::delete('/{org}', [App\Http\Controllers\OrgController::class, 'destroy'])->name('destroy');

            // Position management for org
            Route::post('/{org}/positions', [App\Http\Controllers\Admin\OrgPositionController::class, 'store'])->name('positions.store');

            // Adviser assignment and search
            Route::post('/{org}/assign-adviser', [App\Http\Controllers\Admin\OrgAdviserController::class, 'assign'])->name('assignAdviser');
            Route::get('/{org}/search-advisers', [App\Http\Controllers\Admin\OrgAdviserController::class, 'search'])->name('searchAdvisers');
        });

        // Department management
        Route::post('/departments', [App\Http\Controllers\Admin\DepartmentsController::class, 'store'])->name('departments.store');
        Route::get('/departments/{department}', [App\Http\Controllers\Admin\DepartmentsController::class, 'show'])->name('departments.show');
        Route::get('/departments/{department}/edit', [App\Http\Controllers\Admin\DepartmentsController::class, 'edit'])->name('departments.edit');
        Route::put('/departments/{department}', [App\Http\Controllers\Admin\DepartmentsController::class, 'update'])->name('departments.update');
        Route::delete('/departments/{department}', [App\Http\Controllers\Admin\DepartmentsController::class, 'destroy'])->name('departments.destroy');

        // Form management
        Route::prefix('forms')->name('forms.')->group(function () {
            Route::get('/', fn() => view('admin.forms.index'))->name('index');
            Route::get('/create', fn() => view('admin.forms.create'))->name('create');
            Route::get('/{id}/edit', fn($id) => view('admin.forms.edit', compact('id')))->name('edit');
        });

        // System logs
        Route::get('/logs', fn() => view('admin.logs.index'))->name('logs');

    });
});

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', fn() => view('auth.login'))->name('login');
    Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
    Route::get('/register', [App\Http\Controllers\UserRequestController::class, 'create'])->name('register');
    Route::post('/register', [App\Http\Controllers\UserRequestController::class, 'store']);
    Route::get('/registration-pending', [App\Http\Controllers\UserRequestController::class, 'pending'])->name('registration.pending');
    Route::get('/forgot-password', fn() => view('auth.forgot-password'))->name('password.request');
    Route::post('/forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', fn($token) => view('auth.reset-password', ['token' => $token]))->name('password.reset');
    Route::post('/reset-password', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');
});

// Authenticated user actions
Route::middleware('auth')->group(function () {
    Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
    Route::get('/email/verify', fn() => view('auth.verify-email'))->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [App\Http\Controllers\Auth\VerificationController::class, 'verify'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
    Route::post('/email/verification-notification', [App\Http\Controllers\Auth\VerificationController::class, 'resend'])
        ->middleware('throttle:6,1')
        ->name('verification.send');
});
