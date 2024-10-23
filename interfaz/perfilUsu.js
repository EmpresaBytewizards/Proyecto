document.querySelector('#cambiarPassword').addEventListener('input', validatePassword);
document.querySelector('#password2').addEventListener('input', validatePassword);

function validatePassword() {
    const password = document.getElementById('cambiarPassword').value;
    const password2 = document.getElementById('password2').value;

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
        document.getElementById('password2').setCustomValidity("Las contraseñas no coinciden.");
    } else {
        document.getElementById('password2').setCustomValidity('');
    }

    // Mensaje de que si la contraseña no cumple con los criterios
    if (!isValid) {
        document.getElementById('cambiarPassword').setCustomValidity("La contraseña no cumple los requerimientos.");
    } else {
        document.getElementById('cambiarPassword').setCustomValidity('');
    }
    
}



// Función para manejar la edicion de usuarios
document.getElementById('perfilUsu').addEventListener('submit', function(event) {
    event.preventDefault();

    // Recolectar los datos del formulario de creacion de usuarios
    const formData = new FormData(this);
    const data = {};
    formData.forEach((value, key) => {
      data[key] = value;
    });

    // Enviar los datos al servidor para actualizar el perfil
    fetch('http://localhost/bytewizards/API/editarPerfilUsu.php', {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(responseData => {
      console.log(responseData.message);
      alert("¡Cuenta editada exitosamente!");
      location.reload();
    }).catch(error => alert('Error al crear a:', error));
});