<?php

use App\Http\Controllers\Admin\CheckoutController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmailConfigController;
use App\Http\Controllers\Admin\EmployeeDashboard;
use App\Http\Controllers\Admin\IssueController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\ReturnController;
use App\Http\Controllers\Auth\Authcontroller;
use App\Http\Controllers\Auth\PermissionController;
use App\Http\Controllers\Auth\RoleController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\Master\CategoryController;
use App\Http\Controllers\Master\GenreController;
use App\Http\Controllers\Master\ItemController;
use App\Http\Controllers\Master\SubCategoryController;
use App\Http\Controllers\Master\TypeController;
use App\Http\Controllers\Reports\ApproveRequestHistoryController;
use App\Http\Controllers\Reports\InventoryReport;
use App\Http\Controllers\Reports\InventoryReportController;
use App\Http\Controllers\Reports\MemberBookHistoryController;
use App\Http\Controllers\Reports\BookWiseViewHistoryController;
use App\Http\Controllers\Reports\MemberViewHistoryController;
use App\Http\Controllers\Reports\OverdueHistoryController;
use Illuminate\Support\Facades\Route;
include('manager.php');
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

// Route::group(['prefix' => 'admin/', 'middleware'=> 'admin'], function(){
//   Route::get('user/index', ['as' => 'user.index', 'uses' =>'UserController@index']);
// });

// Route::group(['prefix' => 'admin/', 'middleware'=> 'admin'], function(){
//     Route::get('role/index', ['as' => 'role.index', 'uses' =>'Auth/RoleController@index']);
// });

Route::group(['prefix' => '', 'middleware'=> 'employee'], function(){
    Route::get('/employee/dashboard', [EmployeeDashboard::class, 'index'])->name('employee.dashboard');
    Route::put('/employee/{id}/approve-request', [EmployeeDashboard::class, 'approveRequest'])->name('employee.approve-request');
    Route::get('/employee/request-for-approval-datatable', [EmployeeDashboard::class, 'requestForApproval'])->name('employee.request-for-approval-datatable');
    Route::get('/employee/past-item-taken', [EmployeeDashboard::class, 'pastItemTaken'])->name('employee.past-item-taken');   
});



Route::group(['prefix' => 'admin', 'middleware'=> 'admin'], function(){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/dashboard/datatable', [DashboardController::class, 'datatable'])->name('admin.datatable');
    Route::put('/dashboard/{id}/approve-request', [DashboardController::class, 'approveRequest'])->name('admin.approve-request');
    Route::put('/dashboard/{id}/reject-request', [DashboardController::class, 'rejectRequest'])->name('admin.reject-request');
    Route::get('/dashboard/get-notification', [DashboardController::class, 'getNotification'])->name('dashboard.get-notification');
    
    Route::resource('master/category', CategoryController::class);
    Route::get('category/datatable', [CategoryController::class,'datatable'] )->name('category.datatable');
    Route::put('category/{id}/status', [CategoryController::class,'status'] )->name('category.status');
    Route::get('category/dropdown', [CategoryController::class, 'getDropdown'])->name('category.get-dropdown');


    Route::resource('master/subcategory', SubCategoryController::class);
    Route::get('subcategory/datatable', [SubCategoryController::class,'datatable'] )->name('subcategory.datatable');
    Route::put('subcategory/{id}/status', [SubCategoryController::class,'status'] )->name('subcategory.status');
    Route::get('subcategory/dropdown', [SubCategoryController::class, 'getDropdown'])->name('subcategory.get-dropdown');

    Route::resource('master/genre', GenreController::class);
    Route::get('genre/datatable', [GenreController::class,'datatable'] )->name('genre.datatable');
    Route::put('genre/{id}/status', [GenreController::class,'status'] )->name('genre.status');
    Route::get('genre/dropdown', [GenreController::class, 'getDropdown'])->name('genre.get-dropdown');

    Route::resource('master/type', TypeController::class);
    Route::get('type/datatable', [TypeController::class,'datatable'] )->name('type.datatable');
    Route::put('type/{id}/status', [TypeController::class,'status'] )->name('type.status');
    Route::get('type/dropdown', [TypeController::class, 'getDropdown'])->name('type.get-dropdown');

    Route::resource('master/item', ItemController::class);
    Route::get('item/datatable', [ItemController::class,'datatable'] )->name('item.datatable');
    Route::put('item/{id}/status', [ItemController::class,'status'] )->name('item.status');
    Route::get('item/dropdown', [ItemController::class, 'getDropdown'])->name('item.get-dropdown');
    Route::get('item/get-item', [ItemController::class, 'getItem'])->name('item.get-item');
    
    Route::get('return/get-all-taken-item', [ReturnController::class, 'getAllTakenItem'])->name('return.get-all-taken-item');
    Route::get('return/get-taken-item', [ReturnController::class, 'getTakenItem'])->name('return.get-taken-item');
    Route::post('return/checkin', [ReturnController::class, 'checkin'])->name('return.checkin');
    Route::resource('return', ReturnController::class);
    Route::post('notification/{id}/resend', [NotificationController::class,'resend'])->name('notification.resend');
    Route::get('notification/datatable', [NotificationController::class,'datatable'])->name('notification.datatable');
    Route::resource('admin/notification', NotificationController::class);
});

Route::group(['prefix' => '', 'middleware'=> 'admin'], function(){ 
    Route::get('issue/index',  [IssueController::class,'index'])->name('issue.index');
    Route::get('issue/get-item',[IssueController::class, 'getItemApproval'])->name('issue.get-item');
    Route::get('issue/{id}/datatable', [IssueController::class,'datatable'])->name('issue.datatable');
    Route::post('issue/checkout', [CheckoutController::class,'checkout'])->name('issue.checkout');
    Route::post('issue/send-approval-request', [CheckoutController::class,'sendApprovalRequest'])->name('issue.send-approval-request');
});

Route::group(['prefix' => 'admin/setting', 'middleware'=> 'admin'], function(){ 
    Route::get('role/datatable', [RoleController::class,'datatable'] )->name('role.datatable');
    Route::put('role/{id}/status', [RoleController::class,'status'])->name('role.status');
    Route::resource('role', RoleController::class);
});

Route::group(['prefix' => 'admin/setting', 'middleware'=> 'admin'], function(){ 
    Route::get('user/datatable', [UserController::class,'datatable'] )->name('user.datatable');
    Route::get('user/{id}/editUser', [UserController::class,'editUser'] )->name('user.edit-profile');
    Route::put('user/{id}/updateUser', [UserController::class,'updateUser'] )->name('user.update-profile');
    Route::put('user/{id}/status', [UserController::class,'status'])->name('user.status');
    Route::get('user/get-user-details', [UserController::class, 'getUserDetails'])->name('user.get-user-details');
    Route::resource('user', UserController::class);
});

Route::group(['prefix' => 'admin/setting', 'middleware'=> 'admin'], function(){ 
    Route::get('email-config/edit', [EmailConfigController::class,'create'])->name('email-config.edit');
    Route::post('email-config/{id}/update', [EmailConfigController::class,'update'])->name('email-config.update');
    Route::post('email-config/get-generate-password', [EmailConfigController::class,'getGeneratePassword'])->name('email-config.get-generate-password');
});

Route::group(['prefix' => 'admin/setting', 'middleware'=> 'admin'], function(){
    Route::get('permission', [ PermissionController::class,'index'])->name('permission.index');
    Route::get('permission/get-permission', [PermissionController::class,'getPermission'])->name('permission.get-permission');
    Route::post('permission/store', [PermissionController::class,'store'])->name('permission.store');
    Route::put('permission/update', [PermissionController::class,'update'])->name('permission.update');
});

Route::group(['prefix' => 'admin/setting', 'middleware' => 'admin'], function(){
    Route::get('config', [ ConfigController::class,'index'])->name('config.index');
    Route::post('config-store', [ConfigController::class, 'store'])->name('config.store');
    Route::post('config-cron', [ConfigController::class, 'callOverdueCron'])->name('config.call-cron');
});

Route::group(['prefix' => 'admin/report', 'middleware'=> 'admin'], function(){
    Route::get('inventory', [InventoryReportController::class,'index'])->name('inventory.index');
    Route::get('inventory/datatable', [InventoryReportController::class,'datatable'])->name('inventory.datatable');
    Route::post('inventory/export', [InventoryReportController::class,'export'])->name('inventory.export');

    
    Route::get('approve-request-history', [ApproveRequestHistoryController::class,'index'])->name('approve-request.index');
    Route::get('approve-request-history/datatable', [ApproveRequestHistoryController::class,'datatable'])->name('approve-request.datatable');
    Route::post('approve-request-history/export', [ApproveRequestHistoryController::class,'export'])->name('approve-request.export');
    Route::get('approve-request-history/get-member-dropdown', [ApproveRequestHistoryController::class,'getMemberDropdown'])->name('approve-request.get-member-dropdown');
    Route::get('approve-request-history/get-item-dropdown', [ApproveRequestHistoryController::class,'getItemDropdown'])->name('approve-request.get-item-dropdown');
    

    Route::get('member-book-history', [MemberBookHistoryController::class, 'index'])->name('member-view-history.index');
    Route::get('member-book-history/datatable', [MemberBookHistoryController::class, 'datatable'])->name('member-view-history.datatable');
    Route::post('member-book-history/export', [MemberBookHistoryController::class, 'export'])->name('member-view-history.export');
    Route::get('member-book-history/get-member-dropdown', [MemberBookHistoryController::class, 'getMemberDropdown'])->name('member-view-history.get-member-dropdown');
    Route::get('member-book-history/get-item-dropdown', [MemberBookHistoryController::class, 'getItemDropdown'])->name('member-view-history.get-item-dropdown');


    Route::get('book-view-history', [BookWiseViewHistoryController::class, 'index'])->name('book-view-history.index');
   
    Route::get('book-view-history/get-item-dropdown', [BookWiseViewHistoryController::class, 'getItemDropdown'])->name('book-view-history.get-item-dropdown');

    Route::get('memebr-view-history', [MemberViewHistoryController::class, 'index'])->name('member-history.index');
    Route::get('memebr-view-history/get-member-dropdown', [MemberViewHistoryController::class, 'getMemberDropdown'])->name('member-history.get-member-dropdown');

    Route::get('overdue-history', [OverdueHistoryController::class, 'index'])->name('overdue-history.index');
    Route::get('overdue-history/datatable', [OverdueHistoryController::class, 'datatable'])->name('overdue-history.datatable');
    Route::post('overdue-history/export', [OverdueHistoryController::class, 'export'])->name('overdue-history.export');
    Route::get('overdue-history/get-member-dropdown', [OverdueHistoryController::class, 'getMemberDropdown'])->name('overdue-history.get-member-dropdown');
});

Route::group(['prefix' => 'admin'], function(){
Route::get('/', [Authcontroller::class,'getSignin'])->name('login');
Route::get('/forgot-password', [Authcontroller::class,'forgotPassword'])->name('forgot-password');
Route::get('/send-forget-email', [Authcontroller::class,'sendForgotEmail'])->name('send-forget-email');
Route::post('/', [Authcontroller::class,'postSignin'])->name('login');
Route::post('/logout', [Authcontroller::class,'postSignout'])->name('logout');
});
Route::get('/',function(){ return view('home'); })->name('home');

