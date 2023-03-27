const openModalButton = document.querySelector("#open-modalAtivar");
const closeModalButton = document.querySelector("#close-modalAtivar");
const modal = document.querySelector("#modalAtivar");
const fade = document.querySelector("#fadeAtivar");

const openModalButton2 = document.querySelector("#open-modalEditar");
const closeModalButton2 = document.querySelector("#close-modalEditar");
const modal2 = document.querySelector("#modalEditar");
const fade2 = document.querySelector("#fadeEditar");

const toggleModal = () => {
  modalAtivar.classList.toggle("hide");
  fadeAtivar.classList.toggle("hide");
};

const toggleModal2 = () => {
  modalEditar.classList.toggle("hide");
  fadeEditar.classList.toggle("hide");
};

[openModalButton, closeModalButton, fadeAtivar].forEach((el) => {
  el.addEventListener("click", () => toggleModal());
});

[openModalButton2, closeModalButton2, fadeEditar].forEach((el2) => {
  el2.addEventListener("click", () => toggleModal2());
});


var editarSenha = document.querySelector("#editarSenha");
var editarSenha2 = document.querySelector("#editarSenha2");

editarSenha.disabled = true;
editarSenha2.disabled = true;

function enable() {
  document.querySelector("#editarSenha").disabled = false;
  document.querySelector("#editarSenha2").disabled = false;
}

function disable() {
  document.querySelector("#editarSenha").disabled = true;
  document.querySelector("#editarSenha2").disabled = true;
}

