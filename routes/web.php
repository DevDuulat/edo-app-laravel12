<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DocumentTemplateController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\OcrController;
use App\Http\Controllers\SsoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkflowController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/home', function () {
    return redirect()->route('login');
})->name('home');
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    Route::get('settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});
    Route::get('/sso/callback', [SsoController::class, 'callback']);
    Route::get('/sso/base', [SsoController::class, 'handleRedirect'])->name('sso.base');

    Route::middleware(['auth'])->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('admin.user.index');


   Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
//       Route::resource('departments', DepartmentController::class)
//        ->middleware('permission:edo-hr-department');
       Route::resource('departments', DepartmentController::class);
       Route::resource('employees', EmployeeController::class);
       Route::resource('folders', FolderController::class);
       Route::resource('documents', DocumentController::class);
       Route::resource('workflows', WorkflowController::class);
       Route::resource('categories', CategoryController::class);
       Route::get('/outgoing/workflows', [WorkflowController::class, 'outgoing'])->name('outgoing.workflows');
       Route::get('/incoming/workflows', [WorkflowController::class, 'incoming'])->name('incoming.workflows');
       Route::post('/workflows/{workflow}/approve', [WorkflowController::class, 'approve'])->name('workflows.approve');
       Route::post('/workflows/{workflow}/reject', [WorkflowController::class, 'reject'])->name('workflows.reject');
       Route::post('/workflows/{workflow}/redirect', [WorkflowController::class, 'redirect'])->name('workflows.redirect');
       Route::post('/workflows/{workflow}/execute', [WorkflowController::class, 'execute'])->name('workflows.execute');
       Route::post('/workflows/{workflow}/comments', [WorkflowController::class, 'storeComment'])->name('workflows.comment.store');
       Route::resource('document-templates', DocumentTemplateController::class);
//       Route::post('/workflow', [WorkflowController::class, 'store'])->name('workflow.store');
       Route::get('departments/{department}/employees', [EmployeeController::class, 'byDepartment'])
        ->name('employees.byDepartment');

   });

    //debug
    Route::view('/test-page', 'test-page');
    Route::get('/ocr', [OcrController::class, 'index'])->name('ocr.index');
    Route::post('/ocr', [OcrController::class, 'process'])->name('ocr.process');
    });
require __DIR__.'/auth.php';

