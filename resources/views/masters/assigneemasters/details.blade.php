@extends('layouts.appnew')

@section('page-title', '| Assignee Details')

@section('content')

    <div type="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Details Assignee </h3>
            </div>
            <div class="panel-body">

                    {{--<div class="row col-md-12">--}}
                        {{--<div for="input" class="col-sm-4 col-form-label text-muted">Assignee Code </div>--}}

                        {{--<div class="col-md-4 ol-form-label text-muted">:{{$assignees->assigneecode }}</div>--}}
                    {{--</div>--}}

                    <div class="row col-md-12">
                        <div for="input" class="col-sm-4 col-form-label text-muted">Employee Name</div>
                        <div class="col-md-4 ol-form-label text-muted">: {{$assignees->employeeid }}</div>
                    </div>

                    <div class="row col-md-12">
                        <div for="input" class="col-sm-4 col-form-label text-muted">Assignee Name</div>
                        <div class="col-md-4 ol-form-label text-muted">: {{$assignees->assigneename }}</div>
                    </div>
                    <div class="row col-md-12">
                        <div for="input" class="col-sm-4 col-form-label text-muted">Department Name</div>
                        <div class="col-md-4 ol-form-label text-muted">: {{$assignees->departmentcode}}</div>
                    </div>

                    <div class="row col-md-12">
                        <div for="input" class="col-sm-4 col-form-label text-muted">Mobile No</div>
                        <div class="col-md-4 ol-form-label text-muted">: {{$assignees->mobileno}}</div>
                    </div>

                    <div class="row col-md-12">
                        <div for="input" class="col-sm-4 col-form-label text-muted">Email</div>
                        <div class="col-md-4 ol-form-label text-muted">: {{$assignees->emailid}}</div>
                    </div>

                    <div class="row col-md-12">
                        <div for="input" class="col-sm-4 col-form-label text-muted">Labour Cost</div>
                        <div class="col-md-4 ol-form-label text-muted">: {{$assignees->labourcost}}</div>
                    </div>

                    <div class="row col-md-12">
                        <div for="input" class="col-sm-4 col-form-label text-muted">Is Active</div>
                        @if ($assignees->isactive=='1')
                            <div class="col-md-4 ol-form-label text-muted">: Yes</div>
                        @endif
                        @if ($assignees->isactive=='0')
                            <div class="col-md-4 ol-form-label text-muted">: No</div>
                        @endif
                    </div>

                    {{--<div class="row col-md-12">--}}
                        {{--<div for="input" class="col-sm-4 col-form-label text-muted">Created at</div>--}}
                        {{--<div class="col-md-4 ol-form-label text-muted">: {{$assignees->created_at}}</div>--}}
                    {{--</div>--}}
                    {{--<div class="row col-md-12">--}}
                        {{--<div for="input" class="col-sm-4 col-form-label text-muted">Updated at</div>--}}
                        {{--<div class="col-md-4 ol-form-label text-muted">: {{$assignees->updated_at}}</div>--}}
                    {{--</div>--}}

                    <br>

            </div>
        </div>
        <a class="btn btn-default" href="{{url()->previous()}}">Back</a>
    </div>

@endsection
	
	