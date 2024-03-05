<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CmsPageController;
use App\Models\Admin;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'admin'], function () {
    Route::get('login', function () {
        return view('admin.login.login');
    })->name('admin.login');
    Route::post('login', [AdminController::class, 'login'])->name('admin.login');

    //admin middleware group route
    Route::group(['middleware' => 'admin'], function () {
        Route::get('dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('logout', [AdminController::class, 'logout'])->name('admin.logout');
        Route::get('update-password', function () {
            //session put for live page
            Session::put('page', 'update-password');
            return view('admin.update_password');
        })->name('update.passwrd');
        Route::post('check-current-password', [AdminController::class, 'checkCurrentPassword'])->name('check.current.password');
        Route::post('update-password', [AdminController::class, 'updatePassword'])->name('update.password');
        Route::get('update-details', function () {
            //session put for live page
            Session::put('page', 'update-details');
            return view('admin.update_details');
        });
        Route::post('update-admin-details', [AdminController::class, 'updateDetails'])->name('update.details');

        //cms pages route
        Route::get('cms-pages', [CmsPageController::class, 'index'])->name('cmsPages.index');
        Route::get('cms-page-create', [CmsPageController::class, 'create'])->name('cmsPage.create');
        Route::post('cms-page-store', [CmsPageController::class, 'store'])->name('cmsPage.store');
        Route::post('update-cms-page-status', [CmsPageController::class, 'update']);
        Route::get('cms-page-delete/{id}', [CmsPageController::class, 'destroy'])->name('cmsPage.delete');
        Route::get('cms-page-update/{id}', [CmsPageController::class, 'show'])->name('cmsPage.show');
        Route::post('cms-page-update/{id}', [CmsPageController::class, 'edit'])->name('cmsPage.edit');

        //subadmin
        Route::get('subadmin', [AdminController::class, 'subadminIndex'])->name('subadmin');
        Route::get('subadmin-create', [AdminController::class, 'subadminCreate'])->name('subadmin.create');
        Route::post('subadmin-store', [AdminController::class, 'subadminStore'])->name('subadmin.store');
        Route::post('update-subadmin-status', [AdminController::class, 'subadminStatus'])->name('subadmin.status');
        Route::get('subadmin-delete/{id}', [AdminController::class, 'subadminDestry'])->name('subadmin.delete');
        Route::get('subadmin-update/{id}', [AdminController::class, 'subadminShow'])->name('subadmin.show');
        Route::post('subadmin-update/{id}', [AdminController::class, 'subadminEdit'])->name('subadmin.edit');
    });
});
