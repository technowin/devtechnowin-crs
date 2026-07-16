@extends('layouts.appnew')

@section('page-title', '| Branch Master')

@section('content')

    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Edit Branch</h3>
            </div>
            <div class="panel-body">
                <div class="container">
                    {{ Form::model($branchesmaster , array('route' => array('branches.update', $branchesmaster->branchcode), 'method' => 'PUT')) }}

                    {{ Form::hidden('workorderno', $branchesmaster->workorderno, array('id' => 'workorderno')) }}
                    {{ Form::hidden('branchcode', $branchesmaster->branchcode, array('id' => 'branchcode')) }}
                    <div class="row mt-1{{ $errors->has('contactpersonname') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Branch Name</label>
                        <div class="col-sm-6">
                            {{ Form::text('branchname', null, array('class' => 'form-control form-control-sm')) }}
                        </div>

                    </div>

                    <div class="row mt-1{{ $errors->has('calleremail') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Customer Name</label>
                        <div class="col-sm-6">
                            {{ Form::select('customers', $customers, $customercode, array('placeholder' => 'select','required' => 'required','id' => 'customercode')) }}
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

                    <div class="row mt-1{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Email</label>
                        <div class="col-sm-6">
                            {{ Form::email('email', null, array('class' => 'form-control form-control-sm')) }}
                        </div>

                    </div>
                    <br>
                    <div class="row mt-1{{ $errors->has('calleremail') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted"></label>
                        <div class="col-sm-6">
                            {{ Form::submit('Save & Close', array('class' => 'btn btn-primary')) }}
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection


@section('page-script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#customercode').selectize({
                maxItems: 1
            });
        });
    </script>
@stop