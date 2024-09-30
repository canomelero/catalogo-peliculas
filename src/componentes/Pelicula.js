{{/* Creación de componente "Película" */}}
function Pelicula(propiedades) {
    return (
        <div className="film-box">
            <div>
                <img src={propiedades.imagen} style={{ width: '220px' }}></img>
            </div>

            <div className="film-info">
                <h2>{propiedades.titulo}</h2>
                <p className="lh-base mt-3">
                    {propiedades.children}
                </p>
                <p>
                    Director: {propiedades.director}
                </p>
                <p>
                    Actores: {propiedades.actores}
                </p>
                <p>
                    Valoración: {propiedades.valoracion}
                </p>
            </div>
        </div>
    );
}

{ {/* Es necesario exportar la función para que pueda ser utilizada en el archivo app.js */ } }
export default Pelicula;
