@extends('layouts.appnew')

@section('page-title', '| Customer Master')

@section('content')

@section('page-css')
    <link href="{{ asset('datatable/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
@stop

<div class="panel panel-default">
    <div class="panel-body">
        <div class="col-md-12 row">
            {{ Form::open(array('url' => 'prospectivequotationgetreport','files' => true,'id' => 'reportform',)) }}
            <div class="col-md-3">From Date {{Form::date('fromdate',null,array('id'=>'fromdateid','class'=>'form-control form-control-sm','onchange'=>'myfromdate(); return false;'))}} </div>
            <div class="col-md-3">To Date {{Form::date('todate',null,array('id'=>'todateid','class'=>'form-control form-control-sm','onchange'=>'mytodate(); return false;'))}}</div>
            <div class="col-md-3">Organisation Name {{ Form::select('organisationname',$organisationname,null,array('placeholder' => '--SELECT--','id'=>'organisationnameid')) }}</div>
            <div style="padding-top: 15px;padding-left:15px;">{{ Form::submit('Submit', array('class' => 'btn btn-primary')) }} </div>
            {{Form::close()}}
        </div>
    </div>
</div>
        @if($report != null)
            {{--<div class="container">--}}
            <table border="1">
                <tr>
                    <td width="150px;"><b><h4>Organization Name</h4></b> </td>
                    <td style="padding-left:20px;" width="150px;"><b><h4>Quotation Date</h4> </b> </td>
                    <td style="padding-left:50px;"><b><h4>Quotation No</h4> </b> </td>
                    <td style="padding-left:20px;"><b><h4>Products</h4></b> </td>
                    <td style="padding-left:20px;"><b><h4>Category</h4></b> </td>
                    <td style="padding-left:0px;text-align:center;"><b><h4>Qty</h4></b> </td>
                    <td style="text-align:center;"><h4>Amount</h4></td>
                    <td style="text-align:center;"><h4>Configuration</h4></td>

                </tr>
                @foreach($report as $key => $reportlist)
                            <tr>
                                <td>{{$reportlist->customers->customername}}</td>
                                <td style="padding-left:30px;">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$reportlist->quotationdate)->format('Y-m-d') }}</td>
                                <td style="padding-left:10px;">{{$reportlist->quotationno}}</td>

                                <td>
                                    <table border="0">
                                        @foreach($mainreport as $kry => $mainreportlist)
                                            @if($reportlist->quotationno == $mainreportlist->quotationno)
                                                <tr>
                                                    <td style="padding-left:30px;">{{$mainreportlist->products->productservicename}}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </table>
                                </td>
                                <td>
                                    <table border="0">
                                        @foreach($mainreport as $kry => $mainreportlist)
                                            @if($reportlist->quotationno == $mainreportlist->quotationno)
                                                <tr>
                                                    <td style="padding-left:30px;">{{$mainreportlist->category->categoryname}}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </table>
                                </td>
                                <td>
                                    <table style="margin-left:35px;" border="0">
                                        @foreach($mainreport as $kry => $mainreportlist)
                                            @if($reportlist->quotationno == $mainreportlist->quotationno)
                                                <tr>
                                                    <td style="padding-left:0px;">{{$mainreportlist->qty}}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </table>
                                </td>
                                <td>
                                    <table style="margin-left:15px;" border="0">
                                        @foreach($mainreport as $kry => $mainreportlist)
                                            @if($reportlist->quotationno == $mainreportlist->quotationno)
                                                <tr>
                                                    <td style="padding-left:10px;">{{$mainreportlist->rate}}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </table>
                                </td>
                                <td>
                                    <table style="margin-left:15px;" border="0">
                                        @foreach($mainreport as $kry => $mainreportlist)
                                            @if($reportlist->quotationno == $mainreportlist->quotationno)
                                                <tr>
                                                    <td style="padding-left:10px;">{{$mainreportlist->configuration}}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </table>
                                </td>



                            </tr>


                        {{--<div class="panel col-md-12" style="border: silver 1px solid;">--}}
                        {{--<div class="panel-body">--}}
                            {{--<div class="row" style="padding: 3px">--}}
                                {{--<label for="input" class="col-sm-3 col-form-label-sm text-muted">Organization Name</label>--}}
                                {{--<div class="col-sm-6">--}}
                                    {{--{{  $reportlist->customers->customername }}--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="row" style="padding: 3px">--}}
                                {{--<label for="input" class="col-sm-3 col-form-label-sm text-muted">Quotation Date</label>--}}
                                {{--<div class="col-sm-6">--}}
                                    {{--{{  $reportlist->quotationdate }}--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="row" style="padding: 3px">--}}
                                {{--<label for="input" class="col-sm-3 col-form-label-sm text-muted">Organization Address</label>--}}
                                {{--<div class="col-sm-6">--}}
                                    {{--{{  $reportlist->organizationaddress }}--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="row" style="padding: 3px">--}}
                                {{--<label for="input" class="col-sm-3 col-form-label-sm text-muted">Quotation No</label>--}}
                                {{--<div class="col-sm-6">--}}
                                    {{--{{  $reportlist->quotationno }}--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<br>--}}
                            {{--<br>--}}
                            {{--<table>--}}
                                {{--<tr>--}}
                                    {{--<td width="130px;"><b>Product</b></td>--}}
                                    {{--<td width="130px;"><b>Category</b></td>--}}
                                    {{--<td style="padding-left: 15px;" width="230px;"><b>Model No</b></td>--}}
                                    {{--<td width="130px;"><b>Qty</b></td>--}}
                                    {{--<td width="130px;"><b>Amount</b></td>--}}
                                    {{--<td width="700px;"><b>Configuration</b></td>--}}
                                {{--</tr>--}}
                                {{--@foreach($mainreport as $kry => $mainreportlist)--}}
                                    {{--@if($reportlist->quotationno == $mainreportlist->quotationno)--}}
                                        {{--<tr>--}}

                                            {{--<td width="130px;">{{$mainreportlist->products->productservicename}}</td>--}}
                                            {{--<td width="130px;">{{$mainreportlist->categorycode}}</td>--}}
                                            {{--<td style="padding-left: 5px;" width="20px;">{{$mainreportlist->modelno}}</td>--}}
                                            {{--<td width="130px;">{{$mainreportlist->qty}}</td>--}}
                                            {{--<td width="130px;">{{$mainreportlist->total}}</td>--}}
                                            {{--<td width="700px;">{{$mainreportlist->configuration}}</td>--}}
                                        {{--</tr>--}}
                                        {{--@endif--}}
                                {{--@endforeach--}}
                            {{--</table>--}}
                        {{--</div>--}}
                        {{--<br>--}}
                    {{--</div>--}}
                    <br>
                @endforeach
            </table>
            {{--</div>--}}
            <br>
            {{ Form::open(array('url' => 'prospectivequotationgetreportpdf','files' => true)) }}

            {{Form::hidden('hdfromdate',$fromdate,array('id'=>'hdfromdateid'))}}
            {{Form::hidden('hdtodate',$todate,array('id'=>'hdtodateid'))}}
            @if($customername != null)
                {{Form::hidden('hdorganisationname',$customername,array('id'=>'hdtodateid'))}}
            @else
                {{Form::hidden('hdorganisationname',null,array('id'=>'hdtodateid'))}}
            @endif
            {{ Form::submit('PDF', array('class' => 'btn btn-primary')) }}
            {{Form::close()}}
        @endif

@stop
@section('page-script')
    <script>
        $(document).ready(function () {
            $('#organisationnameid').selectize({
                maxItems: 1
            });
        })
    </script>

    <script>
        $("#reportform").submit(function (e) {
            if($('#fromdateid').val() !="" && $('#todateid').val() !="" || $('#organisationnameid').val() != "")
            {
                return true;
            }
            else {
                alert('Please select field ');
                return false;
            }
        });
    </script>
@stop
