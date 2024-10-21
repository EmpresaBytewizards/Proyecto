document.querySelector('.inicioSesion').addEventListener('submit', (event) => {
  event.preventDefault(); // Evita que el formulario se envíe y recargue la página
  iniciarSesionUsu();
});

function iniciarSesionUsu() {
  const email = document.querySelector("#email").value;
  const password = document.querySelector("#password").value;

  // Validar que ambos campos no estén vacíos
  if (!email || !password) {
    alert('Por favor, ingresa tu correo y contraseña.');
    return;
  }

  // Crear el objeto con los datos a enviar
  const datos = {
    email: email,
    password: password
  };

  // Configuración de la solicitud POST
  fetch(`http://localhost/bytewizards/API/iniciarSesionUsu.php?email=${email}&password=${password}`)
  .then(response => response.json())
  .then(usuario => {
    console.log(usuario);
    alert("¡Iniciado sesion con exito!"); 
    location.reload();
    if (usuario.error) {
      alert(usuario.error); // Mostrar error si hay uno
    } else {
      // Aquí puedes hacer algo con la respuesta, por ejemplo redirigir al usuario o mostrar un mensaje
    }
  })
  .catch(error => alert('Error al iniciar sesión:', error));
}
