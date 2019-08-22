$(document).on("click", "#tgl_modal_summblob", function (e) {
    $('#modal_summblob').modal('toggle');
});

if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}

$(document).on("click", ".checkbox_hideshow", function (e) {
    var displayid = 'displaydiv_' + this.id;
    this.checked ? $('#' + displayid).show(500) : $('#' + displayid).hide(500); //time for show
});
