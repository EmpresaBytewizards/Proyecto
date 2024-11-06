-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-11-2024 a las 02:00:33
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
-- Base de datos: `backoffice`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `problemas`
--

CREATE TABLE `problemas` (
  `ID_Problema` int(11) NOT NULL,
  `tipo` varchar(30) DEFAULT NULL,
  `usuario_que_reporta` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_de_logueo_admin`
--

CREATE TABLE `registro_de_logueo_admin` (
  `ID_Logueo` int(11) NOT NULL,
  `IP_Dispositivo` varchar(45) DEFAULT NULL,
  `departamento_o_estado` varchar(100) DEFAULT NULL,
  `hora_de_solicitud` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `país` varchar(100) DEFAULT NULL,
  `ID_Admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_de_modificacion_de_tuflas`
--

CREATE TABLE `registro_de_modificacion_de_tuflas` (
  `ID_Mod` int(11) NOT NULL,
  `tufla_Modificada` varchar(30) DEFAULT NULL,
  `tabla_Modificada` varchar(30) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `modificacion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `se_registra_en`
--

CREATE TABLE `se_registra_en` (
  `ID_Mod` int(11) NOT NULL,
  `ID_Admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solución`
--

CREATE TABLE `solución` (
  `ID_Admin` int(11) NOT NULL,
  `ID_Problema` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `staff`
--

CREATE TABLE `staff` (
  `id_staff` int(11) NOT NULL COMMENT 'Id del STAFF',
  `nombre_staff` varchar(30) DEFAULT NULL COMMENT 'Nombre del STAFF',
  `contrasena_staff` text DEFAULT NULL COMMENT 'Contraseña del STAFF',
  `mail_staff` varchar(250) DEFAULT NULL COMMENT 'Correo del STAFF',
  `telefono_staff` varchar(50) NOT NULL COMMENT 'Telefono del STAFF',
  `ubicacion_staff` varchar(255) NOT NULL COMMENT 'Ubicacion del STAFF',
  `tipo_staff` enum('Root','Admin','Moderador','Organizador','Deshabilitado') DEFAULT NULL COMMENT 'Tipo de STAFF'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `staff`
--

INSERT INTO `staff` (`id_staff`, `nombre_staff`, `contrasena_staff`, `mail_staff`, `telefono_staff`, `ubicacion_staff`, `tipo_staff`) VALUES
(1, 'ByteWizards', '$2y$10$MTeSp8yFZGa9Ub35.mnFcO22.8lrDEingW7qZ03C5KyFk4y7BU/Iy', 'empresa.bytewizards.3bg@gmail.com', '12521', '3307 Brazo Oriental', 'Root'),
(2, 'GonzaloGarcia', '$2y$10$Qg2fv20/.YuECZhKnUFIzOCkykrfNwAVHLnkEycveIJrblY0Us0mm', 'gonzalo2006.gg@gmail.com', '15123', 'cufre 2774', 'Admin'),
(3, 'GonzaloGarcia2', '$2y$10$vh/bxLeHSiQ2PP2UvGINBOonnt4jZyrR3SwWz2yVvpbwKFnn0pKCa', 'gonzalogg21@outlook.com', '15123', 'cufre 2774', 'Moderador'),
(4, 'GonzaloGarcia3', '$2y$10$FfQUrKQkTCf4djOiabVLru5ZlrSgKEaw8C0BnDPppFfdfDujAqvty', 'gonzalogg21@hotmail.com', '15231', 'cufre 2774', 'Organizador'),
(5, 'Gonza', '$2y$10$jOimVThNAQ7xePvdXIkIi.kDV.TQE76TUAzvOY9yJhTQxxJ5qu5b6', 'gonzalo2@gmail.com', '3124134', 'cufre 2774', 'Deshabilitado'),
(6, 'Gonzalo', '$2y$10$iDaecaCSNClmbOrbPlDjkOqZC4FgiBwTKUc1p8FkP/b2jOJwRhByO', 'gonzalogg2@hotmail.com', '21512', 'cufre 2774', 'Admin'),
(7, 'GonzaloGarcia4', '$2y$10$kusA.RCmjMjud5xX.pRGBeRORU6MxmXTMvZ4kpeRD.5UdzVY1DlEm', 'gonzalogg3@outlook.com', '153', 'cufre 2774', 'Organizador'),
(8, 'Gonza5', '$2y$10$VxAjL5V3KJ055O3y..WBQOz6SQS.DrrRG2OD7roI1PPoXZD/lW56W', 'gonzalo2006@gmail.com', '523153', 'cufre 2774', 'Deshabilitado');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `problemas`
--
ALTER TABLE `problemas`
  ADD PRIMARY KEY (`ID_Problema`);

--
-- Indices de la tabla `registro_de_logueo_admin`
--
ALTER TABLE `registro_de_logueo_admin`
  ADD PRIMARY KEY (`ID_Logueo`,`ID_Admin`);

--
-- Indices de la tabla `registro_de_modificacion_de_tuflas`
--
ALTER TABLE `registro_de_modificacion_de_tuflas`
  ADD PRIMARY KEY (`ID_Mod`);

--
-- Indices de la tabla `se_registra_en`
--
ALTER TABLE `se_registra_en`
  ADD PRIMARY KEY (`ID_Mod`,`ID_Admin`),
  ADD KEY `ID_Admin` (`ID_Admin`);

--
-- Indices de la tabla `solución`
--
ALTER TABLE `solución`
  ADD PRIMARY KEY (`ID_Admin`,`ID_Problema`),
  ADD KEY `ID_Problema` (`ID_Problema`);

--
-- Indices de la tabla `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id_staff`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `se_registra_en`
--
ALTER TABLE `se_registra_en`
  ADD CONSTRAINT `se_registra_en_ibfk_1` FOREIGN KEY (`ID_Mod`) REFERENCES `registro_de_modificacion_de_tuflas` (`ID_Mod`),
  ADD CONSTRAINT `se_registra_en_ibfk_2` FOREIGN KEY (`ID_Admin`) REFERENCES `staff` (`id_staff`);

--
-- Filtros para la tabla `solución`
--
ALTER TABLE `solución`
  ADD CONSTRAINT `solución_ibfk_1` FOREIGN KEY (`ID_Admin`) REFERENCES `staff` (`id_staff`),
  ADD CONSTRAINT `solución_ibfk_2` FOREIGN KEY (`ID_Problema`) REFERENCES `problemas` (`ID_Problema`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
