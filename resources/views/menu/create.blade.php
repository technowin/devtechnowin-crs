@extends('layouts.appnew')

@section('page-title', '| Add Menu')

@section('content')
    <div class="container">
        {{ Form::open(array('action' => 'MenuController@store')) }}
        <div class="panel panel-default">
            <div class="panel-heading">Create Menu</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-3">
                        <label for="input" class="col-form-label text-muted">Menu For</label>
                        {{ Form::select('roles', $roles, null, array('placeholder' => '--SELECT--','id' => 'roles','class' => 'form-control','required' => 'required')) }}
                        @if ($errors->has('roles'))
                            <span class="help-block"><strong>{{ $errors->first('roles') }}</strong></span>
                        @endif
                    </div>
                    <div class="col-md-3">
                        <label for="input" class="col-form-label text-muted">Menu Name</label>
                        {{ Form::text('menu_name', '', array('class' => 'form-control','required' => 'required')) }}
                        @if ($errors->has('menu_name'))
                            <span class="help-block"><strong>{{ $errors->first('menu_name') }}</strong></span>
                        @endif
                    </div>

                    <div class="col-md-3">
                        <label for="input" class="col-form-label text-muted">Menu URL</label>
                        {{ Form::select('menu_url', $urlmenumaster, null, array('placeholder' => '--SELECT--','id' => 'menusid','required' => 'required')) }}
                        @if ($errors->has('menus'))
                            <span class="help-block"><strong>{{ $errors->first('menus') }}</strong></span>
                        @endif
                    </div>

                </div>
            </div>
            <div class="panel-footer">{{ Form::submit('submit', array('class' => 'btn btn-primary')) }}</div>
        </div>
        {{ Form::close() }}

        {{ Form::open(array('action' => 'MenuController@store_sub_menu')) }}
        <div class="panel panel-default">
            <div class="panel-heading">Create Sub-Menu</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-3">
                        <label for="input" class="col-form-label text-muted">Role For</label>
                        {{ Form::select('roles', $roles, null, array('placeholder' => '--SELECT--','id' => 'roles','class' => 'form-control','required' => 'required')) }}
                        @if ($errors->has('roles'))
                            <span class="help-block"><strong>{{ $errors->first('roles') }}</strong></span>
                        @endif
                    </div>
                    <div class="col-md-3">
                        <label for="input" class="col-form-label text-muted">Sub-Menu For</label>
                        {{ Form::select('menus', $menus, null, array('placeholder' => '--SELECT--','id' => 'menus','required' => 'required')) }}
                        @if ($errors->has('menus'))
                            <span class="help-block"><strong>{{ $errors->first('menus') }}</strong></span>
                        @endif
                    </div>
                    <div class="col-md-3">
                        <label for="input" class="col-form-label text-muted">Sub-Menu Name</label>
                        {{ Form::text('submenu_name', null, array('class' => 'form-control','required' => 'required')) }}
                        @if ($errors->has('submenu_name'))
                            <span class="help-block"><strong>{{ $errors->first('submenu_name') }}</strong></span>
                        @endif
                    </div>
                    <div class="col-md-3">
                        <label for="input" class="col-form-label text-muted">Menu URL</label>
                        {{ Form::select('menu_url', $urlsubmenumaster, null, array('placeholder' => '--SELECT--','id' => 'submenuurlid','required' => 'required')) }}
                        {{--{{ Form::text('menu_url', null, array('class' => 'form-control','required' => 'required')) }}--}}
                        @if ($errors->has('menu_url'))
                            <span class="help-block"><strong>{{ $errors->first('menu_url') }}</strong></span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="panel-footer">{{ Form::submit('submit', array('class' => 'btn btn-primary')) }}</div>
        </div>
        {{ Form::close() }}


        @if (Session::has('flash_message'))
            <div class="alert alert-info">{{ Session::get('flash_message') }}</div>
        @endif

        <a href="{{url()->previous()}}" class="btn btn-default">Back</a>
    </div>
@endsection

@section('selectize-script')
    <script src="{{ asset('assets/Selectize/jquery-1.10.2.js') }}"></script>
    <script src="{{ asset('assets/Selectize/js/standalone/selectize.js') }}"></script>
    <script>

        $('#menusid').selectize({
            maxItems: 1
        });
        $('#submenuurlid').selectize({
            maxItems: 1
        });
        $('#nastedmenuurlid').selectize({
            maxItems: 1
        });
        $('#menus').selectize({
            maxItems: 1
        });

    </script>

@stop
