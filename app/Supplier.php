<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'type', 'name', 'address', 'contact', 'email', 'total_balance', 'paid', 'image'
    ];
}
