function buscaCep() {
    // Crio as váriaveis que serão utilizadas para a busca do cep
    let cep = document.getElementById("txtCep").value;
    let url = "https://viacep.com.br/ws/" + cep + "/json";

    let req = new XMLHttpRequest();
    req.open("GET", url);
    req.send()

    // Trato o retorno da requisição
    req.onload = function () {
        if (req.status === 200) {
            let endereco = JSON.parse(req.response);
            document.getElementById("txtLogradouro").value = endereco.logradouro;
            document.getElementById("txtBairro").value = endereco.bairro;
            document.getElementById("txtCidade").value = endereco.localidade;
            document.getElementById("slcUf").value = endereco.uf; 
        }
        else if (req.status === 404) {
            alert("Digite um CEP válido");
        }
        else {
            alert("Erro ao fazer requisição");
        }
    }

}

function buscaCepEntrega(){
    // Crio as váriaveis que serão utilizadas para a busca do cep
    let cepEntrega = document.getElementById("txtCepEntrega").value;
    let urlEntrega = "https://viacep.com.br/ws/" + cepEntrega + "/json";

    let reqEntrega = new XMLHttpRequest();
    reqEntrega.open("GET", urlEntrega);
    reqEntrega.send()

    // Trato o retorno da requisição
    reqEntrega.onload = function () {
        if (reqEntrega.status === 200) {
            let enderecoEntrega = JSON.parse(reqEntrega.response);
            
            document.getElementById("txtLogradouroEntrega").value = enderecoEntrega.logradouro;
            document.getElementById("txtBairroEntrega").value = enderecoEntrega.bairro;
            document.getElementById("txtCidadeEntrega").value = enderecoEntrega.localidade;
            document.getElementById("slcUfEntrega").value = enderecoEntrega.uf;
        }
        else if (reqEntrega.status === 404) {
            alert("Digite um CEP válido");
        }
        else {
            alert("Erro ao fazer requisição");
        }
    }
}

window.addEventListener("load", (event) => {
    let txtCep = document.getElementById("txtCep");
    txtCep.addEventListener("blur", buscaCep);
    let txtCepEntrega = document.getElementById("txtCepEntrega");
    txtCepEntrega.addEventListener("blur", buscaCepEntrega);
});