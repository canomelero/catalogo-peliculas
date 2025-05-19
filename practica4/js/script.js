// Botón para los comentarios y bloque que los contiene
const btnComentarios = document.getElementById("btnComents");
const comentsSection = document.getElementById("coments");

// Botón de enviar del formulario, bloque donde se añaden y el JSON con los comentarios de la BD
const btnEnviar = document.getElementById("btnEnviar");
const comentSection = document.getElementById("listComents");
let coments = null;

if (comentSection != null) {
    const comentJSON = comentSection.getAttribute("comentJSON");

    if (comentJSON != "") {
        coments = JSON.parse(comentJSON);
        console.log(comentJSON);
    }
}

// Input del email y párrafo donde se insertará el mensaje
const inputEmail = document.getElementById("email");
const msgEmail = document.getElementById("msg-email");

// Input del textarea
const txtComent = document.getElementById("txtComent");

// Palabras prohibidas
let formulario = document.getElementById("form-peli");
let palabrasProh = null;

if (formulario != null) {
    const palProhJSON = formulario.getAttribute("palProhJSON");
    palabrasProh = JSON.parse(palProhJSON);
    console.log(palabrasProh);
}

// Tipo de usuario conectado en la aplicación
const usuarioLog = document.body.dataset.usuario;
const rolUsuario = document.body.dataset.rol;
console.log("Usuario en el sistema: ", usuarioLog);
console.log("Rol del usuario: ", rolUsuario);

// ------------------------------------------- Funciones --------------------------------------------------------

// Cuando todos los documentos (HTML y CSS) se han cargado, se insertan los comentarios de la lista
window.onload = function () {
    if (comentSection != null) {
        if (coments != null) {
            comentSection.style.height = "300px";

            coments.forEach(coment => {
                agregarComentarioHTML(coment.id, coment.id_peli, coment.autor, formatearFecha(coment.fecha),
                    coment.comentario, coment.modificado);
            });
        }
        else {
            comentSection.style.height = "0px";
        }
    }
}

// Evento cuando se pulsa el botón de comentarios
if (btnComentarios && comentsSection) {
    btnComentarios.addEventListener('click', function () {
        // Se comprueba si al inicio el display está a none o si el estilo inline (insertado en el HTML)
        // está vacío (puede ocurrir al cargar el CSS)
        if (comentsSection.style.display == "none" || comentsSection.style.display == "") {
            comentsSection.style.display = "flex";
        }
        else {
            comentsSection.style.display = "none";
        }
    });
}

// Evento cuando se pulsa el botón de enviar formulario
if (btnEnviar) {
    btnEnviar.addEventListener('click', function (e) {
        // preventDefault() permite que al pulsar el botón de enviar, no se recargue la página
        e.preventDefault();
        let nombre = "";
        let email = "";
        let comentario = "";

        nombre = document.getElementById("name").value;
        email = document.getElementById("email").value;
        comentario = document.getElementById("txtComent").value;

        if (rolUsuario == "registrado" || rolUsuario == "moderador" || rolUsuario == "gestor" ||
                rolUsuario == "admin") {
            if (camposRellenados(nombre, email, comentario) && emailValido(email)) {
                // Como se ha utilizado el preventDefault(), es necesario forzar el envío del comentario al 
                // servidor ejecutando submit() sobre el formulario; de lo contrario, no se enviaría nada al
                // servidor ya que con preventDefault() deja de realizar el comportamiento normal (enviar al servidor)
                document.querySelector("form").submit();
            }
            else if (!camposRellenados(nombre, email, comentario)) {
                let modal = document.getElementById("modal");
                let cerrarModal = document.querySelector(".cerrar");

                modal.style.display = "flex";

                cerrarModal.addEventListener("click", () => {
                    modal.style.display = "none";
                });
            }
        }
    });
}

// Evento que va recogiendo el contenido del input cada vez que se escribe
if (inputEmail && msgEmail) {
    inputEmail.addEventListener('input', function () {
        if (!emailValido(inputEmail.value)) {
            msgEmail.style.display = "block";
            msgEmail.textContent = "Email no está en formato válido"
            msgEmail.style.color = "red";
            msgEmail.style.textDecoration = "none";
            msgEmail.style.fontSize = "15px";
            msgEmail.style.fontWeight = "bold";
        }
        else {
            msgEmail.textContent = "";
            msgEmail.style.display = "none";
        }
    });
}

// Evento para identificar las palabras prohibidas del textearea
if (txtComent && palabrasProh) {
    txtComent.addEventListener('input', function () {
        let texto = txtComent.value;

        for (let i = 0; i < palabrasProh.length; i++) {
            // replace buscará la palabra prohibida y la que encuentre la reemplaza por *
            texto = texto.replace(palabrasProh[i].palabra, "*".repeat(palabrasProh[i].palabra.length));
        }

        txtComent.value = texto;
    });
}

// Mensaje de error login y crear cuenta
document.addEventListener('DOMContentLoaded', function () {
    const msg_error = document.getElementById("msg-error-form");

    if (msg_error) {
        const msg = msg_error.textContent.trim();

        if (msg === "") {
            msg_error.style.display = "none";
        } else {
            msg_error.style.display = "block";
        }
    }
});

function agregarComentarioHTML(id, id_peli, nombre, fecha, comentario, modificado) {
    let date = new Date();
    let html = `
        <div id="coment-${id}" class="coment">
            <div>
                <img src="./img/usuario.webp" alt="usuario">
            </div>

            <p>${nombre}</p>
            <p>${fecha}</p>
            <p id="comentario">${comentario}</p>
    `;

    if (modificado == "S") {
        html += `<p class="coment-modificado">(Modificado por el moderador)</p>`;
    }

    if (rolUsuario === "moderador" || rolUsuario === "admin") {
        html += `
            <div id="btnModerador">
                <div id="editarComent" class="mod-coment" data-id="${id}">
                    <a href="./modificar_coment.php?idComent=${id}&idPeli=${id_peli}">Editar</a>
                </div>

                <div id="eliminarComent" class="mod-coment" data-id="${id}">
                    Eliminar
                </div>
            </div>`;
    }

    html += `</div>`;

    // Se agrega al bloque HTML en la sección correspondiente
    // Beforeend permite insertarlo dentro del contenedor al final
    comentSection.insertAdjacentHTML("beforeend", html);
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

function formatearFecha(fechaHora) {
    let [fecha, hora] = fechaHora.split(" ");   // Primero se separa por el espacio
    let [anio, mes, dia] = fecha.split("-");    // A continuación se separa la fecha por "-"
    return `${dia}-${mes}-${anio} ${hora}`;
}


// ----------------------------------------- Funcionalidades de usuarios ------------------------------------------------

if (rolUsuario === "registrado" || rolUsuario == "moderador") {
    if (formulario != null) {
        formulario.style.display = "block";
    }
}

// MODERADOR
// Evento al clickar sobre el botón de "eliminar" de los comentarios
document.addEventListener("click", function (event) {
    // Se selecciona la etiqueta (elemento) sobre el que se ha hecho click y se comprueba si su id es "editarComent"
    let elemento = event.target;

    if (elemento != null && elemento.id === "eliminarComent") {
        const idComent = elemento.getAttribute("data-id");
        const datos = { id: `${idComent}` };

        // Se envía una petición POST al servidor con el id del comentario
        fetch('./eliminar_coment.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(datos)
        })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    // Eliminar el comentario de la sección de comentarios y de la tabla
                    const comentElement = document.getElementById(`coment-${idComent}`);
                    const comentTabla = document.getElementById(`${idComent}-coment-tabla`);

                    if (comentElement != null) {
                        comentElement.remove();
                    }
                    else if (comentTabla != null) {
                        comentTabla.remove();
                    }

                    alert(result.message);

                    // Se busca el id del comentario y se elimina con splice()
                    const index = coments.findIndex(coment => coment.id == idComent);

                    if (index !== -1) {
                        coments.splice(index, 1);
                    }

                    if (coments.length > 0) {
                        comentSection.style.height = "300px";
                    }
                    else {
                        comentSection.style.height = "0px";
                    }
                }
            });
    }
});

// Búsqueda de la película en base al título y descripción
const tituloInput = document.getElementById('search-titulo');
const descripcionInput = document.getElementById('search-descripcion');
const filasPelis = document.querySelectorAll('.peli-tabla');

function filtrarPelis() {
    // Se obtiene el valor de cada campo de texto en minúscula
    const tituloValor= tituloInput.value.toLowerCase();
    const descripcionValor = descripcionInput.value.toLowerCase();

    filasPelis.forEach(fila => {
        // Para cada fila se obtiene el título y descripción de la película
        const tituloTexto = fila.querySelector('.titulo').innerText.toLowerCase();
        const descripcionTexto = fila.querySelector('.descripcion').innerText.toLowerCase();

        // Si el título y la descripción de los inputs coinciden se muestran
        if (tituloTexto.includes(tituloValor) && descripcionTexto.includes(descripcionValor)) {
            fila.style.display = '';
        } else {    // Si no se ocultan
            fila.style.display = 'none';
        }
    });
}

if(tituloInput && descripcionInput) {
    tituloInput.addEventListener('input', filtrarPelis);
    descripcionInput.addEventListener('input', filtrarPelis);   
}


// Búsqueda del comentario en base a la descripción
const comentarioInput = document.getElementById('search-comentario');
const filasComents = document.querySelectorAll('.coment-tabla');

function filtrarComentarios() {
    const comentarioValor = comentarioInput.value.toLowerCase();

    filasComents.forEach(fila => {
        // Para cada fila se obtiene el título y descripción de la película
        const comentarioTexto = fila.querySelector('.comentario').innerText.toLowerCase();

        // Si el título y la descripción de los inputs coinciden se muestran
        if (comentarioTexto.includes(comentarioValor)) {
            fila.style.display = '';
        } else {    // Si no se ocultan
            fila.style.display = 'none';
        }
    });
}

if(comentarioInput) {
    comentarioInput.addEventListener('input', filtrarComentarios);   
}

// Obtener palabras prohibidas en el modificar comentario del moderador
const formModerador = document.getElementById("modificar-form");

if (formModerador) {
    const palabrasJSONMod = formModerador.getAttribute("palProhJSON");
    const palabrasProhMod = JSON.parse(palabrasJSONMod);
    const txtComentMod = document.getElementById("txtComentMod");
    
    if(palabrasProhMod && txtComentMod) {
        txtComentMod.addEventListener('input', function () {
            let texto = txtComentMod.value;
    
            for (let i = 0; i < palabrasProhMod.length; i++) {
                // replace buscará la palabra prohibida y la que encuentre la reemplaza por *
                texto = texto.replace(palabrasProhMod[i].palabra, "*".repeat(palabrasProhMod[i].palabra.length));
            }
    
            txtComentMod.value = texto;
        });
    }
}




