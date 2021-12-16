<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transporter extends Model
{

    protected $table = 'transporters';
    protected $fillable = [
        'transporter_name','gst_number','address','city','state','zip','manager_name','manager_contact','emp_name','emp_contact','created_by'
    ];
}
