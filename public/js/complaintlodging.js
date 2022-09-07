/**
 * Created by GIDEON on 09-08-17.
 */

$(document).ready(function () {

    var url = "http://ubuntu-server/complaintredressalsystem/public/index.php";

//        Populate Category Dropdown on Product Service Dropdown Change
    $('select[name="productservice"]').change(function () {

        if ($('select[name="productservice"]').val() != "") {
            $.ajax({
                url: url + '/registration/category/' + $('select[name="productservice"]').val(),
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $('select[name="category"]').empty();
                    $('select[name="subcategory"]').empty();
                    $('select[name="subcategory"]').append('<option value="">--SELECT--</option>');
                    $('select[name="category"]').append('<option value="">--SELECT--</option>');
                    $.each(data, function (key, value) {
                        $('select[name="category"]').append('<option value="' + value['categorycode'] + '">' + value['categoryname'] + '</option>');
                    });
                }
            });
        }
        else {
            $('select[name="subcategory"]').empty();
            $('select[name="category"]').empty();
        }
    })

//        Populate Sub-Category Dropdown on Category Dropdown Change
    $('select[name="category"]').change(function () {
        if ($('select[name="category"]').val() != "") {
            $.ajax({
                url: url + '/registration/subcategory/' + $('select[name="category"]').val(),
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $('select[name="subcategory"]').empty();
                    $('select[name="subcategory"]').append('<option value="">--SELECT--</option>');
                    $.each(data, function (key, value) {
                        $('select[name="subcategory"]').append('<option value="' + value['subcategorycode'] + '">' + value['subcategoryname'] + '</option>');
                    });
                }
            });
        }
        else {
            $('select[name="subcategory"]').empty();
        }
    })


    $('#customers').change(function () {

        if ($('select[name="customers"]').val() != "") {
            $.ajax({
                url: url + '/registration/branch/' + $('select[name="customers"]').val(),
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $.each(data, function (key, value) {
                        $('select[name="customersite"]').append('<option value="' + value['branchcode'] + '">' + value['branchname'] + '</option>');
                    });
                }
            });
        }
        else {
            $('select[name="customersite"]').empty();
        }
    })
});