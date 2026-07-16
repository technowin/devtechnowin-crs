@extends('layouts.appnew')

@section('page-title', '| Sub-Category')
@section('page-css')
    <link href="{{ asset('datatable/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
@stop
@section('content')

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-md-12 row">
                <div class="col-md-10"><h6>Sub-Category Master</h6></div>
                <div class="col-md-2">
                    <a class="btn btn-blue" data-toggle="modal" data-target=".bs-example-modal-lg"> <b>Add New
                            Sub-Category</b></a>
                </div>
            </div>
        </div>
    </div>

    @if (session('flash_message'))
        <div class="alert alert-success">
            {{ session('flash_message') }}
        </div>
    @endif

    <div class="panel panel-default">
        <div class="panel-body table-responsive">
            <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr class="text-muted">
                    {{--<th>#</th>--}}
                    {{--<th>Category Code</th>--}}

                    <th>Sub Category Name</th>
                    <th>Sub Category Description</th>
                    <th>Category Name</th>
                    <th>Product Service</th>
                    <th>Is Active</th>
                    {{--<th>created_at</th>--}}
                    {{--<th>updated_at</th>--}}
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                {{--{{ dd($subcategorys) }}--}}
                {{--                @foreach($subcategorys as $key => $subcategory)--}}
                @for($i=0; $i<$count; $i++)
                    <tr>
                        {{--<th scope="row">{{$key+1}}</th>--}}

                        <td>{{ $subcategorys[$i]->subcategoryname }}</td>
                        <td>{{ $subcategorys[$i]->subcategorydescription }}</td>
                        <td>{{ $subcategorys[$i]->category->categoryname or 'NA' }}</td>
                        <td>{{ $subcategorys[$i]->productservicename or 'NA' }}</td>
                        <td>{{ $subcategorys[$i]->isactive == 1 ? "Yes" : "No" }}</td>
                        <td>
                            <a  href="{{ route('subcategory.show', ['id' => $subcategorys[$i]->subcategorycode]) }}">view</a> |
                            <a  href="{{ route('subcategory.edit', ['id' => $subcategorys[$i]->subcategorycode]) }}">edit</a>
                            {{--<a href="{{ URL::to('deletesubcategory',array($subcategory->subcategorycode))}}">delete</a>--}}
                            {{--<a href="#" data-href="{{ route('subcategory.destroy', ['id' => $subcategory->subcategorycode]) }}" data-toggle="modal" data-target="#confirm-delete">delete</a>--}}
                        </td>

                    </tr>
                @endfor
                </tbody>
            </table>
            {{--            {{ $subcategorys->links() }}--}}
        </div>
    </div>

    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
        <div class="modal-dialog" role="document">
            {{ Form::open(array('action' => 'Masters\SubCategoryMasterController@store')) }}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="gridSystemModalLabel">Create Sub-Category</h4>
                </div>
                <div class="modal-body">

                    <div class="row mt-1{{ $errors->has('subcategoryname') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Sub Category Name</label>
                        <div class="col-sm-6">
                            {{ Form::text('subcategoryname', '', array('class' => 'form-control form-control-sm','required' => 'required')) }}
                            @if ($errors->has('subcategoryname'))
                                <span class="help-block"><strong>{{ $errors->first('subcategoryname') }}</strong></span>
                            @endif
                        </div>
                    </div>

                    <div class="row mt-1{{ $errors->has('subcategoryname') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Category Name</label>
                        <div class="col-sm-6">
                            {{ Form::select('Categorycode', $Categorycode, null, array('placeholder' => 'select','required' => 'required', 'id' => 'Categorycode')) }}
                            @if ($errors->has('sectordescription'))
                                <span class="help-block"><strong>{{ $errors->first('subcategoryname') }}</strong></span>
                            @endif
                        </div>
                    </div>

                    <div class="row mt-1{{ $errors->has('subcategorydescription') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Sub Category Description</label>
                        <div class="col-sm-6">
                            {{ Form::textarea('subcategorydescription', '', array('rows'=>3,'class' => 'form-control form-control-sm','required' => 'required')) }}
                            @if ($errors->has('subcategorydescription'))
                                <span class="help-block"><strong>{{ $errors->first('subcategorydescription') }}</strong></span>
                            @endif
                        </div>
                    </div>

                    <div class="row mt-1{{ $errors->has('isactive') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Is Active</label>
                        <div class="col-sm-6">
                            {{ Form::select('isactive', array('select'=>'--SELECT--','1' => 'Yes','0' => 'No'),null, array('placeholder' => 'select','required' => 'required','id' => 'isactive')) }}
                            @if ($errors->has('isactive'))
                                <span class="help-block"><strong>{{ $errors->first('isactive') }}</strong></span>
                            @endif
                        </div>
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
                </div>
            </div>
        </div>
    </div>

@endsection

@section('page-script')
    <script src="{{asset('datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('datatable/js/dataTables.bootstrap.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('#example').DataTable();
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#isactive').selectize({
                maxItems: 1
            });
            $('#Categorycode').selectize({
                maxItems: 1
            });
        });
    </script>
@stop
