<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';
    protected $fillable = [
        'tid','source','destination','lane','vehicle_no','vtype','transit_load','seal','driver','transporter','lr','product','invoice','idate','status', 'created_by'
    ];
}