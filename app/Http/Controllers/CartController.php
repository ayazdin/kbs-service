<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Models\Cart;
use DB;

class CartController extends Controller
{
    /*
      get the list of cart items according to the orderid
      parameter: orderid, userid
      return: collection of items in the cart
    */

    public function getCartItems()
    {
      $cart="";
      $user = auth()->user();
      $cart = DB::table('carts')
              ->join('products', 'carts.prodid', '=', 'products.id')
              ->where('carts.status', 'cart')
              ->where('carts.uid', $user->id)
              ->select('carts.*', 'products.title', 'products.images', 'products.slug')
              ->get();
      // $items = Cart::where('status', 'cart')
      //                 ->where('uid', $user->id)
      //                 ->get();

      return $cart;
    }

    /*
      stores cart
      parameter: data posted from frontend form
      return: back to the view from where it is called
    */
    public function storeCart(Request $request)
    {
      $orderid = "";$cart="";$ord="";
      $user = auth()->user();
      $ord = Cart::where('uid', $user->id)->where('status', 'cart')->first();
      if(!empty($ord))
        $orderid = $ord->orderid;
      else {
        $orderid = Cart::max('orderid');
        if($orderid!="")
          $orderid = $orderid+1;
        else
          $orderid = 10001;
      }


      $cart = Cart::where('uid', $user->id)
                    ->where('prodid', $request->prodid)
                    ->where('status', 'cart')
                    //->where('option', $request->option)
                    ->first();
//dd($cart);
      if(!empty($cart))
      {
        $cart->quantity=$cart->quantity+$request->quantity;
        $cart->price=$request->wp?$request->wp:0;
        $cart->update();
      }
      else {
        $cart = new Cart();
        $cart->uid=$user->id;
        $cart->prodid=$request->prodid;
        $cart->orderid=$orderid;
        //$cart->option=$request->option;
        $cart->quantity=$request->quantity;
        $cart->price=$request->wp?$request->wp:0;
        $cart->status='cart';
        $cart->save();
      }
      $successmsg = 'Item added to the cart successfully';
      return redirect()->back()
            ->with('success', $successmsg);
    }

    /*
      removes items from cart
      parameter: cart id
      return: cart list after deletion of an item
    */
    public function removeCart($id)
    {
      Cart::where('id',$id)->delete();
      return redirect()->back()
            ->with('success', "Cart Item Deleted Successfully!!!");
    }

    public function getCart()
    {
      return view('users.cart');
    }

    /*
      get the values of the options
      parameter: - seperated fieldVlaue ids
      return: text values of the parameters
    */
    public function getOptionValues($opt)
    {
      $output="";
      if(!empty($opt))
      {
        $oparr = explode("-", $opt);
        //dd($oparr);
        if(count($oparr)==1)
        { //echo $oparr[0];
          $cart = DB::table('field_values')
                      ->join('fields', 'field_values.fid', '=', 'fields.id')
                      ->select('field_values.fid', 'field_values.value', 'fields.title')
                      ->where('field_values.id', $oparr[0])
                      ->first();
                      //dd($cart);
          $output .= '<b>'.$cart->title.'</b>: '.$cart->value.'<br>';
        }
        else {
          foreach($oparr as $op)
          {
            $cart = DB::table('field_values')
                      ->join('fields', 'field_values.fid', '=', 'fields.id')
                      ->select('field_values.fid', 'field_values.value', 'fields.title')
                      ->where('field_values.id', $op)
                      ->first();
            //dd($cart);
            $output .= '<b>'.$cart->title.'</b>: '.$cart->value.'<br>';
          }
        }
      }
      return $output;
    }

    public function getQuantityChanged(Request $request)
    {
      //return $request->cartid."--".$request->qty;
      $cart = Cart::where('id', $request->cartid)->first();
      $cart->quantity = $request->qty;
      $cart->update();
      return "Quantity changed";
    }

    public function getCheckout()
    {
      $user = auth()->user();
      //echo $user->id;
      $orderid = session('orderid');//exit;
      Cart::where('uid', $user->id)
            ->where('status', 'cart')
            ->update(['status' => 'order']);

      $orders = DB::table('carts')
              ->join('products', 'carts.prodid', '=', 'products.id')
              ->where('carts.orderid', $orderid)
              ->select('carts.*', 'products.title', 'products.images', 'products.slug')
              ->get();
      //print_r($cart);exit;
      session(['orderid' => '']);
      return view('users.thankyou')->with(compact('orders'));
    }

    
}
