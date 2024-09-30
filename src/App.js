import React from 'react';
import Navbar from './componentes/Navbar';
import { BrowserRouter as Router } from 'react-router-dom';
import { Routes, Route } from 'react-router-dom';
import './App.css';
import Peliculas from './componentes/Peliculas';
import Inicio from './componentes/Inicio';
import Series from './componentes/Series';

function App() {
  return (
    <>
      <Router>
        <Navbar />
        <Routes>
          <Route path='/' exact Component={Inicio}/>
          <Route path='/peliculas' exact Component={Peliculas}/>
          <Route path='/series' exact Component={Series}/>
        </Routes>
      </Router>

      <div id="footer" className="w-100 h-auto mt-5 pt-3 d-flex justify-content-center align-items-center">
        <p>&copy; 2024 Catálogo de Películas. Todos los derechos reservados.</p>
      </div>
    </>
  );
}

export default App;

