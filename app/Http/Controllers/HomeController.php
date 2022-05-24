<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Product;
use App\Models\Category;
use App\Models\Relation;
use App\Models\Supplier;
use App\Models\Field;
use App\Models\Field_value;
use App\Models\Inventory;
use App\Models\Image;
use DB;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:user');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin/dashboard');
    }

    public function getProductList(Request $request)
    {
      $products = "";$selArr=array();
      $supplierid = isset($request->id) ? $request->id : '';
      $slug = isset($request->slug) ? $request->slug : '';
      $sortby = isset($request->sort) ? $request->sort : 'date-desc';
      $search = !empty($request->search) ? $request->search : '';
      //dd($sortby);
      if($sortby == 'date-asc') {
        $key = 'products.updated_at';
        $value = 'ASC';
      }
      if($sortby == 'date-desc') {
        $key = 'products.updated_at';
        $value = 'DESC';
      }
      if($sortby == 'price-asc') {
        $key = 'products.wp';
        $value = 'ASC';
      }
      
      if($sortby == 'data-title') {
        $key = 'products.title';
        $value = 'ASC';
      }
      //dd($key, $value);
      $catco = new CategoryController();
      if(!empty($slug)){
        $category = Category::where('slug', $slug)->first();
        if(!empty($category)){
          $parent = $catco->getImmediateParent($category->id);
          $selArr[] = $category->id;
          if(!empty($parent))
            $selArr [] = $parent;
        }
        $query = DB::table('products')
                        ->where('relations.catid', $category->id)
                        ->where('products.status', 'publish')
                        ->orderBy($key, $value)
                        ->join('relations', 'products.id','=', 'relations.pid')
                        ->select('products.*', 'relations.catid', 'relations.pid');
        if(!empty($search))
          $query->where('products.title', 'like', '%'.$search.'%');             
        $products = $query->get();
      }
      else{
        $query = Product::query();
        if(!empty($supplierid))
          $query->where('supplierid', $supplierid);
        $query->where('status', 'publish');
        $query->where('title', 'like', '%'.$search.'%');
        $query->orderBy($key, $value);
        $products = $query->get();
        //dd($query->toSql(), $query->getBindings());
      }
      $categories = $catco->getCategoryList("product",$list="home", $selArr);
      $suppliers = Supplier::where('status', 'active')->get();

      return view('users/products')->with(compact('products'))
                                    ->with(compact('categories'))
                                    ->with(compact('suppliers'))
                                    ->with(compact('supplierid'))
                                    ->with(compact('sortby'));
    }

    public function getContactPage()
    {
      return view('users/contact');
    }

    public function getProductDetail($slug)
    {
      $inventories="";
      //return $request->prodid;
      //echo $slug;exit;
      $product = Product::where('slug', $slug)->first();
      //echo $product->images;
      //echo $product->id;exit;
      $prd = new ProductController();
      //$product = Product::find($product->id);
      //$parent = $prd->getProductCategories($request->prodid);
      //echo $product->id;
      //$options = $prd->getProductOptions($product->id);
      //dd($options);
      $inventory = $lots = DB::table('inventories')
                ->select('id', 'options')
                ->selectRaw("SUM(qty) as quantity")
                ->where('prodid', $product->id)
                ->groupBy('options')
                ->get();

      foreach($inventory as $inv)
      {
        if(empty($inventories))
          $inventories = array($inv->options => $inv->quantity);
        else
          $inventories = array_merge($inventories, array($inv->options => $inv->quantity));
          //array_push($inventories, array($inv->options => $inv->quantity));
      }
      
      $images = Image::where('pid', $product->id)->where('type','<>', 'featured')->get();
      return view('users/product-detail')->with(compact('product'))
                                          //->with(compact('options'))
                                          ->with(compact('inventories'))
                                          ->with(compact('images'));
    }
}
