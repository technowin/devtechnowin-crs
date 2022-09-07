@extends('layouts.appnew')

@section('page-title', '| Add User')

@section('page-css')
    <link href="{{ asset('datatable/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
@stop

@section('content')

    @if (session('flash_message'))
        <div class="alert alert-danger">
            {{ session('flash_message') }}
        </div>
    @endif


    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-md-12 row">
                <div class="col-md-10"><h6>Assignee Master</h6></div>
                <div class="col-md-2">
                    <a class="btn btn-blue" data-toggle="modal" data-target=".bs-example-modal-lg"> <b>Add New Assignee</b></a>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body table-responsive">
            <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr class="text-muted">
                    {{--<th>#</th>--}}
                    {{--<th>Assignee Code</th>--}}
                    <th>Assignee Name</th>
                    <th>Department Name</th>
                    <th>Employee Name</th>
                    <th>Mobile No</th>
                    <th>Email</th>
                    {{--<th>Labour Cost</th>--}}
                    <th>Is Active</th>
                    {{--<th>created_at</th>--}}
                    {{--<th>updated_at</th>--}}
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($assignees as $key => $assignee)
                    <tr>
                        {{--<th scope="row">{{$key+1}}</th>--}}
                        {{--<td>{{ $assignee->assigneecode }}</td>--}}
                        <td>{{ $assignee->assigneename }}</td>
                        <td>{{ $assignee->department->departmentname  OR "NA"}}</td>
                        <td>{{ $assignee->employee->employeename or "NA" }}</td>
                        <td>{{ $assignee->mobileno }}</td>
                        <td>{{ $assignee->emailid }}</td>
                        {{--<td>{{ $assignee->labourcost }}</td>--}}
                        <td>{{ $assignee->isactive == 1 ? "Yes" : "No" }}</td>
                        {{--<td>{{ is_null($assignee->created_at) ? '' : $assignee->created_at->format('m-d-Y') }}</td>--}}
                        {{--<td>{{ is_null($assignee->updated_at) ? '' : $assignee->updated_at->format('m-d-Y') }}</td>--}}
                        <td>
                            <a  href="{{ route('assignee.show', ['id' => $assignee->assigneecode]) }}">view</a> |
                            <a  href="{{ route('assignee.edit', ['id' => $assignee->assigneecode]) }}">edit</a>
                            {{--<a href="{{ URL::to('deleteassignee',array($assignee->assigneecode))}}">delete</a>--}}
                            {{--<a href="#" data-href="{{ route('assignee.destroy', ['id' => $assignee->assigneecode]) }}" data-toggle="modal" data-target="#confirm-delete">delete</a>--}}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $assignees->links() }}

        </div>
    </div>

    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">

        <div class="modal-dialog" role="document">
            {{ Form::open(array('action' => 'Masters\AssigneeMasterController@store')) }}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="gridSystemModalLabel">Create Assignee</h4>
                </div>
                <div class="modal-body">

                    <div class="row mt-1">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Assignee Name</label>
                        <div class="col-sm-6">
                            {{ Form::text('assigneename', '', array('class' => 'form-control form-control-sm','required' => 'required')) }}
                            @if ($errors->has('assigneename'))
                                <span class="help-block"><strong>{{ $errors->first('assigneename') }}</strong></span>
                            @endif
                        </div>
                    </div>

                    <div class="row mt-1">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Department Name</label>
                        <div class="col-sm-6">
                            {{ Form::select('departmentcode', $departmentcode, null, array('placeholder' => 'select','required' => 'required','id' => 'departmentcode')) }}
                            @if ($errors->has('departmentcode'))
                                <span class="help-block"><strong>{{ $errors->first('sectordescription') }}</strong></span>
                            @endif
                        </div>
                    </div>

                    <div class="row mt-1{{ $errors->has('mobileno') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Mobile No</label>
                        <div class="col-sm-6">
                            {{ Form::number('mobileno', '', array('class' => 'form-control form-control-sm','onKeyPress'=>'if(this.value.length==10) return false;')) }}
                            @if ($errors->has('mobileno'))
                                <span class="help-block"><strong>{{ $errors->first('mobileno') }}</strong></span>
                            @endif
                        </div>
                    </div>

                    <div class="row mt-1{{ $errors->has('mobileno') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Email</label>
                        <div class="col-sm-6">
                            {{ Form::email('emailid', '', array('required' => 'required','id'=>'emailid','class' => 'form-control form-control-sm','onchange'=>'validemail();')) }}
                            @if ($errors->has('emailid'))
                                <span class="help-block"><strong>{{ $errors->first('emailid') }}</strong></span>
                            @endif
                        </div>
                    </div>

                    <div class="row mt-1{{ $errors->has('labourcost') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Labour Cost</label>
                        <div class="col-sm-6">
                            {{ Form::number('labourcost', '', array('class' => 'form-control form-control-sm', 'max'=>'9999999999')) }}
                            @if ($errors->has('labourcost'))
                                <span class="help-block"><strong>{{ $errors->first('labourcost') }}</strong></span>
                            @endif
                        </div>
                    </div>

                    <div class="row mt-1">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Employee Name</label>
                        <div class="col-sm-6">
                            {{ Form::select('emplyeescode', $emplyeescode, null, array('placeholder' => 'select','id' => 'emplyeescode' )) }}
                        </div>
                    </div>

                    <div class="row mt-1{{ $errors->has('calleremail') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Is Active</label>
                        <div class="col-sm-6">
                            {{ Form::select('isactive', array('1' => 'Yes','0' => 'No'),null, array('placeholder' => 'select', 'id' => 'isactive')) }}
                            @if ($errors->has('calleremail'))
                                <span class="help-block"><strong>{{ $errors->first('calleremail') }}</strong></span>
                            @endif
                        </div>
                    </div>

                    <div class="row mt-1{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Password</label>
                        <div class="col-sm-6">
                            {{ Form::password('password', array('class' => 'form-control form-control-sm','required' => 'required')) }}
                            @if ($errors->has('password'))
                                <span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>
                            @endif
                        </div>
                    </div>

                    <div class="row mt-1{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Confirm Password</label>
                        <div class="col-sm-6">
                            {{ Form::password('password_confirmation', array('class' => 'form-control form-control-sm','required' => 'required')) }}
                        </div>
                    </div>
                    <div class="row mt-1{{ $errors->has('password') ? ' has-error' : '' }}">

                        <div class="col-sm-10">
                            @if (session('flash_message'))
                                <div class="alert alert-success">
                                    {{ session('flash_message') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    {{ Form::submit('submit', array('class' => 'btn btn-primary col-md-offset-9')) }}
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

@section('page-script')

    <script src="{{asset('datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('datatable/js/dataTables.bootstrap.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('#example').DataTable();
        });
    </script>
    <script>
        $('#confirm-delete').on('show.bs.modal', function (e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#emplyeescode').selectize({
                maxItems: 1
            });
            $('#departmentcode').selectize({
                maxItems: 1
            });
            $('#isactive').selectize({
                maxItems: 1
            });
        });
    </script>
    <script type="text/javascript">
        function validemail() {
            var email =  $('#emailid').val();
            var reEmail =  /^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!\.)){0,61}[a-zA-Z0-9]?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!$)){0,61}[a-zA-Z0-9]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/;
            if(!email.match(reEmail)) {
                alert('Invalid Email Address');
                $('#branchemailid_'+id).val('');
                return false;
            }
            return true;
        }

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


@stop
	