$('#mode-filter').on('change', function () {
    var mode = $(this).val();
    var url = new URL(window.location);

    if (mode) {
        url.searchParams.set('mode', mode);
    } else {
        url.searchParams.delete('mode');
    }
    window.location = url.toString();
});