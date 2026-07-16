@extends('layouts.app')

@section('pageTitle', 'Complaint Status')
<link href="{{ asset('css/loader.css') }}" rel="stylesheet">
@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card" style="height: 30rem;">
                    <div class="card-body">
                        <p>Enter Ticket Number</p>
                        <hr>
                        <form>
                            <div class="row">
                                <div class="col"><label>Ticket Number</label></div>
                                <div class="col"><input class="form-control" type="text" name="ticketnumber"></div>
                                <div class="col"> {{ Form::submit('Get Status', array('class' => 'Submit btn btn-primary offset-4')) }}</div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card" style="height: 30rem;">
                    <div class="card-body">
                        <p>Complaint status appear here</p>
                        <hr>
                        <div class="row">
                            <div class="col">
                                <div id="response"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/Selectize/jquery-1.10.2.js') }}"></script>
    <script>
        function doGet(url, params) {
            params = params || {};
            $.get(url, params, function(response) { // requesting url which in form
                if (response != null){
                    debugger
                    $('#response').html(response); // getting response and pushing to element with id #response
                }else {
                    $('#response').html('');
                }
            });
        }
        $(function() {
            $('form').submit(function(e) { // catching form submit
                e.preventDefault(); // preventing usual submit
                doGet('getcomplaintstatus', $(this).serializeArray()); // calling function above with passing inputs from form
            });
        });
    </script>
@endsection