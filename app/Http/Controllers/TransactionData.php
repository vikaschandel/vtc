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

    public function outgoing_dt(Request $request) 
    {
        $user = Auth::user()->id; // Get Current User
        $urole  = Auth::user()->roles()->get();
        $role = $urole[0]->name;
        if($role == 'Warehouse Manager' || $role == 'Super Admin'){
                if($role == 'Warehouse Manager'){
                    $uw = DB::table('warehouse_has_users')->select('wid')->where('uid', $user)->get();
                    $sorted= $uw->toArray();   
                    $ass = $sorted[0]->wid;
                }else{
                    $get_wid = Warehouse::select('id')->get();
                    $sids = array();
                    foreach($get_wid as $wid){
                       $sids[] = $wid->id;
                    }
                    $ass = implode(',',$sids);
                }
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
                $qry_sware = Warehouse::select('warehouse', 'city', 'state')->where('id',$txn['source'])->get();
                $qry_dware = Warehouse::select('warehouse', 'city', 'state')->where('id',$txn['destination'])->get();      
                // echo "<pre>"; print_r($qry_sware[0]->warehouse);die;
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

                $res[$key]['source'] = $qry_sware[0]->warehouse;
                $res[$key]['destination'] = $qry_dware[0]->warehouse;
                $res[$key]['route_source'] = $qry_sware[0]->city.', '.$qry_sware[0]->state;
                $res[$key]['route_destination'] = $qry_dware[0]->city.', '.$qry_dware[0]->state;
                $rs = call_user_func_array('array_merge', $res);
                $array_out[]= array_merge($txn, $rs);
                }
                $data = $array_out;
                return Datatables::of($data)
                ->addColumn('route', function($data){
                //echo "<pre>";print_r($data);die;
                $troute = '<ul class="ant-timeline">
                <li class="ant-timeline-item  css-b03s4t">
                    <div class="ant-timeline-item-tail"></div>
                    <div class="ant-timeline-item-head ant-timeline-item-head-green"></div>
                    <div class="ant-timeline-item-content">
                        <div class="css-16pld72">'.$data['route_source'].', India</div>
                    </div>
                </li>
                <li class="ant-timeline-item ant-timeline-item-last css-phvyqn">
                    <div class="ant-timeline-item-tail"></div>
                    <div class="ant-timeline-item-head ant-timeline-item-head-red"></div>
                    <div class="ant-timeline-item-content">
                    <div class="css-16pld72">'.$data['route_destination'].', India</div>
                    <div class="css-16pld72" style="font-size: 12px; color: rgb(102, 102, 102);">     
                        <span>'.$data['destination'].', </span>
                        <span>'.$data['route_destination'].'</span>
                    </div>
                    </div>
                </li>
                </ul>';
                    return $troute;
                })
                ->addColumn('transporters', function($data){
                     
                    $trps = '<ul class="ant-timeline">
                               <li class="ant-timeline-item"><h5>'.$data['vehicle_no'].'</h5><li>
                               <li class="ant-timeline-item">'.$data['transporter'].'<li>
                             </ul>'; 

                    return $trps;
                })
                ->addColumn('shipping', function($data){
                  //echo "<pre>";print_r($data);die;
                     
                    $bar = '<div class="progress" style="height: 6px;">
                    <div class="progress-bar bg-gradient-quepal" role="progressbar" style="width: 100%"></div>
                    </div>'; 

                    return $bar;
                })
                ->addColumn('status', function($data){
                    if($data['status'] == 0){
                     $st = '<span class="badge alert bg-secondary shadow-sm">Unknown</span>';
                    } 
                    elseif($data['status'] == 1){
                        $st = '<span class="badge bg-info shadow-sm">Incoming</span>';    
                    }
                    elseif($data['status'] == 2){
                        $st = '<span class="badge bg-success">Received</span>';    
                    }
                    elseif($data['status'] == 3){
                        $st = '<span class="badge bg-gradient-bloody text-white shadow-sm ">Delayed</span>';  
                    }

                    return $st;
                })
                ->rawColumns(['route', 'transporters','shipping','status'])
                ->make(true);
        }
        else{
            echo "You don't have the access";
        }
       
    }

    /************************* Incoming transaction datatable API **************************/  

    public function incoming_trans_dt() 
    {
        $user = Auth::user()->id; // Get Current User
        $urole  = Auth::user()->roles()->get();
        $role = $urole[0]->name;
        if($role == 'Security Guards'){
                $uw = DB::table('warehouse_has_users')->select('wid')->where('uid', $user)->get();
                $sorted= $uw->toArray();   
                $ass = $sorted[0]->wid;
                $warr = explode(',', $ass);
                $trns = array();
                foreach($warr as $w){
                    $tqry = Transaction::where('destination', $w)->where('status', 1)->get();
                    $res = count($tqry);
                    if($res > 0){
                        $trns[]= $tqry->toArray();
                    }
                }
                $userTrans = call_user_func_array('array_merge', $trns);
                //echo "<pre>";print_r($userTrans);die;
                $data = $userTrans;
                return Datatables::of($data)
                ->addColumn('status', function($data){
                    $stat = '<h5>'.$data['vehicle_no'].'</h5><div class="badge rounded-pill text-danger bg-light-success p-2 text-uppercase px-3"><i class="bx bxs-circle me-1"></i>Incoming</div>';
                    return $stat;
                })
                ->addColumn('action', function($data){
                    $button = '<a href="'.url('transactions/entry/'.$data['id']).'"><span class="btn btn-primary px-3 radius-30">Click for Gate Entry</span></a>'; 
                    return $button;
                })
                ->rawColumns(['status','action'])
                ->make(true);
        }
        else{
            echo "You don't have the access";
        }
    }

    /************************* Incoming Transaction entry to warehouse **************************/ 

    public function vehicle_entry(Request $request){


        try{

            $file = $request->file('file');
            $filename = time().'_'.$file->getClientOriginalName();
            // File upload location
            $location = 'files';
            // Upload file
            $file->move($location,$filename);
            $path= url('files/'.$filename);
            if($path){
            $txn = Transaction::find($request->tid);
            $update = $txn->update([
                'status' => 2,
                'filepath' => $path
            ]);
            $response['success'] = true;
            $response['message'] = 'Success';
            return Response::json($response);
           }
           else{
            $response['success'] = false;
            $response['message'] = 'Error';
            return Response::json($response);
           }

        }catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);

        }

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
                    $laneid = $singleD['id'];
                }
                else{
                    $laneid = '000';
                }
               // echo "<pre>"; print_r($singleD['id']); die;
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
               //die;
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
