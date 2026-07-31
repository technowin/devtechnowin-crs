@extends('layouts.appnew')
@section('pageTitle', 'Dashboard Alert Settings')
@section('content')
<div class="container-fluid" style="padding:20px;">
    <h3>Dashboard Alert Settings</h3>
    @if(session('flash_message'))
        <div class="alert alert-success">{{ session('flash_message') }}</div>
    @endif
    {{ Form::open(['url' => 'update-alert-settings', 'method' => 'post']) }}
    <table class="table table-bordered" style="max-width:600px;">
        <thead><tr><th>Alert</th><th>Description</th><th width="15%">Days</th></tr></thead>
        <tbody>
        @foreach($settings as $setting)
            <tr>
                <td>{{ $setting->alertkey }}</td>
                <td>{{ $setting->description }}</td>
                <td>
                    {{ Form::number("alertdays[{$setting->id}]", $setting->alertdays, ['class'=>'form-control form-control-sm']) }}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ Form::submit('Save', ['class' => 'btn btn-primary']) }}
    {{ Form::close() }}
</div>
@endsection