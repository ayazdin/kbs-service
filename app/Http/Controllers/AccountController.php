<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Cart;
use App\Models\Account;
use App\Models\SupAccount;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    public function getAllCustomers()
    {
      $ordersNum = DB::table('carts')
                    ->where('status', '!=','cart')
                    ->groupBy('orderid')
                    ->get();

      $totalPaid = DB::table('accounts')
                        ->where('status', 'paid')
                        ->select(DB::raw('sum(amount) AS total'))
                        ->first();

      $customers = DB::table('carts')
                  ->where('carts.status', 'done')
                  ->join('users', 'carts.uid', '=', 'users.id')
                  ->select('users.id', 'users.name', DB::raw('sum(carts.quantity*carts.price) AS orderTotal'))
                  ->groupBy('carts.uid')
                  ->get();
      //dd($totalPaid);
      $ac = new Account();
      $cart = new Cart();
      $users = User::where('id','!=', 1)->get();
      return view('adminpanel.account.customers')->with('totalOrders', $cart->getTotalAmount())
                                                  ->with(compact('ordersNum'))
                                                  ->with('totalPaid', $ac->getTotalTransaction())
                                                  ->with('totalTrans', $ac->getTransNumber())
                                                  ->with(compact('customers'))
                                                  ->with(compact('users'));
    }

    public function getAllSuppliers()
    {
      $totalSupply = DB::table('carts')
                    ->where('status', 'done')
                    ->select(DB::raw('sum(quantity*price) AS total'))
                    //->groupBy('orderid')
                    ->first();
      $suppliers = SupAccount::all();
      return view('adminpanel.account.suppliers')->with(compact('suppliers'));
    }

    public function getAmountTotal($uid, $type)
    {
      $account = DB::table('accounts')
                  ->where('uid', $uid)
                  ->where('ctype', $type)
                  ->select(DB::raw('sum(amount) AS totalAmount'))
                  ->first();
      return $account->totalAmount;
    }

    public function setCustomerTransaction(Request $request)
    {
      $transaction = array('uid' => $request->customer, 'ctype' => 'cus',
                            'particular' => $request->particular,
                            'amount' => $request->amount,
                            'status' => 'paid');
      Account::insert($transaction);
      return redirect()->back()
            ->with('success', "one transaction added successfully.");
    }

    public function getCustomerDetail($id)
    {
      $totalOrders = DB::table('carts')
                    ->where('status', 'done')
                    ->where('uid', $id)
                    ->select(DB::raw('sum(quantity*price) AS total'))
                    //->groupBy('orderid')
                    ->first();

      $ordersNum = DB::table('carts')
                    ->where('status', '!=', 'cart')
                    ->where('uid', $id)
                    ->groupBy('orderid')
                    ->get();

      // echo $totalTrans = DB::table('accounts')
      //                   ->where('uid', $id)
      //                   ->count();

      $customers = DB::table('carts')
                  ->where('carts.uid', 'done')
                  ->where('carts.uid', $id)
                  ->join('users', 'carts.uid', '=', 'users.id')
                  ->select('users.id', 'users.name', DB::raw('sum(carts.quantity*carts.price) AS orderTotal'))
                  ->get();
      //dd($totalPaid);
      $orders = DB::table('carts')//->where('status', 'order')
              ->where('uid', $id)
              ->select('id', 'prodid', 'orderid', 'quantity', 'status', 'created_at')
              ->orderBy('created_at', 'desc')
              ->groupBy('orderid')
              ->paginate(8);
      $ac = new Account();
      $cart = new Cart();
      //$accounts = $ac->getAccountsByUser($id);
      $users = User::where('id','!=', 1)->get();
      return view('adminpanel.account.customer')->with('totalOrders', $cart->getTotalAmountByUser($id))
                                                  ->with(compact('ordersNum'))
                                                  ->with('totalPaid', $ac->getTotalByUser($id))
                                                  ->with(compact('orders'))
                                                  ->with('accounts', $ac->getAccountsByUser($id))
                                                  ->with('totalTrans', $ac->getTransNumberByUser($id))
                                                  ->with(compact('users'))
                                                  ->with(compact('id'));
    }

    public function getTotalByOrder($orderid)
    {
      $ord = DB::table('carts')
                    ->where('orderid', $orderid)
                    ->select(DB::raw('sum(quantity*price) AS total'))
                    ->first();

      return $ord->total;
    }
}
