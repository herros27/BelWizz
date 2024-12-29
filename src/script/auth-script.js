const loginText = document.querySelector(".title-text .login");
const loginForm = document.querySelector("form.login");
const loginBtn = document.querySelector("label.login");
const signupBtn = document.querySelector("label.signup");
const signupLink = document.querySelector("form .signup-link label");
const wrapper = document.querySelector(".wrapper");

signupBtn.onclick = () => {
  loginForm.style.marginLeft = "-50%";
  loginText.style.marginLeft = "-50%";
};
loginBtn.onclick = () => {
  loginForm.style.marginLeft = "0%";
  loginText.style.marginLeft = "0%";
};
signupLink.onclick = () => {
  signupBtn.click();
  return false;
};

// Seleksi semua elemen toggle-password
const togglePasswordButtons = document.querySelectorAll(".toggle-password");

togglePasswordButtons.forEach((toggle) => {
  toggle.addEventListener("click", () => {
    const container = toggle.closest(".password-container");
    const input = container.querySelector("input"); // Hilangkan type="password" dari selector

    if (input.type === "password") {
      input.type = "text";
      toggle.textContent = "🙈";
      toggle.setAttribute("title", "Hide Password");
    } else {
      input.type = "password";
      toggle.textContent = "👁️";
      toggle.setAttribute("title", "Show Password");
    }
  });
});

window.onload = function () {
  var errorAlert = document.getElementById("errorAlert");
  if (errorAlert) {
    setTimeout(function () {
      errorAlert.style.display = "none"; // Sembunyikan elemen
    }, 2000); // 3000 ms = 3 detik
  }

  // Pengecekan status form_status
  if (formStatus === "signup") {
    signupBtn.click(); // Pindahkan ke form Signup
  } else if (formStatus === "login") {
    loginBtn.click(); // Pindahkan ke form Login
    wrapper.style.maxHeight = "400px";
  }
};
