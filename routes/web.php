<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EntrepriseController;
use App\Http\Controllers\Admin\InternController as AdminInternController;
use App\Http\Controllers\Admin\JobsController;
use App\Http\Controllers\Admin\LevelController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\SchoolController;
use App\Http\Controllers\Admin\SecurityObjectController;
use App\Http\Controllers\Admin\SecurityPermissionController;
use App\Http\Controllers\Admin\SecurityRoleController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Front\InternController;
use App\Http\Controllers\Front\WelcomeController;
use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
| Frontend
*/

//home

Route::get('logout',  function () {
    Auth::logout();

    return redirect('home');
});

Route::get('503', function () {
    return 'Accès non autorisé';
});

Route::get('404', function () {
    return 'Page non trouvée';
});
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/profil');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::get('/email/verify', function () {
    return redirect('/profil')->with('error', "Vous devez verifier votre email pour accéder à cette page.");
})->middleware('auth')->name('verification.notice');

Route::get('/email/verification-notification', function () {
    $user = User::find(auth()->user()->id);
    $user->sendEmailVerificationNotification();

    return back()->with('success', 'Le lien de vérification a été envoyé. Consultez votre boîte mail (les spams également) pour valider votre email.');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


Route::middleware('auth')->group(function () {


    Route::get('/', [WelcomeController::class, 'add'])->name('home');

    //profil
    Route::get('/profil', [WelcomeController::class, 'profil'])->name('profil');
    Route::get('/user/{user}', [WelcomeController::class, 'edit'])->name('edit-user');
    Route::post('/user/{user}', [WelcomeController::class, 'update'])->name('update-user');
});

/*
| Backend
*/
Route::prefix('admin')->namespace('Admin')->middleware('admin')->group(function () {

    //dashboard
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('admin-dashboard');
    Route::get('/', [DashboardController::class, 'dashboard']);
    Route::get('/notifications', [DashboardController::class, 'notifications']);

    //users
    Route::get('/admin-profil', [UserController::class, 'profil'])->name('admin-profil');
    Route::get('/list-admins', [UserController::class, 'admins']);
    Route::get('/list-agents', [UserController::class, 'agents']);
    Route::get('/add-user', [UserController::class, 'add']);
    Route::post('/create-user', [UserController::class, 'create']);
    Route::post('/update-user/{user}', [UserController::class, 'update']);

    //role
    Route::get('security-role', [SecurityRoleController::class, 'index']);
    Route::get('security-role/delete/{_id}', [SecurityRoleController::class, 'delete']);
    Route::post('security-role', [SecurityRoleController::class, 'save']);
    Route::get('security-role/edit/{_id}', [SecurityRoleController::class, 'edit']);

    Route::get('security-object', [SecurityObjectController::class, 'index']);
    Route::get('security-object/delete/{_id}', [SecurityObjectController::class, 'delete']);
    Route::post('security-object', [SecurityObjectController::class, 'save']);
    Route::get('security-object/edit/{_id}', [SecurityObjectController::class, 'edit']);

    Route::get('security-permission', [SecurityPermissionController::class, 'index']);
    Route::get('security-permission/delete/{_id}', [SecurityPermissionController::class, 'delete']);
    Route::post('security-permission', [SecurityPermissionController::class, 'save']);
    Route::post('security-permission/edit/{_id}', [SecurityRoleController::class, 'permission']);
});
