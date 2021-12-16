<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vehicle extends Model
{
    protected $table = 'vehicles';
    protected $fillable = [
        'vehicle_no','type','unladen_weight','gvw','filepath'
    ];
}
