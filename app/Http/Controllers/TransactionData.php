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
        $user = Auth::user()->id; // Get Current User
        $uw = DB::table('warehouse_has_users')->select('wid')->where('uid', $user)->get();
        $sor= $uw->toArray();
        $wid = $uw[0]->wid;
        $wname = DB::table('warehouses')->select('wid','city')->where('id', $wid)->get();
        $assigned_ware = $wname[0]->wid;
        //Get Lanes
        $tqry = Transaction::where('source', $assigned_ware)->get();
        $trns= $tqry->toArray();

        $response = \GoogleMaps::load('geocoding')
		->setParam (['address' =>'Karnal'])
 		->get();
       // echo "<pre>";print_r($data);die;
        return view('outgoing-transactions',  ['data' => $response]);
    }
        
    public function incoming_transactions() 
    {

        $user = Auth::user()->id; // Get Current User
        $uw = DB::table('warehouse_has_users')->select('wid')->where('uid', $user)->get();
        $sor= $uw->toArray();
        $wid = $uw[0]->wid;
        $wname = DB::table('warehouses')->select('wid','city')->where('id', $wid)->get();
        $assigned_ware = $wname[0]->wid;
        //Get Lanes
        $tqry = Transaction::where('destination', $assigned_ware)->get();
        $trns= $tqry->toArray();

    
    }


            
}
