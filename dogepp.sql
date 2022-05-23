-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-05-2022 a las 17:25:41
-- Versión del servidor: 10.4.21-MariaDB
-- Versión de PHP: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dogepp`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `amigo`
--

CREATE TABLE `amigo` (
  `id_usuario` char(9) NOT NULL,
  `id_usuario_amigo` char(9) NOT NULL,
  `contenido` varchar(500) NOT NULL,
  `fecha` date NOT NULL,
  `estado` set('0','1') NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `amigo`
--

INSERT INTO `amigo` (`id_usuario`, `id_usuario_amigo`, `contenido`, `fecha`, `estado`, `nombre`) VALUES
('11111111A', '76739116F', 'Agregame Rodolfo, soy Raúl.', '2022-05-08', '1', 'rulo'),
('76739116F', '11111111A', 'Agregame Rodolfo, soy Raúl.', '2022-05-08', '1', 'rodolfin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anuncio`
--

CREATE TABLE `anuncio` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `imagen` varchar(50) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `precio` decimal(5,2) NOT NULL,
  `descripcion` varchar(5000) NOT NULL,
  `id_usuario` char(9) NOT NULL,
  `activo` set('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `anuncio`
--

INSERT INTO `anuncio` (`id`, `imagen`, `titulo`, `precio`, `descripcion`, `id_usuario`, `activo`) VALUES
(1, '1.jpg', 'Paseo perros por Armilla', '10.00', 'Se pasean perros por Armilla y alrededores. No acepto razas categorizadas como peligrosas.', '11111111A', '1'),
(2, '2.jpg', 'Domestico a perros en Granada Capital', '25.99', 'Se domestican perros por Granada centro. Acepto razas categorizadas como peligrosas.', '22222222B', '1'),
(3, '3.jpg', 'Paseo perros por Gabia', '30.00', 'Se pasean perros por Gabia y alrededores. Acepto razas categorizadas como peligrosas.', '33333333C', '1'),
(4, '4.jpg', 'Cuido perros en Granada centro', '20.00', 'Se cuidan perros por Granada capital. No acepto razas categorizadas como peligrosas.', '11111111A', '1'),
(5, '5.jpg', 'Peino y lavo perros por encargo', '35.99', 'Se peinan y lavan perros por Granada en general. Yo me desplazo. No acepto razas categorizadas como peligrosas.', '22222222B', '1'),
(6, '6.jpg', 'Domestico perros en Granada centro', '40.55', 'Se domestican perros por Granada capital. Acepto cualquier tipo de raza.', '33333333C', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `apunta`
--

CREATE TABLE `apunta` (
  `id_ruta` bigint(20) UNSIGNED NOT NULL,
  `id_usuario` char(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `apunta`
--

INSERT INTO `apunta` (`id_ruta`, `id_usuario`) VALUES
(1, '76739116F');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentario`
--

CREATE TABLE `comentario` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `contenido` varchar(5000) NOT NULL,
  `id_usuario` char(9) NOT NULL,
  `id_parque` bigint(20) UNSIGNED NOT NULL,
  `activo` set('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `comentario`
--

INSERT INTO `comentario` (`id`, `fecha`, `contenido`, `id_usuario`, `id_parque`, `activo`) VALUES
(1, '2022-05-09', 'Bastante buena experiencia', '11111111A', 1, '1'),
(2, '2022-05-12', 'Que guapo', '76739116F', 1, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `cif` char(9) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `contraseña` char(32) NOT NULL,
  `telefono` char(9) DEFAULT NULL,
  `imagen` varchar(50) NOT NULL,
  `activo` set('0','1') NOT NULL,
  `localizacion` varchar(1000) DEFAULT NULL,
  `tipo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`cif`, `nombre`, `contraseña`, `telefono`, `imagen`, `activo`, `localizacion`, `tipo`) VALUES
('11111111A', 'Piensos Francisco', 'c4ca4238a0b923820dcc509a6f75849b', '123456789', '11111111A.jpg', '1', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12720.722759036444!2d-3.6773192882537824!3d37.148402861457306!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd71f9514fa8cbf9%3A0x3a78e2fef87c5358!2sPabell%C3%B3n%20Multifuncional%20de%20H%C3%ADjar%20(Las%20Gabias)!5e0!3m2!1ses!2ses!4v1650391689347!5m2!1ses!2ses\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 'Agropecuario'),
('22222222B', 'Carnicas Paquito', 'c81e728d9d4c2f636f067f89cc14862c', '999888777', '22222222B.jpg', '1', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12723.092431922432!2d-3.678204565207414!3d37.13431267809574!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd71f95da29ae509%3A0x2d812d3a40b86b2b!2s18110%20Las%20Gabias%2C%20Granada!5e0!3m2!1ses!2ses!4v1652342576349!5m2!1ses!2ses\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 'Alimenticia'),
('33333333C', 'Corte Inglés', 'eccbc87e4b5ce2fe28308fd9f2a7baf3', '958333333', '33333333C.jpg', '1', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12720.722759036444!2d-3.6773192882537824!3d37.148402861457306!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd71f9514fa8cbf9%3A0x3a78e2fef87c5358!2sPabell%C3%B3n%20Multifuncional%20de%20H%C3%ADjar%20(Las%20Gabias)!5e0!3m2!1ses!2ses!4v1650391689347!5m2!1ses!2ses\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 'Tienda de ropa'),
('44444444D', 'Bar Los Manueles', 'a87ff679a2f3e71d9181a67b7542122c', '958444444', '44444444D.jpg', '1', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12720.722759036444!2d-3.6773192882537824!3d37.148402861457306!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd71f9514fa8cbf9%3A0x3a78e2fef87c5358!2sPabell%C3%B3n%20Multifuncional%20de%20H%C3%ADjar%20(Las%20Gabias)!5e0!3m2!1ses!2ses!4v1650391689347!5m2!1ses!2ses\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 'Bar de tapas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evento`
--

CREATE TABLE `evento` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `imagen` varchar(5000) NOT NULL,
  `descripcion` varchar(5000) NOT NULL,
  `localizacion` varchar(500) NOT NULL,
  `fecha` date NOT NULL,
  `id_empresa` char(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `evento`
--

INSERT INTO `evento` (`id`, `nombre`, `imagen`, `descripcion`, `localizacion`, `fecha`, `id_empresa`) VALUES
(1, 'Concurso de belleza', 'http://estaticos.elmundo.es/assets/multimedia/imagenes/2016/09/13/14737633825967.jpg', 'Concurso de belleza en el que podrán participar toda clase de perros y cuyo premio es 1000€ en lotes de nuestros productos más selectos. \nEmpezamos a las 9:00 AM.', 'C/ Alhamar, Nº32', '2022-06-24', '11111111A'),
(2, 'Carrera de perros', 'https://www.hobbyaficion.com/wp-content/uploads/2019/01/Foto_descripcion_Agility-1.jpg', 'Carrera de perros que se prevee muy divertida y trepidante.', 'C/ Benito, Nº12', '2022-06-28', '11111111A'),
(3, 'Concurso de comida', 'https://mundo.culturizando.com/wp-content/uploads/2016/12/Perro-comiendo.png', 'Concurso para descubrir cual es el perro más glotón de Granada.', 'C/ San Isidro, Nº2', '2022-07-13', '22222222B'),
(4, '¡Todos a jugar!', 'https://cloudfront-us-east-1.images.arcpublishing.com/infobae/FY6H2UVRPBAYRMV6JGJ7TQD62M.jpg', 'Tráete a tu perro y disfruta de un gran día jugando con él y descubriendo gente maravillosa.', 'C/ Unamuno, Nº2', '2022-08-25', '33333333C'),
(5, '¡Muéstranos el talento de tu amigo perruno!', 'https://www.eldiario24.com/d24ar/fotos/uploads/editorial/2013/05/02/imagenes/12668_perro_malabasritas11.jpg', 'Ha llegado el día en el que tu perro puedo demostrar lo que vale. ¡Incluso tenemos premios para todos los participantes!', 'C/ Dulcinea, Nº3', '2022-06-25', '44444444D');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensaje`
--

CREATE TABLE `mensaje` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `contenido` varchar(5000) NOT NULL,
  `id_usuario_envia` char(9) NOT NULL,
  `id_usuario_recibe` char(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `mensaje`
--

INSERT INTO `mensaje` (`id`, `fecha`, `hora`, `contenido`, `id_usuario_envia`, `id_usuario_recibe`) VALUES
(1, '2022-05-08', '19:27:03', 'Hola Raúl. ¿Me lees?\n', '11111111A', '76739116F'),
(2, '2022-05-08', '19:27:44', 'Hola Rodolfo. Sí, claro que te leo.', '76739116F', '11111111A'),
(3, '2022-05-08', '19:42:04', 'Genial :)', '11111111A', '76739116F');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parque`
--

CREATE TABLE `parque` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `descripcion` varchar(5000) NOT NULL,
  `localizacion` varchar(1000) NOT NULL,
  `reglas` varchar(5000) NOT NULL,
  `imagen` varchar(50) NOT NULL,
  `id_usuario` char(9) NOT NULL,
  `activo` set('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `parque`
--

INSERT INTO `parque` (`id`, `nombre`, `descripcion`, `localizacion`, `reglas`, `imagen`, `id_usuario`, `activo`) VALUES
(1, 'García Lorca', 'Parque muy mítico con grandes vistas y cacharritos para los mas peques.', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12720.717005251856!2d-3.677348792552953!3d37.14843706815726!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd71f9514fa8cbf9%3A0x3a78e2fef87c5358!2sPabell%C3%B3n%20Multifuncional%20de%20H%C3%ADjar%20(Las%20Gabias)!5e0!3m2!1ses!2ses!4v1650283091972!5m2!1ses!2ses\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', '- No razas peligrosas', '1.jpg', '11111111A', '1'),
(2, 'Tico Medina', 'Es un parque muy bonito y muy cercano al Parque de las Ciencias.', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12720.717005251856!2d-3.677348792552953!3d37.14843706815726!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd71f9514fa8cbf9%3A0x3a78e2fef87c5358!2sPabell%C3%B3n%20Multifuncional%20de%20H%C3%ADjar%20(Las%20Gabias)!5e0!3m2!1ses!2ses!4v1650283091972!5m2!1ses!2ses\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 'Ninguna', '2.jpg', '22222222B', '1'),
(3, 'Almunia de Ainadamar', 'Parque muy bonito con pocos transeúntes.', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12720.717005251856!2d-3.677348792552953!3d37.14843706815726!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd71f9514fa8cbf9%3A0x3a78e2fef87c5358!2sPabell%C3%B3n%20Multifuncional%20de%20H%C3%ADjar%20(Las%20Gabias)!5e0!3m2!1ses!2ses!4v1650283091972!5m2!1ses!2ses\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', '- No fumar\r\n- No razas peligrosas', '3.jpg', '33333333C', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reporta`
--

CREATE TABLE `reporta` (
  `id_usuario` char(9) NOT NULL,
  `id_usuario_reportado` char(9) NOT NULL,
  `fecha` date NOT NULL,
  `comentario` varchar(5000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ruta`
--

CREATE TABLE `ruta` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `inicio` varchar(50) NOT NULL,
  `fin` varchar(50) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `reglas` varchar(5000) NOT NULL,
  `mapa` varchar(1000) NOT NULL,
  `id_usuario` char(9) NOT NULL,
  `activo` set('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ruta`
--

INSERT INTO `ruta` (`id`, `inicio`, `fin`, `fecha`, `hora`, `reglas`, `mapa`, `id_usuario`, `activo`) VALUES
(1, 'Armilla', 'Churriana', '2022-06-21', '10:43:24', '- No fumar\r\n- No traer razas peligrosas', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12721.374379898216!2d-3.6426106500000004!3d37.14452874999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd71fbed7047a625%3A0xa03d27b24848430!2sChurriana%20de%20la%20Vega%2C%20Granada!5e0!3m2!1ses!2ses!4v1652089453137!5m2!1ses!2ses\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', '11111111A', '1'),
(2, 'Churriana', 'Gabia', '2022-06-24', '12:48:00', '- No fumar', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12720.722759036444!2d-3.6773192882537824!3d37.148402861457306!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd71f9514fa8cbf9%3A0x3a78e2fef87c5358!2sPabell%C3%B3n%20Multifuncional%20de%20H%C3%ADjar%20(Las%20Gabias)!5e0!3m2!1ses!2ses!4v1650391689347!5m2!1ses!2ses\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', '22222222B', '1'),
(3, 'Gabia', 'Armilla', '2022-06-19', '13:55:00', 'Ninguna', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12720.722759036444!2d-3.6773192882537824!3d37.148402861457306!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd71f9514fa8cbf9%3A0x3a78e2fef87c5358!2sPabell%C3%B3n%20Multifuncional%20de%20H%C3%ADjar%20(Las%20Gabias)!5e0!3m2!1ses!2ses!4v1650391689347!5m2!1ses!2ses\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', '33333333C', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `dni` char(9) NOT NULL,
  `tipo` set('b','a') NOT NULL,
  `nick` varchar(50) NOT NULL,
  `imagen` varchar(50) NOT NULL,
  `contraseña` char(32) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `teléfono` char(9) DEFAULT NULL,
  `activo` set('0','1') NOT NULL,
  `estado` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`dni`, `tipo`, `nick`, `imagen`, `contraseña`, `nombre`, `teléfono`, `activo`, `estado`) VALUES
('000000000', 'a', 'admin', 'default.png', '21232f297a57a5a743894a0e4a801fc3', 'Administrador', NULL, '1', 'Hola. Estoy usando Dogepp :)'),
('11111111A', 'a', 'rodolfo', '11111111A.jpg', '508a564003c578d429792581f1759074', 'Rodolfo', '958111111', '1', 'Me encantan los animales'),
('22222222B', 'a', 'maria', '22222222B.jpg', '263bce650e68ab4e23f28263760b9fa5', 'María', '958222222', '1', 'Ya llega el veranito :)'),
('33333333C', 'a', 'agustin', '33333333C.jpg', '4ff413b71217b7b2c3e845c71fc834a9', 'Agustín', NULL, '1', 'Hola. Estoy usando Dogepp :)'),
('44444444D', 'b', 'ana', '44444444D.jpg', '276b6c4692e78d4799c12ada515bc3e4', 'Ana', '958444444', '1', 'Feliz de la vida'),
('55555555E', 'b', 'manuel', '55555555E.jpg', '96917805fd060e3766a9a1b834639d35', 'Manuel', NULL, '1', 'Hola. Estoy usando Dogepp :)'),
('76739116F', 'b', 'raul', 'default.png', 'bc7a844476607e1a59d8eb1b1f311830', 'Raúl', NULL, '1', 'Hola. Estoy usando Dogepp :)');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `amigo`
--
ALTER TABLE `amigo`
  ADD PRIMARY KEY (`id_usuario`,`id_usuario_amigo`),
  ADD KEY `amigo_usuario_amigo` (`id_usuario_amigo`);

--
-- Indices de la tabla `anuncio`
--
ALTER TABLE `anuncio`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `anuncio_usuario` (`id_usuario`);

--
-- Indices de la tabla `apunta`
--
ALTER TABLE `apunta`
  ADD PRIMARY KEY (`id_ruta`,`id_usuario`),
  ADD KEY `apunta_usuario` (`id_usuario`);

--
-- Indices de la tabla `comentario`
--
ALTER TABLE `comentario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `comentario_usuario` (`id_usuario`),
  ADD KEY `comentario_parque` (`id_parque`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`cif`);

--
-- Indices de la tabla `evento`
--
ALTER TABLE `evento`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `evento_empresa` (`id_empresa`);

--
-- Indices de la tabla `mensaje`
--
ALTER TABLE `mensaje`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `mensaje_usuario_envia` (`id_usuario_envia`),
  ADD KEY `mensaje_usuario_recibe` (`id_usuario_recibe`);

--
-- Indices de la tabla `parque`
--
ALTER TABLE `parque`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `parque_usuario` (`id_usuario`);

--
-- Indices de la tabla `reporta`
--
ALTER TABLE `reporta`
  ADD PRIMARY KEY (`id_usuario`,`id_usuario_reportado`),
  ADD KEY `reporta_usuario_reportado` (`id_usuario_reportado`);

--
-- Indices de la tabla `ruta`
--
ALTER TABLE `ruta`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `ruta_usuario` (`id_usuario`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`dni`),
  ADD UNIQUE KEY `nick` (`nick`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `anuncio`
--
ALTER TABLE `anuncio`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `comentario`
--
ALTER TABLE `comentario`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `evento`
--
ALTER TABLE `evento`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `mensaje`
--
ALTER TABLE `mensaje`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de la tabla `parque`
--
ALTER TABLE `parque`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `ruta`
--
ALTER TABLE `ruta`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `amigo`
--
ALTER TABLE `amigo`
  ADD CONSTRAINT `amigo_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`dni`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `amigo_usuario_amigo` FOREIGN KEY (`id_usuario_amigo`) REFERENCES `usuario` (`dni`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `anuncio`
--
ALTER TABLE `anuncio`
  ADD CONSTRAINT `anuncio_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`dni`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `apunta`
--
ALTER TABLE `apunta`
  ADD CONSTRAINT `apunta_ruta` FOREIGN KEY (`id_ruta`) REFERENCES `ruta` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `apunta_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`dni`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `comentario`
--
ALTER TABLE `comentario`
  ADD CONSTRAINT `comentario_parque` FOREIGN KEY (`id_parque`) REFERENCES `parque` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comentario_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`dni`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `evento`
--
ALTER TABLE `evento`
  ADD CONSTRAINT `evento_empresa` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`cif`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `mensaje`
--
ALTER TABLE `mensaje`
  ADD CONSTRAINT `mensaje_usuario_envia` FOREIGN KEY (`id_usuario_envia`) REFERENCES `usuario` (`dni`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mensaje_usuario_recibe` FOREIGN KEY (`id_usuario_recibe`) REFERENCES `usuario` (`dni`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `parque`
--
ALTER TABLE `parque`
  ADD CONSTRAINT `parque_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`dni`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `reporta`
--
ALTER TABLE `reporta`
  ADD CONSTRAINT `reporta_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`dni`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reporta_usuario_reportado` FOREIGN KEY (`id_usuario_reportado`) REFERENCES `usuario` (`dni`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ruta`
--
ALTER TABLE `ruta`
  ADD CONSTRAINT `ruta_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`dni`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
