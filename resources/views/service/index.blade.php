@extends('layouts.appnew')

@section('page-title', '| Branch Master')

@section('content')

    @if($equipmentnull == null)
        <h3>There is no equipment to view</h3>
    @else
        <div type="container">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row col-md-12">
                        {{ Form::open(array('url' => 'storeequipment','files' => true)) }}
                        {{ Form::hidden('contractno',$id,array('id'=>'contractid')) }}
                        {{ Form::hidden('equipementsrno',$equipementid,array('id'=>'equipementsrnoid')) }}
                        <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr class="text-muted">
                                {{--<th>#</th>--}}
                                <th>Product Sr No</th>
                                <th>Product Name</th>
                                <th>Caegory Name</th>
                                <th>Specification</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($equipment as$key => $equip)
                                <tr>
                                    {{--<th scope="row">{{$key+1}}</th>--}}
                                    {{--<td><input type="text" name="equipmentsrno" value="TExt"> </td>--}}
                                    <td>{{ $equip->equipmentsrno }}</td>
                                    <td>{{ $equip->products->productservicename }}</td>
                                    <td>{{ $equip->category->categoryname }}</td>
                                    <td>{{ $equip->specification }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        {{ Form::close() }}
                    </div>
                </div>
            </div>
            {{ Form::submit('Save & Close', array('class' => 'btn btn-primary', 'id' => 'btnSubmit')) }}
        </div>
    @endif
    <br>
    <a class="btn btn-default" href="{{url()->previous()}}">Back</a>


@endsection



@section('page-script')
    <script>
        $("#btnSubmit").on('click', function () {
            this.disabled = true;
            var table = document.getElementById('example');
            var rowCount = table.rows.length;
            var selectedIds = [];
            for (var i = 1; i < rowCount; i++) {
                var test = table.rows[i].innerText;
                var newString = test.replace(/\s+/g,' ').split(" ");
//                var strSplit = newString.split(" ");
                selectedIds.push(newString[0]);
            }
            request = $.ajax({
                url:'{{ url('/storeequipment/{data}') }}/',
                method: "get",
                dataType: "json",
                data: {
                    contractcode: $("#contractid").val(),
                    equipmentsvalue: selectedIds,
                    equipmentsrno:$("#equipementsrnoid").val(),
                },
                success: function (data) {
                    window.location.href = '{{URL::to('pendingservice')}}'
                }
            });
        });

    </script>

@stop
