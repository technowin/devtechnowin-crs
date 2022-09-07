@extends('layouts.appnew')
@section('pageTitle', 'Home')
@section('page-css')
    <link href="{{ asset('datatable/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <style>
        head,body{
            font-size: 13px;
        }
    </style>
@stop
@section('content')
{{--    <div class="w3-sidebar" style="display:none; overflow:auto; max-width: 300px; width: 100%;" id="mySidebar">--}}
{{--        <div class="panel panel-default">--}}
{{--            <div class="panel-heading col-md-12">--}}
{{--                <h3 class="panel-title col-md-9">Filter</h3><button onclick="w3_close()" class="w3-button fa fa-close col-md-3"></button>--}}
{{--            </div>--}}
{{--            <div class="panel-body">--}}
{{--                <label for="input" class="col-sm-12 text-muted">Complaint Status</label>--}}
{{--                <div class="col-md-12">--}}
{{--                    {{ Form::select('customercode', $complaintstatuslist,null, array('placeholder' => '--SELECT--','id' => 'complaintstatusid','class' => 'selectize')) }}--}}
{{--                </div>--}}
{{--                <div class="col-md-12">--}}
{{--                    <label for="input" class="col-md-12"><button class="btn btn-primary" id="getDataId" onclick="GetReport();return false;" onmouseup="w3_close()">Get Data</button></label>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div>--}}
{{--        <button class="btn btn-primary btn-sm fa fa-filter" onclick="w3_open()" id="filtericon"  style=" margin-left: 8px;">Filter</button>--}}
{{--    </div>--}}

    <div type="container">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row col-md-12">

                    <table id="example" class="table table-striped table-bordered" cellspacing="0"
                           width="100%">
                        <thead>
                        <tr class="text-muted">
                            <th> Sr No</th>
                            <th>Equipment Sr No</th>
                            <th>Product Sr No</th>
                            <th>Category Name</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @for($k=0;$k<$count;$k++)
                            <tr>
                                <td>{{ $i=$k+1}}</td>
                                <td>{{ $products[$k]->productsrno_accountno }}</td>
                                <td>{{ $products[$k]->productsrno }}</td>
                                <td>{{ $products[$k]->product->productservicename }}</td>
                                @if($products[$k]->assigneestatus == 'PENDING' && $products[$k]->flag_key == '0' )
                                    <td>PENDING</td>
                                @elseif($products[$k]->assigneestatus == 'PENDING' && $products[$k]->flag_key == '1')
                                    <td>RESOLVED</td>
                                @else
                                <td>{{ $products[$k]->complaintstatus }}</td>
                                @endif
                            </tr>
                        @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
    <script src="{{ asset('assets/Selectize/js/standalone/selectize.js') }}"></script>
    <script>
        $(document).ready(function() {
            document.getElementById("mySidebar").style.display = "none";
        });
        function w3_open(){
            document.getElementById("mySidebar").style.display = "block";
        }
        function w3_close() {
            document.getElementById("mySidebar").style.display = "none";
        }
    </script>
@endsection