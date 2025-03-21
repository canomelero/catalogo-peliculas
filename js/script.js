// Se obtiene el botón para los comentarios y el bloque que los contiene
const btnComentarios = document.getElementById("btnComents");
const comentsSection = document.getElementById("coments");

// Por cada vez que se pulsa el botón, se va a ir añadiendo o quitando la clase hidden que permite
// que se oculte o se visualice la sección de comentarios
btnComentarios.addEventListener('click', function() {
    comentsSection.classList.toggle('hidden');
})