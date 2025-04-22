-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 22-04-2025 a las 10:03:32
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sibw`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `id` int(11) NOT NULL,
  `autor` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `comentario` text DEFAULT NULL,
  `id_pelicula` int(11) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`id`, `autor`, `email`, `comentario`, `id_pelicula`, `fecha`) VALUES
(1, 'José González Fernández', 'jgf@gmail.com', 'Una película increíble', 1, '2025-04-21 08:54:49'),
(2, 'María Rodríguez Ortega', 'mro@gmail.com', 'Es mi película favorita', 1, '2025-04-21 08:54:49'),
(16, 'Jorge Cano', 'jcm@gmail.com', '******', 1, '2025-04-21 08:54:49'),
(17, 'Pepe', 'pp@gmail.com', 'es un ***** ', 1, '2025-04-21 08:54:49'),
(18, 'Carlos', 'carlos@gmail.com', 'buena película', 1, '2025-04-21 08:54:49'),
(19, 'Jose', 'j@gmail.com', 'hola', 1, '2025-04-21 08:54:49'),
(20, 'Juanmi', 'acostao@gmail.com', 'hola', 1, '2025-04-21 08:54:49');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes`
--

CREATE TABLE `imagenes` (
  `id_img` int(11) NOT NULL,
  `id_pelicula` int(11) DEFAULT NULL,
  `ruta` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `imagenes`
--

INSERT INTO `imagenes` (`id_img`, `id_pelicula`, `ruta`) VALUES
(1, 1, './img/interstellar.png'),
(2, 2, './img/oblivion.jpg'),
(3, 3, './img/it.jpg'),
(4, 4, './img/cbo.png'),
(5, 1, './img/interstellar-2.webp'),
(6, 1, './img/interstellar-1.webp'),
(7, 5, './img/gdg.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `palabrasProh`
--

CREATE TABLE `palabrasProh` (
  `id` int(11) NOT NULL,
  `palabra` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `palabrasProh`
--

INSERT INTO `palabrasProh` (`id`, `palabra`) VALUES
(1, 'imbécil'),
(2, 'tonto'),
(3, 'subnormal'),
(4, 'gilipollas'),
(5, 'idiota');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pelicula`
--

CREATE TABLE `pelicula` (
  `titulo` varchar(100) NOT NULL,
  `director` varchar(100) DEFAULT NULL,
  `actores` text DEFAULT NULL,
  `genero` varchar(100) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `id` int(11) NOT NULL,
  `fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pelicula`
--

INSERT INTO `pelicula` (`titulo`, `director`, `actores`, `genero`, `descripcion`, `id`, `fecha`) VALUES
('Interstellar', 'Christopher Nolan', 'Matthew McConaughey, Anne Haithaway, David Gyasi', 'Ciencia ficcion', 'Al ver que la vida en la Tierra está llegando a su fin, un grupo de exploradores dirigidos por el piloto Cooper (McConaughey) y la científica Amelia (Hathaway) emprende una misión que puede ser la más importante de la historia de la humanidad: viajar más allá de nuestra galaxia para descubrir algún planeta en otra que pueda garantizar el futuro de la raza humana.', 1, '2014-11-07'),
('Oblivion', NULL, NULL, NULL, NULL, 2, NULL),
('It', NULL, NULL, NULL, NULL, 3, NULL),
('Batman', NULL, NULL, NULL, NULL, 4, NULL),
('Guardianes de la Galaxia', NULL, NULL, NULL, NULL, 5, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pelicula` (`id_pelicula`);

--
-- Indices de la tabla `imagenes`
--
ALTER TABLE `imagenes`
  ADD PRIMARY KEY (`id_img`),
  ADD KEY `id_pelicula` (`id_pelicula`);

--
-- Indices de la tabla `palabrasProh`
--
ALTER TABLE `palabrasProh`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pelicula`
--
ALTER TABLE `pelicula`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `imagenes`
--
ALTER TABLE `imagenes`
  MODIFY `id_img` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `palabrasProh`
--
ALTER TABLE `palabrasProh`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `pelicula`
--
ALTER TABLE `pelicula`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`id_pelicula`) REFERENCES `pelicula` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `imagenes`
--
ALTER TABLE `imagenes`
  ADD CONSTRAINT `imagenes_ibfk_1` FOREIGN KEY (`id_pelicula`) REFERENCES `pelicula` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
