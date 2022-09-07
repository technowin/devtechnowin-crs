@extends('layouts.appnew')

@section('content')
    <style>
        th, td {
            padding: 5px;
            text-align: center;
        }
    </style>
    <table class="table-bordered table-striped col-lg-12" id="main">
        <thead>
        <th>Calls</th>
        <th>Total</th>
        <th>Received</th>
        <th>Assigned</th>
        <th>Status</th>
        </thead>
        <thead>
        <th></th>
        <th></th>
        <th><table class="table-bordered table-striped col-lg-12">
                <thead>
                <th>>2 days</th>
                <th>>7 days</th>
                <th>>1 month</th>
                <th>>3 months</th>
                </thead>
            </table></th>
        <th><table class="table-bordered table-striped col-lg-12">
                <thead>
                <th>>2 days</th>
                <th>>7 days</th>
                <th>>1 month</th>
                <th>>3 months</th>
                </thead>
            </table></th>
        <th><table class="table-bordered table-striped col-lg-12">
                <thead>
                <th>Pending</th>
                <th>Unresolved</th>
                <th>Resolved</th>
                <th>Closed</th>
                </thead>
            </table></th>
        </thead>
        <tbody>
        <tr>
            <td><b>Complaint</b></td>
            <td>{{ Form::label($totalComplaintCount) }}</td>
            <td><table class="table-bordered table-striped col-lg-12">
                    <tbody>
                    <td>{{ Form::label($twodaysRECount) }}</td>
                    <td>{{ Form::label($sevendaysRECount) }}</td>
                    <td>{{ Form::label($onemonthRECount) }}</td>
                    <td>{{ Form::label($threemonthRECount) }}</td>
                    </tbody>
                </table></td>
            <td><table class="table-bordered table-striped col-lg-12">
                    <tbody>
                    <td>{{ Form::label($twodaysASSCount) }}</td>
                    <td>{{ Form::label($sevendaysASSCount) }}</td>
                    <td>{{ Form::label($onemonthASSCount) }}</td>
                    <td>{{ Form::label($threemonthASSCount) }}</td>
                    </tbody>
                </table></td>
            <td><table class="table-bordered table-striped col-lg-12">
                    <tbody>
                    <td>{{ Form::label($pendingCount) }}</td>
                    <td>{{ Form::label($notresolvedCount) }}</td>
                    <td>{{ Form::label($resolvedCount) }}</td>
                    <td>{{ Form::label($closedCount) }}</td>
                    </tbody>
                </table></td>
        </tr>
        <tr>
            <td><b>Service</b></td>
            <td>{{ Form::label($totalServiceCount) }}</td>
            <td><table class="table-bordered table-striped col-lg-12">
                    <tbody>
                    <td>{{ Form::label($servTwodaysRECount) }}</td>
                    <td>{{ Form::label($servSevendaysRECount) }}</td>
                    <td>{{ Form::label($servOnemonthRECount) }}</td>
                    <td>{{ Form::label($servThreemonthRECount) }}</td>
                    </tbody>
                </table></td>
            <td><table class="table-bordered table-striped col-lg-12">
                    <tbody>
                    <td>{{ Form::label($servTwodaysASSCount) }}</td>
                    <td>{{ Form::label($servSevendaysASSCount) }}</td>
                    <td>{{ Form::label($servOnemonthASSCount) }}</td>
                    <td>{{ Form::label($servThreemonthASSCount) }}</td>
                    </tbody>
                </table></td>
            <td><table class="table-bordered table-striped col-lg-12">
                    <tbody>
                    <td>{{ Form::label($servPendingCount) }}</td>
                    <td>{{ Form::label($servNotresolvedCount) }}</td>
                    <td>{{ Form::label($servResolvedCount) }}</td>
                    <td>{{ Form::label($servClosedCount) }}</td>
                    </tbody>
                </table></td>
        </tr>
        <tr>
            <td><b>Warranty</b></td>
            <td>{{ Form::label($totalSupplyCount) }}</td>
            <td><table class="table-bordered table-striped col-lg-12">
                    <tbody>
                    <td>{{ Form::label($supplyTwodaysRECount) }}</td>
                    <td>{{ Form::label($supplySevendaysRECount) }}</td>
                    <td>{{ Form::label($supplyOnemonthRECount) }}</td>
                    <td>{{ Form::label($supplyThreemonthRECount) }}</td>
                    </tbody>
                </table></td>
            <td><table class="table-bordered table-striped col-lg-12">
                    <tbody>
                    <td>{{ Form::label($supplyTwodaysASSCount) }}</td>
                    <td>{{ Form::label($supplySevendaysASSCount) }}</td>
                    <td>{{ Form::label($supplyOnemonthASSCount) }}</td>
                    <td>{{ Form::label($supplyThreemonthASSCount) }}</td>
                    </tbody>
                </table></td>
            <td><table class="table-bordered table-striped col-lg-12">
                    <tbody>
                    <td>{{ Form::label($supplyPendingCount) }}</td>
                    <td>{{ Form::label($supplyNotresolvedCount) }}</td>
                    <td>{{ Form::label($supplyResolvedCount) }}</td>
                    <td>{{ Form::label($supplyClosedCount) }}</td>
                    </tbody>
                </table></td>
        </tr>
        </tbody>

    </table>

@endsection

@section('page-script')

    <script type="text/javascript">
        $(document).ready(function () {
            window.setTimeout(function () {
                $(".alert").fadeTo(1500, 0).slideUp(500, function () {
                    $(this).remove();
                });
            }, 5000);
        });
    </script>
@stop
