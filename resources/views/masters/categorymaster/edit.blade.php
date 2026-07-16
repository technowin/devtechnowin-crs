@extends('layouts.appnew')

@section('page-title', '| Category Master')

@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"> Category</h3>
            </div>
            <div class="panel-body">
                <div class="container">
                    {{ Form::model($category, array('route' => array('category.update', $category->categorycode), 'method' => 'PUT')) }}

                    <div class="row{{ $errors->has('categoryname') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Category Name</label>
                        <div class="col-sm-6">
                            {{ Form::text('categoryname', null, array('class' => 'form-control form-control-sm')) }}
                        </div>
                    </div>

                    <div class="row mt-1{{ $errors->has('productservicecode') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Product Service Name</label>
                        <div class="col-sm-6">
                            {{ Form::select('productservicecode', array(''=>'--SELECT--') + $productservicecode, null, array('required' => 'required','id' => 'productservicecode')) }}
                        </div>
                    </div>
                    <div class="row mt-1{{ $errors->has('categorydescription') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Category Description</label>
                        <div class="col-sm-6">
                            {{ Form::textarea('categorydescription', null, array('rows'=>3,'class' => 'form-control form-control-sm','onKeyPress'=>'if(this.value.length==250) return false;')) }}
                        </div>
                    </div>
                    <br>
                    <div class="row mt-1{{ $errors->has('isactive') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Is Active</label>
                        <div class="col-sm-6">
                            {{ Form::select('isactive', array('select'=>'--SELECT--','1' => 'Yes','0' => 'No'),null, array('placeholder' => 'select','required' => 'required', 'id' => 'isactive')) }}
                        </div>
                    </div>
                    <br>
                    <div class="row mt-1{{ $errors->has('calleremail') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted"></label>
                        <div class="col-sm-6">
                            {{ Form::submit('Save & Close', array('class' => 'btn btn-primary')) }}
                            <a class="btn btn-primary" href="{{url()->previous()}}">Cancel</a>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

@endsection

@section('page-script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#productservicecode').selectize({
                maxItems: 1
            });
            $('#isactive').selectize({
                maxItems: 1
            });
        });
    </script>
@stop
	