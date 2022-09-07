@extends('layouts.appnew')

@section('page-title', '| Customer Master')

@section('content')

@section('page-css')
    <link href="{{ asset('datatable/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
@stop

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-md-12 row">
                <div class="col-md-10"><h6>Customer Master</h6></div>
                <div class="col-md-2">
                    {{--<a class="btn btn-blue" data-toggle="modal" data-target=".bs-example-modal-lg"><b>Add New--}}
                    {{--Customer</b></a>--}}
                    <a class="btn btn-blue" href="{{ route('customers.create') }}"> <b>Add
                            New Customer</b> </a>
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
                    {{--<th>Customer Code</th>--}}
                    {{--<th>Customer Type</th>--}}
                    <th>Customer Name</th>
                    <th>Email ID</th>
                    <th>Customer Phone</th>
                    <th>Contact Person Name</th>
                    <th>Contact Person Phone</th>

                    {{--<th>created_at</th>--}}
                    {{--<th>updated_at</th>--}}
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($customers as $key => $customer)
                    <tr>
                        {{--<th scope="row">{{$key+1}}</th>--}}
                        {{--<td>{{ $customer->customercode }}</td>--}}
                        {{--<td>{{ $customer->customertype }}</td>--}}
                        <td>{{ $customer->customername }}</td>
                        <td>{{ $customer->emailid }}</td>
                        <td>{{ $customer->customerphone }}</td>
                        <td>{{ $customer->contactpersonname }}</td>
                        <td>{{ $customer->contactpersonphone }}</td>

                        {{--<td>{{ is_null($customer->created_at) ? '' : $customer->created_at->format('m-d-Y') }}</td>--}}
                        {{--<td>{{ is_null($customer->updated_at) ? '' : $customer->updated_at->format('m-d-Y') }}</td>--}}
                        <td>
                            <a href="{{ route('customers.show', ['id' => $customer->customercode]) }}">view</a> |
                            <a href="{{ route('customers.edit', ['id' => $customer->customercode]) }}">edit</a>
                            {{--<a href="{{ URL::to('deletecustomer',array($customer->customercode))}}">delete</a>--}}
                            {{--<a href="#" data-href="{{ route('customers.destroy', ['id' => $customer->customercode]) }}"--}}
                               {{--data-toggle="modal" data-target="#confirm-delete">delete</a>--}}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{--{{ $customers->links() }}--}}
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
            $('#example').DataTable( {
                "ordering": false,
                "language": { "processing": "<div class='overlay custom-loader-background'><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i></div>" },
            } );
        });

    </script>
    <script type="text/javascript">
        $('#confirm-delete').on('show.bs.modal', function (e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#costomercode').selectize({
                maxItems: 1
            });
            $("#costomercode").change(function () {
                if ($('#costomercode').val() != "") {
                    $("#customername").hide();
                }
                else {
                    $("#customername").show();
                }
            });
        });
    </script>

@stop
