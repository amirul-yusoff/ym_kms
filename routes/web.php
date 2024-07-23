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
    return redirect()->route('login');
});

Route::get('/phpinfo', function () {
    return view('phpinfo');
});

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function() {

    /**
     * Added routes for subcon
     */
    Route::get('my-invoice-subcon/{my_invoice}/verify-and-submit', 'invoiceController@verifyAndSubmit')->name('myInvoiceSubcon.verifyAndSubmit');
    Route::get('my-invoice/{my_invoice}/editStage-three', 'invoiceController@editStage3')->name('myInvoiceSubcon.editStage3');
    Route::get('my-invoice/{my_invoice}/updateStage-three', 'invoiceController@updateStage3')->name('myInvoiceSubcon.updateStage3');
    Route::get('my-invoice-subcon/{my_invoice}/verify-and-submit-S3', 'invoiceController@verifyAndSubmitS3')->name('myInvoiceSubcon.verifyAndSubmitS3');
/**
     * Added routes for supplier
     */
    Route::get('my-invoice-supplier/{my_invoice}/verify-and-submit', 'invoiceSupplierController@verifyAndSubmit')->name('myInvoiceSupplier.verifyAndSubmit');

    /**
     * Added routes for searchaccount
     */
    Route::post('members/update-image', 'membersManagementController@storeImage')->name('members.uploadImage');
    Route::post('members/delete-image', 'membersManagementController@deleteImage')->name('members.deleteImage');
    
    Route::get('parameters/add-parameters', 'projectRegistryController@storeParameters')->name('parameters.update');

    /**
     * Split the route for project-members
     */
    Route::get('project-members/select-team/{team}', 'projectMembersController@selectTeam')->name('project-members.update');
    Route::post('project-members/{project_registry}/members', 'projectMembersController@store')->name('members-store.update');
    Route::delete('project-members/{project_registry}/members/{members}', 'projectMembersController@destroy')->name('members-destroy.update');
    Route::put('project-members/{project_registry}/members/{members}', 'projectMembersController@editMembers')->name('members-editing.update');

    /**
	  
     * Added routes for member
     */
    Route::get('member/password-reset/{member}', 'memberController@resetPassword')->name('reset-password.show');
    Route::put('member/password-reset/{member}', 'memberController@setPassword')->name('reset-password.update');
    Route::post('member/read-all', 'memberController@readNoti')->name('notification.show');

    /**
     * Added route for notification
     */
    Route::get('notification', 'HomeController@getNotification');

    /**
     * Route for PDF generator.
     * Added route for work-order-bq print pdf
     * Added route for work-order-letterofaward print pdf
     * Added route for work-order-paymentcert print pdf
     * Added route for work-order-vooo print pdf
     * Added route for bank-guarantee print pdf
     */
    
    Route::resource('accessibility-control', 'accessibilityController');
    Route::resource('login-history', 'loginHistoryController');
    Route::resource('member', 'memberController');
    Route::resource('member-activity', 'memberActivityController');
    Route::resource('member-department', 'memberDepartmentController');
    Route::resource('member-position', 'memberPositionController');
    Route::resource('members-management', 'membersManagementController');
    Route::resource('dashboard', 'DashboardController');
    Route::resource('settings', 'parametersSettingsController');
    Route::resource('module-permission', 'modulePermissionController');
    Route::resource('my-invoice-subcon', 'invoiceController');
    Route::resource('my-invoice-supplier', 'invoiceSupplierController');

    Route::get('mail', 'sendMailReport@sendMail');


    //This route is just for ajax search autocomplete only
    Route::post('searchajax',array('as'=>'searchajax','uses'=>'autoCompleteController@autoComplete'));
    Route::get('searchajax', function(){
        return redirect()->back();
    });

    Route::any('system/upload', function() {
        return view('uploadfile');
    })->name('system.upload');


    Route::resource('admin/roles', 'Admin\RoleController');
    Route::delete('admin/roles_mass_destroy', 'Admin\RoleController@massDestroy')->name('roles.mass_destroy');
});


Route::group(['middleware' => ['auth'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('members', 'Admin\MemberController');
    Route::resource('permissions', 'Admin\PermissionController');
    Route::delete('permissions_mass_destroy', 'Admin\PermissionController@massDestroy')->name('permissions.mass_destroy');
    Route::resource('roles', 'Admin\RoleController');
    Route::delete('roles_mass_destroy', 'Admin\RoleController@massDestroy')->name('roles.mass_destroy');
    Route::delete('members_mass_destroy', 'Admin\MemberController@massDestroy')->name('members.mass_destroy');
});

Route::group(['middleware' => ['auth'], 'prefix' => 'subcon', 'as' => 'subcon.'], function () {
    Route::resource('self-service', 'JointMeasurementSheetController');
    Route::resource('invoice', 'SubconInvoiceController');
});
