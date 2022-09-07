@if(Auth::check())
    <div hidden>
        {{  $menumastermodel= App\Models\Menu_MasterModel::where('role_id', auth()->user()->roles->first()->id)->get()  }}
    </div>
    @foreach($menumastermodel as $menumaster)
        <ul class="nav navbar-nav">
            @if($menumaster->parentid == 0)
                <li>
                    <div hidden>
                        {{$value =  App\Models\Menu_MasterModel::where('parentid',$menumaster->menuid)->get()->first()}}
                    </div>

                    @if($value == null)
                        <a href="{{URL::to($menumaster->redirecturl)}}">{{$menumaster->menuname}}</a>
                    @else
                        <a href="" class="dropdown-toggle" data-toggle="dropdown">{{$menumaster->menuname}}<b class="caret"></b></a>
                    @endif
                    <ul class="dropdown-menu">
                        @foreach($menumastermodel as $menu)
                            @if($menumaster->menuid == $menu->parentid)
                                <li>
                                    <div hidden>
                                        {{$val =  App\Models\Menu_MasterModel::where('parentid',$menu->menuid)->get()->first()}}
                                    </div>
                                    @if($val == null)
                                        <a href="{{URL::to($menu->redirecturl)}}">{{$menu->menuname}}</a>
                            @else
                                <li class="dropdown-submenu">
                                    <a href="" class="dropdown-toggle" data-toggle="dropdown">{{$menu->menuname}}</a>
                                    @endif
                                    <ul class="dropdown-menu">
                                        @foreach($menumastermodel as $submenu)
                                            @if($menu->menuid ==  $submenu->parentid)

                                                <li>
                                                    <div hidden>
                                                        {{$mysubmenuval =  App\Models\Menu_MasterModel::where('parentid',$submenu->menuid)->get()->first()}}
                                                    </div>
                                                    @if($mysubmenuval == null)
                                                        <a href="{{URL::to($submenu->redirecturl)}}">{{$submenu->menuname}}</a>
                                            @else
                                                <li class="dropdown-submenu">
                                                    <a href="" class="dropdown-toggle" data-toggle="dropdown">{{$submenu->menuname}}</a>
                                                    @endif

                                                    <ul class="dropdown-menu">
                                                        @foreach($menumastermodel as $nastedsubmenu)
                                                            @if($submenu->menuid ==  $nastedsubmenu->parentid)
                                                                <li>
                                                                    <div hidden>
                                                                        {{$mysubnestedval =  App\Models\Menu_MasterModel::where('parentid',$nastedsubmenu->menuid)->get()->first()}}
                                                                    </div>
                                                                    @if($mysubnestedval == null)
                                                                        <a href="{{URL::to($nastedsubmenu->redirecturl)}}">{{$nastedsubmenu->menuname}}</a>
                                                            @else
                                                                <li class="dropdown-submenu">
                                                                    <a href="" class="dropdown-toggle" data-toggle="dropdown">{{$nastedsubmenu->menuname}}</a>
                                                                    @endif
                                                                    <ul class="dropdown-menu">
                                                                        @foreach($menumastermodel as $mynastedsubmenu)
                                                                            @if($nastedsubmenu->menuid ==  $mynastedsubmenu->parentid)
                                                                                <li>
                                                                                    <div hidden>
                                                                                        {{$values =  App\Models\Menu_MasterModel::where('parentid',$mynastedsubmenu->menuid)->get()->first()}}
                                                                                    </div>
                                                                                    @if($values == null)
                                                                                        <a href="{{URL::to($mynastedsubmenu->redirecturl)}}">{{$mynastedsubmenu->menuname}}</a>
                                                                            @else
                                                                                <li class="dropdown-submenu">
                                                                                    <a href="" class="dropdown-toggle"
                                                                                       data-toggle="dropdown">{{$mynastedsubmenu->menuname}}</a>
                                                                                    @endif
                                                                                </li>
                                                                            @endif
                                                                        @endforeach
                                                                    </ul>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </li>
            @endif
        </ul>
    @endforeach
@endif


