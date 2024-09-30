import React, { useState } from 'react';
import { Link } from 'react-router-dom';

function Navbar() {
  return (
    <>
        <nav className='w-100 h-auto d-flex justify-content-center align-items-center'>
            <div className='w-75 d-flex justify-content-between align-items-center'>
                <Link to='/' className='w-auto d-flex justify-content-between align-items-center'>
                    <img src='img/paramount-plus-logo-0.png' style={{ width: '100px' }}/>
                    <h1 className='fs-2 text-wrap ms-5 text-white'>Catálogo de Películas</h1>
                </Link>

                <ul className='w-25 d-flex justify-content-between align-items-center flex-wrap'>
                  <li className='nav-item'>
                    <Link to='/' className='nav-links fs-5'>
                      Inicio
                    </Link>
                  </li>
                  <li className='nav-item'>
                    <Link to='/Peliculas' className='nav-links fs-5'>
                      Películas
                    </Link>
                  </li>
                  <li className='nav-item'>
                    <Link to='/Series' className='nav-links fs-5'>
                      Series
                    </Link>
                  </li>
                </ul>
            </div>
        </nav>
    </>
  )
}

export default Navbar