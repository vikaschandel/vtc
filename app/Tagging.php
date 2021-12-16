<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagging extends Model
{
    protected $table = 'taggings';
    protected $fillable = [
        'wid','transporters'
    ];
}
