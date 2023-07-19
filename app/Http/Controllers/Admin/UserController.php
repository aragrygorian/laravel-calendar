<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::latest()->get();
        return view('admin.user.index' , compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.user.create' , compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->phone = $request->phone;

        if($request->hasFile('image')){
            $image_path = $request->file('image')->store('images/user','public');
            $user->image = $image_path;
        }

        if($user->save()){
            $user->assignRole($request->role);
            return redirect()->route('user.index')->with('success' , 'User Created Successfully.');
        }else{
            return redirect()->route('user.index')->with('error' , 'Failed to create user.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);
        return view('admin.user.edit' , compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->phone = $request->phone;
        if($request->hasFile('image')){
            if(isset($user->image)){
                $path = public_path('storage/'.$user->image);
                if(file_exists($path)){
                    unlink($path);
                }
            }
            $image_path = $request->file('image')->store('images/user','public');
            $user->image = $image_path;
           
        }
        if($user->update()){
            return redirect()->route('user.index')->with('success' , 'User Updated Successfully.');
        }else{
            return redirect()->route('user.index')->with('error' , 'Failed to update user.');
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        if(isset($user->image)){
            $path = public_path('storage/'.$user->image);
            if(file_exists($path)){
                unlink($path);
            }
        }

        if($user->destroy($id)){
            return redirect()->route('user.index')->with('success' , 'User deleted Successfully.');
        }else{
            return redirect()->route('user.index')->with('error' , "user canoot delete");
        }
    }
}
