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
});

function articulos() {
    fetch('http://localhost/bytewizards/API/todosProductos.php')
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
                <td style="border: 1px solid #ddd; background-color: rgb(255, 106, 0)">${json[i].titulo}</td>
                <td><button onclick="toggleStatus(this)" style="background-color: rgb(136, 57, 0); color: #fff; padding: 6px 25px; border: none; cursor: pointer;" class="deshabilitado">Habilitar</button></td>
            `;
            }else{
                row.innerHTML = `
                <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0);">${json[i].id_producto}</td>
                <td style="border: 1px solid #ddd; background-color: rgb(255, 106, 0)">${json[i].titulo}</td>
                <td><button onclick="toggleStatus(this)" style="background-color: rgb(184, 77, 0); color: #fff; padding: 6px 25px; border: none; cursor: pointer;">Deshabilitar</button></td>
            `;
            }
            
            articlesTableBody.appendChild(row);
        };
    });
}

function proveedores() {
    fetch('http://localhost/bytewizards/API/todosProveedores.php')
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
                <td style="border: 1px solid #ddd; background-color: rgb(255, 106, 0)">${json[i].nombre_empresa}</td>
                <td><button onclick="toggleStatus(this)" style="background-color: rgb(136, 57, 0); color: #fff; padding: 6px 25px; border: none; cursor: pointer;" class="deshabilitado">Habilitar</button></td>
            `;
            }else{
                row.innerHTML = `
                <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0);">${json[i].id_empresa}</td>
                <td style="border: 1px solid #ddd; background-color: rgb(255, 106, 0)">${json[i].nombre_empresa}</td>
                <td><button onclick="toggleStatus(this)" style="background-color: rgb(184, 77, 0); color: #fff; padding: 6px 25px; border: none; cursor: pointer;">Deshabilitar</button></td>
            `;
            }
            articlesTableBody.appendChild(row);
        };
    });
}

function usuarios() {
    fetch('http://localhost/bytewizards/API/todosUsuarios.php')
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
                    <td style="border: 1px solid #ddd; background-color: rgb(255, 106, 0)">${json[i].nombre_usu}</td>
                    <td><button onclick="toggleStatus(this)" style="background-color: rgb(136, 57, 0); color: #fff; padding: 6px 25px; border: none; cursor: pointer;" class="deshabilitado">Habilitar</button></td>
            `;
            }else{
                row.innerHTML = `
                    <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0);">${json[i].id_usu}</td>
                    <td style="border: 1px solid #ddd; background-color: rgb(255, 106, 0)">${json[i].nombre_usu}</td>
                    <td><button onclick="toggleStatus(this)" style="background-color: rgb(184, 77, 0); color: #fff; padding: 6px 25px; border: none; cursor: pointer;">Deshabilitar</button></td>
            `;
            }
            articlesTableBody.appendChild(row);
        };
    });
}


function denuncias() {
    fetch('http://localhost/bytewizards/API/todosDenuncias.php')
    .then(res => res.json())
    .then(json => {
        listProducts = json;      
        let articlesTableBody = document.getElementById('denunciasTabla').querySelector('tbody');
        for (let i = 0; i < json.length; i++) {
            let row = document.createElement('tr');
            row.setAttribute('data-id', json[i].id_denuncia);
            row.innerHTML = `
                <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0);">${json[i].id_denuncia}</td>
                <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0)">${json[i].tipo_denunciante}</td>
                <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0)">${json[i].id_denunciante}</td>
                <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0)">${json[i].tipo_denunciado}</td>
                <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0)">${json[i].id_denunciado}</td>
                <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0)">${json[i].fecha_denuncia}</td>
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
            endpoint = 'http://localhost/bytewizards/API/todosProductos.php';
            break;
        case 'proveedoresTabla':
            endpoint = 'http://localhost/bytewizards/API/todosProveedores.php';
            break;
        case 'compradoresTabla':
            endpoint = 'http://localhost/bytewizards/API/todosUsuarios.php';
            break;
        case 'denunciasTabla':
            endpoint = 'http://localhost/bytewizards/API/todosDenuncias.php';
            break;
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
