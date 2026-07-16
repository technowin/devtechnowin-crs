@extends('layouts.appnew')

@section('page-title', '| Customers')

@section('content')

    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"> Service Management</h3>
            </div>
            <div class="panel-body">
                <div class="container">
                    {{ Form::open(array('url'=>'servicemanagementeditpost'.$servicemanagementmodel->id, 'files' =>true )) }}

                    {{ Form::hidden('contracttodate', $contracttodate, array('id' => 'contracttodate')) }}
                    <div class="row mt-1{{ $errors->has('contractno') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Contract No</label>
                        <div class="col-sm-6">
                            {{ Form::text('contractno',$servicemanagementmodel->contractno, array('class' => 'form-control','readonly' => 'true')) }}
                        </div>
                    </div>
                    <div class="row mt-1{{ $errors->has('customercode') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Customer Name</label>
                        <div class="col-sm-6">
                            {{ Form::text('customercode',$servicemanagementmodel->customername, array('class' => 'form-control','readonly'=>'true')) }}
                        </div>

                    </div>
                    <div class="row mt-1{{ $errors->has('serviceadate') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Service Date</label>
                        <div class="col-sm-6">
                            {{ Form::date('serviceadate',$servicemanagementmodel->serviceadate, array('id'=>'serviceadate','class' => 'form-control form-control-sm','readonly'=>'true','max'=>'2100-01-01')) }}
                        </div>

                    </div>
                    <div class="row mt-1{{ $errors->has('servicereminderdate') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Service reminder date</label>
                        <div class="col-sm-6">
                            {{ Form::date('servicereminderdate',$servicemanagementmodel->servicereminderdate, array('class' => 'form-control form-control-sm','readonly'=>'true','max'=>'2100-01-01')) }}
                        </div>
                    </div>

                    <div class="row mt-1{{ $errors->has('srmdate') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">SRN Date</label>
                        <div class="col-sm-6">
                            {{--{{ Form::date('srmdate',$servicemanagementmodel->srmdate, array('class' => 'form-control form-control-sm', 'min' => $servicemanagementmodel->serviceadate,'onchange'=>'getdeta();','max'=>'2100-01-01')) }}--}}
                            {{ Form::date('srmdate',$servicemanagementmodel->srmdate, array('class' => 'form-control form-control-sm','id'=>'srmdate','min' => $servicemanagementmodel->serviceadate,'max'=>'2100-01-01')) }}
                        </div>
                    </div>

                    <div class="row mt-1{{ $errors->has('actualcontractcompletiondate') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Actual Contract completion
                            Date</label>
                        <div class="col-sm-6">
{{--                            {{ Form::date('actualcontractcompletiondate',$servicemanagementmodel->actualcontractcompletiondate, array('class' => 'form-control form-control-sm','id'=>'actualcontractcompletiondateid','max'=>'2100-01-01')) }}--}}
                            {{ Form::date('actualcontractcompletiondate',$servicemanagementmodel->actualcontractcompletiondate, array('class' => 'form-control form-control-sm','id'=>'actualcontractcompletiondateid','max'=>'2100-01-01')) }}

                        </div>

                    </div>

                    <br>

                    <div class="row mt-1{{ $errors->has('calleremail') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted"></label>
                        <div class="col-sm-6">

                            {{ Form::submit('Save & Close', array('class' => 'btn btn-primary','onclick'=>'return srmandactualcontract();')) }}
                            <a class="btn btn-primary" href="{{url()->previous()}}">Cancel</a>
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
            $('#customertypeid').selectize({
                maxItems: 1
            });

        });
    </script>

    <script>
        function srmandactualcontract() {
            debugger
            if($('#srmdate').val()!="")
            {
                var dateStart = new Date($('#serviceadate').val());
                var dateEnd = new Date($('#srmdate').val());
                if(Date.parse(dateStart) < Date.parse(dateEnd) || Date.parse(dateStart) == Date.parse(dateEnd)){
//                alert('greater and equal ');
                }else{
                    alert('greater and equal to service date ');
                }
            }
            if($('#actualcontractcompletiondateid').val()!="")
            {
                var dateStart = new Date($('#actualcontractcompletiondateid').val());
                var dateEnd = new Date($('#contracttodate').val());
                if (Date.parse(dateStart) > Date.parse(dateEnd) || Date.parse(dateStart) == Date.parse(dateEnd)) {
//                alert('greater and equal ');
                } else {
                    alert('Actual Contract date should  be greater than Contract To Date ');
                    $("#actualcontractcompletiondateid").val('');
                }
            }
        }
    </script>
    @stop