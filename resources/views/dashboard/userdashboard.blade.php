@extends('layouts.appnew')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h5 class="card-title text-muted table-hover"><img src="{{ asset('img/user-2-icon.png') }}" width="50" height="50" />  Profile</h5>
                    <p class="card-text"><small class="text-muted"><b>Last Active : {{ $user->updated_at }}</b></small></p>
                    <a href="{{ URL::to('settings') }}" class="btn btn-primary">Settings</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h5 class="card-title text-muted table-hover"><img src="{{ asset('img/mail.png') }}" width="50" height="50" />   Complaints</h5>
                    <p class="card-text"><small class="text-muted"><b>Active Complaint : </b></small></p>
                    <a href="{{ URL::to('mycomplaints') }}" class="btn btn-primary">Complaints</a>
                </div>
            </div>
        </div>
        <div class="col-md-4"></div>
    </div>
@endsection

@section('page-script')
    <script type="text/javascript">
        $(document).ready(function () {
            window.setTimeout(function () {
                $(".alert").fadeTo(1500, 0).slideUp(500, function () {
                    $(this).remove();
                });
            }, 5000);
        });
    </script>
@stop

