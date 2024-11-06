-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-11-2024 a las 02:00:19
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
-- Base de datos: `weshop`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `almacen`
--

CREATE TABLE `almacen` (
  `id_almacen` int(11) NOT NULL COMMENT 'Identificador de almacén',
  `telefono_almacen` varchar(50) DEFAULT NULL COMMENT 'Número de teléfono del almacén',
  `region_almacen` varchar(255) DEFAULT NULL COMMENT 'Lugar donde se ubica ese almacén'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `id_carrito` int(11) NOT NULL COMMENT 'Identificador de cada carrito ',
  `fecha_peticion` timestamp NULL DEFAULT current_timestamp() COMMENT 'Almacena la feche de petición',
  `envio` varchar(250) NOT NULL COMMENT 'Almacena el envió de ese carrito',
  `id_usu` int(11) DEFAULT NULL COMMENT 'Clave foránea de usuario',
  `estado` enum('empaquetando','en_camino','entregado','empaquetando_devolucion','enviado_devolucion','entregado_devolucion') NOT NULL DEFAULT 'empaquetando' COMMENT 'Almacena el Estado de envio de los productos del carrito',
  `precio_carrito` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `carrito`
--

INSERT INTO `carrito` (`id_carrito`, `fecha_peticion`, `envio`, `id_usu`, `estado`, `precio_carrito`) VALUES
(1, '2024-10-29 13:53:23', 'cufre 2774', 1, 'empaquetando', 769.95),
(2, '2024-10-29 13:54:15', 'cufre 2774', 1, 'en_camino', 329.97),
(3, '2024-10-29 13:54:50', 'cufre 2774', 1, 'entregado', 219.98),
(4, '2024-10-29 13:55:37', 'cufre 2774', 1, 'empaquetando_devolucion', 219.98),
(5, '2024-10-29 13:57:01', 'cufre 2774', 1, 'enviado_devolucion', 219.98),
(6, '2024-10-29 13:57:46', 'cufre 2774', 1, 'entregado_devolucion', 219.98),
(7, '2024-10-29 16:31:25', 'cufre 2774', 8, 'empaquetando', 1319.93),
(8, '2024-10-29 21:44:55', 'cufre 2774', 1, 'empaquetando', 219.98),
(9, '2024-10-29 21:46:03', 'cufre 2774', 1, 'empaquetando', 219.98),
(10, '2024-10-29 21:46:46', 'cufre 2774', 1, 'empaquetando', 219.98),
(11, '2024-10-30 12:38:26', 'cufre 2774', 1, 'en_camino', 1319.94),
(12, '2024-10-31 10:26:20', 'cufre 2774', 1, 'empaquetando', 259.98),
(13, '2024-11-02 19:08:48', 'Ciudad vieja 97 34', 10, 'empaquetando', 1319.94),
(14, '2024-11-02 19:49:36', 'Ciudad vieja 97 34', 10, 'empaquetando', 129.99);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentario_emp`
--

CREATE TABLE `comentario_emp` (
  `id_comentario_emp` int(11) NOT NULL COMMENT 'Identificador de comentario de proveedor',
  `id_emp` int(11) NOT NULL COMMENT 'Identificador de proveedor',
  `id_producto` int(11) NOT NULL COMMENT 'Identificador de producto',
  `fecha_comentario_emp` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Fecha de comentario de proveedor',
  `contenido_comentario_emp` text NOT NULL COMMENT 'Contenido del comentario de proveedor'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentario_usu`
--

CREATE TABLE `comentario_usu` (
  `id_comentario_usu` int(11) NOT NULL COMMENT 'Identificador de comentario de usuario',
  `id_usu` int(11) NOT NULL COMMENT 'Identificador de usuario',
  `id_producto` int(11) NOT NULL COMMENT 'Identificador de producto',
  `fecha_comentario_usu` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Fecha de comentario de usuario',
  `contenido_comentario_usu` text NOT NULL COMMENT 'Contenido del comentario de usuario'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra_verificada_oficina`
--

CREATE TABLE `compra_verificada_oficina` (
  `id_oficina_envios` int(11) NOT NULL COMMENT 'Identificador de oficina de envió',
  `id_carrito` int(11) DEFAULT NULL COMMENT 'Clave foránea de carrito'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contiene`
--

CREATE TABLE `contiene` (
  `id_contiene` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_carrito` int(11) NOT NULL,
  `precio_contiene` decimal(10,2) NOT NULL,
  `nombre_contiene` varchar(250) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `fecha_contiene` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `contiene`
--

INSERT INTO `contiene` (`id_contiene`, `id_producto`, `id_carrito`, `precio_contiene`, `nombre_contiene`, `id_empresa`, `fecha_contiene`) VALUES
(58, 1, 1, 219.99, '2 Guitarras Ejemplo ', 2, '2024-10-29 13:53:23'),
(59, 1, 1, 219.99, '2 Guitarras Ejemplo ', 2, '2024-10-29 13:53:23'),
(60, 2, 1, 109.99, 'Gato Ejemplo', 2, '2024-10-29 13:53:23'),
(61, 2, 1, 109.99, 'Gato Ejemplo', 2, '2024-10-29 13:53:23'),
(62, 2, 1, 109.99, 'Gato Ejemplo', 2, '2024-10-29 13:53:23'),
(63, 3, 2, 109.99, 'Anillo Ejemplo', 1, '2024-10-29 13:54:15'),
(64, 3, 2, 109.99, 'Anillo Ejemplo', 1, '2024-10-29 13:54:15'),
(65, 2, 2, 109.99, 'Gato Ejemplo', 2, '2024-10-29 13:54:15'),
(66, 3, 3, 109.99, 'Anillo Ejemplo', 1, '2024-10-29 13:54:50'),
(67, 3, 3, 109.99, 'Anillo Ejemplo', 1, '2024-10-29 13:54:50'),
(68, 2, 4, 109.99, 'Gato Ejemplo', 2, '2024-10-29 13:55:37'),
(69, 2, 4, 109.99, 'Gato Ejemplo', 2, '2024-10-29 13:55:37'),
(70, 3, 5, 109.99, 'Anillo Ejemplo', 1, '2024-10-29 13:57:01'),
(71, 3, 5, 109.99, 'Anillo Ejemplo', 1, '2024-10-29 13:57:01'),
(72, 3, 6, 109.99, 'Anillo Ejemplo', 1, '2024-10-29 13:57:46'),
(73, 3, 6, 109.99, 'Anillo Ejemplo', 1, '2024-10-29 13:57:46'),
(74, 2, 7, 109.99, 'Gato Ejemplo', 2, '2024-10-29 16:31:25'),
(75, 2, 7, 109.99, 'Gato Ejemplo', 2, '2024-10-29 16:31:25'),
(76, 1, 7, 219.99, '2 Guitarras Ejemplo ', 2, '2024-10-29 16:31:25'),
(77, 1, 7, 219.99, '2 Guitarras Ejemplo ', 2, '2024-10-29 16:31:25'),
(78, 1, 7, 219.99, '2 Guitarras Ejemplo ', 2, '2024-10-29 16:31:25'),
(79, 1, 7, 219.99, '2 Guitarras Ejemplo ', 2, '2024-10-29 16:31:25'),
(80, 1, 7, 219.99, '2 Guitarras Ejemplo ', 2, '2024-10-29 16:31:25'),
(81, 2, 8, 109.99, 'Gato Ejemplo', 2, '2024-10-29 21:44:55'),
(82, 2, 8, 109.99, 'Gato Ejemplo', 2, '2024-10-29 21:44:55'),
(83, 2, 9, 109.99, 'Gato Ejemplo', 2, '2024-10-29 21:46:03'),
(84, 2, 9, 109.99, 'Gato Ejemplo', 2, '2024-10-29 21:46:03'),
(85, 2, 10, 109.99, 'Gato Ejemplo', 2, '2024-10-29 21:46:46'),
(86, 2, 10, 109.99, 'Gato Ejemplo', 2, '2024-10-29 21:46:46'),
(87, 1, 11, 219.99, '2 Guitarras Ejemplo ', 2, '2024-10-30 12:38:26'),
(88, 1, 11, 219.99, '2 Guitarras Ejemplo ', 2, '2024-10-30 12:38:26'),
(89, 1, 11, 219.99, '2 Guitarras Ejemplo ', 2, '2024-10-30 12:38:26'),
(90, 1, 11, 219.99, '2 Guitarras Ejemplo ', 2, '2024-10-30 12:38:26'),
(91, 1, 11, 219.99, '2 Guitarras Ejemplo ', 2, '2024-10-30 12:38:26'),
(92, 1, 11, 219.99, '2 Guitarras Ejemplo ', 2, '2024-10-30 12:38:26'),
(93, 5, 12, 129.99, 'Termo Ejemplo', 2, '2024-10-31 10:26:20'),
(94, 5, 12, 129.99, 'Termo Ejemplo', 2, '2024-10-31 10:26:20'),
(95, 5, 14, 129.99, 'Termo Ejemplo', 2, '2024-11-02 19:49:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `denuncia`
--

CREATE TABLE `denuncia` (
  `id_denuncia` int(11) NOT NULL COMMENT 'Id de la denuncia.',
  `id_denunciante` int(11) NOT NULL,
  `fecha_denuncia` timestamp NOT NULL DEFAULT current_timestamp(),
  `tipo_denunciante` enum('usuario','proveedor') NOT NULL DEFAULT 'usuario',
  `tipo_denunciado` enum('usuario','proveedor','comentario','producto') NOT NULL DEFAULT 'producto' COMMENT 'Tipo de denunciado.',
  `id_denunciado` int(11) NOT NULL COMMENT 'Id del denunciado.',
  `estado_denuncia` enum('Solucionada','Pendiente','Descartada') NOT NULL DEFAULT 'Pendiente' COMMENT 'El estado actual de la denuncia.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `denuncia`
--

INSERT INTO `denuncia` (`id_denuncia`, `id_denunciante`, `fecha_denuncia`, `tipo_denunciante`, `tipo_denunciado`, `id_denunciado`, `estado_denuncia`) VALUES
(1, 1, '2024-10-24 14:33:23', 'usuario', 'producto', 2, 'Solucionada'),
(2, 3, '2024-10-27 23:21:55', 'usuario', 'producto', 3, 'Pendiente'),
(3, 1, '2024-10-27 23:28:37', 'usuario', 'producto', 1, 'Descartada'),
(4, 1, '2024-10-28 15:20:49', 'usuario', 'producto', 3, 'Pendiente'),
(5, 10, '2024-11-02 19:03:19', 'usuario', 'producto', 7, 'Pendiente'),
(6, 10, '2024-11-02 19:09:41', 'usuario', 'producto', 1, 'Pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `id_empresa` int(11) NOT NULL COMMENT 'Identificador de empresa',
  `nombre_empresa` varchar(255) DEFAULT NULL COMMENT 'Nombre de la empresa',
  `mail_empresa` varchar(255) DEFAULT NULL COMMENT 'Mail de la empresa',
  `ubicacion_fisica` varchar(255) DEFAULT NULL COMMENT 'Ubicación de la empresa',
  `telefono_empresa` varchar(50) DEFAULT NULL COMMENT 'Teléfono de la empresa',
  `contrasena_empresa` text DEFAULT NULL COMMENT 'Contraseña de la empresa',
  `habilitacion_empresa` enum('Habilitado','Deshabilitado') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`id_empresa`, `nombre_empresa`, `mail_empresa`, `ubicacion_fisica`, `telefono_empresa`, `contrasena_empresa`, `habilitacion_empresa`) VALUES
(1, 'ByteWizards', 'empresa.bytewizards.3bg@gmail.com', '3307 Brazo Oriental', '16512', '$2y$10$GUQgEx4e/o2NnVf.60RQeuMcjigYOARqUwdnpNHLpoK.MtHMuGt7G', 'Habilitado'),
(2, 'GonzaloGarcia', 'gonzalo2006.gg@gmail.com', 'cufre 2774', '32511', '$2y$10$eym/23ao2k5yz7MbmeFc7O9YJnBjDsJfkn0w44TvJv3AePe2T8CcK', 'Habilitado'),
(3, 'Juan', 'juaninavilan@gmail.com', '1600 Fake Street', '16415', '$2y$10$HB9YGiOGbSnK4fDpcViT5eaQTHktrzR4vh1Fe0vymzj1ge9B3CoqW', 'Deshabilitado'),
(4, 'Gonza', 'gonzalogg21@outlook.com', 'cufre 2774', '1534', '$2y$10$xLht5spTUcR4OQNjA4tFCuMkzKlAoWLaKfj8NySm3Q1U5qsvBm6my', 'Habilitado'),
(5, 'GonzaloGarcia2', 'gonzalogg21@hotmail.com', 'cufre 2774', '541', '$2y$10$al6gWNUZOOW87MKs6ei9f.pmheO7I/1UN4wOYIIZAobVsTtilMYVO', 'Habilitado'),
(6, 'ALberto', 'alber@gmail.com', 'Ciudad vieja 4065', '7652378', '$2y$10$g6OMCa6BTmaKvutDs/eaX.65SLGyEkGtoy7RwQBHei49cCKdpBnSW', 'Habilitado'),
(7, 'Mundo manga', 'mundo.manga@gmail.com', 'barrios de los judios 13 45', '4392402', '$2y$10$hZoP/dUPPfC5sdj/cmfhCudWgnnklvd2Fbv8GWecBStWB6xx/rLm2', 'Habilitado'),
(8, 'tecnology game', 'tecnoligygames@gmail.com', 'ciudad vieja 55 55', '6743290', '$2y$10$XiXwEmM8QQzQRjPNDg/9nePLslHAHXdRBaiPOmTH2nrg.Zd2ao2Ny', 'Habilitado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa_intenta_unirse_pagina`
--

CREATE TABLE `empresa_intenta_unirse_pagina` (
  `id_registro` int(11) NOT NULL COMMENT 'Identificador de registro',
  `id_empresa` int(11) DEFAULT NULL COMMENT 'Clave foránea de empresa'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `forma_parte_de`
--

CREATE TABLE `forma_parte_de` (
  `id_oferta_de_pagina` int(11) NOT NULL COMMENT 'Identificador de las ofertas de la pagina',
  `id_producto` int(11) NOT NULL COMMENT 'Identificador de producto'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historico`
--

CREATE TABLE `historico` (
  `fecha_hora` datetime NOT NULL COMMENT 'Identificador de la fecha y hora del historial',
  `id_usu` int(11) NOT NULL COMMENT 'Identificador de usuarios y histórico, además clave foránea de usuario'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historico_empresa`
--

CREATE TABLE `historico_empresa` (
  `id_historico` int(11) NOT NULL,
  `id_empresa_historico` int(11) NOT NULL,
  `id_contiene_historico` int(11) NOT NULL,
  `fecha_historico_empresa` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ident_comentario`
--

CREATE TABLE `ident_comentario` (
  `id_comentario` int(11) NOT NULL COMMENT 'Identificador de comentario',
  `fecha` date DEFAULT NULL COMMENT 'Fecha de comentarios'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `intenta_comprar`
--

CREATE TABLE `intenta_comprar` (
  `id_carrito` int(11) NOT NULL COMMENT 'Identificador de carrito',
  `id_usu` int(11) DEFAULT NULL COMMENT 'Clave foránea de usuario'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ofertas_internas_producto`
--

CREATE TABLE `ofertas_internas_producto` (
  `id_ofertas_internas` int(11) NOT NULL COMMENT 'Identificador de oferta internas',
  `nombre_oferta` varchar(255) DEFAULT NULL COMMENT 'Nombre de la oferta',
  `id_producto` int(11) DEFAULT NULL COMMENT 'Identificador de producto'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oferta_de_pagina`
--

CREATE TABLE `oferta_de_pagina` (
  `id_oferta_de_pagina` int(11) NOT NULL COMMENT 'Identificador de oferta de la pagina',
  `fecha_inicio` date DEFAULT NULL COMMENT 'Almacena la fecha de inicio de esa oferta',
  `fecha_final` date DEFAULT NULL COMMENT 'Almacena la fecha de finalización de la oferta',
  `descuentos` decimal(10,2) DEFAULT NULL COMMENT 'Almacena el descuento'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oficina_envios`
--

CREATE TABLE `oficina_envios` (
  `id_oficina_envios` int(11) NOT NULL COMMENT 'Identificador de la oficina de envió ',
  `costo_envio_agregado` decimal(10,2) DEFAULT NULL COMMENT 'Almacena el costo de envió agregado de los vehículos '
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id_producto` int(11) NOT NULL COMMENT 'Identificador de producto',
  `stock` int(11) DEFAULT NULL COMMENT 'Almacena la cantidad de stock de productos que hay',
  `imagen` text DEFAULT NULL COMMENT 'Almacena la URL del producto',
  `precio` decimal(10,2) DEFAULT NULL COMMENT 'Almacena el precio del producto',
  `titulo` varchar(255) DEFAULT NULL COMMENT 'Almacena el titulo del producto',
  `ventas_totales` int(11) DEFAULT NULL COMMENT 'Almacena las ventas totales de productos',
  `ventas_mes` int(11) DEFAULT NULL COMMENT 'Almacena las ventas totales por mes de producto',
  `precio_base` decimal(10,2) DEFAULT NULL COMMENT 'Almacena el precio base',
  `descripcion` text DEFAULT NULL COMMENT 'Almacena la descripción del producto',
  `condicion` enum('Primera Mano','Segunda Mano') NOT NULL COMMENT 'Almacena la condición de un producto',
  `id_empresa_producto` int(11) DEFAULT NULL COMMENT 'Clave foránea de empresa',
  `habilitacion_producto` enum('Habilitado','Deshabilitado') NOT NULL COMMENT 'Almacena la habilitación de un producto',
  `categoria` enum('tecnologia','joyeria','ropa','animales','juegos','otros') NOT NULL COMMENT 'Almacena la categoría de un producto'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_producto`, `stock`, `imagen`, `precio`, `titulo`, `ventas_totales`, `ventas_mes`, `precio_base`, `descripcion`, `condicion`, `id_empresa_producto`, `habilitacion_producto`, `categoria`) VALUES
(1, 6, '../api/assets/1.png', NULL, '2 Guitarras Ejemplo ', NULL, NULL, 219.99, 'Bonitas guitarras. \n\nDisfruten el ejemplo.', 'Segunda Mano', 2, 'Habilitado', 'tecnologia'),
(2, 15, '../api/assets/2.png', NULL, 'Gato Ejemplo', NULL, NULL, 109.99, 'Bonito gato. \n\nEs de ejemplo, no es real.', 'Segunda Mano', 2, 'Deshabilitado', 'animales'),
(3, 203, '../api/assets/3.png', NULL, 'Anillo Ejemplo', NULL, NULL, 119.99, 'Es un hermosisimo anillo.', 'Primera Mano', 1, 'Habilitado', 'joyeria'),
(4, 0, '../api/assets/4.png', NULL, 'Perro Ejemplo', NULL, NULL, 0.99, 'Bonito perro de ejemplo.', 'Primera Mano', 1, 'Habilitado', 'animales'),
(5, 42, '../api/assets/5.png', NULL, 'Termo Ejemplo', NULL, NULL, 129.99, 'Termo epico de ejemplo. ', 'Primera Mano', 2, 'Habilitado', 'otros'),
(6, 1, '../api/assets/6.png', NULL, 'Lagarto Ejemplo ', NULL, NULL, 19.99, 'Un ejemplo de lagarto.', 'Primera Mano', 3, 'Habilitado', 'animales'),
(7, 3, '../api/assets/7.png', NULL, 'Ejemplo de Camisa', NULL, NULL, 2414.00, 'Una muy bonita camisa.', 'Primera Mano', 4, 'Habilitado', 'ropa'),
(8, 16, '../api/assets/8.png', NULL, 'Manga Chainsaw Man tomo 1', NULL, NULL, 550.00, 'Manga del famoso mangaca Tatsuki Fujimoto,tomo 1', 'Primera Mano', 7, 'Habilitado', 'otros'),
(9, 3, '../api/assets/9.png', NULL, 'My Hero Academia tomo 1', NULL, NULL, 550.00, 'Maga del mangaka Kohei Horikoshi, tomo 1', 'Primera Mano', 7, 'Habilitado', 'otros'),
(10, 10, '../api/assets/10.png', NULL, 'Oshi No Ko tomo 1', NULL, NULL, 540.00, 'Manga Oshi No Ko del mangaka Aka Akasaka, primer tomo', 'Primera Mano', 7, 'Habilitado', 'otros'),
(11, 34, '../api/assets/11.png', NULL, 'Gafas de realidad virtual', NULL, NULL, 3500.00, 'Gafas de realidad virtual para jugar', 'Primera Mano', 8, 'Habilitado', 'tecnologia'),
(12, 21, '../api/assets/12.png', NULL, 'Mando red dragon para pc', NULL, NULL, 900.00, 'mando con dispositivo para poder usarlo en tu pc', 'Primera Mano', 8, 'Habilitado', 'tecnologia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_logueo`
--

CREATE TABLE `registro_logueo` (
  `id_registro` int(11) NOT NULL COMMENT 'Identificador de registro',
  `ip_dispositivo` varchar(50) DEFAULT NULL COMMENT 'Almacena la ip del dispositivo u equipo',
  `pais` varchar(100) DEFAULT NULL COMMENT 'Almacena el país de ese logueo',
  `hora_solicitud` time DEFAULT NULL COMMENT 'Almacena la hora de solicitud de ese logueo',
  `departamento_estado` varchar(100) DEFAULT NULL COMMENT 'Almacena el departamento u estado de donde se hizo ese logueo',
  `tipo_cuenta` varchar(50) DEFAULT NULL COMMENT 'Almacena el tipo de cuenta que se logueo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiene_asignado`
--

CREATE TABLE `tiene_asignado` (
  `id_almacen` int(11) NOT NULL COMMENT 'Identificador de almacén',
  `id_oficina_envios` int(11) NOT NULL COMMENT 'Identificador de la oficina de envíos'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiene_un_usuario`
--

CREATE TABLE `tiene_un_usuario` (
  `id_usu` int(11) NOT NULL COMMENT 'Identificador de usuario',
  `fecha_hora` datetime DEFAULT NULL COMMENT 'clave foránea de fecha y hora'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usu` int(11) NOT NULL COMMENT 'Identificador de usuario',
  `nombre_usu` varchar(255) DEFAULT NULL COMMENT 'Almacena el nombre de usuario',
  `contrasena_usu` text DEFAULT NULL COMMENT 'Almacena la contraseña de usuario',
  `mail_usu` varchar(255) DEFAULT NULL COMMENT 'Almacena el mail de usuario',
  `domicilio_usu` varchar(255) DEFAULT NULL COMMENT 'Almacena el domicilio de usuario',
  `direccion_usu` varchar(255) DEFAULT NULL COMMENT 'Almacena la dirección de usuario',
  `telefono_usu` varchar(20) NOT NULL COMMENT 'Almacena el teléfono de usuario',
  `habilitacion_usu` enum('Habilitado','Deshabilitado') NOT NULL COMMENT 'Almacena la habilitación de usuario'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usu`, `nombre_usu`, `contrasena_usu`, `mail_usu`, `domicilio_usu`, `direccion_usu`, `telefono_usu`, `habilitacion_usu`) VALUES
(1, 'GonzaloGarcia', '$2y$10$mwCrKbC2M3ucSAuxYYgc.Od1tV53L85kp/lseUM/aqmiZBXqfC3OK', 'gonzalo2006.gg@gmail.com', NULL, 'cufre 2774', '513', 'Habilitado'),
(2, 'GonzaloGarcia2', '$2y$10$a40jPPA1zUS5IcTuETqTjuO05.mCuffiAHHwNHXwWAAjlM2J8IFpq', 'gonzalogg21@outlook.com', NULL, 'cufre 2774', '152', 'Deshabilitado'),
(3, 'ByteWizards', '$2y$10$4wXTUNdixjTlUbhfU0yltepaX55NT3pG.Iom75okbXL2Cgur3Ow1e', 'empresa.bytewizards.3bg@gmail.com', NULL, '3307 Brazo Oriental', '51215', 'Habilitado'),
(7, 'silvana gonzalez', '$2y$10$rsBvZlYP5suPhA.htmt2LOV5o/11iFjwvKWV2BncGY2hVbyt2DQqW', 'oriente@adinet.com.uy', NULL, 'cufre 2774', '094109919', 'Habilitado'),
(8, 'Gonza', '$2y$10$kUxW8NNkQ/lEGl9jQxENE.ObqeOzCQdcsE9hRyf6ZfUtA2PgRVTE6', 'gonzalogg21@hotmail.com', NULL, 'cufre 2774', '1524', 'Deshabilitado'),
(9, 'GonzaloGarcia3', '$2y$10$C70/1InuxddBupyANKmdTukXmVJvc6Gw9AADo.9Pjyau90fKH9jtC', 'gonzalogg2@hotmail.com', NULL, 'cufre 2774', '12512', 'Deshabilitado'),
(10, 'Peponcio', '$2y$10$LYiCK8ihqKuLIDp7pAADj.psVRSwH7Pq3mHIv0ctHJh1DikVG2OU6', 'soyelgran.peponcio@gmail.com', NULL, 'Ciudad vieja 97 34', '690777', 'Habilitado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_intenta_unirse_pagina`
--

CREATE TABLE `usuario_intenta_unirse_pagina` (
  `id_registro` int(11) NOT NULL COMMENT 'Identificador de registro',
  `id_usu` int(11) DEFAULT NULL COMMENT 'Clave foránea de usuario'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculo_sustentable`
--

CREATE TABLE `vehiculo_sustentable` (
  `id_oficina_envios` int(11) NOT NULL COMMENT 'Identificador de oficina de envíos',
  `porcentaje_huella_carbono` decimal(10,2) DEFAULT NULL COMMENT 'Almacena el porcentaje de huella de carbono'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculo_termico`
--

CREATE TABLE `vehiculo_termico` (
  `id_oficina_envios` int(11) NOT NULL COMMENT 'Identificador de la oficina de envíos'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vende`
--

CREATE TABLE `vende` (
  `id_producto` int(11) NOT NULL COMMENT 'Identificador de producto',
  `id_empresa` int(11) DEFAULT NULL COMMENT 'Clave foránea de empresa'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `almacen`
--
ALTER TABLE `almacen`
  ADD PRIMARY KEY (`id_almacen`);

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`id_carrito`),
  ADD KEY `id_usu` (`id_usu`);

--
-- Indices de la tabla `comentario_emp`
--
ALTER TABLE `comentario_emp`
  ADD PRIMARY KEY (`id_comentario_emp`);

--
-- Indices de la tabla `comentario_usu`
--
ALTER TABLE `comentario_usu`
  ADD PRIMARY KEY (`id_comentario_usu`);

--
-- Indices de la tabla `compra_verificada_oficina`
--
ALTER TABLE `compra_verificada_oficina`
  ADD PRIMARY KEY (`id_oficina_envios`),
  ADD KEY `id_carrito` (`id_carrito`);

--
-- Indices de la tabla `contiene`
--
ALTER TABLE `contiene`
  ADD PRIMARY KEY (`id_contiene`);

--
-- Indices de la tabla `denuncia`
--
ALTER TABLE `denuncia`
  ADD PRIMARY KEY (`id_denuncia`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`id_empresa`);

--
-- Indices de la tabla `empresa_intenta_unirse_pagina`
--
ALTER TABLE `empresa_intenta_unirse_pagina`
  ADD PRIMARY KEY (`id_registro`),
  ADD KEY `id_empresa` (`id_empresa`);

--
-- Indices de la tabla `forma_parte_de`
--
ALTER TABLE `forma_parte_de`
  ADD PRIMARY KEY (`id_oferta_de_pagina`,`id_producto`);

--
-- Indices de la tabla `historico`
--
ALTER TABLE `historico`
  ADD PRIMARY KEY (`fecha_hora`,`id_usu`),
  ADD KEY `id_usu` (`id_usu`);

--
-- Indices de la tabla `historico_empresa`
--
ALTER TABLE `historico_empresa`
  ADD PRIMARY KEY (`id_historico`);

--
-- Indices de la tabla `ident_comentario`
--
ALTER TABLE `ident_comentario`
  ADD PRIMARY KEY (`id_comentario`);

--
-- Indices de la tabla `intenta_comprar`
--
ALTER TABLE `intenta_comprar`
  ADD PRIMARY KEY (`id_carrito`),
  ADD KEY `id_usu` (`id_usu`);

--
-- Indices de la tabla `ofertas_internas_producto`
--
ALTER TABLE `ofertas_internas_producto`
  ADD PRIMARY KEY (`id_ofertas_internas`);

--
-- Indices de la tabla `oferta_de_pagina`
--
ALTER TABLE `oferta_de_pagina`
  ADD PRIMARY KEY (`id_oferta_de_pagina`);

--
-- Indices de la tabla `oficina_envios`
--
ALTER TABLE `oficina_envios`
  ADD PRIMARY KEY (`id_oficina_envios`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `id_empresa` (`id_empresa_producto`);

--
-- Indices de la tabla `registro_logueo`
--
ALTER TABLE `registro_logueo`
  ADD PRIMARY KEY (`id_registro`);

--
-- Indices de la tabla `tiene_asignado`
--
ALTER TABLE `tiene_asignado`
  ADD PRIMARY KEY (`id_almacen`,`id_oficina_envios`);

--
-- Indices de la tabla `tiene_un_usuario`
--
ALTER TABLE `tiene_un_usuario`
  ADD PRIMARY KEY (`id_usu`),
  ADD KEY `fecha_hora` (`fecha_hora`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usu`);

--
-- Indices de la tabla `usuario_intenta_unirse_pagina`
--
ALTER TABLE `usuario_intenta_unirse_pagina`
  ADD PRIMARY KEY (`id_registro`),
  ADD KEY `id_usu` (`id_usu`);

--
-- Indices de la tabla `vehiculo_sustentable`
--
ALTER TABLE `vehiculo_sustentable`
  ADD PRIMARY KEY (`id_oficina_envios`);

--
-- Indices de la tabla `vehiculo_termico`
--
ALTER TABLE `vehiculo_termico`
  ADD PRIMARY KEY (`id_oficina_envios`);

--
-- Indices de la tabla `vende`
--
ALTER TABLE `vende`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `id_empresa` (`id_empresa`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comentario_emp`
--
ALTER TABLE `comentario_emp`
  MODIFY `id_comentario_emp` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador de comentario de proveedor';

--
-- AUTO_INCREMENT de la tabla `comentario_usu`
--
ALTER TABLE `comentario_usu`
  MODIFY `id_comentario_usu` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador de comentario de usuario';

--
-- AUTO_INCREMENT de la tabla `contiene`
--
ALTER TABLE `contiene`
  MODIFY `id_contiene` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT de la tabla `historico_empresa`
--
ALTER TABLE `historico_empresa`
  MODIFY `id_historico` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `carrito_ibfk_1` FOREIGN KEY (`id_usu`) REFERENCES `usuario` (`id_usu`);

--
-- Filtros para la tabla `compra_verificada_oficina`
--
ALTER TABLE `compra_verificada_oficina`
  ADD CONSTRAINT `compra_verificada_oficina_ibfk_1` FOREIGN KEY (`id_carrito`) REFERENCES `carrito` (`id_carrito`);

--
-- Filtros para la tabla `empresa_intenta_unirse_pagina`
--
ALTER TABLE `empresa_intenta_unirse_pagina`
  ADD CONSTRAINT `empresa_intenta_unirse_pagina_ibfk_1` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`);

--
-- Filtros para la tabla `historico`
--
ALTER TABLE `historico`
  ADD CONSTRAINT `historico_ibfk_1` FOREIGN KEY (`id_usu`) REFERENCES `usuario` (`id_usu`) ON DELETE CASCADE;

--
-- Filtros para la tabla `intenta_comprar`
--
ALTER TABLE `intenta_comprar`
  ADD CONSTRAINT `intenta_comprar_ibfk_1` FOREIGN KEY (`id_usu`) REFERENCES `usuario` (`id_usu`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`id_empresa_producto`) REFERENCES `empresa` (`id_empresa`);

--
-- Filtros para la tabla `tiene_un_usuario`
--
ALTER TABLE `tiene_un_usuario`
  ADD CONSTRAINT `tiene_un_usuario_ibfk_1` FOREIGN KEY (`fecha_hora`) REFERENCES `historico` (`fecha_hora`);

--
-- Filtros para la tabla `usuario_intenta_unirse_pagina`
--
ALTER TABLE `usuario_intenta_unirse_pagina`
  ADD CONSTRAINT `usuario_intenta_unirse_pagina_ibfk_1` FOREIGN KEY (`id_usu`) REFERENCES `usuario` (`id_usu`);

--
-- Filtros para la tabla `vende`
--
ALTER TABLE `vende`
  ADD CONSTRAINT `vende_ibfk_1` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
