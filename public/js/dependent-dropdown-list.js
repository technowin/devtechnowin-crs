/**
 * Created by abc on 11-08-17.
 */

$('#productservice').change(function(){
    var url = "http://ubuntu-server/complaintredressalsystem/public/index.php";
    var productserviceid = $(this).val();
    if(productserviceid){
        $.ajax({
            type:"GET",
            url: url + '/adminaccess/adminaccess/' + productserviceid,
            success:function(res){
                if(res){
                    $("#category").empty();
                    $("#category").append('<option>Select</option>');
                    $.each(res,function(key,value){
                        $("#category").append('<option value="'+key+'">'+value+'</option>');
                    });

                }else{
                    $("#category").empty();
                }
            }
        });
    }else{
        $("#category").empty();
    }
});


$('#state').on('change',function(){
    var stateID = $(this).val();
    if(stateID){
        $.ajax({
            type:"GET",
            url:"{{url('api/get-city-list')}}?state_id="+stateID,
            success:function(res){
                if(res){
                    $("#city").empty();
                    $.each(res,function(key,value){
                        $("#city").append('<option value="'+key+'">'+value+'</option>');
                    });

                }else{
                    $("#city").empty();
                }
            }
        });
    }else{
        $("#city").empty();
    }

});