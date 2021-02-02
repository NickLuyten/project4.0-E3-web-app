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

//test route to clear route cache
Route::get('/clear/route', 'Controller@clearRoute');

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

Route::get('/admin/users', 'Admin\UserController@index');
Route::get('/admin/users/{id}/edit', 'Admin\UserController@edit');
Route::post('/admin/users/{id}', 'Admin\UserController@update');
Route::get('/admin/users/create', 'Admin\UserController@new_index');
Route::post('/admin/users/create/store', 'Admin\UserController@new');
Route::get('/admin/users/{id}/delete', 'Admin\UserController@destroy');
Route::get('/admin/users/qrcodeGuest/{id}', 'Admin\UserController@qrcodeguest');

Route::get('/admin/{cid}/units', 'Admin\UnitsController@overview');
Route::get('/admin/{cid}/units/new', 'Admin\UnitsController@new_index');
Route::post('/admin/{cid}/units/new/store', 'Admin\UnitsController@new');
Route::get('/admin/{cid}/units/{mid}', 'Admin\UnitsController@edit_index');
Route::put('/admin/{cid}/units/{mid}/update', 'Admin\UnitsController@edit');
Route::get('/admin/{cid}/units/{mid}/delete', 'Admin\UnitsController@delete');
Route::get('/admin/{cid}/units/{mid}/access', 'Admin\UnitsController@access_index');
Route::post('/admin/{cid}/units/{mid}/access/{uid}/store', 'Admin\UnitsController@access_update');

Route::get('/admin/id/access', 'User\QRCodeController@request');
Route::get('/admin/companies', 'Admin\CompanyController@overview'); //vanroey admin
Route::get('/admin/companies/new', 'Admin\CompanyController@new_index'); //vanroey admin
Route::post('/admin/companies/new/store', 'Admin\CompanyController@new'); //vanroey admin
Route::get('/admin/companies/view/{cid}', 'Admin\CompanyController@view'); //vanroey admin
Route::get('/admin/companies/delete/{cid}', 'Admin\CompanyController@delete');

Route::get('/admin/company/{cid}/edit', 'Admin\CompanyController@edit_index');
Route::post('/admin/company/{cid}/update', 'Admin\CompanyController@update');

Route::get('/profile/edit', 'User\ProfileController@edit');
Route::post('/profile/update', 'User\ProfileController@update');
Route::get('/profile/password/edit', 'User\PasswordController@edit');
Route::post('/profile/password/update', 'User\PasswordController@update');


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
