<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
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
    Route::get('/portfolio', function () {
        return view('portfolio.index');
    })->name('portfolio.index');
    
    Route::get('/portfolio/documents', function () {
        return view('portfolio.documents');
    })->name('portfolio.documents');
    
    // Student routes
    Route::get('/student/memberships', function () {
        return view('student.memberships');
    })->name('student.memberships');
    
    // Adviser routes
    Route::get('/adviser/organizations', function () {
        return view('adviser.organizations');
    })->name('adviser.organizations');
    
    Route::get('/adviser/evaluations', function () {
        return view('adviser.evaluations');
    })->name('adviser.evaluations');
    
    // Admin routes
    Route::get('/admin/departments', function () {
        return view('admin.departments');
    })->name('admin.departments');
    
    Route::get('/admin/councils', function () {
        return view('admin.councils');
    })->name('admin.councils');
    
    Route::get('/admin/users', function () {
        return view('admin.users');
    })->name('admin.users');
});

// Auth routes will be added when authentication is set up
// require __DIR__.'/auth.php';
