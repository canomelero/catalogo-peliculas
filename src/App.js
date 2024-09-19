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
                <a className="nav-link fs-5" aria-current="page" href="../index.html">Inicio</a>
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

      <div className="w-100 border border-black" style={{height: '500px'}}>

      </div>

      <div id="footer" className="w-100 border border-black" style={{height: '30px'}}>

      </div>
    </div>
  );
}

export default App;
