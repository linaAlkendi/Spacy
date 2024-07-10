document.getElementById("formForgotPass").addEventListener("submit", function(event) {
    var resetpasswordemail = document.getElementById("formEmail").value;
    var newpassword = document.getElementById("formNewPassword").value;
    var confirmnewpassword = document.getElementById("formConfirmNewPassword").value;

    // Email validation using regular expression
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(resetpasswordemail)) {
        alert("Invalid email address");
        event.preventDefault(); // Prevent form submission
        return;
    }

    // Password strength validation
    var passwordPattern = /^(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])(?=.{8,})/;
    if (!passwordPattern.test(newpassword)) {
        alert("Password must have minimum 8 characters, one uppercase character, one number, and one special character");
        event.preventDefault(); // Prevent form submission
        return;
    }

    // Confirm password match validation
    if (newpassword !== confirmnewpassword) {
        alert("Passwords do not match");
        event.preventDefault(); // Prevent form submission
        return;
    }

    // If all validations pass, the form will be submitted automatically
});
