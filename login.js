document.getElementById("loginForm").addEventListener("submit", function(event) {
    var email = document.getElementById("loginEmail").value;
    var password = document.getElementById("loginPassword").value;

    // Regular expression for validating email
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        alert("Invalid email address.");
        event.preventDefault(); // Prevent form submission
        return;
    }

    // Regular expression for validating password
    var passwordRegex = /^(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])(?=.{8,})/;
    if (!passwordRegex.test(password)) {
        alert("Password must be at least 8 characters long and include one uppercase letter, one number, and one special character.");
        event.preventDefault();
        return;
    }
});