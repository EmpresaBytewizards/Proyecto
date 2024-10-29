const dropdownIcon = document.querySelector("#menu__icon");
const dropdown = document.querySelector(".dropdown");

function toggleLoggin() {
    document.querySelector(".loggin").classList.toggle("active");
    document.querySelector(".loggin").classList.toggle("inactive");
}

document.addEventListener('DOMContentLoaded', function() {
    articulos();
    usuarios();
    proveedores();
    denuncias();
    admin();
    staff();
    carrito();
    venta();
});

function articulos() {
    let articlesTableBody = document.getElementById('articulosTabla');
    if (!articlesTableBody) {
        // Si la tabla no existe, termina la función
        return;
    }
    fetch('../API/todosProductos.php')
    .then(res => res.json())
    .then(json => {
        listProducts = json;      
        let articlesTableBody = document.getElementById('articulosTabla').querySelector('tbody');
        for (let i = 0; i < json.length; i++) {
            let row = document.createElement('tr');
            row.setAttribute('data-id', json[i].id_producto);
            if (json[i].habilitacion_producto == "Deshabilitado") {
                row.innerHTML = `
                <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0);">${json[i].id_producto}</td>
                <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0);">${json[i].id_empresa_producto}</td>
                <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0);">${json[i].titulo}</td>
                <td><button onclick="toggleStatus(this)" style="background-color: rgb(136, 57, 0); color: #fff; padding: 6px 25px; border: none; cursor: pointer;" class="deshabilitado">Habilitar</button></td>
            `;
            }else{
                row.innerHTML = `
                <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0);">${json[i].id_producto}</td>
                <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0);">${json[i].id_empresa_producto}</td>
                <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0);">${json[i].titulo}</td>
                <td><button onclick="toggleStatus(this)" style="background-color: rgb(184, 77, 0); color: #fff; padding: 6px 25px; border: none; cursor: pointer;">Deshabilitar</button></td>
            `;
            }
            
            articlesTableBody.appendChild(row);
        };
    });
}

function proveedores() {
    let articlesTableBody = document.getElementById('proveedoresTabla');
    if (!articlesTableBody) {
        // Si la tabla no existe, termina la función
        return;
    }
    fetch('../API/todosProveedores.php')
    .then(res => res.json())
    .then(json => {
        listUsers = json;      
        let articlesTableBody = document.getElementById('proveedoresTabla').querySelector('tbody');
        for (let i = 0; i < json.length; i++) {
            let row = document.createElement('tr');
            row.setAttribute('data-id', json[i].id_empresa);
            if (json[i].habilitacion_empresa == "Deshabilitado") {
                row.innerHTML = `
                <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0);">${json[i].id_empresa}</td>
                <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0);">${json[i].nombre_empresa}</td>
                <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0);">${json[i].mail_empresa}</td>
                <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0);">${json[i].telefono_empresa}</td>
                <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0);">${json[i].ubicacion_fisica}</td>
                <td><button onclick="toggleStatus(this)" style="background-color: rgb(136, 57, 0); color: #fff; padding: 6px 25px; border: none; cursor: pointer;" class="deshabilitado">Habilitar</button></td>
            `;
            }else{
                row.innerHTML = `
                <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0);">${json[i].id_empresa}</td>
                <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0);">${json[i].nombre_empresa}</td>
                <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0);">${json[i].mail_empresa}</td>
                <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0);">${json[i].telefono_empresa}</td>
                <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0);">${json[i].ubicacion_fisica}</td>
                <td><button onclick="toggleStatus(this)" style="background-color: rgb(184, 77, 0); color: #fff; padding: 6px 25px; border: none; cursor: pointer;">Deshabilitar</button></td>
            `;
            }
            articlesTableBody.appendChild(row);
        };
    });
}

function usuarios() {
    let articlesTableBody = document.getElementById('compradoresTabla');
    if (!articlesTableBody) {
        // Si la tabla no existe, termina la función
        return;
    }
    fetch('../API/todosUsuarios.php')
    .then(res => res.json())
    .then(json => {
        listProducts = json;      
        let articlesTableBody = document.getElementById('compradoresTabla').querySelector('tbody');
        for (let i = 0; i < json.length; i++) {
            let row = document.createElement('tr');
            row.setAttribute('data-id', json[i].id_usu);
            if (json[i].habilitacion_usu == "Deshabilitado") {
                row.innerHTML = `
                    <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0);">${json[i].id_usu}</td>
                    <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0);">${json[i].nombre_usu}</td>
                    <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0);">${json[i].mail_usu}</td>
                    <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0);">${json[i].telefono_usu}</td>
                    <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0);">${json[i].direccion_usu}</td>
                    <td><button onclick="toggleStatus(this)" style="background-color: rgb(136, 57, 0); color: #fff; padding: 6px 25px; border: none; cursor: pointer;" class="deshabilitado">Habilitar</button></td>
            `;
            }else{
                row.innerHTML = `
                    <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0);">${json[i].id_usu}</td>
                    <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0);">${json[i].nombre_usu}</td>
                    <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0);">${json[i].mail_usu}</td>
                    <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0);">${json[i].telefono_usu}</td>
                    <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0);">${json[i].direccion_usu}</td>
                    <td><button onclick="toggleStatus(this)" style="background-color: rgb(184, 77, 0); color: #fff; padding: 6px 25px; border: none; cursor: pointer;">Deshabilitar</button></td>
            `;
            }
            articlesTableBody.appendChild(row);
        };
    });
}


function denuncias() {
    let articlesTableBody = document.getElementById('denunciasTabla');
    if (!articlesTableBody) {
        // Si la tabla no existe, termina la función
        return;
    }
    fetch('../API/todosDenuncias.php')
    .then(res => res.json())
    .then(json => {
        listProducts = json;      
        let articlesTableBody = document.getElementById('denunciasTabla').querySelector('tbody');
        for (let i = 0; i < json.length; i++) {
            let row = document.createElement('tr');
            row.setAttribute('data-id', json[i].id_denuncia);
            row.innerHTML = `
                <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0);">${json[i].id_denuncia}</td>
                <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0);">${json[i].tipo_denunciante}</td>
                <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0);">${json[i].id_denunciante}</td>
                <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0);">${json[i].tipo_denunciado}</td>
                <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0);">${json[i].id_denunciado}</td>
                <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0);">${json[i].fecha_denuncia}</td>
                <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0);">
                    <select style="padding: 5px 10px; font-size: 14px; background-color: rgb(184, 77, 0); border: 1px solid #ddd; border-radius: 5px; outline: none; cursor: pointer; transition: all 0.3s ease;" onchange="updateDenunciaStatus(this)">
                        <option value="Solucionada" ${json[i].estado_denuncia === 'Solucionada' ? 'selected' : ''}>Solucionada</option>
                        <option value="Pendiente" ${json[i].estado_denuncia === 'Pendiente' ? 'selected' : ''}>Pendiente</option>
                        <option value="Descartada" ${json[i].estado_denuncia === 'Descartada' ? 'selected' : ''}>Descartada</option>
                    </select>
                </td>
            `;
            articlesTableBody.appendChild(row);
        };
    });
}


function admin() {
    let articlesTableBody = document.getElementById('modTabla');
    if (!articlesTableBody) {
        // Si la tabla no existe, termina la función
        return;
    }
    fetch('../API/todosModeradores.php')
    .then(res => res.json())
    .then(json => {
        listProducts = json;      
        let articlesTableBody = document.getElementById('modTabla').querySelector('tbody');
        for (let i = 0; i < json.length; i++) {
            let row = document.createElement('tr');
            row.setAttribute('data-id', json[i].id_staff);
            row.innerHTML = `
                <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0);">${json[i].id_staff}</td>
                <td style="border: 1px solid #ddd; background-color: rgb(255, 106, 0)">${json[i].nombre_staff}</td>
                <td style="border: 1px solid #ddd; background-color: rgb(255, 106, 0)">${json[i].mail_staff}</td>
                <td style="border: 1px solid #ddd; background-color: rgb(255, 106, 0)">${json[i].telefono_staff}</td>
                <td style="border: 1px solid #ddd; background-color: rgb(255, 106, 0)">${json[i].ubicacion_staff}</td>
                <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0)">
                    <select style="padding: 5px 10px; font-size: 14px; background-color: rgb(184, 77, 0); border: 1px solid #ddd; border-radius: 5px; outline: none; cursor: pointer; transition: all 0.3s ease;" onchange="updateModStatus(this)">
                        <option value="Moderador" ${json[i].tipo_staff === "Moderador" ? "selected" : ""}>Moderador</option>
                        <option value="Organizador" ${json[i].tipo_staff === "Organizador" ? "selected" : ""}>Organizador</option>
                        <option value="Deshabilitado" ${json[i].tipo_staff === "Deshabilitado" ? "selected" : ""}>Deshabilitado</option>
                    </select>
                </td>
            `;
            articlesTableBody.appendChild(row);
        };
    });
}


function staff() {
    let articlesTableBody = document.getElementById('staffTabla');
    if (!articlesTableBody) {
        // Si la tabla no existe, termina la función
        return;
    }
    fetch('../API/todosStaffs.php')
    .then(res => res.json())
    .then(json => {
        listProducts = json;      
        let articlesTableBody = document.getElementById('staffTabla').querySelector('tbody');
        for (let i = 0; i < json.length; i++) {
            let row = document.createElement('tr');
            row.setAttribute('data-id', json[i].id_staff);
            row.innerHTML = `
                <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0);">${json[i].id_staff}</td>
                <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0);">${json[i].nombre_staff}</td>
                <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0);">${json[i].mail_staff}</td>
                <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0);">${json[i].telefono_staff}</td>
                <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0);">${json[i].ubicacion_staff}</td>
                <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0)">
                    <select style="padding: 5px 10px; font-size: 14px; background-color: rgb(184, 77, 0); border: 1px solid #ddd; border-radius: 5px; outline: none; cursor: pointer; transition: all 0.3s ease;" onchange="updateStaffStatus(this)">
                        <option value="Admin" ${json[i].tipo_staff === "Admin" ? "selected" : ""}>Admin</option>
                        <option value="Moderador" ${json[i].tipo_staff === "Moderador" ? "selected" : ""}>Moderador</option>
                        <option value="Organizador" ${json[i].tipo_staff === "Organizador" ? "selected" : ""}>Organizador</option>
                        <option value="Deshabilitado" ${json[i].tipo_staff === "Deshabilitado" ? "selected" : ""}>Deshabilitado</option>
                    </select>
                </td>
            `;
            articlesTableBody.appendChild(row);
        };
    });
}

function carrito() {
    let articlesTableBody = document.getElementById('carritoTabla');
    if (!articlesTableBody) {
        // Si la tabla no existe, termina la función
        return;
    }
    fetch('../API/todosCarritos.php')
    .then(res => res.json())
    .then(json => {
        listProducts = json;      
        let articlesTableBody = document.getElementById('carritoTabla').querySelector('tbody');
        for (let i = 0; i < json.length; i++) {
            let row = document.createElement('tr');
            row.setAttribute('data-id', json[i].id_carrito);
            row.innerHTML = `
                <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0);">${json[i].id_carrito}</td>
                <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0);">${json[i].id_usu_carrito}</td>
                <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0);">${json[i].fecha_peticion}</td>
                <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0);">${json[i].envio}</td>
                <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0);">${json[i].precio_carrito}$</td>
                <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0)">
                    <select style="padding: 5px 10px; font-size: 14px; background-color: rgb(184, 77, 0); border: 1px solid #ddd; border-radius: 5px; outline: none; cursor: pointer; transition: all 0.3s ease;" onchange="updateCarritoStatus(this)">
                        <option value="empaquetando" ${json[i].estado === "empaquetando" ? "selected" : ""}>Empaquetando</option>
                        <option value="en_camino" ${json[i].estado === "en_camino" ? "selected" : ""}>En camino</option>
                        <option value="entregado" ${json[i].estado === "entregado" ? "selected" : ""}>Entregado</option>
                        <option value="empaquetando_devolucion" ${json[i].estado === "empaquetando_devolucion" ? "selected" : ""}>Empaquetando Devolucion</option>
                        <option value="enviado_devolucion" ${json[i].estado === "enviado_devolucion" ? "selected" : ""}>Enviando Devolucion</option>
                        <option value="entregado_devolucion" ${json[i].estado === "entregado_devolucion" ? "selected" : ""}>Devuelto</option>
                    </select>
                </td>
            `;
            articlesTableBody.appendChild(row);
        };
    });
}

function venta() {
    let articlesTableBody = document.getElementById('carritoTabla');
    if (!articlesTableBody) {
        // Si la tabla no existe, termina la función
        return;
    }
    fetch('../API/todosVentas.php')
    .then(res => res.json())
    .then(json => {
        listProducts = json;      
        let articlesTableBody = document.getElementById('ventaTabla').querySelector('tbody');
        for (let i = 0; i < json.length; i++) {
            let row = document.createElement('tr');
            row.setAttribute('data-id', json[i].id_carrito);
            row.innerHTML = `
                <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0);">${json[i].id_contiene}</td>
                <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0);">${json[i].id_carrito_contiene}</td>
                <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0);">${json[i].id_empresa_contiene}</td>
                <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0);">${json[i].id_producto_contiene}</td>
                <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0);">${json[i].fecha_contiene}</td>
                <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0);">${json[i].precio_contiene}$</td>
            `;
            articlesTableBody.appendChild(row);
        };
    });
}


function filterList(tableId, searchInputId) {
    let input = document.getElementById(searchInputId);
    let filter = input.value.toUpperCase();
    let table = document.getElementById(tableId);
    let tr = table.getElementsByTagName('tr');

    for (let i = 0; i < tr.length; i++) {
        let row = tr[i];
        let td = row.getElementsByTagName('td')[0];
        if (td) {
            let txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        }       
    }
}


function toggleStatus(button) {
    const row = button.closest('tr');  // Obtener el elemento <tr> donde está el botón
    const id = row.getAttribute('data-id');  // Obtener el ID del <tr>
    const table = row.closest('table');  // Obtener la tabla a la que pertenece el <tr>
    let endpoint;
    
    // Definir el endpoint según la tabla
    switch (table.id) {
        case 'articulosTabla':
            endpoint = '../API/todosProductos.php';
            break;
        case 'proveedoresTabla':
            endpoint = '../API/todosProveedores.php';
            break;
        case 'compradoresTabla':
            endpoint = '../API/todosUsuarios.php';
            break;
        //     case 'denunciasTabla':
        //     endpoint = '../API/todosDenuncias.php';
        //     break;
        default:
            console.error('Tabla desconocida');
            return;
    }
    
    let estado;
    if (button.classList.contains('deshabilitado')) {
        button.classList.remove('deshabilitado');
        button.textContent = 'Deshabilitar';
        button.style.backgroundColor = 'rgb(184, 77, 0)';
        estado = 'Habilitado';
    } else {
        button.classList.add('deshabilitado');
        button.textContent = 'Habilitar';
        button.style.backgroundColor = 'rgb(136, 57, 0)';
        estado = 'Deshabilitado';
    }

    // Enviar el ID y el estado con fetch al endpoint correspondiente
    fetch(endpoint, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            id: id,
            estado: estado
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log(data.message);  // Mensaje de confirmación del servidor
    })
    .catch(error => {
        console.error('Error:', error);  // Manejo de errores
    });
}


// Función que se llama cuando el usuario cambia el valor del <select>
function updateDenunciaStatus(selectElement) {
    const row = selectElement.closest('tr'); // Obtiene el <tr> padre
    const idDenuncia = row.getAttribute('data-id'); // Obtiene el ID de la denuncia
    const status = selectElement.value; // Obtiene el valor seleccionado en el <select>

    // Enviar el ID y el nuevo estado al servidor
    fetch('../API/todosDenuncias.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            id: idDenuncia,
            estado: status
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log(data.message); // Mensaje de confirmación del servidor
    })
    .catch(error => {
        console.error('Error:', error); // Manejo de errores
    });
}



function updateModStatus(selectElement) {
    const row = selectElement.closest('tr'); // Obtiene el <tr> padre
    const idStaff = row.getAttribute('data-id'); // Obtiene el ID de la denuncia
    const status = selectElement.value; // Obtiene el valor seleccionado en el <select>

    // Enviar el ID y el nuevo estado al servidor
    fetch('../API/todosModeradores.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            id: idStaff,
            estado: status
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log(data.message); // Mensaje de confirmación del servidor
    })
    .catch(error => {
        console.error('Error:', error); // Manejo de errores
    });
}

function updateStaffStatus(selectElement) {
    const row = selectElement.closest('tr'); // Obtiene el <tr> padre
    const idStaff = row.getAttribute('data-id'); // Obtiene el ID de la denuncia
    const status = selectElement.value; // Obtiene el valor seleccionado en el <select>

    // Enviar el ID y el nuevo estado al servidor
    fetch('../API/todosStaffs.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            id: idStaff,
            estado: status
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log(data.message); // Mensaje de confirmación del servidor
    })
    .catch(error => {
        console.error('Error:', error); // Manejo de errores
    });
}


function updateCarritoStatus(selectElement) {
    const row = selectElement.closest('tr'); // Obtiene el <tr> padre
    const idCarrito = row.getAttribute('data-id'); // Obtiene el ID de la denuncia
    const status = selectElement.value; // Obtiene el valor seleccionado en el <select>

    // Enviar el ID y el nuevo estado al servidor
    fetch('../API/todosCarritos.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            id: idCarrito,
            estado: status
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log(data.message); // Mensaje de confirmación del servidor
    })
    .catch(error => {
        console.error('Error:', error); // Manejo de errores
    });
}