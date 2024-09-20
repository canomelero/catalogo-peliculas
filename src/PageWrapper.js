

function PageWrapper(propiedades) {
    return (
        <div className="App">
            <div id="header" className="w-100 h-auto d-flex justify-content-center align-items-center">
                <div className="w-75 d-flex justify-content-between align-items-center">
                    <div className="w-auto d-flex justify-content-between align-items-center">
                        <img src="img/paramount-plus-logo-0.png" style={{ width: '100px' }}></img>
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

            <div className="w-100 h-auto d-flex justify-content-center align-items-start" style={{ height: '500px' }}>
                <div className="w-75 d-flex flex-column justify-content-start align-items-start">
                    {propiedades.children}
                </div>
            </div>

            <div id="footer" className="w-100 h-auto mt-5 pt-3 d-flex justify-content-center align-items-center">
                <p>&copy; 2024 Catálogo de Películas. Todos los derechos reservados.</p>
            </div>
        </div>
    );
}

export default PageWrapper;