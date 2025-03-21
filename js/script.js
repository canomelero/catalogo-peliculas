// Se obtiene el botón para los comentarios y el bloque que los contiene
const btnComentarios = document.getElementById("btnComents");
const comentsSection = document.getElementById("coments");

// Se obtiene el botón de enviar del formulario y el bloque donde se añaden
const btnEnviar = document.getElementById("btnEnviar");
const comentSection = document.getElementById("listComents");

// Por cada vez que se pulsa el botón, se va a ir añadiendo o quitando la clase (toggle) "hidden",
// permitiendo que se oculte o se visualice la sección de comentarios
btnComentarios.addEventListener('click', function () {
    comentsSection.classList.toggle('hidden');
});


btnEnviar.addEventListener('click', function (e) {
    e.preventDefault();
    let name = document.getElementById("name").value;
    let email = document.getElementById("email").value;
    let coment = document.getElementById("txtComent").value;

    comentSection.insertAdjacentHTML("beforeend", `
        <div class="coment">
            <div>
                <img src="../img/usuario.webp" alt="usuario">
            </div>
    
            <p>Autor: ${name}</p>
            <p>Fecha: 21/03/2025</p>
            <p>Hora: 19:30 </p>
            <p>${coment}</p>
        </div >
    `);

    document.getElementById("name").value = "";
    document.getElementById("email").value = "";
    document.getElementById("txtComent").value = "";
});