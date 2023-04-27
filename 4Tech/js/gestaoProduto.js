// Area de pesquisa
  var search = document.getElementById('pesquisar');

search.addEventListener("keydown",function(event){
  if(event.key == "Enter")
  {
    searchData();
  }
});

  function searchData(){
    window.location = 'GestaoProdutos.php?search='+search.value;
  }

 

// Area do modal
const modal = document.getElementById("myModal");
const spanModal = document.getElementById("spanModal");

function abrirModal(id, status) {
  id_produto = id;
  status_produto = status;

  modal.style.display = "block";
  if (status_produto == 1) {
    spanModal.textContent = 'desativar';
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
  if (status_produto == 1) {
    novoStatus = 2;
  } else {
    novoStatus = 1;
  }
  $.ajax({
    url: "alterarStatus.php",
    type: "post",
    data: {
      id: id_produto,
      status: novoStatus,
      produto: 'produto'
    },
    success: window.location.href = "GestaoProdutos.php"
  });
  modal.style.display = "none";

});

// Adiciona um evento de clique para o botão de cancelamento
cancelarBtn.addEventListener('click', function () {
  // Fecha o modal
  window.location.href = "GestaoProdutos.php";

});


