<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\Models\Role;

class UserController extends Controller
{
    public function index()
    {
      $customers = User::all();
      $roles = Role::all();
      //print_r($roles);exit;
      return view('adminpanel.users.users')->with(compact('customers'))
                                            ->with(compact('roles'));
    }

    public function createUser($id="")
    {
      $customer="";
      $customers = User::all();
      $roles = Role::all();
      if($id!="")
        $customer = User::find($id);
      return view('adminpanel.users.users')->with('customer', $customer)
                                          ->with(compact('customers'))
                                          ->with(compact('roles'));
    }

    public function store(Request $request)
    {
      if($request->userid!="")
      {
        $customer = User::find($request->userid);
        $customer->name = $request->fullname;
        $customer->phone = $request->phone;
        $customer->address = $request->address;
        $customer->role_id = $request->role;
        if($request->password!="")
          $customer->password = Hash::make($request->password);
        $customer->update();
        return redirect()
              ->back()
              ->with('success', 'Member information updated');
      }
      else
      {
        if($this->isEmailAvail($request->email))
        {
          $customer = new User;
          $customer->name = $request->fullname;
          $customer->phone = $request->phone;
          $customer->email = $request->email;
          $customer->address = $request->address;
          $customer->role_id = $request->role;
          $customer->password = Hash::make($request->password);
          $customer->save();
        }
        else {
          return back()->withError('Email already exists');
        }
      }
      return redirect()
            ->back()
            ->with('success', 'One member added');
      //return back()->with('message', "One member added");
    }

    protected function isEmailAvail($email)
    {
      $count=0;
      $count = User::where('email', $email)->count();
      if($count>0)
        return false;
      else
        return true;
    }

    public function delete($id)
    {
      if($id>0)
      {
        User::destroy($id);
        return redirect()->back()
              ->with('success', 'User deleted successfully');
      }
      else {
        return redirect()->back()
              ->with('error', 'User id cannot be 0');
      }
    }
}
