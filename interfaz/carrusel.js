window.onload = function () {
    // Lista de imágenes para el carrusel
    const IMAGENES = [
        'img/1.jpg','img/2.jpg','img/3.jpg'
    ];
    const TIEMPO_INTERVALO_MILESIMAS_SEG = 3000; // 3 segundos
    let posicionActual = 0;
    let $imagen = document.querySelector('#publi');

    // Función para cambiar la imagen
    function cambiarImagen() {
        $imagen.style.backgroundImage = `url(${IMAGENES[posicionActual]})`;
        posicionActual = (posicionActual + 1) % IMAGENES.length;
    }

    // Cambiar imagen al cargar y luego cada 3 segundos
    cambiarImagen();
    setInterval(cambiarImagen, TIEMPO_INTERVALO_MILESIMAS_SEG);
}
