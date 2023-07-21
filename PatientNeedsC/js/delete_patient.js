$(document).ready(function() {
    $('.delete-btn').click(function() {
        var patient_id = $(this).data('patient-id');
        $.ajax({
            url: 'delete_patient.php',
            method: 'GET',
            data: {
                'patient_id': patient_id
            },
            success: function(response) {
                window.location.href = 'active-patients.php';
            }
        });
    });
});