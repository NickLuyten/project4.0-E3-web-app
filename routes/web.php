<?php

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


Auth::routes();

Route::get('/', 'NavigationController@home');

Route::get('contact-us', 'ContactUsController@show');
Route::post('contact-us', 'ContactUsController@sendEmail');


Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    route::redirect('/', 'records');
});

Route::get('/user/token', 'User\QRCodeController@request');

//test routes zonder permissies
//id = company ID
Route::get('/admin/id/users', 'User\QRCodeController@request');
Route::get('/admin/id/units', 'User\QRCodeController@request');
Route::get('/admin/id/access', 'User\QRCodeController@request');
Route::get('/admin/companies', 'User\QRCodeController@request'); //vanroey admin


if (Cookie::get('AuthToken') == '') {
    Route::get('login', 'Auth\LoginController@show');
} elseif  (Cookie::get('AuthToken') != '') {
    Route::get('login', 'Auth\LoginController@dashboard');
}



Route::get('logout', 'Auth\LoginController@logout');
Route::get('dashboard', 'Auth\LoginController@dashboard');

Route::get('contact', function () {
    $me = ['name' => env('MAIL_FROM_NAME')];
    return view('contact', $me);
});

Route::redirect('user', '/user/profile');
Route::middleware(['auth'])->prefix('user')->group(function () {
    Route::get('profile', 'User\ProfileController@edit');
    Route::post('profile', 'User\ProfileController@update');
});

Route::redirect('user', '/user/profile');
Route::middleware(['auth'])->prefix('user')->group(function () {
    Route::get('profile', 'User\ProfileController@edit');
    Route::post('profile', 'User\ProfileController@update');
    Route::get('password', 'User\PasswordController@edit');
    Route::post('password', 'User\PasswordController@update');
});
