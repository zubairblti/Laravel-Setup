document.addEventListener("DOMContentLoaded", function() {
  const inputs = document.querySelectorAll('#otp input');

  inputs.forEach((input, index) => {
    input.addEventListener('input', (e) => {
      if (e.target.value && index < inputs.length - 1) {
        inputs[index + 1].focus();
      }
    });

    input.addEventListener('keydown', (e) => {
      if (e.key === 'Backspace' && !input.value && index > 0) {
        inputs[index - 1].focus();
      }
    });
  });
});
