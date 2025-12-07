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

const inputImagenes = document.getElementById("inputImagenes");
const previewContainer = document.getElementById("previewImagenes");

let archivosSeleccionados = [];

inputImagenes.addEventListener("change", function (e) {
  const files = Array.from(e.target.files);

  files.forEach((file) => {
    archivosSeleccionados.push(file);

    const reader = new FileReader();
    reader.onload = function (event) {
      const div = document.createElement("div");
      div.classList.add("preview-item");

      div.innerHTML = `
                <img src="${event.target.result}">
                <button type="button">&times;</button>
            `;

      // Eliminar imagen
      div.querySelector("button").addEventListener("click", () => {
        const index = archivosSeleccionados.indexOf(file);
        if (index > -1) archivosSeleccionados.splice(index, 1);
        div.remove();
        actualizarInput();
      });

      previewContainer.appendChild(div);
    };

    reader.readAsDataURL(file);
  });

  actualizarInput();
});

function actualizarInput() {
  const dataTransfer = new DataTransfer();
  archivosSeleccionados.forEach((file) => dataTransfer.items.add(file));
  inputImagenes.files = dataTransfer.files;
}

document.querySelectorAll("input[name='NuevaImagen']").forEach((input) => {
  input.addEventListener("change", function () {
    const previewId =
      "preview_edit_" + this.closest("tr").id.replace("edit", "");
    const preview = document.getElementById(previewId);

    const file = this.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = (e) => {
      preview.src = e.target.result;
      preview.classList.remove("d-none");
    };
    reader.readAsDataURL(file);
  });
});
