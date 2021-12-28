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

class HomeController extends Controller
{
    
    
    public function index()
    {
        return view('home');
    }

    public function clearCache()
    {
        \Artisan::call('cache:clear');
        return view('clear-cache');
    }

    public function dashboard()
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
                return view('pages.dashboard', ['data' => $userTrans]);
            }
            else{
                return view('pages.dashboard');
            }
        
    }
}
