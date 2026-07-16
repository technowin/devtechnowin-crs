@extends('layouts.app')

@section('page-title', '| Add User')

@section('content')
    <div class="card">
        <div class="card-block">
            <div class="col-md-12 row">
                <div class="col-md-6"><h6 class="card-subtitle text-muted mt-2">Bid Details</h6></div>

                <div class="col-md-2">

                </div>
                <div class="col-md-2">

                </div>
                <div class="col-md-2">
                    <a class="btn btn-outline-secondary" href="{{ route('sectors.create') }}" style="color:gray;"> <b>
                            </b> </a>
                </div>

            </div>

        </div>
    </div>

    <div class="card mt-2 table-responsive">
        <div class="card-block">
            <div class="col-md-12 row">
                <table class="table table-sm table-hover">
                    <thead>
                    <tr class="text-muted">
                        <th>#</th>
                        <th>tenderid</th>
                        <th>nameofbidder</th>
                        <th>bidamount</th>
                        <th>created_at</th>
                        <th>updated_at</th>
                        <th>action</th>
                    </tr>
                    </thead>
                    {{--<tbody>--}}
                    {{--@foreach($sectorMaster as $key => $sectorMaster)--}}
                        {{--<tr>--}}
                            {{--<th scope="row">{{$key+1}}</th>--}}
                            {{--<td>{{ $sectorMaster->sectorcode }}</td>--}}
                            {{--<td>{{ $sectorMaster->sectorname }}</td>--}}
                            {{--<td>{{ $sectorMaster->sectordescription }}</td>--}}
                            {{--<td>{{ $sectorMaster->isactive }}</td>--}}
                            {{--<td>{{ is_null($sectorMaster->created_at) ? '' : $sectorMaster->created_at->format('m-d-Y') }}</td>--}}
                            {{--<td>{{ is_null($sectorMaster->updated_at) ? '' : $sectorMaster->updated_at->format('m-d-Y') }}</td>--}}
                            {{--<td>--}}
                                {{--<a href="{{ route('sectors.show', $sectorMaster->sectorcode) }}" style="margin-right: 3px;">View</a>--}}
                                {{--<a href="{{ route('sectors.edit', $sectorMaster->sectorcode) }}" style="margin-right: 3px;">edit</a> |--}}
                            {{--</td>--}}
                        {{--</tr>--}}
                    {{--@endforeach--}}
                    {{--</tbody>--}}
                </table>

            </div>
        </div>
    </div>
@endsection