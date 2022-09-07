@extends('layouts.appnew')

@section('title', '| Roles')

@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-md-12 row">
                <div class="col-md-10"><h6>Available Roles</h6></div>
                <div class="col-md-2">
                    <a class="btn btn-blue" data-toggle="modal" data-target=".bs-example-modal-lg"> <b>Add New Role</b>
                    </a>
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
                    <th>role name</th>
                    <th>description</th>
                    <th>created_at</th>
                    <th>updated_at</th>
                    <th>action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($roles as $key => $role)
                    <tr>
                        <th scope="row">{{$key+1}}</th>
                        <td>{{ $role->name }}</td>
                        <td>{{ $role->description }}</td>
                        <td>{{ is_null($role->created_at) ? '' : $role->created_at->format('m-d-Y') }}</td>
                        <td>{{ is_null($role->updated_at) ? '' : $role->updated_at->format('m-d-Y') }}</td>
                        <td>
                            <a target="_blank" href="{{ url('viewrole/'.$role->id) }}">view</a> |
                            <a target="_blank" href="{{ url('editrole/'.$role->id) }}">edit</a>
                            {{--<a href="#" data-href="{{ url('deleterole/'.$role->id) }}" data-toggle="modal"--}}
                               {{--data-target="#confirm-delete">delete</a>--}}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $roles->links() }}
        </div>
    </div>

    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="gridSystemModalLabel">Create Role</h4>
                </div>
                <div class="modal-body">
                    {{ Form::open(array('action' => 'RoleController@store')) }}
                    <div class="row">
                        <div class="col-md-6">
                            <label for="input" class="col-form-label text-muted">Role Name</label>
                            {{ Form::text('name', '', array('class' => 'form-control','required' => 'required')) }}
                            @if ($errors->has('name'))
                                <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    {{ Form::submit('submit', array('class' => 'btn btn-primary col-md-offset-9')) }}
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
                </div>
            </div>
        </div>
    </div>

@endsection
@section('page-script')
    <script>
        $('#confirm-delete').on('show.bs.modal', function (e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        });
    </script>
@stop