@extends('layouts.appnew')

@section('pageTitle', 'User Lodged Complaints')

@section('page-css')
    <link href="{{ asset('datatable/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
@stop

<div class="panel panel-default">
    <div class="panel-body">
        <div class="col-md-12 row">
            <div class="col-md-10"><h6>Category Master</h6></div>
            <div class="col-md-2">
                {{--<a class="btn btn-blue" data-toggle="modal" data-target=".bs-example-modal-lg"><b>Add New--}}
                {{--Customer</b></a>--}}
                <a  class="btn btn-blue" data-toggle="modal" data-target=".bs-example-modal-lg"> <b>Add New
                        Category</b></a>
            </div>
        </div>
    </div>
</div>
@section('content')

    @if (session('flash_message'))
        <div class="alert alert-success">
            {{ session('flash_message') }}
        </div>
    @endif


    <div class="panel panel-default">
        <div class="panel-body">
            <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr class="text-muted">
                    {{--<th>#</th>--}}

                    <th>Category Name</th>
                    <th>Category Description</th>
                    <th>Product Service</th>
                    <th>Is Active</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($categorys as $key => $category)
                    <tr>
                        {{--<th scope="row">{{$key+1}}</th>--}}
{{--                        <td>{{ $category->products->productservicename or 'NA' }}</td>--}}
                        <td>{{ $category->categoryname }}</td>
                        <td>{{ $category->categorydescription }}</td>
                        <td>{{ $category->products->productservicename or 'NA' }}</td>
                        <td>{{ $category->isactive == 1 ? "Yes" : "No" }}</td>
                        <td>
                            <a href="{{ route('category.show', ['id' => $category->categorycode]) }}">view</a> |
                            <a href="{{ route('category.edit', ['id' => $category->categorycode]) }}">edit</a>
                            {{--<a href="{{ URL::to('deletecategory',array($category->categorycode))}}">delete</a>--}}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $categorys->links() }}
        </div>
    </div>

    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
        <div class="modal-dialog" role="document">
            {{ Form::open(array('action' => 'Masters\CategoryMasterController@store')) }}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="gridSystemModalLabel">Create Category</h4>
                </div>
                <div class="modal-body">

                    <div class="row mt-1{{ $errors->has('categoryname') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Category Name</label>
                        <div class="col-sm-6">
                            {{ Form::text('categoryname', '', array('class' => 'form-control form-control-sm','required' => 'required')) }}
                            @if ($errors->has('categoryname'))
                                <span class="help-block"><strong>{{ $errors->first('categoryname') }}</strong></span>
                            @endif
                        </div>
                    </div>

                    <div class="row mt-1{{ $errors->has('productservicecode') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Product Service Name</label>
                        <div class="col-sm-6">
                            {{ Form::select('productservicecode', array(''=>'--SELECT--') + $productservicecode, null, array('required' => 'required','id'=>'productservicecode')) }}
                            @if ($errors->has('productservicecode'))
                                <span class="help-block"><strong>{{ $errors->first('productservicecode') }}</strong></span>
                            @endif
                        </div>
                    </div>

                    <div class="row mt-1{{ $errors->has('categorydescription') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Category Description</label>
                        <div class="col-sm-6">
                            {{ Form::textarea('categorydescription', '', array('rows'=>3,'class' => 'form-control form-control-sm')) }}
                            @if ($errors->has('categorydescription'))
                                <span class="help-block"><strong>{{ $errors->first('categorydescription') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <br>

                    <div class="row mt-1{{ $errors->has('isactive') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Is Active</label>
                        <div class="col-sm-6">
                            {{ Form::select('isactive', array('select'=>'--SELECT--','1' => 'Yes','0' => 'No'),null, array('placeholder' => 'select','required' => 'required', 'id' => 'isactive')) }}
                            @if ($errors->has('isactive'))
                                <span class="help-block"><strong>{{ $errors->first('isactive') }}</strong></span>
                            @endif
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        {{ Form::submit('submit', array('class' => 'btn btn-primary col-md-offset-9')) }}
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
                </div>

                <div class="modal-body">
                    <p>You are about to delete one track, this procedure is irreversible.</p>
                    <p>Do you want to proceed?</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger btn-ok">Delete</a>
                    <a href="" class="btn btn-danger btn-ok">Delete</a>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('selectize-script')
    <script src="{{asset('datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('datatable/js/dataTables.bootstrap.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('#example').DataTable();
        });
    </script>

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
@endsection