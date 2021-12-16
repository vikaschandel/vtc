<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lane extends Model
{
    protected $table = 'lanes';
    protected $fillable = [
        'from','destination','vehicle_type','lead_time'
    ];
}
