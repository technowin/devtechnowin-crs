<?php

namespace App\Http\Controllers;

use App\Models\CustomersModel;
use App\User;
use App\Role;
use Validator;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users =  User::all();

        $roles = Role::pluck('name', 'id')->except('3');

        $customercode = CustomersModel::pluck('customername', 'customercode')->all();

        return view('users.index',compact('users','roles','customercode'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name', 'id')->all();

        return view('users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'required|max:120',
            'email'=>'required|email|unique:users',
            'mobile' => 'required|numeric|digits:10',
            'password'=>'required|min:6|confirmed'
        ]);

        if ($validator->fails())
        {
            return redirect()->route('createuser')->withErrors($validator)->withInput();
        }

        $user = User::create($request->only('email', 'name', 'mobile', 'password','customercode'));

        $role = $request->roles;

        $role_r = Role::where('id', '=', $role)->firstOrFail();

        $user->assignRole($role_r);

        return redirect('users')->with('flash_message', 'user successfully added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('users.details', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
           $user = User::findOrFail($id);
           $roles = Role::pluck('name', 'id')->all();

        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name'=>'required|max:120',
            'email'=>'required|email|unique:users,email,'.$id,
            'mobile' => 'required|numeric|digits:10'
        ]);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
        else
        {
            //$input = $request->only(['name','email','mobile','is_verified']);
            $input = $request->only(['email', 'name', 'mobile', 'password','customercode']);

            $roles = $request['roles'];

            $user->fill($input)->save();

            if (isset($roles))
            {
                $user->roles()->sync($roles);
            }
            else
            {
                $user->roles()->detach();
            }
            return redirect('users')->with('flash_message', 'User successfully edited');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return redirect('users')->with('flash_message', 'user successfully deleted');
    }
}
