<?php

namespace App\Http\Controllers;

use App\User;
use DebugBar\DebugBar;
use http\Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    /*
     * Ensure the user is signed in to access this page
     */
    public function __construct() {
        $this->middleware('auth');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        try{
            $urlpath="";
            $user = auth()->user()->roles->first()->name;
            if($user =="admin")
            {
                $urlpath="adminupdatepassword";
            }
            else if($user =="user")
            {
                $urlpath ="userupdatepassword";
            }
            else if($user =="assignee"){
                $urlpath ="assigneeupdatepassword";
            }
            else if($user =="tender"){
                $urlpath ="tenderupdatepassword";
            }

            return view('auth.passwords.changepassword',compact('urlpath'));
        }
        catch (\Exception $ex) {
            Debugbar::addThrowable($ex);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'old'=>'required',
            'password'=>'required|min:6|confirmed'
        ]);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
        else{
        $user = User::find(Auth::id());
        $hashedPassword = $user->password;

        if (Hash::check($request->old, $hashedPassword)) {

            $user->fill([
                'password' => ($request->password),
            ])->save();
            $user->passwordtext = $request->password;
            $user->save();
           //Hash::make
            return redirect()->back()->with('flash_message', 'Your password has been changed.');
        }
        else{
            return redirect()->back()->with('alert_message', 'Old Password entered was incorrect.');
        }
        }

    }
}
