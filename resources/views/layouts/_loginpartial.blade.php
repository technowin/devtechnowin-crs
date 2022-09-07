@if(Auth::check())
    <div hidden>
        {{ $menumastermodel = App\Models\SubmenuModel::where('role_id', auth()->user()->roles->first()->id)->get()  }}
    </div>
    @foreach($menumastermodel as $menumaster)

        <ul class="nav navbar-nav" style="padding-right: 3px;">
            @if($menumaster->parentid == 0)
                <li>
                    <div hidden>
                        {{$value =  App\Models\SubmenuModel::where('parentid',$menumaster->menuid)->get()->first()}}
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
                                        {{$val =  App\Models\SubmenuModel::where('parentid',$menu->menuid)->get()->first()}}
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
                                                        {{$mysubmenuval =  App\Models\SubmenuModel::where('parentid',$submenu->menuid)->get()->first()}}
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
                                                                        {{$mysubnestedval =  App\Models\SubmenuModel::where('parentid',$nastedsubmenu->menuid)->get()->first()}}
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
                                                                                        {{$values =  App\Models\SubmenuModel::where('parentid',$mynastedsubmenu->menuid)->get()->first()}}
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

@guest
<li><a href="{{ route('login') }}">Login</a></li>
{{--<li><a href="{{ route('register') }}">Register</a></li>--}}
@else
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true"><i class="fa fa-user" aria-hidden="true"></i>  {{ Auth::user()->name }} <span class="caret"></span></a>
        <ul class="dropdown-menu">
            <div hidden>
            {{ $role = App\Models\UserRolesModel::where('id', auth()->user()->roles->first()->id)->get()->first()  }}
            </div>
              @if($role->name == "admin")
                <li><a href="{{ url('adminchangepassword') }}"><i class="fa fa-cog" aria-hidden="true"></i> Change Password</a></li>
              @endif
            @if($role->name == "user")
                <li><a href="{{ url('userchangepassword') }}"><i class="fa fa-cog" aria-hidden="true"></i> Change Password</a></li>
            @endif
            @if($role->name == "assignee")
                <li><a href="{{ url('assigneechangepassword') }}"><i class="fa fa-cog" aria-hidden="true"></i> Change Password</a></li>
            @endif
            @if($role->name == "tender")
                <li><a href="{{ url('tenderchangepassword') }}"><i class="fa fa-cog" aria-hidden="true"></i> Change Password</a></li>
            @endif

            <li><a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a><form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form></li>
        </ul>
    </li>
@endif