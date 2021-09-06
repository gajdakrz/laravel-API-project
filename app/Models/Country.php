<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [
        'id', 'name', 'country', 'rate_per_day', 'updated_at' , 'created_at'
    ];
}
