@extends('layouts.appnew')

@section('page-title', 'ComplaintTypes')

@section('content')

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-md-12 row">
                <div class="col-md-10"><h6>Complaint Types</h6></div>
                <div class="col-md-2">
                    <a class="btn btn-blue" data-toggle="modal" data-target=".bs-example-modal-lg"> <b>Add New Complaint
                            Type</b></a>
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
            <table class="table table-sm table-hover">
                <thead>
                <tr class="text-muted">
                    <th>#</th>
                    <th>Complaint Code</th>
                    <th>Complaint Name</th>
                    <th>Complaint Description</th>
                    <th>Is Active</th>
                    {{--<th>created_at</th>--}}
                    {{--<th>updated_at</th>--}}
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($complaintypes as $key => $complaintype)
                    <tr>
                        <th scope="row">{{$key+1}}</th>
                        <td>{{ $complaintype->complaintcode }}</td>
                        <td>{{ $complaintype->complaintname }}</td>
                        <td>{{ $complaintype->complaintdescription }}</td>
                        <td>{{ $complaintype->isactive }}</td>
                        {{--<td>{{ is_null($complaintype->created_at) ? '' : $complaintype->created_at->format('d-m-Y') }}</td>--}}
                        {{--<td>{{ is_null($complaintype->updated_at) ? '' : $complaintype->updated_at->format('d-m-Y') }}</td>--}}
                        <td>
                            <a href="{{ route('complainttypes.show', ['id' => $complaintype->complaintcode]) }}"
                               style="margin-right: 3px;">view</a>|
                            <a href="{{ route('complainttypes.edit', ['id' => $complaintype->complaintcode]) }}"
                               style="margin-right: 3px;">edit</a>
                            <a href="#"
                               data-href="{{ route('complainttypes.destroy', ['id' => $complaintype->branchcode]) }}"
                               data-toggle="modal" data-target="#confirm-delete">delete</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $complaintypes->links() }}
        </div>
    </div>

    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
        <div class="modal-dialog" role="document">
            {{ Form::open(array('action' => 'Masters\ComplaintTypeMaster@store')) }}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="gridSystemModalLabel">Create Complaint Type</h4>
                </div>
                <div class="modal-body">

                    <div class="row mt-1{{ $errors->has('branchname') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Complaint Name</label>
                        <div class="col-sm-6">
                            {{ Form::text('complaintname', '', array('class' => 'form-control form-control-sm','required' => 'required')) }}
                            @if ($errors->has('complaintname'))
                                <span class="help-block"><strong>{{ $errors->first('complaintname') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="row mt-1{{ $errors->has('complaintdescription') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Complaint Description</label>
                        <div class="col-sm-6">
                            {{ Form::textarea('complaintdescription', '', array('rows'=>3,'required' => 'required', 'class' => 'form-control form-control-sm',  'rel' => URL::to('/'),'required' => 'required')) }}
                            @if ($errors->has('complaintdescription'))
                                <span class="help-block"><strong>{{ $errors->first('complaintdescription') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <br>
                    <div class="row mt-1{{ $errors->has('calleremail') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Is Active</label>
                        <div class="col-sm-6">
                            {{ Form::select('isactive', array('select'=>'--SELECT--','1' => 'Yes','0' => 'No'),null, array('placeholder' => 'select','required' => 'required', 'id' => 'isactive')) }}
                            @if ($errors->has('calleremail'))
                                <span class="help-block"><strong>{{ $errors->first('calleremail') }}</strong></span>
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

@section('page-script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#isactive').selectize({
                maxItems: 1
            });
        });
    </script>
@endsection

