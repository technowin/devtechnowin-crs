@extends('layouts.appnew')
@section('pageTitle', 'Comment')
@section('content')
    <div class="col-md-12">
        <div class="col-md-12 row" >
            <div class="panel panel-default">
                <div class="panel-heading">Add Comments</div>
                <div class="panel-body" style="padding-left: 50px;">
                    <div class="container">
                        {{ Form::open(array('url' => 'submitcomments','method' => 'post')) }}
                        <div class="row mt-1">
                            <label for="input" class="col-sm-3 col-form-label text-muted">Ticket No.</label>
                            <div class="col-sm-6">
                                {{ Form::text('ticketno', $ticketno, array('class' => 'form-control form-control-sm','required' => 'required','readonly' => true,'style'=>'background-color:white;')) }}
                            </div>
                        </div>
                        <div class="row mt-1">
                            <label for="input" class="col-sm-3 col-form-label text-muted">Admin's Comment</label>
                            <div class="col-sm-6">
                                {{ Form::textarea('comments', '', array('class' => 'form-control form-control-sm','required' => 'required','style'=>'background-color:white;')) }}
                            </div>
                        </div>
                        <div class="row mt-1">
                            <label for="input" class="col-sm-3 col-form-label text-muted">Comment Date</label>
                            <div class="col-sm-6">
                                {{ Form::date('commentdate', null, array('class' => 'form-control form-control-sm','id' => 'complaintdateid')) }}
                            </div>
                        </div>
                        <div class="row mt-2">
                            <label for="input" class="col-sm-2 col-form-label text-muted"></label>
                            <div class="col-sm-6">
                                {{ Form::submit('Submit', array('class' => 'btn btn-primary offset-4')) }}
                            </div>
                        </div>

                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-script')

@endsection