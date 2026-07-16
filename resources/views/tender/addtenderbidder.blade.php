@extends('layouts.appnew')
@section('pageTitle', 'Add Tender Bid Details')
@section('content')
    <div class="container card col-md-9">
        <div class="col card-block">
            <div class="container">
                <br>
                {{ Form::open(array('url' => 'addtenderbidder/'.$id)) }}

                <div class="panel-body">
                    <div class="row" style="border-bottom: 1px solid darkgray">
                        <div class="col-md-6"><h2 class="card-title text-muted">Add Tender Bid Details</h2></div>

                    </div>
                    <div class="panel-body">
                        <br/>

                        <div class="row col-md-12">
                            <div class="col-md-6"><h4> Tender </h4></div>
                            <div class="col-md-6">
                                {{Form::text('text',$tenderdetails->tenderno,array('class' => 'form-control','readonly'))}}
                            </div>
                        </div>

                        <div class="row col-md-12" style="margin-top: 5px;">
                            <div class="col-md-6"><h4>Organisation Name</h4></div>
                            <div class="col-md-6">
                                {{Form::text('text',$tenderdetails->organisationname,array('class' => 'form-control','readonly'))}}
                            </div>
                        </div>

                        <div class="row col-md-12" style="margin-top: 5px;">
                            <div class="col-md-6"><h4>Subject</h4></div>
                            <div class="col-md-6">
                                {{Form::text('text',$tenderdetails->subject,array('class' => 'form-control','readonly'))}}
                            </div>
                        </div>

                        <div class="panel col-md-12" style="border: silver 1px solid; margin-top: 15px;">
                            <div class="panel-body">
                                <div class="row mt-1">
                                    {{Form::hidden('bidderid[]','0')}}
                                    {{Form::hidden('incrementid','1',array('id'=>'incrementclaculationid'))}}
                                    <div class="col-sm-4 col-form-label text-muted">Company Name</div>
                                    <div class="col-md-6">{{Form::text('nameofbidder[]',null,array('class' => 'form-control','required' => 'required'))}}</div>
                                    <div class="col-md-4"></div>
                                </div>
                            </div>
                            <div id="addcomponent_0" style="margin-top: 15px;">
                            </div>
                            <div class="row" style="margin-left:13px;">
                                <a href="#" id="addmultiplebiddetails" onclick="AddComponent(0); return false;">Add
                                    Component</a>
                            </div>

                            <div class="col-md-2"
                                 style="margin-top:25px;margin-left:630px;width:200px;margin-bottom: 15px;">Total Amt
                                {{ Form::text('totalamt[]', null, ['id'=>'totalamtid_0','class' => 'form-control','readonly']) }}</div>
                        </div>
                    </div>
                    <input type="hidden" id="incrementid" value="1">
                    <div id="addcontractsitemaster">
                    </div>
                    <input style="margin-top: 10px;" href="javascript:void(0);" type="button" value="Add Company"
                           onclick="addbiddernamediv(); return false;">
                    <div class="row">
                        <label for="input" class="col-sm-3 col-form-label-sm text-muted"></label>
                        <div class="col-sm-6">
                            {{ Form::submit('Save & Close', array('class' => 'btn btn-primary')) }}
                        </div>
                    </div>
                </div>

                {{ Form::close() }}
            </div>
        </div>
    </div>

@endsection

@section('selectize-script')
    <script type="text/javascript" src="{{ asset('js/jquery-3.1.1.js') }}"></script>
    {{--<script type="text/javascript" src="dist/js/jquery-2.1.1.min.js"></script>--}}
    <script type="text/javascript">
        function addbiddernamediv() {
            var count = $('#incrementid').val();
            var wrapper = $('#addcontractsitemaster');
            var addButton = $('#addcontractsitemastersdiv');
            var appendtags = '<div><a  href="javascript:void(0);" class="remove_button" title="Remove field"><img src="{{asset('img/cancel-512.png')}}" style="height: 20px; width: 20px; margin-left:910px;"/></a><div class="panel col-md-12" style="border: silver 1px solid;"><div class="panel-body"><div class="row mt-1">' +
                '<div class="row" style="margin-top:5px;">{{Form::hidden('incrementid','1',array('id'=>'incrementclaculationid'))}} <label for="input" class="col-sm-4 col-form-label text-muted">Company Name</label> <div class="col-sm-6"> ' +
                '{{ Form::text('nameofbidder[]', null, array('class' => 'form-control form-control-sm', 'id' => 'branchid','required' => 'required')) }} </div> </div> ' +
                '{{Form::hidden('bidderid[]','asdsadas',array('class'=>'saveid'))}}</td></tr>'.replace('asdsadas', count) +
                '<div class="row" style="margin-top:5px;"><label for="input" class="col-sm-4 col-form-label text-muted">' +
                '</div><div id="addcomponent_' + count + '"></div>'+
                '<a href="#" id="addmultiplebiddetails" onclick="AddComponent(' + count + '); return false;">Add Component</a></label><div></div>' +
                '<div class="col-md-2" style="margin-top:25px;margin-left:630px;width:200px;">Total Amt : {{ Form::text('totalamt[]', null, ['id'=>'totalamtid_%count%','class' => 'form-control','readonly']) }}</div>'.replace('%count%',count)+
                '</div>';
            $(addButton).click(function () { //Once add button is clicked
                $(wrapper).append(appendtags); // Add field html
            });
            $(wrapper).on('click', '.remove_button', function (e) { //Once remove button is clicked
                $(this).parent('div').remove(); //Remove field html
            });
            $('#addcontractsitemaster').append(appendtags);
            count = parseInt(count) + 1;
            $('#incrementid').val(count);
        }

        function AddComponent(id) {
            debugger
            var wrapper = $('#addcomponent_' + id);
            var count = id;
            var incrementid = $('#incrementclaculationid').val();
            var html = '<div><a  href="javascript:void(0);" class="remove_component" title="Remove field"><img src="{{asset('img/cancel-512.png')}}" style="height: 20px; width: 20px;"/></a><div class="panel col-md-12" style="border: silver 1px solid;"><div class="panel-body"><div class="row mt-1">' +
                '{{Form::hidden('classid[]','asdsadas',array('class'=>'saveid'))}}'.replace('asdsadas', id) +
                '<div class="col-md-3">Component Name</div><div class="col-md-3">QTY</div><div class="col-md-3">Rate</div><div class="col-md-3">Amt</div></div>' +
                '<div class="row col-md-12">'+
                '<div class="col-md-3">{{ Form::text('component[]', null, array('class' => 'form-control', 'id' => 'componentid','required' => 'required')) }}</div>'+
                {{--'<div class="col-md-3">{{ Form::text('noofquantity[]', null, array('class' => 'form-control form-control-sm', 'id' => 'noofquantityid','required' => 'required')) }}</div>'+--}}
                    '<div class="col-md-3"><input type="text" class="form-control" name="noofquantity[]" id="textone_%id%" onchange="totalcal(%count%); return false"></div>'.replace('%id%',incrementid).replace('%count%',incrementid)+
                {{--'<div class="col-md-3">{{ Form::text('perunitrate[]', null, array('class' => 'form-control form-control-sm', 'id' => 'perunitrateid','required' => 'required')) }}</div>'+--}}
                '<div class="col-md-3"><input type="text" class="form-control" name="perunitrate[]" id="texttwo_%id%" onchange="totalcal(%count%); return false"></div>'.replace('%id%',incrementid).replace('%count%',incrementid)+
                '<div class="col-md-3">{{ Form::text('bidamount[]', null, array('class' => 'form-control bidamountid_%count% totalcountofbiamtclassid_%totalcountofbiamtclassid%','required' => 'required','onkeyup'=>'tallytotalamt(%id%);','readonly')) }}</div>'.replace('%count%',incrementid).replace('%id%',count).replace('%totalcountofbiamtclassid%',id)+
                '</div></div></div>';
            $(html).click(function () {
                $(wrapper).append(html);
            });
            $(wrapper).on('click', '.remove_component', function (e) { //Once remove button is clicked
                debugger
                $(this).parent('div').remove();
            });
            $('#addcomponent_' + id).append(html);
            incrementid = parseInt(incrementid) + 1;
            $('#incrementclaculationid').val(incrementid);

        }
    </script>
    <script type="text/javascript">
        function tallytotalamt(id) {
            debugger
            var sum = 0;
            var cost = $('.totalcountofbiamtclassid_'+id);
            for (var i = 0; i < cost.length; i++) {
                sum += parseFloat(cost[i].value);
            }
            document.getElementById('totalamtid_'+id).value = sum;
        }

    </script>
    <script type="text/javascript">
        function totalcal(id) {
            debugger
            var textone;
            var texttwo;
            textone = parseFloat($('#textone_'+id).val());
            texttwo = parseFloat($('#texttwo_'+id).val());
            var result = textone * texttwo;
            if(result > 0)
            {
                $('.bidamountid_'+id).val(result.toFixed(.00));
            }
            else
            {
                $('.bidamountid_'+id).val(0);
            }
        }
    </script>


@endsection
