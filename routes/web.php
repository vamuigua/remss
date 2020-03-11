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

// ADMIN ROUTES
Route::middleware(['roles:Admin'])->group(function () {
    Route::get('/admin/dashboard', [
        'uses' => 'AdminController@index',
        'as' => 'admin.dashboard'
    ]);

    Route::post('admin/houses/importData', [
        'uses' => 'Admin\\HousesController@importHousesData',
        'as' => 'houses.importHousesData'
    ]);

    Route::get('admin/houses/exportData', [
        'uses' => 'Admin\\HousesController@exportHousesData',
        'as' => 'houses.exportHousesData'
    ]);

    Route::post('/admin/tenants/assignHouse', [
        'uses' => 'Admin\\TenantsController@assignHouse',
        'as' => 'tenants.assignHouse'
    ]);

    Route::post('admin/tenants/revokeHouse', [
        'uses' => 'Admin\\TenantsController@revokeHouse',
        'as' => 'tenants.revokeHouse'
    ]);

    Route::post('admin/tenants/importData', [
        'uses' => 'Admin\\TenantsController@importTenantsData',
        'as' => 'tenants.importTenantsData'
    ]);

    Route::get('admin/tenants/exportData', [
        'uses' => 'Admin\\TenantsController@exportTenantsData',
        'as' => 'tenants.exportTenantsData'
    ]);

    Route::get('/admin/roles/assign', [
        'uses' => 'Admin\\RolesController@assign',
        'as' => 'roles.assign'  
    ]);

    Route::post('/admin/roles/assign-roles', [
        'uses' => 'Admin\\RolesController@assignRoles',
        'as' => 'roles.assignRoles'
    ]);
    
    Route::post('/admin/payments/getInvoiceBalance', [
        'uses' => 'Admin\\PaymentsController@getInvoiceBalance',
        'as' => 'payments.getInvoiceBalance'
    ]);

    Route::get('/admin/payments/print_receipt/{payment}',[
        'uses' => 'Admin\\PaymentsController@print_receipt',
        'as' => 'payments.print_receipt'
    ]);

    Route::get('/admin/invoices/print_invoice/{invoice}',[
        'uses' => 'Admin\\InvoicesController@print_invoice',
        'as' => 'invoices.print_invoice'
    ]);

    Route::get('/admin/invoices/pdf_invoice/{invoice}',[
        'uses' => 'Admin\\InvoicesController@pdf_invoice',
        'as' => 'invoices.pdf_invoice'
    ]);

    Route::resource('admin/houses', 'Admin\\HousesController');
    Route::resource('admin/tenants', 'Admin\\TenantsController');
    Route::resource('admin/invoices', 'Admin\\InvoicesController');
    Route::resource('admin/payments', 'Admin\\PaymentsController');
    Route::resource('admin/notices', 'Admin\\NoticesController');
    Route::resource('admin/roles', 'Admin\\RolesController');
    Route::resource('admin/expenditures', 'Admin\\ExpendituresController');
});

// USER ROUTES
Route::middleware(['roles:User'])->group(function () {
    Route::get('/user/dashboard', [
        'uses' => 'User\\UsersController@index',
        'as' => 'user.dashboard'
    ]);
});