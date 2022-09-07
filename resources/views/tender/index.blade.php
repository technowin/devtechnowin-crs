@extends('layouts.appnew')

@section('pageTitle', 'Complaints')

@section('page-css')
    <link href="{{ asset('datatable/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.bootstrap.min.css">
@stop

@section('content')

    <div class="panel with-nav-tabs panel-default">
        <div class="panel-heading" style="padding-left: 1150px;"> <a class="btn btn-outline-secondary" href="{{ URL::to('tender/newregistration') }}" style="color:gray; float: right"> <b>Add
                    New Tender</b> </a>
        </div>
        <div class="panel-heading">
            <ul class="nav nav-tabs">
                <li class="active"><a class="pagehead-tabs-item selected" data-toggle="tab" href="#currentactivetenders" role="tab">Active Tenders</a></li>
                <li><a class="pagehead-tabs-item selected" data-toggle="tab" href="#expiredtenderstenders" role="tab">Expired Tenders</a></li>
                <li><a class="pagehead-tabs-item selected" data-toggle="tab" href="#prospectivetenders" role="tab">Prospective Tenders</a></li>
                <li><a class="pagehead-tabs-item selected" data-toggle="tab" href="#emdnotcollecttenders" role="tab">EMD Not Collect</a></li>
                <li><a class="pagehead-tabs-item selected" data-toggle="tab" href="#emdcollecttenders" role="tab">EMD Collect</a></li>
                <li><a class="pagehead-tabs-item selected" data-toggle="tab" href="#alltenders" role="tab">All Tenders</a></li>
            </ul>
        </div>

        <div class="panel-body">
            <div class="tab-content">
                <div class="tab-pane fade in active" id="currentactivetenders">
                    <table id="currentactivetenderstableid" class="table table-sm table-hover" cellspacing="0"
                           width="100%">
                        <thead>
                        <tr class="text-muted">
                            <th></th>
                            <th>Tender No</th>
                            <th>Emd Status</th>
                            <th>Tender Date</th>
                            <th>Organisation</th>
                            <th>Department</th>
                            <th>Bid To Be Submited</th>
                            <th>MS/ME</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($customers as $key => $customer)
                            <tr class="data-row">
                                <td></td>
                                <td class="align-middle name">{{ $customer->tenderno }}</td>
                                <td>{{ $customer->emdstatus }}</td>
                                {{--<td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$customer->tenderdate )->format('Y-m-d') }}</td>--}}
                                <td>{{ $customer->tenderdate }}</td>
                                <td>{{ $customer->organisationname }}</td>
                                <td>{{ $customer->department }}</td>
                                <td>{{ $customer->bidtobesubmited }}</td>
                                <td>{{ $customer->ms_me }}</td>

                                <td>
                                    <a  href="{{ URL::to('tender/viewtenderregistration',array($customer->id))}}">view</a>
                                    |
                                    <a  href="{{ URL::to('tender/editregistration',array($customer->id))}}">edit</a> |

                                    @if($customer->flagkey == null)
                                        <a href="{{ URL::to('tender/tenderbidderview',array($customer->id))}}">Add bids</a>
                                    @else
                                        <a  href="{{ URL::to('tender/edittenderbidder',array($customer->id))}}">Edit bids</a>
                                    @endif
                                   | <a class="" id="edit-item">expired</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="expiredtenderstenders">
                    <table class="table table-sm table-hover" id="expiredtenders" width="100%">
                        <thead>
                        <tr class="text-muted">
                            <th></th>
                            <th>Tender No</th>
                            <th>Organisation Name</th>
                            <th>Tender Date</th>
                            <th>Technical Status</th>
                            <th>Commercial Status</th>
                            <th>Emd Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($expiredgetalltenderdata as $key => $expiredgetalltender)
                            <tr>
                                <td></td>
                                <td>{{ $expiredgetalltender->tenderno }}</td>
                                <td>{{ $expiredgetalltender->organisationname }}</td>
                                <td>{{ $expiredgetalltender->tenderdate }}</td>
                                <td>{{ $expiredgetalltender->technicalbidstatus }}</td>
                                <td>{{ $expiredgetalltender->commercialbidstatus }}</td>
                                <td>{{ $expiredgetalltender->emdstatus }}</td>
                                <td>
                                    <a  href="{{ URL::to('tender/viewtenderregistration',array($expiredgetalltender->id))}}">view</a>|
                                    <a  href="{{ URL::to('tender/editregistration',array($expiredgetalltender->id))}}">edit</a>|
                                    @if($expiredgetalltender->flagkey == null)
                                        <a  href="{{ URL::to('tender/tenderbidderview',array($expiredgetalltender->id))}}">Add
                                            bids</a>
                                    @else
                                        <a  href="{{ URL::to('tender/edittenderbidder',array($expiredgetalltender->id))}}">Edit
                                            bids</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="prospectivetenders">
                    <table  id="prospectivetenderstableid" class="table table-sm table-hover" cellspacing="0" width="100%">
                        <thead class="thead-dark">
                        <tr class="text-muted">
                            <th> #</th>
                            <th> Tender No</th>
                            <th>Emd Status</th>
                            <th>Tender Date</th>
                            <th>Organisation</th>
                            <th>Department</th>
                            <th>Bid To Be Submited</th>
                            <th> Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($pendingemdtendersdata as $key => $pendingemdtenders)
                            <tr class="data-row">
                                <td></td>
                                <td class="align-middle name">{{ $pendingemdtenders->tenderno }}</td>
                                <td>{{ $pendingemdtenders->emdstatus }}</td>
                                {{--<td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$pendingemdtenders->tenderdate )->format('Y-m-d') }}</td>--}}
                                <td>{{$pendingemdtenders->tenderdate }}</td>
                                <td>{{ $pendingemdtenders->organisationname }}</td>
                                <td>{{ $pendingemdtenders->department }}</td>
                                <td>{{ $pendingemdtenders->bidtobesubmited }}</td>
                                <td>
                                    <a  href="{{ URL::to('tender/viewtenderregistration',array($pendingemdtenders->id))}}">view</a> |
                                    <a  href="{{ URL::to('tender/editregistration',array($pendingemdtenders->id))}}">edit</a> |

                                    @if($pendingemdtenders->flagkey == null)
                                        <a  href="{{ URL::to('tender/tenderbidderview',array($pendingemdtenders->id))}}">Add
                                            Bids</a> |
                                    @else
                                        <a  href="{{ URL::to('tender/edittenderbidder',array($pendingemdtenders->id))}}">Edit
                                            bids</a>|
                                    @endif
                                    <a class="" id="edit-item">expired</a>

                                </td>
                                {{--<td class="align-middle"><a  id="edit-item">edit</a></td>--}}
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="emdnotcollecttenders">
                    <div style="padding-right: 1216px;"> <a class="btn btn-outline-secondary"  href="{{ URL::to('convertnotcollectedpdf') }}" style="color:gray; float: right"> <b>PDF</b> </a>
                    </div>
                    <table class="table table-sm table-hover" id="emdnotcollecttendersid" width="100%">
                        <thead>
                        <tr class="text-muted">
                            <th></th>
                            <th>Tender No</th>
                            <th>Emd Status</th>
                            <th>Tender Date</th>
                            <th>Organisation Name</th>
                            <th>Department</th>
                            <th>Subject</th>
                            <th>EMD</th>
                            {{--<th>Action</th>--}}
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($emdnotcollected as $key => $emdcollect)
                            <tr>
                                <td></td>
                                <td>{{ $emdcollect->tenderno }}</td>
                                <td>{{ $emdcollect->emdstatus }}</td>
                                <td>{{ $emdcollect->tenderdate }}</td>
                                <td>{{ $emdcollect->organisationname }}</td>
                                <td>{{ $emdcollect->department }}</td>
                                <td>{{ $emdcollect->subject }}</td>
                                <td>{{ $emdcollect->earnestmoneydeposit }}</td>

                                {{--<td>--}}
                                {{--<a href="{{ URL::to('tender/viewtenderregistration',array($emdcollect->id))}}">view</a> |--}}
                                {{--<a href="{{ URL::to('tender/editregistration',array($emdcollect->id))}}">edit</a> |--}}
                                {{--<a href="{{ URL::to('tender/tenderbidderview',array($emdcollect->id))}}">bids</a>--}}

                                {{--</td>--}}
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="emdcollecttenders">
                    <div style="padding-right: 1216px;"> <a class="btn btn-outline-secondary"  href="{{ URL::to('convertcollectedpdf') }}" style="color:gray; float: right"> <b>PDF</b> </a>
                    </div>
                    <table class="table table-sm table-hover" id="emdcollecttendersid" width="100%">
                        <thead>
                        <tr class="text-muted">
                            <th></th>
                            <th>Tender No</th>
                            <th>Emd Status</th>
                            <th>Tender Date</th>
                            <th>Organisation Name</th>
                            <th>Department</th>
                            <th>Subject</th>
                            <th>EMD</th>
                            {{--<th>Action</th>--}}
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($emdcollected as $key => $emdcollect)
                            <tr>
                                <td></td>
                                <td>{{ $emdcollect->tenderno }}</td>
                                <td>{{ $emdcollect->emdstatus }}</td>
                                <td>{{ $emdcollect->tenderdate }}</td>
                                <td>{{ $emdcollect->organisationname }}</td>
                                <td>{{ $emdcollect->department }}</td>
                                <td>{{ $emdcollect->subject }}</td>
                                <td>{{ $emdcollect->earnestmoneydeposit }}</td>

                                {{--<td>--}}
                                {{--<a href="{{ URL::to('tender/viewtenderregistration',array($emdcollect->id))}}">view</a> |--}}
                                {{--<a href="{{ URL::to('tender/editregistration',array($emdcollect->id))}}">edit</a> |--}}
                                {{--<a href="{{ URL::to('tender/tenderbidderview',array($emdcollect->id))}}">bids</a>--}}

                                {{--</td>--}}
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="alltenders">
                    <table class="table table-sm table-hover" id="alltenderstableid" width="100%">
                        <thead>
                        <tr class="text-muted">
                            <th></th>
                            <th>Tender No</th>
                            <th>Organisation Name</th>
                            <th>Tender Date</th>
                            <th>Technical Status</th>
                            <th>Commercial Status</th>
                            <th>Emd Status</th>
                            {{--<th>Emd Status</th>--}}
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($alltenders as $key => $tenders)
                            <tr>
                                <td></td>
                                <td>{{ $tenders->tenderno }}</td>
                                <td>{{ $tenders->organisationname }}</td>
                                <td>{{ $tenders->tenderdate }}</td>
                                <td>{{ $tenders->technicalbidstatus }}</td>
                                <td>{{ $tenders->commercialbidstatus }}</td>
                                <td>{{ $tenders->emdstatus }}</td>
                                {{--<td>{{ $tenders->subject }}</td>--}}
                                <td>
                                    <a href="{{ URL::to('tender/viewtenderregistration',array($tenders->id))}}">view</a>
                                    {{--<a href="{{ URL::to('tender/editregistration',array($tenders->id))}}">edit</a> |--}}

                                    {{--@if($tenders->flagkey == null)--}}
                                    {{--<a href="{{ URL::to('tender/tenderbidderview',array($tenders->id))}}">Add bids</a>--}}
                                    {{--@else--}}
                                    {{--<a href="{{ URL::to('tender/edittenderbidder',array($tenders->id))}}">Edit bids</a>--}}
                                    {{--@endif--}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>

    <div class="modal fade bs-example-modal-lg" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit-modal-label">Expired Tender</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="attachment-body-content" style="padding-left: 250px;">
                    {{ Form::open(array('url' => 'expiredtenders','files' => true)) }}
                    <div class="card text-white bg-dark mb-0">
                        <div class="card-body">
                            <div class="form-group">
                                <label class="col-form-label" for="modal-input-name" style="color: black;">Tender No</label>
                                <input type="text" name="modal-input-name" class="form-control" id="modal-input-name" readonly>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label" for="modal-input-name" style="color: black;">Description</label>
                                {{ Form::textarea('reasondescription', '', array('required'=>'required', 'rows'=>3,'class' => 'form-control form-control-sm')) }}
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    {{ Form::submit('submit', array('class' => 'btn btn-primary col-md-offset-9')) }}
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

@endsection

@section('selectize-script')
    <script src="{{asset('datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('datatable/js/dataTables.bootstrap.min.js')}}"></script>
    <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.bootstrap.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.colVis.min.js"></script>

    <script>
        $(document).ready(function() {
            var table = $('#emdnotcollecttendersid').DataTable( {
                lengthChange: false,
//                buttons: ['pdf']
            } );
            table.buttons().container()
                .appendTo( '#emdnotcollecttendersid_wrapper .col-sm-6:eq(0)');
        } );
        $(document).ready(function() {
            var table = $('#emdcollecttendersid').DataTable( {
                lengthChange: false,
//                buttons: ['pdf']
            } );
            table.buttons().container()
                .appendTo( '#emdcollecttendersid_wrapper .col-sm-6:eq(0)' );
        } );
    </script>
    <script>
        $(document).ready(function() {
            var t = $('#currentactivetenderstableid').DataTable( {
                "columnDefs": [ {
                    "searchable": false,
                    "orderable": false,
                    "targets": 0
                } ],
                "order": [[ 1, 'asc' ]]
            } );

            t.on( 'order.dt search.dt', function () {
                t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            } ).draw();
        });
        $(document).ready(function() {
            var t = $('#expiredtenders').DataTable( {
                "columnDefs": [ {
                    "searchable": false,
                    "orderable": false,
                    "targets": 0
                } ],
                "order": [[ 1, 'asc' ]]
            } );

            t.on( 'order.dt search.dt', function () {
                t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            } ).draw();
        });
        $(document).ready(function() {
            var t = $('#prospectivetenderstableid').DataTable( {
                "columnDefs": [ {
                    "searchable": false,
                    "orderable": false,
                    "targets": 0
                } ],
                "order": [[ 1, 'asc' ]]
            } );

            t.on( 'order.dt search.dt', function () {
                t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            } ).draw();
        });
        $(document).ready(function() {
            var t = $('#alltenderstableid').DataTable( {
                "columnDefs": [ {
                    "searchable": false,
                    "orderable": false,
                    "targets": 0
                } ],
                "order": [[ 1, 'asc' ]]
            } );

            t.on( 'order.dt search.dt', function () {
                t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            } ).draw();
        });

        $(document).ready(function() {
            debugger
            $('#example').DataTable( {
                "footerCallback": function () {
                    var api = this.api(), data;

                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    // Total over all pages
                    total = api
                        .column( 4 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    // Total over this page
                    pageTotal = api
                        .column( 4, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    // Update footer
                    $(api.column( 4 ).footer()).html(
                        '$'+pageTotal +' ( $'+ total +' total)'
                    );
                }
            } );
        } );

    </script>
    <script>

            $(document).on('click', "#edit-item", function() {
                $(this).addClass('edit-item-trigger-clicked'); //useful for identifying which trigger was clicked and consequently grab data from the correct row and not the wrong one.
                var options = {
                    'backdrop': 'static'
                };
                $('#edit-modal').modal(options)
            });

            // on modal show
            $('#edit-modal').on('show.bs.modal', function() {
                debugger
                var el = $(".edit-item-trigger-clicked"); // See how its usefull right here?
                var row = el.closest(".data-row");

                // get the data
                var id = el.data('item-id');
                var name = row.children(".name").text();
                var description = row.children(".description").text();

                // fill the data in the input fields
                $("#modal-input-id").val(id);
                $("#modal-input-name").val(name);
                $("#modal-input-description").val(description);

            });

           //  on modal hide
            $('#edit-modal').on('hide.bs.modal', function() {
                $('.edit-item-trigger-clicked').removeClass('edit-item-trigger-clicked')
                $("#edit-form").trigger("reset");
            })

    </script>
@endsection