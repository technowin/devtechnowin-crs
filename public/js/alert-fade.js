/**
 * Created by abc on 07-08-17.
 */
$(document).ready(function () {
    window.setTimeout(function () {
        $(".alert-success").fadeTo(1500, 0).slideUp(500, function () {
            $(this).remove();
        });
    }, 5000);
});

//Near checkboxes
$('.product-list').click(function() {
    $(this).siblings('input:checkbox').prop('checked', false);
});