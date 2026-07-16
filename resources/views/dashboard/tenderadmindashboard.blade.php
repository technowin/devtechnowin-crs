@extends('layouts.appnew')

@section('pageTitle', 'Complaints')
@section('content')

    {{--<div class="col-md-12 row" style="margin-top: 20px">--}}

        {{--<div class="col-lg-6" style="border-radius: 10px; border: 1px solid darkgray;">--}}

            {{--<div class="card card-outline-secondary bg-faded auto-scroll" style="height: 340px;overflow: auto;">--}}
                {{--<br/><h4 style="text-align: center">Query End Status</h4>--}}
                {{--inner div--}}

                {{--<div class="col-md-12 form-group">--}}
                    {{--<table class="table table-hover" id="emdalert" max-width="80%">--}}
                        {{--<thead>--}}
                        {{--<th>Days Left</th>--}}
                        {{--<th>Tender No</th>--}}
                        {{--<th>Subject</th>--}}
                        {{--<th>Department</th>--}}
                        {{--<th>Organisation</th>--}}
                        {{--<th>Query End Date</th>--}}
                        {{--<th>Actions</th>--}}
                        {{--</thead>--}}
                        {{--@foreach($queryenddate as $key => $query)--}}
                            {{--<tr>--}}
                                {{--<td> {{$query->days}}&nbsp;day(s)</td>--}}
                                {{--<td>{{$query->tenderno}}</td>--}}
                                {{--<td>{{$query->organisationname}}</td>--}}
                                {{--<td>{{$query->department}}</td>--}}
                                {{--<td>{{$query->subject}}</td>--}}
                                {{--<td>{{(($query->queryenddate))}}</td>--}}
                                {{--<td>--}}
                                    {{--<a href="/tender/viewtenderregistration/{{ $query->id }}" style="margin-right:--}}
                                        {{--3px;">view</a>--}}
                                    {{--| <a href="/tender/editregistration/{{ $query->id }}" style="margin-right:--}}
                                        {{--3px;">edit</a>--}}
                                {{--</td>--}}

                            {{--</tr>--}}
                        {{--@endforeach--}}
                    {{--</table>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="col-lg-6 " style="border-radius: 10px; border: 1px solid darkgray">--}}
            {{--<div class="card card-outline-secondary bg-faded auto-scroll" style="height: 340px;overflow: auto;">--}}
                {{--inner div--}}
                {{--<br/><h4 style="text-align: center">Pre-Bid Meet Status</h4>--}}

                {{--<div class="col-md-12 form-group">--}}
                    {{--<table class="table table-hover" id="emdalert" max-width="80%">--}}
                        {{--<thead>--}}
                        {{--<th>Days Left</th>--}}
                        {{--<th>Tender No</th>--}}
                        {{--<th>Subject</th>--}}
                        {{--<th>Department</th>--}}
                        {{--<th>Organisation</th>--}}
                        {{--<th>Pre-Bid Meet Date</th>--}}
                        {{--<th>Actions</th>--}}
                        {{--</thead>--}}
                        {{--@foreach($prebid as $key => $prebidmeet)--}}
                            {{--<tr>--}}
                                {{--<td> {{$prebidmeet->days}}&nbsp;day(s)</td>--}}
                                {{--<td>{{$prebidmeet->tenderno}}</td>--}}
                                {{--<td>{{$prebidmeet->organisationname}}</td>--}}
                                {{--<td>{{$prebidmeet->department}}</td>--}}
                                {{--<td>{{$prebidmeet->subject}}</td>--}}
                                {{--<td>{{(($prebidmeet->prebidmeetingdate))}}</td>--}}
                                {{--<td>--}}
                                    {{--<a href="/tender/viewtenderregistration/{{ $prebidmeet->id }}" style="margin-right:--}}
                                        {{--3px;">view</a>--}}
                                    {{--| <a href="/tender/editregistration/{{ $prebidmeet->id }}" style="margin-right:--}}
                                        {{--3px;">edit</a>--}}
                                {{--</td>--}}
                            {{--</tr>--}}
                        {{--@endforeach--}}
                    {{--</table>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}

    {{--</div>--}}


    {{--<div class="col-md-12 row" style="margin-top: 20px;">--}}

        {{--<div class="col-lg-6 " style="border-radius: 10px; border: 1px solid darkgray">--}}
            {{--<div class="card card-outline-secondary bg-faded " style="height: 340px;overflow: auto;">--}}
                {{--inner div--}}
                {{--<br/><h4 style="text-align: center">Bid Submission Data</h4>--}}

                {{--<div class="col-md-12 form-group">--}}
                    {{--<table class="table table-hover" id="emdalert" max-width="80%">--}}
                        {{--<thead>--}}
                        {{--<th>Days Left</th>--}}
                        {{--<th>Tender No</th>--}}
                        {{--<th>Subject</th>--}}
                        {{--<th>Department</th>--}}
                        {{--<th>Organisation</th>--}}
                        {{--<th>Bid Submission Date</th>--}}
                        {{--<th>Actions</th>--}}
                        {{--</thead>--}}
                        {{--@foreach($bidsubmission as $key => $bidsub)--}}
                            {{--<tr>--}}
                                {{--<td> {{$bidsub->days}}&nbsp;day(s)</td>--}}
                                {{--<td>{{$bidsub->tenderno}}</td>--}}
                                {{--<td>{{$bidsub->organisationname}}</td>--}}
                                {{--<td>{{$bidsub->department}}</td>--}}
                                {{--<td>{{$bidsub->subject}}</td>--}}
                                {{--<td>{{(($bidsub->bidsubmissiondate))}}</td>--}}
                                {{--<td>--}}
                                    {{--<a href="/tender/viewtenderregistration/{{ $bidsub->id }}" style="margin-right:--}}
                                        {{--3px;">view</a>--}}
                                    {{--| <a href="/tender/editregistration/{{ $bidsub->id }}" style="margin-right:--}}
                                        {{--3px;">edit</a>--}}
                                {{--</td>--}}
                            {{--</tr>--}}
                        {{--@endforeach--}}
                    {{--</table>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="col-lg-6 " style="border-radius: 10px; border: 1px solid darkgray">--}}
            {{--<div class="card card-outline-secondary bg-faded " style="height: 340px;overflow: auto;">--}}
                {{--inner div--}}
                {{--<br/><h4 style="text-align: center">Technical Bid Data</h4>--}}

                {{--<div class="col-md-12 form-group">--}}
                    {{--<table class="table table-hover" id="emdalert" max-width="80%">--}}
                        {{--<thead>--}}
                        {{--<th>Days Left</th>--}}
                        {{--<th>Tender No</th>--}}
                        {{--<th>Subject</th>--}}
                        {{--<th>Department</th>--}}
                        {{--<th>Organisation</th>--}}
                        {{--<th>Technical Bid Date</th>--}}
                        {{--<th>Actions</th>--}}
                        {{--</thead>--}}
                        {{--@foreach($technicalbid as $key => $technbid)--}}
                            {{--<tr>--}}
                                {{--<td> {{$technbid->days}}&nbsp;day(s)</td>--}}
                                {{--<td>{{$technbid->tenderno}}</td>--}}
                                {{--<td>{{$technbid->organisationname}}</td>--}}
                                {{--<td>{{$technbid->department}}</td>--}}
                                {{--<td>{{$technbid->subject}}</td>--}}
                                {{--<td>{{(($technbid->technicalbidopendate))}}</td>--}}
                                {{--<td>--}}
                                    {{--<a href="/tender/viewtenderregistration/{{ $technbid->id }}" style="margin-right:--}}
                                        {{--3px;">view</a>--}}
                                    {{--| <a href="/tender/editregistration/{{ $technbid->id }}" style="margin-right:--}}
                                        {{--3px;">edit</a>--}}
                                {{--</td>--}}
                            {{--</tr>--}}
                        {{--@endforeach--}}
                    {{--</table>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}

    {{--</div>--}}


    {{--<div class="col-md-12 row" style="margin-top: 20px;">--}}

        {{--<div class="col-lg-6 " style="border-radius: 10px; border: 1px solid darkgray">--}}
            {{--<div class="card card-outline-secondary bg-faded" style="height: 340px;overflow: auto;" >--}}
                {{--inner div--}}
                {{--<br/><h4 style="text-align: center">Commercial Bid Data</h4>--}}

                {{--<div class="col-md-12 form-group">--}}
                    {{--<table class="table table-hover" id="emdalert" max-width="80%">--}}
                        {{--<thead>--}}
                        {{--<th>Days Left</th>--}}
                        {{--<th>Tender No</th>--}}
                        {{--<th>Subject</th>--}}
                        {{--<th>Department</th>--}}
                        {{--<th>Organisation</th>--}}
                        {{--<th>Bid Submission Date</th>--}}
                        {{--<th>Actions</th>--}}
                        {{--</thead>--}}
                        {{--@foreach($commercialbid as $key => $combid)--}}
                            {{--<tr>--}}
                                {{--<td> {{$combid->days}}&nbsp;day(s)</td>--}}
                                {{--<td>{{$combid->tenderno}}</td>--}}
                                {{--<td>{{$combid->organisationname}}</td>--}}
                                {{--<td>{{$combid->department}}</td>--}}
                                {{--<td>{{$combid->subject}}</td>--}}
                                {{--<td>{{(($combid->commercialbidopendate))}}</td>--}}
                                {{--<td>--}}
                                    {{--<a href="/tender/viewtenderregistration/{{ $combid->id }}" style="margin-right:--}}
                                        {{--3px;">view</a>--}}
                                    {{--| <a href="/tender/editregistration/{{ $combid->id }}" style="margin-right:--}}
                                        {{--3px;">edit</a>--}}
                                {{--</td>--}}
                            {{--</tr>--}}
                        {{--@endforeach--}}
                    {{--</table>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="col-lg-6" style="border-radius: 10px; border: 1px solid darkgray">--}}
            {{--<div class="card card-outline-secondary bg-faded" style="height: 340px;overflow: auto;">--}}
                {{--inner div--}}
                {{--<br/><h4 style="text-align: center">EMD Return Data</h4>--}}

                {{--<div class="col-md-12 form-group">--}}
                    {{--<table class="table table-hover" id="emdalert" max-width="80%">--}}
                        {{--<thead>--}}
                        {{--<th>Days Left</th>--}}
                        {{--<th width="10%">Tender No</th>--}}
                        {{--<th>Subject</th>--}}
                        {{--<th>Department</th>--}}
                        {{--<th>Organisation</th>--}}
                        {{--<th>Technical Bid Date</th>--}}
                        {{--<th>Actions</th>--}}
                        {{--</thead>--}}
                        {{--@foreach($emdreturndate as $key => $tender)--}}
                            {{--<tr>--}}
                                {{--<td> {{$tender->days}}&nbsp;day(s)</td>--}}
                                {{--<td>{{$tender->tenderno}}</td>--}}
                                {{--<td>{{$tender->organisationname}}</td>--}}
                                {{--<td>{{$tender->department}}</td>--}}
                                {{--<td>{{$tender->subject}}</td>--}}
                                {{--<td>{{(($tender->emdreturndate))}}</td>--}}
                                {{--<td>--}}
                                    {{--<a href="/tender/viewtenderregistration/{{ $tender->id }}" style="margin-right:--}}
                                        {{--3px;">view</a>--}}
                                    {{--| <a href="/tender/editregistration/{{ $tender->id }}" style="margin-right:--}}
                                        {{--3px;">edit</a>--}}
                                {{--</td>--}}
                            {{--</tr>--}}
                        {{--@endforeach--}}
                    {{--</table>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}

    {{--</div>--}}

    @endsection