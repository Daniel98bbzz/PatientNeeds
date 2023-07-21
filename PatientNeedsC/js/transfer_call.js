$(document).ready(function() {
    $('.confirm-btn').click(function() {
        var smart_id = $(this).data('smart-id');
        $.ajax({
            url: 'transfer_call.php',
            method: 'GET',
            data: {
                'smart_id': smart_id
            },
            success: function(response) {
                location.reload();
            }
        });
    });
});