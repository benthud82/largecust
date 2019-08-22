$(document).on("click", ".btn_toggle", function (e) {
    debugger;
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