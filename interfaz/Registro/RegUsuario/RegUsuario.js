document.querySelector('#contraseña_comprador').addEventListener('input', validatePassword);
document.querySelector('#confirmar_contraseña').addEventListener('input', validatePassword);

function validatePassword() {
    const password = document.getElementById('contraseña_comprador').value;
    const password2 = document.getElementById('confirmar_contraseña').value;

    const caractMin = document.getElementById('caractMin');
    const mayMin = document.getElementById('mayMin');
    const minMin = document.getElementById('minMin');
    const minNum = document.getElementById('minNum');

    let isValid = true;

    // Minimo 5 caracteres
    if (password.length >= 5) {
        caractMin.classList.remove('reject');
        caractMin.classList.add('accept');
    } else {
        caractMin.classList.remove('accept');
        caractMin.classList.add('reject');
        isValid = false;
    }

    // Minimo 1 mayuscula
    if (/[A-Z]/.test(password)) {
        mayMin.classList.remove('reject');
        mayMin.classList.add('accept');
    } else {
        mayMin.classList.remove('accept');
        mayMin.classList.add('reject');
        isValid = false;
    }

    // Minimo 1 minuscula
    if (/[a-z]/.test(password)) {
        minMin.classList.remove('reject');
        minMin.classList.add('accept');
    } else {
        minMin.classList.remove('accept');
        minMin.classList.add('reject');
        isValid = false;
    }

    // Al menos 1 numero
    if (/\d/.test(password)) {
        minNum.classList.remove('reject');
        minNum.classList.add('accept');
    } else {
        minNum.classList.remove('accept');
        minNum.classList.add('reject');
        isValid = false;
    }

    // Verificar si las contraseñas coinciden
    if (password !== password2) {
        document.getElementById('confirmar_contraseña').setCustomValidity("The passwords do not match.");
    } else {
        document.getElementById('confirmar_contraseña').setCustomValidity('');
    }

    // Mensaje de que si la contraseña no cumple con los criterios
    if (!isValid) {
        document.getElementById('contraseña_comprador').setCustomValidity("The password does not meet the requirements.");
    } else {
        document.getElementById('contraseña_comprador').setCustomValidity('');
    }
}

