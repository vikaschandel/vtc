<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class warehouse_has_user extends Model
{
    protected $table = 'warehouse_has_user';
    protected $fillable = [
        'wid','uid'
    ];
}
