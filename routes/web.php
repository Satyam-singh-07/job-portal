<?php

use App\Http\Controllers\web\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/jobs', function () {
    return view('jobs.index');
})->name('jobs.index');

Route::get('/job-detail', function () {
    return view('jobs.show');
})->name('jobs.show');

Route::get('/employers', function () {
    return view('employers.index');
})->name('employers.index');

Route::get('/employer/dashboard', function () {
    return view('employers.dashboard');
})->name('employer.dashboard');

Route::get('/company-detail', function () {
    return view('employers.show');
})->name('company.show');

Route::get('/employer/post-job', function () {
    return view('employer.post-job');
})->name('employer.post-job');






Route::prefix('candidate')->name('candidate.')->group(function () {

    Route::get('/list', function () {
        return view('candidates.index');
    })->name('index');

    Route::get('/grid', function () {
        return view('candidates.grid');
    })->name('grid');

    Route::get('/detail', function () {
        return view('candidates.show');
    })->name('show');
    Route::get('/edit-profile', function () {
        return view('candidates.edit-profile');
    })->name('edit-profile');

    Route::get('/build-resume', function () {
        return view('candidates.build-resume');
    })->name('build-resume');

    Route::get('/download-cv', function () {
        return view('candidates.download-cv');
    })->name('download-cv');

    Route::get('/public-profile', function () {
        return view('candidates.public-profile');
    })->name('public-profile');

    Route::get('/applications', function () {
        return view('candidates.applications');
    })->name('applications');

    Route::get('/favourites', function () {
        return view('candidates.favourites');
    })->name('favourites');

    Route::get('/alerts', function () {
        return view('candidates.alerts');
    })->name('alerts');

    Route::get('/manage-resume', function () {
        return view('candidates.manage-resume');
    })->name('manage-resume');

    Route::get('/messages', function () {
        return view('candidates.messages');
    })->name('messages');

    Route::get('/followings', function () {
        return view('candidates.followings');
    })->name('followings');

    Route::get('/packages', function () {
        return view('candidates.packages');
    })->name('packages');

    Route::get('/payment-history', function () {
        return view('candidates.payment-history');
    })->name('payment-history');
});



Route::middleware('guest')->group(function () {

    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');


    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');


    //auth routes
    Route::post('/register', [AuthController::class, 'store'])
        ->middleware('throttle:10,1');

    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:10,1')->name('login.post');
});


Route::middleware('auth')->group(function () {

    Route::post('/resend-otp', [AuthController::class, 'resendOtp'])->middleware('throttle:5,1');
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->middleware('throttle:10,1');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');



    Route::middleware('role:candidate')->prefix('candidate')->name('candidate.')->group(function () {

        Route::get('/dashboard', function () {
            return view('candidates.dashboard');
        })->name('dashboard');
    });








    Route::middleware('role:employer')->prefix('employer')->name('employer.')->group(function () {
        Route::get('/dashboard', function () {
            return view('employers.dashboard');
        })->name('dashboard');

        Route::get('/company-profile', function () {
            return view('employers.company-profile');
        })->name('company-profile');
    });
});
