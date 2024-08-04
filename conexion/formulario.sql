
-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS formulario 
    DEFAULT CHARACTER SET utf8 
    DEFAULT COLLATE utf8_general_ci;

-- Seleccionar la base de datos
USE formulario;

--
-- Base de datos: `formulario`
--
CREATE DATABASE IF NOT EXISTS `formulario` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `formulario`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acciones`
--
CREATE TABLE `acciones` (
    `id_accion` INT AUTO_INCREMENT PRIMARY KEY,
    `id_administrador` INT NOT NULL,
    `nombres` VARCHAR(255) NOT NULL,
    `apellidos` VARCHAR(255) NOT NULL,
    `DNI` VARCHAR(20) NOT NULL,
    `tipo_accion` ENUM('Eliminar', 'Editar', 'Agregar') NOT NULL,
    `descripcion` TEXT NOT NULL,
    `fecha` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`id_administrador`) REFERENCES `usuarios`(`id_usuarios`)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciudades`
--
CREATE TABLE `ciudades` (
    `id_ciudades` INT(11) NOT NULL,
    `id_departamentos` INT(11) NOT NULL,
    `ciudades` VARCHAR(450) DEFAULT NULL,
    PRIMARY KEY (`id_ciudades`),
    FOREIGN KEY (`id_departamentos`) REFERENCES `departamentos`(`id_departamentos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos`
--
CREATE TABLE `departamentos` (
    `id_departamentos` INT(11) NOT NULL,
    `departamentos` VARCHAR(450) DEFAULT NULL,
    PRIMARY KEY (`id_departamentos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos`
--
CREATE TABLE `documentos` (
    `id_documentos` INT(11) NOT NULL,
    `placa` VARCHAR(20) NOT NULL,
    `marca` VARCHAR(50) NOT NULL,
    `modelo` VARCHAR(50) NOT NULL,
    `color` VARCHAR(50) NOT NULL,
    `licencia_de_conducir` VARCHAR(255) DEFAULT NULL,
    `tarjeta_de_propiedad` VARCHAR(255) DEFAULT NULL,
    `soat` VARCHAR(255) DEFAULT NULL,
    `tecno_mecanica` VARCHAR(255) DEFAULT NULL,
    `id_usuarios` INT(11) NOT NULL,
    PRIMARY KEY (`id_documentos`),
    FOREIGN KEY (`id_usuarios`) REFERENCES `usuarios`(`id_usuarios`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes_temporales`
--
CREATE TABLE `mensajes_temporales` (
    `id` INT(11) NOT NULL,
    `id_usuario` INT(11) NOT NULL,
    `id_solicitud` INT(11) NOT NULL,
    `mensaje` TEXT NOT NULL,
    `fecha` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    `leido` VARCHAR(50) NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`id_usuario`) REFERENCES `usuarios`(`id_usuarios`),
    FOREIGN KEY (`id_solicitud`) REFERENCES `solicitudes`(`id_solicitud`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `retenciones`
--
CREATE TABLE `retenciones` (
    `id` INT(11) NOT NULL,
    `id_usuarios` INT(11) NOT NULL,
    `monto` DECIMAL(10,2) NOT NULL,
    `retencion` VARCHAR(50) NOT NULL,
    `fecha` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    `pagado` TINYINT(1) NOT NULL,
    `id_solicitud` INT(11) NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`id_usuarios`) REFERENCES `usuarios`(`id_usuarios`),
    FOREIGN KEY (`id_solicitud`) REFERENCES `solicitudes`(`id_solicitud`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--
CREATE TABLE `roles` (
    `id` INT(11) NOT NULL,
    `roles` VARCHAR(50) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes`
--
CREATE TABLE `solicitudes` (
    `id_solicitud` INT(11) NOT NULL,
    `origen` VARCHAR(255) NOT NULL,
    `destino` VARCHAR(255) NOT NULL,
    `cantidad_personas` INT(11) NOT NULL,
    `cantidad_motos` INT(11) NOT NULL,
    `metodo_pago` ENUM('efectivo','nequi') NOT NULL,
    `estado` ENUM('pendiente','aceptada','completada','cancelada') NOT NULL,
    `id_usuarios` INT(11) NOT NULL,
    `costo_total` DECIMAL(10,2) NOT NULL,
    `retencion_total` DECIMAL(10,2) NOT NULL,
    `pago_completo` TINYINT(1) NOT NULL,
    PRIMARY KEY (`id_solicitud`),
    FOREIGN KEY (`id_usuarios`) REFERENCES `usuarios`(`id_usuarios`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--
CREATE TABLE `usuarios` (
    `id_usuarios` INT(11) NOT NULL,
    `Nombres` VARCHAR(50) NOT NULL,
    `Apellidos` VARCHAR(50) NOT NULL,
    `DNI` VARCHAR(50) NOT NULL,
    `fecha_de_nacimiento` DATE NOT NULL,
    `telefono` VARCHAR(50) NOT NULL,
    `Departamento` VARCHAR(250) NOT NULL,
    `Ciudad` VARCHAR(250) NOT NULL,
    `Direccion` VARCHAR(250) NOT NULL,
    `Usuario` VARCHAR(50) NOT NULL,
    `Password` VARCHAR(50) NOT NULL,
    `Estado` VARCHAR(50) NOT NULL,
    `rol` INT(11) NOT NULL,
    PRIMARY KEY (`id_usuarios`),
    FOREIGN KEY (`rol`) REFERENCES `roles`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;