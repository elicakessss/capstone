<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\PositionsController;

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

    // AJAX: Check for duplicate org+year (must be outside closure-based prefix group)
    Route::get('/orgs/check-duplicate', [App\Http\Controllers\OrgTermController::class, 'checkDuplicate'])->name('orgs.check-duplicate');

    // Orgs (all roles)
    Route::prefix('orgs')->name('orgs.')->group(function () {
        Route::get('/', fn() => view('orgs.index'))->name('index');
        // If you have orgs.create or orgs.edit views, update here as well
        // Route::get('/create', fn() => view('orgs.create'))->name('create')->middleware('role:admin,adviser');
        // Route::get('/{id}/edit', fn($id) => view('orgs.edit', compact('id')))->name('edit')->middleware('role:admin,adviser');
    });

    // Orgs
    Route::resource('orgs', App\Http\Controllers\OrgTermController::class)->only(['index', 'store']);
    Route::get('orgs/{org}', [App\Http\Controllers\OrgTermController::class, 'show'])->name('orgs.show');

    // Evaluations (all roles)
    Route::prefix('evaluations')->name('evaluations.')->group(function () {
        Route::get('/', fn() => view('evaluations.index'))->name('index');
        Route::get('/pending', fn() => view('evaluations.pending'))->name('pending');
        Route::get('/completed', fn() => view('evaluations.completed'))->name('completed');
    });

    // Student
    Route::prefix('student')->name('student.')->middleware('is_admin')->group(function () {
        Route::get('/memberships', fn() => view('student.memberships'))->name('memberships');
    });

    // Adviser
    Route::prefix('adviser')->name('adviser.')->middleware('is_admin')->group(function () {
        Route::get('/organizations', fn() => view('adviser.organizations'))->name('organizations');
        Route::get('/evaluations', fn() => view('adviser.evaluations'))->name('evaluations');

        // Assign student to position (AJAX)
        Route::post('/orgs/{org}/positions/{position}/assign-student', [App\Http\Controllers\OrgController::class, 'assignStudentToPosition'])->name('orgs.positions.assignStudent');
    });

    // Admin
    Route::prefix('admin')->name('admin.')->middleware('is_admin')->group(function () {
        Route::get('/departments', fn() => view('admin.departments'))->name('departments');
        // Route::get('/orgs', fn() => view('admin.orgs'))->name('orgs');


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

        // Org Type management
        Route::post('/org_types', [App\Http\Controllers\Admin\OrgTypeController::class, 'store'])->name('org_types.store');
        Route::get('/org_types/{type}', [App\Http\Controllers\Admin\OrgTypeController::class, 'show'])->name('org_types.show');
        Route::get('/org_types/{type}/edit', [App\Http\Controllers\Admin\OrgTypeController::class, 'edit'])->name('org_types.edit');
        Route::put('/org_types/{type}', [App\Http\Controllers\Admin\OrgTypeController::class, 'update'])->name('org_types.update');
        Route::delete('/org_types/{type}', [App\Http\Controllers\Admin\OrgTypeController::class, 'destroy'])->name('org_types.destroy');

        // Position management for org (admin)
        Route::resource('positions', PositionsController::class)->only(['edit', 'update', 'destroy']);
    });

    // Add route for org_terms.show so org term cards work
    Route::get('org_terms/{orgTerm}', [App\Http\Controllers\OrgTermController::class, 'show'])->name('org_terms.show');
    // Add route for assigning student to position in org term
    Route::post('org_terms/{orgTerm}/assign-student', [App\Http\Controllers\OrgTermController::class, 'assignStudent'])->name('org_terms.assignStudent');
    // Add route for AJAX student search in org term
    Route::get('org_terms/{orgTerm}/search-students', [App\Http\Controllers\OrgTermController::class, 'searchStudents'])->name('org_terms.searchStudents');
    // Remove student from position in org term
    Route::delete('org_terms/{orgTerm}/positions/{position}/remove-student/{user}', [App\Http\Controllers\OrgTermController::class, 'removeStudent'])->name('org_terms.removeStudent');
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
