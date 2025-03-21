// Lista de listas con los datos de cada mensaje
let coments = [
    [
        "José Luis González Fernández",
        "jlgf@gmail.com",
        "Comentario de José Luis"
    ],
    [
        "María Rodríguez Ortega",
        "mro@gmail.com",
        "Comentario de María"
    ]
];

// Cuando todos los documentos (HTML y CSS) se han cargado, se insertan los comentarios de la lista
window.onload = function() {
    for(let i = 0; i < coments.length; i++) {
        agregarComentarioHTML(coments[i][0], coments[i][2]);
    }
}

// Se obtiene el botón para los comentarios y el bloque que los contiene
const btnComentarios = document.getElementById("btnComents");
const comentsSection = document.getElementById("coments");

btnComentarios.addEventListener('click', function () {
    // Se comprueba si al inicio el display está a none o si el estilo inline (insertado en el HTML)
    // está vacío (puede ocurrir al cargar el CSS)
    if(comentsSection.style.display == "none" || comentsSection.style.display == "") {
        comentsSection.style.display = "flex";
    }
    else {
        comentsSection.style.display = "none";
    }
});

// Se obtiene el botón de enviar del formulario y el bloque donde se añaden
const btnEnviar = document.getElementById("btnEnviar");
const comentSection = document.getElementById("listComents");

btnEnviar.addEventListener('click', function (e) {
    // preventDefault() permite que al pulsar el botón de enviar, no se recargue la página
    e.preventDefault();
    let name = document.getElementById("name").value;
    let email = document.getElementById("email").value;
    let coment = document.getElementById("txtComent").value;

    // Se agrega el comentario a la lista
    coments.push([name, email, coment]);

    agregarComentarioHTML(name, coment);

    // Se elemina el texto de cada campo del formulario
    document.getElementById("name").value = "";
    document.getElementById("email").value = "";
    document.getElementById("txtComent").value = "";
});

function agregarComentarioHTML(nombre, comentario) {
    // Se agrega al bloque HTML en la sección correspondiente
    // Beforeend permite insertarlo dentro del contenedor al final
    comentSection.insertAdjacentHTML("beforeend", `
        <div class="coment">
            <div>
                <img src="../img/usuario.webp" alt="usuario">
            </div>
    
            <p>Autor: ${nombre}</p>
            <p>Fecha: 21/03/2025</p>
            <p>Hora: 19:30 </p>
            <p>${comentario}</p>
        </div >
    `);
}