@extends('layouts.appnew')

@section('page-title', '| Add User')

@section('content')


    <div class="panel panel-default">
        <div class="panel-heading"> Edit Product Service</div>
        <div class="panel-body">
            <div class="container">
                {{ Form::model($productservicesmaster , array('route' => array('productservice.update', $productservicesmaster->productservicecode), 'method' => 'PUT')) }}

                <div class="row{{ $errors->has('sectorname') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Sector Name</label>
                    <div class="col-sm-6">
                        {{ Form::select('sector', $sector, $sectorcode, array('placeholder' => 'select','required' => 'required', 'id'=>'sectorcode' )) }}
                    </div>

                </div>

                <div class="row{{ $errors->has('productservicename') ? ' has-error' : '' }}" style="padding-bottom: 5px;">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Product Service Name</label>
                    <div class="col-sm-6">
                        {{ Form::text('productservicename', null, array('class' => 'form-control form-control-sm')) }}
                    </div>

                </div>

                <div class="row{{ $errors->has('productservicedescription') ? ' has-error' : '' }}" style="padding-bottom: 5px;">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Product Service Description</label>
                    <div class="col-sm-6">
                        {{ Form::textarea('productservicedescription', null, array('rows'=>3,'class' => 'form-control form-control-sm')) }}
                    </div>

                </div>
                <br>
                <div class="row{{ $errors->has('calleremail') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Is Active</label>
                    <div class="col-sm-6">
                        {{ Form::select('isactive', array('select'=>'--SELECT--','1' => 'Yes','0' => 'No'),null, array('placeholder' => 'select','required' => 'required', 'id' => 'isactive', 'rel' => URL::to('/'))) }}
                        @if ($errors->has('calleremail'))
                            <span class="help-block"><strong>{{ $errors->first('calleremail') }}</strong></span>
                        @endif
                    </div>
                </div>
                <br>

                <div class="row{{ $errors->has('calleremail') ? ' has-error' : '' }}">
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
    <script src="{{ asset('assets/Selectize/jquery-1.10.2.js') }}"></script>
    <script src="{{ asset('assets/Selectize/js/standalone/selectize.js') }}"></script>
    <script>

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

	