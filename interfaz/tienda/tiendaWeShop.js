window.onload = function () {
    // Variables
    const IMAGENES = [
        'imgprueba.jpg',
        'imgprueba2.jpg',
        'imgprueba4.jpg',
        'imgprueba5.jpg',
        'imgprueba6.jpg'

    ];
    const TIEMPO_INTERVALO_MILESIMAS_SEG = 2000;
    let posicionActual = 0;
    let $imagen = document.querySelector('#imagen');
    let intervalo;

    $imagen.classList.add('img-ajustada');
    // Funciones

    /**
     * Funcion que cambia la foto en la siguiente posicion
     */
    function pasarFoto() {
        if (posicionActual >= IMAGENES.length - 1) {
            posicionActual = 0;
        } else {
            posicionActual++;
        }
        renderizarImagen();
    }

    /**
     * Funcion que actualiza la imagen de imagen dependiendo de posicionActual
     */
    function renderizarImagen() {
        $imagen.src = IMAGENES[posicionActual];
    }

    /**
     * Activa el autoplay de la imagen
     */
    function playIntervalo() {
        intervalo = setInterval(pasarFoto, TIEMPO_INTERVALO_MILESIMAS_SEG);
    }

    // Iniciar
    renderizarImagen();
    playIntervalo();
}

document.getElementById('btn_carrito').onclick = function(){

    document.getElementById('contenido_carrito').showModal();

};

document.getElementById('cerrar_contenido').onclick = function(){

    document.getElementById('contenido_carrito').close();

};