<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $roles =  Role::paginate(10);

        return view('role.index')->with('roles', $roles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('role.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'required'
        ]);

        if ($validator->fails())
        {
            return redirect()->route('createrole')->withErrors($validator)->withInput();
        }

        $role = new Role;

        $role->name = $request->name;

        $role->description = $request->name;

        $role->save();

        return redirect()->back()->with('flash_message','role successfully added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $role = Role::findOrFail($id);

        $assignedrole = Role::with('users')->where('name', $role->name)->get();

        return view('role.show',compact('assignedrole'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);

        return view('role.edit',compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $role->name = $request->name;

        $role->description = $request->name;

        $role->save();

        return redirect()->back()->with('flash_message','role successfully edit.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $user = Role::findOrFail($id);

        $user->delete();

        return redirect('roles')->with('flash_message', 'role successfully deleted');
    }
}
