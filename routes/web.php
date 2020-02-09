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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/admin/dashboard', 'AdminController@index');
Route::resource('admin/tenants', 'Admin\\TenantsController');

Route::get('/admin/roles/users', [
    'uses' => 'Admin\\RolesController@users',
    'as' => 'roles.users'
]);
Route::resource('admin/roles', 'Admin\\RolesController');