import logo from './logo.svg';
import './App.css';
import peliculasJSON from './peliculas.json';
import Pelicula from './Pelicula';
import PageWrapper from './PageWrapper'; { {/* PageWrapper es el componente que contiene el "esqueleto" de la página */ } }

function App() {
  { {/* Se crea un tipo de dato JSON para las películas */ } }
  let peliculas = peliculasJSON;

  return (
    <PageWrapper>
      {peliculas.map((pelicula) => {
        return <Pelicula titulo={pelicula.titulo} director={pelicula.director} actores={pelicula.actores}
          valoracion={pelicula.valoracion} imagen={pelicula.imagen}>
            {pelicula.sinopsis}
          </Pelicula>
      })}
    </PageWrapper>
  );
}

export default App;
