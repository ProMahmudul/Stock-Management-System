<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    public function product()
    {
        return $this->hasOne('App\Product', 'box_id', 'box_id');
    }

    public function supplier()
    {
        return $this->belongsTo('App\Supplier');
    }

    public function payment()
    {
        return $this->hasMany('App\Payment', 'box_id', 'box_id');
    }
}
