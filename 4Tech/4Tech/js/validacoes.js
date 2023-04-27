const form = document.getElementById('form-cadastro');
const campos = document.querySelectorAll('.required');
const spans = document.querySelectorAll('.span-required');
const emailRegex = /^[\w+.]+@\w+\.\w{2,}(?:\.\w{2})?$/;

form.addEventListener('submit', (event) => {
    
        function validar() {
            validaNome();
            mascaraCPF();
            validaEmail();
            validaSenha();
            comparaSenha();
            validaGrupo();
        }
        if (!validaNome() == true || !mascaraCPF() == true || !validaEmail() == true || !comparaSenha() == true || !validaGrupo() == true) {
            event.preventDefault();
            validar();
        }
    

});

function setError(index) {
    campos[index].style.border = '1.5px solid #E63636';
    spans[index].style.display = 'block';
}

function removeError(index) {
    campos[index].style.border = '';
    spans[index].style.display = 'none';
}

function validaNome() {

    if (campos[0].value.length < 3) {
        setError(0);
    } else {
        removeError(0);
        return true;
    }

}

//Essa função está mascarando o CPF para preenhcer os acentos
function mascaraCPF() {

    campos[1].addEventListener('keypress', () => {
        let cpflength = campos[1].value.length

        if (cpflength === 3 || cpflength === 7) {
            campos[1].value += '.'
        } if (cpflength === 11) {
            campos[1].value += '-'
        }
    });
    var cpf = campos[1].value.replace(/\.|-/g, '');
    if (validaCPF(cpf) == true) {

        return true;
    }

}

function validaCPF(cpf) {

    var Soma;
    var Resto;
    Soma = 0;
    if (cpf == "00000000000") {
        setError(1);
    } else {
        for (i = 1; i <= 9; i++) Soma = Soma + parseInt(cpf.substring(i - 1, i)) * (11 - i);
        Resto = (Soma * 10) % 11;

        if ((Resto == 10) || (Resto == 11)) Resto = 0;
        if (Resto != parseInt(cpf.substring(9, 10))) {
            setError(1);
        }

        Soma = 0;
        for (i = 1; i <= 10; i++) Soma = Soma + parseInt(cpf.substring(i - 1, i)) * (12 - i);
        Resto = (Soma * 10) % 11;

        if ((Resto == 10) || (Resto == 11)) Resto = 0;
        if (Resto != parseInt(cpf.substring(10, 11))) setError(1);
        else {
            removeError(1);
            return true;
        }
    }

}

function validaEmail() {
    if (!emailRegex.test(campos[2].value)) {
        setError(2);
    } else {
        removeError(2);
        return true;
    }
}


function validaSenha() {
    
        if (campos[3].value.length < 8) {
            setError(3);
        } else {
            removeError(3);
            comparaSenha();
        }

}

function comparaSenha() {
    
        if (campos[3].value != campos[4].value || campos[4].value.length < 8) {
            setError(4);
        } else {
            removeError(4);
            return true;
        }

}

function validaGrupo() {
    
        if (!campos[5].checked == true) {
            spans[5].style.display = 'block';
        } else {
            spans[5].style.display = 'none';
            return true;

        } if (!campos[6].checked == true) {
            spans[6].style.display = 'block';
        } else {
            spans[5].style.display = 'none';
            return true;
        }
 
}