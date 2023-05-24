
window.addEventListener("load", (event) => {
    const descricao = document.querySelectorAll('.card-text');
    for (let i = 0; i < descricao.length; i++) {
        var texto = descricao[i].textContent;
        let textoCurto = texto.substring(0, 10);
        descricao[i].textContent = textoCurto;
        
    }
});



