-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: mariadb:3306
-- Tiempo de generación: 06-11-2022 a las 22:02:25
-- Versión del servidor: 10.6.10-MariaDB
-- Versión de PHP: 8.0.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gestion_recursos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Reservations`
--

CREATE TABLE `Reservations` (
  `id` int(10) UNSIGNED NOT NULL,
  `idResource` int(10) UNSIGNED NOT NULL,
  `idUser` int(10) UNSIGNED NOT NULL,
  `idTimeslot` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `remarks` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `Reservations`
--

INSERT INTO `Reservations` (`id`, `idResource`, `idUser`, `idTimeslot`, `date`, `remarks`) VALUES
(19, 6, 2, 7, '2022-11-07', 'La estaré usando en el patio.'),
(27, 7, 27, 3, '2022-11-14', 'Todos los lunes hasta navidad. '),
(28, 7, 27, 3, '2022-11-21', 'Todos los lunes hasta navidad. '),
(29, 7, 27, 3, '2022-11-28', 'Todos los lunes hasta navidad. '),
(30, 7, 27, 3, '2022-12-05', 'Todos los lunes hasta navidad. '),
(31, 7, 27, 3, '2022-12-12', 'Todos los lunes hasta navidad. '),
(32, 7, 27, 3, '2022-12-19', 'Todos los lunes hasta navidad. '),
(33, 7, 27, 3, '2022-12-26', 'Todos los lunes hasta navidad. '),
(34, 14, 27, 27, '2022-11-17', 'Lo estaré usando para grabar el cable inglés.'),
(35, 9, 27, 34, '2022-11-18', 'Lo reservaré dos semanas para el módulo de entorno servidor'),
(36, 9, 27, 34, '2022-11-25', 'Lo reservaré dos semanas para el módulo de entorno servidor'),
(37, 9, 27, 34, '2022-12-02', 'Lo reservaré dos semanas para el módulo de entorno servidor'),
(38, 11, 34, 35, '2022-11-18', 'Para el curso de 1ºDaw, aula 21'),
(39, 11, 34, 35, '2022-11-25', 'Para el curso de 1ºDaw, aula 21'),
(41, 11, 34, 35, '2022-12-09', 'Para el curso de 1ºDaw, aula 21'),
(42, 11, 34, 35, '2022-12-16', 'Para el curso de 1ºDaw, aula 21'),
(43, 11, 34, 35, '2022-12-23', 'Para el curso de 1ºDaw, aula 21'),
(44, 11, 34, 35, '2022-12-30', 'Para el curso de 1ºDaw, aula 21'),
(45, 11, 34, 35, '2023-01-06', 'Para el curso de 1ºDaw, aula 21'),
(46, 11, 34, 35, '2023-01-13', 'Para el curso de 1ºDaw, aula 21'),
(47, 11, 34, 35, '2023-01-20', 'Para el curso de 1ºDaw, aula 21'),
(48, 11, 34, 35, '2023-01-27', 'Para el curso de 1ºDaw, aula 21'),
(49, 11, 34, 35, '2023-02-03', 'Para el curso de 1ºDaw, aula 21'),
(50, 11, 34, 35, '2023-02-10', 'Para el curso de 1ºDaw, aula 21'),
(51, 11, 34, 35, '2023-02-17', 'Para el curso de 1ºDaw, aula 21'),
(52, 11, 34, 35, '2023-02-24', 'Para el curso de 1ºDaw, aula 21'),
(53, 11, 34, 35, '2023-03-03', 'Para el curso de 1ºDaw, aula 21'),
(54, 11, 34, 35, '2023-03-10', 'Para el curso de 1ºDaw, aula 21'),
(55, 11, 34, 35, '2023-03-17', 'Para el curso de 1ºDaw, aula 21'),
(56, 11, 34, 35, '2023-03-24', 'Para el curso de 1ºDaw, aula 21'),
(57, 11, 34, 35, '2023-03-31', 'Para el curso de 1ºDaw, aula 21'),
(58, 11, 34, 35, '2023-04-07', 'Para el curso de 1ºDaw, aula 21'),
(59, 11, 34, 35, '2023-04-14', 'Para el curso de 1ºDaw, aula 21'),
(60, 11, 34, 35, '2023-04-21', 'Para el curso de 1ºDaw, aula 21'),
(61, 11, 34, 35, '2023-04-28', 'Para el curso de 1ºDaw, aula 21'),
(62, 11, 34, 35, '2023-05-05', 'Para el curso de 1ºDaw, aula 21'),
(63, 11, 34, 35, '2023-05-12', 'Para el curso de 1ºDaw, aula 21'),
(64, 11, 34, 35, '2023-05-19', 'Para el curso de 1ºDaw, aula 21'),
(65, 11, 34, 35, '2023-05-26', 'Para el curso de 1ºDaw, aula 21'),
(66, 9, 34, 33, '2022-11-18', 'Para arreglar algún fallo.'),
(67, 9, 34, 31, '2022-11-25', 'Adelantada la hora por dentista'),
(68, 13, 34, 7, '2022-11-07', 'Testeo del dron, mejor prevenir'),
(69, 14, 34, 7, '2022-11-07', 'Testeo en el patio');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Resources`
--

CREATE TABLE `Resources` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `location` varchar(200) NOT NULL,
  `image` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `Resources`
--

INSERT INTO `Resources` (`id`, `name`, `description`, `location`, `image`) VALUES
(6, 'Cámara 360', 'Cámara para realizar gabraciones en 360º. Incluye caja e instrucciones.', 'Aula tic', 'assets/images/mi-360-camera-1080p!800x800!85.png'),
(7, 'Estantería de portátiles (A)', 'Estantería con 25 portátiles y sus respectivos cargadores. Se ruega recuerden dejarlos cargando tras su uso.', 'Aula 21', 'assets/images/portatil.png'),
(8, 'Estantería de portátiles (B)', 'Estantería con 25 portátiles y sus respectivos cargadores. Se ruega recuerden dejarlos cargando tras su uso.', 'Biblioteca', 'assets/images/portatil.png'),
(9, 'Proyector Neopix', 'Proyector para presentaciones con cable preparado para la pantalla de televisión grande.', 'Aula AtecA', 'assets/images/proyector.jfif'),
(10, 'Proyector LG 1', 'Proyector para aulas o pistas.', 'Almacén sótano', 'assets/images/proyector2.jfif'),
(11, 'Proyector LG 2', 'Proyector para aulas o pistas.', 'Almacén sótano', 'assets/images/proyector2.jfif'),
(12, 'Proyector LG 3', 'Proyector para aulas o pistas.', 'Almacén sótano', 'assets/images/proyector2.jfif'),
(13, 'Colchonetas y material diverso', 'Material para gimnasia', 'Almacén patio.', 'assets/images/colchonetas.jpg'),
(14, 'Dron', 'Dron y control. Para quien no sepa usarlo, contactar primero con Félix para evitar daños. Recordar devolverlo cargado.', 'Despacho informática', 'assets/images/dron.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Timeslots`
--

CREATE TABLE `Timeslots` (
  `id` int(10) UNSIGNED NOT NULL,
  `dayOfWeek` varchar(100) NOT NULL,
  `startTime` varchar(10) NOT NULL,
  `endTime` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `Timeslots`
--

INSERT INTO `Timeslots` (`id`, `dayOfWeek`, `startTime`, `endTime`) VALUES
(1, 'monday', '08:05', '09:05'),
(2, 'monday', '09:05', '10:05'),
(3, 'monday', '10:05', '11:05'),
(5, 'monday', '11:35', '12:35'),
(6, 'monday', '12:35', '13:35'),
(7, 'monday', '13:35', '14:35'),
(8, 'tuesday', '08:05', '09:05'),
(9, 'tuesday', '09:05', '10:05'),
(10, 'tuesday', '10:05', '11:05'),
(12, 'tuesday', '11:35', '12:35'),
(13, 'tuesday', '12:35', '13:35'),
(14, 'tuesday', '13:35', '14:35'),
(15, 'wednesday', '08:05', '09:05'),
(16, 'wednesday', '09:05', '10:05'),
(17, 'wednesday', '10:05', '11:05'),
(19, 'wednesday', '11:35', '12:35'),
(20, 'wednesday', '12:35', '13:35'),
(21, 'wednesday', '13:35', '14:35'),
(22, 'thursday', '08:05', '09:05'),
(23, 'thursday', '09:05', '10:05'),
(24, 'thursday', '10:05', '11:05'),
(26, 'thursday', '11:35', '12:35'),
(27, 'thursday', '12:35', '13:35'),
(28, 'thursday', '13:35', '14:35'),
(29, 'friday', '08:05', '09:05'),
(30, 'friday', '09:05', '10:05'),
(31, 'friday', '10:05', '11:05'),
(33, 'friday', '11:35', '12:35'),
(34, 'friday', '12:35', '13:35'),
(35, 'friday', '13:35', '14:35');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Users`
--

CREATE TABLE `Users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(500) NOT NULL,
  `realname` varchar(100) NOT NULL,
  `type` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `Users`
--

INSERT INTO `Users` (`id`, `username`, `password`, `realname`, `type`) VALUES
(2, 'adminJJ', '81dc9bdb52d04dc20036dbd8313ed055', 'Jose Juan', 'admin'),
(26, 'jodamaru', 'jodamaru', 'Jose David', 'user'),
(27, 'adminAl', '81dc9bdb52d04dc20036dbd8313ed055', 'Alfredo', 'admin'),
(29, 'feljs', 'feljs', 'Félix', 'user'),
(34, 'turbomanolo', '39c63ddb96a31b9610cd976b896ad4f0', 'Manolo', 'user');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Reservations`
--
ALTER TABLE `Reservations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `Resources`
--
ALTER TABLE `Resources`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `Timeslots`
--
ALTER TABLE `Timeslots`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `Reservations`
--
ALTER TABLE `Reservations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT de la tabla `Resources`
--
ALTER TABLE `Resources`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `Timeslots`
--
ALTER TABLE `Timeslots`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `Users`
--
ALTER TABLE `Users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
