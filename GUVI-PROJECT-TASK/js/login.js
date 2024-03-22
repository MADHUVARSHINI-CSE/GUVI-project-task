function loginUser() {
  var username = $("#username").val();
  var password = $("#password").val();

  $.ajax({
    type: "POST",
    url: "php/login.php",
    data: {
      username: username,
      password: password,
    },
    success: function (response) {
      // Handle the response from the server
      if (response == "success") {
        // Redirect to the profile page or any other desired action
        alert("Login Successful");
        window.location.href = "profile.html";
      } else {
        // Display an error message
        console.log(response);
        Swal.fire({
          icon: "error",
          title: "Login Failed",
          text: "Invalid username or password. Please try again.",
        });
      }
    },
  });
}
