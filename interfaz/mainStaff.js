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
            row.innerHTML = `
                <td style="border: 1px solid #ddd; background-color: rgb(255, 106, 0);">${json[i].id_producto}</td>
                <td style="border: 1px solid #ddd; background-color: rgb(255, 106, 0)">${json[i].titulo}</td>
                <td><button onclick="toggleStatus(this)" style="background-color: rgb(184, 77, 0); color: #fff; padding: 6px 12px; border: none; border-radius: 4px; cursor: pointer;">Disable</button></td>
            `;
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
            row.innerHTML = `
                <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0);">${json[i].id_empresa}</td>
                <td style="border: 1px solid #ddd; background-color: rgb(255, 106, 0)">${json[i].nombre_empresa}</td>
                <td><button onclick="toggleStatus(this)" style="background-color: rgb(184, 77, 0); color: #fff; padding: 6px 12px; border: none; border-radius: 4px; cursor: pointer;">Disable</button></td>
            `;
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
            row.innerHTML = `
                <td style="text-align: center; border: 1px solid #ddd; background-color: rgb(255, 106, 0);">${json[i].id_usu}</td>
                <td style="border: 1px solid #ddd; background-color: rgb(255, 106, 0)">${json[i].nombre_usu}</td>
                <td><button onclick="toggleStatus(this)" style="background-color: rgb(184, 77, 0); color: #fff; padding: 6px 12px; border: none; border-radius: 4px; cursor: pointer;">Disable</button></td>
            `;
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
                <td><button onclick="toggleStatus(this)" style="background-color: rgb(184, 77, 0);color: #fff;padding: 11px 100px;border: none;border-radius: 4px;cursor: pointer;">Disable</button></td>
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
    if (button.classList.contains('disabled')) {
        button.classList.remove('disabled');
        button.textContent = 'Disable';
        button.style.backgroundColor = ' rgb(184, 77, 0)';
    } else {
        button.classList.add('disabled');
        button.textContent = 'Enable';
        button.style.backgroundColor = 'rgb(136, 57, 0)';
    }
}
