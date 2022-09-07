@extends('layouts.appnew')

@section('page-title', '| Branch Master')

@section('content')

    @if($show == null)
        <h3>There is no equipment to  view</h3>
        @else
        <div type="container">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row col-md-12">

                        <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr class="text-muted">
                                {{--<th>#</th>--}}
                                <th>Product Sr No</th>
                                <th>Product Sr Name</th>
                                <th>Caegory Name</th>
                                <th>Specification</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($show as $showeq)
                                <tr>
                                    {{--<th scope="row">{{$key+1}}</th>--}}
                                    <td>{{ $showeq->equipmentsrno }}</td>
                                    <td>{{ $showeq->products->productservicename }}</td>
                                    <td>{{ $showeq->category->categoryname }}</td>
                                    <td>{{ $showeq->specification }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    @endif
    <br>
    <a class="btn btn-default" href="{{url()->previous()}}">Back</a>




@endsection