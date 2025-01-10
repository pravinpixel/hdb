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
            <div class='input-group '>
                <input type='text' class='form-control background-textbox' name='staff_id' placeholder='eg. V15267' aria-label='Sizing example input' aria-describedby='inputGroup-sizing-default' autocomplete='off'>
               
            </div>
             <b style='color:red; display: inline-flex;height: 30px;' id='staffErr'></b>
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
        $user=User::where('member_id',$request->staff_id)->where('is_active',1)->first();
        if(!$user){
        return response()->json([
            'status' => false,
            'err' => 'You have keyed in an invalid ID. Please approach the admin to retrieve your ID' 
        ]);
        }
        if(isset($user->roles[0]) && $user->roles[0]->id !=7){
            return response()->json([
                'status' => false,
                'err' => 'You have keyed in an invalid ID. Please approach the admin to retrieve your ID' 
            ]); 
        }
       if($request->type == 'check-in'){
        $div = "
        <div class='card-staff-check'>
            <div class='card-body-4 '>
                <div class='padd-style-checkout-h2'>

                    <h1 class='h2-text'>Scan your books</h1>
                </div>
                <div class='input-group mb-3'>
                    <input type='text' class='form-control background-textbox' placeholder='Scan your book on the RFID Pad' aria-label='Sizing example input' aria-describedby='inputGroup-sizing-default' name='item_ref' id='scan-data' autocomplete='off'>
                
                 <b style='color:red' id='itemErr'></b>
                     <input type='hidden' name='type' value='{$request->type}'>
                 <input type='hidden' name='staff_id' value='{$request->staff_id}'> 
                 </div>
                 <div class='item_data' id='item_data'> </div>
                <div class='btn-center btn-end-new gap-btn'>
                    <button type='button' class='btn btn-color-new-bt' id='clear_function'>Clear & Cancel</button>
                    <button type='button' class='btn btn-color-new padding-btn' id='taken'>Confirm</button>
                </div>
            </div>
        </div>";
       }else{
        $checkouts=Checkout::where('checkout_by',$user->id)->where('status','taken')->get();
        $div = "<div class='card-staff-check'>
           <div class='card-body-2'>
            <div class='padd-style-checkout-h2'>
              <h1 class='h2-text'>Book list for check-in</h1>
            </div>
            <div class='card card-border scrollable-card-body' style='width: 95%; margin: 0 auto;'><div class='card-chekout'>
            ";
            
        $checkout_id = [];
        foreach ($checkouts as $key => $checkout) {
            $no = $key + 1;
            $deleteImageUrl = asset('dark/assets/images/home/delete.png');
            $div .= "<div class='content-flex content-widthadjust'>
                        <h4 class='text-content'>{$no}</h4>
                        <h4 class='text-content'>{$checkout->item->item_ref}</h4>
                        <h4 class='text-content'>{$checkout->title}</h4>
                        <div class='flex-checkout' style='cursor: pointer;'>
                            <img src='{$deleteImageUrl}' alt='delete' onclick='unsetCheckout({$checkout->id})'/>
                        </div>
                      </div><hr class='hr-tag'>";
            array_push($checkout_id, $checkout->id);
        }
        $checkout_ids = implode(',', $checkout_id);
        $isButtonDisabled = count($checkout_id) == 0 ? 'disabled' : ''; 
        $div .= "<input type='hidden' name='check_in' value='{$checkout_ids}'> <input type='hidden' name='type' value='{$request->type}'>
                 <input type='hidden' name='staff_id' value='{$request->staff_id}'> ";
        $div .= "</div></div><div class='btn-center btn-end-new gap-btn'>
          <button type='button' class='btn btn-color-new-bt' id='clear_function'>Clear & Cancel</button>
              <button type='button' class='btn btn-color-new' id='return' {$isButtonDisabled}>Confirm</button>
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
        $item=Item::where('item_ref',$request->item_ref)->where('status',1)->first();
        if(!$item){
        return response()->json([
            'status' => false,
            'err' => 'The Book ID field is required.' 
        ]);
        }
        if($item->is_active == 1){
            return response()->json([
                'status' => false,
                'err' => 'The Book has already been taken.' 
            ]);
        }
        $user=User::where('member_id',$request->staff_id)->first();
        $ins['date']          = now();
        $ins['item_id']        = $item->id;
        $ins['title']        = $item->title;
        $period=isset($item->due_period)?$item->due_period : 21;
        $ins['date_of_return'] = Carbon::now()->addDays($period);
        $ins['checkout_by']    = $user->id;
        Checkout::updateOrCreate(['item_id' => $item->id,'checkout_by'=>$user->id,'status'=>'pending'], $ins);
        $checkouts=Checkout::where('checkout_by',$user->id)->where('status','pending')->get();
        $div = "<div class='card card-border scrollable-card-body-2' margin: 0 auto;'><div class='card-chekout'>";
        $checkout_id = [];
        foreach ($checkouts as $key => $checkout) {
            $no = $key + 1;
            $deleteImageUrl = asset('dark/assets/images/home/delete.png');
            $div .= "<div class='content-flex content-widthadjust' >
                        <h4 class='text-content'>{$no}</h4>
                        <h4 class='text-content'>{$checkout->item->item_ref}</h4>
                        <h4 class='text-content'>{$checkout->title}</h4>
                        <div class='flex-checkout' style='cursor: pointer;'>
                            <img src='{$deleteImageUrl}' alt='delete' onclick='deleteCheckout({$checkout->id})'/>
                        </div>
                      </div><hr class='hr-tag'>";
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
        $isCheckin=Checkout::whereIn('id',$checkinIds)->get();
        foreach($isCheckin as $checkin_data){
            
            $item=Item::find($checkin_data->item_id);
            if($item){
                if($item->is_active == 1){
                    return response()->json([
                        'status' => false,
                        'err' =>$item->item_ref. ' The Book has already been taken.' 
                    ]);
                }
                $item->is_active = 1;
                $item->save();
            }
            $checkin_data->status = 'taken';
            $checkin_data->save();
        }
        if(isset($isCheckin) && count($isCheckin)>0){
            return response()->json([
                'status' => true,
                'data' => 'Successfully check-in' ,
                'redirect_to'=>'check-in-success'
            ]);
        }else{
            return response()->json([
                'status' => false,
                
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
        $div = "<div class='card card-border scrollable-card-body'  margin: 0 auto; '><div class='card-chekout'>";
        $checkout_id = [];
        foreach ($checkouts as $key => $checkout) {
            $no = $key + 1;
            $deleteImageUrl = asset('dark/assets/images/home/delete.png');
            $div .= "<div class='content-flex content-widthadjust'>
                        <h4 class='text-content'>{$no}</h4>
                        <h4 class='text-content'>{$checkout->item->item_ref}</h4>
                        <h4 class='text-content'>{$checkout->title}</h4>
                        <div class='flex-checkout' style='cursor: pointer;'>
                            <img src='{$deleteImageUrl}' alt='delete' onclick='deleteCheckout({$checkout->id})' />
                        </div>
                      </div><hr class='hr-tag'>";
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
              <h1 class='h2-text'>Book list for check-out</h1>
            </div><div class='card card-border scrollable-card-body' style='width: 95%; margin: 0 auto;'><div class='card-chekout'>";
        $checkout_id = [];
        foreach ($checkouts as $key => $checkout) {
            $no = $key + 1;
            $deleteImageUrl = asset('dark/assets/images/home/delete.png');
            $div .= "<div class='content-flex content-widthadjust'>
                        <h4 class='text-content'>{$no}</h4>
                        <h4 class='text-content'>{$checkout->item->item_ref}</h4>
                        <h4 class='text-content'>{$checkout->title}</h4>
                        <div class='flex-checkout' style='cursor: pointer;'>
                            <img src='{$deleteImageUrl}' alt='delete' onclick='unsetCheckout({$checkout->id})'/>
                        </div>
                      </div><hr class='hr-tag'>";
            array_push($checkout_id, $checkout->id);
        }
        $checkout_ids = implode(',', $checkout_id);
        $isButtonDisabled = count($checkout_id) == 0 ? 'disabled' : '';
        $div .= "<input type='hidden' name='check_in' value='{$checkout_ids}'> <input type='hidden' name='type' value='{$request->type}'>
        <input type='hidden' name='staff_id' value='{$request->staff_id}'> ";
        $div .= "</div></div><div class='btn-center btn-end-new'>
           <button type='button' class='btn btn-color-new-bt' id='clear_function'>Clear & Cancel</button>
              <button type='button' class='btn btn-color-new' id='return' {$isButtonDisabled}>Confirm</button>
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
        $isCheckout=Checkout::whereIn('id',$checkoutIds)->get();
        foreach($isCheckout as $checkout_data){
            $checkout_data->checkout_date=now();
            $checkout_data->status = 'returned';
            $checkout_data->save();
            $item=Item::find($checkout_data->item_id);
            if($item){
                $item->is_active = 0;
                $item->save();
            }
        }
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
    public function CheckOutClear(Request $request)
    {   
        if($request->type=='check-in'){
        if(isset($request->check_out) && !empty($request->check_out)){
         $check_outIds = explode(',', $request->check_out);
         Checkout::whereIn('id',$check_outIds)->delete();
        }
            return response()->json([
                'status' => true,
                'data' => '' ,
                'redirect_to'=>'/'
            ]);
        }else{
            return response()->json([
                'status' => true,
                'data' => '' ,
                'redirect_to'=>'/'
            ]);
        }
        return view('check-out');
    }
    
}
