<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

//use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;

use App\User;
use Session;
use App\Models\Role;
use App\Models\Product;
use App\Models\Category;
use App\Models\Relation;
use App\Models\Supplier;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
  public function index()
  {
    DB::statement("SET sql_mode = '' ");
    $orders = DB::table('carts')->where('status', '!=', 'cart')
            ->select('id', 'prodid', 'orderid', 'quantity', 'status', 'created_at')
            ->orderBy('created_at', 'desc')
            ->groupBy('orderid')
            ->paginate(8);
    //$orders = DB::table('orders')->groupBy('orderid')->paginate(2);
    //$orders = Order::groupBy('orderid')->select('orderid', 'created_at', DB::raw('count(*) as items'))->orderBy('created_at', 'DESC')->paginate(2);
    return view('adminpanel.orders.orders')->with(compact('orders'));
  }

  public function viewOrder($orderid)
  {
    $orders="";$output="";$to="";$table="";$gtotal=0;
    $orders = DB::table('carts')
                ->where('orderid', $orderid)
                ->join('products', 'carts.prodid', '=', 'products.id')
                ->select('products.sku', 'products.title', 'products.sp', 'carts.uid', 'carts.quantity', 'carts.option', 'carts.id')
                ->get();

    if(!empty($orders))
    {
      $crt = new CartController();
      $customer = User::where('id', $orders[0]->uid)->first();
      if(!empty($customer))
      {
        $to = 'To <address>
          <strong>'.$customer->name.'</strong><br>
          '.$customer->address.'<br>
          Phone: '.$customer->phone.'<br>
          Email: '.$customer->email.'
        </address>';
      }
      $output .= '<!-- title row -->
      <div class="row">
        <div class="col-12">
          <h4>
            <i class="fas fa-globe"></i> Inventory Management System
            <small class="float-right orderdate">Date: '.date("d/m/Y").'</small>
          </h4>
        </div>
        <!-- /.col -->
      </div>';
      $output .= '<!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">'.$to.'</div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <br>
          <b>Invoice #007612</b><br>
          <b>Order ID:</b> '.$orderid.'<br>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col"></div>
        <!-- /.col -->
      </div>
      <!-- /.row -->';
      $table = '<table class="table table-striped">
        <thead>
        <tr>
          <th>Qty</th>
          <th>Product</th>
          <th>Description</th>
          <!--<th>Rate</th>-->
          <th>Subtotal</th>
          <th></th>
        </tr>
        </thead>
        <tbody>';

      foreach($orders as $order)
      {
        $total = (float)$order->quantity * (float)$order->sp;
        $gtotal = $gtotal+$total;
        $table .= '<tr>
                      <td><input type="text" class="quantity" data-cartid="'.$order->id.'" data-price="'.$order->sp.'" size="4" value="'.$order->quantity.'"></td>
                      <td>'.$order->title.'</td>
                      <td>'.$crt->getOptionValues($order->option).'</td>
                      <!--<td>'.$order->sp.'</td>-->
                      <td class="sub'.$order->id.'">Rs. '.$total.'</td>
                      <td><a href="" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a></td>
                    </tr>';
      }
      $table .= '</tbody></table>';
      $output .= '<!-- Table row -->
      <div class="row">
        <div class="col-12 table-responsive" id="view-detail">'.$table.'</div>
        <!-- /.col -->
      </div>
      <!-- /.row -->';

      $output .= '<div class="row">
        <!-- accepted payments column -->
        <div class="col-6"></div>
        <!-- /.col -->
        <div class="col-6">
          <p class="lead">Amount Due 2/22/2014</p>

          <div class="table-responsive">
            <table class="table">
              <tbody>
              <tr>
                <th>Total:</th>
                <td id="gtotal">Rs. '.$gtotal.'</td>
              </tr>
            </tbody></table>
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->';
      $output .= '<div class="row no-print">
                <div class="col-12">
                  <!--<a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>-->
                  <a href="/admin/orders/change-status/'.$orderid.'/done" class="btn btn-success float-right"><i class="fas fa-check"></i> Completed </a>
                  <a href="/admin/orders/change-status/'.$orderid.'/cancel" class="btn btn-danger float-right" style="margin-right: 5px;">
                    <i class="fas fa-trash"></i> Cancel Order
                  </a>
                </div>
              </div>';
    }
    echo $output;
  }

  public function placeOrder($id="")
  {
    $products = Product::where('sold','!=','1')->get();
    return view('adminpanel.orders.add-order')->with(compact('products'));
  }

  public function storeOrder(Request $request)
  {
    $orderid = Order::max('orderid');
    if(empty($orderid))
      $orderid = 2021;
    else
      $orderid = $orderid+1;
    $sessid = Session::getId();//exit;
    /*$ordcheck="";
    $ordcheck = Order::where('sessid', $sessid)->first();
    if(!empty($ordcheck))
      $orderid = $ordcheck->orderid;*/
    $icount=0;
    $order = array();
    $user = auth()->user();
    foreach($request['product'] as $prod)
    {
      $order = array('uid' => $user->id, 'pid' => $prod, 'sessid' => $sessid, 'orderid' => $orderid,
                      'quantity' => $request['quantity'][$icount], 'status' => 'ordered');
      Order::create($order);
      $icount++;
    }
    return redirect()->back()
          ->with('success', $icount." items added to the order list.");
    //Order::insert($order);
    //echo "we are here";echo "<br>";//exit;
    //print_r($request['product']);echo "<br>";
    //print_r($request['quantity']);
  }

  public function deleteOrder($orderid)
  {
    Order::where('orderid',$orderid)->delete();
    echo json_encode("Your Order has been deleted Successfully!!!");
    //return redirect()->back()
          //->with('success', "Order Deleted Successfully!!!");
  }

  public function salesList()
  {
    $sales = DB::table('carts')
                ->where('carts.status', 'done')
                ->join('products', 'carts.prodid', '=', 'products.id')
                ->join('users', 'carts.uid', '=', 'users.id')
                ->select('carts.*', 'products.sku', 'products.title', 'products.sp', 'users.name', 'users.phone', 'users.address', 'users.email')
                ->orderBy('carts.orderid', 'desc')
                ->paginate(20);

    //dd($sales);
    return view('adminpanel.sales.sales')->with(compact('sales'));
  }

  public function statusChangedDone($orderid)
  {
    Cart::where('orderid', $orderid)
          ->update(['status' => 'done']);
    return redirect()->back()
          ->with('success', "Status changed !!!");
  }

  public function statusChanged($orderid, $status)
  {
    Cart::where('orderid', $orderid)
          ->update(['status' => $status]);
    return redirect()->back()
          ->with('success', "Status changed !!!");
  }
}
