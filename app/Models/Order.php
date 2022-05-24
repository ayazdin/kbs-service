<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $fillable = ['uid', 'pid', 'sessid', 'orderid', 'quantity', 'status'];
}
