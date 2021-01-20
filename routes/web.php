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

//Route::get('/', function () {
//    return view('welcome');
//});
Auth::routes();
//Route::get('/home', 'HomeController@index')->name('home');
Route::view('/', 'home');

Route::view('contact-us', 'contact');

//Route::get('contact-us', function () {
//    return view('contact');
//});

Route::get('qrcode', 'QrcodeController@make');



Route::get('contact-us', 'ContactUsController@show');
Route::post('contact-us', 'ContactUsController@sendEmail');


Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    route::redirect('/', 'records');
    Route::get('genres/qryGenres', 'Admin\GenreController@qryGenres');
    Route::resource('genres', 'Admin\GenreController');
    Route::resource('records', 'Admin\RecordController');
    Route::get('users2/qryUsers', 'Admin\User2Controller@qryUsers');
    Route::resource('users', 'Admin\UserController');
    Route::resource('users2', 'Admin\User2Controller', ['parameters' => ['users2' => 'user']]);
});


Auth::routes();
Route::get('logout', 'Auth\LoginController@logout');

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
