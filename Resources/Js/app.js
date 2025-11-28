// Codigo para abrir modal de login y registro
document.addEventListener("DOMContentLoaded", () => {
  const btnLogin = document.getElementById("btnShowLogin");
  const btnRegister = document.getElementById("btnShowRegister");
  const loginForm = document.getElementById("loginForm");
  const registerForm = document.getElementById("registerForm");

  btnLogin.addEventListener("click", () => {
    loginForm.classList.remove("d-none");
    registerForm.classList.add("d-none");
  });

  btnRegister.addEventListener("click", () => {
    registerForm.classList.remove("d-none");
    loginForm.classList.add("d-none");
  });
});

function showLogin() {
  document.getElementById("authOptions").classList.add("d-none");
  document.getElementById("loginForm").classList.remove("d-none");
  document.getElementById("registerForm").classList.add("d-none");

  document.getElementById("iconUser").classList.remove("d-none");
  document.getElementById("iconPlus").classList.add("d-none");
}

function showRegister() {
  document.getElementById("authOptions").classList.add("d-none");
  document.getElementById("registerForm").classList.remove("d-none");
  document.getElementById("loginForm").classList.add("d-none");

  document.getElementById("iconUser").classList.remove("d-none");
  document.getElementById("iconPlus").classList.remove("d-none");
}

function backToOptions() {
  document.getElementById("loginForm").classList.add("d-none");
  document.getElementById("registerForm").classList.add("d-none");
  document.getElementById("authOptions").classList.remove("d-none");

  document.getElementById("iconPlus").classList.add("d-none");
}
