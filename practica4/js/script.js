// Botón para los comentarios y bloque que los contiene
const btnComentarios = document.getElementById("btnComents");
const comentsSection = document.getElementById("coments");

// Botón de enviar del formulario, bloque donde se añaden y el JSON con los comentarios de la BD
const btnEnviar = document.getElementById("btnEnviar");
const comentSection = document.getElementById("listComents");
let coments = null;

if(comentSection != null) {
    const comentJSON = comentSection.getAttribute("comentJSON");

    if(comentJSON != "") {
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
let formulario = document.getElementById("form");
let palabrasProh = null;

if(formulario != null) {
    const palProhJSON = formulario.getAttribute("palProhJSON");
    palabrasProh = JSON.parse(palProhJSON);
    console.log(palabrasProh);
}

// ------------------------------------------- Funciones --------------------------------------------------------

// Cuando todos los documentos (HTML y CSS) se han cargado, se insertan los comentarios de la lista
window.onload = function () {
    if(comentSection != null) {
        if(coments != null) {
            comentSection.style.height = "300px";
    
            coments.forEach(coment => {
                agregarComentarioHTML(coment.autor, formatearFecha(coment.fecha), coment.comentario);
            });
        }
        else {
            comentSection.style.height = "0px";
        }
    }
}

// Evento cuando se pulsa el botón de comentarios
if(btnComentarios && comentsSection) {
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
}

// Evento cuando se pulsa el botón de enviar formulario
if(btnEnviar) {
    btnEnviar.addEventListener('click', function(e) {
        // preventDefault() permite que al pulsar el botón de enviar, no se recargue la página
        e.preventDefault();
        let nombre = document.getElementById("name").value;
        let email = document.getElementById("email").value;
        let comentario = document.getElementById("txtComent").value;
    
        if (camposRellenados(nombre, email, comentario) && emailValido(email)) {
            // Como se ha utilizado el preventDefault(), es necesario forzar el envío del comentario al 
            // servidor ejecutando submit() sobre el formulario; de lo contrario, no se enviaría nada al
            // servidor ya que con preventDefault() deja de realizar el comportamiento normal (enviar al servidor)
            document.querySelector("form").submit();
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
}

// Evento que va recogiendo el contenido del input cada vez que se escribe
if(inputEmail && msgEmail) {
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
}

// Evento para identificar las palabras prohibidas del textearea
if(txtComent && palabrasProh) {
    txtComent.addEventListener('input', function() {
        let texto = txtComent.value;
    
        for(let i = 0; i < palabrasProh.length; i++) {
            // replace buscará la palabra prohibida y la que encuentre la reemplaza por *
            texto = texto.replace(palabrasProh[i].palabra, "*".repeat(palabrasProh[i].palabra.length)); 
        }
    
        txtComent.value = texto;
    });
}

// Mensaje de error login y crear cuenta
document.addEventListener('DOMContentLoaded', function () {
    const msg_error = document.getElementById("msg-error");

    if (msg_error) {
        const msg = msg_error.textContent.trim();

        if (msg === "") {
            msg_error.style.display = "none";
        } else {
            msg_error.style.display = "block";
        }
    }
});

function agregarComentarioHTML(nombre, fecha, comentario) {
    let date = new Date();

    // Se agrega al bloque HTML en la sección correspondiente
    // Beforeend permite insertarlo dentro del contenedor al final
    comentSection.insertAdjacentHTML("beforeend", `
        <div class="coment">
            <div>
                <img src="./img/usuario.webp" alt="usuario">
            </div>
    
            <p>${nombre}</p>
            <p>${fecha}</p>
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

function formatearFecha(fechaHora) {
    let [fecha, hora] = fechaHora.split(" ");   // Primero se separa por el espacio
    let [anio, mes, dia] = fecha.split("-");    // A continuación se separa la fecha por "-"
    return `${dia}-${mes}-${anio} ${hora}`;
}


// ----------------------------------------- Funcionalidades de usuarios ------------------------------------------------

// Tipo de usuario conectado en la aplicación
const usuarioLog = document.body.dataset.usuario;
const rolUsuario = document.body.dataset.rol;
console.log("Usuario en el sistema: ", usuarioLog);
console.log("Rol del usuario: ", rolUsuario);

if(usuarioLog === '') {     // Usuario anónimo
    if(formulario != null) {
        formulario.style.display = "none";
    }
}

if(rolUsuario === 'registrado') {
    if(formulario != null) {
        formulario.style.display = "block";
    }
}

