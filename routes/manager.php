<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ManagerDashboard;
use App\Http\Controllers\Admin\ApprovalController;

Route::group(['prefix' => '', 'middleware'=> 'manager'], function(){
    Route::get('/manager/dashboard', [ManagerDashboard::class, 'index'])->name('manager.dashboard');
    Route::get('/manager/approval', [ApprovalController::class,'index'] )->name('approval-list.index');
    Route::get('/manager/datatable', [ApprovalController::class, 'datatable'])->name('approval-list.datatable');
    Route::post('/manager/approve-all-request', [ApprovalController::class, 'approveAllRequest'])->name('approval-list.approve-all-request');
    Route::put('/manager/{id}/approve-request', [ApprovalController::class, 'approveRequest'])->name('approval-list.approve-request');
    Route::put('/manager/{id}/reject-request', [ApprovalController::class, 'rejectRequest'])->name('approval-list.reject-request');
    Route::get('/manager/remainder-datatable', [ManagerDashboard::class, 'remainderDatatable'])->name('manager.remainder-datatable');
    Route::put('/manager/{id}/send-remainder',[ManagerDashboard::class, 'sendReminderEmail'])->name('manager.send-reminder-email');
});