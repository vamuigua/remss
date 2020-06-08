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

Route::view('/', 'welcome');
Route::view('/about-us', 'static.about');

// Featured Listings
Route::get('/featured-listings', [
    'uses' => 'FeaturedListingsController@index',
    'as' => 'featured-listings.index'
]);

Route::get('/featured-listings/{id}', [
    'uses' => 'FeaturedListingsController@show',
    'as' => 'featured-listings.show'
]);

Route::post('/featured-listings/{id}/question', [
    'uses' => 'FeaturedListingsController@sendQuestion',
    'as' => 'featured-listing.sendQuestion'
]);

Route::post('/featured-listings/{id}/bookHouse', [
    'uses' => 'FeaturedListingsController@bookHouse',
    'as' => 'featured-listing.bookHouse'
]);

Route::get('/house_ads/view_doc/{id}', [
    'uses' => 'Admin\\HouseAdvertsController@view_doc',
    'as' => 'house_ads.view_doc'
]);

// Contact Page
Route::get('/contact', [
    'uses' => 'ContactFormController@index',
    'as' => 'contact.index'
]);

Route::post('/contact', [
    'uses' => 'ContactFormController@store',
    'as' => 'contact.store'
]);

Auth::routes();

Route::get('/home', [
    'uses' => 'HomeController@index',
    'as' => 'home'
]);

// Routes Shared by Both Authenticated Users (Admin & Normal User)
Route::middleware(['auth','web'])->group(function () {
    Route::post('/admin/payments/getInvoiceBalance', [
        'uses' => 'Admin\\PaymentsController@getInvoiceBalance',
        'as' => 'payments.getInvoiceBalance'
    ]);
    
    Route::get('admin/tenants/download_doc/{tenant}', [
        'uses' => 'Admin\\TenantsController@download_doc',
        'as' => 'tenants.download_doc'
    ]);

    Route::get('admin/tenants/view_doc/{tenant}', [
        'uses' => 'Admin\\TenantsController@view_doc',
        'as' => 'tenants.view_doc'
    ]);
});

// ADMIN ROUTES
Route::middleware(['roles:Admin', 'auth'])->group(function () {
    Route::get('/admin/dashboard', [
        'uses' => 'Admin\\AdminDashboardController@index',
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

    Route::post('/admin/water-readings/getPrevWaterReading', [
        'uses' => 'Admin\\WaterReadingsController@getPrevWaterReading',
        'as' => 'water-readings.getPrevWaterReading'
    ]);

    // Notifications
    Route::get('/admin/notifications', [
        'uses' => 'Admin\\NotificationsController@index',
        'as' => 'admin.notifications.index'
    ]);

    // Mark Notification as Read
    Route::get('/admin/notifications/{notification}/notificationRead', [
        'uses' => 'Admin\\NotificationsController@notificationRead',
        'as' => 'admin.notifications.notificationRead'
    ]);

    // Mark All Notifications as Read
    Route::get('/admin/notifications/markNotificationsAsRead', [
        'uses' => 'Admin\\NotificationsController@markNotificationsAsRead',
        'as' => 'admin.notifications.markNotificationsAsRead'
    ]);

    //Settings
    Route::get('/admin/settings/profile/{user}', [
        'uses' => 'Admin\\SettingsController@profile',
        'as' => 'admin.settings.profile'
    ]);

    // Update Password
    Route::post('/admin/settings/updatePassword', [
        'uses' => 'Admin\\SettingsController@updatePassword',
        'as' => 'admin.settings.updatePassword'
    ]);

    // Expenditures Per Month Request
    Route::post('/admin/expenditure-months', [
        'uses' => 'Admin\\ExpendituresController@expenditureMonths',
        'as' => 'admin.expenditureMonths'
    ]);

    Route::get('/admin/pending-payments', [
        'uses' => 'Admin\\PendingPaymentsController@index',
        'as' => 'admin.pendingpayments.index'
    ]);

    Route::resource('admin/houses', 'Admin\\HousesController');
    Route::resource('admin/tenants', 'Admin\\TenantsController');
    Route::resource('admin/invoices', 'Admin\\InvoicesController');
    Route::resource('admin/payments', 'Admin\\PaymentsController');
    Route::resource('admin/notices', 'Admin\\NoticesController');
    Route::resource('admin/roles', 'Admin\\RolesController');
    Route::resource('admin/expenditures', 'Admin\\ExpendituresController');
    Route::resource('admin/messages', 'Admin\\MessagesController');
    Route::resource('admin/water-readings', 'Admin\\WaterReadingsController');
    Route::resource('admin/house-adverts', 'Admin\\HouseAdvertsController');
});

// USER ROUTES
Route::middleware(['roles:User', 'auth'])->group(function () {
    // Dashnoard
    Route::get('/tenant/dashboard', [
        'uses' => 'Tenant\\TenantController@index',
        'as' => 'tenant.dashboard'
    ]);

    // House
    Route::get('/tenant/house', [
        'uses' => 'Tenant\\TenantController@house',
        'as' => 'tenant.house'
    ]);

    // Invoices
    Route::get('/tenant/invoices', [
        'uses' => 'Tenant\\InvoicesController@invoices',
        'as' => 'tenant.invoices.index'
    ]);

    Route::get('/tenant/invoices/{invoice}', [
        'uses' => 'Tenant\\InvoicesController@invoicesShow',
        'as' => 'tenant.invoices.show'
    ]);

    Route::get('/tenant/invoices/print_invoice/{invoice}',[
        'uses' => 'Tenant\\InvoicesController@print_invoice',
        'as' => 'tenant.invoices.print_invoice'
    ]);

    Route::get('/tenant/invoices/pdf_invoice/{invoice}',[
        'uses' => 'Tenant\\InvoicesController@pdf_invoice',
        'as' => 'tenant.invoices.pdf_invoice'
    ]);

    // Payments
    Route::get('/tenant/payments', [
        'uses' => 'Tenant\\PaymentsController@payments',
        'as' => 'tenant.payments.index'
    ]);

    Route::get('/tenant/payments/create', [
        'uses' => 'Tenant\\PaymentsController@paymentsCreate',
        'as' => 'tenant.payments.create'
    ]);

    Route::get('/tenant/payments/{payment}', [
        'uses' => 'Tenant\\PaymentsController@paymentsShow',
        'as' => 'tenant.payments.show'
    ]);

    Route::post('/tenant/payments', [
        'uses' => 'Tenant\\PaymentsController@paymentsStore',
        'as' => 'tenant.paymentsStore'
    ]);

    Route::get('/tenant/complete_payment/{payment}', [
        'uses' => 'Tenant\\PaymentsController@completePayment',
        'as' => 'tenant.completePayment'
    ]);

    // Print Receipt
    Route::get('/tenant/payments/print_receipt/{payment}',[
        'uses' => 'Tenant\\PaymentsController@print_receipt',
        'as' => 'tenant.payments.print_receipt'
    ]);

    // Notices
    Route::get('/tenant/notices', [
        'uses' => 'Tenant\\NoticesController@notices',
        'as' => 'tenant.notices.index'
    ]);

    Route::get('/tenant/notices/{notice}', [
        'uses' => 'Tenant\\NoticesController@noticesShow',
        'as' => 'tenant.notices.show'
    ]);

    // Notifications
    Route::get('/tenant/notifications', [
        'uses' => 'Tenant\\NotificationsController@index',
        'as' => 'tenant.notifications.index'
    ]);

    // Mark Notification as Read
    Route::get('/tenant/notifications/{notification}/notificationRead', [
        'uses' => 'Tenant\\NotificationsController@notificationRead',
        'as' => 'tenant.notifications.notificationRead'
    ]);

    // Mark All Notifications as Read
    Route::get('/tenant/notifications/markNotificationsAsRead', [
        'uses' => 'Tenant\\NotificationsController@markNotificationsAsRead',
        'as' => 'tenant.notifications.markNotificationsAsRead'
    ]);
    
    //Settings
    Route::post('/tenant/settings/updateProfilePic', [
        'uses' => 'Tenant\\SettingsController@updateProfilePic',
        'as' => 'tenant.settings.updateProfilePic'
    ]);

    Route::get('/tenant/settings/profile/{user}', [
        'uses' => 'Tenant\\SettingsController@profile',
        'as' => 'tenant.settings.profile'
    ]);

    // Update Password
    Route::post('/tenant/settings/updatePassword', [
        'uses' => 'Tenant\\SettingsController@updatePassword',
        'as' => 'tenant.settings.updatePassword'
    ]);

    // Mpesa Routes
    // Access-Token
    Route::get('/tenant/access_token', [
        'uses' => 'Mpesa\\MpesaController@access_token',
        'as' => 'tenant.access_token'
    ]);

    // Register URLs
    Route::get('/tenant/register_url', [
        'uses' => 'Mpesa\\MpesaController@register_url',
        'as' => 'tenant.register_url'
    ]);

    // Simulate C2B Transaction
    Route::get('/tenant/C2B_simulate/{amount_paid}/{invoice_no}/{payment_id}', [
        'uses' => 'Mpesa\\MpesaController@C2B_simulate',
        'as' => 'tenant.C2B_simulate'
    ]);

    // Feedback / Questions
    Route::get('/tenant/questions',[
        'uses' =>'Tenant\\QuestionsController@index',
        'as' => 'tenant.questions'
    ]);

    Route::post('/tenant/questions',[
        'uses' =>'Tenant\\QuestionsController@store',
        'as' => 'tenant.questions'
    ]);

});

