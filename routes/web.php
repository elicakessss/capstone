<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

// Dashboard route (requires authentication)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile routes
    Route::get('/profile', function () {
        return view('profile.edit');
    })->name('profile.edit');

    // Portfolio routes
    Route::prefix('portfolio')->name('portfolio.')->group(function () {
        Route::get('/', function () {
            return view('portfolio.index');
        })->name('index');

        Route::get('/documents', function () {
            return view('portfolio.documents');
        })->name('documents');
    });

    // Councils routes (unified for all roles)
    Route::prefix('councils')->name('councils.')->group(function () {
        Route::get('/', function () {
            return view('councils.index');
        })->name('index');

        Route::get('/create', function () {
            return view('councils.create');
        })->name('create')->middleware('role:admin,adviser');

        Route::get('/{id}/edit', function ($id) {
            return view('councils.edit', compact('id'));
        })->name('edit')->middleware('role:admin,adviser');
    });

    // Evaluations routes (for all roles)
    Route::prefix('evaluations')->name('evaluations.')->group(function () {
        Route::get('/', function () {
            return view('evaluations.index');
        })->name('index');

        Route::get('/pending', function () {
            return view('evaluations.pending');
        })->name('pending');

        Route::get('/completed', function () {
            return view('evaluations.completed');
        })->name('completed');
    });

    // Student routes
    Route::prefix('student')->name('student.')->middleware('role:student')->group(function () {
        Route::get('/memberships', function () {
            return view('student.memberships');
        })->name('memberships');
    });

    // Adviser routes
    Route::prefix('adviser')->name('adviser.')->middleware('role:adviser,admin')->group(function () {
        Route::get('/organizations', function () {
            return view('adviser.organizations');
        })->name('organizations');

        Route::get('/evaluations', function () {
            return view('adviser.evaluations');
        })->name('evaluations');
    });

    // Admin routes
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        // Department management
        Route::get('/departments', function () {
            return view('admin.departments');
        })->name('departments');

        // Council management (admin-specific)
        Route::get('/councils', function () {
            return view('admin.councils');
        })->name('councils');

        // User request management
        Route::prefix('user-requests')->name('user-requests.')->group(function () {
            Route::get('/', [App\Http\Controllers\UserRequestController::class, 'index'])->name('index');
            Route::get('/{userRequest}', [App\Http\Controllers\UserRequestController::class, 'show'])->name('show');
            Route::post('/{userRequest}/approve', [App\Http\Controllers\UserRequestController::class, 'approve'])->name('approve');
            Route::post('/{userRequest}/reject', [App\Http\Controllers\UserRequestController::class, 'reject'])->name('reject');
        });

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

        // Form management
        Route::prefix('forms')->name('forms.')->group(function () {
            Route::get('/', function () {
                return view('admin.forms.index');
            })->name('index');

            Route::get('/create', function () {
                return view('admin.forms.create');
            })->name('create');

            Route::get('/{id}/edit', function ($id) {
                return view('admin.forms.edit', compact('id'));
            })->name('edit');
        });

        // System logs
        Route::get('/logs', function () {
            return view('admin.logs.index');
        })->name('logs');
    });
});

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);

    Route::get('/register', [App\Http\Controllers\UserRequestController::class, 'create'])->name('register');

    Route::post('/register', [App\Http\Controllers\UserRequestController::class, 'store']);

    Route::get('/registration-pending', [App\Http\Controllers\UserRequestController::class, 'pending'])->name('registration.pending');

    Route::get('/forgot-password', function () {
        return view('auth.forgot-password');
    })->name('password.request');

    Route::post('/forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

    Route::get('/reset-password/{token}', function ($token) {
        return view('auth.reset-password', ['token' => $token]);
    })->name('password.reset');

    Route::post('/reset-password', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', [App\Http\Controllers\Auth\VerificationController::class, 'verify'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('/email/verification-notification', [App\Http\Controllers\Auth\VerificationController::class, 'resend'])
        ->middleware('throttle:6,1')
        ->name('verification.send');
});
