<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CmsPageController;
use App\Http\Controllers\Admin\ProductController;
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
        //cms pages route end

        //subadmin
        Route::get('subadmin', [AdminController::class, 'subadminIndex'])->name('subadmin');
        Route::get('subadmin-create', [AdminController::class, 'subadminCreate'])->name('subadmin.create');
        Route::post('subadmin-store', [AdminController::class, 'subadminStore'])->name('subadmin.store');
        Route::post('update-subadmin-status', [AdminController::class, 'subadminStatus'])->name('subadmin.status');
        Route::get('subadmin-delete/{id}', [AdminController::class, 'subadminDestry'])->name('subadmin.delete');
        Route::get('subadmin-update/{id}', [AdminController::class, 'subadminShow'])->name('subadmin.show');
        Route::post('subadmin-update/{id}', [AdminController::class, 'subadminEdit'])->name('subadmin.edit');
        Route::get('subadmin-role-view/{id}', [AdminController::class, 'subadminPermisionView'])->name('subadminpermision.view');
        Route::post('subadmin-role-update/{id}', [AdminController::class, 'subadminPermisionGive'])->name('subadminpermision.give');
        //delete brand image
        Route::get('subadmin-image-delete/{id}', [AdminController::class, 'subadminImageDelete'])->name('subadmin.image.delete');
        //subadmin end


        //Categories route
        Route::get('category', [CategoryController::class, 'categories'])->name('category');
        Route::get('category-create', [CategoryController::class, 'categoryCreate'])->name('category.create');
        Route::post('category-store', [CategoryController::class, 'categoryStore'])->name('category.store');
        Route::get('category-update/{id}', [CategoryController::class, 'categoryShow'])->name('category.show');
        Route::post('category-update/{id}', [CategoryController::class, 'categoryEdit'])->name('category.edit');
        Route::post('update-category-status', [CategoryController::class, 'categoriesStatus'])->name('categories.status');
        Route::get('category-delete/{id}', [CategoryController::class, 'categoryDestry'])->name('category.delete');
        //delete category image
        Route::get('category-image-delete/{id}', [CategoryController::class, 'categoryImageDelete'])->name('category.image.delete');
        //Categories route end

        //Product route
        Route::get('product', [ProductController::class, 'product'])->name('product.index');
        Route::get('product-create', [ProductController::class, 'productCreate'])->name('product.create');
        Route::post('product-store', [ProductController::class, 'productStore'])->name('product.store');
        Route::get('product-update/{id}', [ProductController::class, 'productShow'])->name('product.show');
        Route::post('product-update/{id}', [ProductController::class, 'productEdit'])->name('product.edit');
        Route::post('update-product-status', [ProductController::class, 'productStatus'])->name('product.status');
        Route::get('product-delete/{id}', [ProductController::class, 'productDestry'])->name('product.delete');
        //delete product vodeo
        Route::get('product-video-delete/{id}', [ProductController::class, 'productVideoDelete'])->name('product.video.delete');
        //delete product image
        Route::get('product-image-delete/{id}', [ProductController::class, 'productImageDelete'])->name('product.image.delete');
        //delete product attrubute
        Route::get('product-attribute-delete/{id}', [ProductController::class, 'productAttributeDelete'])->name('product.attribute.delete');
        //update product attribute status
        Route::post('update-product-attribute-status', [ProductController::class, 'productAttributeStatus'])->name('product.attribute.status');
        //Product route end


        //Brand Route Start
        Route::get('brand', [BrandController::class, 'brand'])->name('brand.index');
        Route::get('brand-create', [BrandController::class, 'brandCreate'])->name('brand.create');
        Route::post('brand-store', [BrandController::class, 'brandStore'])->name('brand.store');
        Route::get('brand-update/{id}', [BrandController::class, 'brandShow'])->name('brand.show');
        Route::post('brand-update/{id}', [BrandController::class, 'brandEdit'])->name('brand.edit');
        Route::get('brand-delete/{id}', [BrandController::class, 'brandDestry'])->name('brand.delete');
        Route::post('update-barnd-status', [BrandController::class, 'brandStatus'])->name('brand.status');
        //delete brand image
        Route::get('brand-image-delete/{id}', [BrandController::class, 'brandImageDelete'])->name('brand.image.delete');
        //delete brand logo
        Route::get('brand-logo-delete/{id}', [BrandController::class, 'brandLogoDelete'])->name('brand.logo.delete');
        //Brand Route end

        //Banners route start
        Route::get('banner', [BannerController::class, 'banners'])->name('banner.index');
        Route::get('banner-create', [BannerController::class, 'bannerCreate'])->name('banner.create');
        Route::post('banner-store', [BannerController::class, 'bannerStore'])->name('banner.store');
        Route::get('banner-update/{id}', [BannerController::class, 'bannerShow'])->name('banner.show');
        Route::post('banner-update/{id}', [BannerController::class, 'bannerEdit'])->name('banner.edit');
        Route::get('banner-delete/{id}', [BannerController::class, 'bannerDestry'])->name('banner.delete');
        Route::post('update-banner-status', [BannerController::class, 'bannerStatus'])->name('banner.status');

        //delete banner image
        Route::get('banner-image-delete/{id}', [BannerController::class, 'bannerImageDelete'])->name('banner.image.delete');
        //Banners route end
    });
});
