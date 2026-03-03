<?php

use App\Http\Controllers\Candidate\CandidateProfileController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\JobController as AdminJobController;
use App\Http\Controllers\Admin\CompanyController as AdminCompanyController;
use App\Http\Controllers\Admin\CandidateController as AdminCandidateController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Candidate\CandidateDashboardController;
use App\Http\Controllers\Candidate\FavouriteJobController;
use App\Http\Controllers\Candidate\FollowingController;
use App\Http\Controllers\Candidate\JobAlertController;
use App\Http\Controllers\Candidate\ResumeController;
use App\Http\Controllers\Employer\CompanyProfileController;
use App\Http\Controllers\Employer\CvSearchController;
use App\Http\Controllers\Employer\DashboardController as EmployerDashboardController;
use App\Http\Controllers\Employer\FollowerController;
use App\Http\Controllers\web\AuthController;
use App\Http\Controllers\web\EmployerController;
use App\Http\Controllers\web\HomeController;
use App\Http\Controllers\web\JobApplicationController;
use App\Http\Controllers\web\MessageController;
use App\Http\Controllers\web\ActivityTrackerController;
use App\Http\Controllers\web\SitemapController;
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

Route::get('/', [HomeController::class, 'index'])->name('home');

use App\Http\Controllers\web\JobController;

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/jobs', [JobController::class, 'index'])->middleware('throttle:jobs-search')->name('jobs.index');
Route::get('/jobs/{slug}', [JobController::class, 'show'])->name('jobs.show');

Route::get('/employers', function () {
    return view('employers.index');
})->name('employers.index');

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

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'create'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'store'])
            ->middleware('throttle:admin-login')
            ->name('login.store');
    });

    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/jobs', [AdminJobController::class, 'index'])->name('jobs.index');
        Route::get('/jobs/{job}', [AdminJobController::class, 'show'])->name('jobs.show');
        Route::patch('/jobs/{job}/status', [AdminJobController::class, 'updateStatus'])->name('jobs.status');
        Route::delete('/jobs/{job}', [AdminJobController::class, 'destroy'])->name('jobs.destroy');
        Route::get('/companies', [AdminCompanyController::class, 'index'])->name('companies.index');
        Route::get('/companies/{company}', [AdminCompanyController::class, 'show'])->name('companies.show');
        Route::patch('/companies/{company}/status', [AdminCompanyController::class, 'updateStatus'])->name('companies.status');
        Route::patch('/companies/{company}/rating', [AdminCompanyController::class, 'updateRating'])->name('companies.rating');
        Route::patch('/companies/{company}/posting-balance', [AdminCompanyController::class, 'updatePostingBalance'])->name('companies.posting-balance');
        Route::get('/candidates', [AdminCandidateController::class, 'index'])->name('candidates.index');
        Route::patch('/candidates/{candidate}/status', [AdminCandidateController::class, 'updateStatus'])->name('candidates.status');
        Route::patch('/candidates/{candidate}/open-to-work', [AdminCandidateController::class, 'updateOpenToWork'])->name('candidates.open-to-work');
        Route::patch('/candidates/{candidate}/application-balance', [AdminCandidateController::class, 'updateApplicationBalance'])->name('candidates.application-balance');
        Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/export', [AdminReportController::class, 'export'])->name('reports.export');
        Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');
        Route::patch('/settings/default-balances', [AdminSettingController::class, 'updateDefaultBalances'])->name('settings.default-balances');
        Route::redirect('/setting', '/admin/settings');
        Route::redirect('/report', '/admin/reports');
        Route::post('/logout', [AdminAuthController::class, 'destroy'])->name('logout');
    });
});

Route::middleware('auth')->group(function () {
    Route::post('/activity/track', [ActivityTrackerController::class, 'store'])
        ->middleware('throttle:240,1')
        ->name('activity.track');

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('role:candidate')->prefix('candidate')->name('candidate.')->group(function () {

        Route::get('/dashboard', [CandidateDashboardController::class, 'index'])->name('dashboard');

        Route::get('/edit-profile', [CandidateProfileController::class, 'edit'])->name('edit-profile');
        Route::put('/edit-profile', [CandidateProfileController::class, 'update'])->name('edit-profile.update');
        Route::post('/edit-profile/photo', [CandidateProfileController::class, 'updatePhoto'])->name('edit-profile.photo');
        Route::post('/edit-profile/visibility', [CandidateProfileController::class, 'updateVisibility'])->name('edit-profile.visibility');
        Route::patch('/open-to-work', [CandidateProfileController::class, 'updateOpenToWork'])->name('open-to-work');

        Route::get('/applications', [JobApplicationController::class, 'index'])->name('applications');
        Route::post('/jobs/{job}/apply', [JobApplicationController::class, 'store'])->name('jobs.apply');
        Route::delete('/applications/{application}', [JobApplicationController::class, 'destroy'])->name('applications.destroy');
        Route::get('/favourites', [FavouriteJobController::class, 'index'])->name('favourites');
        Route::post('/jobs/{job}/favourite', [FavouriteJobController::class, 'store'])->name('jobs.favourite');
        Route::delete('/favourites/{job}', [FavouriteJobController::class, 'destroy'])->name('favourites.destroy');
        Route::get('/followings', [FollowingController::class, 'index'])->name('followings');
        Route::post('/followings/{employer}', [FollowingController::class, 'store'])->name('followings.store');
        Route::delete('/followings/{employer}', [FollowingController::class, 'destroy'])->name('followings.destroy');

        Route::get('/manage-resume', [ResumeController::class, 'manage'])->name('manage-resume');
        Route::get('/messages', [MessageController::class, 'candidateIndex'])->name('messages');
        Route::post('/messages/{conversation}', [MessageController::class, 'send'])->name('messages.send');
        Route::post('/jobs/{job}/contact-employer', [MessageController::class, 'contactEmployer'])->name('jobs.contact');

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
        Route::get('/dashboard', [EmployerDashboardController::class, 'index'])->name('dashboard');

        Route::get('/company-profile', [CompanyProfileController::class, 'edit'])->name('company-profile');
        Route::post('/profile/logo', [CompanyProfileController::class, 'updateLogo'])->name('profile.logo');
        Route::put('update-company-profile', [CompanyProfileController::class, 'update'])->name('profile.update');

        Route::get('/post-job', [App\Http\Controllers\Employer\JobController::class, 'create'])->name('post-job');
        Route::post('/post-job', [App\Http\Controllers\Employer\JobController::class, 'store'])->name('post-job.store');
        Route::get('/manage-jobs', [App\Http\Controllers\Employer\JobController::class, 'index'])->name('manage-jobs');
        Route::get('/cv-search', [CvSearchController::class, 'index'])->name('cv-search');
        Route::get('/jobs/{job}/edit', [App\Http\Controllers\Employer\JobController::class, 'edit'])->name('jobs.edit');
        Route::put('/jobs/{job}', [App\Http\Controllers\Employer\JobController::class, 'update'])->name('jobs.update');
        Route::post('/jobs/{job}/publish', [App\Http\Controllers\Employer\JobController::class, 'publish'])->name('jobs.publish');
        Route::post('/jobs/{job}/close', [App\Http\Controllers\Employer\JobController::class, 'close'])->name('jobs.close');
        Route::post('/jobs/{job}/reopen', [App\Http\Controllers\Employer\JobController::class, 'reopen'])->name('jobs.reopen');
        Route::delete('/jobs/{job}', [App\Http\Controllers\Employer\JobController::class, 'destroy'])->name('jobs.destroy');
        Route::get('/jobs/{job}/applications', [App\Http\Controllers\Employer\JobApplicationController::class, 'index'])->name('jobs.applications');
        Route::patch('/jobs/{job}/applications/{application}/status', [App\Http\Controllers\Employer\JobApplicationController::class, 'updateStatus'])->name('jobs.applications.status');
        Route::get('/jobs/{job}/applications/{application}/resume', [App\Http\Controllers\Employer\JobApplicationController::class, 'viewResume'])->name('jobs.applications.resume');
        Route::get('/messages', [MessageController::class, 'employerIndex'])->name('messages');
        Route::post('/messages/{conversation}', [MessageController::class, 'send'])->name('messages.send');
        Route::post('/messages/candidate/{candidate}', [MessageController::class, 'startWithCandidate'])->name('messages.start-candidate');
        Route::get('/followers', [FollowerController::class, 'index'])->name('followers');
    });
});
