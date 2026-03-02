<?php

use App\Http\Controllers\Candidate\CandidateProfileController;
use App\Http\Controllers\Candidate\FavouriteJobController;
use App\Http\Controllers\Candidate\JobAlertController;
use App\Http\Controllers\Employer\CompanyProfileController;
use App\Http\Controllers\web\AuthController;
use App\Http\Controllers\web\EmployerController;
use App\Http\Controllers\web\JobApplicationController;
use App\Models\User;
use Illuminate\Notifications\DatabaseNotification;
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

use App\Http\Controllers\web\JobController;

Route::get('/jobs', [JobController::class, 'index'])->middleware('throttle:jobs-search')->name('jobs.index');
Route::get('/jobs/{slug}', [JobController::class, 'show'])->name('jobs.show');

Route::get('/employers', function () {
    return view('employers.index');
})->name('employers.index');

Route::get('/employer/dashboard', function () {
    return view('employers.dashboard');
})->name('employer.dashboard');

Route::get('/company/@{username}', [EmployerController::class, 'show'])->name('company.show');

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

    Route::get('/build-resume', function () {
        return view('candidates.build-resume');
    })->name('build-resume');

    Route::get('/download-cv', function () {
        return view('candidates.download-cv');
    })->name('download-cv');

    Route::get('/public-profile', [CandidateProfileController::class, 'publicProfile'])->name('public-profile');

    Route::get('/applications', function () {
        return view('candidates.applications');
    })->name('applications');

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

    Route::post('/resend-otp', [AuthController::class, 'resendOtp'])->middleware('throttle:otp-resend');
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->middleware('throttle:otp-verify');
    Route::post('/passwordless/request-otp', [AuthController::class, 'requestPasswordlessOtp'])
        ->middleware('throttle:passwordless-request')
        ->name('passwordless.request-otp');
    Route::post('/passwordless/verify-otp', [AuthController::class, 'verifyPasswordlessOtp'])
        ->middleware('throttle:passwordless-verify')
        ->name('passwordless.verify-otp');

    // auth routes
    Route::post('/register', [AuthController::class, 'store'])
        ->middleware('throttle:register');

    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:login')->name('login.post');
});

Route::middleware('auth')->group(function () {

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('role:candidate')->prefix('candidate')->name('candidate.')->group(function () {

        Route::get('/dashboard', function () {
            return view('candidates.dashboard');
        })->name('dashboard');

        Route::get('/edit-profile', [CandidateProfileController::class, 'edit'])->name('edit-profile');
        Route::put('/edit-profile', [CandidateProfileController::class, 'update'])->name('edit-profile.update');
        Route::post('/edit-profile/photo', [CandidateProfileController::class, 'updatePhoto'])->name('edit-profile.photo');
        Route::post('/edit-profile/visibility', [CandidateProfileController::class, 'updateVisibility'])->name('edit-profile.visibility');

        Route::get('/applications', [JobApplicationController::class, 'index'])->name('applications');
        Route::post('/jobs/{job}/apply', [JobApplicationController::class, 'store'])->name('jobs.apply');
        Route::delete('/applications/{application}', [JobApplicationController::class, 'destroy'])->name('applications.destroy');
        Route::get('/favourites', [FavouriteJobController::class, 'index'])->name('favourites');
        Route::post('/jobs/{job}/favourite', [FavouriteJobController::class, 'store'])->name('jobs.favourite');
        Route::delete('/favourites/{job}', [FavouriteJobController::class, 'destroy'])->name('favourites.destroy');

        Route::get('/alerts', [JobAlertController::class, 'index'])->name('alerts');
        Route::post('/alerts', [JobAlertController::class, 'store'])->name('alerts.store');
        Route::patch('/alerts/{alert}/status', [JobAlertController::class, 'updateStatus'])->name('alerts.status');
        Route::post('/alerts/pause-all', [JobAlertController::class, 'pauseAll'])->name('alerts.pause-all');
        Route::delete('/alerts/{alert}', [JobAlertController::class, 'destroy'])->name('alerts.destroy');
        Route::get('/notifications/{notification}/read', function (DatabaseNotification $notification) {
            if (
                $notification->notifiable_type !== User::class ||
                (int) $notification->notifiable_id !== (int) auth()->id()
            ) {
                abort(403);
            }

            if (is_null($notification->read_at)) {
                $notification->markAsRead();
            }

            $targetUrl = data_get($notification->data, 'url', route('candidate.dashboard'));
            if (!is_string($targetUrl) || trim($targetUrl) === '') {
                $targetUrl = route('candidate.dashboard');
            }

            return redirect()->to($targetUrl);
        })->name('notifications.read');
        Route::post('/notifications/read-all', function () {
            auth()->user()->unreadNotifications->markAsRead();

            return back();
        })->name('notifications.read-all');
    });

    Route::middleware('role:employer')->prefix('employer')->name('employer.')->group(function () {
        Route::get('/dashboard', function () {
            return view('employers.dashboard');
        })->name('dashboard');

        Route::get('/company-profile', [CompanyProfileController::class, 'edit'])->name('company-profile');
        Route::post('/profile/logo', [CompanyProfileController::class, 'updateLogo'])->name('profile.logo');
        Route::put('update-company-profile', [CompanyProfileController::class, 'update'])->name('profile.update');

        Route::get('/post-job', [App\Http\Controllers\Employer\JobController::class, 'create'])->name('post-job');
        Route::post('/post-job', [App\Http\Controllers\Employer\JobController::class, 'store'])->name('post-job.store');
        Route::get('/manage-jobs', [App\Http\Controllers\Employer\JobController::class, 'index'])->name('manage-jobs');
        Route::get('/jobs/{job}/edit', [App\Http\Controllers\Employer\JobController::class, 'edit'])->name('jobs.edit');
        Route::put('/jobs/{job}', [App\Http\Controllers\Employer\JobController::class, 'update'])->name('jobs.update');
        Route::post('/jobs/{job}/publish', [App\Http\Controllers\Employer\JobController::class, 'publish'])->name('jobs.publish');
        Route::post('/jobs/{job}/close', [App\Http\Controllers\Employer\JobController::class, 'close'])->name('jobs.close');
        Route::post('/jobs/{job}/reopen', [App\Http\Controllers\Employer\JobController::class, 'reopen'])->name('jobs.reopen');
        Route::delete('/jobs/{job}', [App\Http\Controllers\Employer\JobController::class, 'destroy'])->name('jobs.destroy');
        Route::get('/jobs/{job}/applications', [App\Http\Controllers\Employer\JobApplicationController::class, 'index'])->name('jobs.applications');
        Route::patch('/jobs/{job}/applications/{application}/status', [App\Http\Controllers\Employer\JobApplicationController::class, 'updateStatus'])->name('jobs.applications.status');
    });
});
