$(document).ready(function() {
    $.ajax({
        type: "GET",
        url: "profile-action.php",
        data: { action: "fetch_user_data" },
        success: function(data) {
            var user = JSON.parse(data);
            $("#fullName").val(user.First_Name + " " + (user.Middle_Name ? user.Middle_Name + " " : "") + user.Last_Name);
            $("#phoneNumber").val(user.Phone_Number);
            if (user.Profile_Picture) {
                $(".profile-picture-placeholder").html('<img src="data:image/jpeg;base64,' + user.Profile_Picture + '" class="rounded-circle profile-picture" alt="Profile Picture">');
            }
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });

    $("#saveChanges").click(function() {
        var phoneNumber = $("#phoneNumber").val();
        if (phoneNumber.length !== 10) {
            alert("Phone number must be 10 digits long");
            return;
        }

        $.ajax({
            type: "POST",
            url: "profile-action.php",
            data: { action: "update_phone_number", phoneNumber: phoneNumber },
            success: function(data) {
                alert(data);
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });

    $("#pictureInput").change(function() {
        var file = this.files[0];
        if (file) {
            var formData = new FormData();
            formData.append("picture", file);

            $.ajax({
                type: "POST",
                url: "profile-action.php",
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    alert(data);
                    $(".profile-picture-placeholder").html('<img src="data:image/jpeg;base64,' + btoa(String.fromCharCode.apply(null, new Uint8Array(file))) + '" class="rounded-circle profile-picture" alt="Profile Picture">');
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
    });

    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });
});