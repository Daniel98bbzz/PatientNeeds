$(document).ready(function(){
    $(".filter").click(function(){
        $(".select-box").toggle();
    });

    $("#risk_filter").on('change', function() {
        window.location = 'active-smart.php?risk_level=' + $(this).val();
    });
});