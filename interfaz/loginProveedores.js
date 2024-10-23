// document.querySelector('#formRegistro').addEventListener('submit', (event) => {
//     event.preventDefault(); // Evita que el formulario se envíe y recargue la página
//     iniciarSesionUsu();
//   });
  
//   function iniciarSesionUsu() {
//     const email = document.querySelector("#email").value;
//     const password = document.querySelector("#password").value;
  
//     // Validar que ambos campos no estén vacíos
//     if (!email || !password) {
//       alert('Por favor, ingresa tu correo y contraseña.');
//       return;
//     }
  
//     // Crear el objeto con los datos a enviar
//     const datos = {
//       email: email,
//       password: password
//     };
  
//     // Configuración de la solicitud POST
//     fetch(`http://localhost/bytewizards/API/iniciarSesionProv.php?email=${email}&password=${password}`)
//     .then(response => response.json())
//     .then(usuario => {
//       console.log(usuario);
      
      
//       if (usuario.error) {
//         alert(usuario.error); // Mostrar error si hay uno
//       } else {
//         alert("¡Iniciado sesion con exito!"); 
//         location.href = "indexProveedores.php";
//       }
//     })
//     .catch(error => alert('Error al iniciar sesión:', error));
//   }
  


  document.querySelector('#formRegistro').addEventListener('submit', (event) => {
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
    fetch('http://localhost/bytewizards/API/iniciarSesionProv.php', {
      method: 'POST', // Cambiar a método POST
      headers: {
        'Content-Type': 'application/json' // Enviar datos como JSON
      },
      body: JSON.stringify(datos) // Convertir datos a JSON
    })
    .then(response => response.json())
    .then(usuario => {
      console.log(usuario);
      
      if (usuario.error) {
        alert(usuario.error); // Mostrar error si hay uno
      } else {
        alert("¡Sesión iniciada con éxito!"); 
        location.href = "indexProveedores.php";
      }
    })
    .catch(error => alert('Error al iniciar sesión:', error));
  }
  