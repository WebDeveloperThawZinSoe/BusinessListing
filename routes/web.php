<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RouteCheckController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Auth;

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



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function(){
        return redirect("/route/check");
    })->name('dashboard');
});


Route::get("/route/check", [RouteCheckController::class, 'check'])->name("routeCheck");

// Route::middleware(['role:admin'])->group(function () {
//     Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
//     // Other admin routes
// });

// Route::middleware(['role:shop'])->group(function () {
//     Route::get('/shop/dashboard', [ShopController::class, 'dashboard']);
//     // Other shop routes
// });

// Route::middleware(['role:user'])->group(function () {
//     Route::get('/user/dashboard', [UserController::class, 'dashboard']);
//     // Other user routes
// });


Route::get("/",[PageController::class, 'index'])->name("home");
Route::get("/category/{slug}",[PageController::class, 'categoryDetail'])->name("categoryDetail");
Route::get("/regions",[PageController::class,"regions"])->name("region");
Route::get("/region/{slug}",[PageController::class,"regionDetail"])->name("regionDetail");
Route::get("/products",[PageController::class,"products"])->name("products");
Route::get("/shops",[PageController::class,"shops"])->name("shops");
Route::get("/shop/{slug}",[PageController::class,"shopDetail"])->name("shop");
Route::get("/faq",[PageController::class,"faq"])->name("faq");
Route::get("/contact",[PageController::class,"contact"])->name("contact");


Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');