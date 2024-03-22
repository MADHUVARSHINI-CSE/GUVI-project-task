function registerUser() {
  var country = $("#country").val();
  var email = $("#email").val();
  var phone = $("#phone").val();
  var dob = $("#dob").val();
  var username = $("#username").val();
  var password = $("#password").val();

  $.ajax({
    type: "POST",
    url: "php/register.php",
    data: {
      country: country,
      email: email,
      phone: phone,
      dob: dob,
      username: username,
      password: password,
    },
    success: function (response) {
      console.log("Response from server:", response);
      response = $.trim(response); // Trim whitespaces

      // Handle the response from the server
      if (response === "success") {
        // Redirect to the login page or any other desired action
        console.log("Redirecting to login.html");
        alert("User Register Succesful");
        window.location.href = "login.html";
      } else {
        // Display an error message
        Swal.fire({
          icon: "error",
          title: "Registration Failed",
          text: "Please try again.",
        });
      }
    },
  });
}
