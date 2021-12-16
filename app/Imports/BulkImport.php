<?php
namespace App\Imports;
use Illuminate\Support\Facades\DB;
use App\Warehouse;
use App\vehicle;
use App\driver;
use App\transporter;
use App\lane;
use App\product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class BulkImport implements ToModel,WithHeadingRow
{
	/**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

       //echo "<pre>";print_r($row); die;
        if($_POST['itype'] == 1){
            $w = $row['warehouse'];
            $ex = explode(' ', $w);
            $arr = array($ex[0],$ex[1], $row['sdcf_name']);
            $imp = implode('-',$arr);
            $chkw = DB::table('warehouses')->select('warehouse')->where('warehouse', $row['warehouse'])->get();
            $cw = count($chkw);
            $did = $cw+1;
            if($did != 1){
                $wid = $imp.'-'.$did;
            }
            else{
                $wid = $imp;
            }
            return new Warehouse([
            'wid' => $wid,
            'warehouse'  => $row['warehouse'],
            'type'    => $row['type'],
            'address' => $row['address'],
            'city'   => $row['city'],
            'state'   => $row['state'],
            'zip'   => $row['zip'],
            'cords'   => $row['cords']
        ]);
       }

       if($_POST['itype'] == 2){ 
        $unladen_weight = $row['unladen_weight'];
        $gvw = $row['gvw'];
        $vehicle_capacity = $gvw - $unladen_weight;
        $type = $vehicle_capacity / 1000;
        return new vehicle([
        'vehicle_no'  => $row['vehicle_no'],
        'type'    => round($type, 2),
        'unladen_weight'    => $row['unladen_weight'],
        'gvw'    => $row['gvw'],
        'filepath'   => $row['rc_file']
    ]);
   }

    if($_POST['itype'] == 3){
            return new driver([
            'driver_name'  => $row['driver_name'],
            'contact_no'    => $row['contact_no'],
            'dl_number' => $row['dl_number'],
            'dl_file'   => $row['dl_file']
        ]);
        }

    if($_POST['itype'] == 4){
        return new transporter([
        'transporter_name'  => $row['transporter_name'],
        'gst_number'    => $row['gst_number'],
        'address' => $row['address'],
        'city'   => $row['city'],
        'state'   => $row['state'],
        'zip'   => $row['zip'],
        'manager_name'   => $row['manager_name'],
        'manager_contact'   => $row['contact_no'],
        'emp_name'   => $row['emp_name'],
        'emp_contact'   => $row['emp_no']
    ]);
    }

    if($_POST['itype'] == 5){
        return new lane([
        'from'  => $row['from'],
        'destination'    => $row['destination'],
        'vehicle_type' => $row['vehicle_type'],
        'lead_time'   => $row['lead_time']
    ]);
    }    

    if($_POST['itype'] == 6){
        return new product([
        'name'  => $row['product_name'],
    ]);
    }   
   
}
    
}