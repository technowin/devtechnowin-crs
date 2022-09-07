@extends('layouts.appnew')

@section('page-title', '| Customers')

@section('content')

    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Edit Work Order Customer</h3>
            </div>
            <div class="panel-body">
                <div class="container">
                    {{ Form::model($customers, array('route' => array('customers.update', $customers->customercode), 'method' => 'PUT')) }}

                    {{ Form::hidden('workorderno', $customers->workorderno, array('id' => 'workorderno')) }}
                    {{ Form::hidden('customercode', $customers->customercode, array('id' => 'customercode')) }}

                    <div class="row mt-1{{ $errors->has('customertype') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Customer Type</label>
                        <div class="col-sm-6">
                            {{ Form::select('customertype', array('select' =>'--SELECT--','private' => 'Private','government' => 'Government','individual'=>' Individual'), null ,array('id'=>'customertypeid')) }}
                        </div>

                    </div>

                    <div class="row mt-1{{ $errors->has('customername') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Customer Name</label>
                        <div class="col-sm-6">
                            {{ Form::text('customername', null, array('class' => 'form-control form-control-sm')) }}
                        </div>
                    </div>
                    <div class="row mt-1{{ $errors->has('customerphone') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Customer Phone No</label>
                        <div class="col-sm-6">
                            {{ Form::number('customerphone', null, array('class' => 'form-control form-control-sm','onKeyPress'=>'if(this.value.length==11) return false;')) }}
                        </div>

                    </div>
                    <div class="row mt-1{{ $errors->has('emailid') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Customer Email</label>
                        <div class="col-sm-6">
                            {{ Form::email('emailid', null, array('id'=>'emailid','class' => 'form-control form-control-sm','required' => 'required')) }}
                        </div>

                    </div>
                    <div class="row mt-1{{ $errors->has('customerfax') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Customer Fax</label>
                        <div class="col-sm-6">
                            {{ Form::text('customerfax', null, array('class' => 'form-control form-control-sm')) }}
                        </div>
                    </div>

                    <div class="row mt-1{{ $errors->has('customerpanno') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Contact Pan No</label>
                        <div class="col-sm-6">
                            {{ Form::text('customerpanno', null, array('class' => 'form-control form-control-sm','onKeyPress'=>'if(this.value.length==10) return false;')) }}
                        </div>

                    </div>
                    <div class="row mt-1{{ $errors->has('customergstno') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Customer GST No</label>
                        <div class="col-sm-6">
                            {{ Form::text('customergstno', null, array('class' => 'form-control form-control-sm','onKeyPress'=>'if(this.value.length==15) return false;')) }}
                        </div>
                    </div>

                    <div class="row mt-1{{ $errors->has('customerwebsite') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Customer Website</label>
                        <div class="col-sm-6">
                            {{ Form::text('customerwebsite', null, array('id'=>'customerwebsite', 'class' => 'form-control form-control-sm','onchange'=>'checkwebsite();')) }}
                        </div>

                    </div>
                    <div class="row mt-1{{ $errors->has('contactpersondesignation') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Contact Person Name</label>
                        <div class="col-sm-6">
                            {{ Form::text('contactpersonname', null, array('rows'=>3,'class' => 'form-control form-control-sm')) }}
                        </div>
                    </div>
                    <div class="row mt-1{{ $errors->has('contactpersondesignation') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Customer Person Designation</label>
                        <div class="col-sm-6">
                            {{ Form::text('contactpersondesignation', null, array('rows'=>3,'class' => 'form-control form-control-sm')) }}
                        </div>
                    </div>

                    <div class="row mt-1{{ $errors->has('contactpersondesignation') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Contact Person Address</label>
                        <div class="col-sm-6">
                            {{ Form::textarea('address', null, array('rows'=>3,'class' => 'form-control form-control-sm')) }}
                        </div>
                    </div>

                    <div class="row mt-1{{ $errors->has('state') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Contact Person State</label>
                        <div class="col-sm-6">
                            {{ Form::text('state', null, array('rows'=>3,'class' => 'form-control form-control-sm')) }}
                        </div>
                    </div>

                    <div class="row mt-1{{ $errors->has('statecode') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Contact Person State Code</label>
                        <div class="col-sm-6">
                            {{ Form::number('statecode', null, array('class' => 'form-control form-control-sm','onKeyPress'=>'if(this.value.length==2) return false;')) }}
                        </div>
                    </div>



                    <div class="row mt-1{{ $errors->has('contactpersondepartment') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Customer Department</label>
                        <div class="col-sm-6">
                            {{ Form::text('contactpersondepartment', null, array('rows'=>3,'class' => 'form-control form-control-sm')) }}
                        </div>

                    </div>
                    <div class="row mt-1{{ $errors->has('contactpersonphone') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Contact Person Phone</label>
                        <div class="col-sm-6">
                            {{ Form::number('contactpersonphone', null, array('class' => 'form-control form-control-sm','onKeyPress'=>'if(this.value.length==11) return false;')) }}
                        </div>

                    </div>
                    <div class="row mt-1{{ $errors->has('contactpersonmobile') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Contact Person Mobile</label>
                        <div class="col-sm-6">
                            {{ Form::number('contactpersonmobile', null, array('class' => 'form-control form-control-sm','onKeyPress'=>'if(this.value.length==10) return false;')) }}
                        </div>

                    </div>
                    <div class="row mt-1{{ $errors->has('contactpersonemailid') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Contact Person Email</label>
                        <div class="col-sm-6">
                            {{ Form::email('contactpersonemailid', null, array('id'=>'contactpersonemailid','class' => 'form-control form-control-sm')) }}
                        </div>
                    </div>

                    {{--<div class="row mt-1{{ $errors->has('customerpanno') ? ' has-error' : '' }}">--}}
                        {{--<label for="input" class="col-sm-4 col-form-label text-muted">Contact Pan No</label>--}}
                        {{--<div class="col-sm-6">--}}
                            {{--{{ Form::text('customerpanno', null, array('class' => 'form-control form-control-sm','onKeyPress'=>'if(this.value.length==10) return false;')) }}--}}
                        {{--</div>--}}

                    {{--</div>--}}
                    {{--<div class="row mt-1{{ $errors->has('customergstno') ? ' has-error' : '' }}">--}}
                        {{--<label for="input" class="col-sm-4 col-form-label text-muted">Customer GST No</label>--}}
                        {{--<div class="col-sm-6">--}}
                            {{--{{ Form::text('customergstno', null, array('class' => 'form-control form-control-sm','onKeyPress'=>'if(this.value.length==15) return false;')) }}--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    <br>

                    <div class="row mt-1{{ $errors->has('calleremail') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted"></label>
                        <div class="col-sm-6">
                            {{ Form::submit('Save & Close', array('class' => 'btn btn-primary','onclick'=>'return checkEmailandWebsite();')) }}
                            {{--{{ Form::submit('Save & Close', array('class' => 'btn btn-primary','onclick'=>'checkEmail();')) }}--}}
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

    <script type="text/javascript">

        function checkEmailandWebsite() {

            if($('#customertypeid').val()=="" || $('#customertypeid').val()=="select")
            {
                alert('Select customer Type');
                return false;
            }
           else if($('#emailid').val() !="" ) {
                var email = $('#emailid').val();
                var reEmail = /^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!\.)){0,61}[a-zA-Z0-9]?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!$)){0,61}[a-zA-Z0-9]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/;
                if (!email.match(reEmail)) {
                    alert('Invalid Customer Email Address');
                    $('#emailid').focus;
                    return false;
                }
                else if ($('#customerwebsite').val() != "") {
                    var customerwebsite = $('#customerwebsite').val();
                    var recustomerwebsite = /^(http[s]?:\/\/){0,1}(www\.){0,1}[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,5}[\.]{0,1}/;
                    if (!customerwebsite.match(recustomerwebsite)) {
                        alert('Invalid Customer Website Name');
                        $('#customerwebsite').focus;
                        return false;
                    }
                    else if($('#contactpersonemailid').val() != "")
                    {
                        var email = $('#contactpersonemailid').val();
                        var reEmail = /^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!\.)){0,61}[a-zA-Z0-9]?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!$)){0,61}[a-zA-Z0-9]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/;
                        if (!email.match(reEmail)) {
                            alert('Invalid Contactperson Email Address');
                            $('#contactpersonemailid').focus;
                            return false;
                        }
                        else {return true;}
                    }
                    else {return true;}
                }
                else if($('#contactpersonemailid').val() != "")
                {
                    var email = $('#contactpersonemailid').val();
                    var reEmail = /^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!\.)){0,61}[a-zA-Z0-9]?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!$)){0,61}[a-zA-Z0-9]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/;
                    if (!email.match(reEmail)) {
                        alert('Invalid Contact person Email Address');
                        $('#contactpersonemailid').focus;
                        return false;
                    }
                    else {return true;}
                }
                else {return true;}
            }
        }
    </script>





@stop