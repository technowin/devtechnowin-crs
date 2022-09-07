@extends('layouts.appnew')

@section('page-title', '| Add Menu')

@section('content')
    <div class="container">
        <div class="panel panel-default">
            {{ Form::model($menu,['action' => ['MenuController@update', $menu->id]]) }}
            {{Form::hidden('menuurl',$urlmenucode)}}
            <div class="panel panel-default">
                <div class="panel-heading">View Menu</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="input" class="col-form-label text-muted">Menu For</label>
                            {{ Form::select('menufor', $menufor, $menuforcode, array('placeholder' => '--SELECT--','id' => 'roles','class' => 'form-control','required' => 'required','disabled' => true)) }}
                            @if ($errors->has('roles'))
                                <span class="help-block"><strong>{{ $errors->first('roles') }}</strong></span>
                            @endif
                        </div>
                        <div class="col-md-3">
                            <label for="input" class="col-form-label text-muted">Menu Name</label>
                            {{ Form::text('menu_name', $menu->menu_name, array('class' => 'form-control','required' => 'required','readonly')) }}
                            @if ($errors->has('menu_name'))
                                <span class="help-block"><strong>{{ $errors->first('menu_name') }}</strong></span>
                            @endif
                        </div>

                        <div class="col-md-3">
                            <label for="input" class="col-form-label text-muted">Menu URL</label>
                            {{ Form::select('urlmenu', $urlmenu, $urlmenucode, array('placeholder' => '--SELECT--','id' => 'menuurlid','class' => 'form-control','required' => 'required','disabled' => true)) }}
                            @if ($errors->has('menus'))
                                <span class="help-block"><strong>{{ $errors->first('menus') }}</strong></span>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
            {{ Form::close() }}

            {{ Form::open(array('url' => 'updatesubmenu/'.$menu->id,'files' => true)) }}
            <div class="panel panel-default">
                <div class="panel-heading">View Sub-Menu</div>
                <div class="panel-body">
                    @foreach($sub_menu as $key => $menu)
                        {{Form::hidden('hdid[]',$menu->id)}}
                        {{Form::hidden('link[]',$menu->id)}}
                        <div class="row">

                            <div class="col-md-3">
                                <label for="input" class="col-form-label text-muted">Role For</label>
                                {{ Form::select('role_id[]', $sub_menufor, $menu->role_id, array('placeholder' => '--SELECT--','id' => 'roles','class' => 'form-control','required' => 'required','disabled' => true)) }}
                                @if ($errors->has('roles'))
                                    <span class="help-block"><strong>{{ $errors->first('roles') }}</strong></span>
                                @endif
                            </div>

                            <div class="col-md-3">
                                <label for="input" class="col-form-label text-muted">Sub-Menu For</label>
                                {{ Form::select('menu_id[]', $sub_menu_for, $menu->menu_id, array('placeholder' => '--SELECT--','id' => 'roles','class' => 'form-control','required' => 'required','disabled' => true)) }}
                                @if ($errors->has('menus'))
                                    <span class="help-block"><strong>{{ $errors->first('menus') }}</strong></span>
                                @endif
                            </div>

                            <div class="col-md-3">
                                <label for="input" class="col-form-label text-muted">Sub-Menu Name</label>
                                {{ Form::text('submenu_name[]', $menu->submenu_name, array('class' => 'form-control','required' => 'required','disabled' => true)) }}
                                @if ($errors->has('submenu_name'))
                                    <span class="help-block"><strong>{{ $errors->first('submenu_name') }}</strong></span>
                                @endif
                            </div>

                            <div class="col-md-3">
                                <label for="input" class="col-form-label text-muted">Menu URL</label>
                                {{ Form::select('link[]', $sub_menu_link, $menu->id, array('placeholder' => '--SELECT--','id' => 'submenuurlid','class' => 'form-control','required' => 'required','disabled' => true)) }}
                                @if ($errors->has('menu_url'))
                                    <span class="help-block"><strong>{{ $errors->first('menu_url') }}</strong></span>
                                @endif
                            </div>
                        </div>
                    @endforeach

                </div>

            </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection
