@extends('layouts.appnew')

@section('page-title', '| Customer Master')

@section('content')

@section('page-css')
    <link href="{{ asset('datatable/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <style>
        /*th, td {*/
        /*    white-space: nowrap;*/
        /*}*/
        #wot{
            width: 130px;
        }
        #cn{
            width: 120px;
        }
    </style>

@stop

<div class="panel panel-default">
    <div class="panel-body">
        <div class="col-md-12 row">
            <div class="col-md-10"><h6>Contracts</h6></div>
            <div class="col-md-2">
                {{--<a class="btn btn-blue" data-toggle="modal" data-target=".bs-example-modal-lg"> <b>Add New Contract</b></a>--}}
                <a class="btn btn-outline-secondary" href="{{ URL::to('/addnewcontract') }}" style="color:gray;">
                    <b>Add New Contract</b> </a>
            </div>
        </div>
    </div>
</div>

@if (session('flash_message'))
    <div class="alert alert-success">
        {{ session('flash_message') }}
    </div>
@endif

<div class="panel panel-default">
    <div class="panel-body table-responsive">
        <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
            <tr class="text-muted">
                {{--<th>#</th>--}}
                <th id="cn">Contract No</th>
                <th>Customer Name</th>
                <th>Tender No/Quotation No</th>
                <th id="wot">Work Order Type</th>
                <th>Work Order No/PO No</th>
                <th>Contract From Date</th>
                <th>Contract To Date</th>
                <th>Closure Date</th>
                <th>Created Date</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($contracts as $key => $contract)
                <tr>
                    {{--<th scope="row">{{$key+1}}</th>--}}
                    <td id="cn">{{ $contract->contractno }}</td>
                    <td>{{ $contract->customername }}</td>

                    {{--                    <td>{{ $contract->branchname }}</td>--}}
                    <td>{{ $contract->tenderno }}</td>
                    <td id="wot">{{ $contract->workordertype }}</td>
                    @if($contract->workorderno != null)
                    <td>{{ $contract->workorderno }}</td>
                    @else
                    <td>{{ $contract->purchaseorderno }}</td>
                    @endif
                    <td>{{ $contract->contractfromdate }}</td>
                    <td>{{ $contract->contracttodate }}</td>
                    <td>{{ $contract->closuredate }}</td>

                    <td>{{ $contract->created_at }}</td>
                    <td>
                        <a href="{{ URL::to('showcontract',array($contract->contractno))}}">view</a>
                        @if($contract->closuredate == null)
                            |
                        <a href="{{ URL::to('editcontract',array($contract->contractno))}}">edit</a>
                        @endif
                        @if($contract->contracttodate <= \Carbon\Carbon::now() && ($contract->workordertype == 'AMC' || $contract->workordertype == 'Hardware AMC' || $contract->workordertype == 'Warranty') && $contract->closuredate == null)
                            <a href="{{ URL::to('amendcontract',array('id'=>$contract->contractno, 'customername' =>$contract->customername ))}}">amend</a>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{--{{ $contracts->links() }}--}}
    </div>
</div>
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
            </div>

            <div class="modal-body">
                <p>You are about to delete one track, this procedure is irreversible.</p>
                <p>Do you want to proceed?</p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>

@endsection
@section('page-script')
    <script src="{{asset('datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('datatable/js/dataTables.bootstrap.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            var table = $('#example').DataTable({
                 "order": [[ 7, "asc" ],[ 8, "desc"]],
                // "orderable" : false
                'columnDefs': [ {
                 'targets': [7,8], /* column index */
                 'visible': false,
                 'searchable': false,/* true or false */
            }]
            });
        });

    </script>


@stop
