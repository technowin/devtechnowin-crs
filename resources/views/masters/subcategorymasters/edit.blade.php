@extends('layouts.appnew')

@section('page-title', '| Add User')

@section('content')

    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Edit Sub-Category</h3>
            </div>
            <div class="panel-body">
                <div class="container">
                    {{ Form::model($subcategory, array('route' => array('subcategory.update', $subcategory->subcategorycode), 'method' => 'PUT')) }}

                    <div class="row{{ $errors->has('subcategoryname') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Sub Category Name</label>
                        <div class="col-sm-6">
                            {{ Form::text('subcategoryname', null, array('class' => 'form-control form-control-sm')) }}
                        </div>
                    </div>

                    <div class="row mt-1{{ $errors->has('subcategoryname') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Category Name</label>
                        <div class="col-sm-6", >
                            {{ Form::select('category', $category, $categorycode, array('placeholder' => 'select','required' => 'required','id'=>'productservice')) }}
                        </div>
                    </div>

                    <div class="row mt-1{{ $errors->has('productservicecode') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Product Service Name</label>
                        <div class="col-sm-6">
                            {{--                                {{ Form::select('productservicecode', array('placeholder'=>'select','required' => 'required','id' => 'productservicecode')) }}--}}
                            {{ Form::select('productservicecode',$productservicecode,$productservicecodes   , array('required' => 'required','id' => 'productservicecode')) }}
                        </div>
                    </div>
                </div>

                <div class="row mt-1{{ $errors->has('subcategorydescription') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Sub Category Description</label>
                    <div class="col-sm-6">
                        {{ Form::textarea('subcategorydescription', null, array('rows'=>3,'class' => 'form-control form-control-sm')) }}
                    </div>
                </div>

                <div class="row mt-1{{ $errors->has('calleremail') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Is Active</label>
                    <div class="col-sm-6">
                        {{ Form::select('isactive', array('select'=>'--SELECT--','1' => 'Yes','0' => 'No'),null, array('placeholder' => 'select','required' => 'required', 'class' => 'form-control form-control-sm', 'id' => 'category', 'rel' => URL::to('/'))) }}
                        @if ($errors->has('calleremail'))
                            <span class="help-block"><strong>{{ $errors->first('calleremail') }}</strong></span>
                        @endif
                    </div>
                </div>

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


@endsection


@section('page-script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#productservice').selectize({
                maxItems: 1
            });
            $('#productservicecode').selectize({
                maxItems: 1
            });
        });
    </script>

@stop
