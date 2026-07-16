@extends('layouts.appnew')

@section('page-title', '| Product Service Master')

@section('page-css')
    <link href="{{ asset('datatable/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
@stop

@section('content')

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-md-12 row">
                <div class="col-md-10"><h6>Product Service Master</h6></div>
                <div class="col-md-2">
                    <a class="btn btn-blue" data-toggle="modal" data-target=".bs-example-modal-lg"> <b>Add New Product
                            Service Master</b></a>
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

                    <th>Product Service Name</th>
                    <th>Product Service Description</th>
                    <th>Sector Name</th>
                    <th>Is Active</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($productservices as $key => $productservice)
                    <tr>
                        {{--<th scope="row">{{$key+1}}</th>--}}

                        <td>{{ $productservice->productservicename }}</td>
                        <td>{{ $productservice->productservicedescription }}</td>
                        <td>{{ $productservice->Sector->sectorname }}</td>
                        <td>{{ $productservice->isactive == 1 ? "Yes" : "No" }}</td>
                        <td>
                            <a href="{{ route('productservice.show', ['id' => $productservice->productservicecode]) }}">view</a>
                            |
                            <a href="{{ route('productservice.edit', ['id' => $productservice->productservicecode]) }}">edit</a>
                            {{--|--}}
                            {{--<a href="{{ URL::to('deleteproductservice',array($productservice->productservicecode))}}">delete</a>--}}

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $productservices->links() }}
        </div>
    </div>



    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
        <div class="modal-dialog" role="document">
            {{ Form::open(array('action' => 'Masters\ProductServiceMasterController@store')) }}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="gridSystemModalLabel">Create Product </h4>
                </div>
                <div class="modal-body">

                    <div class="row{{ $errors->has('sectorcode') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Sector Name </label>
                        <div class="col-sm-6">
                            {{ Form::select('sectorcode', array(''=>'--SELECT--') + $sectorcode, null, array('required' => 'required','id'=>'sectorcode')) }}
                            {{--{{ Form::select('sectorscode', $sectorscode, null, array('placeholder' => 'select','required' => 'required', 'id'=>'sectorcode')) }}--}}
                            @if ($errors->has('sectorcode'))
                                <span class="help-block"><strong>{{ $errors->first('sectorcode') }}</strong></span>
                            @endif
                        </div>
                    </div>

                    <div class="row{{ $errors->has('productservicename') ? ' has-error' : '' }}" style="padding-bottom: 5px;">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Product Service Name</label>
                        <div class="col-sm-6">
                            {{ Form::text('productservicename', '', array('class' => 'form-control form-control-sm','required' => 'required')) }}
                            @if ($errors->has('productservicename'))
                                <span class="help-block"><strong>{{ $errors->first('productservicename') }}</strong></span>
                            @endif
                        </div>
                    </div>


                    <div class="row{{ $errors->has('productservicedescription') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Product Service Description</label>
                        <div class="col-sm-6">
                            {{ Form::textarea('productservicedescription', '', array('rows'=>3,'class' => 'form-control form-control-sm','required' => 'required')) }}
                            @if ($errors->has('productservicedescription'))
                                <span class="help-block"><strong>{{ $errors->first('productservicedescription') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <br>
                    <div class="row{{ $errors->has('isactive') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Is Active</label>
                        <div class="col-sm-6">
                            {{ Form::select('isactive', array('select'=>'--SELECT--','1' => 'Yes','0' => 'No'),null, array('placeholder' => 'select','required' => 'required',  'id' => 'isactive', 'rel' => URL::to('/'))) }}
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
        $('#confirm-delete').on('show.bs.modal', function (e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#sectorcode').selectize({
                maxItems: 1
            });
            $('#isactive').selectize({
                maxItems: 1
            });
        });
    </script>
@stop
	