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
Route::middleware(['roles:Admin', 'auth'])->group(function () {
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
Route::middleware(['roles:User', 'auth'])->group(function () {
    // Dashnoard
    Route::get('/user/dashboard', [
        'uses' => 'User\\UsersController@index',
        'as' => 'user.dashboard'
    ]);

    // House
    Route::get('/user/house', [
        'uses' => 'User\\UsersController@house',
        'as' => 'user.house'
    ]);

    // Invoices
    Route::get('/user/invoices', [
        'uses' => 'User\\UsersController@invoices',
        'as' => 'user.invoices.index'
    ]);

    Route::get('/user/invoices/{invoice}', [
        'uses' => 'User\\UsersController@invoicesShow',
        'as' => 'user.invoices.show'
    ]);

    Route::get('/user/invoices/print_invoice/{invoice}',[
        'uses' => 'User\\UsersController@print_invoice',
        'as' => 'user.invoices.print_invoice'
    ]);

    Route::get('/user/invoices/pdf_invoice/{invoice}',[
        'uses' => 'User\\UsersController@pdf_invoice',
        'as' => 'user.invoices.pdf_invoice'
    ]);

    // Payments
    Route::get('/user/payments', [
        'uses' => 'User\\UsersController@payments',
        'as' => 'user.payments.index'
    ]);

    Route::get('/user/payments/create', [
        'uses' => 'User\\UsersController@paymentsCreate',
        'as' => 'user.payments.create'
    ]);

    Route::get('/user/payments/{payment}', [
        'uses' => 'User\\UsersController@paymentsShow',
        'as' => 'user.payments.show'
    ]);

    Route::post('/user/payments', [
        'uses' => 'User\\UsersController@paymentsStore',
        'as' => 'user.paymentsStore'
    ]);

    Route::post('/admin/payments/getInvoiceBalance', [
        'uses' => 'Admin\\PaymentsController@getInvoiceBalance',
        'as' => 'payments.getInvoiceBalance'
    ]);

    // Print Receipt
    Route::get('/user/payments/print_receipt/{payment}',[
        'uses' => 'User\\UsersController@print_receipt',
        'as' => 'user.payments.print_receipt'
    ]);

    // Notices
    Route::get('/user/notices', [
        'uses' => 'User\\UsersController@notices',
        'as' => 'user.notices.index'
    ]);

    Route::get('/user/notices/{notice}', [
        'uses' => 'User\\UsersController@noticesShow',
        'as' => 'user.notices.show'
    ]);

    // Notifications

    // Mark Notification as Read
    Route::get('/user/notifications/{notification}/notificationRead', [
        'uses' => 'User\\UsersController@notificationRead',
        'as' => 'user.notifications.notificationRead'
    ]);

    // Mark All Notifications as Read
    Route::get('/user/notifications/markNotificationsAsRead', [
        'uses' => 'User\\UsersController@markNotificationsAsRead',
        'as' => 'user.notifications.markNotificationsAsRead'
    ]);

    Route::get('/user/notifications', [
        'uses' => 'User\\UsersController@notifications',
        'as' => 'user.notifications.index'
    ]);
    
    //Settings
    Route::post('/user/settings/updateProfilePic', [
        'uses' => 'User\\SettingsController@updateProfilePic',
        'as' => 'user.settings.updateProfilePic'
    ]);

    Route::get('/user/settings/profile/{user}', [
        'uses' => 'User\\SettingsController@profile',
        'as' => 'user.settings.profile'
    ]);

    // Update Password
    Route::post('/user/settings/updatePassword', [
        'uses' => 'User\\SettingsController@updatePassword',
        'as' => 'user.settings.updatePassword'
    ]);

    // Mpesa
    // Access-Token
    Route::get('/user/access_token', [
        'uses' => 'Mpesa\\MpesaController@access_token',
        'as' => 'user.access_token'
    ]);

    // Register URLs
    Route::get('/user/register_url', [
        'uses' => 'Mpesa\\MpesaController@register_url',
        'as' => 'user.register_url'
    ]);

    // Simulate C2B Transaction
    Route::get('/user/C2B_simulate/{amount_paid}/{invoice_no}', [
        'uses' => 'Mpesa\\MpesaController@C2B_simulate',
        'as' => 'user.C2B_simulate'
    ]);

});