function copiarEndereco() {
    let checkboxEntrega = document.getElementById('copiarEndereco');
    let areaEntrega = document.querySelector('.endereco-entrega');

    if (checkboxEntrega.checked) {
        areaEntrega.style.display = "none";
    }
    else{
        areaEntrega.style.display = "block"; 
    }
}
