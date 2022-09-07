@extends('layouts.appnew')

@section('pageTitle', 'Complaints')
@section('content')
    <table>
        <tr>
            <td>Rate</td>
            <td>Quantity</td>
        </tr>
        @foreach($values as $key => $val)
            <input type="hidden" value="{{ $key+1 }}" id="hdid">
            <tr>
                <td> <input type="text" name="value1" id="textone_{{$key + 1}}" value="{{$val->noofquantity}}" onchange="tallytotalamt({{$key + 1}}); return false"></td>
                <td><input type="text" name="value2" id="texttwo_{{$key + 1}}" value="{{$val->perunitrate}}" onchange="tallytotalamt({{$key + 1}}); return false"></td>
            </tr>
            <tr>
                <td colspan="2">Result</td>
            </tr>
            <tr>
                <td colspan="2"><input type="text" name="result" id="result_{{$key + 1}}"></td>
            </tr>
            @endforeach

    </table>


@endsection
@section('selectize-script')
    {{--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>--}}
<script type="text/javascript">
    function tallytotalamt(id) {
        debugger
                var textone;
        var texttwo;
        textone = parseFloat($('#textone_'+id).val());
        texttwo = parseFloat($('#texttwo_'+id).val());
        var result = textone * texttwo;
        $('#result_'+id).val(result.toFixed(.00));


    };

//    $('#texttwo').keyup(function(){
//        debugger
//        var id = $('#hdid').val();
//        var textone;
//        var texttwo;
//        textone = parseFloat($('#textone').val());
//        texttwo = parseFloat($('#texttwo').val());
//        var result = textone * texttwo;
//        $('#result_'+id).val(result.toFixed(.00));
//    });
</script>
@endsection