document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('signupForm').addEventListener('submit', function(event) {
        event.preventDefault();
        
        var name = document.getElementById('signupName').value;
        var email = document.getElementById('signupEmail').value;
        var password = document.getElementById('signupPassword').value;
        var repeatedPassword = document.getElementById('repeatedPassword').value;
        
         // Regular expression for validating name (only letters)
         var nameRegex = /^[A-Za-z\s]+$/;
         if (!nameRegex.test(name)) {
             alert("Name must contain only letters.");
             return;
         }

        // Regular expression for validating email
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            alert("Invalid email address.");
            return;
        }

        // Regular expression for validating password
        var passwordRegex = /^(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])(?=.{8,})/;
        if (!passwordRegex.test(password)) {
            alert("Password must be at least 8 characters long and include one uppercase letter, one number, and one special character.");
            return;
        }

        // Check if both passwords match
        if (password !== repeatedPassword) {
            alert("Passwords do not match.");
            return;
        }


        // If all validations pass, submit the form
        this.submit();
    });
});
