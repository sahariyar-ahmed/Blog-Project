<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Frontend\BloggController;
use App\Http\Controllers\Frontend\CatBlogController;
use App\Http\Controllers\Frontend\GuestAuthentication;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ManagementController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RequestController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

Auth::routes(['register' => false]);



//frontend
Route::get('/',[HomeController::class,'index'])->name('frontend');
//category
Route::get('/category/{slug}',[CatBlogController::class,'show'])->name('frontend.cat.blog');
Route::get('/category/single/{slug}', [CatBlogController::class, 'single'])->name('frontend.blog.single');
//blog
Route::get('/blogs',[BloggController::class,'index'])->name('frontend.blogs');
Route::get('/blogs/single/{slug}',[BloggController::class,'single'])->name('frontend.blogs.single');
//comment
Route::post('/blogs/comment/{id}',[BloggController::class,'comment'])->name('frontend.blogs.comment');
//login
Route::get('guest/login',[GuestAuthentication::class,'login'])->name('guest.login');
Route::post('guest/login',[GuestAuthentication::class,'login_post'])->name('guest.login');
//registration
Route::get('guest/register',[GuestAuthentication::class,'register'])->name('guest.register');
Route::post('guest/register',[GuestAuthentication::class,'register_post'])->name('guest.register');


//Request
Route::get('/role/request',[RequestController::class,'index'])->name('request.show');
Route::get('/role/request/accept/{id}',[RequestController::class,'accept'])->name('request.accept');
Route::get('/role/request/cancel/{id}',[RequestController::class,'cancel'])->name('request.cancel');
Route::post('/role/request/{id}',[RequestController::class,'request_send'])->name('request.send');




//dashboard-routes
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard')->middleware(['auth','verified']);


//middleware
Route::prefix(env('HOST_NAME'))->middleware(['rolecheck'])->group(function(){
    //management
    Route::get('/management', [ManagementController::class,'index'])->name("management.index");
    Route::post('/management/user/register', [ManagementController::class,'store_register'])->name("management.store");
    Route::post('/management/user/manager/down{id}', [ManagementController::class,'manager_down'])->name("management.down");

    //role
    Route::get('/management/role', [ManagementController::class,'role_index'])->name("management.role.index");
    Route::post('/management/role/assign', [ManagementController::class,'role_assign'])->name("management.role.assign");
    Route::post('/management/role/undo/blogger/{id}', [ManagementController::class,'blogger_grade_down'])->name("management.role.blogger.down");
    Route::post('/management/role/undo/user/{id}', [ManagementController::class,'user_grade_down'])->name("management.role.user.down");


});


//profile
Route::get('/profile', [App\Http\Controllers\ProfileController::class,'index'])->name("profile");
Route::post('/profile/name/update', [App\Http\Controllers\ProfileController::class,'name_update'])->name("profile.name.update");
Route::post('/profile/email/update', [App\Http\Controllers\ProfileController::class,'email_update'])->name("profile.email.update");
Route::post('/profile/password/update', [App\Http\Controllers\ProfileController::class,'password_update'])->name("profile.password.update");
Route::post('/profile/image/update', [App\Http\Controllers\ProfileController::class,'image_update'])->name("profile.image.update");


//middleware
Route::prefix(env('HOST_NAME'))->middleware(['excess'])->group(function(){
//category
Route::get('/category',[CategoryController::class,'index'])->name('category.index');
Route::post('/category/store',[CategoryController::class,'store'])->name('category.store');
Route::get('/category/edit/{rifat}',[CategoryController::class,'edit'])->name('category.edit');
Route::post('/category/update/{slug}',[CategoryController::class,'update'])->name('category.update');
Route::get('/category/delete/{slug}',[CategoryController::class,'delete'])->name('category.delete');
Route::post('/category/status/{slug}',[CategoryController::class,'status'])->name('category.status');

//blog
Route::resource('/blog',BlogController::class);
Route::post('/blog/status/{blog}', [BlogController::class, "status"])->name('blog.change_status');
Route::post('/blog/feature/{id}', [BlogController::class, "feature"])->name('blog.feature');


});






// Email verification routes
Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');


Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');



