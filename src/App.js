import logo from './logo.svg';
import './App.css';

function App() {


  return (
    <div className="App">
      <div id="header" className="w-100 h-auto d-flex justify-content-center align-items-center">
        <div className="w-75 d-flex justify-content-between align-items-center">
          <div className="w-auto d-flex justify-content-between align-items-center">
            <img src="img/paramount-plus-logo-0.png" style={{width: '100px'}}></img>
            <h1 className="fs-2 text-wrap ms-5">Catálogo Películas</h1>
          </div>
          
          <div className="w-25 d-flex justify-content-star align-items-center">
            <nav className="w-100 d-flex justify-content-between align-items-center flex-wrap">
              <div>
                <a className="nav-link fs-5" aria-current="page" href="#">Inicio</a>
              </div>
              <div>
                <a className="nav-link fs-5" href="#">Películas</a>
              </div>
              <div>
                <a className="nav-link fs-5" href="#">Series</a>
              </div>
            </nav>
          </div>
        </div>
      </div>

      <div className="w-100 h-auto d-flex justify-content-center align-items-start" style={{height: '500px'}}>
        <div className="w-75 d-flex flex-column justify-content-start align-items-start">
          <div className="film-box">
            <div>
              <img src="img/mv-it1.jpg" style={{width: '220px'}}></img>
            </div>
            
            <div className="film-info">
              <h2>Oblivion</h2>
              <p className="lh-base mt-3">En el año 2073, la Tierra ha sido devastada por una guerra nuclear y los seres humanos han sido evacuados a Marte. Jack Harper (Tom Cruise), 
                 un ingeniero de drones, es uno de los últimos hombres que quedan en la Tierra, asignado a patrullar los cielos y reparar los drones que han 
                 sido dañados en combates con los restos de la alienígena raza enemiga. <br></br>
                 Durante su misión, Jack rescata a una misteriosa mujer, Julia Rusakova (Olga Kurylenko), de una nave espacial. Esta encuentro cambia el curso 
                 de su vida y desencadena una serie de eventos que cuestionan la verdad sobre su misión y el estado de la Tierra.</p>
              <p>
                Director: Joseph Kosinski
              </p>
              <p>
                Actores: Tom Cruise, Andrea Risenborough, Olga Kurylenko, Morgan Freeman
              </p>
              <p>
                Valoración: 7 / 10
              </p>
            </div>
          </div>

          <div className="film-box">
            <div>
              <img src="img/mv-it7.jpg" style={{width: '220px'}}></img>
            </div>
            
            <div className="film-info">
              <h2>IT</h2>
              <p className="lh-base mt-3">La película cuenta la historia de siete niños marginados del municipio de Derry, Maine (EE. UU.), que se llaman a sí mismos "El Club de los 
                Perdedores". Todos se han visto marginados por uno u otro motivo; todos cargan con alguna de las "cualidades" favoritas de los abusones de la 
                ciudad... y todos han visto sus peores pesadillas hacerse realidad en forma de un antiguo depredador que cambia de forma y al que solo logran 
                llamar "eso". <br></br>
                Desde que existe, Derry ha sido el coto de caza de esa entidad, que resurge de las alcantarillas cada 27 años para alimentarse de los miedos de 
                sus presas favoritas: los niños. Unidos debido a un terrible y apasionante verano, Los Perdedores forman una piña para ayudarse a superar sus miedos 
                y detener un nuevo ciclo de asesinatos iniciado un lluvioso día con la muerte de un niño pequeño que seguía un barco de papel en su viaje sobre las 
                aguas de lluvia hasta el alcantarillado... y las garras de Pennywise el payaso.</p>
              <p>
                Director: Andy Muschietti
              </p>
              <p>
                Actores: Bill Skarsgård, Jaeden Martell, Jeremy Ray Taylor, Sophia Lillis
              </p>
              <p>
                Valoración: 8.5 / 10
              </p>
            </div>
          </div>

          <div className="film-box">
            <div>
              <img src="img/mv-it10.jpg" style={{width: '220px'}}></img>
            </div>
            
            <div className="film-info">
              <h2>Harry Potter y el prisionero de Azkabán</h2>
              <p className="lh-base mt-3">La tercera entrega de la saga Harry Potter nos cuenta el transcurso del tercer año del protagonista en el colegio Hogwarts. Al inicio de este año,
                 Harry descubre algunas novedades: Sirius Black, uno de los asesinos de Lord Voldemort, se ha escapado de la prisión de Azkaban y todos se hallan 
                 preocupados por si este llegara a acabar con el joven Harry. <br></br>
                 A pesar de que en el colegio se toman fuertes medidas de seguridad para evitar la tragedia y se colocan dementores (criaturas que ejercen de carceleros 
                 en la prisión de Azkaban) alrededor de todo el edificio, Harry terminará entablando una relación con el prófugo Sirius Black. <br></br>
              </p>
              <p>
                Director: Alfonso Cuarón
              </p>
              <p>
                Actores: Daniel Radcliffe, Rupert Grint, Emma Watson, Gary Oldman
              </p>
              <p>
                Valoración: 9 / 10
              </p>
            </div>
          </div>

          <div className="film-box">
            <div>
              <img src="img/mv-it11.jpg" style={{width: '220px'}}></img>
            </div>
            
            <div className="film-info">
              <h2>Guardianes de la Galaxia</h2>
              <p className="lh-base mt-3">El temerario aventurero Peter Quill es objeto de un implacable cazarrecompensas después de robar una misteriosa esfera codiciada por Ronan, un poderoso 
                villano cuya ambición amenaza todo el universo. Para poder escapar del incansable Ronan, Quill se ve obligado a pactar una complicada tregua con un cuarteto 
                de disparatados inadaptados: Rocket, un mapache armado con un rifle, Groot, un humanoide con forma de árbol, la letal y enigmática Gamora y el vengativo Drax 
                the Destroyer. Pero cuando Quill descubre el verdadero poder de la esfera, deberá hacer todo lo posible para derrotar a sus extravagantes rivales en un intento 
                desesperado de salvar el destino de la galaxia.</p>
              <p>
                Director: James Gunn
              </p>
              <p>
                Actores: Chris Pratt, Zoe Saldana, Dave Bautista, Bradley Cooper
              </p>
              <p>
                Valoración: 9 / 10
              </p>
            </div>
          </div>
        </div>
      </div>

      <div id="footer" className="w-100 h-auto mt-5 pt-3 d-flex justify-content-center align-items-center">
        <p>&copy; 2024 Catálogo de Películas. Todos los derechos reservados.</p>
      </div>
    </div>
  );
}

export default App;
