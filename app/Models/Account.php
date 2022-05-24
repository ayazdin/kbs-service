<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use DB;

class Account extends Model
{
  public function getAccountsByUser($uid)
  {
    $accounts = Account::where('status', 'paid')
                ->where('uid', $uid)
                ->get();
    return $accounts;
  }

  public function getTotalByUser($uid)
  {
    $tp = Account::where('status', 'paid')
                      ->where('uid', $uid)
                      ->select(DB::raw('sum(amount) AS total'))
                      ->first();
    return $tp->total;
  }

  public function getTotalTransaction()
  {
    $tp = Account::where('status', 'paid')
                      ->select(DB::raw('sum(amount) AS total'))
                      ->first();
    return $tp->total;
  }

  public function getTransNumberByUser($uid)
  {
    $totalTrans = DB::table('accounts')
                      ->where('uid', $uid)
                      ->count();
    return $totalTrans;
  }

  public function getTransNumber()
  {
    $totalTrans = DB::table('accounts')
                      ->count();
    return $totalTrans;
  }

}
