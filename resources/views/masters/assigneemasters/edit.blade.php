@extends('layouts.appnew')

@section('page-title', '| Edit Assignee')

@section('content')

    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Edit Assignee</h3>
            </div>
            <div class="panel-body">
                {{ Form::model($assignees , array('route' => array('assignee.update', $assignees->assigneecode), 'method' => 'PUT')) }}

                <div class="row mt-1{{ $errors->has('appadmin/assigneename') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Assignee Name</label>
                    <div class="col-sm-6">
                        {{ Form::text('assigneename', null, array('class' => 'form-control')) }}
                    </div>
                </div>

                <div class="row mt-1{{ $errors->has('calleremail') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Department Name</label>
                    <div class="col-sm-6">
                        {{ Form::select('departments', $departments, $departmentcode, array('id'=>'departments','placeholder' => 'select','required' => 'required')) }}
                    </div>
                </div>

                <div class="row mt-1{{ $errors->has('assigneename') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Mobile No</label>
                    <div class="col-sm-6">
                        {{ Form::number('mobileno', null, array('class' => 'form-control','onKeyPress'=>'if(this.value.length==10) return false;')) }}
                    </div>

                </div>

                <div class="row mt-1{{ $errors->has('assigneename') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Email</label>
                    <div class="col-sm-6">
                        {{ Form::email('emailid', null, array('id'=>'emailid','class' => 'form-control','onchange' => 'checkEmail();')) }}
                    </div>
                </div>

                <div class="row mt-1{{ $errors->has('assigneename') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Labour Cost</label>
                    <div class="col-sm-6">
                        {{ Form::number('labourcost', null, array('class' => 'form-control')) }}
                    </div>
                </div>

                <div class="row mt-1{{ $errors->has('calleremail') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Employee Name</label>
                    <div class="col-sm-6">
                        {{ Form::select('employees', $employees, $employeescode, array('id'=>'employees','placeholder' => 'select')) }}
                    </div>
                </div>

                <div class="row mt-1{{ $errors->has('calleremail') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Is Active</label>
                    <div class="col-sm-6">
                        {{ Form::select('isactive', array('1' => 'Yes','0' => 'No'),null, array('id'=>'isactive','required' => 'required')) }}
                        @if ($errors->has('calleremail'))
                            <span class="help-block"><strong>{{ $errors->first('calleremail') }}</strong></span>
                        @endif
                    </div>
                </div>
                <br>
                <div class="row mt-1">
                    <label for="input" class="col-sm-4 col-form-label text-muted"></label>
                    <div class="col-sm-6">


                        {{ Form::submit('Submit', array('class' => 'btn btn-primary','onclick'=>'return checkEmail();')) }}
{{--                        {{ Form::submit('Submit', array('class' => 'btn btn-primary','onclick'=>'checkEmail()')) }}--}}

                        <a class="btn btn-primary" href="{{url()->previous()}}">Cancel</a>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>

    </div>

@endsection

@section('selectize-script')
    <script src="{{ asset('assets/Selectize/jquery-1.10.2.js') }}"></script>
    <script src="{{ asset('assets/Selectize/js/standalone/selectize.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#employees').selectize({
                maxItems: 1
            });

            $('#departments').selectize({
                maxItems: 1
            });

            $('#isactive').selectize({
                maxItems: 1
            });
        });
    </script>

    <script type="text/javascript">

        function checkEmail() {
debugger
            if ($('#departments').val() == "") {
                   alert('select worktype');
               }
               else
               {
                   var email =  $('#emailid').val();
                   var reEmail =  /^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!\.)){0,61}[a-zA-Z0-9]?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!$)){0,61}[a-zA-Z0-9]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/;
                   if(!email.match(reEmail)) {
                       alert('Invalid Email Address');
                       $('#emailid').focus;
                       return false;
                   }
                   return true;
               }
           }


    </script>
@stop
