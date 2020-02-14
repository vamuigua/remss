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

Route::get('/home', [
    'uses' => 'HomeController@index',
    'as' => 'home'
]);

Route::middleware(['roles:Admin'])->group(function () {
    Route::get('/admin/dashboard', [
        'uses' => 'AdminController@index',
        'as' => 'admin.dashboard'
    ]);
    
    Route::resource('admin/houses', 'Admin\\HousesController');

    Route::post('admin/tenants/importData', [
        'uses' => 'Admin\\TenantsController@importTenantsData',
        'as' => 'tenants.importTenantsData'
    ]);

    Route::get('admin/tenants/exportData', [
        'uses' => 'Admin\\TenantsController@exportTenantsData',
        'as' => 'tenants.exportTenantsData'
    ]);

    Route::resource('admin/tenants', 'Admin\\TenantsController');

    Route::get('/admin/roles/assign', [
        'uses' => 'Admin\\RolesController@assign',
        'as' => 'roles.assign'  
    ]);

    Route::post('/admin/roles/assign-roles', [
        'uses' => 'Admin\\RolesController@assignRoles',
        'as' => 'roles.assignRoles'
    ]);
    
    Route::resource('admin/roles', 'Admin\\RolesController');
});
