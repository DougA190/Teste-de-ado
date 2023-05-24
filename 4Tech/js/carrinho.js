/* Inicio do carrinho de compras*/
// Função para carregar o carrinho de compras salvo na sessão
window.addEventListener("load", function carregarCarrinhoSalvo() {
    var carrinhoSalvo = JSON.parse(localStorage.getItem("carrinho")) || [];
    var carrinho = document.querySelector("#tbl-carrinho tbody");
    for (var i = 0; i < carrinhoSalvo.length; i++) {
        var imagemProduto = carrinhoSalvo[i].imagem;
        var nomeProduto = carrinhoSalvo[i].nome;
        var precoProduto = carrinhoSalvo[i].preco;
        var qtdProduto = carrinhoSalvo[i].quantidade;
        var item = document.createElement("tr");
        item.classList.add("item-carrinho");
        item.innerHTML = "<td class='col-item'><img src='img/" + imagemProduto + "' alt='" + nomeProduto + "' width='80' data-imagem='" + imagemProduto + "'> <p class='nomeProduto'>" + nomeProduto + "</p></td> <td class='col-preco'><span class='precoProduto'>" + precoProduto.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }) + "</span></td> <td class='col-quantidade'><input type='number' value='" + qtdProduto + "' min='1' class='qtdProduto' onchange='calculaPrecoTotal()'> <button class='btn btn-danger' onclick='removerItem(this)'><i class='bi bi-trash'></i></button></td>";
        carrinho.appendChild(item);
    }
    calculaPrecoTotal();
});

function adicionarNoCarrinho(button) {
    let nomeProduto = button.getAttribute('data-nome');
    let imagemProduto = button.getAttribute('data-imagem');
    let precoProduto = parseFloat(button.getAttribute('data-preco').replace(",", "."));
    var carrinho = document.querySelector("#tbl-carrinho tbody");
    var carrinhoSalvo = JSON.parse(localStorage.getItem("carrinho")) || [];
    // Verifica se já existe um item com o mesmo nome
    var itemJaExiste = false;
    var qtdItens = 0;
    for (var i = 0; i < carrinhoSalvo.length; i++) {
        if (carrinhoSalvo[i].nome === nomeProduto) {
            carrinhoSalvo[i].quantidade++;
            const carrinhoCompras = document.querySelectorAll('.item-carrinho');
            parseInt(qtdItens = carrinhoSalvo[i].quantidade);
            carrinhoCompras[i].getElementsByClassName('qtdProduto')[0].value = qtdItens;
            itemJaExiste = true;
            break;
        }
    }

    // Se não encontrou um item com o mesmo nome, adiciona um novo item no carrinhoSalvo
    if (!itemJaExiste) {
        var item = document.createElement("tr");
        item.classList.add("item-carrinho");
        item.innerHTML = "<td class='col-item'><img src='img/" + imagemProduto + "' alt='" + nomeProduto + "' width='80' data-imagem='" + imagemProduto + "'> <p class='nomeProduto'>" + nomeProduto + "</p></td> <td class='col-preco'><span class='precoProduto'>" + precoProduto.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }) + "</span></td> <td class='col-quantidade'><input type='number' value='1' min='1' class='qtdProduto' onchange='calculaPrecoTotal()'> <button class='btn btn-danger' onclick='removerItem(this)'><i class='bi bi-trash'></i></button></td>";
        carrinho.appendChild(item);

        var produto = {
            nome: nomeProduto,
            imagem: imagemProduto,
            preco: precoProduto,
            quantidade: 1
        };
        carrinhoSalvo.push(produto);
    }
    localStorage.setItem("carrinho", JSON.stringify(carrinhoSalvo));
    calculaPrecoTotal();
}

function removerItem(button) {
    // Estou associando toda a coluna do botao na variavel coluna
    var coluna = button.parentNode;
    // Estou associando todas as colunas da tabela na variavel linha
    var linha = coluna.parentNode;
    var itemImg = linha.getElementsByTagName("img")[0];
    // Obter o nome do item da linha produto da tabela
    var imagemProduto = itemImg.getAttribute("data-imagem");
    // Remover o item da lista armazenada no localStorage
    var items = JSON.parse(localStorage.getItem("carrinho")) || [];
    var updatedItems = items.filter(function (item) {
        return item.imagem !== imagemProduto;
    });
    localStorage.setItem("carrinho", JSON.stringify(updatedItems));
    // Remover o elemento da tabela na página
    coluna.parentNode.remove(coluna);
    calculaPrecoTotal();
}

function calculaPrecoTotal() {
    // var spanFrete = document.getElementsById('valorFrete');
    let frete1 = document.getElementById('frete1');
    let frete2 = document.getElementById('frete2');
    console.log(frete1);
    let frete3 = document.getElementById('frete3');
    valorFrete = 0;
    if (frete1) {
        if(frete1.checked){
            alert('entrei');
            valorFrete += 20;
        }
    }
    if (frete2) {
        if(frete2.checked){
            valorFrete += 30;
        }
    }
    if (frete3) {
        if(frete3.checked){
            valorFrete += 40;
        }
    }

    const carrinhoCompras = document.querySelectorAll('.item-carrinho');
    total = 0;
    
    for (var i = 0; i < carrinhoCompras.length; i++) {
        const precoProduto = carrinhoCompras[i].getElementsByClassName('precoProduto')[0].innerText.replace("R$", "").replace(".", "").replace(",", ".");
        const qtdProduto = carrinhoCompras[i].getElementsByClassName('qtdProduto')[0].value;
        var carrinhoSalvo = JSON.parse(localStorage.getItem("carrinho"));
        for (let i = 0; i < carrinhoSalvo.length; i++) {
            carrinhoSalvo[i].quantidade = parseInt(qtdProduto);
        }
        localStorage.setItem('carrinho', JSON.stringify(carrinhoSalvo));
        total += parseFloat(precoProduto) * qtdProduto;
        totalGeral = total + valorFrete;
    }
    document.getElementById('precoCompra').innerText = totalGeral.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
    contaItens();
}

function contaItens() {
    var itensCarrinho = 0;
    var qtdProdutos = document.querySelectorAll('.qtdProduto');
    for (let i = 0; i < qtdProdutos.length; i++) {
        itensCarrinho += parseInt(qtdProdutos[i].value);
    }
    var contadorItens = document.getElementById('contador_carrinho');
    if(contadorItens){

        contadorItens.innerHTML = itensCarrinho;
    }
}