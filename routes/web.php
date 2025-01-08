<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;


Route::middleware(['auth', 'throttle:60,1'])->group(function () {
    Route::get('/home', function () {
        return view('home.index');
    });

    Route::get('/employees', function () {
        return view('employees.employees-page');
    });

    Route::get('/clients', function () {
        return view('clients.clients-page');
    });


    Route::get('/transactions', function () {
        return view('transactions.transactions-page');
    });

    Route::get('/balance', function () {
        return view('balance');
    });

    Route::get('/reports', function () {
        return view('reports');
    });

    Route::get('/contractors', function () {
        return view('contractors.contractors-page');
    });
    
    Route::get('/units', function () {
        return view('units.units-page');
    });

    Route::get('/resources', function () {
        return view('resources.resources-page');
    });
    
    Route::get('/profile', function () {
        return view('profile.profile-page');
    });

    Route::controller(AuthController::class)->group(function () {
        Route::post('/logout', 'logout');
        Route::post('/change-password', 'changePassword');
        Route::get('/user', 'getUserData');
    });

});

Route::middleware('throttle:60,1')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('/register', 'register');
        Route::post('/login', 'login');
    });

    Route::get('/admin', function () {
        return view('admin');
    })
    ->middleware(['admin'])
    ->name('admin');

    // Redirect authenticated users from login and register pages to home
    Route::get('/login', function () {
        if (Auth::check() && Auth::user()->role == "super admin") {
            return redirect('/admin');
        }
        else  if (Auth::check()) {
            return redirect('/home');
        }
        return view('login');
    })
        ->name('login');

    Route::get('/', function () {
        if (Auth::check() && Auth::user()->role == "super admin") {
            return redirect('/admin');
        }
        else  if (Auth::check()) {
            return redirect('/home');
        }
        return view('login');
    });

    Route::get('/register', function () {
        if (Auth::check() && Auth::user()->role == "super admin") {
            return redirect('/admin');
        }
        else  if (Auth::check()) {
            return redirect('/home');
        }
        return view('register');
    });
});

Route::fallback(function () {
    return view('404');
});