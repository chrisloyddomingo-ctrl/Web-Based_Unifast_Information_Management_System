<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ApplicationViewController;
use App\Http\Controllers\GranteeListController;
use App\Http\Controllers\ApplicationStatusController;
use App\Http\Controllers\StudentAuthController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\MyAccountController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StudentAccountController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\GranteePrintController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| PUBLIC APPLICATION ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/apply/options', function () {
    return view('apply.options');
})->name('apply.options');
Route::get('/apply', [ApplicationController::class, 'create'])->name('apply.create');
Route::post('/apply', [ApplicationController::class, 'store'])->name('apply.store');
Route::get('/apply/tdp', function () {
    return view('apply.tdp_create');
})->name('apply.tdp.create');
Route::get('/apply/submitted', [ApplicationController::class, 'submitted'])->name('apply.submitted');

Route::get('/application/status', [ApplicationStatusController::class, 'index'])
    ->name('application.status');

/*
|--------------------------------------------------------------------------
| STUDENT AUTH ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('student')->group(function () {
    Route::get('/login', [StudentAuthController::class, 'showLogin'])->name('student.login');
    Route::post('/login', [StudentAuthController::class, 'login'])->name('student.login.submit');
    Route::post('/logout', [StudentAuthController::class, 'logout'])->name('student.logout');

    Route::middleware('auth:student')->group(function () {
        Route::get('/dashboard', [StudentDashboardController::class, 'index'])
            ->name('student.dashboard');
    });
});

/*
|--------------------------------------------------------------------------
| ADMIN SEEDER ROUTE
|--------------------------------------------------------------------------
|
| Visit /seed-admin to create the default admin account. This route is
| only active when no users exist in the database, ensuring it cannot
| be used to overwrite an existing setup.
|
*/

Route::get('/seed-admin', function () {
    if (\App\Models\TblUser::count() > 0) {
        return response()->json([
            'message' => 'Seeding skipped: users already exist in the database.',
        ], 403);
    }

    (new AdminUserSeeder())->run();

    return response()->json([
        'message'  => 'Admin user seeded successfully.',
        'email'    => 'admin@unifast.com',
        'password' => 'Admin@1234',
        'note'     => 'Please change the default password immediately after logging in.',
    ], 201);
});

/*
|--------------------------------------------------------------------------
| DEFAULT LARAVEL AUTH
|--------------------------------------------------------------------------
|
| Included here:
| - login
| - logout
| - register
| - forgot password
| - reset password
|
*/

Auth::routes();

/*
|--------------------------------------------------------------------------
| ADMIN AUTH ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Post Management
    Route::get('/post_management_pagination', [HomeController::class, 'post_management_pagination'])
        ->name('post_management_pagination');

    /*
    |--------------------------------------------------------------------------
    | APPLICATION MANAGEMENT
    |--------------------------------------------------------------------------
    */
    Route::get('/applications', [ApplicationViewController::class, 'index'])->name('applications.index');
    Route::post('/applications/store', [ApplicationViewController::class, 'store'])->name('applications.store');
    Route::get('/applications/{id}/edit', [ApplicationViewController::class, 'edit'])->name('applications.edit');
    Route::get('/applications/{id}/show', [ApplicationViewController::class, 'show'])->name('applications.show');
    Route::post('/applications/update', [ApplicationViewController::class, 'update'])->name('applications.update');
    Route::post('/applications/destroy', [ApplicationViewController::class, 'destroy'])->name('applications.destroy');
    Route::get('/applications/export/excel', [ApplicationViewController::class, 'exportExcel'])->name('applications.export.excel');

    /*
    |--------------------------------------------------------------------------
    | APPROVE / REJECT
    |--------------------------------------------------------------------------
    */
    Route::post('/applications/approve', [ApplicationViewController::class, 'approve'])
        ->name('applications.approve');

    Route::post('/applications/reject', [ApplicationViewController::class, 'reject'])
        ->name('applications.reject');

    /*
    |--------------------------------------------------------------------------
    | OTHER ADMIN PAGES
    |--------------------------------------------------------------------------
    */
    Route::get('/registration_pagination', [HomeController::class, 'registration_pagination'])
        ->name('registration_pagination');

    Route::get('/fileupload_pagination', [HomeController::class, 'fileupload_pagination'])
        ->name('fileupload_pagination');

    Route::post('/users/store', [HomeController::class, 'store'])->name('home.users.store');

    // Grantees List
    Route::get('/grantees', [GranteeListController::class, 'index'])->name('grantees.index');

    /*
    |--------------------------------------------------------------------------
    | ACCOUNT SETTINGS
    |--------------------------------------------------------------------------
    */
    Route::get('/security-settings', function () {
        return view('security-settings');
    })->name('security.settings');

    Route::get('/my-account', [MyAccountController::class, 'view'])->name('myaccount.view');
    Route::get('/my-account/edit', [MyAccountController::class, 'edit'])->name('myaccount.edit');
    Route::put('/my-account', [MyAccountController::class, 'update'])->name('myaccount.update');
    Route::get('/my-account/deactivate', [MyAccountController::class, 'deactivate'])->name('myaccount.deactivate');
    Route::delete('/my-account', [MyAccountController::class, 'destroy'])->name('myaccount.destroy');
    Route::put('/myaccount/password/update', [MyAccountController::class, 'updatePassword'])
        ->name('myaccount.password.update');

    /*
    |--------------------------------------------------------------------------
    | ADMIN USER MANAGEMENT
    |--------------------------------------------------------------------------
    */
    Route::middleware('admin')->group(function () {
        Route::resource('users', UserController::class);
    });

    /*
    |--------------------------------------------------------------------------
    | APPROVED / REJECTED LIST
    |--------------------------------------------------------------------------
    */
    Route::get('/approve_list/approved', [ApplicationViewController::class, 'approved'])
        ->name('approve_list.approved');

    Route::get('/approve_list/rejected', [ApplicationViewController::class, 'rejected'])
        ->name('approve_list.rejected');

    /*
    |--------------------------------------------------------------------------
    | ATTENDANCE
    |--------------------------------------------------------------------------
    */
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance/store-event', [AttendanceController::class, 'storeEvent'])->name('attendance.storeEvent');
    Route::get('/attendance/event/{id}', [AttendanceController::class, 'showEvent'])->name('attendance.showEvent');
    Route::post('/attendance/event/{id}/scan', [AttendanceController::class, 'processScan'])->name('attendance.processScan');
    Route::get('/test-scan/{value}', [AttendanceController::class, 'testScan'])->name('attendance.testScan');
    Route::get('/attendance/scan', [AttendanceController::class, 'scanPage'])->name('attendance.scan');
    Route::get('/attendance/event/{id}/edit', [AttendanceController::class, 'editEvent'])->name('attendance.editEvent');
    Route::put('/attendance/event/{id}', [AttendanceController::class, 'updateEvent'])->name('attendance.updateEvent');
    Route::delete('/attendance/event/{id}', [AttendanceController::class, 'deleteEvent'])->name('attendance.deleteEvent');
    Route::get('/attendance/event/{id}/export', [AttendanceController::class, 'export'])->name('attendance.export');
    Route::get('/attendance/{event}/print', [AttendanceController::class, 'print'])->name('attendance.print');
    Route::post('/attendance/{event}/time-in', [AttendanceController::class, 'timeIn'])->name('attendance.timein');
    Route::post('/attendance/{event}/time-out', [AttendanceController::class, 'timeOut'])->name('attendance.timeout');

    /*
    |--------------------------------------------------------------------------
    | REPORTS
    |--------------------------------------------------------------------------
    */
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportsController::class, 'index'])->name('index');
        Route::get('/grantees', [ReportsController::class, 'grantees'])->name('grantees');
        Route::get('/outstanding', [ReportsController::class, 'outstanding'])->name('outstanding');
        Route::get('/disbursement', [ReportsController::class, 'disbursement'])->name('disbursement');
        Route::get('/attendance', [ReportsController::class, 'attendance'])->name('attendance');
        Route::get('/pwd', [ReportsController::class, 'pwd'])->name('pwd');
        Route::get('/parents-income', [ReportsController::class, 'parentsIncome'])->name('parents_income');
        Route::get('/generation', [ReportsController::class, 'generation'])->name('generation');
    });

    /*
    |--------------------------------------------------------------------------
    | GRANTEE LIST
    |--------------------------------------------------------------------------
    */
    Route::get('/grantees/new', [GranteeListController::class, 'newGrantees'])
        ->name('granteelist.newgrantees');

    Route::post('/grantees/import', [GranteeListController::class, 'import'])
        ->name('grantees.import');

    Route::resource('grantees', GranteeListController::class);

    /*
    |--------------------------------------------------------------------------
    | STUDENT PROFILE
    |--------------------------------------------------------------------------
    */
    Route::get('/student/auth/profile', function () {
        return view('student.auth.profile');
    })->name('student.auth.profile');

    /*
    |--------------------------------------------------------------------------
    | STUDENT ACCOUNT MANAGEMENT
    |--------------------------------------------------------------------------
    */
    Route::prefix('student')->group(function () {
        Route::get('/account/view', [StudentAccountController::class, 'view'])->name('student.account.view');
        Route::get('/account/edit', [StudentAccountController::class, 'edit'])->name('student.account.edit');
        Route::post('/account/update', [StudentAccountController::class, 'update'])->name('student.account.update');
        Route::get('/account/deactivate', [StudentAccountController::class, 'deactivateForm'])->name('student.account.deactivate.form');
        Route::post('/account/deactivate', [StudentAccountController::class, 'deactivate'])->name('student.account.deactivate');
    });

    /*
    |--------------------------------------------------------------------------
    | SEMESTER MANAGEMENT
    |--------------------------------------------------------------------------
    */
    Route::get('/semesters', [SemesterController::class, 'index'])->name('semesters.index');

    Route::get('/semesters/create', [SemesterController::class, 'create'])->name('semesters.create');

    Route::post('/semesters', [SemesterController::class, 'store'])->name('semesters.store');

    Route::get('/semesters/{id}/edit', [SemesterController::class, 'edit'])->name('semesters.edit');

    Route::put('/semesters/{id}', [SemesterController::class, 'update'])->name('semesters.update');

    Route::delete('/semesters/{id}', [SemesterController::class, 'destroy'])->name('semesters.destroy');

    Route::post('/semesters/{id}/set-current', [SemesterController::class, 'setCurrent'])->name('semesters.setCurrent');

    Route::post('/semesters/{id}/open-application', [SemesterController::class, 'openApplication'])->name('semesters.openApplication');

    Route::post('/semesters/{id}/close-application', [SemesterController::class, 'closeApplication'])->name('semesters.closeApplication');

    Route::post('/semesters/{id}/set-viewing', [SemesterController::class, 'setViewing'])->name('semesters.setViewing');

    /*
    |-------------------------------------------------------------------------- |
    | LOGOUT ROUTE
    |-------------------------------------------------------------------------- |
    */
    Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    })->name('logout');


    /*    
    |--------------------------------------------------------------------------
    | GRANTEE PRINT PREVIEW
    |-------------------------------------------------------------------------- 
    */  
    Route::post('/grantees/print-preview', [GranteePrintController::class, 'printPreview'])
        ->name('grantees.print.preview');

    /*
    |--------------------------------------------------------------------------
    | BILL STATEMENT
    |--------------------------------------------------------------------------
    */
    Route::get('/disbursement', function () {
        return view('billstatement.bill_statement');
    })->name('disbursement');    
});