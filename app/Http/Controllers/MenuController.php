<?php

namespace App\Http\Controllers;

use App\Menu;
use App\Models\MenuRoleModel;
use App\Role;
use App\SubMenu;
use App\User;
use Illuminate\Http\Request;
use  App\Models\UrlMenuMasterModel;
use  App\Models\UrlSubMenuMasterModel;
use App\Models\Menu_MasterModel;
use Illuminate\Http\Response;
use Validator;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $roleid = auth()->user()->roles->first()->id;

        $examplemenu = Menu_MasterModel::where('role_id',$roleid)->get();
        return view('menu.index',compact('examplemenu'));
//        $menus =  Menu::where('role_id',$roleid)->get();
//        return view('menu.index')->with('menus', $menus);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $roles = Role::pluck('name', 'id')->all();
        $menus = Menu_MasterModel::pluck('menuname', 'menuid')->all();
        $nastedmenu = SubMenu::pluck('submenu_name', 'id')->all();
        $urlmenumaster = UrlMenuMasterModel::all()->pluck('menu_name','url');
        $urlsubmenumaster = UrlSubMenuMasterModel::all()->pluck('submenu_name','link');
        return view('menu.create',compact('roles','menus','urlmenumaster','urlsubmenumaster','nastedmenu'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */

    public function store(Request $request)
    {
        $user = auth()->user()->roles->first()->name;
        $validator = Validator::make($request->all(), [
            'roles'=>'required',
            'menu_name'=>'required|max:191',
            'menu_url'=>'required|max:191',
        ]);

        if ($validator->fails())
        {
            return redirect()->route('createmenu')->withErrors($validator)->withInput();
        }

        $menu = new Menu_MasterModel;
        $menu->preferredrolename = auth()->user()->roles->first()->name;
        $menu->menuname = $request->menu_name;
        $menu->redirecturl = $request->menu_url;
        $menu->role_id = $request['roles'];

        $menu->save();

        return redirect()->back()->with('flash_message','menu successfully added.');
    }

    public function store_sub_menu(Request $request)
    {
//        return $request->all();
        $validator = Validator::make($request->all(), [
            'roles'=>'required',
            'menus'=>'required',
            'submenu_name'=>'required|max:191',
            'menu_url'=>'required|max:191',
        ]);

        if ($validator->fails())
        {
            return redirect()->route('createmenu')->withErrors($validator)->withInput();
        }

        $menumastermodel = new Menu_MasterModel;
        $menumastermodel->menuname = $request->submenu_name;
        $menumastermodel->redirecturl = $request->menu_url;
        $menumastermodel->parentid = $request->menus;
        $menumastermodel->role_id = $request['roles'];
        $menumastermodel->save();

        return redirect()->back()->with('flash_message','sub_menu successfully added.');
    }

    public function store_nasted_menu(Request $request)
    {
//        return $request->all();
        $nastedmenu = new NastedMenuModel();
        $nastedmenu->menu_name = $request->natsed_menu_name;
        $nastedmenu->url = $request->nasted_menu_url;
        $nastedmenu->role_id = $request->roles;
        $nastedmenu->submenu_id = $request->nastedmenus;
        $nastedmenu->save();
        return redirect()->back()->with('flash_message','nasted_sub_menu successfully added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        return $menu = Menu::where('id',$id)->get()->first();
        $menufor =  Role::pluck('name', 'id');
        $menuforcode = $menu->role_id;
        $urlmenu = UrlMenuMasterModel::pluck('menu_name','url');
        $urlmenucode = $menu->url;

        $sub_menu = SubMenu::where('menu_id',$id)->get();
        $sub_menufor =  Role::pluck('name', 'id');
        $sub_menu_for = menu::all()->pluck('menu_name','id');
        $sub_menu_link = SubMenu::where('menu_id',$menu->id)->get()->pluck('link','id');
        return view('menu.show',compact('menu','menufor','menuforcode','urlmenu','urlmenucode','sub_menu','sub_menufor','sub_menu_for','sub_menu_link'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
//        $menu = Menu::where('id',$id)->get()->first();
//        $menufor =  Role::pluck('name', 'id');
//        $menuforcode = $menu->role_id;
//        $urlmenu = UrlMenuMasterModel::pluck('menu_name','url');
//        $urlmenucode = $menu->url;
//
//        $sub_menu = SubMenu::where('menu_id',$id)->get();
//        $sub_menufor =  Role::pluck('name', 'id');
//        $sub_menu_for = menu::all()->pluck('menu_name','id');
//        $sub_menu_link = SubMenu::where('menu_id',$menu->id)->get()->pluck('link','id');
//        return view('menu.edit',compact('menu','menufor','menuforcode','urlmenu','urlmenucode','sub_menu','sub_menufor','sub_menu_for','sub_menu_link'));

        $menumaster = Menu_MasterModel::where('menuid',$id)->get()->first();
        $menufor =  Role::pluck('name', 'id');
        $submenumaster = Menu_MasterModel::where('parentid',$menumaster->menuid)->get();
        $urlmenu = UrlMenuMasterModel::pluck('menu_name','url');
        $urlmenucode = $menumaster->redirecturl;
        $menuforcode = $menumaster->role_id;
        $sub_menu_for = Menu_MasterModel::pluck('menuname','menuid');
        $sub_menu_link = Menu_MasterModel::where('parentid',$menumaster->menuid)->get()->pluck('redirecturl','menuid');

        return view('menu.edit',compact('menumaster','submenumaster','urlmenu','urlmenucode','menufor','menuforcode','sub_menu_for','sub_menu_link'));

    }

    public function update(Request $request, $id)
    {
        $menu = Menu_MasterModel::find($id);
        $menu->role_id = $request->role_id;
        $menu->menuname = $request->menu_name;
        $menu->redirecturl = $request->redirecturl;
        $menu->save();
        return redirect('examplegetmenuindex')->with('flash_message', 'menu successfully edited');
    }

    public function submenu_update(Request $request, $id)
    {
        $count = count($request['hdid']);
        for ($i=0; $i < $count; $i++)
        {
            $updatesubmenu = Menu_MasterModel::find($request['hdid'][$i]);
            $updatesubmenu->role_id = $request['role_id'][$i];
            $updatesubmenu->menuname = $request['submenu_name'][$i];
            $updatesubmenu->redirecturl = $request['redirecturlhdid'][$i];
            $updatesubmenu->parentid = $request['menu_id'][$i];
            $updatesubmenu->save();
        }
        return redirect('examplegetmenuindex')->with('flash_message', 'menu successfully edited');
    }

    public function destroy($id)
    {
        $user = Menu::findOrFail($id);

        $user->delete();

        return redirect('roles')->with('flash_message', 'role successfully deleted');
    }
}
