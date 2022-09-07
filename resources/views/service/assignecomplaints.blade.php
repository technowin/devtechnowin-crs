@extends('layouts.appnew')
@section('page-title', '| Add User')
@section('page-css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css"/>
@stop

@section('content')
{{ Form::open(array('url' => 'storeequipment','files' => true)) }}

<div id="treeview">
<ul>
<li value="{{ $workorder->workorderno }}">{{ $workorder->workorderno }}
<ul>
@foreach($equipmet as $equipmetsrno)
<li value="{{ $equipmetsrno->equipmentsrno }}">{{ $equipmetsrno->equipmentsrno }}</li>
@endforeach
</ul>
</li>
</ul>
</div>

<br>

<input type="button" class="btn btn-primary" value="Save & Close" onclick="saveandclose();">
{{ Form::submit('Save & Close', array('class' => 'btn btn-primary', 'id' => 'btnSubmit')) }}

{{ Form::close() }}

@endsection