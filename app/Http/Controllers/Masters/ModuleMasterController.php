<?php

namespace App\Http\Controllers\Masters;

use App\Models\ModuleMasterModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Auth;

class ModuleMasterController
{
    public function index(){
        $modules = ModuleMasterModel::all();
        return view('masters.modulemaster.index', compact('modules'));
    }

    public function create(){
        return view('masters.modulemaster.create');
    }

    public function store(Request $request){
        $module = new ModuleMasterModel;

        $module->id = Uuid::uuid1();
        $module->modulename = $request->modulename;
        $module->moduledescription = $request->moduledescription;
        $module->created_at = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
        $module->created_by = Auth::id();
        $module->updated_at = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
        $module->save();

        return redirect('adminaccess/modules')->with('flash_message',$request->modulename.' added successfully');
    }

    public function show($id){
        $module = ModuleMasterModel::find($id);
        return view('masters.modulemaster.details', compact('module'));
    }

    public function edit($id){
        $module = ModuleMasterModel::find($id);
        return view('masters.modulemaster.edit', compact('module'));
    }

    public function update(Request $request, $id){
        $module = ModuleMasterModel::find($id);

        $module->modulename = $request->modulename;
        $module->moduledescription = $request->moduledescription;
        $module->updated_by = Auth::id();
        $module->updated_at = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
        $module->save();

        return redirect('adminaccess/modules')->with('flash_message',$request->modulename.' edited successfully');
    }
}