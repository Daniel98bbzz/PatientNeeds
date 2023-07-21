$(document).ready(function() {
    $('#form_need').change(function() {
      var riskLevel = $(this).val();
      $.ajax({
        type: 'GET',
        url: 'filter_patients.php',
        data: { 'risk_level': riskLevel },
        success: function(data) {
          $('table tbody').html(data);
        }
      });
    });
  });