import Pelicula from './Pelicula';
import peliculasJson from './Peliculas.json';

function Peliculas() {
    let peliculas = peliculasJson;

    return (
        <div className="w-100 h-auto d-flex justify-content-center align-items-start" style={{ height: '500px' }}>
            <div className="w-75 d-flex flex-column justify-content-start align-items-start">
                {peliculas.map((pelicula) => {
                    return <Pelicula titulo={pelicula.titulo} director={pelicula.director} actores={pelicula.actores} 
                        valoracion={pelicula.valoracion} imagen={pelicula.imagen}>
                            {pelicula.sinopsis}
                    </Pelicula>
                })}
            </div>
        </div>
    );
}

export default Peliculas;
