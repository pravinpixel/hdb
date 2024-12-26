<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Item;
use App\Models\Checkout;
use Carbon\Carbon;
class HomeController extends Controller
{
    public function index()
    {   
        return view('home');
    }
    public function getStaff(Request $request)
    { 


      
        $div = "<div class='card-staff-check'>
        <div class='card-body-3'>
            <div class='padd-style-checkout-h2'>
                <h1 class='h2-text'>Enter Your Staff ID</h1>
            </div>
            <div class='input-group mb-3'>
                <input type='text' class='form-control background-textbox' name='staff_id' placeholder='eg. V15267' aria-label='Sizing example input' aria-describedby='inputGroup-sizing-default'>
               
            </div>
             <b style='color:red' id='staffErr'></b>
             <input type='hidden' name='type' value='{$request->type}'>
            <div class='btn-center'>
                <button id='verify-staff' type='button' class='btn btn-color-new'>Submit</button>
            </div>
        </div>

    </div>";

        return response()->json([
            'status' => true,
            'data' => $div 
        ]);
    }
    public function verifyStaff(Request $request)
    { 
        $user=User::where('member_id',$request->staff_id)->first();
        if(!$user){
        return response()->json([
            'status' => false,
            'err' => 'Staff id not found' 
        ]);
        }
       
        $div = "
        <div class='card-staff-check'>
            <div class='card-body-4'>
                <div class='padd-style-checkout-h2'>
                  <h5 class='h2-text'>Welcome {$user->first_name}</h5><br>
                    <h1 class='h2-text'>Enter Your BOOK ID</h1>
                </div>
                <div class='input-group mb-3'>
                    <input type='text' class='form-control background-textbox' placeholder='Scan your book on the RFID Pad' aria-label='Sizing example input' aria-describedby='inputGroup-sizing-default' name='item_ref' id='scan-data'>
                
                 <b style='color:red' id='itemErr'></b>
                     <input type='hidden' name='type' value='{$request->type}'>
                 <input type='hidden' name='staff_id' value='{$request->staff_id}'> 
                 </div>
                 <div class='item_data' id='item_data'> </div>
                <div class='btn-center-scan'>
                    <button type='button' class='btn btn-color-new padding-btn' id='check-id'>submit</button>
                </div>
            </div>
        </div>";
        
        return response()->json([
            'status' => true,
            'data' => $div 
        ]);
    }
    public function CheckItem(Request $request)
    { 
        $item=Item::where('item_ref',$request->item_ref)->first();
        if(!$item){
        return response()->json([
            'status' => false,
            'err' => 'Item RFID not found' 
        ]);
        }
        $user=User::where('member_id',$request->staff_id)->first();
        $ins['date']          = now();
        $ins['item_id']        = $item->id;
        $ins['title']        = $item->title;
        $ins['date_of_return'] = Carbon::now()->addDays(21);
        $ins['checkout_by']    = $user->id;
        Checkout::updateOrCreate(['item_id' => $item->id,'checkout_by'=>$user->id], $ins);
        $checkouts=Checkout::where('checkout_by',$user->id)->where('status','pending')->get();
        $div = "<table>
                <tr>
                    <th>No</th>
                    <th>Book name</th>
                    <th>Action</th>
                </tr>";
        foreach ($checkouts as $checkout) {
        $div .= "<tr>
                    <td>{$checkout->id}</td>
                    <td>{$checkout->title}</td>
                    <td>{$checkout->item->item_ref}</td>
                     <input type='hidden' name='check_in[]' value='{$checkout->id}'>
                </tr>";
        }
        $div .= "</table>";
        
        return response()->json([
            'status' => true,
            'data' => $div 
        ]);
    }

    public function CheckIn(Request $request)
    { 
       
       dd($request);
        
        return response()->json([
            'status' => true,
            'data' => $div 
        ]);
    }
}
