const form = document.querySelector('.cadastro-cliente');
const nome = document.querySelector('.nome');
const email = document.getElementById('email');
const campos = document.querySelectorAll('.required');
const spans = document.querySelectorAll('.span-required');
const emailRegex = /^[\w+.]+@\w+\.\w{2,}(?:\.\w{2})?$/;

form.addEventListener('submit', (event) => {
    function validar() {
        validaNome();
        validaSobrenome();
        mascaraCPF();
        validaEmail();
        comparaEmail();
        validaSenha();
        comparaSenha();
    }
    if (!validaNome() == true || !validaSobrenome() == true || !mascaraCPF() == true || !validaEmail() == true || comparaEmail == true || !comparaSenha() == true) {
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

function setErrorEmail() {
    campos[3].style.border = '1.5px solid #E63636';
    spans[4].style.display = 'block';
}

function removeErrorEmail() {
    campos[3].style.border = '';
    spans[4].style.display = 'none';
}
function setErrorConfEmail() {
    campos[4].style.border = '1.5px solid #E63636';
    spans[5].style.display = 'block';
}

function removeErrorConfEmail() {
    campos[4].style.border = '';
    spans[5].style.display = 'none';
}

function setErrorSenha() {
    campos[5].style.border = '1.5px solid #E63636';
    spans[6].style.display = 'block';
}

function removeErrorSenha() {
    campos[5].style.border = '';
    spans[6].style.display = 'none';
}
function setErrorConfSenha() {
    campos[6].style.border = '1.5px solid #E63636';
    spans[7].style.display = 'block';
}

function removeErrorConfSenha() {
    campos[6].style.border = '';
    spans[7].style.display = 'none';
}

function validaNome() {

    if (campos[0].value.length < 3) {
        setError(0);
        // console.log('nome invalido');
    } else {
        removeError(0);
        return true;
    }

}
function validaSobrenome() {

    if (campos[1].value.length < 3) {
        setError(1);
    } else {
        removeError(1);
        return true;
    }

}

//Essa função está mascarando o CPF para preenhcer os acentos
function mascaraCPF() {

    campos[2].addEventListener('keypress', () => {
        let cpflength = campos[2].value.length;

        if (cpflength === 3 || cpflength === 7) {
            campos[2].value += '.'
        } if (cpflength === 11) {
            campos[2].value += '-'
        }
    });
    var cpf = campos[2].value.replace(/\.|-/g, '');
    if (validaCPF(cpf) == true) {

        return true;
    }

}

function validaCPF(cpf) {

    var Soma;
    var Resto;
    Soma = 0;
    if (cpf == "00000000000") {
        setError(2);
    } else {
        for (i = 1; i <= 9; i++) Soma = Soma + parseInt(cpf.substring(i - 1, i)) * (11 - i);
        Resto = (Soma * 10) % 11;
        if ((Resto == 10) || (Resto == 11)) Resto = 0;
        if (Resto != parseInt(cpf.substring(9, 10))) {
            setError(2);
        }
        Soma = 0;
        for (i = 1; i <= 10; i++) Soma = Soma + parseInt(cpf.substring(i - 1, i)) * (12 - i);
        Resto = (Soma * 10) % 11;

        if ((Resto == 10) || (Resto == 11)) Resto = 0;
        if (Resto != parseInt(cpf.substring(10, 11))) setError(2);
        else {
            removeError(2);
            return true;
        }
    }

}

function validaEmail() {
    if (!emailRegex.test(campos[3].value)) {
        setErrorEmail();
    } else {
        removeErrorEmail();
        return true;
    }
}

function comparaEmail() {

    if (campos[3].value != campos[4].value) {
        setErrorConfEmail();
    } else {
        removeErrorConfEmail();
        return true;
    }

}

function validaSenha() {

    if (campos[5].value.length < 8) {
        setErrorSenha();
    } else {
        removeErrorSenha();
        comparaSenha();
    }

}

function comparaSenha() {

    if (campos[5].value != campos[6].value || campos[6].value.length < 8) {
        setErrorConfSenha();
    } else {
        removeErrorConfSenha();
        return true;
    }

}