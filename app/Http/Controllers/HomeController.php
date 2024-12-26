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
       if($request->type == 'check-in'){
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
                    <button type='button' class='btn btn-color-new padding-btn' id='taken'>submit</button>
                </div>
            </div>
        </div>";
       }else{
        $checkouts=Checkout::where('checkout_by',$user->id)->where('status','taken')->get();
        $div = "<div class='card-staff-check'>
           <div class='card-body-2'>
            <div class='padd-style-checkout-h2'>
              <h1 class='h2-text'>Waiting for Scanning the books</h1>
            </div><div class='card card-border' style='width: 95%; margin: 0 auto; height: 154px;'><div class='card-chekout'>";
        $checkout_id = [];
        foreach ($checkouts as $key => $checkout) {
            $no = $key + 1;
            $deleteImageUrl = asset('dark/assets/images/home/delete.png');
            $div .= "<div class='content-flex'>
                        <h4 class='text-content'>{$no}</h4>
                        <h4 class='text-content'>{$checkout->title}</h4>
                        <h4 class='text-content'>{$checkout->item->item_ref}</h4>
                        <div class='flex-checkout' style='cursor: pointer;'>
                            <img src='{$deleteImageUrl}' alt='delete' onclick='unsetCheckout({$checkout->id})'/>
                        </div>
                      </div>";
            array_push($checkout_id, $checkout->id);
        }
        $checkout_ids = implode(',', $checkout_id);
        $isButtonDisabled = count($checkout_id) == 0 ? 'disabled' : ''; 
        $div .= "<input type='hidden' name='check_in' value='{$checkout_ids}'> <input type='hidden' name='type' value='{$request->type}'>
                 <input type='hidden' name='staff_id' value='{$request->staff_id}'> ";
        $div .= "</div></div><div class='btn-center btn-end-new'>
              <button type='button' class='btn btn-color-new' id='return' {$isButtonDisabled}>Check out</button>
            </div> 
          </div>
        </div>";
       }
       
        
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
        Checkout::updateOrCreate(['item_id' => $item->id,'checkout_by'=>$user->id,'status'=>'pending'], $ins);
        $checkouts=Checkout::where('checkout_by',$user->id)->where('status','pending')->get();
        $div = "<div class='card card-border' style='width: 95%; margin: 0 auto; height: 154px;'><div class='card-chekout'>";
        $checkout_id = [];
        foreach ($checkouts as $key => $checkout) {
            $no = $key + 1;
            $deleteImageUrl = asset('dark/assets/images/home/delete.png');
            $div .= "<div class='content-flex'>
                        <h4 class='text-content'>{$no}</h4>
                        <h4 class='text-content'>{$checkout->title}</h4>
                        <h4 class='text-content'>{$checkout->item->item_ref}</h4>
                        <div class='flex-checkout' style='cursor: pointer;'>
                            <img src='{$deleteImageUrl}' alt='delete' onclick='deleteCheckout({$checkout->id})'/>
                        </div>
                      </div>";
            array_push($checkout_id, $checkout->id);
        }
        $checkout_ids = implode(',', $checkout_id);
        $div .= "<input type='hidden' name='check_in' value='{$checkout_ids}'>";
        $div .= "</div></div>";
        return response()->json([
            'status' => true,
            'data' => $div 
        ]);
    }

    public function CheckIn(Request $request)
    { 
        $checkinIds = explode(',', $request->check_in);
        $isCheckin=Checkout::whereIn('id',$checkinIds)->update(['status' => 'taken']);
        if($isCheckin){
            return response()->json([
                'status' => true,
                'data' => 'Successfully check-in' ,
                'redirect_to'=>'check-in-success'
            ]);
        }else{
            return response()->json([
                'status' => false,
                'err' => 'Server Error' 
            ]);
        }
       
    }
    public function CheckInSuccess()
    {   
        return view('check-in');
    }
    public function ItemDelete(Request $request)
    { 
        $item=Checkout::where('id',$request->checkoutId)->delete();
        $user=User::where('member_id',$request->staff_id)->first();
        $checkouts=Checkout::where('checkout_by',$user->id)->where('status','pending')->get();
        $div = "<div class='card card-border' style='width: 95%; margin: 0 auto; height: 154px;'><div class='card-chekout'>";
        $checkout_id = [];
        foreach ($checkouts as $key => $checkout) {
            $no = $key + 1;
            $deleteImageUrl = asset('dark/assets/images/home/delete.png');
            $div .= "<div class='content-flex'>
                        <h4 class='text-content'>{$no}</h4>
                        <h4 class='text-content'>{$checkout->title}</h4>
                        <h4 class='text-content'>{$checkout->item->item_ref}</h4>
                        <div class='flex-checkout' style='cursor: pointer;'>
                            <img src='{$deleteImageUrl}' alt='delete' onclick='deleteCheckout({$checkout->id})' />
                        </div>
                      </div>";
            array_push($checkout_id, $checkout->id);
        }
        $checkout_ids = implode(',', $checkout_id);
        $div .= "<input type='hidden' name='check_in' value='{$checkout_ids}'>";
        $div .= "</div></div>";
        return response()->json([
            'status' => true,
            'data' => $div 
        ]);
    }
    public function ItemUnset(Request $request)
    {  
        $checkoutId = $request->checkoutId;
        $user=User::where('member_id',$request->staff_id)->first();
        $checkouts=Checkout::whereNotIn('id',$checkoutId)->where('checkout_by',$user->id)->where('status','taken')->get();

        $div = "<div class='card-staff-check'>
           <div class='card-body-2'>
            <div class='padd-style-checkout-h2'>
              <h1 class='h2-text'>Waiting for Scanning the books</h1>
            </div><div class='card card-border' style='width: 95%; margin: 0 auto; height: 154px;'><div class='card-chekout'>";
        $checkout_id = [];
        foreach ($checkouts as $key => $checkout) {
            $no = $key + 1;
            $deleteImageUrl = asset('dark/assets/images/home/delete.png');
            $div .= "<div class='content-flex'>
                        <h4 class='text-content'>{$no}</h4>
                        <h4 class='text-content'>{$checkout->title}</h4>
                        <h4 class='text-content'>{$checkout->item->item_ref}</h4>
                        <div class='flex-checkout' style='cursor: pointer;'>
                            <img src='{$deleteImageUrl}' alt='delete' onclick='unsetCheckout({$checkout->id})'/>
                        </div>
                      </div>";
            array_push($checkout_id, $checkout->id);
        }
        $checkout_ids = implode(',', $checkout_id);
        $isButtonDisabled = count($checkout_id) == 0 ? 'disabled' : '';
        $div .= "<input type='hidden' name='check_in' value='{$checkout_ids}'> <input type='hidden' name='type' value='{$request->type}'>
        <input type='hidden' name='staff_id' value='{$request->staff_id}'> ";
        $div .= "</div></div><div class='btn-center btn-end-new'>
              <button type='button' class='btn btn-color-new' id='return' {$isButtonDisabled}>Check out</button>
            </div> 
          </div>
        </div>";

        return response()->json([
            'status' => true,
            'data' => $div ,
            'checkoutId'=>$checkoutId
        ]);
    }
    public function CheckOut(Request $request)
    { 
        $checkoutIds = explode(',', $request->check_out);
        $isCheckout=Checkout::whereIn('id',$checkoutIds)->update(['status' => 'returned']);
        if($isCheckout){
            return response()->json([
                'status' => true,
                'data' => 'Successfully check-out' ,
                'redirect_to'=>'check-out-success'
            ]);
        }else{
            return response()->json([
                'status' => false,
                'err' => 'Server Error' 
            ]);
        }
       
    }
    public function CheckOutSuccess()
    {   
        return view('check-out');
    }
    
}
