@extends('layouts.app')

@section('page-title', '| Add User')

@section('content')


    <div class="card">
        <div class="card-block">
            <h6 class="card-subtitle mb-2 text-muted">Add Sector</h6>
            <hr/>
            {{ Form::open(array('url' => 'sectors.store')) }}

            <div class="row col-md-4">
                <div class="col">
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name">Sector Code</label>
                        {{ Form::text('sectorcode', '', array('class' => 'form-control','required' => 'required')) }}
                        @if ($errors->has('sectorcode'))
                            <span class="help-block">
                          <strong>{{ $errors->first('sectorcode') }}</strong>
                       </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row col-md-4">
                <div class="col">
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name">Sector Name</label>
                        {{ Form::text('sectorname', '', array('class' => 'form-control','required' => 'required')) }}
                        @if ($errors->has('sectorname'))
                            <span class="help-block">
                          <strong>{{ $errors->first('sectorname') }}</strong>
                       </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row col-md-4">
                <div class="col">
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="name">Sector Description</label>
                        {{ Form::text('sectordescription', '', array('class' => 'form-control','required' => 'required')) }}
                        @if ($errors->has('sectordescription'))
                            <span class="help-block">
                          <strong>{{ $errors->first('sectordescription') }}</strong>
                       </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row col-md-4">
                <div class="col">
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="name">Is Active</label>
{{--                        {{ Form::select('sectordescription', '', array('class' => 'form-control','required' => 'required'))}}--}}
                        {{ Form::select('sectordescription', array('1' => 'Yes','0' => 'No'), null, array('placeholder' => 'select','required' => 'required', 'class' => 'form-control', 'id' => 'sectordescription', 'rel' => URL::to('/'))) }}
                        @if ($errors->has('sectordescription'))
                            <span class="help-block">
                          <strong>{{ $errors->first('sectordescription') }}</strong>
                       </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row col-md-4">
                <div class="col">
                    <div class="form-group">
                        {{ Form::submit('Add Sector', array('class' => 'btn btn-primary')) }}
                    </div>
                </div>
            </div>


            {{--<div class="col-md-4">--}}
                {{--<a class="btn btn-outline-secondary" href="{{ route('sectors.store') }}" style="color:gray;"> <b>Sumbit--}}
                        {{--</b> </a>--}}
            {{--</div>--}}

            {{ Form::close() }}
        </div>
    </div>

@endsection