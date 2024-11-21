-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 21-11-2024 a las 00:16:03
-- Versión del servidor: 8.0.39-0ubuntu0.24.04.2
-- Versión de PHP: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `MecaYuca`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int NOT NULL,
  `rol` enum('admin','usuario','guia') NOT NULL,
  `nombre_usuario` varchar(50) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `contrasena` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `rol`, `nombre_usuario`, `correo`, `contrasena`) VALUES
(1, 'admin', 'CarlosAdmin', 'carlos.admin@gmail.com', '$2y$10$GwzM7hrcpkSKcPPHS//C9uRqB54LM5CpqSScEWzPL/66POWS9eobW'),
(2, 'admin', 'AnaAdmin', 'ana.admin@outlook.com', '$2y$10$KrpYTax4XJU6SENrMbDcvOAjq5Wy9shmDtO3TQRlfdUEt/BU09Yby'),
(3, 'usuario', 'JuanPerez', 'juan.perez@gmail.com', '$2y$10$nA4KkTxiBL456/f9.zV17Oxuu/9FHgR8pcXnXv6KkbXteqsRUY0jW'),
(4, 'usuario', 'MariaLopez', 'maria.lopez@outlook.com', '$2y$10$FRvy9iXqmDXdb4FvXnybdOfUsVKV0djdac6w3MI7uziJhhWUKTQ1e'),
(5, 'usuario', 'EmilyJohnson', 'emily.johnson@gmail.com', '$2y$10$x1RGSljeqLcS7JhA01mLW.C1jTMguaAQ.RQzyM9rpgxteWUV0XFkK'),
(6, 'usuario', 'MiguelGarcia', 'miguel.garcia@outlook.com', '$2y$10$1/VuCa9Cs17Opc6Dz2ioQ.SruKf8oaACwoLqeM7SvMvmZ/eHfNK2W'),
(7, 'usuario', 'RobertSmith', 'robert.smith@gmail.com', '$2y$10$EmiT2MjnXtecCYMHOumQD.lzv1CwSAL8yYJyhxYj8otVdiHMcwlye'),
(8, 'usuario', 'DiegoHernandez', 'diego.hernandez@gmail.com', '$2y$10$.4UxVDhuMq7AvWswXEOeqOeWAtksHOJUZbsBlsc.rXbDcQN9ZFbJ2'),
(9, 'guia', 'JoseGuia', 'jose.guia@outlook.com', '$2y$10$fTDvYGb8vQAK5CBvOTAzouoEerdCjXSEX/7977a85utiVBu7ncNYi'),
(10, 'guia', 'LauraGuia', 'laura.guia@gmail.com', '$2y$10$XOMQbojhtpJEx0bZA2RNHOWi8KvRV63OadlV6umQlJ5i4B3YvDIu6'),
(11, 'usuario', 'Mike', 'mije2709@gmail.com', '$2y$10$pWmIccB4RrTzMkeJfUz0V.s7QkLvJiefCPAi.3eF8oFSeRqILfI2u'),
(12, 'usuario', 'Bryan', 'bryanuwu@gmail.com', '$2y$10$SB3omd9XJo3a31iuRJwuX.H6aZzOr.O4QurO5K04qtmKHqmcrMzK6');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `id` int NOT NULL,
  `id_cliente` int DEFAULT NULL,
  `comentario_usuario` text NOT NULL,
  `comentario_admin` text,
  `fecha_comentario` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`id`, `id_cliente`, `comentario_usuario`, `comentario_admin`, `fecha_comentario`) VALUES
(1, 3, 'Excelente viaje, muy recomendado!', 'Gracias por tu comentario, Juan!', '2024-11-13 14:31:56'),
(2, 4, 'El tour estuvo bien, pero el guía se demoró.', 'Gracias por tus comentarios, María. Trabajaremos en mejorar.', '2024-11-13 14:31:56'),
(3, 5, 'El lugar fue increíble, aunque el clima no ayudó mucho.', 'Lamentamos el inconveniente, Emily.', '2024-11-13 14:31:56'),
(4, 6, 'Muy bien organizado, lo disfruté bastante!', 'Nos alegra que te haya gustado, Miguel.', '2024-11-13 14:31:56'),
(5, 7, 'La atención fue excelente, volveré a contratar el servicio.', '¡Gracias, Robert! Esperamos verte pronto.', '2024-11-13 14:31:56'),
(6, 8, 'Buena experiencia, aunque esperaba más lugares.', 'Gracias por tu opinión, Diego. Consideraremos tus sugerencias.', '2024-11-13 14:31:56'),
(7, 3, 'Espectacular! El mejor viaje que he tenido.', 'Gracias, Juan. Nos alegra mucho.', '2024-11-13 14:31:56'),
(8, 6, '¿Podrían agregar otros destinos cercanos?', 'Estamos trabajando en ello, Miguel.', '2024-11-13 14:31:56'),
(9, 7, 'El guía era muy atento y amable.', '¡Gracias por compartir tu experiencia, Robert!', '2024-11-13 14:31:56'),
(10, 5, 'Podría mejorar el transporte.', 'Agradecemos tus comentarios, Emily.', '2024-11-13 14:31:56');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `guias`
--

CREATE TABLE `guias` (
  `id` int NOT NULL,
  `nombre_guia` varchar(100) NOT NULL,
  `numero_identificacion` varchar(20) NOT NULL,
  `longevidad` int DEFAULT NULL,
  `salario` decimal(10,2) NOT NULL,
  `id_cliente` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `guias`
--

INSERT INTO `guias` (`id`, `nombre_guia`, `numero_identificacion`, `longevidad`, `salario`, `id_cliente`) VALUES
(2, 'Laura Gómez', 'GID002', 3, 14000.00, 5),
(3, 'Pedro Hernández', 'GID003', 8, 16000.00, NULL),
(4, 'Carla Romero', 'GID004', 4, 14500.00, NULL),
(5, 'Luis Navarro', 'GID005', 6, 15500.00, NULL),
(6, 'Fernanda Díaz', 'GID006', 2, 13500.00, NULL),
(7, 'Pablo Torres', 'GID007', 10, 18000.00, NULL),
(8, 'Ana Sandoval', 'GID008', 7, 15000.00, NULL),
(9, 'Miguel Castro', 'GID009', 5, 15200.00, NULL),
(10, 'Sofía Ruiz', 'GID010', 4, 14800.00, NULL),
(16, 'Amce', '740', 20, 500.00, 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lugares`
--

CREATE TABLE `lugares` (
  `id` int NOT NULL,
  `nombre_lugar` varchar(100) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `costo_por_persona` decimal(10,2) NOT NULL,
  `descuento` decimal(5,2) DEFAULT '0.00',
  `anticipo` decimal(10,2) DEFAULT NULL,
  `guia_especializado` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `lugares`
--

INSERT INTO `lugares` (`id`, `nombre_lugar`, `fecha_inicio`, `fecha_fin`, `costo_por_persona`, `descuento`, `anticipo`, `guia_especializado`) VALUES
(1, 'Chichén Itzá', '2024-01-10', '2024-01-12', 1500.00, 10.00, 300.00, 9),
(2, 'Uxmal', '2024-02-15', '2024-02-17', 1200.00, 5.00, 250.00, 10),
(3, 'Cenote Ik Kil', '2024-03-20', '2024-03-20', 800.00, 0.00, 100.00, 9),
(4, 'Valladolid', '2024-04-05', '2024-04-06', 900.00, 15.00, 150.00, 10),
(5, 'Mérida City Tour', '2024-05-12', '2024-05-12', 500.00, 0.00, 100.00, 9),
(6, 'Isla Holbox', '2024-06-20', '2024-06-22', 2000.00, 20.00, 500.00, 10),
(7, 'Cenote Suytun', '2024-07-10', '2024-07-10', 850.00, 5.00, 150.00, 9),
(8, 'Izamal', '2024-08-15', '2024-08-15', 700.00, 0.00, 100.00, 10),
(9, 'Las Coloradas', '2024-09-05', '2024-09-06', 1300.00, 10.00, 200.00, 9),
(10, 'Ría Celestún', '2024-10-10', '2024-10-11', 1600.00, 0.00, 300.00, 10),
(11, 'San Felipe y Rio Lagartos', '2024-09-27', '2024-09-30', 1500.00, 250.00, 500.00, 10);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- Indices de la tabla `guias`
--
ALTER TABLE `guias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numero_identificacion` (`numero_identificacion`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- Indices de la tabla `lugares`
--
ALTER TABLE `lugares`
  ADD PRIMARY KEY (`id`),
  ADD KEY `guia_especializado` (`guia_especializado`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `guias`
--
ALTER TABLE `guias`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `lugares`
--
ALTER TABLE `lugares`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id`);

--
-- Filtros para la tabla `guias`
--
ALTER TABLE `guias`
  ADD CONSTRAINT `guias_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id`);

--
-- Filtros para la tabla `lugares`
--
ALTER TABLE `lugares`
  ADD CONSTRAINT `lugares_ibfk_1` FOREIGN KEY (`guia_especializado`) REFERENCES `clientes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
