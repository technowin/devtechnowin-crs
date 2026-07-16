@extends('layouts.app')

@section('page-title', '| Add User')

@section('content')

    <div class="container card col-md-8">
        <div class="col card-body">
            <div class="row"  style="border-bottom: 1px solid darkgray">
                <div class="col-md-6"><h5 class="card-title text-muted"> Edit Complainee Department</h5></div>
                <div class="col-md-6"><img src="{{ asset('images/addcomplaint.png') }}" width="40" height="40" style="float: right; margin-top: -15px"/></div>
            </div>
            <BR>
            <div class="container">
                {{ Form::model($complaineedepartment , array('route' => array('complaineedepartment.update', $complaineedepartment->complaineedepartmentmastercode), 'method' => 'PUT')) }}

                <div class="row{{ $errors->has('assigneename') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Department Name</label>
                    <div class="col-sm-6">
                        {{ Form::select('departments', $departments, $departmentcode, array('placeholder' => 'select','required' => 'required','id'=>'departmentcode')) }}
                    </div>

                </div>

                <div class="row{{ $errors->has('calleremail') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Product Service Name</label>
                    <div class="col-sm-6">
                        {{ Form::select('ProductService', $ProductService, $ProductServiceCode, array('placeholder' => 'select','required' => 'required','id' => 'productid','onchange' => 'getcategory(); return false;')) }}
                    </div>
                </div>

                <div class="row{{ $errors->has('assigneename') ? ' has-error' : '' }}">
                <label for="input" class="col-sm-4 col-form-label text-muted">Category Name</label>
                <div class="col-sm-6">
                    {{ Form::select('category', $category, $categorycode, array('placeholder' => 'select','required' => 'required', 'id' => 'categoryid','onchange' => 'getsubcategory(); return false;')) }}
                </div>

                </div>

                <div class="row{{ $errors->has('assigneename') ? ' has-error' : '' }}">
                <label for="input" class="col-sm-4 col-form-label text-muted">Sub Category Name</label>
                <div class="col-sm-6">
                    {{ Form::select('subcategory', $subcategory, $subcategorycode, array('placeholder' => 'select','required' => 'required', 'id' => 'subcategoryid')) }}
                </div>

                </div>

                <div class="row{{ $errors->has('maxdays') ? ' has-error' : '' }}">
                <label for="input" class="col-sm-4 col-form-label text-muted">Max Days</label>
                <div class="col-sm-6">
                {{ Form::text('maxdays', null, array('class' => 'form-control form-control-sm')) }}
                </div>

                </div>

                <br>

                <div class="row{{ $errors->has('calleremail') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted"></label>
                    <div class="col-sm-6">
                        {{ Form::submit('Save & Close', array('class' => 'btn btn-primary')) }}

                    </div>
                </div>







                {{ Form::close() }}

            </div>

        </div>
    </div>




@endsection

@section('script-js')
    <script src="{{ asset('assets/Selectize/jquery-1.10.2.js') }}"></script>
    <script src="{{ asset('assets/Selectize/js/standalone/selectize.js') }}"></script>
    <script>

        $(document).ready(function () {
            $('#departmentcode').selectize({
                maxItems: 1
            });
            $('#productid').selectize({
                maxItems: 1
            });
            $('#categoryid').selectize({
                maxItems: 1
            });
            $('#subcategoryid').selectize({
                maxItems: 1
            });
        });
    </script>

@stop
<script src="{{ asset('assets/Selectize/jquery-1.10.2.js') }}"></script>

<script type="text/javascript">
    //    var url = "http://ubuntu-server/complaintredressalsystem/public/index.php";
    function getcategory() {
        debugger
        if ($("#productid").val() != "") {
            var categorylist = [];
            var subcategorylist= [];
            $.ajax({
                url: '/registration/category/' + $("#productid").val(),
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $('#subcategoryid').selectize()[0].selectize.destroy();
                    $('#subcategoryid').selectize({
                        options: null
                    });

                    $.each(data, function (key, value) {
                        categorylist.push({
                            text: value['categoryname'],
                            value: value['categorycode'],
                        })
                    });

                    $('#categoryid').selectize()[0].selectize.destroy();
                    $('#categoryid').selectize({
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
            });
        }
        else {
            $('select[name="subcategorycode"]').empty();
            $('select[name="category"]').empty();
        }
    }

    function getsubcategory() {
        if ($("#categoryid").val() != "") {
            var subcategorylist= [];
            $.ajax({
                url: '/registration/subcategory/' + $("#categoryid").val(),
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $.each(data, function (key, value) {
                        subcategorylist.push({
                            text: value['subcategoryname'],
                            value: value['subcategorycode'],
                        })
                    });

                    $('#subcategoryid').selectize()[0].selectize.destroy();
                    $('#subcategoryid').selectize({
                        maxItems: 1,
                        valueField: 'value',
                        labelField: 'text',
                        searchField: 'text',
                        create: false,
                        sortField: {
                            field: 'text',
                            direction: 'asc'
                        },
                        options: subcategorylist,
                    });
                }
            });
        }

        else {
            $('select[name="subcategorycode"]').empty();
            $('select[name="category"]').empty();
        }
    }

</script>

{{--<script src="{{ asset('assets/Selectize/jquery-1.10.2.js') }}"></script>--}}
{{--<script type="text/javascript">--}}

    {{--function getcategory() {--}}
        {{--debugger--}}
        {{--if ($("#productid").val() != "") {--}}
            {{--$.ajax({--}}
                {{--url: '/registration/category/' + $("#productid").val(),--}}
                {{--type: "GET",--}}
                {{--dataType: "json",--}}
                {{--success: function (data) {--}}
                    {{--debugger--}}
                    {{--$('select[name="category"]').empty();--}}
                    {{--$('select[name="subcategorycode"]').empty();--}}
                    {{--$('select[name="subcategorycode"]').append('<option value="">--SELECT--</option>');--}}
                    {{--$('select[name="category"]').append('<option value="">--SELECT--</option>');--}}
                    {{--$.each(data, function (key, value) {--}}
                        {{--$('select[name="category"]').append('<option value="' + value['categorycode'] + '">' + value['categoryname'] + '</option>');--}}
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
            {{--$.ajax({--}}
                {{--url: '/registration/subcategory/' + $("#category").val(),--}}
                {{--type: "GET",--}}
                {{--dataType: "json",--}}
                {{--success: function (data) {--}}
                    {{--$('select[name="subcategory"]').empty();--}}
                    {{--$('select[name="subcategory"]').append('<option value="">--select--</option>');--}}
                    {{--$.each(data, function (key, value) {--}}
                        {{--$('select[name="subcategory"]').append('<option value="' + value['subcategorycode'] + '">' + value['subcategoryname'] + '</option>');--}}
                    {{--});--}}
                {{--}--}}
            {{--});--}}
        {{--}--}}
        {{--else {--}}
            {{--$('select[name="subcategorycode"]').empty();--}}
            {{--$('select[name="category"]').empty();--}}
        {{--}--}}
    {{--}--}}

{{--</script>--}}
	{{----}}
	