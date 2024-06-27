/*
window.onload = function(){
    const imagenes=[
    'img prueba.jpg',
    'img prueba2.jpg',
    'img prueba3.jpg',
    'img prueba4.jpg',
    'img prueba5.jpg',
    'img prueba6.jpg'

    ];

    const TIEMPO_INTERVALO_MILESIMAS_SEG = 1000;
    let $imagen=document.querySelector('#imagen');
    let posicionActual = 0;
    let intervalo;


    function pasarFoto() {
        if(posicionActual >= imagenes.length - 1) {
            posicionActual = 0;
        } else {
            posicionActual++;
        }
        renderizarImagen();
    }

    function retrocederFoto() {
        if(posicionActual <= 0) {
            posicionActual = imagenes.length - 1;
        } else {
            posicionActual--;
        }
        renderizarImagen();
    }

    function renderizarImagen () {
        $imagen.style.backgroundImage = `url(${imagenes[posicionActual]})`;
    }



}
*/

window.onload = function () {
    // Variables
    const IMAGENES = [
        'imgprueba.jpg',
        'imgprueba2.jpg',
        'imgprueba3.jpg',
        'imgprueba4.jpg',
        'imgprueba5.jpg',
        'imgprueba6.jpg'

    ];

    const TIEMPO_INTERVALO_MILESIMAS_SEG = 1000;
    let posicionActual = 0;
    let $botonRetroceder = document.querySelector('#retroceder');
    let $botonAvanzar = document.querySelector('#avanzar');
    let $imagen = document.querySelector('#imagen');
    let $botonPlay = document.querySelector('#play');
    let $botonStop = document.querySelector('#stop');
    let intervalo;

    // Funciones

    /**
     * Funcion que cambia la foto en la siguiente posicion
     */
    function pasarFoto() {
        if(posicionActual >= IMAGENES.length - 1) {
            posicionActual = 0;
        } else {
            posicionActual++;
        }
        renderizarImagen();
    }

    /**
     * Funcion que cambia la foto en la anterior posicion
     */
    function retrocederFoto() {
        if(posicionActual <= 0) {
            posicionActual = IMAGENES.length - 1;
        } else {
            posicionActual--;
        }
        renderizarImagen();
    }

    /**
     * Funcion que actualiza la imagen de imagen dependiendo de posicionActual
     */
    function renderizarImagen () {
        $imagen.style.backgroundImage = `url(${IMAGENES[posicionActual]})`;
    }

    /**
     * Activa el autoplay de la imagen
     */
    function playIntervalo() {
        intervalo = setInterval(pasarFoto, TIEMPO_INTERVALO_MILESIMAS_SEG);
        // Desactivamos los botones de control
        $botonAvanzar.setAttribute('disabled', true);
        $botonRetroceder.setAttribute('disabled', true);
        $botonPlay.setAttribute('disabled', true);
        $botonStop.removeAttribute('disabled');

    }

    /**
     * Para el autoplay de la imagen
     */
    function stopIntervalo() {
        clearInterval(intervalo);
        // Activamos los botones de control
        $botonAvanzar.removeAttribute('disabled');
        $botonRetroceder.removeAttribute('disabled');
        $botonPlay.removeAttribute('disabled');
        $botonStop.setAttribute('disabled', true);
    }

    // Eventos
    $botonAvanzar.addEventListener('click', pasarFoto);
    $botonRetroceder.addEventListener('click', retrocederFoto);
    $botonPlay.addEventListener('click', playIntervalo);
    $botonStop.addEventListener('click', stopIntervalo);
    // Iniciar
    renderizarImagen();
}