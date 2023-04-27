const modal = document.getElementById("myModal");
const spanModal = document.getElementById("spanModal");
const checkbox = document.getElementsByClassName("myCheckbox");

var status_usuario;
var id_usuario;
var search = document.getElementById('pesquisar');

search.addEventListener("keydown",function(event){
  if(event.key == "Enter")
  {
    searchData();
  }
});

  function searchData(){
    window.location = 'GestaoUsuarios.php?search='+search.value;
  }

function abrirModal(id, status) {

  id_usuario = id;
  status_usuario = status;

  modal.style.display = "block";
  if (status_usuario == 1) {
    spanModal.textContent = 'inativar';
  } else {
    spanModal.textContent = 'ativar';
  }

}

// Obtém os botões de confirmação e cancelamento
var confirmarBtn = document.getElementById("confirmar");
var cancelarBtn = document.getElementById("cancelar");

// Adiciona um evento de clique para o botão de confirmação
confirmarBtn.addEventListener('click', () => {
  var novoStatus = 0;
  if (status_usuario == 1) {
    novoStatus = 2;
  } else {
    novoStatus = 1;
  }
  $.ajax({
    url: "alterarStatus.php",
    type: "post",
    data: {
      id: id_usuario,
      status: novoStatus,
      usuario: 'usuario'
    },
    success: window.location.href = "gestaoUsuarios.php"
  });
  modal.style.display = "none";

});

// Adiciona um evento de clique para o botão de cancelamento
cancelarBtn.addEventListener('click', function () {
  // Fecha o modal
  window.location.href = "gestaoUsuarios.php";

});


