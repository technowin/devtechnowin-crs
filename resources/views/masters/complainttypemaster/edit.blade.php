@extends('layouts.appnew')

@section('page-title', '| Complaint Types')

@section('content')

    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Panel title</h3>
            </div>
            <div class="panel-body">
                <div class="container">
                    {{ Form::model($complainttypemaster, array('route' => array('complainttypes.update', $complainttypemaster->complaintcode), 'method' => 'PUT')) }}
                    <div class="row{{ $errors->has('complaintname') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Complaint Name</label>
                        <div class="col-sm-6">
                            {{ Form::text('complaintname', null, array('class' => 'form-control form-control-sm')) }}
                        </div>
                    </div>
                    <div class="row mt-1{{ $errors->has('complaintdescription') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Complaint Description</label>
                        <div class="col-sm-6">
                            {{ Form::textarea('complaintdescription', null, array('rows'=>3,'class' => 'form-control form-control-sm')) }}
                        </div>
                    </div>
                    <br>
                    <div class="row mt-1{{ $errors->has('isactive') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Is Active</label>
                        <div class="col-sm-6">
                            {{ Form::select('isactive', array('select'=>'--SELECT--','1' => 'Yes','0' => 'No'),null, array('placeholder' => 'select','required' => 'required', 'id' => 'isactive')) }}
                            @if ($errors->has('calleremail'))
                                <span class="help-block"><strong>{{ $errors->first('calleremail') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <br>
                    <div class="row mt-1{{ $errors->has('calleremail') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted"></label>
                        <div class="col-sm-6">
                            {{ Form::submit('Submit', array('class' => 'btn btn-primary')) }}
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
            $('#isactive').selectize({
                maxItems: 1
            });
        });
    </script>
@stop