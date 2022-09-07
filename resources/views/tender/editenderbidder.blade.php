@extends('layouts.appnew')

@section('pageTitle', 'Edit Tender Bid Details')

@section('content')

    <br/>
    <div class="container card col-md-9">

        <div class="col card-block">
            <div class="row" style="border-bottom: 1px solid darkgray">
                <div class="col-md-6"><h2 class="card-title text-muted">Edit Tender Bid Details</h2></div>
            </div>

            <div class="row col-md-12" style="margin-top: 5px;">
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

            <div class="row col-md-12" style="margin-top: 5px;margin-bottom: 5px;">
                <div class="col-md-6"><h4>Subject</h4></div>
                <div class="col-md-6">
                    {{Form::text('text',$tenderdetails->subject,array('class' => 'form-control','readonly'))}}
                </div>
            </div>

            <div class="container">
                <br>
                {{ Form::open(array('url' => 'updatetenderbidder/'.$id,'files' => true)) }}
                @foreach($tenderbiddercompany as $key => $tendercompany)
                    {{ Form::hidden('savtendercompanyid[]', $tendercompany->id,array('class'=>'contractsitemasterclass')) }}
                    <div class="panel col-md-12" style="border: silver 1px solid;">
                        <div class="panel-body">
                            <div class="row{{ $errors->has('nameofbidder') ? ' has-error' : '' }}" style="padding: 3px">
                                <label for="input" class="col-sm-3 col-form-label-sm text-muted">Name of Bidder</label>
                                <div class="col-sm-6">
                                    {{ Form::text('nameofbidder[]', $tendercompany->companyname, array('class' => 'form-control')) }}
                                </div>

                            </div>
                            <div class="row col-md-12" style="margin-top: 15px;">
                                <div class="col-md-3">Component Name</div>
                                <div class="col-md-3">QTY</div>
                                <div class="col-md-3">Rate</div>
                                <div class="col-md-3">Amt</div>
                            </div>
                            <br>
                            @foreach($tenderbidderdetails as $kry => $tenderdetails)
                                @if($tendercompany->id == $tenderdetails->biddercompanynameid)
                                    <div class="row col-md-12">
                                        {{ Form::hidden('tenderdetailsaveid[]', $tenderdetails->id) }}
                                        {{ Form::hidden('biddercompanynameid[]', $tenderdetails->biddercompanynameid,array('class'=>'contractsitemasterclass')) }}
                                        <div class="col-md-3" style="margin-top: 5px;">{{ Form::text('component[]', $tenderdetails->component,array('class' => 'form-control form-control-sm')) }}</div>
                                        <div class="col-md-3"><input type="text" name="noofquantity[]" value="{{$tenderdetails->noofquantity}}" class="form-control" id="textone_{{$kry+1}}" onkeyup="totalcal({{$kry + 1}}); return false"></div>
                                        <div class="col-md-3"><input type="text" name="perunitrate[]" value="{{$tenderdetails->perunitrate}}" id="texttwo_{{$kry+1}}" onkeyup="totalcal({{$kry + 1}}); return false"> </div>
                                        <div class="col-md-3"><input type="text" class="form-control bidamountid_{{$kry+1}} sdkksdfhsdsjkfhs_{{$key+1}}" name="bidamount[]" value="{{$tenderdetails->bidamount +.00}}" onkeyup="tallytotalamt({{$key+1}}); return false;" readonly></div>
                                    </div>
                                @endif
                            @endforeach
                            <div class="col-sm-6">
                                <a href="#" id="addmultiplebiddetails" onclick="AddComponent({{$key + 1}}, '{{$tendercompany->id}}'); return false;">Add Component</a>
                            </div>
                        </div>
                        <div id="addcomponent_{{$key + 1}}"></div>
                        <div class="col-sm-3" style="margin-left: 660px;width:215px;margin-bottom: 10px;">
                            Total
                            Amt
                            {{--                            {{ Form::text('totalbidderamt[]', $tendercompany->totalbidderamt, array('class' => 'form-control','readonly', 'id'=>'totalofbiamtid_'+{{$key+1}} )) }}--}}
                            <input type="text" name="totalbidderamt[]" class="form-control" value="{{$tendercompany->totalbidderamt}}" id="totalofbiamtid_{{$key+1}}" readonly>
                        </div>
                        <br>
                    </div>
                @endforeach
                <input type="hidden" id="incrementcountid" value="101">
                <input type="hidden" id="incrementid" value="{{$key + 1}}">
                <div id="addcontractsitemaster">
                </div>
                <input href="javascript:void(0);" type="button" value="Add Company"
                       onclick="addbiddernamediv(); return false;">
                <div class="row">
                    <label for="input" class="col-sm-3 col-form-label text-muted"></label>
                    <div class="col-sm-3" style="margin-bottom: 50px;">
                        <br/>
                        {{ Form::submit('Save & Close', array('class' => 'btn btn-primary')) }}
                        <a style="margin-left: 50px;" type="button" class="btn btn-primary" href="{{ url('pdfreport/'.$id) }}">PDF</a>
                    </div>
                </div>
                <br>

                {{ Form::close() }}
            </div>
        </div>
    </div>
    </div>

@endsection


@section('selectize-script')
    <script type="text/javascript" src="{{ asset('js/jquery-3.1.1.js') }}"></script>
    {{--<script type="text/javascript" src="dist/js/jquery-2.1.1.min.js"></script>--}}
    <script type="text/javascript">
        function addbiddernamediv() {
            var mycount = $('#incrementid').val();
            var count = mycount + 1;
            var wrapper = $('#addcontractsitemaster');
            var addButton = $('#addcontractsitemastersdiv');
            var appendtags = '<div><a  href="javascript:void(0);" class="remove_button" title="Remove field"><img src="{{asset('img/cancel-512.png')}}" style="height: 20px; width: 20px; margin-left:910px;"/></a><div class="panel col-md-12" style="border: silver 1px solid;"><div class="panel-body"><div class="row mt-1">' +
                '<div class="row" style="margin-top:5px;"> <label for="input" class="col-sm-4 col-form-label text-muted">Company Name</label> <div class="col-sm-6"> ' +
                '{{ Form::text('nameofbidder[]', null, array('class' => 'form-control form-control-sm', 'id' => 'branchid','required' => 'required')) }} </div> </div> ' +
                '{{Form::hidden('bidderid[]','asdsadas',array('class'=>'saveid'))}}</td>{{ Form::hidden('savtendercompanyid[]', '0') }}</tr>'.replace('asdsadas', count) +
                '{{Form::hidden('incrementcountid','21',array('id'=>'incrementcountid'))}}'+
                '<div class="row" style="margin-top:5px;"><label for="input" class="col-sm-4 col-form-label text-muted">' +
//                '<a href="#" id="addmultiplebiddetails" onclick="AddComponent("' + count + ',' + "'dsfhsjkdafjksahfjk-hsdjkfhsdaf-dash_"+count+"'"+',' + count + '); return false;">Add Component</a></label><div class="col-sm-6"></div>' +
                '<a href="#" id="addmultiplebiddetails" onclick="AddComponent(' + count + ',' + "'dsfhsjkdafjksahfjk-hsdjkfhsdaf-dash_" + count + "'" + ');return false;">Add Component</a></label><div class="col-sm-6"></div>' +
                '</div><div id="addcomponent_' + count + '"></div>' +
                '<div class="col-md-2" style="margin-top:25px;margin-left:630px;width:200px;">Total Amt : {{ Form::text('totalbidderamt[]', null, ['id'=>'totalofbiamtid_%count%','class' => 'form-control','readonly']) }}</div>'.replace('%count%', count) +
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
        function AddComponent(id, bidderid) {
            debugger
            var wrapper = $('#addcomponent_' + id);
            var incrementbiddercountid = $('#incrementcountid').val();
            var count = id;
            var html = '<div><a  href="javascript:void(0);" class="remove_component" title="Remove field"><img src="{{asset('img/cancel-512.png')}}" style="height: 20px; width: 20px;"/></a><div class="panel col-md-12" style="border: silver 1px solid;"><div class="panel-body"><div class="row mt-1">' +
                '{{Form::hidden('classid[]','asdsadas',array('class'=>'saveid'))}}'.replace('asdsadas', id) +
                '{{ Form::hidden('biddercompanynameid[]','asdsadas',array('class'=>'saveid')) }}'.replace('asdsadas', bidderid) +
                '<div class="col-md-3">Component Name</div><div class="col-md-3">QTY</div><div class="col-md-3">Rate</div><div class="col-md-3">Amt</div></div>' +
                '<div class="row col-md-12">{{ Form::hidden('tenderdetailsaveid[]', '0') }}' +
                '<div class="col-md-3">{{ Form::text('component[]', null, array('class' => 'form-control form-control-sm', 'id' => 'componentid','required' => 'required')) }}</div>' +
                    {{--'<div class="col-md-3">{{ Form::text('noofquantity[]', null, array('class' => 'form-control form-control-sm', 'id' => 'noofquantityid','required' => 'required')) }}</div>' +--}}
                        '<div class="col-md-3"><input type="text" class="form-control" name="noofquantity[]" id="textone_%id%" onchange="totalcal(%count%); return false"></div>'.replace('%id%',incrementbiddercountid).replace('%count%',incrementbiddercountid)+
                    {{--'<div class="col-md-3">{{ Form::text('perunitrate[]', null, array('class' => 'form-control form-control-sm', 'id' => 'perunitrateid','required' => 'required')) }}</div>' +--}}
                        '<div class="col-md-3"><input type="text" class="form-control" name="perunitrate[]" id="texttwo_%id%" onchange="totalcal(%count%); return false"></div>'.replace('%id%',incrementbiddercountid).replace('%count%',incrementbiddercountid)+
                '<div class="col-md-3">{{ Form::text('bidamount[]', null, array('class' => 'form-control bidamountid_%count% sdkksdfhsdsjkfhs_%incrementbiddercountid%','required' => 'required','onkeyup'=>'tallytotalamt(%id%);','readonly')) }}</div>'.replace('%count%', incrementbiddercountid).replace('%id%', id).replace('%incrementbiddercountid%',id) +
                '</div></div></div>';
            $(html).click(function () { //Once add button is clicked
                $(wrapper).append(html); // Add field html
            });
            $(wrapper).on('click', '.remove_component', function (e) { //Once remove button is clicked
                $(this).parent('div').remove(); //Remove field html
            });
            $('#addcomponent_' + id).append(html);
            incrementbiddercountid = parseInt(incrementbiddercountid) + 1;
            $('#incrementcountid').val(incrementbiddercountid);
//            $('.saveid').val(id);
        }
    </script>
    <script type="text/javascript">
        function tallytotalamt(id) {
            debugger
            var sum = 0;
            var cost = $('.sdkksdfhsdsjkfhs_'+id);
//            var cost = $('.bidamountid_' + id);
            for (var i = 0; i < cost.length; i++) {
                sum += parseFloat(cost[i].value);
            }
            document.getElementById('totalofbiamtid_'+id).value = sum;
        };

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
        };
    </script>



@endsection
