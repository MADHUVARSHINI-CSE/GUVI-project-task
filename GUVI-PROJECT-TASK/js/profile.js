function updateProfile() {
    var address = $("#address").val();
    var state = $("#state").val();
    var country = $("#country").val();
    var aadharNumber = $("#aadharNumber").val();

    $.ajax({
        type: "POST",
        url: "php/updateProfile.php",
        data: {
            address: address,
            state: state,
            country: country,
            aadharNumber: aadharNumber
        },
        success: function (response) {
            if (response === "success") {
                // Redirect to the next page (view_profile.php)
                window.location.href = "final.html";
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Update Failed",
                    text: "Failed to update your profile. Please try again.",
                });
            }
        },
        error: function (error) {
            console.error("Error during profile update:", error);
        }
    });
}
