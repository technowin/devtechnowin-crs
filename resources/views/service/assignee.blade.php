@extends('layouts.appnew')
@section('page-title', '| Branch Master')
@section('page-css')
    <link type="text/css" rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css"/>
@stop
@section('content')

    @if($equipmentnull == null)
        <h3>There is no equipment to assign</h3>
        <br>
        <a class="btn btn-default" href="{{url()->previous()}}">Back</a>
    @else
        <div id="treeview-checkbox-demo">
            <ul>
                @foreach($branches as $branchdata)
                    <li value="{{ $branchdata->branchcode }}">{{ $branchdata->branchname }}
                        <ul>
                            @foreach($productnames as $products)
                                @foreach($equipmentforlooping as $equipmetsrno)
                                    @if($equipmetsrno->productservicecode == $products->productservicecode && $equipmetsrno->branchcode == $branchdata->branchcode)
                                        <li value="{{ $products->productservicename }}">{{ $products->productservicename }}
                                            <ul>
                                                @foreach($equipment as $srnos)
                                                    @if($srnos->branchcode == $branchdata->branchcode && $srnos->productservicecode == $products->productservicecode)
                                                        <li data-value="{{ $srnos->equipmentsrno }}">{{ $srnos->equipmentsrno }}</li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endif
                                @endforeach
                            @endforeach

                        </ul>
                    </li>
                @endforeach
            </ul>
            <br>
            <input type="hidden" id="contractno" value="{{$equipment[0]->contractno}}">
            <input type="hidden" id="serviceId" value="{{$serviceId}}">
            <br>
            <button type="button" class="btn btn-success" id="show-values">Submit</button>
            <a class="btn btn-success" href="{{url()->previous()}}">Cancel</a>
        </div>
    @endif


    <br>

    <br>


@endsection
@section('page-script')
    {{--<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>--}}
    {{--<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js"></script>--}}
    <script src="https://www.jquery-az.com/jquery/js/jquery-treeview/logger.js"></script>
    <script src="https://www.jquery-az.com/jquery/js/jquery-treeview/treeview.js"></script>
    <script>
        $('#treeview-checkbox-demo').treeview({
            debug: true,
            data: ['links', 'Do WHile loop']
        });
        $('#show-values').on('click', function () {
            $.ajax({
                url: '{{ url('/getcheckpostedvalues/{data}') }}/',
                type: "GET",
                dataType: "json",
                data: {
                    checkvalues: $('#treeview-checkbox-demo').treeview('selectedValues'),
                    contractno : $('#contractno').val(),
                    serviceId : $('#serviceId').val(),
                },
                success: function (data) {
                    window.location.href = '{{URL::to('registration/assigncomplaint')}}/' + data + '/' + $('#serviceId').val();
                }
            });

        });
    </script>
@stop
