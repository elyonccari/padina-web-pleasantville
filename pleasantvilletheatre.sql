-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-08-2024 a las 07:23:15
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `pleasantvilletheatre`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actor`
--

CREATE TABLE `actor` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `correo_electronico` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `actor`
--

INSERT INTO `actor` (`id`, `nombre`, `direccion`, `telefono`, `correo_electronico`) VALUES
(1, 'Pedro Sánchez', '222 Calle Norte', '555-2345', 'pedro@example.com'),
(2, 'Laura Fernández', '333 Avenida Este', '555-6789', 'laura@example.com'),
(3, 'Miguel Torres', '444 Bulevar Oeste', '555-9876', 'miguel@example.com'),
(4, 'Lucía Díaz', '555 Ruta Central', '555-4567', 'lucia@example.com'),
(5, 'Jorge García', '666 Camino Sur', '555-7891', 'jorge@example.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `informeprograma`
--

CREATE TABLE `informeprograma` (
  `id` int(11) NOT NULL,
  `produccion_id` int(11) DEFAULT NULL,
  `detalles` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `informeprograma`
--

INSERT INTO `informeprograma` (`id`, `produccion_id`, `detalles`) VALUES
(1, 1, 'Hamlet: Producción realizada en otoño 2023 con éxito.'),
(2, 2, 'La Casa de Bernarda Alba: Producción planeada para primavera 2024.'),
(3, 3, 'El Médico a Palos: Producción planeada para otoño 2024.'),
(4, 4, 'El Fantasma de la Ópera: Producción planeada para primavera 2025.'),
(5, 5, 'Romeo y Julieta: Producción planeada para otoño 2025.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logventaboletos`
--

CREATE TABLE `logventaboletos` (
  `id` int(11) NOT NULL,
  `venta_id` int(11) DEFAULT NULL,
  `produccion_id` int(11) DEFAULT NULL,
  `patrono_id` int(11) DEFAULT NULL,
  `fila` char(1) DEFAULT NULL,
  `asiento` int(11) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `miembro`
--

CREATE TABLE `miembro` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `correo_electronico` varchar(100) DEFAULT NULL,
  `cuota_pagada` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `miembro`
--

INSERT INTO `miembro` (`id`, `nombre`, `direccion`, `telefono`, `correo_electronico`, `cuota_pagada`) VALUES
(1, 'Juan Pérez', '123 Calle Falsa', '555-1234', 'juan@example.com', 1),
(2, 'María Gómez', '456 Avenida Siempreviva', '555-5678', 'maria@example.com', 1),
(3, 'Carlos Ruiz', '789 Bulevar Principal', '555-8765', 'carlos@example.com', 0),
(4, 'Ana López', '1010 Ruta Secundaria', '555-3456', 'ana@example.com', 1),
(5, 'Luis Martínez', '1111 Camino Real', '555-7890', 'luis@example.com', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `patrono`
--

CREATE TABLE `patrono` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `correo_electronico` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `patrono`
--

INSERT INTO `patrono` (`id`, `nombre`, `direccion`, `telefono`, `correo_electronico`) VALUES
(1, 'Javier Mendez', '777 Calle Oeste', '555-6543', 'javier@example.com'),
(2, 'Elena Castro', '888 Avenida Norte', '555-3212', 'elena@example.com'),
(3, 'Fernando Rivera', '999 Bulevar Este', '555-0987', 'fernando@example.com'),
(4, 'Isabel Mora', '1011 Ruta Sur', '555-4568', 'isabel@example.com'),
(5, 'Ricardo Ortiz', '1112 Camino Central', '555-7892', 'ricardo@example.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producción`
--

CREATE TABLE `producción` (
  `id` int(11) NOT NULL,
  `titulo` varchar(100) DEFAULT NULL,
  `autor` varchar(100) DEFAULT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `numero_actos` int(11) DEFAULT NULL,
  `temporada` enum('otoño','primavera') DEFAULT NULL,
  `año` int(11) DEFAULT NULL,
  `productor_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producción`
--

INSERT INTO `producción` (`id`, `titulo`, `autor`, `tipo`, `numero_actos`, `temporada`, `año`, `productor_id`) VALUES
(1, 'Hamlet', 'William Shakespeare', 'Drama', 5, 'otoño', 2023, 1),
(2, 'La Casa de Bernarda Alba', 'Federico García Lorca', 'Drama', 3, 'primavera', 2024, 2),
(3, 'El Médico a Palos', 'Molière', 'Comedia', 2, 'otoño', 2024, 3),
(4, 'El Fantasma de la Ópera', 'Gaston Leroux', 'Musical', 2, 'primavera', 2025, 4),
(5, 'Romeo y Julieta', 'William Shakespeare', 'Drama', 5, 'otoño', 2025, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producciónactor`
--

CREATE TABLE `producciónactor` (
  `id` int(11) NOT NULL,
  `produccion_id` int(11) DEFAULT NULL,
  `actor_id` int(11) DEFAULT NULL,
  `papel` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producciónactor`
--

INSERT INTO `producciónactor` (`id`, `produccion_id`, `actor_id`, `papel`) VALUES
(1, 1, 1, 'Hamlet'),
(2, 1, 2, 'Ofelia'),
(3, 2, 3, 'Bernarda Alba'),
(4, 3, 4, 'Sganarelle'),
(5, 4, 5, 'Erik');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producciónpatrono`
--

CREATE TABLE `producciónpatrono` (
  `id` int(11) NOT NULL,
  `produccion_id` int(11) DEFAULT NULL,
  `patrono_id` int(11) DEFAULT NULL,
  `monto_donado` decimal(10,2) DEFAULT NULL,
  `tipo_donación` enum('dinero','bienes','servicios') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producciónpatrono`
--

INSERT INTO `producciónpatrono` (`id`, `produccion_id`, `patrono_id`, `monto_donado`, `tipo_donación`) VALUES
(1, 1, 1, 500.00, 'dinero'),
(2, 2, 2, 1000.00, 'bienes'),
(3, 3, 3, 200.00, 'servicios'),
(4, 4, 4, 1500.00, 'dinero'),
(5, 5, 5, 300.00, 'bienes');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reportefinanciero`
--

CREATE TABLE `reportefinanciero` (
  `id` int(11) NOT NULL,
  `tipo` enum('ingreso','gasto') DEFAULT NULL,
  `monto` decimal(10,2) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reportefinanciero`
--

INSERT INTO `reportefinanciero` (`id`, `tipo`, `monto`, `descripcion`, `fecha`) VALUES
(1, 'ingreso', 500.00, 'Donación de Javier Mendez', '2023-09-01'),
(2, 'gasto', 250.00, 'Compra de vestuario para Hamlet', '2023-09-15'),
(3, 'ingreso', 1000.00, 'Donación de Elena Castro', '2024-03-01'),
(4, 'gasto', 300.00, 'Alquiler de escenario para La Casa de Bernarda Alba', '2024-04-01'),
(5, 'ingreso', 1500.00, 'Donación de Isabel Mora', '2025-01-15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `suscriptor`
--

CREATE TABLE `suscriptor` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `correo_electronico` varchar(100) DEFAULT NULL,
  `cuota_pagada` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `suscriptor`
--

INSERT INTO `suscriptor` (`id`, `nombre`, `direccion`, `telefono`, `correo_electronico`, `cuota_pagada`) VALUES
(1, 'Andrés Gil', '1213 Calle Luna', '555-9875', 'andres@example.com', 1),
(2, 'Marina Rojas', '1415 Avenida Sol', '555-4321', 'marina@example.com', 1),
(3, 'Tomas Vázquez', '1617 Bulevar Tierra', '555-7654', 'tomas@example.com', 0),
(4, 'Rosa Jiménez', '1819 Ruta Mar', '555-8765', 'rosa@example.com', 1),
(5, 'Sergio Díaz', '2021 Camino Montaña', '555-5432', 'sergio@example.com', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventaboletos`
--

CREATE TABLE `ventaboletos` (
  `id` int(11) NOT NULL,
  `produccion_id` int(11) DEFAULT NULL,
  `patrono_id` int(11) DEFAULT NULL,
  `fila` char(1) DEFAULT NULL,
  `asiento` int(11) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventaboletos`
--

INSERT INTO `ventaboletos` (`id`, `produccion_id`, `patrono_id`, `fila`, `asiento`, `precio`) VALUES
(1, 1, 1, 'A', 1, 50.00),
(2, 2, 2, 'B', 2, 75.00),
(3, 3, 3, 'C', 3, 100.00),
(4, 4, 4, 'D', 4, 125.00),
(5, 5, 5, 'E', 5, 150.00);

--
-- Disparadores `ventaboletos`
--
DELIMITER $$
CREATE TRIGGER `after_ticket_sale` AFTER INSERT ON `ventaboletos` FOR EACH ROW BEGIN
    -- Insertar el registro en la tabla LogVentaBoletos
    INSERT INTO LogVentaBoletos (venta_id, produccion_id, patrono_id, fila, asiento, precio)
    VALUES (NEW.id, NEW.produccion_id, NEW.patrono_id, NEW.fila, NEW.asiento, NEW.precio);

    -- Actualizar el ReporteFinanciero con el nuevo ingreso
    INSERT INTO ReporteFinanciero (tipo, monto, descripcion, fecha)
    VALUES ('ingreso', NEW.precio, CONCAT('Venta de boleto para producción ID: ', NEW.produccion_id), NOW());
END
$$
DELIMITER ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actor`
--
ALTER TABLE `actor`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `informeprograma`
--
ALTER TABLE `informeprograma`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produccion_id` (`produccion_id`);

--
-- Indices de la tabla `logventaboletos`
--
ALTER TABLE `logventaboletos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `miembro`
--
ALTER TABLE `miembro`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `patrono`
--
ALTER TABLE `patrono`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `producción`
--
ALTER TABLE `producción`
  ADD PRIMARY KEY (`id`),
  ADD KEY `productor_id` (`productor_id`);

--
-- Indices de la tabla `producciónactor`
--
ALTER TABLE `producciónactor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produccion_id` (`produccion_id`),
  ADD KEY `actor_id` (`actor_id`);

--
-- Indices de la tabla `producciónpatrono`
--
ALTER TABLE `producciónpatrono`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produccion_id` (`produccion_id`),
  ADD KEY `patrono_id` (`patrono_id`);

--
-- Indices de la tabla `reportefinanciero`
--
ALTER TABLE `reportefinanciero`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `suscriptor`
--
ALTER TABLE `suscriptor`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ventaboletos`
--
ALTER TABLE `ventaboletos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produccion_id` (`produccion_id`),
  ADD KEY `patrono_id` (`patrono_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actor`
--
ALTER TABLE `actor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `informeprograma`
--
ALTER TABLE `informeprograma`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `logventaboletos`
--
ALTER TABLE `logventaboletos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `miembro`
--
ALTER TABLE `miembro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `patrono`
--
ALTER TABLE `patrono`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `producción`
--
ALTER TABLE `producción`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `producciónactor`
--
ALTER TABLE `producciónactor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `producciónpatrono`
--
ALTER TABLE `producciónpatrono`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `reportefinanciero`
--
ALTER TABLE `reportefinanciero`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `suscriptor`
--
ALTER TABLE `suscriptor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `ventaboletos`
--
ALTER TABLE `ventaboletos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `informeprograma`
--
ALTER TABLE `informeprograma`
  ADD CONSTRAINT `informeprograma_ibfk_1` FOREIGN KEY (`produccion_id`) REFERENCES `producción` (`id`);

--
-- Filtros para la tabla `producción`
--
ALTER TABLE `producción`
  ADD CONSTRAINT `producción_ibfk_1` FOREIGN KEY (`productor_id`) REFERENCES `miembro` (`id`);

--
-- Filtros para la tabla `producciónactor`
--
ALTER TABLE `producciónactor`
  ADD CONSTRAINT `producciónactor_ibfk_1` FOREIGN KEY (`produccion_id`) REFERENCES `producción` (`id`),
  ADD CONSTRAINT `producciónactor_ibfk_2` FOREIGN KEY (`actor_id`) REFERENCES `actor` (`id`);

--
-- Filtros para la tabla `producciónpatrono`
--
ALTER TABLE `producciónpatrono`
  ADD CONSTRAINT `producciónpatrono_ibfk_1` FOREIGN KEY (`produccion_id`) REFERENCES `producción` (`id`),
  ADD CONSTRAINT `producciónpatrono_ibfk_2` FOREIGN KEY (`patrono_id`) REFERENCES `patrono` (`id`);

--
-- Filtros para la tabla `ventaboletos`
--
ALTER TABLE `ventaboletos`
  ADD CONSTRAINT `ventaboletos_ibfk_1` FOREIGN KEY (`produccion_id`) REFERENCES `producción` (`id`),
  ADD CONSTRAINT `ventaboletos_ibfk_2` FOREIGN KEY (`patrono_id`) REFERENCES `patrono` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
