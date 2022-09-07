@extends('layouts.appnew')
@section('pageTitle', 'Manage User Complaint')
@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">User Filled Complaint</h3>
                </div>

                <div class="panel-body">
                    <div class="row mt-2">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Ticket No : </label>
                        {{ Form::label('', $ticketno, array('class'=>'col-sm-8 col-form-label text-muted')) }}
                    </div>
                    <div class="row">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Customer Name : </label>
                        {{ Form::label('', $customername, array('class'=>'col-sm-8 col-form-label text-muted')) }}
                    </div>
                    <div class="row">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Work Oreder No : </label>
                        {{ Form::label('', $userworkorderno, array('class'=>'col-sm-8 col-form-label text-muted')) }}
                    </div>
                    <div class="row">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Branch Name : </label>
                        {{ Form::label('', $branchname, array('class'=>'col-sm-8 col-form-label text-muted')) }}
                    </div>
                    <div class="row">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Product / Service : </label>
                        {{ Form::label('', $productservicename, array('class'=>'col-sm-8 col-form-label text-muted')) }}
                    </div>
                    <div class="row">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Category : </label>
                        {{ Form::label('', $categoryname, array('class'=>'col-sm-8 col-form-label text-muted')) }}
                    </div>
                    <div class="row">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Sub-Category : </label>
                        {{ Form::label('', $subcategoryname, array('class'=>'col-sm-8 col-form-label text-muted')) }}
                    </div>
                    <div class="row">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Product Serial No : </label>
                        {{ Form::label('', $productserialno, array('class'=>'col-sm-8 col-form-label text-muted')) }}
                    </div>
                    <div class="row">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Complaint Description : </label>
                        {{ Form::label('', $complaintdescription, array('class'=>'col-sm-8 col-form-label text-muted')) }}
                    </div><div class="row">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Caller Name : </label>
                        {{ Form::label('', $callername, array('class'=>'col-sm-8 col-form-label text-muted')) }}
                    </div>
                    <div class="row">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Mobile No : </label>
                        {{ Form::label('', $mobileno, array('class'=>'col-sm-8 col-form-label text-muted')) }}
                    </div>
                    <div class="row">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Email ID : </label>
                        {{ Form::label('', $emailid, array('class'=>'col-sm-8 col-form-label text-muted')) }}
                    </div>
                    <div class="row">
                        <div class="col-md-4"><label class="control-label">Rejection Reason</label></div>
                        <div class="col-md-8">
                            {{ Form::open(['action' => ['ComplaintsFilterController@rejectcomplaint', $ticketno]]) }}
                            {{ Form::hidden('ticketno', $ticketno, array('class'=>'col-form-label text-muted')) }}
                            {{ Form::textarea('rejectionreason',null,['class'=>'form-control', 'rows' => 2, 'cols' => 40, 'required' => 'required']) }}
                            <br>
                            {{ Form::submit('Reject', array('class' => 'btn btn-primary')) }}
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Lodge User Complaint</h3>
                </div>
                <div class="panel-body">
                    {{--{{ Form::open(['action' => ['ComplaintsFilterController@LodgedUserComplaint', $ticketno]]) }}--}}
                    {{--{{Form::open(array('action' => 'ComplaintsFilterController@lodgeusercomplaint','method' => 'post', 'role' => 'form', 'invalidate' => 'invalidate', 'files'=>true, 'onsubmit' => 'return checkvalidation();'))}}--}}
                    {{ Form::open(array('url' => 'lodgeusercomplaint')) }}
                    {{ form::hidden('ticketno', $ticketno) }}
                    @if($contract !=null)
                        {{ form::hidden('contractno',$contractno,array('id'=>'contractnoid')) }}
                        @else
                        {{ form::hidden('contractno','',array('id'=>'contractnoid')) }}
                    @endif
                    {{--{{ Form::hidden('ticketno', $ticketno, array('class'=>'col-form-label text-muted')) }}--}}
                    {{ Form::hidden('customertype', $customertype, array('class'=>'col-form-label text-muted')) }}
                    <div class="row mt-2 {{ $errors->has('customers') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Customer Name</label>
                        <div class="col-sm-6">
                            {{ Form::select('customerlike', $customerlike, $customercode, array('placeholder' => '--SELECT--','id' => 'customerslist', 'class' => 'selectize')) }}
                            @if ($errors->has('customers'))
                                <span class="help-block"><strong>{{ $errors->first('customers') }}</strong></span>
                            @endif
                        </div>
                    </div>

                    <div class="row{{ $errors->has('customersite') ? ' has-error' : '' }}" >
                        <label for="input" class="col-sm-4 col-form-label text-muted">Work Order No</label>
                        <div class="col-sm-6">
                            {{ Form::select('workorderno', $workorderlist, $workordercode,  array('placeholder' => '--SELECT--','id' => 'workordernoid', 'class' => 'selectize')) }}
                            @if ($errors->has('customersite'))
                                <span class="help-block"><strong>{{ $errors->first('customersite') }}</strong></span>
                            @endif
                        </div>
                    </div>

                    <div class="row{{ $errors->has('customersite') ? ' has-error' : '' }}" >
                        <label for="input" class="col-sm-4 col-form-label text-muted">Customer Site</label>
                        <div class="col-sm-6">
                            {{ Form::select('customersite', $branchlist, $branchcode,  array('placeholder' => '--SELECT--','id' => 'customersite', 'class' => 'selectize')) }}
                            @if ($errors->has('customersite'))
                                <span class="help-block"><strong>{{ $errors->first('customersite') }}</strong></span>
                            @endif
                        </div>
                    </div>

                    <div class="row{{ $errors->has('productservice') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Product & Service</label>
                        <div class="col-sm-6">
                            {{ Form::select('productservice',array('' => '') + $productservice, $productservicecode, array('id' => 'productservice','class' => 'selectize','onchange' => 'getcategory(); return false;','required' => 'required')) }}
                            @if ($errors->has('productservice'))
                                <span class="help-block"><strong>{{ $errors->first('productservice') }}</strong></span>
                            @endif
                        </div>
                    </div>

                    <div class="row{{ $errors->has('category') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Category</label>
                        <div class="col-sm-6">
                            {{--{{ Form::select('category',array('' => '--SELECT--') + $category, $categorycode, array('id' => 'category', 'class' => 'selectize','onchange' => 'getsubcategory(); return false;','required' => 'required')) }}--}}
                            {{ Form::select('category',array('' => '--SELECT--') + $category, $categorycode, array('id' => 'category', 'class' => 'selectize','required' => 'required')) }}
                            @if ($errors->has('category'))
                                <span class="help-block"><strong>{{ $errors->first('category') }}</strong></span>
                            @endif
                        </div>
                    </div>

                    <div class="row{{ $errors->has('subcategory') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Sub-Category</label>
                        <div class="col-sm-6">
                            {{ Form::select('subcategory', array('' => '--SELECT--') + $subcategory, $subcategorycode, array('id' => 'subcategory', 'class' => 'selectize','required' => 'required')) }}
                            @if ($errors->has('subcategory'))
                                <span class="help-block"><strong>{{ $errors->first('subcategory') }}</strong></span>
                            @endif
                        </div>
                    </div>

                    <div class="row{{ $errors->has('productserialno') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Product Serial No</label>
                        <div class="col-sm-6">
                            {{ Form::select('productservice', $productsrnolist, $productsrnocode,  array('placeholder' => '--SELECT--','id' => 'productserialno', 'class' => 'selectize')) }}
                                {{--{{ Form::select('productserialno', array('' => '--SELECT--') + $productsrno, $productsrcode, array('id' => 'productserialno', 'class' => 'selectize','required' => 'required')) }}--}}
                            @if ($errors->has('sub-category'))
                                <span class="help-block"><strong>{{ $errors->first('productserialno') }}</strong></span>
                            @endif
                        </div>
                    </div>

                    <div class="row{{ $errors->has('complaintdescription') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Complaint Description (Max 500 Chars)</label>
                        <div class="col-sm-6">
                            {{ Form::textarea('complaintdescription',$complaintdescription,['class'=>'form-control form-control-sm', 'rows' => 3, 'cols' => 40, 'required' => 'required']) }}
                            @if ($errors->has('complaintdescription'))
                                <span class="help-block"><strong>{{ $errors->first('complaintdescription') }}</strong></span>
                            @endif
                        </div>
                    </div>

                    <div class="row{{ $errors->has('callername') ? ' has-error' : '' }} mt-2">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Caller Name</label>
                        <div class="col-sm-6">
                            {{ Form::text('callername', $callername, array('class' => 'form-control form-control-sm','required' => 'required')) }}
                            @if ($errors->has('callername'))
                                <span class="help-block"><strong>{{ $errors->first('callername') }}</strong></span>
                            @endif
                        </div>
                    </div>

                    <div class="row{{ $errors->has('callermobile') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Caller Mobile</label>
                        <div class="col-sm-6">
                            {{ Form::text('callermobile', $mobileno, array('class' => 'form-control form-control-sm','required' => 'required')) }}
                            @if ($errors->has('callermobile'))
                                <span class="help-block"><strong>{{ $errors->first('callermobile') }}</strong></span>
                            @endif
                        </div>
                    </div>

                    <div class="row{{ $errors->has('calleremail') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Caller Email</label>
                        <div class="col-sm-6">
                            {{ Form::text('calleremail', $emailid, array('class' => 'form-control form-control-sm','required' => 'required')) }}
                            @if ($errors->has('calleremail'))
                                <span class="help-block"><strong>{{ $errors->first('calleremail') }}</strong></span>
                            @endif
                        </div>
                    </div>

                    <div class="row mt-2 {{ $errors->has('priority') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Priority</label>
                        <div class="col-sm-6">
                            {{ Form::select('priority', array('High' => 'High','Low' => 'Low','Medium' => 'Medium'), null, array('placeholder' => '--SELECT--', 'id' => 'priority', 'class' => 'selectize','required' => 'required')) }}
                            @if ($errors->has('priority'))
                                <span class="help-block"><strong>{{ $errors->first('priority') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="row mt-2 {{ $errors->has('chargedcomplaint') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Charged Complaint</label>
                        <div class="col-sm-6">
                            {{Form::hidden('chargedcomplaint',0)}}
                            {{Form::checkbox('chargedcomplaint')}}
                            @if ($errors->has('priority'))
                                <span class="help-block"><strong>{{ $errors->first('chargedcomplaint') }}</strong></span>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <label for="input" class="col-sm-4 col-form-label text-muted"></label>
                        <div class="col-sm-6">
                            <br>
                            {{ Form::submit('Lodge Complaint', array('class' => 'btn btn-primary')) }}
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection


@section('selectize-script')
    <script src="{{ asset('assets/Selectize/jquery-1.10.2.js') }}"></script>
    <script src="{{ asset('assets/Selectize/js/standalone/selectize.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.selectize').selectize({
                maxItems: 1
            });
        });

        function checkvalidation() {
            var message = '';
            if($("#customerslist").val() == ''){
                message = checkifempty(message, 'Customer')
            }
            if($("#customersite").val() == ''){
                message = checkifempty(message, 'Customer Site')
            }
            if($("#productservice").val() == ''){
                message = checkifempty(message, 'Product Service')
            }
            if($("#category").val() == ''){
                message = checkifempty(message, 'Category')
            }
            if($("#subcategory").val() == ''){
                message = checkifempty(message, 'Sub Category')
            }
            if($("#productserialno").val() == ''){
                message = checkifempty(message, 'Product Serial No')
            }
            if($("#priority").val() == ''){
                message = checkifempty(message, 'Priority')
            }

            if(message != ''){
                alert(message + ' Required');
                return false;
            }
            return true;
        }

        function checkifempty(message, tobeadded){
            if(message == ''){
                message = tobeadded;
            }
            else {
                message = message+', ' + tobeadded;
            }
            return message;
        }

        //Bind branch names / customer sites on customer selection
        $("#customerslist").change(function () {
            var branchlist = [];

            if ($('#customerslist').val() != "") {
                $.ajax({
                    url: '{{ url('/registration/branch') }}/'+ $('#customerslist').val() ,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        $.each(data, function (key, value) {
                            branchlist.push({
                                text: value['branchname'],
                                value: value['branchcode'],
                            })
                        });

                        $('#customersite').selectize()[0].selectize.destroy();

                        if(branchlist.length > 0) {
                            $('#customersite').selectize({
                                maxItems: 1,
                                valueField: 'value',
                                labelField: 'text',
                                searchField: 'text',
                                create: false,
                                sortField: {
                                    field: 'text',
                                    direction: 'asc'
                                },
                                options: branchlist,
                            });
                        }
                        else {
                            $('#customersite').selectize({
                                options:null
                            });
                        }
                    }
                });
            }
            else{
                $('#customersite').selectize()[0].selectize.destroy();
                $('#customersite').selectize({
                    options: null
                });
            }
        })

        $('#customersite').change(function () {
            $("#productservice").empty();
            $("#category").empty();
            $("#productserialno").empty();

            if ($('#customersite').val() != "") {
                debugger
                $.ajax({
                    url: "{{URL::to('getequipment/')}}/" + $('#customersite').val(),
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        debugger
//                        $('#productserialno').selectize()[0].selectize.destroy();
//                        $('#category').selectize()[0].selectize.destroy();
                        $('#productservice').selectize()[0].selectize.destroy();
//                        $("#productservice").empty();
//                        $("#category").empty();
                        $("#productserialno").empty();
//                        $('#productserialno').append('<option value="" selected disabled>--SELECT--</option>');
//                        $('#category').append('<option value="" selected disabled>--SELECT--</option>');
                        $('#productservice').append('<option value="" selected disabled>--SELECT--</option>');

                        for (var i = 0; i < data.equipmentsnolist.length; i++) {

                            if(data.equipmentsnolist[i] != undefined)
                            {
//                                $('#productserialno').append('<option value="'+data.equipmentsnolist[i].equipmentsrno+'">'+data.equipmentsnolist[i].equipmentsrno+'</option>');
                            }

                            if(data.categorylist[i] != undefined){
//                                $("#category").append($("<option>" + "  " + + "</option>" +"<option value = " + data.categorylist[i].categorycode + ">" + data.categorylist[i].categoryname + "</option>"));
                            }

                            if( data.productservicelist[i] != undefined) {
                                $("#productservice").append($("<option>" + "  " + + "</option>" +"<option value=" + data.productservicelist[i].productservicecode + ">" + data.productservicelist[i].productservicename + "</option>"));
                            }
                        }
//                        $('#productserialno').selectize();
//                        $('#category').selectize();
                        $('#productservice').selectize();
                    }
                });
            }
        });

        {{--$('#productservice').change(function () {--}}
            {{--debugger--}}
            {{--$("#category").empty();--}}
            {{--$("#productserialno").empty();--}}

            {{--if ($('#productservice').val() != "")    {--}}
                {{--$.ajax({--}}
                    {{--url: '{{ url('/getyear/{data}') }}/',--}}
                    {{--url: "{{URL::to('getequipmentproductsrno/{data}')}}/",--}}
                    {{--type: "GET",--}}
                    {{--dataType: "json",--}}
                    {{--data: {--}}
                        {{--productservice: $('#productservice').val(),--}}
                        {{--contractnoid: $('#contractnoid').val(),--}}
                        {{--customerscode: $('#customerslist').val()--}}
                    {{--},--}}
                    {{--success: function (data) {--}}
                        {{--debugger--}}
                        {{--$('#productserialno').selectize()[0].selectize.destroy();--}}
                        {{--$('#category').selectize()[0].selectize.destroy();--}}
                        {{--$("#category").empty();--}}
                        {{--$("#productserialno").empty();--}}
                        {{--$('#productserialno').append('<option value="" selected disabled>--SELECT--</option>');--}}
                        {{--$('#category').append('<option value="" selected disabled>--SELECT--</option>');--}}

                        {{--for (var i = 0; i < data.productsrnolist.length; i++) {--}}

                            {{--if(data.productsrnolist[i] != undefined)--}}
                            {{--{--}}
                                {{--$('#productserialno').append('<option value="'+data.productsrnolist[i].equipmentsrno+'">'+data.productsrnolist[i].equipmentsrno+'</option>');--}}
                            {{--}--}}

                            {{--if(data.categorylist[i] != undefined){--}}
                                {{--$("#category").append($("<option>" + "  " + + "</option>" +"<option value = " + data.categorylist[i].categorycode + ">" + data.categorylist[i].categoryname + "</option>"));--}}
                            {{--}--}}


                        {{--}--}}
                        {{--$('#productserialno').selectize();--}}
                        {{--$('#category').selectize();--}}
                    {{--}--}}

                {{--});--}}
            {{--}--}}
        {{--});--}}


         $("#productservice").change(function () {
            var categorylist = [];
            if ($('#productservice').val() != "") {

                $.ajax({
                    url: "{{URL::to('registration/category/')}}/" + $('#productservice').val(),
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        $.each(data, function (key, value) {
                            categorylist.push({
                                text: value['categoryname'],
                                value: value['categorycode'],
                            })
                        });

                        $('#category').selectize()[0].selectize.destroy();

                        if (categorylist.length > 0) {
                            $('#category').selectize({
                                maxItems: 1,
                                valueField: 'value',
                                labelField: 'text',
                                searchField: 'text',
                                create: false,
                                sortField: {
                                    field: 'text',
                                    direction: 'asc'
                                },
                                options: categorylist,
                            });
                        }
                        else {
                            $('#category').selectize({
                                options: null
                            });
                        }
                    }
                });
            }
            else {

                $('#category').selectize()[0].selectize.destroy();
                $('#category').selectize({
                    options: null
                });
            }
        });

        {{--$('#category').change(function () {--}}
            {{--debugger--}}
            {{--if ($('#category').val() != "") {--}}
                {{--var subcategorylist = [];--}}
                {{--$.ajax({--}}
                    {{--url: "{{URL::to('registration/subcategory/')}}/" + $('#category').val(),--}}
                    {{--type: "GET",--}}
                    {{--dataType: "json",--}}
                    {{--success: function (data) {--}}
                        {{--debugger--}}
                        {{--$.each(data, function (key, value) {--}}
                            {{--subcategorylist.push({--}}
                                {{--text: value['subcategoryname'],--}}
                                {{--value: value['subcategorycode'],--}}
                            {{--})--}}
                        {{--});--}}

                        {{--$('#subcategory').selectize()[0].selectize.destroy();--}}
                        {{--if (subcategorylist.length > 0) {--}}
                            {{--$('#subcategory').selectize({--}}
                                {{--maxItems: 1,--}}
                                {{--valueField: 'value',--}}
                                {{--labelField: 'text',--}}
                                {{--searchField: 'text',--}}
                                {{--create: false,--}}
                                {{--sortField: {--}}
                                    {{--field: 'text',--}}
                                    {{--direction: 'asc'--}}
                                {{--},--}}
                                {{--options: subcategorylist,--}}
                            {{--});--}}
                        {{--}--}}
                        {{--else {--}}
                            {{--$('#subcategory').selectize({--}}
                                {{--options: null--}}
                            {{--});--}}
                        {{--}--}}
                    {{--}--}}
                {{--});--}}
            {{--}--}}
            {{--else {--}}
                {{--$('#subcategory').selectize()[0].selectize.destroy();--}}
                {{--$('#subcategory').selectize({--}}
                    {{--options: null--}}
                {{--});--}}
            {{--}--}}
        {{--});--}}


        $('#category').change(function () {
            debugger
            $("#subcategory").empty();
            $("#productserialno").empty();

            if ($('#category').val() != "") {
                $.ajax({
                    url: "{{URL::to('getequipmentproductsrno/{data}')}}/",
                    type: "GET",
                    dataType: "json",
                    data: {
                        productservice: $('#productservice').val(),
                        contractnoid: $('#contractnoid').val(),
                        customerscode: $('#customerslist').val(),
                        branchcode: $('#customersite').val(),
                        categorycode: $("#category").val()
                    },
                    success: function (data) {
                        debugger
                        $('#productserialno').selectize()[0].selectize.destroy();
                        $('#subcategory').selectize()[0].selectize.destroy();
                        $("#subcategory").empty();
                        $("#productserialno").empty();
                        $('#productserialno').append('<option value="" selected disabled>--SELECT--</option>');
                        $('#subcategory').append('<option value="" selected disabled>--SELECT--</option>');

                        for (var i = 0; i < data.productsrnolist.length; i++) {
                            if(data.productsrnolist[i] != undefined)
                            {
                                $('#productserialno').append('<option value="'+data.productsrnolist[i].equipmentsrno+'">'+data.productsrnolist[i].equipmentsrno+'</option>');
                            }
                        }
                        for (var n =0;n < data.subcategorylist.length; n++)
                        {
                            if(data.subcategorylist[n] != undefined){
                                $("#subcategory").append($("<option>" + "  " + + "</option>" +"<option value = " + data.subcategorylist[n].subcategorycode + ">" + data.subcategorylist[n].subcategoryname + "</option>"));
                            }
                        }

                        $('#productserialno').selectize();
                        $('#subcategory').selectize();
                    }

                });
            }
        });


        {{--function getcategory() {--}}
            {{--debugger--}}

            {{--if ($("#productservice").val() != "") {--}}
                {{--var categorylist = [];--}}
                {{--var subcategorylist = [];--}}
                {{--$.ajax({--}}
                    {{--url:'{{ url('/registration/category') }}/'+ $("#productservice").val(),--}}
                    {{--type: "GET",--}}
                    {{--dataType: "JSON",--}}
                    {{--success: function (data) {--}}
                    {{--debugger--}}
                        {{--$.each(data, function (key, value) {--}}
                            {{--categorylist.push({--}}
                                {{--text: value['categoryname'],--}}
                                {{--value: value['categorycode'],--}}
                            {{--})--}}
                        {{--});--}}

                        {{--$('#category').selectize()[0].selectize.destroy();--}}
                        {{--$('#category').selectize({--}}
                            {{--maxItems: 1,--}}
                            {{--valueField: 'value',--}}
                            {{--labelField: 'text',--}}
                            {{--searchField: 'text',--}}
                            {{--create: false,--}}
                            {{--sortField: {--}}
                                {{--field: 'text',--}}
                                {{--direction: 'asc'--}}
                            {{--},--}}
                            {{--options: categorylist,--}}
                        {{--});--}}
                    {{--}--}}
                {{--});--}}
            {{--}--}}
            {{--else {--}}
                {{--$('select[name="subcategorycode"]').empty();--}}
                {{--$('select[name="category"]').empty();--}}
            {{--}--}}
        {{--}--}}

        {{--function getsubcategory() {--}}
            {{--debugger--}}
            {{--if ($("#category").val() != "") {--}}
                {{--var subcategorylist = [];--}}
                {{--$.ajax({--}}
                    {{--url:'{{ url('/registration/subcategory') }}/'+ $("#category").val(),--}}
                    {{--type: "GET",--}}
                    {{--dataType: "json",--}}
                    {{--success: function (data) {--}}
                        {{--$.each(data, function (key, value) {--}}
                            {{--subcategorylist.push({--}}
                                {{--text: value['subcategoryname'],--}}
                                {{--value: value['subcategorycode'],--}}
                            {{--})--}}
                        {{--});--}}

                        {{--$('#subcategory').selectize()[0].selectize.destroy();--}}
                        {{--$('#subcategory').selectize({--}}
                            {{--maxItems: 1,--}}
                            {{--valueField: 'value',--}}
                            {{--labelField: 'text',--}}
                            {{--searchField: 'text',--}}
                            {{--create: false,--}}
                            {{--sortField: {--}}
                                {{--field: 'text',--}}
                                {{--direction: 'asc'--}}
                            {{--},--}}
                            {{--options: subcategorylist,--}}
                        {{--});--}}
                    {{--}--}}
                {{--});--}}
            {{--}--}}
            {{--else {--}}
                {{--$('select[name="subcategorycode"]').empty();--}}
                {{--$('select[name="category"]').empty();--}}
            {{--}--}}
        {{--}--}}


        $("#workordernoid").change(function () {
            debugger
            var branchlist = [];
            if ($('#workordernoid').val() != "") {
                $.ajax({
                    url: "{{URL::to('getworkordernowisebranch/{data}')}}/",
                    type: "GET",
                    dataType: "json",
                    data: {
                        workordernoid: $('#workordernoid').val(),
                    },
                    success: function (data) {
                        debugger
                        $.each(data.branchlist, function (key, value) {
                            branchlist.push({
                                text: value['branchname'],
                                value: value['branchcode'],
                            })
                        });
                        $('#customersite').selectize()[0].selectize.destroy();
                        if (branchlist.length > 0) {
                            $('#customersite').selectize({
                                maxItems: 1,
                                valueField: 'value',
                                labelField: 'text',
                                searchField: 'text',
                                create: false,
                                sortField: {
                                    field: 'text',
                                    direction: 'asc'
                                },
                                options: branchlist,
                            });
                        }
                        else {
                            $('#customersite').selectize({
                                options: null
                            });
                        }
                        $('#contractnoid').val(data.contractno)
                    }
                });
            }
            else {

                $('#customersite').selectize()[0].selectize.destroy();
                $('#customersite').selectize({
                    options: null
                });
            }

        });

    </script>
@stop