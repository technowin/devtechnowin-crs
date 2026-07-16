@extends('layouts.appnew')
@section('pageTitle', 'Assigned Complaint')
@section('content')
    <style>
        label {
            overflow:hidden;
            text-overflow:ellipsis;
            display:inline-block;
            word-wrap: break-word;
        }
    </style>
    <div class="col-md-12">
        <div class="col-md-12 row">
            <div class="container col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Challan Details</div>
                    <div class="panel-body">
                        <div class="container">
                            <br>
                            <div class="row col-lg-12">
                                <label for="input" class="col-sm-3 text-muted">Challan No :</label>
                                <label for="input" class="col-sm-3">{{ @is_null($challan->challanNo) ? '-' : $challan->challanNo }}</label>

                                <label for="input" class="col-sm-3 text-muted">Challan Date :</label>
                                <label for="input" class="col-sm-3">{{ @is_null($challan->challanDate) ? '-' : Carbon\Carbon::parse($challan->challanDate)->format('d-m-Y') }}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection