document.querySelector('#comment').addEventListener('input', commentarySize);
function commentarySize() {
    const commentary = document.getElementById('comment').value;
    if (commentary.length > 600) {
        document.getElementById('comment').setCustomValidity("Excede el limite de los 600 caracteres");
    } else {
        document.getElementById('comment').setCustomValidity("");
    }
}
