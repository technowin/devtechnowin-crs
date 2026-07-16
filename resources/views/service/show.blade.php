@extends('layouts.appnew')

@section('page-title', '| Branch Master')

@section('content')

    @if($equipmentnull == null)
        <h3>There is no equipment to view</h3>
    @else
        <div type="container">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row col-md-12">

                        <table id="example" class="table table-striped table-bordered" cellspacing="0"
                               width="100%">
                            <thead>
                            <tr class="text-muted">
                                {{--<th>#</th>--}}
                                <th> Sr No</th>
                                <th>Product Sr No</th>
                                <th>Equipment Sr No</th>
                                <th>Product Sr Name</th>
                                <th>Category Name</th>
                                <th>Branch Name</th>
                                <th>Specification</th>
                            </tr>
                            </thead>
                            <tbody>
                            {{--                                    @foreach($equipment as $equip)--}}
                            {{--                                        <tr>--}}
                            {{--                                            --}}{{--<th scope="row">{{$key+1}}</th>--}}
                            {{--                                            <td>{{ $equip->equipmentsrno }}</td>--}}
                            {{--                                            <td>{{ $equip->equipmentsrno }}</td>--}}
                            {{--                                            <td>{{ $equip->products->productservicename }}</td>--}}
                            {{--                                            <td>{{ $equip->category->categoryname }}</td>--}}
                            {{--                                            <td>{{ $equip->branch->branchname }}</td>--}}
                            {{--                                            <td>{{ $equip->specification }}</td>--}}
                            {{--                                        </tr>--}}
                            {{--                                    @endforeach --}}

                            {{--                                    @foreach($equipment as $equip)--}}
                            @for($k=0;$k<$count;$k++)
                                <tr>
                                    {{--<th scope="row">{{$key+1}}</th>--}}
                                    <td>{{ $i=$k+1}}</td>
                                    <td>{{ $equipment[$k]->equipmentsrno }}</td>
                                    <td>{{ $equipment[$k]->productsrno }}</td>
                                    <td>{{ $equipment[$k]->products->productservicename }}</td>
                                    <td>{{ $equipment[$k]->category->categoryname }}</td>
                                    <td>{{ $equipment[$k]->branch->branchname }}</td>
                                    <td>{{ $equipment[$k]->specification }}</td>
                                </tr>
                            @endfor
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
