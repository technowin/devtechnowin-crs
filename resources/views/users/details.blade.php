@extends('layouts.appnew')

@section('title', '| View User')

@section('content')

    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">User Details</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4">Name : {{$user->name}}</div>
                    <div class="col-md-4">Email : {{$user->email}}</div>
                    <div class="col-md-4">Mobile : {{$user->mobile}}</div>
                </div>
                <div class="row" style="margin-top: 0.4rem;">
                    <div class="col-md-4">Role : {{ $user->roles()->pluck('name')->implode(' ') }}</div>
                    <div class="col-md-4"></div>
                    <div class="col-md-4"></div>
                </div>
            </div>
        </div>
        <a class="btn btn-default" href="{{url()->previous()}}">Back</a>
    </div>

@endsection
