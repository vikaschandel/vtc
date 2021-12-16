<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class driver extends Model
{
    protected $table = 'drivers';
    protected $fillable = [
        'driver_name','contact_no','dl_number','dl_file'
    ];
}
