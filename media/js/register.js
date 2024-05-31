$(document).ready(function() {
$("#register").click(function() {
	var firstName = $("#First_Name").val();
	var middleName = $("#Middle_Name").val();
	var lastName = $("#Last_Name").val();
	var email = $("#VCU_Email").val();
	var password = $("#UserPassword").val();
	var cpassword = $("#repeat_password").val();
	if (firstName == '' || lastName=='' || email == '' || password == '' || cpassword == '') {
		alert("Please fill all fields...!!!!!!");
	} 
	else if ((password.length) < 8) 
	{
		alert("Password should atleast 8 character in length...!!!!!!");
	} 
	else if (!(password).match(cpassword)) 
	{
		alert("Your passwords don't match. Try again?");
	} 
	else 
	{
		$.ajax({
			type: "POST",
			url: "register-action.php",
			data: {
				First_Name: firstName,
				Middle_Name: middleName,
				Last_Name: lastName,
				VCU_Email: email,
				UserPassword: password,
				passwordRepeat: cpassword
			},
			success: function(data) {
				if (data.includes('You have Successfully Registered.....')) {
					$("form")[0].reset();
					alert('You have Successfully Registered! Please log in now!', 'success');
				}
				else {
					alert('Error: ' + data, 'danger');
				}
			}
		});
	}
});
});
