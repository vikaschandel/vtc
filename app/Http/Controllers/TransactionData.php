<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Warehouse;
use App\vehicle;
use App\driver;
use App\transporter;
use App\lane;
use App\product;
use App\Transaction;
use App\Tagging;
use Response;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DataTables,Auth;

class TransactionData extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /////////////////////   Outgoing Transaction from warehouse to warehouse ////////////////////

    public function outgoing_transactions() 
    {
        return view('outgoing-transactions');
    }

    public function outgoing_dt() 
    {
        $user = Auth::user()->id; // Get Current User
        $uw = DB::table('warehouse_has_users')->select('wid')->where('uid', $user)->get();
        $sorted= $uw->toArray();
        $ass = $sorted[0]->wid;
        $warr = explode(',', $ass);
        $trns = array();
        foreach($warr as $w){
            $tqry = Transaction::where('source', $w)->get();
            $res = count($tqry);
            if($res > 0){
                $trns[]= $tqry->toArray();
            }
        }

        $userTrans = call_user_func_array('array_merge', $trns);
        $array_out = array();
        foreach($userTrans as $key => $txn){
        $qry = lane::select('from','destination as city','lead_time')->where('id',$txn['lane'])->get();
        $res= $qry->toArray();
        $cr = $txn['created_at'];
        $date = explode('T', $cr);
        if(empty($res)){
           $res=  array();
           $res[$key]['from'] = '0';
           $res[$key]['city'] = '0';
           $res[$key]['lead_time'] = '0';
        }
        
        $res[$key]['start_date'] = date("d-m-Y", strtotime($date[0])); 
        $rs = call_user_func_array('array_merge', $res);
        $array_out[]= array_merge($txn, $rs);
        }
       //echo "<pre>";print_r($array_out);
        return Response::json(['data' => $array_out]);
    }
       
        
    public function incoming_transactions() 
    {

        $user = Auth::user()->id; // Get Current User
        $uw = DB::table('warehouse_has_users')->select('wid')->where('uid', $user)->get();
        $sorted= $uw->toArray();
        $ass = $sorted[0]->wid;
        $warr = explode(',', $ass);
        $trns = array();
        foreach($warr as $w){
            $tqry = Transaction::where('destination', $w)->get();
            $res = count($tqry);
            if($res > 0){
                $trns[]= $tqry->toArray();
            }
        }
        $userTrans = call_user_func_array('array_merge', $trns);
        $array_out = array();
        foreach($userTrans as $txn){
        $qry = lane::select('from','destination as city','lead_time')->where('id',$txn['lane'])->get();
        $res= $qry->toArray();
        $rs = call_user_func_array('array_merge', $res);
        $array_out[]= array_merge($txn, $rs);
        }
       // echo "<pre>";print_r($array_o);
        //;
        return view('incoming-trans',  ['data' => $array_out]);

    
    }

   ////////////////////////////////////  Get Assigned Warehouses //////////////////////////////////////

   public function get_assigned() 
   {
       $city = explode(',', $_POST['org']);
       $user = Auth::user()->id;
       $uw = DB::table('warehouse_has_users')->select('wid')->where('uid', $user)->get();
       $res = $uw->toArray();
       if(!empty($res)){
       $wid = $uw[0]->wid;
       $ids = str_split(str_replace(',', '', $wid));
       $wname = DB::table('warehouses')->select('id','warehouse','city')->whereIn('id', $ids)->where('city', 'like', $city[0].'%')->get();
       $assigned =  $wname->toArray();
       //
       if(!empty($assigned)) {
           ?>
           <label for="fromwarehouse" class="form-label">From Warehouse</label> 
           <select name="assigned" id="source" class="form-select">
           <?php
           foreach($assigned as $w) {
           ?>
           <option value="<?php echo $w->id;?>"><?php echo $w->warehouse;?></option>
           <?php } ?>
           </select>
           <?php }
           else{
            echo "<p class='text-danger'>No warehouse assigned in the selected city</p>";
           }
       }
       else{
           echo "<p class='text-danger'>No warehouse assigned</p>";
       }
   }
   
   ////////////////////////////////////  Get Destination Warehouses //////////////////////////////////////

   public function get_destination() 
   {
       $city = explode(',', $_POST['dest']);
       $wname = DB::table('warehouses')->select('id','warehouse','city')->where('city', 'like', $city[0].'%')->get();
       $available =  $wname->toArray();
       //echo "<pre>";print_r($available);die;
       if(!empty($available)) {
           ?>
           <label for="fromwarehouse" class="form-label">TO Warehouse</label> 
           <select name="to_warehouse" id="to_warehouse" class="form-select">
           <?php
           foreach($available as $w) {
           ?>
           <option value="<?php echo $w->id;?>"><?php echo $w->warehouse;?></option>
           <?php } ?>
           </select>
           <?php }
           else{
            echo "<p class='text-danger'>No warehouse assigned in the selected city</p>";
           }

   }
   

    ///////////////////////////////// Create New Transaction /////////////////////////////////

       public function add_new_transaction()
       {
           
           //echo "<pre>";print_r($_POST);die;
           try
           { 
                $o= $_POST['origin'];
                $or= explode(',', $o);
                $origin = $or[0];
                $d = $_POST['destination'];
                $de= explode(',', $d);
                $destination = $de[0];
                $roundCap = round($_POST['trnl']);
                $qry = lane::select('id')->whereIn('from', [$origin, $destination])->whereIn('destination', [$origin, $destination])->whereRaw('FIND_IN_SET(?, vehicle_type)', [$roundCap])->get();
                $lanes = $qry->toArray();
                $singleD = call_user_func_array('array_merge', $lanes);
                if(!empty($singleD)){
                    $laneid = $singleD;
                }
                else{
                    $laneid = '000';
                }
                //echo "<pre>"; print_r($singleD); die;
                $chk = Transaction::where('lr', $_POST["lr"])->get();
                $co = count($chk);
                if($co>0){
                    $response['message'] = "Transaction for this LR is already created";
                    return Response::json($response);
                }
               else{
                $transaction = Transaction::create([
                    'source' => $_POST['assigned'],
                    'destination' => $_POST['to_warehouse'],
                    'lane' => $laneid,
                    'vehicle_no' => $_POST['vlist'],
                    'vtype' => $_POST['vtype'],
                    'transit_load' => $_POST['trnl'],
                    'transporter' => $_POST['trp'],
                    'seal' => $_POST['seal'],
                    'driver' => $_POST['driver'],
                    'lr' => $_POST['lr'],
                    'product' => $_POST['pname'],
                    'invoice' => $_POST['invoice'],
                    'idate' => $_POST['idate'],
                    'status' => '1',
                ]);
               $transaction->save();
               $lid = $transaction->id;
               $prefix = "TRN-000";
               $transaction_id = $prefix.''.$lid;
               $tid = Transaction::where('id', $lid)->update(['tid' => $transaction_id]);
               $response['success'] = true;
               return Response::json($response);
             }
   
           }catch (\Exception $e) {
               $bug = $e->getMessage();
               $response['message'] = $bug;
               return Response::json($response);
   
           }
       }
   

}
