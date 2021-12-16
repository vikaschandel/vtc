<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Imports\BulkImport;
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
use Maatwebsite\Excel\Facades\Excel;
use DataTables,Auth;

class TransactionController extends Controller
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
    
    public function create_transaction() 
    {
        $user = Auth::user()->id;
        $uw = DB::table('warehouse_has_users')->select('wid')->where('uid', $user)->get();
        $sor= $uw->toArray();
        if(empty($sor) && $user != 1){
            return redirect('404');   
        }
        elseif($user == 1){
            $wname = DB::table('warehouses')->select('wid')->get();
            $assigned_ware = '';
            $vehicle = DB::table('vehicles')->distinct()->get();
            $v= $vehicle->toArray();
            $trans = DB::table('taggings')->select('transporters')->get();
            $t= $trans->toArray();
            $uns = unserialize($t[0]->transporters);
            //echo "<pre>"; print_r($uns);die;
            //Currently working for 1 warehouse
            return view('create-transaction',  ['vehicle' => $v, 'transporter' => $uns, 'assigned' => $assigned_ware]); 
        }
        else{
        $wid = $uw[0]->wid;
        $wname = DB::table('warehouses')->select('wid')->where('id', $wid)->get();
        $assigned_ware = $wname[0]->wid;
        $vehicle = DB::table('vehicles')->distinct()->get();
        $v= $vehicle->toArray();
        $trans = DB::table('taggings')->select('transporters')->where('wid', $assigned_ware)->get();
        $t= $trans->toArray();
        if(!empty($t)){
            $uns = unserialize($t[0]->transporters);
            return view('create-transaction',  ['vehicle' => $v, 'transporter' => $uns, 'assigned' => $assigned_ware]);   
        }
        else{
            return view('create-transaction',  ['vehicle' => $v]); 
        }
        
       }
        //return back();
    }

    public function suggested_lanes() 
    {
        $qry = Warehouse::select('wid')->where('wid', 'like', $_GET["keyword"].'%')->get();
        $suggestions = $qry->toArray();
        //echo "<pre>"; print_r($suggestions);die;
        if(!empty($suggestions)) {
            ?>
            <ul id="warehouse-list">
            <?php
            foreach($suggestions as $w) {
            ?>
            <li onClick="selectWarehouse('<?php echo $w["wid"]; ?>');"><?php echo $w["wid"]; ?></li>
            <?php } ?>
            </ul>
            <?php }
           
        //return back();
    }

    public function suggested_desti() 
    {
        //echo "<pre>"; print_r($_GET['source']);die;
        $qry = Warehouse::select('wid')->where('wid', 'not like', $_GET['source'].'%')->get();
        $suggestions = $qry->toArray();
        
        if(!empty($suggestions)) {
            ?>
            <ul id="warehouse-list">
            <?php
            foreach($suggestions as $w) {
            ?>
            <li onClick="selectDesti('<?php echo $w["wid"]; ?>');"><?php echo $w["wid"]; ?></li>
            <?php } ?>
            </ul>
            <?php }
           
        //return back();
    }
    
    public function getLanes() 
    {
        
        $scity = Warehouse::select('city')->where('wid', $_GET['source'])->get();
        $dcity = Warehouse::select('city')->where('wid', $_GET['destination'])->get();
        $source = $scity->toArray();
        $destination = $dcity->toArray();
       // echo "<pre>"; print_r($source);
       // echo "<pre>"; print_r($destination);
        //die;
        $qry = lane::where('from', $source[0]['city'])->where('destination', $destination[0]['city'])->get();
        $lanes = $qry->toArray();
       // echo "<pre>"; print_r($lanes);die;
        //return back();
        if(!empty($lanes)) {
            ?>
            <label for="lanes" class="form-label">Lanes</label>
            <select id="lanes" name="lanes" class="form-select">
            <option disabled selected>Choose lane....</option>
            <?php
            foreach($lanes as $lane) {
            $lname = $lane['from'].' &#xf061; '.$lane['destination'].' &#xf0d1; '.$lane['vehicle_type'].' &#xf017; '.$lane['lead_time']; 
            ?>
           <option value="<?php echo $lane['id'];?>"><?php echo $lname;?></option>
            <?php } ?>
            </select>
            <input type="hidden" value="<?php echo $lane['vehicle_type'];?>">
            <?php }						
    }

    public function check_vehicles() 
    {
        $veh = vehicle::select('type')->where('vehicle_no', 'like', $_GET["vehicle"].'%')->get();
        $scity = Warehouse::select('city')->where('wid', $_GET['source'])->get();
        $dcity = Warehouse::select('city')->where('wid', $_GET['destination'])->get();
        $source = $scity->toArray();
        $destination = $dcity->toArray();
        $lne = lane::select('vehicle_type', 'id')->where('from', $source[0]['city'])->where('destination', $destination[0]['city'])->get();
        $vtype = $veh->toArray();
        $vc = $vtype[0]['type'];
        $lanev = $lne->toArray();
        $lid = '';
        foreach($lanev as $lane){
           $l = $lane['vehicle_type'];
           $vt = $vtype[0]['type'];
           $exp = explode('-', $l);
           $min = $exp[0];
           $max = $exp[1]; 
           if($min <= $vt && $vt <= $max ){
              $lid .= $lane['id'];
           }
        }
        $vehicle_type = $vtype[0]['type'];
        $response['vt'] = $vehicle_type;
        $response['lane'] = $lid;
        return Response::json($response);
        
    }

    /*********************** Create New Transaction *************************/

    public function add_new_transaction()
    {
        try
        {
            $chk = Transaction::where('lr', $_POST["lr"])->get();
            $co = count($chk);
            if($co>0){
                $response['message'] = "Transaction for this LR is already created";
                return Response::json($response);
          }
          else{
            $transaction = Transaction::create([
                'source' => $_POST['source'],
                'destination' => $_POST['dest'],
                'lane' => $_POST['lanes'],
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

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////// Function required to create a transaction (Warehouse, vehicles, lanes, transporters,) ////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function create_lanes() 
    {

        $warehouse = DB::table('warehouses')->select('city')->distinct()->get();
        $w = $warehouse->toArray();
        $vehicle = DB::table('vehicles')->select('type')->distinct()->get();
        $v= $vehicle->toArray();
        return view('create-lanes',  ['warehouse' => $w, 'vehicle' => $v]);
           
        //return back();
    }

   /** 
    * Add a warehouse
    */
    public function add_warehouse()
    {
        try
        {
            $w = $_POST['warehouse_name'];
            $ex = explode(' ', $w);
            $arr = array($ex[0],$ex[1], $_POST['sdcf']);
            $imp = implode('-',$arr);
            $chkw = DB::table('warehouses')->select('warehouse')->where('warehouse', $_POST['warehouse_name'])->get();
            $cw = count($chkw);
            $did = $cw+1;
            if($did != 1){
                $wid = $imp.'-'.$did;
            }
            else{
                $wid = $imp;
            }
           // echo "<pre>"; print_r();die;
            $warehouse = Warehouse::create([
                'wid' => $wid,
                'warehouse' => $_POST['warehouse_name'],
                'type' => $_POST['wtype'],
                'address' => $_POST['waddress'],
                'city' => $_POST['wcity'],
                'state' => $_POST['state'],
                'zip' => $_POST['wzip'],
                'cords' => $_POST['w_cords'],
            ]);

            $warehouse->save();
            $response['success'] = true;
            return Response::json($response);

        }catch (\Exception $e) {
            $bug = $e->getMessage();
            $response['message'] = $bug;
            return Response::json($response);

        }
    }

    public function getWareList(Request $request)
    {
        
        $data  = Warehouse::get();

        return Datatables::of($data)->addColumn('action', function($data){
            if($data->name == 'Super Admin'){
                return '';
            }
            if (Auth::user()->can('manage_user')){
                return '<div class="table-actions">
                        <a href="'.url('warehouse/delete/'.$data->id).'"><span class="badge bg-gradient-quepal">Delete</span></a>
                    </div>';
            }else{
                return '';
            }
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function delete($id)
    {
        $warehouse   = Warehouse::find($id);
        if($warehouse){
            $warehouse->delete();
            return redirect('warehouseList')->with('success', 'Warehouse removed!');
        }else{
            return redirect('warehouseList')->with('error', 'Warehouse not found');
        }
    }


    public function add_tagging() 
    {
        try{
            $ftag = Tagging::where('wid', $_POST['warehousename'])->get();;
            $co = count($ftag);
            //echo $co; die;
            if($co>0){
                $response['messages'] = "Tagging is already available, please update the same.";
                return Response::json($response);
            }
            else{
                $tarr = $_POST['trps'];
                $trps = serialize($tarr);
                $tags = Tagging::create([
                    'wid' => $_POST['warehousename'],
                    'transporters' => $trps,
                ]);
                $tags->save();
                $response['success'] = true;
                return Response::json($response);
            }

        }
        catch (\Exception $e) {
            $bug = $e->getMessage();
            $response['messages'] = $bug;
            return Response::json($response);

        }

    }

    public function getTaged(Request $request)
    {
        
        $data  = Tagging::get();

        return Datatables::of($data)->addColumn('transporters', function($data){
            $w= $data->toArray();
            $un = unserialize($w['transporters']);
            $trn = '';
            foreach($un as $t){
                $trn .= $t .', ' ;
            }
            return $trn;
        })
        ->addColumn('action', function($data){
            if($data->name == 'Super Admin'){
                return '';
            }
            if (Auth::user()->can('manage_user')){
                return '<div class="table-actions">
                        <a href="'.url('tags/edit/'.$data->id).'" ><span class="badge bg-gradient-blooker ">Edit</span></a>
                        <a href="'.url('tags/delete/'.$data->id).'"><span class="badge bg-gradient-quepal">Delete</span></a>
                    </div>';
            }else{
                return '';
            }
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function edit_tags($id)
    {
        try
        {
            $tags  = Tagging::find($id);

            if($tags){
                $t= $tags->toArray();
                $wid = $t['wid'];
                $wlist = unserialize($t['transporters']);
                //echo "<pre>";print_r($wlist);die;
                $trans = DB::table('transporters')->distinct()->get();
                $trn = $trans->toArray();
                return view('tag-edit', ['wid' => $wid, 'transporter' => $trn, 'slt' => $wlist]);
            }else{
                return redirect('404');
            }

        }catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    public function update_tagging() 
    {
        try{
                $tarr = $_POST['trps'];
                $trps = serialize($tarr);
                
                $tags = Tagging::where('wid', '=', $_POST['warehousename'])->update(array('transporters' => $trps));
                $response['success'] = true;
                return Response::json($response);


        }
        catch (\Exception $e) {
            $bug = $e->getMessage();
            $response['messages'] = $bug;
            return Response::json($response);

        }

    }

   /** 
    * Add a Vehicle
    */
    public function add_vehicle()
    {
        try
        {
            $file = request()->file('uploadrc');
            $filename = 'rc-' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('vehicles', $filename);
            //echo "<pre>"; print_r($_POST);die;
            $vehicle = vehicle::create([
                'vehicle_no' => $_POST['vno'],
                'type' => $_POST['cap'],
                'unladen_weight' => $_POST['unladen'],
                'gvw' => $_POST['gvw'],
                'filepath' => $path,
            ]);

            $vehicle->save();
            $response['success'] = true;
            return Response::json($response);

        }catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);

        }
    }

    public function getvlist(Request $request)
    {
        
        $data  = vehicle::get();

        return Datatables::of($data)->addColumn('action', function($data){
            if($data->name == 'Super Admin'){
                return '';
            }
            if (Auth::user()->can('manage_user')){
                return '<div class="table-actions">
                        <a href="'.url('vehicle/delete/'.$data->id).'"><span class="badge bg-gradient-quepal">Delete</span></a>
                    </div>';
            }else{
                return '';
            }
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function delete_vehicle($id)
    {
        $vehicle   = vehicle::find($id);
        if($vehicle){
            $vehicle->delete();
            return redirect('vehiclesList')->with('success', 'Vehicle removed!');
        }else{
            return redirect('vehiclesList')->with('error', 'Vehicle not found');
        }
    }

   /** 
    * Add a Transporter
    */

    public function add_transporter()
    {
        try
        {

            $file = request()->file('uploadrc');
            //echo "<pre>"; print_r($_POST);die;
            $transporter = transporter::create([
                'transporter_name' => $_POST['tname'],
                'gst_number' => $_POST['tgst'],
                'address' => $_POST['taddress'],
                'city' => $_POST['tcity'],
                'state' => $_POST['tstate'],
                'zip' => $_POST['tzip'],
                'manager_name' => $_POST['mname'],
                'manager_contact' => $_POST['mconum'],
                'emp_name' => $_POST['emname'],
                'emp_contact' => $_POST['econum']
            ]);

            $transporter->save();
            $response['success'] = true;
            return Response::json($response);

        }catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);

        }
    }

    public function trnplist(Request $request)
    {
        
        $data  = transporter::get();

        return Datatables::of($data)->addColumn('action', function($data){
            if($data->name == 'Super Admin'){
                return '';
            }
            if (Auth::user()->can('manage_user')){
                return '<div class="table-actions">
                        <a href="'.url('transporter/delete/'.$data->id).'"><span class="badge bg-gradient-quepal">Delete</span></a>
                    </div>';
            }else{
                return '';
            }
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function delete_transporter($id)
    {
        $trp   = transporter::find($id);
        if($trp){
            $trp->delete();
            return redirect('transportList')->with('success', 'Transporter removed!');
        }else{
            return redirect('transportList')->with('error', 'Transporter not found');
        }
    }

    public function create_tagging() 
    {

        $warehouse = DB::table('warehouses')->distinct()->get();
        $v= $warehouse->toArray();
        $trans = DB::table('transporters')->distinct()->get();
        $t= $trans->toArray();
        return view('transporters-tagging',  ['warehouse' => $v, 'transporter' => $t]);
           
        //return back();
    }
     /** 
    * Add Lanes
    */

    public function add_lane()
    {
        try
        {
           // echo "<pre>"; print_r($_POST);die;
           $leadtime = $_POST['leadtime'].' '.$_POST['lformat'];
            $lane = lane::create([
                'from' => $_POST['from'],
                'destination' => $_POST['destination'],
                'vehicle_type' => $_POST['vtype'],
                'lead_time' => $leadtime,
            ]);

            $lane->save();
            $response['success'] = true;
            return Response::json($response);

        }catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);

        }
    }

    public function lanelist(Request $request)
    {
        
        $data  = lane::get();

        return Datatables::of($data)->addColumn('action', function($data){
            if($data->name == 'Super Admin'){
                return '';
            }
            if (Auth::user()->can('manage_user')){
                return '<div class="table-actions">
                        <a href="'.url('lanes/delete/'.$data->id).'"><span class="badge bg-gradient-quepal">Delete</span></a>
                    </div>';
            }else{
                return '';
            }
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function delete_lane($id)
    {
        $lane   = lane::find($id);
        if($lane){
            $lane->delete();
            return redirect('lanesList')->with('success', 'Lane removed!');
        }else{
            return redirect('lanesList')->with('error', 'Lane not found');
        }
    }


    /////////////////////////////// Products ////////////////////////////////

    public function add_product()
    {
        try
        {
           // echo "<pre>"; print_r($_POST);die;;
            $product = product::create([
                'name' => $_POST['pname'],
            ]);

            $product->save();
            $response['success'] = true;
            return Response::json($response);

        }catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);

        }
    }

    public function productlist(Request $request)
    {
        
        $data  = product::get();

        return Datatables::of($data)->addColumn('action', function($data){
            if($data->name == 'Super Admin'){
                return '';
            }
            if (Auth::user()->can('manage_user')){
                return '<div class="table-actions">
                        <a href="'.url('products/delete/'.$data->id).'"><span class="badge bg-gradient-quepal">Delete</span></a>
                    </div>';
            }else{
                return '';
            }
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function delete_product($id)
    {
        $product   = product::find($id);
        if($product){
            $product->delete();
            return redirect('products')->with('success', 'Product removed!');
        }else{
            return redirect('products')->with('error', 'Product not found');
        }
    }

   /** 
    * all imports
    */

    public function imports() 
    {
        try
        {   
            //echo "<pre>";print_r($_POST);die;
            $data = Excel::import(new BulkImport,request()->file('uploadata'));
            $response['success'] = true;
            return Response::json($response);

        }catch (\Exception $e) {
            $bug = $e->getMessage();
            $response['success'] = false;
            $response['messages'] = $bug;
            return Response::json($response);
        }
           
        //return back();
    }


}
