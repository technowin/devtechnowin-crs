@extends('layouts.appnew')

@section('page-title', '| Customers')

@section('content')

    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"> Supply Management</h3>
            </div>
            <div class="panel-body">
                <div class="container">
                    {{ Form::open(array('url'=>'supplymanagementupdate'.$supplymanagementModel->id, 'files' =>true )) }}

                    {{ Form::hidden('contracttodate',$contracttodate= $supplymanagementModel->contracttodate, array('id' => 'contracttodateid')) }}
                    <div class="row mt-1{{ $errors->has('contractno') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Contract No</label>
                        <div class="col-sm-6">
                            {{ Form::text('contractno',$supplymanagementModel->contractno, array('class' => 'form-control','readonly' => 'true')) }}
                        </div>
                    </div>

                    <div class="row mt-1{{ $errors->has('customercode') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Customer Name</label>
                        <div class="col-sm-6">
                            {{ Form::text('customercode',$supplymanagementModel->customername, array('class' => 'form-control','readonly'=>'true')) }}
                        </div>
                    </div>

                    <div class="row mt-1{{ $errors->has('installationdate') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Installation date</label>
                        <div class="col-sm-6">
                            @if($supplymanagementModel->installationdate == null)
                                {{ Form::date('installationdate',$supplymanagementModel->installationdate, array('class' => 'form-control form-control-sm','max'=>'2100-01-01')) }}
                            @else
                                {{ Form::date('installationdate',$supplymanagementModel->installationdate, array('class' => 'form-control form-control-sm','readonly' => 'true','max'=>'2100-01-01')) }}
                            @endif

                        </div>
                    </div>

                    <div class="row mt-1{{ $errors->has('inspectiondate') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Inspection Date</label>
                        <div class="col-sm-6">
                            @if($supplymanagementModel->inspectiondate == null)
                                {{ Form::date('inspectiondate',$supplymanagementModel->inspectiondate, array('class' => 'form-control form-control-sm','min'=>$supplymanagementModel->installationdate,'max'=>'2100-01-01')) }}
                            @else
                                {{ Form::date('inspectiondate',$supplymanagementModel->inspectiondate, array('class' => 'form-control form-control-sm','readonly' => 'true','max'=>'2100-01-01')) }}
                            @endif
                        </div>
                    </div>

                    <div class="row mt-1{{ $errors->has('preventivemaintenancedate') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Preventive maintenance Date</label>
                        <div class="col-sm-6">
                            @if($supplymanagementModel->installationdate!=null)

                                @if($supplymanagementModel->preventivemaintenancedate==null)
                                    {{ Form::date('preventivemaintenancedate',$supplymanagementModel->preventivemaintenancedate, array('id'=>'preventivemaintenancedateid','class' => 'form-control form-control-sm','min'=>$supplymanagementModel->installationdate,'max'=>'2100-01-01')) }}
                                @else
                                    {{ Form::date('preventivemaintenancedate',$supplymanagementModel->preventivemaintenancedate, array('id'=>'preventivemaintenancedateid','class' => 'form-control form-control-sm','readonly'=>'true','max'=>'2100-01-01')) }}
                                @endif
                            @else
                                {{ Form::date('preventivemaintenancedate',$supplymanagementModel->preventivemaintenancedate, array('id'=>'preventivemaintenancedateid','class' => 'form-control form-control-sm','readonly'=>'true','max'=>'2100-01-01')) }}
                            @endif
                        </div>
                    </div>

                    <div class="row mt-1{{ $errors->has('preventivemaintenancereminderdate') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Preventive maintenance reminder date</label>
                        <div class="col-sm-6">
                            @if($supplymanagementModel->installationdate!=null && $supplymanagementModel->preventivemaintenancereminderdate==null )
                                {{ Form::date('preventivemaintenancereminderdate',$supplymanagementModel->preventivemaintenancereminderdate, array('class' => 'form-control form-control-sm','max'=>'2100-01-01')) }}
                            @else
                                {{ Form::date('preventivemaintenancereminderdate',$supplymanagementModel->preventivemaintenancereminderdate, array('class' => 'form-control form-control-sm','readonly'=>'true','max'=>'2100-01-01')) }}
                            @endif
                        </div>
                    </div>

                    <div class="row mt-1{{ $errors->has('preventivemaintenancecertificatedate') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Preventive maintenance certificate date</label>
                        <div class="col-sm-6">
                            @if($supplymanagementModel->preventivemaintenancedate==null)
                                {{ Form::date('preventivemaintenancecertificatedate',$supplymanagementModel->preventivemaintenancecertificatedate, array('class' => 'form-control form-control-sm','min'=>$supplymanagementModel->preventivemaintenancedate,'readonly'=>'true','max'=>'2100-01-01')) }}
                            @else
                                {{ Form::date('preventivemaintenancecertificatedate',$supplymanagementModel->preventivemaintenancecertificatedate, array('id'=>'preventivemaintenancecertificatedate','class' => 'form-control form-control-sm','min'=>$supplymanagementModel->preventivemaintenancedate,'max'=>'2100-01-01')) }}
{{--                                {{ Form::date('preventivemaintenancecertificatedate',$supplymanagementModel->preventivemaintenancecertificatedate, array('id'=>'preventivemaintenancecertificatedateid','class' => 'form-control form-control-sm','onchange'=>'getdeta();')) }}--}}
                            @endif
                        </div>
                    </div>

                    <div class="row mt-1{{ $errors->has('actualcontractcompletiondate') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Actual Contract completion Date</label>
                        <div class="col-sm-6">

                            @if($supplymanagementModel->installationdate==null)
                                {{ Form::date('actualcontractcompletiondate',$supplymanagementModel-> actualcontractcompletiondate, array('onchange' => 'getcallclosuredate(); return false;','class' => 'form-control form-control-sm','readonly'=>'true','max'=>'2100-01-01')) }}
                            @else
                                {{ Form::date('actualcontractcompletiondate',$supplymanagementModel-> actualcontractcompletiondate, array('onchange' => 'getcallclosuredate(); return false;','class' => 'form-control', 'id'=>'actualcontractcompletiondateid','max'=>'2100-01-01')) }}
                            @endif
                        </div>
                    </div>
                    <br>
                    <div class="row mt-1{{ $errors->has('calleremail') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted"></label>
                        <div class="col-sm-6">
                            {{ Form::submit('Save & Close', array('class' => 'btn btn-primary')) }}
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
        document.getElementById("preventivemaintenancecertificatedate").onblur = function() {
            debugger
            var dateStart = new Date($('#preventivemaintenancedateid').val());
            var dateEnd = new Date($('#preventivemaintenancecertificatedate').val());
            if(Date.parse(dateStart) < Date.parse(dateEnd) || Date.parse(dateStart) == Date.parse(dateEnd)){
//                alert('greater and equal ');
            }else{
                alert('greater and equal to Preventive maintenance Date');
            }

        };
    </script>

    <script type="text/javascript">


        function getcallclosuredate() {
            document.getElementById("actualcontractcompletiondateid").onblur = function () {
                debugger
                var dateStart = new Date($('#actualcontractcompletiondateid').val());
                var dateEnd = new Date($('#contracttodateid').val());
                if (Date.parse(dateStart) > Date.parse(dateEnd) || Date.parse(dateStart) == Date.parse(dateEnd)) {
//                alert('greater and equal ');
                } else {
                    alert('Actual Contract date should  be greater than Contract To Date ');
                    $("#actualcontractcompletiondateid").val('');
                }
            };
        }
    //        function getcallclosuredate() {
//            debugger
//                if ($("#actualcontractcompletiondateid").val() != "") {
//                    if ($("#actualcontractcompletiondateid").val() <= $("#contracttodateid").val()) {
//                        alert('Actual Contract date should  be greater than Contract To Date');
//                        $("#actualcontractcompletiondateid").val('');
//                    }
//                }
//        }

        function getdeta() {

            if ($("#preventivemaintenancecertificatedateid").val() != "") {
                if ($("#preventivemaintenancedateid").val()  >= $("#preventivemaintenancecertificatedateid").val()) {
                    alert('Preventive Maintenance Certificate Date  should  be greater Than Preventive Maintenance Date');
                    $("#preventivemaintenancecertificatedateid").val('');
                }
            }
        }

    </script>

@stop