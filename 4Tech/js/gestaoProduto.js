// seleciona o elemento checkbox e adiciona um evento onclick
document.getElementById("myCheckbox").onclick = function() {
    // seleciona o elemento de texto
    var textElement = document.getElementById("myText");
    // verifica se o checkbox está marcado
    if (this.checked) {
      // atualiza o texto
      textElement.innerHTML = "Ativado";
    } else {
      // atualiza o texto
      textElement.innerHTML = "Desativado";
    }
  }

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
