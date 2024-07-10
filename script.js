// script.js
var emailInput = document.getElementById('formEmail');
var passwordInput = document.getElementById('formPassword');

document.addEventListener('keydown', function(event) {
  // Check if the Backspace key is pressed and no input field is focused
  if (event.key === 'Backspace' && !document.querySelector(':focus')) {
      history.back();
  }
});

window.addEventListener('resize', function(event) {
  alert("🖥️ Page Resized: Please note that the layout may have changed. Ensure optimal viewing by adjusting your window size. 🔄");
});



emailInput.addEventListener('focus', function () {
  emailInput.setAttribute('placeholder', 'ex: email@example.com');
});

emailInput.addEventListener('blur', function () {
  emailInput.setAttribute('placeholder', 'Your Email');
});

passwordInput.addEventListener('focus', function () {
  passwordInput.setAttribute('placeholder', '8 characters, ex: 33$fjj##5');
});

passwordInput.addEventListener('blur', function () {
  passwordInput.setAttribute('placeholder', 'Your Password');
});
