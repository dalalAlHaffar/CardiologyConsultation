<?php

use App\Http\Controllers\Cms\BlogController;
use App\Http\Controllers\Cms\CategoryController;
use App\Http\Controllers\Cms\ConsoluteController as CmsConsoluteController;
use App\Http\Controllers\Cms\DashboardController;
use App\Http\Controllers\Cms\UserController;
use App\Http\Controllers\Web\BlogController as WebBlogController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\ConsoluteController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
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

Route::get('/', [HomeController::class, 'index']);
Route::get('/categories', [HomeController::class, 'selectData']);
Route::get('/web/blog/{id}', [WebBlogController::class, 'details']);

Route::group([
    'prefix' => 'web',
    'middleware' => ['auth'],
], function () {
    Route::resource('consolute', ConsoluteController::class);
    Route::post('/blog/comment/add', [WebBlogController::class, 'addComment']);
});

Route::group([
    'prefix' => 'cms',
    'middleware' => ['auth', 'isAdmin'],
], function () {
    Route::resource('dashBoard', DashboardController::class)->only(['index']);

    Route::resource('blog', BlogController::class);
    Route::get('blogs/data', [BlogController::class, 'indexData'])->name('cms.blogs.data');

    Route::resource('user', UserController::class);
    Route::get('users/data', [UserController::class, 'indexData'])->name('cms.users.data');

    Route::resource('category', CategoryController::class);
    Route::get('categories/data', [CategoryController::class, 'indexData'])->name('cms.categories.data');
    Route::get('categories/select', [CategoryController::class, 'selectData']);

    Route::resource('consolute', CmsConsoluteController::class)->only(['index','edit','update']);
    Route::get('consulates/data', [CmsConsoluteController::class, 'indexData'])->name('cms.consulates.data');


});

Auth::routes();
Route::get('/email/verify', function () {
    return view('auth.verify');
})->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
