-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 21-05-2025 a las 15:56:28
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
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `modificado` char(1) DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`id`, `autor`, `email`, `comentario`, `id_pelicula`, `fecha`, `modificado`) VALUES
(44, 'pp', 'pp@gmail.com', 'muy *****', 9, '2025-05-16 16:44:14', 'S'),
(48, 'pepe', 'ppito@gmail.com', 'eres un *****', 2, '2025-05-17 08:50:31', 'S'),
(54, 'root', 'admin@gmail.com', 'aterradora', 3, '2025-05-20 07:55:03', 'S'),
(55, 'carlos', 'nn@gmail.com', 'si le gusto la pelicula', 3, '2025-05-20 08:01:15', 'S'),
(56, 'moderador', 'mm@gmail.com', 'increible **********', 3, '2025-05-20 08:04:38', 'N'),
(58, 'gestor', 'g@gmail.com', 'muy buena', 2, '2025-05-21 07:42:18', 'N'),
(59, 'carlos', 'cc@gmail.com', 'no da miedo', 3, '2025-05-21 07:45:12', 'N');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hashtags`
--

CREATE TABLE `hashtags` (
  `id_hashtag` int(11) NOT NULL,
  `hashtag` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `hashtags`
--

INSERT INTO `hashtags` (`id_hashtag`, `hashtag`) VALUES
(6, '#aterradora'),
(3, '#espectacular'),
(2, '#increible'),
(5, '#lamejor'),
(7, '#muybuena'),
(1, '#peliculon');

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
(2, 2, './img/oblivion.jpg'),
(3, 3, './img/it.jpg'),
(4, 4, './img/cbo.png'),
(7, 5, './img/gdg.jpg'),
(13, 9, './img/interstellar.png'),
(14, 9, './img/interstellar-1.webp'),
(15, 9, './img/interstellar-2.webp'),
(23, 2, './img/cbo.png'),
(25, 5, './img/cbo.png');

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
('Oblivion 2', 'Joseph Kosinski', 'Tom Cruise, Morgan Freeman, Olga Kurylenko', 'Ciencia ficción', 'Oblivion (titulada Oblivion: el tiempo del olvido en Hispanoamérica) es una película de ciencia ficción dirigida y coproducida por Joseph Kosinski.', 2, '2019-04-16'),
('It', 'Andrés Muschietti', 'Jaeden Martell, Bill Skarsgård, Finn Wolfhard, Sophia Lillis', 'Terror sobrenatural', 'Un grupo de niños en Derry, Maine, enfrenta a una entidad maligna que adopta la forma de un payaso llamado Pennywise.', 3, '2017-09-08'),
('Batman', 'Matt Reeves', 'Robert Pattinson, Zoë Kravitz, Paul Dano, Jeffrey Wright', 'Acción, Crimen, Drama', 'Batman investiga una serie de asesinatos en Gotham que lo llevan a descubrir la corrupción en la ciudad y su conexión con su propia familia.', 4, '2022-03-04'),
('Guardianes de la Galaxia', 'James Gunn', 'Chris Pratt, Zoe Saldaña, Dave Bautista, Vin Diesel, Bradley Cooper', 'Ciencia ficción', 'Oblivion (titulada Oblivion: el tiempo del olvido en Hispanoamérica) es una película de ciencia ficción dirigida y coproducida por Joseph Kosinski.', 5, '2014-08-01'),
('Interstellar', 'Christopher Nolan', 'Matthew McConaughey, Anne Hathaway', 'Ciencia ficción', 'Al ver que la vida en la Tierra está llegando a su fin, un grupo de exploradores dirigidos por el piloto Cooper (McConaughey) y la científica Amelia (Hathaway) emprende una misión que puede ser la más importante de la historia de la humanidad: viajar más allá de nuestra galaxia para descubrir algún planeta en otra que pueda garantizar el futuro de la raza humana.', 9, '2014-11-07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `peliculas_hashtags`
--

CREATE TABLE `peliculas_hashtags` (
  `id_pelicula` int(11) NOT NULL,
  `id_hashtag` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `peliculas_hashtags`
--

INSERT INTO `peliculas_hashtags` (`id_pelicula`, `id_hashtag`) VALUES
(2, 1),
(2, 3),
(3, 1),
(3, 6),
(5, 5),
(9, 1),
(9, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`) VALUES
(1, 'admin'),
(3, 'gestor'),
(2, 'moderador'),
(4, 'registrado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `rol_id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `password`, `rol_id`, `email`) VALUES
(1, 'root', '$2y$10$soI5WBm551rQPfrHpMC6W.CN68xHs4KV7ajkzjGAd16gdkjCTCqLm', 1, 'admin@gmail.com'),
(2, 'moderador', '$2y$10$1O5RU/NYnkdlw9.4lrZkjevxdgF2fde/rw20T.eSTOl0ja6K1UA4u', 2, 'mm@gmail.com'),
(3, 'gestor', '$2y$10$bLy6Uu8ex7UKes5K/4zaDeWn0cm5gJScu9zaMvg37iWj9tJyALh7K', 3, 'g@gmail.com'),
(7, 'jorge', '$2y$10$rvPndI6QnVr/y./zgIXCW.motefvVrrRy5gma0XSCl23yZClIs1dC', 1, 'nuevoemail@dominio.com'),
(9, 'pepe', '$2y$10$XqJPL6mB9X3GyQVC5WN.uuchidXsEenkm1FO.lE2wzW5tZyR0Ep8i', 1, 'ppito@gmail.com'),
(10, 'carlos', '$2y$10$M2Q6pMbsTolzhhG5rl9xTe60YYQpWrVyAb1Kp7sLa1E9G4fUgc.0q', 4, 'cc@gmail.com');

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
-- Indices de la tabla `hashtags`
--
ALTER TABLE `hashtags`
  ADD PRIMARY KEY (`id_hashtag`),
  ADD UNIQUE KEY `hashtag` (`hashtag`);

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
-- Indices de la tabla `peliculas_hashtags`
--
ALTER TABLE `peliculas_hashtags`
  ADD PRIMARY KEY (`id_pelicula`,`id_hashtag`),
  ADD KEY `id_hashtag` (`id_hashtag`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`),
  ADD KEY `rol_id` (`rol_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT de la tabla `hashtags`
--
ALTER TABLE `hashtags`
  MODIFY `id_hashtag` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `imagenes`
--
ALTER TABLE `imagenes`
  MODIFY `id_img` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `palabrasProh`
--
ALTER TABLE `palabrasProh`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `pelicula`
--
ALTER TABLE `pelicula`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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

--
-- Filtros para la tabla `peliculas_hashtags`
--
ALTER TABLE `peliculas_hashtags`
  ADD CONSTRAINT `peliculas_hashtags_ibfk_1` FOREIGN KEY (`id_pelicula`) REFERENCES `pelicula` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `peliculas_hashtags_ibfk_2` FOREIGN KEY (`id_hashtag`) REFERENCES `hashtags` (`id_hashtag`) ON DELETE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
