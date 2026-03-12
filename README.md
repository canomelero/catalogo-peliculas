# Catalogo de Peliculas

Proyecto academico de la asignatura **Sistemas de Informacion basados en Web**.

El repositorio muestra la evolucion de una aplicacion web de catalogo de peliculas a lo largo de varias practicas:

- `practica2`: version estatica (HTML, CSS y JS).
- `practica3`: version dinamica con PHP, Twig y MySQL.
- `practica4`: autenticacion, roles y gestion de contenido/comentarios.
- `practica5`: mejoras de gestion (busquedas, filtrado y publicado/no publicado).

## Tecnologias

- PHP 8.x
- MySQL o MariaDB
- Twig (`twig/twig`)
- Composer
- HTML5, CSS3 y JavaScript

## Estructura del repositorio

```text
.
├── practica2/
├── practica3/
├── practica4/
└── practica5/
```

Cada carpeta incluye su propio codigo, recursos (`css/`, `js/`, `img/`), plantillas y, en las practicas dinamicas, su propio `sibw.sql`.

## Evolucion por practicas

### Practica 2

- Interfaz estatica del portal de peliculas.
- Vistas principales:
	- `practica2/html/portada.html`
	- `practica2/html/pelicula.html`
	- `practica2/html/pelicula_imprimir.html`
- Interaccion en cliente con JavaScript (comentarios, validaciones basicas y UI).

### Practica 3

- Paso a arquitectura con PHP + Twig.
- Carga de peliculas desde base de datos.
- Plantillas en `practica3/templates/`.
- Punto de entrada principal: `practica3/portada.php`.

### Practica 4

- Sistema de login/logout y creacion de cuenta.
- Gestion de sesion y roles (`registrado`, `moderador`, `gestor`, `admin`).
- CRUD de peliculas, imagenes y hashtags segun permisos.
- Moderacion de comentarios (editar/eliminar) y filtrado de palabras prohibidas.
- Vistas de administracion:
	- `listar_pelis.php`
	- `listar_coments.php`
	- `listar_usuarios.php`

### Practica 5

- Extiende `practica4` con mejoras de gestion.
- Busqueda de peliculas por titulo (via `fetch`) y por descripcion (cliente).
- Gestion del estado de publicacion de peliculas (`publicado`) desde listado.
- Tabla parcial renderizada con Twig (`templates/tabla_pelis.html`) para refresco dinamico.

## Requisitos previos

- PHP 8.1+ recomendado
- Composer instalado globalmente
- MySQL/MariaDB en ejecucion
- Extension `mysqli` habilitada en PHP

Puedes comprobar versiones con:

```bash
php -v
composer -V
mysql --version
```

## Instalacion y ejecucion

Las practicas 3, 4 y 5 tienen backend PHP con Twig y base de datos.

### 1. Elegir practica

Ejemplo con `practica5`:

```bash
cd practica5
```

### 2. Instalar dependencias PHP

```bash
composer install
```

### 3. Crear e importar base de datos

Desde MySQL/MariaDB:

```sql
CREATE DATABASE IF NOT EXISTS sibw CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE sibw;
SOURCE sibw.sql;
```

Tambien puedes importar `sibw.sql` con phpMyAdmin o herramienta equivalente.

### 4. Configurar conexion a BD

Revisa `baseDatos.php` de la practica elegida y adapta credenciales si es necesario:

- `hostname`
- `username`
- `password`
- `database`
- `port`

### 5. Levantar servidor local

Desde la carpeta de la practica:

```bash
php -S localhost:8000
```

### 6. Abrir en navegador

- Practicas dinamicas: `http://localhost:8000/portada.php`
- Practica estatica (`practica2`): `http://localhost:8000/html/portada.html` (si levantas servidor en `practica2`) o abrir el HTML directamente.

## Archivos clave

- `practica3/portada.php`, `practica4/portada.php`, `practica5/portada.php`: entrada principal.
- `practica4/login.php`, `practica5/login.php`: autenticacion.
- `practica4/pelicula.php`, `practica5/pelicula.php`: vista de detalle y comentarios.
- `practica5/listar_pelis.php`: listado de peliculas con busqueda y cambios de publicacion.
- `practica4/modelos/` y `practica5/modelos/`: acceso a datos.

## Notas

- El proyecto esta organizado por entregas de practicas; no es una unica app monolitica con routing centralizado.
- En el repositorio hay carpetas `vendor/` incluidas en algunas practicas, pero se recomienda ejecutar `composer install` en el entorno local para asegurar compatibilidad.
- Para pruebas locales, usa siempre el `sibw.sql` de la practica que vayas a ejecutar, ya que el esquema evoluciona entre versiones.
