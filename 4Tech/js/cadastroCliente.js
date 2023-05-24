
function copiarEndereco() {
    let checkboxEntrega = document.getElementById('copiarEndereco');
    // let cepEntrega = document.getElementById('txtCepEntrega');
    let areaEntrega = document.querySelector('.enderecos-entrega');
    let inputEntrega = areaEntrega.querySelectorAll('input');

    if (checkboxEntrega.checked) {
        areaEntrega.style.display = "none";
        for(let i =0;i<inputEntrega.length;i++){
            inputEntrega[i].removeAttribute("required");
        }
    }
    else{
        areaEntrega.style.display = "block";
        for(let i =0;i<inputEntrega.length;i++){
        inputEntrega[i].setAttribute("required","required");
    }
    }
}

document.getElementById('copiarEndereco').addEventListener("click",copiarEndereco);

// let contador = 1;
// function adicionarEndereco() {
//     const primeiroEndereco = document.querySelector('.endereco');
//     const novoEndereco = primeiroEndereco.cloneNode(true);
//     novoEndereco.querySelectorAll('input').forEach(function (campo) {
//         campo.value = '';
//         campo.name = campo.name + contador;
//     });
//     contador++;
//     document.querySelector('.enderecos-entrega').appendChild(novoEndereco);
// }