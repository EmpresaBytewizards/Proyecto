window.onload = function(){
const imagenes=[
'img prueba.jpg',
'img prueba2.jpg',
'img prueba3.jpg',
'img prueba4.jpg',
'img prueba5.jpg',
'img prueba6.jpg'

];

const TIEMPO_INTERVALO_MILESIMAS_SEG = 2500;
let $imagen=document.querySelector('#imagen');
let $posicionActual=0;
let $intervalo=setInterval(pasarFoto, TIEMPO_INTERVALO_MILESIMAS_SEG);
let $botonRetroceder = document.querySelector('#retroceder');
let $botonAvanzar = document.querySelector('#avanzar');


function pasarFoto() {
    if($posicionActual >= imagenes.length - 1) {
        $posicionActual = 0;
    } else {
        $posicionActual++;
    }
    renderizarImagen();
}

function retrocederFoto() {
    if($posicionActual <= 0) {
        $posicionActual = imagenes.length - 1;
    } else {
        $posicionActual--;
    }
    renderizarImagen();
}

function renderizarImagen () {
    $imagen.style.backgroundImage = `url(${imagenes[$posicionActual]})`;
}
$botonAvanzar.addEventListener('click', pasarFoto);
$botonRetroceder.addEventListener('click', retrocederFoto);
renderizarImagen();
}