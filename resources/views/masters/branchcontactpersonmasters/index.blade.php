@extends('layouts.appnew')

@section('page-title', '| Branch Master')

@section('content')

@section('page-css')
    <link href="{{ asset('datatable/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
@stop
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-md-12 row">
                <div class="col-md-10"><h6>Branch Contact Person Master</h6></div>
                <div class="col-md-2">
                    <a class="btn btn-blue" data-toggle="modal" data-target=".bs-example-modal-lg"> <b>Add New Branch Contact Person</b></a>
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
                    <th>Branch Contact Name</th>
                    <th>Branch Name</th>
                    {{--<th>contact Person </th>--}}
                    <th>Phone </th>
                    <th>Fax</th>
                    <th>Email</th>
                    <th>Desingnation</th>
                    {{--<th>created_at</th>--}}
                    {{--<th>updated_at</th>--}}
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($branches as $key => $branch)
                    <tr>
                        {{--<th scope="row">{{$key+1}}</th>--}}
                        <td>{{ $branch->contactpersonname }}</td>
                        <td>{{ $branch->Branach->branchname }}</td>
                        {{--<td>{{ $branch->contactpersonname }}</td>--}}
                        <td>{{ $branch->phone }}</td>
                        <td>{{ $branch->fax }}</td>
                        <td>{{ $branch->emailid }}</td>
                        <td>{{ $branch->designation }}</td>
                        {{--<td>{{ is_null($branch->created_at) ? '' : $branch->created_at->format('m-d-Y') }}</td>--}}
                        {{--<td>{{ is_null($branch->updated_at) ? '' : $branch->updated_at->format('m-d-Y') }}</td>--}}
                        <td>
                            <a target="_blank" href="{{ route('branchescontactperson.show', ['id' => $branch->branchcontactcode]) }}">view</a> |
                            <a target="_blank" href="{{ route('branchescontactperson.edit', ['id' => $branch->branchcontactcode]) }}">edit</a> |
                            <a target="_blank" href="{{ URL::to('deletebranchcontact',array($branch->branchcontactcode))}}">delete</a>
                            {{--<a href="#" data-href="{{ route('branchescontactperson.destroy', ['id' => $branch->branchcontactcode]) }}" data-toggle="modal" data-target="#confirm-delete">delete</a>--}}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $branches->links() }}
        </div>
    </div>

    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
        <div class="modal-dialog" role="document">
            {{ Form::open(array('action' => 'Masters\BranchContactMasterController@store')) }}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="gridSystemModalLabel">Create Branch Contact Person</h4>
                </div>
                <div class="modal-body">

                    <div class="row mt-1">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Branch Person Name</label>
                        <div class="col-sm-6">
                            {{ Form::text('contactpersonname', '', array('class' => 'form-control','required' => 'required')) }}
                            @if ($errors->has('contactpersonname'))
                                <span class="help-block"><strong>{{ $errors->first('contactpersonname') }}</strong></span>
                            @endif
                        </div>
                    </div>

                    <div class="row mt-1">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Branch Name</label>
                        <div class="col-sm-6">
                            {{ Form::select('branchmastercode', $branchmastercode, null, array('placeholder' => 'select','required' => 'required','id'=>'branchmastercode')) }}
                            @if ($errors->has('contactpersonname'))
                                <span class="help-block"><strong>{{ $errors->first('contactpersonname') }}</strong></span>
                            @endif
                        </div>
                    </div>

                    <div class="row mt-1">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Designation</label>
                        <div class="col-sm-6">
                            {{ Form::text('designation', '', array('class' => 'form-control','required' => 'required')) }}
                            @if ($errors->has('designation'))
                                <span class="help-block"><strong>{{ $errors->first('designation') }}</strong></span>
                            @endif
                        </div>
                    </div>

                    <div class="row mt-1{{ $errors->has('fax') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Fax</label>
                        <div class="col-sm-6">
                            {{ Form::text('fax', '', array('class' => 'form-control form-control-sm','onKeyPress'=>'if(this.value.length==12) return false;')) }}
                            @if ($errors->has('fax'))
                                <span class="help-block"><strong>{{ $errors->first('fax') }}</strong></span>
                            @endif
                        </div>
                    </div>

                    <div class="row mt-1{{ $errors->has('phone') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Phone</label>
                        <div class="col-sm-6">
                            {{ Form::number('phone', '', array('class' => 'form-control form-control-sm','onKeyPress'=>'if(this.value.length==10) return false;')) }}
                            @if ($errors->has('emailid'))
                                <span class="help-block"><strong>{{ $errors->first('phone') }}</strong></span>
                            @endif
                        </div>
                    </div>

                    <div class="row mt-1{{ $errors->has('emailid') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Email</label>
                        <div class="col-sm-6">
                            {{ Form::email('emailid', '', array('class' => 'form-control form-control-sm','required' => 'required')) }}
                            @if ($errors->has('emailid'))
                                <span class="help-block"><strong>{{ $errors->first('emailid') }}</strong></span>
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
    <script type="text/javascript">
        $('#confirm-delete').on('show.bs.modal', function (e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#branchmastercode').selectize({
                maxItems: 1
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#example').DataTable();
        });
    </script>
@stop