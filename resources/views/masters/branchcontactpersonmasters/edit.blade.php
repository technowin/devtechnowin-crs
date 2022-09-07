@extends('layouts.appnew')

@section('page-title', '| Add User')

@section('content')

    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Edit Branch Contact</h3>
            </div>
            <div class="panel-body">
            {{ Form::model($branchcontactmasters , array('route' => array('branchescontactperson.update', $branchcontactmasters->branchcontactcode), 'method' => 'PUT')) }}

                <div class="row mt-1{{ $errors->has('contactpersonname') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Branch Person Name</label>
                    <div class="col-sm-6">
                        {{ Form::text('contactpersonname', null, array('class' => 'form-control form-control-sm')) }}
                    </div>

                </div>

                <div class="row mt-1{{ $errors->has('calleremail') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Branch Name</label>
                    <div class="col-sm-6">
                        {{ Form::select('branchmasters', $branchmasters, $customercode, array('placeholder' => 'select','required' => 'required', 'id'=> 'branchcode')) }}
                    </div>
                </div>

                <div class="row mt-1{{ $errors->has('designation') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Designation</label>
                    <div class="col-sm-6">
                        {{ Form::text('designation',null, array('class' => 'form-control form-control-sm','required' => 'required')) }}
                    </div>
                </div>


                <div class="row mt-1{{ $errors->has('assigneename') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Fax</label>
                    <div class="col-sm-6">
                        {{ Form::text('fax', null, array('class' => 'form-control form-control-sm','onKeyPress'=>'if(this.value.length==12) return false;')) }}
                    </div>

                </div>

                <div class="row mt-1{{ $errors->has('assigneename') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Phone</label>
                    <div class="col-sm-6">
                        {{ Form::text('phone', null, array('class' => 'form-control form-control-sm','onKeyPress'=>'if(this.value.length==10) return false;')) }}
                    </div>

                </div>

                <div class="row mt-1{{ $errors->has('assigneename') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Email</label>
                    <div class="col-sm-6">
                        {{ Form::email('emailid', null, array('class' => 'form-control form-control-sm')) }}
                    </div>
                </div>
                <br>
                <div class="row mt-1{{ $errors->has('calleremail') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted"></label>
                    <div class="col-sm-6">
                        {{ Form::submit('Submit', array('class' => 'btn btn-primary')) }}
                    </div>
                </div>
              {{ Form::close() }}
            </div>
        </div>
        <a class="btn btn-default" href="{{url()->previous()}}">Back</a>
    </div>

@endsection

@section('page-script')

    <script type="text/javascript">
        $(document).ready(function () {
            $('#branchcode').selectize({
                maxItems: 1
            });
        });
    </script>

@stop