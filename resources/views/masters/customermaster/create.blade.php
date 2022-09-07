@extends('layouts.appnew')
@section('page-title', '| Add User')
@section('head-css')
    <link href="{{ asset('assets/Selectize/css/selectize.css') }}" rel="stylesheet">
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">Add Customer</div>
        <div class="panel-body">
            <div class="container">
                {{ Form::open(array('url' => 'customers')) }}

                <div class="row{{ $errors->has('customertype') ? ' has-error' : '' }}" style="padding-bottom: 5px;">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Customer Type</label>
                    <div class="col-sm-6">
                        {{ Form::select('customertype', array('' =>'--SELECT--','private' => 'Private','government' => 'Government','individual'=>' Individual'), null, array('required' => 'required','id'=>'customertypeid')) }}
                        @if ($errors->has('customertype'))
                            <span class="help-block"><strong>{{ $errors->first('customertype') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div id="customername", class="row" style="padding-bottom: 5px;">
                    <label for="input" class="col-sm-4 col-form-label text-muted"> Customer Name</label>
                    <div class="col-sm-6">
                        {{ Form::text('customername', '', array('class' => 'form-control form-control-sm','style' => 'enable = false;','required' => 'required')) }}

                    </div>
                </div>

                <div class="row{{ $errors->has('customerphone') ? ' has-error' : '' }}" style="padding-bottom: 5px;">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Customer Phone No</label>
                    <div class="col-sm-6">
                        {{ Form::number('customerphone', '', array('class' => 'form-control form-control-sm','onKeyPress'=>'if(this.value.length==11) return false;')) }}
                        @if ($errors->has('customerphone'))
                            <span class="help-block"><strong>{{ $errors->first('customerphone') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="row{{ $errors->has('emailid') ? ' has-error' : '' }}" style="padding-bottom: 5px;">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Customer Email</label>
                    <div class="col-sm-6">
                        {{ Form::email('emailid', '', array('id'=>'emailid','class' => 'form-control form-control-sm','required' => 'required')) }}
                        @if ($errors->has('contactpersonname'))
                            <span class="help-block"><strong>{{ $errors->first('emailid') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('customerfax') ? ' has-error' : '' }}" style="padding-bottom: 5px;">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Customer Fax</label>
                    <div class="col-sm-6">
                        {{ Form::text('customerfax', '', array('class' => 'form-control form-control-sm','onKeyPress'=>'if(this.value.length==12) return false;')) }}
                        @if ($errors->has('customerfax'))
                            <span class="help-block"><strong>{{ $errors->first('customerfax') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="row{{ $errors->has('customerpanno') ? ' has-error' : '' }}" style="padding-bottom: 5px;">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Customer Pan No</label>
                    <div class="col-sm-6">
                        {{ Form::text('customerpanno', '', array('class' => 'form-control form-control-sm','onKeyPress'=>'if(this.value.length==15) return false;')) }}
                        @if ($errors->has('customerpanno'))
                            <span class="help-block"><strong>{{ $errors->first('customerpanno') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('customergstno') ? ' has-error' : '' }}" style="padding-bottom: 5px;">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Customer GST No</label>
                    <div class="col-sm-6">
                        {{ Form::text('customergstno', '', array('class' => 'form-control form-control-sm','onKeyPress'=>'if(this.value.length==20) return false;')) }}
                        @if ($errors->has('customergstno'))
                            <span class="help-block"><strong>{{ $errors->first('customergstno') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="row{{ $errors->has('customerwebsite') ? ' has-error' : '' }}" style="padding-bottom: 5px;">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Customer Website</label>
                    <div class="col-sm-6">
                        {{ Form::text('customerwebsite', '', array( 'id'=>'customerwebsite','class' => 'form-control form-control-sm','onchange' => 'checkwebsite();')) }}
                        @if ($errors->has('customerwebsite'))
                            <span class="help-block"><strong>{{ $errors->first('customerwebsite') }}</strong></span>
                        @endif
                    </div>
                </div>



                <div class="row{{ $errors->has('contactpersonname') ? ' has-error' : '' }}" style="padding-bottom: 5px;">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Contact Person Name</label>
                    <div class="col-sm-6">
                        {{ Form::text('contactpersonname', '', array('class' => 'form-control form-control-sm')) }}
                        @if ($errors->has('contactpersonname'))
                            <span class="help-block"><strong>{{ $errors->first('contactpersonname') }}</strong></span>
                        @endif
                    </div>
                </div>

                {{--<div class="row{{ $errors->has('contactpersonname') ? ' has-error' : '' }}" style="padding-bottom: 5px;">--}}
                {{--<label for="input" class="col-sm-4 col-form-label text-muted">Contact Person Number</label>--}}
                {{--<div class="col-sm-6">--}}
                {{--{{ Form::number('contactpersonname', '', array('class' => 'form-control form-control-sm','onKeyPress'=>'if(this.value.length==10) return false;')) }}--}}
                {{--@if ($errors->has('contactpersonname'))--}}
                {{--<span class="help-block"><strong>{{ $errors->first('contactpersonname') }}</strong></span>--}}
                {{--@endif--}}
                {{--</div>--}}
                {{--</div>--}}

                <div class="row{{ $errors->has('address') ? ' has-error' : '' }}" style="padding-bottom: 5px;">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Contact Person Address</label>
                    <div class="col-sm-6">
                        {{ Form::textarea('address', '', array('rows'=>'2','class' => 'form-control form-control-sm')) }}
                        @if ($errors->has('address'))
                            <span class="help-block"><strong>{{ $errors->first('address') }}</strong></span>
                        @endif
                    </div>
                </div>

                {{--//Ajay--}}

                <div class="row{{ $errors->has('state') ? ' has-error' : '' }}" style="padding-bottom: 5px;">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Contact Person State</label>
                    <div class="col-sm-6">
                        {{ Form::text('state', '', array('class' => 'form-control form-control-sm')) }}
                        @if ($errors->has('state'))
                            <span class="help-block"><strong>{{ $errors->first('state') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="row{{ $errors->has('statecode') ? ' has-error' : '' }}" style="padding-bottom: 5px;">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Contact Person State Code</label>
                    <div class="col-sm-6">
                        {{ Form::number('statecode', '', array('class' => 'form-control form-control-sm','onKeyPress'=>'if(this.value.length==2) return false;')) }}
                        @if ($errors->has('statecode'))
                            <span class="help-block"><strong>{{ $errors->first('statecode') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="row{{ $errors->has('contactpersondesignation') ? ' has-error' : '' }}" style="padding-bottom: 5px;">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Contact Designation</label>
                    <div class="col-sm-6">
                        {{ Form::text('contactpersondesignation', '', array('rows'=>3,'class' => 'form-control form-control-sm')) }}
                        @if ($errors->has('contactpersondesignation'))
                            <span class="help-block"><strong>{{ $errors->first('contactpersondesignation') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('contactpersondepartment') ? ' has-error' : '' }}" style="padding-bottom: 5px;">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Contact Department</label>
                    <div class="col-sm-6">
                        {{ Form::text('contactpersondepartment', '', array('class' => 'form-control form-control-sm')) }}
                        @if ($errors->has('contactpersondepartment'))
                            <span class="help-block"><strong>{{ $errors->first('contactpersondepartment') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('contactpersonphone') ? ' has-error' : '' }}" style="padding-bottom: 5px;">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Contact Person Phone</label>
                    <div class="col-sm-6">
                        {{ Form::number('contactpersonphone', '', array('class' => 'form-control form-control-sm','onKeyPress'=>'if(this.value.length==11) return false;')) }}
                        @if ($errors->has('contactpersonphone'))
                            <span class="help-block"><strong>{{ $errors->first('contactpersonphone') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('contactpersonmobile') ? ' has-error' : '' }}" style="padding-bottom: 5px;">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Contact Person Mobile</label>
                    <div class="col-sm-6">
                        {{ Form::number('contactpersonmobile', '', array('class' => 'form-control form-control-sm','onKeyPress'=>'if(this.value.length==10) return false;')) }}
                        @if ($errors->has('contactpersonmobile'))
                            <span class="help-block"><strong>{{ $errors->first('contactpersonmobile') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('contactpersonemailid') ? ' has-error' : '' }}" style="padding-bottom: 5px;">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Contact Person Email</label>
                    <div class="col-sm-6">
                        {{ Form::email('contactpersonemailid', '', array('id'=>'contactpersonemailid','class' => 'form-control form-control-sm')) }}
                        @if ($errors->has('contactpersonemailid'))
                            <span class="help-block"><strong>{{ $errors->first('contactpersonemailid') }}</strong></span>
                        @endif
                    </div>
                </div>

                {{--<div class="row{{ $errors->has('customerpanno') ? ' has-error' : '' }}" style="padding-bottom: 5px;">--}}
                {{--<label for="input" class="col-sm-4 col-form-label text-muted">Customer Pan No</label>--}}
                {{--<div class="col-sm-6">--}}
                {{--{{ Form::text('customerpanno', '', array('class' => 'form-control form-control-sm','onKeyPress'=>'if(this.value.length==15) return false;')) }}--}}
                {{--@if ($errors->has('customerpanno'))--}}
                {{--<span class="help-block"><strong>{{ $errors->first('customerpanno') }}</strong></span>--}}
                {{--@endif--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="row{{ $errors->has('customergstno') ? ' has-error' : '' }}" style="padding-bottom: 5px;">--}}
                {{--<label for="input" class="col-sm-4 col-form-label text-muted">Customer GST No</label>--}}
                {{--<div class="col-sm-6">--}}
                {{--{{ Form::text('customergstno', '', array('class' => 'form-control form-control-sm','onKeyPress'=>'if(this.value.length==20) return false;')) }}--}}
                {{--@if ($errors->has('customergstno'))--}}
                {{--<span class="help-block"><strong>{{ $errors->first('customergstno') }}</strong></span>--}}
                {{--@endif--}}
                {{--</div>--}}
                {{--</div>--}}



                <br>

                <div class="row{{ $errors->has('calleremail') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted"></label>
                    <div class="col-sm-6">

                        {{ Form::submit('Save & Close', array('class' => 'btn btn-primary','onclick'=>'return checkEmailandWebsite();')) }}
                        <a class="btn btn-primary" href="{{url()->previous()}}">Cancel</a>
                    </div>
                </div>
                {{ Form::close() }}

            </div>
        </div>
    </div>

@endsection
@endsection

@section('page-script')
    <script src="{{ asset('assets/Selectize/jquery-1.10.2.js') }}"></script>
    <script src="{{ asset('assets/Selectize/js/standalone/selectize.js') }}"></script>
    <script>

        $(document).ready(function () {
            $('#costomercode').selectize({
                maxItems: 1
            });

            $('#customertypeid').selectize({
                maxItems: 1
            });

        });
    </script>
    <script type="text/javascript">

        function checkEmailandWebsite() {
            debugger
            if($('#customertypeid').val()==""||$('#customertypeid').val()=="select")
            {
                alert('Select customer Type');
                return false;
            }
            else if ($('#emailid').val() != "") {
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
                    else if ($('#contactpersonemailid').val() != "") {
                        var email = $('#contactpersonemailid').val();
                        var reEmail = /^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!\.)){0,61}[a-zA-Z0-9]?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!$)){0,61}[a-zA-Z0-9]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/;
                        if (!email.match(reEmail)) {
                            alert('Invalid Contactperson Email Address');
                            $('#contactpersonemailid').focus;
                            return false;
                        }
                        else {
                            return true;
                        }
                    }
                    else {
                        return true;
                    }
                }
                else if ($('#contactpersonemailid').val() != "") {
                    var email = $('#contactpersonemailid').val();
                    var reEmail = /^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!\.)){0,61}[a-zA-Z0-9]?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!$)){0,61}[a-zA-Z0-9]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/;
                    if (!email.match(reEmail)) {
                        alert('Invalid Contactperson Email Address');
                        $('#contactpersonemailid').focus;
                        return false;
                    }
                    else {
                        return true;
                    }
                }
                else {
                    return true;
                }
            }
        }
    </script>

    {{--<script>--}}
    {{--function selectddropdown() {--}}
    {{--debugger--}}
    {{--if($('#customertypeid').val()=="")--}}
    {{--{--}}
    {{--alert('select customer type');--}}
    {{--}--}}
    {{--else {return true;}--}}

    {{--}--}}
    {{--</script>--}}



@stop