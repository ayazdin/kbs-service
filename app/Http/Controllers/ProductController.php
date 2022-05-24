<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\SupplierController;

use App\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Relation;
use App\Models\Supplier;
use App\Models\Image;
use App\Models\Field;
use App\Models\Field_value;
use App\Models\Inventory;
use DB;


class ProductController extends Controller
{
  public function index()
  {
    $products = Product::all();
    //$supplier = Supplier::find(1);
    //print_r($supplier);
    return view('adminpanel.product.products')->with(compact('products'));
  }

  public function createProduct($id="")
  {
    $parent="";$cateTree="";$product="";$options="";
    $images="";$inventories="";
    $catCtrl = new CategoryController();
    if($id!="")
    {
      $product = Product::find($id);
      $parent = $this->getProductCategories($id);
      //$options = $this->getProductOptions($id);
      //$inventories = $this->getInventoryList($options, $id);
      $images = Image::where('pid', $id)->where('type','<>', 'featured')->get();
    }
    //$suppliers = Supplier::all();
    $cateTree = $catCtrl->categoryTreeWalk('product', 'chk', $parent);
    return view('adminpanel.product.add-product')->with(compact('cateTree'))
                                                  //->with(compact('suppliers'))
                                                  ->with(compact('product'))
                                                  ->with(compact('images'))
                                                  //->with(compact('options'))
                                                  //->with(compact('inventories'))
                                                  ->with('isCopy', 'false');
  }

  public function copyProduct($id="")
  {
    $parent="";$cateTree="";$product="";$options="";
    $images="";$inventories="";
    $catCtrl = new CategoryController();
    if($id!="")
    {
      $product = Product::find($id);
      $parent = $this->getProductCategories($id);
      $options = $this->getProductOptions($id);
      $images = Image::where('pid', $id)->where('type','<>', 'featured')->get();
    }
    //$suppliers = Supplier::all();
    $cateTree = $catCtrl->categoryTreeWalk('product', 'chk', $parent);
    return view('adminpanel.product.add-product')->with(compact('cateTree'))
                                                  //->with(compact('suppliers'))
                                                  ->with(compact('product'))
                                                  ->with(compact('images'))
                                                  ->with(compact('options'))
                                                  ->with('isCopy', 'true');
  }

  public function getInventoryList($options, $pid)
  {
    $output="";
    if(!empty($options))
    {
      $optHead = "";
      $optHtml = "";
      $fields = array();
      $i=0;
      foreach($options as $opts)
      {
        $optHead .= '<th>'.$opts['name'].'</th>';
        $field = array($opts['id']=>$opts['options']);
        $fields = array_merge($fields, $field);
        $i++;
      }
      $combinations = $this->get_combinations($fields);
      $iCount=0;
      //print_r($inventories);echo "<br>";
      foreach($combinations as $com)
      {
        $optHtml .= '<tr>';
        $optarr = array();
        foreach($com as $key => $val)
        {
          $vArr = explode("-", $val);
          $optarr = array_merge($optarr, array($vArr[0]));
          $optHtml .= '<td><input type="hidden" name="field'.$iCount.'[]" value="'.$vArr[0].'">'.$vArr[1].'</td>';
        }
        $filtered="";
        $search = implode("-",$optarr);//echo "<br>";
        $filtered = Inventory::where("prodid", $pid)
                                ->where("options", 'like', '%'.$search.'%')
                                ->first();
        if(!empty($filtered))
          $optHtml .= '<td><input type="number" name="qty'.$iCount.'" class="qty" value="'.$filtered->qty.'"></td>';
        else
          $optHtml .= '<td><input type="number" name="qty'.$iCount.'" class="qty" value="0"></td>';//echo "No";
        $optHtml .= '</tr>';
        $iCount++;
      }
      $output .= '<input type="hidden" name="fieldCount" value="'.count($combinations).'">';
      $output .= '<input type="hidden" name="pid" value="'.$pid.'">';
      $output .= '<table class="table table-sm table-striped table-bordered">
              <thead><tr>'.$optHead.'<th>Quantity</th></tr></thead>
              <tbody>'.$optHtml.'</tbody>
            </table>';
      }
      //dd($optarr);
      return $output;
  }

  public function ajaxGetPurchaseOrder(Request $request)
  {
    $output=""; $pid=$request->prodid;
    $lotno = Inventory::max('lotnumber')+1;
    $suppliers = Supplier::all();
    $options = $this->getProductOptions($pid);
    if(!empty($options))
    {
      $optHead = "";
      $optHtml = "";
      $fields = array();
      $i=0;
      //$cols = count($options)+1;
      foreach($options as $opts)
      {
        $optHead .= '<th>'.$opts['name'].'</th>';
        $field = array($opts['id']=>$opts['options']);
        $fields = array_merge($fields, $field);
        $i++;
      }
      $combinations = $this->get_combinations($fields);
      $iCount=0;

      foreach($combinations as $com)
      {
        $optHtml .= '<tr>';
        $optarr = array();

        foreach($com as $key => $val)
        {
          $vArr = explode("-", $val);
          $optarr = array_merge($optarr, array($vArr[0]));
          $optHtml .= '<td><input type="hidden" name="field'.$iCount.'[]" value="'.$vArr[0].'">'.$vArr[1].'</td>';
        }
        $filtered="";
        $search = implode("-",$optarr);//echo "<br>";
        $filtered = Inventory::where("prodid", $pid)
                                ->where("options", 'like', '%'.$search.'%')
                                ->first();
        if(!empty($filtered))
          $optHtml .= '<td><input type="number" name="qty'.$iCount.'" class="qty" value="0">('.$filtered->qty.')</td>';
        else
          $optHtml .= '<td><input type="number" name="qty'.$iCount.'" class="qty" value="0"></td>';//echo "No";
        $optHtml .= '</tr>';
        $iCount++;
      }
      $output .= '<input type="hidden" name="fieldCount" value="'.count($combinations).'">';
      $output .= '<input type="hidden" name="pid" value="'.$pid.'">';
      $output .= '<input type="hidden" name="lotnumber" value="'.$lotno.'">';
      $output .= '<table class="table table-sm table-striped table-bordered">
                    <tr>
                    <td>Cost Price <input type="text" name="cp" placeholder="Cost Price"></td>
                    <td><select class="form-control" name="supplier" id="supplier">
                      <option value="">Select Supplier</option>';
                      if(!empty($suppliers)) {
                        foreach($suppliers as $supplier) {
                          $output .= '<option value="'.$supplier->id.'">'.$supplier->name.'</option>';
                        }
                      }
      $output .= '</select></td>
                    </tr>
                  <table>';
      $output .= '<table class="table table-sm table-striped table-bordered">
              <thead><tr>'.$optHead.'<th>Quantity</th></tr></thead>
              <tbody>'.$optHtml.'</tbody>
            </table>';
      }
      else {
        $lotno = Inventory::max('lotnumber')+1;
        $output .= '<input type="hidden" name="pid" value="'.$pid.'">';
        $output .= '<input type="hidden" name="lotnumber" value="'.$lotno.'">';
        $output .= '<input type="hidden" name="fieldCount" value="0">';
        $output .= '<table class="table table-sm table-striped table-bordered">
                      <tr>
                      <td>Cost Price <input type="text" name="cp" placeholder="Cost Price"></td>
                      <td>Quantity <input type="text" name="qty" placeholder="Quantity"></td>
                      <td><select class="form-control" name="supplier" id="supplier">
                        <option value="">Select Supplier</option>';
                        if(!empty($suppliers)) {
                          foreach($suppliers as $supplier) {
                            $output .= '<option value="'.$supplier->id.'">'.$supplier->name.'</option>';
                          }
                        }

        $output .= '</select></td>
                      </tr>
                    <table>';
      }
      return $output;
  }

  public function storeProduct(Request $request)
  {
    $user = auth()->user();
    $optfields = array();
    $optname = $request->optName;
    $optindex = explode(",", $request->optionNumber);
    $imgCtrl = new ImageController();

    if($request->prodid!="")
    {
      $product = Product::where('id', $request->prodid)->first();
      $product->title = $request->productname;
      $product->slug = $request->slug;
      $product->description = $request->description;
      $product->cp = $request->cp;
      $product->sp = $request->sp;
      $product->wp = $request->wp;
      //$product->op = $request->op;
      $product->quantity = $request->quantity;
      //$product->supplierid = $request->supplier;
      $product->sku = $request->sku;
      $product->status = $request->rdoPublish;
      $product->update();

      //$product->sku = $product->id;
      //$product->slug = $request->slug."-".$product->id;
      $product->update();

      $this->saveCategories($product->id, $request->categories);
      for($i=0; $i<count($optindex);$i++)
      {
        $field="";
        $op = "optValue".$optindex[$i];
        if(!empty($optname[$i]))
          $this->updateFields($optname[$i], $request->prodid, $request->$op);
      }

      $successmsg = 'Product updated successfully';
    }
    else {
      $images = array();
      $product = new Product();
      $product->uid = $user->id;
      $product->title = $request->productname;
      //$product->slug = $request->slug;
      $product->description = $request->description;
      $product->cp = $request->cp;
      $product->sp = $request->sp;
      $product->wp = $request->wp;
      //$product->op = $request->op;
      $product->quantity = $request->quantity;
      $product->supplierid = $request->supplier;
      $product->sku = $request->sku;
      $product->status = $request->rdoPublish;
      $product->save();

      //$product->sku = $product->id;
      $product->slug = $request->slug."-".$product->id;
      $product->save();

      for($i=0; $i<count($optindex);$i++)
      {
        $field="";
        $op = "optValue".$optindex[$i];
        $optfield = array($i=>$request->$op);
        $optfields = array_merge($optfields, $optfield);
        if(!empty($optname[$i]))
          $this->saveFields($optname[$i], $product->id, $request->$op);
      }
      //$this->saveInventory($product->id, $optfields);
      $this->saveCategories($product->id, $request->categories);
      $successmsg = 'Product added successfully';
    }

    if(!empty($_FILES['image']['name'][0])){
        $files = $_FILES['image'];
        $featuredfile = $imgCtrl->multifileupload($files,'featured', $product->id);
        $product->images = $featuredfile[0];
        $product->update();
    }

    if(!empty($_FILES['imagecap']['name'][0])){
        $files = $_FILES['imagecap'];
        $featuredfile = $imgCtrl->multifileupload($files,'featured', $product->id);
        $product->images = $featuredfile[0];
        $product->update();
    }
    if(!empty($_FILES['images']['name'][0]))
    {
      $files = $_FILES['images'];
      $featuredfile = $imgCtrl->multifileupload($files,'others', $product->id);
    }
    return redirect()->back()
          ->with('success', $successmsg);
  }

  public function delete($id)
  {
    Product::where('id',$id)->delete();
    return redirect()->back()
          ->with('success', "Product Deleted Successfully!!!");
  }

  public function get_combinations($arrays)
  {
    $result = array(array());
    foreach ($arrays as $property => $property_values) {
      $tmp = array();
      foreach ($result as $result_item) {
        foreach ($property_values as $key => $property_value) {
          $tmp[] = array_merge($result_item, array($property => $key.'-'.$property_value));
        }
      }
      $result = $tmp;
    }
    return $result;
  }

  public function deleteImage($id)
  {
    $image = Image::where('id', $id)->first();
    $imgs = unserialize($image->images);
    foreach($imgs as $img)
    {
      if(!empty($img))
        @unlink(realpath($img));
    }
    Image::where('id',$id)->delete();

    return redirect()->back()
          ->with('success', "Image Deleted Successfully!!!");
  }
  public function saveFields($field, $pid, $vals)
  {
    $f = new Field();
    $f->prodid = $pid;
    $f->title = strtolower($field);
    $f->save();
    foreach($vals as $v)
    {
      $fv = new Field_value();
      $fv->fid = $f->id;
      $fv->value = $v;
      $fv->save();
    }
  }

  public function saveProductImage($images, $type)
  {
    if(!empty($images))
    {
      $fimg = Image::where('pid', $product->id)->where('type', $type)->first();
      if(!empty($fimg))
      {
        $fimg = serialize($featuredfile);
        $fimg->update();
      }
      else {
        $fimg = array('pid'=>$product->id, 'type'=>$type, 'images'=>serialize($featuredfile));
        Image::insert($fimg);
      }
    }
  }

  public function updateFields($field, $pid, $vals)
  {
    $field = strtolower($field);
    $f="";
    $f = Field::where('prodid', $pid)->where('title', $field)->first();
    if(!empty($f))
    {
      foreach($vals as $v)
      {
        $fv="";
        $v = strtolower($v);
        $fv = Field_value::where('fid', $f->id)->where('value', $v)->first();
        if(empty($fv))
        {
          $fv = new Field_value();
          $fv->fid = $f->id;
          $fv->value = $v;
          $fv->save();
        }
      }
    }
    else {
      $f = new Field();
      $f->prodid = $pid;
      $f->title = $field;
      $f->save();
      foreach($vals as $v)
      {
        $fv = new Field_value();
        $fv->fid = $f->id;
        $fv->value = $v;
        $fv->save();
      }
    }
  }

  public function ajaxUpdateField(Request $request)
  {
    //return  response()->json($request['fieldid'].'--'.$request['fieldname']);
    $f = Field::find($request['fieldid']);
    $f->title = $request['fieldname'];
    $f->update();
    return  response()->json("updated");
  }

  public function ajaxUpdateValue(Request $request)
  {
    $f = Field_value::find($request['valid']);
    $f->value = $request['valname'];
    $f->update();
    return  response()->json("updated");
  }

  public function ajaxDeleteValue(Request $request)
  {
    Field_value::destroy($request['valid']);
    return  response()->json("deleted");
  }

  public function ajaxDeleteField(Request $request)
  {
    //return response()->json($request['fid']);
    Field_value::destroy($request['fid']);
    Field::destroy($request['fid']);
    return  response()->json("Field deleted");
  }

  public function storeInventorytest()
  {
    $option = serialize(array('1','6','7'));
    $inventory = array('prodid' => 2, 'options' => $option, 'qty' => 2, 'status' => 'publish');
  }

  public function ajaxStoreInventory(Request $request)
  {
    $fcount = $request['fieldCount'];
    $pid = $request['pid'];
    $lotnumber = $request['lotnumber'];
    $supid = $request['supplier'];
    $inventory = array();
    //$delInv = Inventory::where('prodid', $pid)->delete();
    //return response()->json("Inventory Saved ".serialize($request['field0']));
    if($fcount==0)
    {
      $quantity = $request['qty'];
      $cp = $request['cp'];
      Inventory::insert(array('prodid' => $pid, 'supplierid' => $supid, 'lotnumber' => $lotnumber, 'options' => "", 'qty' => $quantity, 'cost' => $cp, 'status' => 'publish', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')));
    }
    else {
      for($i=0;$i<$fcount;$i++)
      {
        $option = implode("-", $request['field'.$i]);
        $quantity = $request['qty'.$i];
        $cp = $request['cp'];
        array_push($inventory, array('prodid' => $pid, 'supplierid' => $supid, 'lotnumber' => $lotnumber, 'options' => $option, 'qty' => $quantity, 'cost' => $cp, 'status' => 'publish', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')));
      }
      Inventory::insert($inventory);
    }

    return response()->json("Inventory Saved ".serialize($inventory));
  }

  public function saveCategories($pid, $categories)
  {
    $data = array();

    if(!empty($categories)){
      foreach($categories as $cat)
      {
        $rel="";
        $rel = Relation::where('catid', $cat)->where('pid', $pid)->first();
        if(empty($rel))
          array_push($data, array('catid' => $cat, 'pid' => $pid));
      }
      Relation::insert($data);
    }
    else {
      Relation::where('pid',$pid)->delete();
    }
  }

  /*
    * parameter: product id
    * returns an array of options assigned to the product
  */
  public function getProductOptions($id)
  {
    $options = array();
    $fields = Field::where('prodid', $id)->get();
    foreach($fields as $field)
    {
      $fv = Field_value::where('fid', $field->id)->pluck('value', 'id')->all();
      array_push($options, array('id' => $field->id, 'name' => $field->title, 'options' => $fv));
    }
    return $options;
  }

  public function getProductCategories($pid)
  {
    $catArr = array();
    $catArr = Relation::where('pid', $pid)->pluck('catid')->all();
    return $catArr;
  }

  public function getAllPurchase($id)
  {
    $temp = ""; $purchaseOrder = array();$purchase="";
    $lots = DB::table('inventories')
            ->select('id','prodid', 'supplierid', 'lotnumber', 'options', 'qty', 'cost')
            ->where('prodid', $id)
            ->orderBy('lotnumber', 'DESC')
            ->groupBy('lotnumber')
            ->get();
    //$purchases = Inventory::where('prodid', $id)->groupBy('lotnumber')->orderBy('lotnumber', 'desc')->get();
    if(!empty($lots))
    {
      $options = $this->getProductOptions($id);
      if(!empty($options))
      {
        foreach($lots as $lot)
        {
          $purchase .= $this->getEachPurchaseList($options, $id, $lot->lotnumber);
        }
      }
      else {
        foreach($lots as $lot)
        {
          $purchase .= '<div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Lot Number: '.$lot->lotnumber.'</h3>
                <div class="card-tools">
                  <a href="/admin/product/purchase/delete/'.$lot->lotnumber.'" class="btn btn-danger bsmall" title="Delete Purchase">
                    <i class="fas fa-trash"></i>
                  </a>
                </div>
              </div>
              <div class="card-body table-responsive p-0">';
          $purchase .= '<table class="table table-sm table-striped table-bordered">
                        <tr>
                          <td>Cost Price: Rs. <span class="cp">'.$lot->cost.'</span></td>
                          <td>Quantity: <span class="cp">'.$lot->qty.'</span></td>
                        </tr>
                      </table>';
          $purchase .= '</div>
            </div>
            <!-- /.card -->
          </div>';
        }
      }
    }

    //dd($purchase);
    /*foreach($purchases as $purchase)
    {
      if($temp=="")
      {
        $temp = "lot-".$purchase->lotnumber;
        $purchaseOrder = array($temp => array($purchase->toArray()));
      }
      elseif($temp=="lot-".$purchase->lotnumber)
      {
        array_push($purchaseOrder[$temp], $purchase->toArray());
      }
      elseif($temp!="lot-".$purchase->lotnumber)
      {
        $temp = "lot-".$purchase->lotnumber;
        $temparr = array($temp => array($purchase->toArray()));
        $purchaseOrder = array_merge($purchaseOrder, $temparr);
      }
    }*/

    //dd($options);
    return view('adminpanel.product.purchase')->with(compact('purchase'));
    //dd($purchaseOrder);
  }

  /**
   * returns table view of single purchase list (lot wise)
   */
  public function getEachPurchaseList($options, $pid, $lot)
  {
    $output="";
    if(!empty($options))
    {
      $optHead = "";
      $optHtml = "";
      $costPrice = "";
      $fields = array();
      $i=0;

      foreach($options as $opts)
      {
        $optHead .= '<th>'.$opts['name'].'</th>';
        $field = array($opts['id']=>$opts['options']);
        $fields = array_merge($fields, $field);
        $i++;
      }

      $combinations = $this->get_combinations($fields);
      $iCount=0;

      //print_r($inventories);echo "<br>";
      $sup="";$supplier="";
      foreach($combinations as $com)
      {
        $optHtml .= '<tr>';
        $optarr = array();
        foreach($com as $key => $val)
        {
          $vArr = explode("-", $val);
          $optarr = array_merge($optarr, array($vArr[0]));
          $optHtml .= '<td>'.$vArr[1].'</td>';
        }
        $filtered="";
        $search = implode("-",$optarr);//echo "<br>";
        $filtered = Inventory::where("prodid", $pid)
                                ->where('lotnumber', $lot)
                                ->where("options", 'like', '%'.$search.'%')
                                ->first();

        if(!empty($filtered))
        {
          $optHtml .= '<td>'.$filtered->qty.'</td>';
          $costPrice = $filtered->cost;
          if($filtered->supplierid!=0)
          {
            $sup = Supplier::where('id', $filtered->supplierid)->first();
            $supplier = $sup->name;
          }
        }
        $optHtml .= '</tr>';
        $iCount++;
      }
      //echo $sup->name;
      $output .= '<div class="col-lg-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Lot Number: '.$lot.'</h3>
            <div class="card-tools">
              <a href="/admin/product/purchase/delete/'.$lot.'" class="btn btn-danger bsmall" title="Delete Purchase">
                <i class="fas fa-trash"></i>
              </a>
            </div>
          </div>
          <div class="card-body table-responsive p-0">';
      $output .= '<table class="table table-sm table-striped table-bordered">
                    <tr>
                      <td>Cost Price: Rs. <span class="cp">'.$costPrice.'</span></td>
                      <td>Supplier: '.$supplier.'</td>
                    </tr>
                  </table>';
      $output .= '<table class="table table-sm table-striped table-bordered">
              <thead><tr>'.$optHead.'<th>Quantity</th></tr></thead>
              <tbody>'.$optHtml.'</tbody>
            </table>';
      $output .= '</div>
        </div>
        <!-- /.card -->
      </div>';

      }
      return $output;
  }

  public function deletePurchase($lot)
  {
    Inventory::where('lotnumber',$lot)->delete();
    echo json_encode("Purchase order with lot number $lot has been deleted!!!");
  }

  public function deletePurchaseItem($pid)
  {
    Inventory::where('id',$pid)->delete();
    echo json_encode("One item from your purchase list has been deleted!!!");
  }

  public function getPurchaseOrder()
  {
    $products = Product::all();
    $suppliers = Supplier::all();
    return view('adminpanel.purchase.add-purchase')->with(compact('products'))
                                          ->with(compact('suppliers'));
  }

  public function setPurchaseOrder(Request $request)
  {
    // echo $request->supplier;echo "<br>";
    // print_r($request->productname);echo "<br>";
    // print_r($request->quantity);echo "<br>";
    // print_r($request->cost);echo "<br><br><br><br>";
    $insertarr =  array();
    $lotno = Inventory::max('lotnumber')+1;
    $icount=0;
    $quantity = $request->quantity;
    $cost = $request->cost;
    foreach($request->productname as $p)
    {
      $prod = Product::where('title', $p)->first();
      //echo $prod->id;echo "<br>";
      array_push($insertarr, array('prodid' => $prod->id, 'supplierid' => $request->supplier, 'lotnumber' => $lotno, 'qty' => $quantity[$icount], 'cost' => $cost[$icount], 'status' => 'publish', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')));
      $icount++;
    }
    //dd($insertarr);
    Inventory::insert($insertarr);
    return redirect()->back()
          ->with('success', "Purchase order added successfully!!!");
  }

  public function getPurchaseList()
  {
    DB::statement("SET sql_mode = '' ");
    //$this->getPurchaseDetail(108);
    $purchase = DB::table('inventories')->where('inventories.status', 'publish')
            //->join('products', 'inventory.prodid', '=', 'products.id')
            ->join('suppliers', 'inventories.supplierid', '=', 'suppliers.id')
            ->select('inventories.*', 'suppliers.name')
            ->orderBy('inventories.created_at', 'desc')
            ->groupBy('inventories.lotnumber')
            ->paginate(8);

    //$this->getTotalByLot(109);
    return view('adminpanel.purchase.purchases')->with(compact('purchase'));
  }

  public function getTotalByLot($lot)
  {
    $purchase = DB::table('inventories')->where('lotnumber', $lot)
            ->select(DB::raw('sum(qty*cost) AS subtotal'))
            ->groupBy('lotnumber')
            ->first();
    return $purchase->subtotal;
  }

  public function getPurchaseDetail($lot)
  {
    if($lot!="")
    {

      $items = DB::table('inventories')->where('inventories.status', 'publish')
              ->where('inventories.lotnumber', $lot)
              ->join('products', 'inventories.prodid', '=', 'products.id')
              ->select('inventories.*', 'products.title')
              ->get();
      // $items = Inventory::where('lotnumber', $lot)
      //                     ->where('status', 'publish')
      //                     ->get();
      //echo $items[0]->supplierid;
      $supplier = Supplier::where('id', $items[0]->supplierid)->first();
      return view('adminpanel.purchase.purchase-detail')->with(compact('items'))
                                                        ->with(compact('supplier'))
                                                        ->with(compact('lot'));
    }
  }

  public function changePurchaseQuantity(Request $request)
  {
    //return $request->cartid."--".$request->qty;
    $inv = Inventory::where('id', $request->pid)->first();
    $inv->qty = $request->qty;
    $inv->update();
    return "Quantity changed";
  }
}
