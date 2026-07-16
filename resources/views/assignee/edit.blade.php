@extends('layouts.appnew')
@section('pageTitle', 'Manage Complaint')
@section('head-css')
    <link href="{{ asset('assets/Selectize/css/selectize.css') }}" rel="stylesheet">
@endsection
@section('content')
 <div class="panel panel-default">
     <div class="panel-heading">Complaint Feedback Status</div>
       {{Form::open(array('action' => array('AssigneeController@update',$complaints->id),'method' => 'post', 'role' => 'form', 'invalidate' => 'invalidate','files' => true,'id'=>'formid'))}}
       {{ Form::hidden('status', $status, array('id' => 'statusid')) }}
       {{ Form::hidden('description', $description, array('id' => 'descriptionid')) }}
       {{ Form::hidden('subcategory', $complaintType[0]->subcategorycode, array('id' => 'subcategory')) }}
       {{ Form::hidden('checkvalues[]', null,array('id' => 'checkvalues')) }}
       <div class="form-group">
           <label class="col-sm-3 col-form-label text-muted">Ticket No </label>
           {{ Form::text('ticketnumber', $complaints->ticketno, array('class' => 'form-control','readonly'=>true)) }}
       </div>
     <div class="form-group" id="descriptiondiv">
         <label class="col-sm-3 col-form-label text-muted">Complaint Description</label>
         {{ Form::text('description', $description, array('class' => 'form-control col-sm-3','readonly'=>true)) }}
         <a  class="form-group col-lg-3" data-toggle="modal" data-target="#equipment">Equipments</a>
     </div>
     <div class="form-group">
         <label class="col-sm-3 col-form-label text-muted">Start Date </label>
         {{ Form::text('assigneestartdate', $assigneestartdate, array('class' => 'form-control','readonly'=>true)) }}
     </div>
     <div class="form-group">
         <label class="col-sm-3 col-form-label text-muted">End Date</label>
         {{ Form::text('assigneeenddate', $assigneeenddate, array('class' => 'form-control','readonly'=>true)) }}
     </div>
     <div class="form-group" id="complaintstatusiddiv">
         <label class="col-sm-3 col-form-label text-muted">Complaint Status</label>
         {{ Form::select('complaintstatus', $statusList, $complaints->assigneestatus, array('class'=>'form-control complaintstatusclassid','placeholder' => '--SELECT--', 'id' => 'complaintstatus')) }}
     </div>
     <div class="form-group" id="servicestatusid">
         <label class="col-sm-3 col-form-label text-muted">Complaint Status</label>
{{--         {{ Form::select('complaintstatus', $statusList, $complaints->assigneestatus, array('class'=>'form-control complaintstatusclassid','placeholder' => '--SELECT--','required' => 'required', 'id' => 'servicecomplaintstatusid')) }}--}}
         {{ Form::text('complaintstatus1', $complaints->assigneestatus, array('class' => 'form-control', 'id' => 'complaintstatusid','readonly'=> true)) }}
     </div>
     <div class="form-group" id="resolvecommentdiv">
         <label class="col-sm-3 col-form-label text-muted">Comment</label>
         {{ Form::textarea('resolvecomment', $complaints->ticketresolvecomment, array('id' => 'resolvecomment','class' => 'form-control-sm','rows'=>'3')) }}
     </div>
     <div class="form-group" id="unresolvecommentdiv">
         <label class="col-sm-3 col-form-label text-muted">Un Resolve Comment</label>
         {{ Form::textarea('unresolvecomment', $complaints->ticketunresolvecomment, array('id' => 'unresolvecomment','class' => 'form-control-sm','rows'=>'3')) }}
     </div>
     <div class="form-group" id="pendingreasondiv">
         <label class="col-sm-3 col-form-label text-muted">Pending Reason</label>
         {{ Form::textarea('pendingreason', $complaints->ticketpendingreason, array('id' => 'pendingreason','class' => 'form-control-sm','rows'=>'3')) }}
     </div>
     <div class="form-group" id="nextactionremarkdiv">
         <label class="col-sm-3 col-form-label text-muted">Next Action Remark</label>
         {{ Form::textarea('nextactionremark', $complaints->ticketnextactionremark, array('id' => 'nextactionremark','class' => 'form-control-sm','rows'=>'3')) }}
     </div>
     <div class="form-group" id="nextactionremarkdiv">
         <label class="col-sm-3 col-form-label text-muted">Upload Files</label>
         {{ Form::file('file[]',array('class'=>'form-control form-control-sm uplaodfileclass','multiple'=>true,'multiple id'=>'uplodedfileid','onchange'=>'ValidateFileUpload()')) }}
     </div>

     <div class="col-sm-3">
     </div>
     <div class="col-sm-3">
     <button type="button" class="fa fa-eye" data-toggle="modal" data-target="#myModal"></button>
     </div>

     <div class="modal fade animated fadeIn faster" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
         <div class="modal-dialog" role="document" style="max-width:50%;">
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title" id="ModalLabel">View File</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
                 <div class="modal-body" id="p1body">
                     <img  class="img-responsive" id="profile-img-tag">
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                 </div>
             </div>
         </div>
     </div>

     <div class="modal fade animated fadeIn faster" id="equipment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
         <div class="modal-dialog" role="document" style="max-width:50%;">
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title" id="equipmentmodallabel">Equipments</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
                 <div class="modal-body-1" id="equipmentbody">
                     <ul style="margin-left: 20px">
                         @foreach($equipment as $srnos)
                                 <li data-value="{{ $srnos->productsrno_accountno }}">{{ $srnos->productsrno_accountno }}</li>
                         @endforeach
                     </ul>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" id="modalsubmit">Submit</button>
                     <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeid">Close</button>
                 </div>
             </div>
         </div>
     </div>

    <br>
     <div class="form-group" id="nextactionremarkdiv" style="padding-left: 150px;">
         <button type="submit" class="btn btn-primary" id="btnsubmit">Submit</button>
     </div>

 </div>
   {{ Form::close() }}
@endsection

@section('selectize-script')
    <script src="https://www.jquery-az.com/jquery/js/jquery-treeview/logger.js"></script>
    <script src="https://www.jquery-az.com/jquery/js/jquery-treeview/treeview.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            if($('#descriptionid').val() === "service" && $("#subcategory").val() === "service")
            {
                $('#descriptiondiv').show();
                $('#complaintstatusiddiv').hide();
                $('#servicestatusid').show();
                // document.getElementById("complaintstatusid").readOnly = true;
            }
            else{
                $('#descriptiondiv').hide();
                $('#complaintstatusiddiv').show();
                $('#servicestatusid').hide();
            }
            showhideDivs();
            $('#equipment').hide();
            $('#equipment').treeview({
                debug: true,
                data: ['links', 'Do WHile loop']
            });
        });
        $("#complaintstatus").change(function () {
            showhideDivs();
        });

        function showhideDivs() {
            var complaintstatusValue = document.getElementById("complaintstatus");
            var complaintstatusValueselectedText = complaintstatusValue.options[complaintstatusValue.selectedIndex].text;

            if(complaintstatusValueselectedText == "RESOLVED"){

                $('#resolvecommentdiv').show();

                $('#unresolvecommentdiv').hide();

                $("#pendingreasondiv").hide();

                $("#nextactionremarkdiv").hide();

                        document.getElementById("uplodedfileid").required = true;

            }
             if(complaintstatusValueselectedText == "NOT RESOLVED"){

                $('#resolvecommentdiv').hide();

                $('#unresolvecommentdiv').show();

                $("#pendingreasondiv").hide();

                $('#nextactionremarkdiv').hide();
                document.getElementById("uplodedfileid").required = false;
                document.getElementById("unresolvecomment").required = true;
            }
            if(complaintstatusValueselectedText == "PENDING"){

                $("#pendingreasondiv").show();

                $('#nextactionremarkdiv').show();

                $("#unresolvecommentdiv").hide();

                $("#resolvecommentdiv").hide();
                document.getElementById("pendingreason").required = true;
                document.getElementById("uplodedfileid").required = false;

            }
            if(complaintstatusValueselectedText == "--SELECT--"){
                $("#pendingreasondiv").hide();

                $('#nextactionremarkdiv').hide();

                $("#unresolvecommentdiv").hide();

                $("#resolvecommentdiv").hide();
            }
            if(complaintstatusValueselectedText == "ReassignedResolved"){
                $('#resolvecommentdiv').show();

                $('#unresolvecommentdiv').hide();

                $("#pendingreasondiv").hide();

                $("#nextactionremarkdiv").hide();

                document.getElementById("uplodedfileid").required = true;
            }
        }

        function showhideDivspart2() {
            var complaintstatusValue = $("#complaintstatusid").val();
            // var complaintstatusValueselectedText = complaintstatusValue.options[complaintstatusValue.selectedIndex].text;

            if(complaintstatusValue == "RESOLVED"){

                $('#resolvecommentdiv').show();

                $('#unresolvecommentdiv').hide();

                $("#pendingreasondiv").hide();

                $("#nextactionremarkdiv").hide();

                document.getElementById("uplodedfileid").required = true;

            }
            if(complaintstatusValue == "NOT RESOLVED"){

                $('#resolvecommentdiv').hide();

                $('#unresolvecommentdiv').show();

                $("#pendingreasondiv").hide();

                $('#nextactionremarkdiv').hide();
                document.getElementById("uplodedfileid").required = false;
                document.getElementById("unresolvecomment").required = true;
            }
            if(complaintstatusValue == "PENDING"){

                $("#pendingreasondiv").show();

                $('#nextactionremarkdiv').show();

                $("#unresolvecommentdiv").hide();

                $("#resolvecommentdiv").hide();
                document.getElementById("pendingreason").required = true;
                document.getElementById("uplodedfileid").required = false;

            }
        }

        var selectobject = document.getElementById("complaintstatus");
        if($("#statusid").val() == "REASSIGNED")
        {
            for (var i=0; i<selectobject.length; i++){
                if (selectobject.options[i].value == 'RESOLVED' )
                    selectobject.remove(i);
            }
        }else {
            for (var i=0; i<selectobject.length; i++){
                if (selectobject.options[i].value == 'ReassignedResolved' )
                    selectobject.remove(i);
            }
        }

        $("#formid").submit(function (e) {
            if($('#descriptionid').val() === "service" && $("#subcategory").val() === "service" && $("#complaintstatusid").val() === '')
            {
                alert("Please select Equipments.");
                return false;
            }
            else{
                $("#btnsubmit").attr("disabled", true);
                return true;
            }

        });
    </script>
    <script type="text/javascript">
        $('#modalsubmit').click(function(e){
            debugger;
            var checkedvalues = $('#equipment').treeview('selectedValues');
            $('#checkvalues').val(checkedvalues);
            var equipment = {!! json_encode($equipment->toArray()) !!}.length;
            var count = checkedvalues.length;
            if(equipment > count){
                $('#complaintstatusid').val('PENDING');
                $('#closeid').click();
                showhideDivspart2();

            }
            else if(equipment == count){
                $('#complaintstatusid').val('RESOLVED');
                $('#closeid').click();
                showhideDivspart2();
            }
            else{
                alert('Select Equipments');
            }
        })
    </script>

    <script type="text/javascript">
        function ValidateFileUpload() {
            var fuData = document.getElementById('uplodedfileid');
            var FileUploadPath = fuData.value;

//To check if user upload any file
            if (FileUploadPath === '') {
                alert("Please upload an image");

            } else {
                var Extension = FileUploadPath.substring(
                    FileUploadPath.lastIndexOf('.') + 1).toLowerCase();

//The file uploaded is an image

                if ( Extension === "png"
                    || Extension === "jpeg" || Extension === "jpg") {

// To Display
                    if (fuData.files && fuData.files[0]) {
                        var reader = new FileReader();

                        reader.onload = function(e) {
                            $('#blah').attr('src', e.target.result);
                        };

                        reader.readAsDataURL(fuData.files[0]);
                    }

                }

//The file upload is NOT an image
                else {
                    $("#uplodedfileid").val('');
                    alert("Photo only allows file types of  PNG, JPG and JPEG ");

                }
            }
        }
    </script>

    <script type="text/javascript">
        function centerModal() {
        $(this).css('display', 'block');
        var $dialog = $(this).find(".modal-body");
        var offset = ($(window).height() - $dialog.height()) / 2;
        // Center modal vertically in window
        $dialog.css("margin-top", offset);
        }
        $(function() {
            var imagesPreview = function (input, modal) {
                if (input.files) {
                    var filesAmount = input.files.length;
                    for (i = 0; i < filesAmount; i++) {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            $($.parseHTML('<img width="350px;" height="250px;" >')).attr('src', e.target.result).appendTo(modal);
                        };
                        reader.readAsDataURL(input.files[i]);
                    }
                }
            };
            $("#uplodedfileid").on('change',function () {
                imagesPreview(this, 'div.modal-body');
            })
        });
    </script>
@endsection