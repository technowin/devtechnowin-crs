@extends('layouts.appnew')
@section('title', '| Roles')
@section('content')
    <div class="container">
        @foreach ($assignedrole as $role)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5 class="panel-title"> Role Name : {{ Form::label($role->name, ucfirst($role->name)) }}</h5>
                </div>
                <div class="panel-body">
                    <h5 class="text-muted">List of Users</h5>
                    <ul>
                        <li>{{ $role->users->get(0)->email }}</li>
                    </ul>
                </div>
            </div>
        @endforeach
        <a href="{{ url()->previous() }}" class="btn btn-default">Back</a>
    </div>
@endsection