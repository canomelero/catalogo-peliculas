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

// Lista con las palabras prohibidas
const palabrasProh = ["puta", "mierda", "joder", "cabrón", "imbécil", "gilipollas", "subnormal",
    "idiota", "retrasado", "tonto", "cabron"
]

// Botón para los comentarios y el bloque que los contiene
const btnComentarios = document.getElementById("btnComents");
const comentsSection = document.getElementById("coments");

// Botón de enviar del formulario y el bloque donde se añaden
const btnEnviar = document.getElementById("btnEnviar");
const comentSection = document.getElementById("listComents");

// Input del email y párrafo donde se insertará el mensaje
const inputEmail = document.getElementById("email");
const msgEmail = document.getElementById("msg-email");

// Input del textarea
const txtComent = document.getElementById("txtComent");


// ------------------------------------------- Funciones --------------------------------------------------------

// Cuando todos los documentos (HTML y CSS) se han cargado, se insertan los comentarios de la lista
window.onload = function () {
    for (let i = 0; i < coments.length; i++) {
        agregarComentarioHTML(coments[i][0], coments[i][2]);
    }
}

// Evento cuando se pulsa el botón de comentarios
btnComentarios.addEventListener('click', function() {
    // Se comprueba si al inicio el display está a none o si el estilo inline (insertado en el HTML)
    // está vacío (puede ocurrir al cargar el CSS)
    if (comentsSection.style.display == "none" || comentsSection.style.display == "") {
        comentsSection.style.display = "flex";
    }
    else {
        comentsSection.style.display = "none";
    }
});

// Evento cuando se pulsa el botón de enviar formulario
btnEnviar.addEventListener('click', function(e) {
    // preventDefault() permite que al pulsar el botón de enviar, no se recargue la página
    e.preventDefault();
    let nombre = document.getElementById("name").value;
    let email = document.getElementById("email").value;
    let comentario = document.getElementById("txtComent").value;

    if (camposRellenados(nombre, email, comentario) && emailValido(email)) {
        // Se agrega el comentario a la lista
        coments.push([nombre, email, comentario]);

        agregarComentarioHTML(nombre, comentario);

        // Se elemina el texto de cada campo del formulario
        document.getElementById("name").value = "";
        document.getElementById("email").value = "";
        document.getElementById("txtComent").value = "";
    }
    else if(!camposRellenados(nombre, email, comentario)) {
        let modal = document.getElementById("modal");
        let cerrarModal = document.querySelector(".cerrar");

        modal.style.display = "flex";

        cerrarModal.addEventListener("click", () => {
            modal.style.display = "none";
        });
    }
});

// Evento que va recogiendo el contenido del input cada vez que se escribe
inputEmail.addEventListener('input', function() {
    if(!emailValido(inputEmail.value)) {
        msgEmail.textContent = "Email no está en formato válido"
        msgEmail.style.color = "red";
        msgEmail.style.textDecoration = "none";
        msgEmail.style.fontSize = "15px";
    }
    else {
        msgEmail.textContent = "";
    }
});

// Evento para identificar las palabras prohibidas del textearea
txtComent.addEventListener('input', function() {
    let texto = txtComent.value;

    for(let i = 0; i < palabrasProh.length; i++) {
        // replace buscará la palabra prohibida y la que encuentre (palabra), la reemplaza por *
        texto = texto.replace(palabrasProh[i], (palabra) => "*".repeat(palabra.length)); 
    }

    txtComent.value = texto;
});


function agregarComentarioHTML(nombre, comentario) {
    let date = new Date();

    // Se agrega al bloque HTML en la sección correspondiente
    // Beforeend permite insertarlo dentro del contenedor al final
    comentSection.insertAdjacentHTML("beforeend", `
        <div class="coment">
            <div>
                <img src="../img/usuario.webp" alt="usuario">
            </div>
    
            <p>${nombre}</p>
            <p>${date.toLocaleString()}</p>
            <p>${comentario}</p>
        </div >
    `);
}

function emailValido(email) {
    // /^ indica el inicio de la cadenam, [^\s@]+ uno o más caracteres que no sean espacios (\s) ni @
    // @ comprueba que haya un arroba, [^\s@]+ busca más carecteres válidos, \. asegura que haya punto,
    // [^\s@]+ valida que haya algo más después del punto, $ fin de cadena
    const emailExp = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailExp.test(email);
}

function camposRellenados(nombre, email, comentario) {
    // trim() función nativa de JS que elimina los espacios en blanco al inicio y al final.
    return nombre.trim() != "" && email.trim() != "" && comentario.trim() != "";
}
