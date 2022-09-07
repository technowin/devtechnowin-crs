/**
 * Created by technowin on 23/01/2018.
 */

function ValidateDate(input,year,message) {
    var inputdate = new Date($('#'+input).val());
    inputday = inputdate.getDate();
    inputmonth = inputdate.getMonth();
    inputyear = inputdate.getFullYear();
    if (inputyear > year){
        $('#'+input).val('')
        alert(message)
        e.preventDefault();
    }
}
