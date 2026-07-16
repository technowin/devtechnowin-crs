@extends('layouts.appnew')

@section('page-title', '| Customers')

@section('content')

    <div type="container">
        <div class="panel panel-default">

            <div class="panel-heading">
                <h3 class="panel-title">Details Customers</h3>
            </div>
            <div class="panel-body">

                {{--<div class="row col-md-12">--}}
                    {{--<div for="input" class="col-sm-4 col-form-label text-muted">Customer Code</div>--}}
                    {{--<div class="col-md-4 ol-form-label text-muted">: {{$customers->customercode }}</div>--}}
                {{--</div>--}}

                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Customer Name</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$customers->customername }}</div>
                </div>

                {{--<div class="row col-md-12">--}}
                    {{--<div for="input" class="col-sm-4 col-form-label text-muted">Customer Type</div>--}}
                    {{--<div class="col-md-4 ol-form-label text-muted">: {{$customers->customertype }}</div>--}}
                {{--</div>--}}
                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Address</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$customers->address }}</div>
                </div>

                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">State</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$customers->state }}</div>
                </div>

                {{--<div class="row col-md-12">--}}
                    {{--<div for="input" class="col-sm-4 col-form-label text-muted">State Code</div>--}}
                    {{--<div class="col-md-4 ol-form-label text-muted">: {{$customers->statecode }}</div>--}}
                {{--</div>--}}

                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Customer Fax</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$customers->customerfax }}</div>
                </div>
                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Email Id</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$customers->emailid }}</div>
                </div>

                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Customer Website</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$customers->customerwebsite }}</div>
                </div>
                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Contact Person Name</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$customers->contactpersonname }}</div>
                </div>

                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Contact  Designation</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$customers->contactpersondesignation }}</div>
                </div>
                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Contact  Department</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$customers->contactpersondepartment }}</div>
                </div>
                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Contact  Person Phone</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$customers->contactpersonphone }}</div>
                </div>
                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Contact  Person Mobile</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$customers->contactpersonmobile }}</div>
                </div>
                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Contact  Person Email</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$customers->contactpersonemailid }}</div>
                </div>
                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Customer Pan No</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$customers->customerpanno }}</div>
                </div>
                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Customer GST No</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$customers->customergstno }}</div>
                </div>
                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Customer Type</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$customers->customertype }}</div>
                </div>

                {{--<div class="row col-md-12">--}}
                    {{--<div for="input" class="col-sm-4 col-form-label text-muted">Created at</div>--}}
                    {{--<div class="col-md-4 ol-form-label text-muted">: {{$customers->created_at}}</div>--}}
                {{--</div>--}}
                {{--<div class="row col-md-12">--}}
                    {{--<div for="input" class="col-sm-4 col-form-label text-muted">Updated at</div>--}}
                    {{--<div class="col-md-4 ol-form-label text-muted">: {{$customers->updated_at}}</div>--}}
                {{--</div>--}}

            </div>
        </div>
        <a class="btn btn-default" href="{{url()->previous()}}">Back</a>
    </div>

@endsection