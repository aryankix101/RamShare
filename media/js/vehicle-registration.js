$(document).ready(function() {
    $('#vehicle-registration-form').submit(function(event) {
        event.preventDefault(); 

        var licensePlate = $('#licenseplate').val();
        var state = $('#state').val();
        var model = $('#model').val();
        var year = $('#year').val();
        var color = $('#color').val();

        $.ajax({
            type: 'POST',
            url: 'vehicle-registration-action.php',
            data: {
                licenseplate: licensePlate, 
                state: state,
                model: model,
                year: year,
                color: color
            },
            success: function(response) {
                alert(response);
                $('#vehicle-registration-form')[0].reset();
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });
});