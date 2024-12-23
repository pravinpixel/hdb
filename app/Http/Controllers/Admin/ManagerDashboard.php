<?php

namespace App\Http\Controllers\Admin;

use App\Events\Notification;
use App\Http\Controllers\Controller;
use App\Mail\SendReminder;
use App\Models\ApproveRequest;
use App\Models\Config;
use App\Models\Item;
use Carbon\Carbon;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
class ManagerDashboard extends Controller
{
    public function index()
    {
        $data['total_item'] = Item::get()->count();
        $approve_status = ApproveRequest::groupBy('approve_status')
                                        ->select('approve_status', DB::raw('count(*) as total'))
                                        ->get();
        foreach($approve_status as $item) {
            if($item->approve_status  == 1) //pending
                $data['total_pending'] = $item->total;

            if($item->approve_status  == 2) //approved 
                $data['total_approved'] = $item->total;
            
            if($item->approve_status  == 3) //rejected
                $data['total_rejected'] = $item->total;
        }
        return view('manager.index', compact('data'));
    }
    
    public function remainderDatatable(Request $request)
    {
        if ($request->ajax() == true) {
            $dataDb =  Item::query();
            if($request->search_item_name) {
                $dataDb->where('item_id', $request->search_item_name);
                $dataDb->orWhere('item_name', 'like', '%'.$request->search_item_name.'%');
            }
            if($request->category) {
                $dataDb->where('category_id', $request->category);
            }
            $dataDb->with('user');
            return DataTables::eloquent($dataDb) 
                ->addColumn('status', function ($dataDb) {
                    $status = '';
                    if($dataDb->is_issued) {
                        $status = '<div class="text-left"><div class="badge badge-danger">Issued to </div> <div class="badge badge-danger">'. $dataDb->user->first_name.'</div></div>';
                    } else {
                        $status = '<div class="text-left"><div class="badge badge-info"> Available </div></div>';
                    }
                   return  $status;
                }) 
                ->addColumn('date_of_return', function ($dataDb) {
                    $day_diff = 0;
                    if($dataDb->date_of_return) {
                        $current_date = strtotime(Date('Y-m-d'));
                        $checkout_date = strtotime($dataDb->date_of_return);
                        $day_diff = ( $checkout_date - $current_date ) / 86400 ;
                        $no_of_days = ($day_diff > 0) ? "<div><div class='label label-success'>{$day_diff} days</div></div>" : "<div><div class='label label-danger'>{$day_diff} days</div></div>";
                        return Carbon::parse($dataDb->date_of_return)->format('d-m-Y').'  '. $no_of_days;
                    }
                    return '-';
                }) 
                ->addColumn('action', function ($dataDb) {
                    if($dataDb->checkout_by) {
                        return '<a href="#" data-message="Are you sure to send overdue email" data-href="' . route('manager.send-reminder-email', $dataDb->id) . '" id="tooltip" data-method="POST" data-title="Send Overdue Email" data-title-modal="Send Overdue Email" data-toggle="modal" data-target="#delete" title=""><span class="label label-danger label-sm"> Send Reminder </span></a>';
                    }
                    return '';
                })
                ->rawColumns(['action','status','date_of_return'])
                ->make(true);
        }
    }

    public function sendReminderEmail($id)
    {
        try {
            $config = Config::find(1);
            $item = Item::with('user')->find($id);
        if(empty($item)) {
            return response(['status' => false, 'msg' => 'Item not found']);
        }
        $email   =  $item->user->email;
        $from    =  Sentinel::getUser()->id;
        $to      =  $item->user->id;
        $item_id =  $item->id;
        $current_date = strtotime(Date('Y-m-d'));
        $checkout_date = strtotime($item->date_of_return);
        $day_diff = ( $checkout_date - $current_date ) / 86400 ;
        $details = [
            'title' => 'Overdue Email',
            'user'  => $item->user,
            'item'  => $item,
            'overdue' => $day_diff
        ];
            if($config->enable_email == 1) {
                Mail::to($email)->send(new SendReminder($details));
                if(count(Mail::failures()) > 0){
                    event(new Notification("Overdue email sent failure [item name : {$item->item_name}]","overdue", $id, $from, $to, $item_id,0));
                    Log::info('Overdue send email failure');
                }else {
                    event(new Notification("Overdue email sent [item name : {$item->item_name}]", "overdue", $id, $from, $to, $item_id));
                    Log::info('Overdue email sent successfully');
                }
                return  response(['status' => true, 'msg' => 'Email Send Successfully']);
            } else {
                return  response(['status' => false, 'msg' => 'Please Enable email config']);
            }
        } catch (Exception $e) {
            Log::info($e->getMessage());
            event(new Notification("Overdue email sentemail failure [item name : {$item->item_name}]","overdue", $id, $from, $to, $item_id,0));
        }
    }
}
