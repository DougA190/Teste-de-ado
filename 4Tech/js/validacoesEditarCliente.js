const form = document.getElementById('form-edicao');
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
    }
    if (!validaNome() == true || !mascaraCPF() == true || !validaEmail() == true || !comparaSenha() == true || !validaData() == true) {
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

    if (campos[1].value.length < 3) {
        setError(1);
        console.log('erro acontece aqui');
    } else {
        removeError(1);
        return true;
    }

}

function validaSobreNome() {

    if (campos[2].value.length < 3) {
        setError(2);
        console.log('erro acontece aqui');
    } else {
        removeError(2);
        return true;
    }

}

// function validaData(dateString) {

//     let pattern = /^\d{2}-\d{2}-\d{4}$/;
//     return pattern.test(dateString);

//   }

//Essa função está mascarando o CPF para preenhcer os acentos
function mascaraCPF() {

    campos[3].addEventListener('keypress', () => {
        let cpflength = campos[3].value.length;

        if (cpflength === 3 || cpflength === 7) {
            campos[3].value += '.'
        } if (cpflength === 11) {
            campos[3].value += '-'
        }
    });
    var cpf = campos[3].value.replace(/\.|-/g, '');
    if (validaCPF(cpf) == true) {
        return true;
    }

}

function validaCPF(cpf) {
    var Soma;
    var Resto;
    Soma = 0;
    if (cpf == "00000000000") {
        setError(3);
    } else {
        for (var i = 1; i <= 11; i++) Soma = Soma + parseInt(cpf.substring(i - 1, i)) * (11 - i);
        Resto = (Soma * 10) % 11;
        if ((Resto == 10) || (Resto == 11)) Resto = 0;
        if (Resto != parseInt(cpf.substring(9, 10))) {
            console.log('erro acontece aqui');
            setError(3);
        }

        Soma = 0;
        for (i = 1; i <= 10; i++) Soma = Soma + parseInt(cpf.substring(i - 1, i)) * (12 - i);
        Resto = (Soma * 10) % 11;

        if ((Resto == 10) || (Resto == 11)) Resto = 0;
        if (Resto != parseInt(cpf.substring(10, 11))) {
            console.log('erro acontece aqui');
            setError(3);
        }
        else {
            removeError(3);
            return true;
        }
    }

}

function validaEmail() {
    if (!emailRegex.test(campos[4].value)) {
        setError(4);
    } else {
        removeError(4);
        return true;
    }
}

function validaSenha() {
    if (!campos[6]) {
        console.error("Campo não encontrado");
        return;
    }

    if (campos[6].value.length < 8) {
        setError(6);
    } else {
        removeError(6);
        comparaSenha();
    }
}

function comparaSenha() {
    if (campos[6].value != campos[7].value || campos[7].value.length < 8) {
        setError(7);
    } else if (campos[6].value !== '' && campos[7].value === '') {
        setError(7);
    } else {
        removeError(7);
        return true;
    }
}