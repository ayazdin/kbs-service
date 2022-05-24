<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\Models\Role;
use App\Models\Supplier;

class SupplierController extends Controller
{
  public function index()
  {
    $suppliers = Supplier::all();
    return view('adminpanel.supplier.supplier')->with(compact('suppliers'));
  }

  public function createSupplier($id="")
  {
    $supplier="";
    $suppliers = Supplier::all();
    if($id!="")
      $supplier = Supplier::find($id);
    return view('adminpanel.supplier.supplier')->with('supplier', $supplier)
                                        ->with(compact('suppliers'));
  }

  public function store(Request $request)
  {
    $user = auth()->user();

    if($request->supid!="")
    {
      $supplier = Supplier::find($request->supid);
      $supplier->uid = $user->id;
      $supplier->name = $request->name;
      $supplier->rpname = $request->rpname;
      $supplier->phone1 = $request->phone1;
      $supplier->phone2 = $request->phone2;
      $supplier->location = $request->location;
      $supplier->email = $request->email;
      if($supplier->status=="")
        $supplier->status='active';
      else
        $supplier->status = $request->status;
      $supplier->update();
      return redirect()
            ->back()
            ->with('success', 'Supplier information updated');
    }
    else
    {
      $supplier = new Supplier;
      $supplier->uid = $user->id;
      $supplier->name = $request->name;
      $supplier->rpname = $request->rpame;
      $supplier->phone1 = $request->phone1;
      $supplier->phone2 = $request->phone2;
      $supplier->location = $request->location;
      $supplier->email = $request->email;
      if($supplier->status=="")
        $supplier->status='active';
      else
        $supplier->status = $request->status;

      $supplier->save();
    }
    return redirect()
          ->back()
          ->with('success', 'One supplier added');
    //return back()->with('message', "One member added");
  }

  public function delete($id)
  {
    if($id>0)
    {
      Supplier::destroy($id);
      return redirect()->back()
            ->with('success', 'Supplier deleted successfully');
    }
    else {
      return redirect()->back()
            ->with('error', 'Supplier id cannot be 0');
    }
  }

  public function supplierById($id)
  {
    return Supplier::find($id);
  }
}
