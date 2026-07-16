@extends('layouts.appnew')
@section('pageTitle', 'Add Contract')
@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Upload Equipment Sr. No.</h3>
        </div>
        <div class="panel-body">
            {{ Form::open(array('method' => 'post','enctype'=>'multipart/form-data','url' => 'uploadexcelpost','files' => true ,'id'=>'form')) }}
{{--            <div class="row{{ $errors->has('contractno') ? ' has-error' : '' }}">--}}
{{--                <label for="input" class="col-sm-4 col-form-label text-muted">Contract No.</label>--}}
{{--                <div class="col-sm-6">--}}
{{--                    {{ Form::text('contractno', null, array('class' => 'form-control form-control-sm contract','readonly','id'=>'contractequipmentid')) }}--}}
{{--                    @if ($errors->has('contractno'))--}}
{{--                        <span class="help-block"><strong>{{ $errors->first('contractno') }}</strong></span>--}}
{{--                    @endif--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="row{{ $errors->has('contracttype') ? ' has-error' : '' }}"--}}
{{--                 style="padding-top:5px;">--}}
{{--                <label for="input" class="col-sm-4 col-form-label text-muted">Contract Type</label>--}}
{{--                <div class="col-sm-6">--}}
{{--                    {{ Form::text('contracttype', null, array('id'=>'contracttypeid','placeholder'=>'AMC/Short-Term','class' => 'form-control form-control-sm','readonly')) }}--}}
{{--                    @if ($errors->has('contracttype'))--}}
{{--                        <span class="help-block"><strong>{{ $errors->first('contracttype') }}</strong></span>--}}
{{--                    @endif--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div id="addrow" class="row col-md-12">--}}
{{--                <div class="form-group col-md-4" ><label for="inputEmail4">Branch Name</label>--}}
{{--                    {{ Form::select('branchcode[]',array('placeholder' => '---SELECT---'),null, array('required' => 'required', 'id' => 'equipementbranchid','style'=>'width:200')) }}--}}
{{--                </div>--}}
{{--                <div class="form-group col-md-4" style="padding-left:15px;"><label for="inputPassword4">Product Name</label>--}}
{{--                    {{ Form::select('eqipmentproductservice[]',array('placeholder' => '---SELECT---'),null, array('required' => 'required', 'id' => 'productid_0','onchange' => 'getcategory(0); return false;','style'=>'width:200')) }}--}}
{{--                </div>--}}
{{--                <div class="form-group col-md-4" ><label for="inputPassword4">Category Name</label>--}}
{{--                    {{ Form::select('categorycode[]',array('placeholder' => '---SELECT---'),null, array('required' => 'required', 'id' => 'categoryid_0','style'=>'width:200')) }}--}}
{{--                </div>--}}
{{--            </div>--}}
            <div class="row-col-md-12">
                <div class="form-group" id="file">
                    <label class="col-sm-3 col-form-label text-muted">Upload Files</label>
                    {{ Form::file('file',array('class'=>'form-control form-control-sm uplaodfileclass','multiple'=>false,'onchange'=>'ValidateFileUpload()')) }}
                </div>
            </div>
            <div class="row-col-md-12">
                {{ Form::submit('Save & Close', array( 'id'=>'btnsubmitid','class' => 'btn btn-primary offset-4')) }}
            </div>
            {{Form::close()}}
        </div>
    </div>


@endsection
@section('selectize-scripts')
    <script type="text/javascript">
        function ValidateFileUpload() {
            var fuData = document.getElementById('uplodedfileid');
            var FileUploadPath = fuData.value;

//To check if user upload any file
            if (FileUploadPath === '') {
                alert("Please upload an image");

            } else {
                var Extension = FileUploadPath.substring(
                    FileUploadPath.lastIndexOf('.') + 1).toLowerCase();

//The file uploaded is an image

                if ( Extension === "xlsx") {

// To Display
                    if (fuData.files && fuData.files[0]) {
                        var reader = new FileReader();

                        reader.onload = function(e) {
                            $('#blah').attr('src', e.target.result);
                        };

                        reader.readAsDataURL(fuData.files[0]);
                    }

                }

//The file upload is NOT an image
                else {
                    $("#uplodedfileid").val('');
                    alert("Only '.xlsx' format supported.");

                }
            }
        }
    </script>
@endsection