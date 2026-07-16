@extends('layouts.appnew')
@section('pageTitle', 'Complaints')

@section('content')
    <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.css"  rel="stylesheet"  type='text/css'>
    <div class="main dragscroll">
        <img src="{{asset('uploads/'.$filedetails->filename)}} " style="border:none; alignment: center" id="image"  width="300px"></img>
    </div>
    <div style="padding-top: 100px">
        <button class="btn-transparent" id="rotate" style="background-color: transparent; outline:none; border: none;"><i class="fa fa-rotate-right" style="font-size:36px; "></i></button>
        <button class="btn-transparent" style="background-color: transparent; outline:none; border: none;" onclick="zoomin()"><i class="fa fa-search-plus" style="font-size:36px;"></i></button>
        <button class="btn-transparent" style="background-color: transparent; outline:none; border: none;" onclick="zoomout()"><i class="fa fa-search-minus" style="font-size:36px;"></i></button>
    </div>
    <div style="padding-top: 50px">
        <a class="btn btn-default" href="{{url()->previous()}}">Back</a>
    </div>

@endsection

@section('selectize-script')
    <script type="text/javascript" src="http://cdn.sobekrepository.org/includes/jquery-rotate/2.2/jquery-rotate.min.js"></script>
    <script type="text/javascript" src="https://cdn.rawgit.com/asvd/dragscroll/master/dragscroll.js"></script>
<script>
    var angle = 0;
    $('#rotate').on('click', function() {
        debugger
    angle += 90;
    $("#image").rotate(angle);
    });
</script>
    <script>
        function zoomin() {
            var myImg = document.getElementById("image");
            var currWidth = myImg.clientWidth;
            if (currWidth == 2500) return false;
            else {
                myImg.style.width = (currWidth + 100) + "px";
            }
        }
    </script>
    <script>
        function zoomout() {
            var myImg = document.getElementById("image");
            var currWidth = myImg.clientWidth;
            if (currWidth == 100) return false;
            else {
                myImg.style.width = (currWidth - 100) + "px";
            }
        }
    </script>

@endsection
