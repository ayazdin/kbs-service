<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use DB;

class Cart extends Model
{
    public function getTotalAmountByUser($uid)
    {
      $totalOrders = DB::table('carts')
                    ->where('status', '!=', 'cart')
                    ->where('uid', $uid)
                    ->select(DB::raw('sum(quantity*price) AS total'))
                    //->groupBy('orderid')
                    ->first();
      return $totalOrders->total;
    }

    public function getTotalAmount()
    {
      $totalOrders = DB::table('carts')
                    ->where('status', 'done')
                    ->select(DB::raw('sum(quantity*price) AS total'))
                    //->groupBy('orderid')
                    ->first();
      return $totalOrders->total;
    }
}
