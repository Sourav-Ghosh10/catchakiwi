<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\AdsController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CustomAuthenticatedSessionController;
use App\Http\Controllers\Admin\AdminBusinessController;
use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ChatController;
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

// Route::get('/', function () {
//     return view('frontend/home');
// });
Route::get('/', [UserController::class, 'Home'])->name('/'); 

Route::get('/terms-and-condition', function () {
    return view('frontend/terms-condition');
});
Route::get('/privercy-policy', function () {
    return view('frontend/privercy-policy');
});
// Route::get('/contact-us', function () {
//     return view('frontend/contact-us');
// });
Route::get('contact-us', [UserController::class, 'contactUs'])->name('contact-us');

Route::get('test', [UserController::class, 'test'])->name('test');

Route::get('admin', function () {
    return view('admin/login');
});
Route::post('/login/submit', [AdminController::class, 'login'])->name('admin.login.submit');

// Route::get('admin/dashboard', function () {
//     return view('admin.login');
// })->middleware('admin')->name('admin.dashboard');
Route::get('/admin-logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/admin');
})->name('admin.logout');
Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
    // Your admin routes here
  	Route::get('/notifications', [AdminController::class, 'notificationIndex'])->name('notifications.index');
	Route::get('/notification/create', [AdminController::class, 'notificationCreate'])->name('notification.create');
    Route::post('/notification/send', [AdminController::class, 'sendNotification'])->name('notification.send');
    Route::post('/notification/subcategories', [AdminController::class, 'getSubcategories'])->name('notification.subcategories');
    Route::post('/notification/users', [AdminController::class, 'getUsersByCategories'])->name('notification.users');
    Route::get('/notifications/{notification}', [AdminController::class, 'notificationShow'])->name('notifications.show');
  	Route::post('/notification/users', [AdminController::class, 'getUsers'])->name('notification.users');
    Route::get('/email-change-requests', [AdminController::class, 'emailChange'])->name('email-change-requests');

    Route::post('/email-change/{user}/approve', [AdminController::class, 'emailChangeapprove'])->name('email-change.approve');

    Route::post('/email-change/{user}/reject', [AdminController::class, 'emailChangereject'])->name('email-change.reject');

    Route::get('dashboard', [AdminController::class, 'dashBoard'])->name('dashboard');
    Route::get('users', [AdminController::class, 'userDetails'])->name('userdetails');
    Route::get('userlist', [AdminController::class, 'userList'])->name('userlist');
    Route::get('/users/{id}/edit', [AdminController::class, 'useredit'])->name('users.edit');
    Route::put('/users/{id}', [AdminController::class, 'userUpdate'])->name('users.update');
    Route::get('/admin/users/change-status/{id}', [AdminController::class, 'changeStatus'])->name('users.change-status');
   	Route::post('/users/businesses', [AdminBusinessController::class, 'getUserBusinesses'])
        ->name('users.businesses');
    // Other admin routes...
    //Route::resource('ads', AdsController::class);

    Route::resource('ads', AdsController::class)->names([
        'index' => 'ads.index',
        'create' => 'ads.create',
        'store' => 'ads.store',
        'show' => 'ads.show',
        'edit' => 'ads.edit',
        'update' => 'ads.update',
        'destroy' => 'ads.destroy',
    ]);

    Route::get('/locations', [LocationController::class, 'index'])->name('locations.index');
    Route::get('/locations/get-states/{countryId}', [LocationController::class, 'getStatesByCountry']);
    Route::get('/locations/get-cities/{stateId}', [LocationController::class, 'getCitiesByState']);
    Route::get('/locations/get-towns/{cityId}', [LocationController::class, 'getTownsByCity']);
    Route::put('/locations/update', [LocationController::class, 'update']);
    Route::put('/locations/add', [LocationController::class, 'add']);
    Route::post('/locations/city-delete', [LocationController::class, 'Delete']);
  
  	Route::prefix('businesses')->name('businesses.')->group(function () {
        Route::get('/', [AdminBusinessController::class, 'index'])->name('index');
        Route::get('/edit/{id}', [AdminBusinessController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [AdminBusinessController::class, 'update'])->name('update');
        Route::get('/change-status/{id}', [AdminBusinessController::class, 'changeStatus'])->name('change-status');
    });
  	Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // Article Management
    Route::resource('article-categories', \App\Http\Controllers\Admin\ArticleCategoryController::class)->names('article-categories');
    Route::get('articles', [\App\Http\Controllers\Admin\ArticleController::class, 'index'])->name('articles.index');
    Route::get('articles/{id}/edit', [\App\Http\Controllers\Admin\ArticleController::class, 'edit'])->name('articles.edit');
    Route::put('articles/{id}', [\App\Http\Controllers\Admin\ArticleController::class, 'update'])->name('articles.update');
    Route::get('articles/status/{id}/{status}', [\App\Http\Controllers\Admin\ArticleController::class, 'changeStatus'])->name('articles.status');
});
/*
---------------------------------------------------------------------
FRONTEND CONTROLLER BEGIN
---------------------------------------------------------------------
*/
Route::post('/login', [CustomAuthenticatedSessionController::class, 'store']);

Route::get('/notice-board', [NoticeController::class, 'noticeBoard'])->name('notice-board');
Route::get('/notices', [NoticeController::class, 'noticeBoardV2'])->name('notices');

Route::get('/get-a-quote', [BusinessController::class, 'getaQuote'])->name('get-a-quote');
Route::get('/{country}/business', [BusinessController::class, 'list']);
Route::get('/{country}/business/search', [UserController::class, 'Search'])->name('search'); 
Route::get('/{country}/business/{primary}/{secondary}', [BusinessController::class, 'CategoryWiseList']);
Route::get('/{country}/business/{primary}', [BusinessController::class, 'CategoryWiseList']);
Route::post('/business/reviewsub', [BusinessController::class, 'reviewSub'])->name('business.reviewsub');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::get('/add-your-business', [BusinessController::class, 'addYourBusiness'])->name('add-your-business'); 
    Route::post('/business/list/insert', [BusinessController::class, 'listInsert'])->name('business.list.insert');
    Route::get('/business/edit/{id}', [BusinessController::class, 'businessEdit'])->name('business.list.edit');
    Route::put('/business/update/{id}', [BusinessController::class, 'businessUpdate'])->name('business.list.update');
    Route::delete('/business/delete/{id}', [BusinessController::class, 'businessDelete'])->name('business.list.delete');
    Route::post('/business/update-status', [BusinessController::class, 'changeStatus'])->name('business.update-status');

    
    Route::get('/notice-post', [UserController::class, 'Notice'])->name('notice-post');
    Route::post('/notice-submit', [UserController::class, 'NoticePost'])->name('notice-submit');

    Route::post('/store/profilebanner', [UserController::class, 'StoreProfileBanner'])->name('store.profilebanner');
    Route::post('/store/profilepic', [UserController::class, 'StoreProfilePic'])->name('store.profilepic');
    Route::post('/store/aboutus', [UserController::class, 'StoreAboutusr'])->name('store.aboutus');
});

//$business = DB::table('business')->join('countries','countries.id','=','business.country')->get();
// if(!empty($business)){
//     foreach($business as $busi){
Route::get('/{country}/business/{primary}/{secondary}/{slug}', [BusinessController::class, 'details']);
Route::get('/{country}/business/{cat}/{subcat}/{slug}/print', [BusinessController::class, 'businessPrint']);
Route::get('/{country}/profile/{user_id}', [BusinessController::class, 'businessProfile']);
//     }
// }


Route::get('/business/category', [BusinessController::class, 'category']);
Route::get('/article/list', [ArticleController::class, 'list'])->name('article.list');
Route::get('/article/add', [ArticleController::class, 'add'])->middleware('auth')->name('article.add');
Route::post('/article/store', [ArticleController::class, 'store'])->middleware('auth')->name('article.store');
Route::get('/article/{slug}', [ArticleController::class, 'details'])->name('article.details');
Route::get('/article/category/{slug}', [ArticleController::class, 'categoryList'])->name('article.category');
Route::get('/my-articles', [ArticleController::class, 'myArticles'])->middleware('auth')->name('article.my-articles');
Route::get('/article/edit/{id}', [ArticleController::class, 'userEdit'])->middleware('auth')->name('article.user-edit');
Route::post('/article/update/{id}', [ArticleController::class, 'userUpdate'])->middleware('auth')->name('article.user-update');
Route::delete('/article/delete/{id}', [ArticleController::class, 'userDelete'])->middleware('auth')->name('article.user-delete');
Route::post('/article/{article_id}/comment', [ArticleController::class, 'postComment'])->middleware('auth')->name('article.comment');

Route::get('register', [UserController::class, 'Register'])->name('register');
Route::match(['get', 'post'], 'logout', [UserController::class, 'Logout'])->name('logout');

Route::post('getCityState', [UserController::class, 'GetCityState'])->name('GetCityState');
Route::post('GetCityStatesameVal', [UserController::class, 'GetCityStatesameVal'])->name('GetCityStatesameVal');

Route::post('getCitystateforselectsize', [UserController::class, 'getCitystateForSelectsize'])->name('getCitystateforselectsize');

Route::post('getstateforselectsize', [UserController::class, 'getStateForSelectsize'])->name('getstateforselectsize');


Route::get('changecountry', [UserController::class, 'changeCountry'])->name('changecountry');

// Moved to auth group above

Route::post('contact-us', [UserController::class, 'contactUsSub'])->name('contact-us');
/*
-----------------------------------------------------------------------------
AJAX CALL
-----------------------------------------------------------------------------
*/
Route::post('/ajaxcontroller/district', [AjaxController::class, 'GetRegionDistrict']);
Route::post('/ajaxcontroller/getsuburbs', [AjaxController::class, 'GetSuburbs']);
Route::post('/ajaxcontroller/getsubcat', [AjaxController::class, 'GetSubcat']);

Route::post('/profile/update', [UserController::class, 'updateProfile']);

Route::get('/forgot-password', [ForgotPasswordController::class, 'showEmailForm'])->name('password.request');
Route::post('/forgot-password/send-otp', [ForgotPasswordController::class, 'sendOtp'])->name('password.send.otp');
Route::get('/forgot-password/verify', [ForgotPasswordController::class, 'showOtpForm'])->name('password.otp.form');
Route::post('/forgot-password/reset', [ForgotPasswordController::class, 'resetPassword'])->name('password.reset');
Route::post('/forgot-password/resend-otp', [ForgotPasswordController::class, 'resendOtp'])->name('password.resend.otp');
/*
-----------------------------------------------------------------------------
AJAX CALL END
-----------------------------------------------------------------------------
*/

/*
---------------------------------------------------------------------
FRONTEND CONTROLLER END
---------------------------------------------------------------------
*/

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/chat/list', [ChatController::class, 'getChatList'])->name('chat.list');
    Route::get('/chat/messages/{receiverId}', [ChatController::class, 'getMessages'])->name('chat.messages');
    Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::get('/chat/unread', [ChatController::class, 'unreadCounts']);
  	Route::post('/chat/mark-seen/{receiverId}', [ChatController::class, 'markSeen']);
  	Route::post('/profile/change-email', [UserController::class, 'requestEmailChange']);
    Route::post('/profile/password-request', [UserController::class, 'requestPasswordChange'])->name('profile.password-request');
	Route::post('/profile/password-verify', [UserController::class, 'verifyPasswordOtp'])->name('profile.password-verify');
    Route::post('/notification/read', [UserController::class, 'markAsRead'])->name('notification.read');
});

//===================================================================================================================
