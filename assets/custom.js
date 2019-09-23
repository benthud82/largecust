$(document).on("click", ".btn_toggle", function (e) {
    var modalid = $(this).attr('data-modalid');
    $('#' + modalid).modal('toggle');
});

if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}

$(document).on("click", ".checkbox_hideshow", function (e) {
    var displayid = 'displaydiv_' + this.id;
    this.checked ? $('#' + displayid).show(500) : $('#' + displayid).hide(500); //time for show
});

function confirm_salesplan(arg) {
    debugger;
    //where to place check or x
    var modalid = arg.getAttribute('id');
    //value to lookup
    var val_salesplan = arg.value;
    //add post here
 $.ajax({
                url: 'globaldata/table_forecastaccuracy.php',
                data: {userid: userid},
                type: 'POST',
                dataType: 'html',
                success: function (ajaxresult) {
                    $("#table_forecastacc").html(ajaxresult);
                }
            });
}
