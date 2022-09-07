@extends('layouts.appnew')

@section('page-title', '| Feedback')

@section('page-css')
    <link href="{{asset('css/star-rating.min.css')}}" rel="stylesheet">
@stop

@section('content')
    <div class="container">
        {{ Form::open(array('action' => 'FeedbackController@store','id' => 'ratingsForm','class'=> 'form-horizontal')) }}
        {{ Form::hidden('ticketno',$ticketno) }}
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <div class="row">
                        <div class="col-md-6">Feedback</div>
                        <div class="col-md-6"></div>
                    </div>
                </h3>
            </div>
            <div class="panel-body">
                <div class="form-group{{ $errors->has('stars') ? ' has-error' : '' }}">
                    <label class="col-sm-2 control-label">Ratings</label>
                    <div class="col-sm-10">
                        <input id="input-1" required name="stars" class="rating rating-loading" data-min="0"
                               data-max="5" data-step="0.5" value="1">
                    </div>
                </div>
                <div class="form-group{{ $errors->has('feedback_description') ? ' has-error' : '' }}">
                    <label class="col-sm-2 control-label">Description</label>
                    <div class="col-sm-10">
                        {{ Form::textarea('feedback_description',null,['required' => 'required','class'=>'form-control', 'rows' => 2, 'cols' => 40]) }}
                    </div>
                </div>
            </div>
            <div class="panel-footer">{{ Form::submit('submit', array('class' => 'btn btn-primary btn-block')) }}</div>
        </div>
        {{ Form::close() }}
    </div>
@endsection

@section('page-script')
    <script src="{{asset('js/star-rating.min.js')}}"></script>
@stop