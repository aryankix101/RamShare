$(document).ready(function() {
    $("#submit-second-round-information").click(function() {
        var birthDate = $("#birthdate").val();
        var phoneNumber = $("#phone_number").val();
        var genderValue = document.querySelector('input[name="gender"]:checked').value;
        var bio = $("#bio").val();
        var typeOfUserValue = document.querySelector('select[name="type_of_user"]').value;
        console.log(birthDate);
        console.log(phoneNumber);
        console.log(genderValue);
        console.log(bio);
        console.log(typeOfUserValue);
        $.ajax({
                type: "POST",
                url: "new-user-registration-action.php",
                data: {
                    Birthdate: birthDate,
                    Phone_Number: phoneNumber,
                    Gender: genderValue,
                    Bio: bio,
                    Type_Of_User: typeOfUserValue
                },
                success: function(data) {
                    if (data.includes('You have Successfully Registered.....')) {
                        $("form")[0].reset();
                        alert('You have Successfully Registered!', 'success');
                    }
                    else 
                    {
                        alert('Error: ' + data, 'danger');
                    }
                }
            });
        })
    });
    