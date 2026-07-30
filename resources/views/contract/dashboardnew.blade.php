@extends('layouts.appnew')
@section('pageTitle', 'Contracts Dashboard')

@section('page-css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<style>
    body { background-color: #f4f6f9; }

    .dashboard-wrap { padding: 12px 0 20px; }
    .dashboard-wrap h2 {
        font-weight: 700;
        color: #1f2d3d;
        margin-bottom: 12px;
        font-size: 20px;
        letter-spacing: -0.3px;
    }
    .dashboard-wrap h2:before {
        content: "";
        display: inline-block;
        width: 5px;
        height: 18px;
        background: linear-gradient(180deg, #337ab7, #5bc0de);
        border-radius: 3px;
        margin-right: 8px;
        vertical-align: middle;
    }

    /* Tabs */
    .nav-tabs {
        border-bottom: none;
        background: #fff;
        border-radius: 10px;
        padding: 5px;
        box-shadow: 0 1px 6px rgba(0,0,0,0.06);
        display: flex;
        flex-wrap: wrap;
        margin-bottom: 0;
    }
    .nav-tabs > li { margin-bottom: 0; }
    .nav-tabs > li > a {
        border: none;
        border-radius: 6px;
        font-weight: 600;
        font-size: 13px;
        color: #5a6a7a;
        padding: 7px 14px;
        margin-right: 2px;
        transition: all 0.2s ease;
    }
    .nav-tabs > li > a:hover {
        background-color: #eef4fa;
        color: #337ab7;
        border-color: transparent;
    }
    .nav-tabs > li.active > a,
    .nav-tabs > li.active > a:focus,
    .nav-tabs > li.active > a:hover {
        color: #fff;
        background: linear-gradient(135deg, #337ab7, #2a6a9f);
        border: none;
        box-shadow: 0 2px 6px rgba(51,122,183,0.3);
    }
    .nav-tabs > li > a .badge {
        margin-left: 6px;
        background-color: #dce4ec;
        color: #5a6a7a;
        font-weight: 700;
        font-size: 11px;
    }
    .nav-tabs > li.active > a .badge { background-color: rgba(255,255,255,0.25); color: #fff; }

    /* Card */
    .panel {
        border: none;
        border-radius: 10px;
        box-shadow: 0 1px 8px rgba(0,0,0,0.06);
        margin-top: 10px;
        overflow: hidden;
    }
    .dashcard { padding: 12px 14px; }

    /* Table */
    table.dataTable { border-collapse: collapse !important; width: 100% !important; }
    table.dataTable thead th {
        background-color: #f8f9fb;
        color: #495867;
        font-weight: 700;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        border-bottom: 2px solid #e9edf2 !important;
        white-space: nowrap;
        padding-top: 8px !important;
        padding-bottom: 8px !important;
    }
    table.dataTable tbody tr:nth-child(odd) td { background-color: #fbfcfd; }
    table.dataTable tbody td { vertical-align: middle; border-top: 1px solid #eef1f4; padding: 6px 8px; font-size: 14px; }
    table.dataTable tbody tr:hover td { background-color: #f0f7fc !important; }

    tr.danger td  { background-color: #fdeeee !important; }
    tr.warning td { background-color: #fff8e8 !important; }
    tr.info td    { background-color: #eaf5fb !important; }
    tr.success td { background-color: #eaf7ef !important; }

    .dashcard .label {
        font-size: 11px;
        padding: 3px 9px;
        border-radius: 16px;
        font-weight: 600;
    }

    /* DataTables controls */
    .dataTables_wrapper { padding-top: 2px; font-size: 12.5px; }
    .dataTables_length, .dataTables_filter, .dataTables_info, .dataTables_paginate {
        margin: 6px 0;
    }
    .dataTables_length select {
        width: auto;
        padding: 2px 6px;
        border-radius: 5px;
        border: 1px solid #dde3e9;
        margin: 0 4px;
    }
    .dataTables_filter input {
        border-radius: 16px;
        border: 1px solid #dde3e9;
        padding: 4px 12px;
        margin-left: 6px;
        width: 180px;
    }
    .dataTables_info { color: #8a97a3; }

    .dataTables_paginate .paginate_button {
        padding: 3px 9px !important;
        margin-left: 2px;
        border-radius: 5px !important;
        border: 1px solid #e2e6ea !important;
        background: #fff !important;
        color: #495867 !important;
        cursor: pointer;
    }
    .dataTables_paginate .paginate_button.current,
    .dataTables_paginate .paginate_button.current:hover {
        background: #337ab7 !important;
        border-color: #337ab7 !important;
        color: #fff !important;
    }
    .dataTables_paginate .paginate_button:hover {
        background: #eef4f8 !important;
        border-color: #337ab7 !important;
        color: #337ab7 !important;
    }
    .dataTables_paginate .paginate_button.disabled { opacity: 0.5; cursor: default; }

    .btn-xs { border-radius: 5px; font-weight: 600; }

    /* Category filter — compact segmented pill control */
    .category-filter-group {
        display: inline-flex;
        background: #eef1f5;
        border-radius: 22px;
        padding: 3px;
        margin-bottom: 10px;
        gap: 2px;
        
    }
    .category-filter-group .category-btn {
        border: none;
        background: transparent;
        color: #6b7684;
        font-weight: 600;
        font-size: 12px;
        padding: 4px 12px;
        border-radius: 18px;
        transition: all 0.2s ease;
        box-shadow: none !important;
        line-height: 1.4;
    }
    .category-filter-group .category-btn i { margin-right: 4px; font-size: 11px; }
    .category-filter-group .category-btn:hover {
        color: #337ab7;
        background: rgba(51,122,183,0.08);
    }
    .category-filter-group .category-btn.active {
        background: #fff;
        color: #337ab7;
        box-shadow: 0 1px 4px rgba(0,0,0,0.12);
    }

    .billing-alert-bell {
    color: #e74c3c;
    margin-left: 6px;
    display: inline-block;
    vertical-align: middle;
    animation: bellring 0.8s ease-in-out infinite;
    transform-origin: top center;
}



    .category-filter-group .category-btn.active[data-category="software"] { color: #6f42c1; }
    .category-filter-group .category-btn.active[data-category="hardware"] { color: #e67e22; }
    .category-filter-group .category-btn.active[data-category="manpower"] { color: #16a085; }

    .critical-count-badge {
    background: #e74c3c;
    color: #fff;
    font-size: 10px;
    font-weight: 700;
    padding: 1px 5px;
    border-radius: 10px;
    margin-left: 2px;
    vertical-align: top;
}

@keyframes bellring {
    0%, 100% { transform: rotate(0deg); }
    20% { transform: rotate(12deg); }
    40% { transform: rotate(-10deg); }
    60% { transform: rotate(6deg); }
    80% { transform: rotate(-4deg); }
}
</style>
@stop

@section('content')
<div class="container-fluid dashboard-wrap">
    <h2> Contract Dashboard</h2>

    @php
        $criticalBillingCount = $billingalerts->where('billstatuscolor', 'danger')->count();
    @endphp

    <ul class="nav nav-tabs" role="tablist">
        
        <li role="presentation" class="active"><a style="font-size:20px; !important;" href="#expiring-tab" data-toggle="tab">Expiring Soon <span class="badge">{{ count($expiring) }}</span></a></li>

        <li role="presentation">
    <a style="font-size:19px; !important;" href="#billing-tab" data-toggle="tab">
        Billing Alerts <span class="badge">{{ count($billingalerts) }}</span>
        @if($criticalBillingCount > 0)
            <svg class="billing-alert-bell" xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 16 16" fill="currentColor" title="{{ $criticalBillingCount }} critical billing issue(s)">
                <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zM8 1.918l-.797.161A4.002 4.002 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4.002 4.002 0 0 0-3.203-3.92L8 1.917zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5.002 5.002 0 0 1 13 6c0 .88.32 4.2 1.22 6z"/>
            </svg>
            <span class="critical-count-badge">{{ $criticalBillingCount }}</span>
        @endif
    </a>
</li>

        <li role="presentation"><a style="font-size:19px; !important;" href="#expired-tab" data-toggle="tab">Expired <span class="badge">{{ count($expired) }}</span></a></li>
        <li role="presentation"><a style="font-size:19px; !important;" href="#new-tab" data-toggle="tab">New <span class="badge">{{ count($newContracts) }}</span></a></li>
        <li role="presentation"><a style="font-size:19px; !important;" href="#all-tab" data-toggle="tab">All <span class="badge">{{ count($all) }}</span></a></li>
        
    </ul>

    <div class="tab-content" style="margin-top:15px;">

        {{-- EXPIRING SOON --}}
        <div class="tab-pane fade active in" id="expiring-tab">
            <div class="panel panel-default">
                <div class="panel-body dashcard">

                    <div class="btn-group category-filter-group" data-target-table="table-expiring">
                        <button type="button" style="font-size:19px; !important;" class="btn btn-sm btn-default category-btn active" data-category="all">All</button>
                        <button type="button" style="font-size:19px; !important;" class="btn btn-sm btn-default category-btn" data-category="software">Software</button>
                        <button type="button" style="font-size:19px; !important;" class="btn btn-sm btn-default category-btn" data-category="hardware">Hardware</button>
                        <button type="button" style="font-size:19px; !important;" class="btn btn-sm btn-default category-btn" data-category="manpower">Manpower</button>
                    </div>

                    <table class="table table-bordered table-hover table-condensed" id="table-expiring">
                        <thead>
                            <tr><th>Contract No</th><th>Customer</th><th>Work Order Type</th><th>Contract To Date</th><th>Days Left</th><th>Status</th><th>Action</th></tr>
                        </thead>
                        <tbody>
                        @foreach($expiring as $c)

                        
                            <tr class="{{ $c->statuscolor }}" data-category="{{ $c->category }}">
                                <td>{{ $c->contractno }}</td>
                                <td>{{ $c->customername }}</td>
                                <td>{{ $c->workordertype }}</td>
                                <td>{{ $c->contracttodate }}</td>
                                <td><b>{{ $c->daysleft }}</b> day(s)</td>
                                <td><span class="label label-{{ $c->statuscolor }}">{{ $c->status }}</span></td>
                                <td><a href="{{ url('editcontract/'.$c->contractno) }}" class="btn btn-xs btn-primary">Edit</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- EXPIRED --}}
        <div class="tab-pane fade" id="expired-tab">
            <div class="panel panel-default">
                <div class="panel-body dashcard">

                    <div class="btn-group category-filter-group" data-target-table="table-expired">
                        <button type="button" style="font-size:19px; !important;" class="btn btn-sm btn-default category-btn active" data-category="all">All</button>
                        <button type="button" style="font-size:19px; !important;" class="btn btn-sm btn-default category-btn" data-category="software">Software</button>
                        <button type="button" style="font-size:19px; !important;" class="btn btn-sm btn-default category-btn" data-category="hardware">Hardware</button>
                        <button type="button" style="font-size:19px; !important;" class="btn btn-sm btn-default category-btn" data-category="manpower">Manpower</button>
                    </div>

                    <table class="table table-bordered table-hover table-condensed" id="table-expired">
                        <thead>
                            <tr><th>Contract No</th><th>Customer</th><th>Work Order Type</th><th>Contract To Date</th><th>Overdue By</th><th>Action</th></tr>
                        </thead>
                        <tbody>
                        @forelse($expired as $c)
                            <tr class="danger" data-category="{{ $c->category }}">
                                <td>{{ $c->contractno }}</td>
                                <td>{{ $c->customername }}</td>
                                <td>{{ $c->workordertype }}</td>
                                <td>{{ $c->contracttodate }}</td>
                                <td><b>{{ abs($c->daysleft) }}</b> day(s)</td>
                                <td><a href="{{ url('editcontract/'.$c->contractno) }}" class="btn btn-xs btn-primary">Edit</a></td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center text-muted">No expired contracts pending closure.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- NEW --}}
        <div class="tab-pane fade" id="new-tab">
            <div class="panel panel-default">
                <div class="panel-body dashcard">

                    <div class="btn-group category-filter-group" data-target-table="table-new">
                        <button type="button" style="font-size:19px; !important;" class="btn btn-sm btn-default category-btn active" data-category="all">All</button>
                        <button type="button" style="font-size:19px; !important;" class="btn btn-sm btn-default category-btn" data-category="software">Software</button>
                        <button type="button" style="font-size:19px; !important;" class="btn btn-sm btn-default category-btn" data-category="hardware">Hardware</button>
                        <button type="button" style="font-size:19px; !important;" class="btn btn-sm btn-default category-btn" data-category="manpower">Manpower</button>
                    </div>

                    <table class="table table-bordered table-hover table-condensed" id="table-new">
                        <thead>
                            <tr><th>Contract No</th><th>Customer</th><th>Work Order Type</th><th>Created At</th><th>Contract Period</th><th>Action</th></tr>
                        </thead>
                        <tbody>
                        @forelse($newContracts as $c)
                            <tr class="success" data-category="{{ $c->category }}">
                                <td>{{ $c->contractno }}</td>
                                <td>{{ $c->customername }}</td>
                                <td>{{ $c->workordertype }}</td>
                                <td>{{ $c->created_at }}</td>
                                <td>{{ $c->contractfromdate }} to {{ $c->contracttodate }}</td>
                                <td><a href="{{ url('editcontract/'.$c->contractno) }}" class="btn btn-xs btn-primary">Edit</a></td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center text-muted">No contracts created in the last 7 days.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- ALL --}}
        <div class="tab-pane fade" id="all-tab">
            <div class="panel panel-default">
                <div class="panel-body dashcard">

                    <div class="btn-group category-filter-group" data-target-table="table-all">
                        <button type="button" style="font-size:19px; !important;" class="btn btn-sm btn-default category-btn active" data-category="all">All</button>
                        <button type="button" style="font-size:19px; !important;" class="btn btn-sm btn-default category-btn" data-category="software">Software</button>
                        <button type="button" style="font-size:19px; !important;" class="btn btn-sm btn-default category-btn" data-category="hardware">Hardware</button>
                        <button type="button" style="font-size:19px; !important;" class="btn btn-sm btn-default category-btn" data-category="manpower">Manpower</button>
                    </div>

                    <table class="table table-bordered table-hover table-condensed" id="table-all">
                        <thead>
                            <tr><th>Contract No</th><th>Customer</th><th>Work Order Type</th><th>Contract To Date</th><th>Days Left</th><th>Status</th><th>Action</th></tr>
                        </thead>
                        <tbody>
                        @forelse($all as $c)
                            <tr class="{{ $c->statuscolor }}" data-category="{{ $c->category }}">
                                <td>{{ $c->contractno }}</td>
                                <td>{{ $c->customername }}</td>
                                <td>{{ $c->workordertype }}</td>
                                <td>{{ $c->contracttodate }}</td>
                                <td>{{ $c->daysleft !== null ? $c->daysleft : '-' }}</td>
                                <td><span class="label label-{{ $c->statuscolor }}">{{ $c->status }}</span></td>
                                <td><a href="{{ url('editcontract/'.$c->contractno) }}" class="btn btn-xs btn-primary">Edit</a></td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center text-muted">No contracts found.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- BILLING ALERTS --}}
        <div class="tab-pane fade" id="billing-tab">
            <div class="panel panel-default">
                <div class="panel-body dashcard">

                    <div class="btn-group category-filter-group" data-target-table="table-billing">
                        <button type="button" style="font-size:19px; !important;" class="btn btn-sm btn-default category-btn active" data-category="all">All</button>
                        <button type="button" style="font-size:19px; !important;" class="btn btn-sm btn-default category-btn" data-category="software">Software</button>
                        <button type="button" style="font-size:19px; !important;" class="btn btn-sm btn-default category-btn" data-category="hardware">Hardware</button>
                        <button type="button" style="font-size:19px; !important;" class="btn btn-sm btn-default category-btn" data-category="manpower">Manpower</button>
                    </div>

                    <table class="table table-bordered table-hover table-condensed" id="table-billing">
                        <thead>
                            <tr>
                                <th>Contract No</th><th>Customer</th><th>Cycle</th>
                                <th>Est. Bill Date</th><th>Act Bill Date</th>
                                <th>Bill Amt</th><th>Paid Amt</th><th>Diff</th>
                                <th>Payment Date</th><th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($billingalerts as $b)
                            <tr class="{{ $b->billstatuscolor }}" data-category="{{ $b->category }}">
                                <td>{{ $b->contractno }}</td>
                                <td>{{ $b->customername }}</td>
                                <td>{{ $b->paymentcycleno }}</td>
                                <td>{{ $b->estimatedbillingdate }}</td>
                                <td>{{ $b->actualbilldate ?? '—' }}</td>
                                <td>{{ $b->billamount }}</td>
                                <td>{{ $b->billpaidamount }}</td>
                                <td>{{ $b->diffamount ? number_format($b->diffamount, 2) : '-' }}</td>
                                <td>{{ $b->billpaymentdate ?? '—' }}</td>
                                <td><span class="label label-{{ $b->billstatuscolor }}">{{ $b->billstatus }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="10" class="text-center text-muted">No billing cycles found.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('page-script')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
$(function () {
    var dtOptions = {
        pageLength: 10,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        order: [],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search...",
            lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            infoEmpty: "No entries to show",
            infoFiltered: "(filtered from _MAX_ total)"
        }
    };

    var initializedTables = {};
    var categoryFilters = {}; // tableId -> 'all'|'software'|'hardware'|'manpower'

    function initTable(selector) {
        if ($(selector).length && !$.fn.DataTable.isDataTable(selector)) {
            initializedTables[selector] = $(selector).DataTable(dtOptions);
        }
    }

    // custom filter applied to ALL DataTables on the page; scoped per table below
    $.fn.dataTable.ext.search.push(function (settings, searchData, index, rowData, counter) {
        var tableId = settings.nTable.id;
        var filter = categoryFilters['#' + tableId] || 'all';
        if (filter === 'all') return true;

        var api = new $.fn.dataTable.Api(settings);
        var node = api.row(index).node();
        return $(node).data('category') === filter;
    });

    // init the visible tab's table immediately
    initTable('#table-expiring');

    // init others only when their tab is shown (avoids zero-width bug in hidden tab-panes)
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        var target = $(e.target).attr('href'); // e.g. "#expired-tab"
        var tableSelector = '#' + $(target).find('table').attr('id');

        initTable(tableSelector);

        if (initializedTables[tableSelector]) {
            initializedTables[tableSelector].columns.adjust();
        }
    });

    // category button clicks
    $('.category-btn').on('click', function () {
        var $group = $(this).closest('.category-filter-group');
        var tableId = '#' + $group.data('target-table');
        var category = $(this).data('category');

        $group.find('.category-btn').removeClass('active');
        $(this).addClass('active');

        categoryFilters[tableId] = category;

        if (initializedTables[tableId]) {
            initializedTables[tableId].draw();
        } else {
            // table not yet initialized (hidden tab) — init now so filter applies once shown
            initTable(tableId);
        }
    });
});
</script>
@stop