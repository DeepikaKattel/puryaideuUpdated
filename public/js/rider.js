
$(document).ready(function() {
    $('#role').on('change.rider', function() {
        $("#rider").toggle($(this).val() == '2');
    }).trigger('change.rider');
});
