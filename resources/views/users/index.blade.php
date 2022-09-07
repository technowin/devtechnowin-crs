@extends('layouts.appnew')

@section('pageTitle', 'Assignee')

@section('page-css')
    <link href="{{ asset('datatable/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
@stop

@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-md-12 row">
                <div class="col-md-10"><h6>Available Users</h6></div>
                <div class="col-md-2">
                    <a class="btn btn-blue" data-toggle="modal" data-target=".bs-example-modal-lg"> <b>Add New Users</b>
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if (session('flash_message'))
        <div class="alert alert-success">
            {{ session('flash_message') }}
        </div>
    @endif

    @if (session('error-message'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{session('error-message')}}
        </div>
    @endif
    <div class="panel with-nav-tabs panel-default">
        <div class="panel-body">
            <div class="tab-content">
                <div class="tab-pane fade in active" id="newcomplaints">
                    <table class="table table-sm table-hover" id="usertableid" cellspacing="0" width="100%">
                        <thead>
                        <tr class="text-muted">
                            <th>#</th>
                            <th>name</th>
                            <th>email</th>
                            <th>mobile</th>
                            <th>role</th>
                            <th>is verified</th>
                            <th>created_at</th>
                            <th>updated_at</th>
                            <th>action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $key => $user)
                            <tr>
                                <th scope="row">{{$key+1}}</th>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->mobile }}</td>
                                <td>{{ $user->roles()->pluck('name')->implode(' ') }}</td>
                                <td>{{ $user->is_verified }}</td>
                                <td>{{ is_null($user->created_at) ? '' : $user->created_at->format('m-d-Y') }}</td>
                                <td>{{ is_null($user->updated_at) ? '' : $user->updated_at->format('m-d-Y') }}</td>
                                <td>
                                    <a href="{{ url('viewuser/'.$user->id) }}">view</a> |
                                    <a href="{{ url('edituser/'.$user->id) }}">edit</a>
                                    {{--<a href="#" data-href="{{ url('deleteuser/'.$user->id) }}" data-toggle="modal"--}}
                                       {{--data-target="#confirm-delete">delete</a>--}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
        <div class="modal-dialog" role="document">
            {{ Form::open(array('action' => 'UserController@store')) }}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="gridSystemModalLabel">Create User</h4>
                </div>
                <div class="modal-body">
                    <div class="container offset-1">
                        <div class="form-group{{ $errors->has('customers') ? ' has-error' : '' }}">
                            <label for="roles">Customer</label>
                            {{ Form::select('customercode', $customercode, null,array('class' => 'form-control','id' => 'customers','placeholder' => '-SELECT-')) }}
                            @if ($errors->has('customers'))
                                <span class="help-block"><strong>{{ $errors->first('customers') }}</strong></span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name">Name</label>
                            {{ Form::text('name', '', array('class' => 'form-control','required' => 'required')) }}
                            @if ($errors->has('name'))
                                <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email">Email</label>
                            {{ Form::email('email', '', array('class' => 'form-control','required' => 'required')) }}
                            @if ($errors->has('email'))
                                <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
                            <label for="mobile">Mobile</label>
                            {{ Form::number('mobile', '', array('class' => 'form-control','required' => 'required','onKeyPress' => "if(this.value.length==10) return false;",
                            'id' => 'mobileno','onfocusout' => "mobileValid()")) }}
                            @if ($errors->has('mobile'))
                                <span class="help-block"><strong>{{ $errors->first('mobile') }}</strong></span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('roles') ? ' has-error' : '' }}">
                            <label for="roles">Roles</label>
                            {{ Form::select('roles', $roles, null,array('class' => 'form-control','required' => 'required','placeholder' => '-SELECT-')) }}
                            @if ($errors->has('roles'))
                                <span class="help-block"><strong>{{ $errors->first('roles') }}</strong></span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password">Password</label>
                            {{ Form::password('password', array('class' => 'form-control form-control-sm','required' => 'required')) }}
                            @if ($errors->has('password'))
                                <span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password_confirmation">Confirm Password</label>
                            {{ Form::password('password_confirmation', array('class' => 'form-control','required' => 'required')) }}
                            @if ($errors->has('password_confirmation'))
                                <span class="help-block"><strong>{{ $errors->first('password_confirmation') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    {{ Form::submit('submit', array('class' => 'btn btn-primary col-md-offset-9','onclick' => 'return mobileValid()')) }}
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>

    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
                </div>

                <div class="modal-body">
                    <p>You are about to delete one track, this procedure is irreversible.</p>
                    <p>Do you want to proceed?</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger btn-ok">Delete</a>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('selectize-script')
    <script src="{{asset('datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('datatable/js/dataTables.bootstrap.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('#usertableid').DataTable();
        });

    </script>
    <script>
        $('#confirm-delete').on('show.bs.modal', function (e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            window.setTimeout(function () {
                $(".alert").fadeTo(1500, 0).slideUp(500, function () {
                    $(this).remove();
                });
            }, 5000);
        });
    </script>
    <script type="text/javascript">
        function mobileValid(){
            var number;
            debugger;
            number = document.getElementById('mobileno').value;
            if(number.length < 10){
                debugger;
                alert('Mobile no. must be of 10 digits.');
                return false;
            }
        }
    </script>
@endsection
