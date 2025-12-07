-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-12-2025 a las 18:36:29
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
-- Base de datos: `luzia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cupon`
--

CREATE TABLE `cupon` (
  `id` int(11) NOT NULL,
  `codigo` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `monto` float NOT NULL,
  `vigencia` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cupon`
--

INSERT INTO `cupon` (`id`, `codigo`, `nombre`, `monto`, `vigencia`) VALUES
(1, 369, 'SinCodigo', 0, '2090-01-11 23:59:59'),
(2, 1232025, 'Shine2025', 15000, '2025-01-11 23:59:59'),
(3, 140225, 'Loversilver', 20000, '2025-02-22 23:59:59'),
(4, 160725, 'Goldtime', 25000, '2025-07-22 23:59:59'),
(5, 210925, 'Yellowflowers', 35000, '2025-09-23 23:59:59'),
(6, 191025, 'Momtime', 30000, '2025-10-22 23:59:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_cupon` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `cantidad` int(11) NOT NULL,
  `estado` enum('pendiente','entregado','en almacen','transporte') NOT NULL,
  `precio` float NOT NULL,
  `montobruto` float NOT NULL,
  `cupon_descuento` float NOT NULL,
  `total` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`id`, `id_usuario`, `id_producto`, `id_cupon`, `fecha`, `cantidad`, `estado`, `precio`, `montobruto`, `cupon_descuento`, `total`) VALUES
(2, 3, 1, 1, '2024-12-28', 1, 'entregado', 43000, 43000, 0, 45000),
(3, 3, 3, 2, '2025-01-02', 1, 'entregado', 45000, 45000, 15000, 30000),
(4, 19, 8, 3, '2025-02-13', 2, 'entregado', 25000, 50000, 20000, 30000),
(5, 27, 4, 1, '2025-02-28', 1, 'entregado', 31000, 31000, 0, 31000),
(6, 1, 3, 1, '2025-02-28', 1, 'entregado', 27000, 27000, 0, 27000),
(7, 19, 10, 4, '2025-07-20', 3, 'entregado', 37000, 111000, 25000, 86000),
(8, 17, 1, 4, '2025-07-20', 2, 'entregado', 53000, 106000, 25000, 81000),
(9, 1, 9, 1, '2025-09-19', 1, 'entregado', 29000, 29000, 0, 29000),
(10, 2, 9, 5, '2025-09-19', 5, 'entregado', 29000, 145000, 35000, 110000),
(11, 26, 4, 6, '2025-10-13', 2, 'transporte', 47000, 94000, 30000, 64000),
(12, 2, 1, 6, '2025-10-13', 2, 'transporte', 53000, 106000, 30000, 76000),
(13, 28, 7, 6, '2025-10-15', 2, 'en almacen', 47000, 94000, 30000, 64000),
(14, 17, 8, 1, '2025-10-15', 1, 'en almacen', 30000, 30000, 0, 30000),
(15, 30, 4, 1, '2025-10-15', 1, 'en almacen', 53000, 53000, 0, 53000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id` int(11) NOT NULL,
  `sku` varchar(8) NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `descripcion` text NOT NULL,
  `categoria` enum('anillos','aros','brazaletes','collares') NOT NULL,
  `precio` float NOT NULL,
  `stock` int(11) NOT NULL,
  `imagen` varchar(200) NOT NULL,
  `destacado` int(11) NOT NULL,
  `estado` enum('activo','pausado','no publicado') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id`, `sku`, `nombre`, `descripcion`, `categoria`, `precio`, `stock`, `imagen`, `destacado`, `estado`) VALUES
(1, 'ANI001', 'Anillo Aurora T6', 'Fabricado con oro de la más alta calidad, su brillo natural y pulido perfecto lo convierten en una pieza versátil que complementa cualquier atuendo, desde el más casual hasta el más formal.\n\nMaterial: Oro 18K\nTalla: 6\nPeso: 5 gramos\nHecho a mano', 'anillos', 53000, 10, 'https://github.com/mlolaserrano/luzia/blob/desarrollo/img/ANI001anillo_piedra_3.png', 0, 'activo'),
(2, 'ANI002', 'Anillo Cromática', 'Elaborado con plata esterlina 925, este anillo combina durabilidad con una elegancia sutil. Su acabado brillante y su diseño minimalista lo hacen ideal para llevarlo solo o apilado con otras piezas, añadiendo un toque de sofisticación discreta a tu estilo diario.\r\n\r\nMaterial: Plata 925\r\nTallas disponibles: 8\r\nPeso: 3.5 gramos\r\nHecho a mano', 'anillos', 40000, 12, 'https://github.com/mlolaserrano/luzia/blob/desarrollo/img/ANI002anillo_piedra_1.png', 0, 'activo'),
(3, 'ANI003', 'Anillo Cloe', 'Una pieza de lujo y distinción, forjada en oro de 18K y diseñada para capturar todas las miradas. Su cuerpo pulido contrasta con un engaste central de alto relieve, creando un efecto de luz y sombra que le confiere una presencia majestuosa. Ideal para momentos especiales o como un sello de elegancia diaria. \r\n\r\nMaterial: Oro 18K\r\nTalla: 8\r\nPeso: 5.8 gramos\r\nHecho a mano', 'anillos', 37000, 10, 'https://github.com/mlolaserrano/luzia/blob/desarrollo/img/ANI003anillo_piedra_4.png', 0, 'activo'),
(4, 'ARO001', 'Aros Aura', 'Diseñados para envolver la luz, los Aros Aura son una declaración de sofisticación minimalista. Su silueta pulida y fluida en oro de 18K los convierte en el complemento perfecto para iluminar tu rostro con un brillo sutil, ideal para un uso diario distinguido.\r\n\r\nMaterial: Oro 18K\r\nPeso: 2.9 gramos\r\nHecho a mano', 'aros', 47000, 10, 'https://github.com/mlolaserrano/luzia/blob/desarrollo/img/ARO001aroscolagantes3.jpg', 1, 'activo'),
(5, 'ARO002', 'Aros Celia', 'Los Aros Celia ofrecen un diseño atemporal y versátil, perfectos para cualquier ocasión. Elaborados en resistente Oro 14K, su estructura robusta y su acabado radiante aseguran una pieza duradera y cómoda. Pensados para convertirse en tus básicos dorados de cabecera.\r\n\r\nMaterial: Oro 14K\r\nPeso: 3.8 gramos\r\nHecho a mano', 'aros', 39000, 10, 'https://github.com/mlolaserrano/luzia/blob/desarrollo/img/ARO002aroscolagantes4.png', 1, 'activo'),
(6, 'ARO003', 'Aros Amaré', 'Los Aros Amaré encarnan la elegancia moderna con un toque de calidez. Con un hermoso laminado de Oro 24K sobre una base de metal noble, obtienen un brillo puro y lujoso. Su forma geométrica destaca sutilmente, realzando cualquier conjunto con una presencia deslumbrante.\r\n\r\nMaterial: Oro 24K Laminado\r\nPeso: 4.1 gramos\r\nHecho a mano', 'aros', 41000, 10, 'https://github.com/mlolaserrano/luzia/blob/desarrollo/img/ARO003aros1.png', 0, 'activo'),
(7, 'COL001', 'Collar Selene', 'Este collar es un tributo a la simplicidad elevada. Elaborado con Plata Esterlina 925, presenta una cadena de eslabones finos y un colgante minimalista que reposa delicadamente sobre la clavícula. Es la pieza ideal para quienes buscan un toque de luz discreto que complemente su estilo diario.\r\n\r\nMaterial: Plata 925\r\nLargo de Cadena: 45 cm\r\nPeso: 6.5 gramos\r\nHecho a mano', 'collares', 47000, 10, 'https://github.com/mlolaserrano/luzia/blob/desarrollo/img/COL001gargantilla.png', 0, 'activo'),
(8, 'COL002', 'Collar Lyra', 'Una joya con carácter. Forjado en brillante Oro 18K, este collar presenta una cadena robusta que sostiene un dije con forma geométrica pulida, diseñado para capturar y refractar la luz. Es una pieza de declaración que añade una sofisticación moderna a cualquier vestuario, desde el casual elegante hasta el de noche.\r\n\r\nMaterial: Oro 18K\r\nLargo de Cadena: 50 cm\r\nPeso: 9.2 gramos\r\nHecho a mano', 'collares', 30000, 10, 'https://github.com/mlolaserrano/luzia/blob/desarrollo/img/COL002collarlargo.png', 0, 'activo'),
(9, 'BRA001', 'Brazalete Iris', 'Un diseño delicado con una resistencia excepcional. Forjado en Oro 14K, este brazalete presenta una banda fina y flexible que se adapta cómodamente a la muñeca. Su acabado pulido refleja una luz sutil, convirtiéndolo en la joya perfecta para complementar un look elegante y cotidiano.\r\n\r\nMaterial: Oro 14K\r\nLargo: 18 cm\r\nPeso: 5.0 gramos\r\nHecho a mano', 'brazaletes', 29000, 10, 'https://github.com/mlolaserrano/luzia/blob/desarrollo/img/BRA001bracelet_fino_2.jpg', 1, 'activo'),
(10, 'BRA002', 'Brazalete Amelia', 'Una pieza atemporal que destila opulencia y estilo clásico. El Brazalete Viena está forjado en Oro 18K y presenta un diseño de eslabones entrelazados más robustos que reflejan la luz con un brillo intenso. Su presencia marcada lo convierte en un accesorio de lujo, ideal para eventos especiales o como pieza central.\r\n\r\nMaterial: Oro 18K\r\nLargo: 17.5 cm\r\nPeso: 11.5 gramos\r\nHecho a mano', 'brazaletes', 37000, 10, 'https://github.com/mlolaserrano/luzia/blob/desarrollo/img/BRA002bracelet_fino_1.jpg', 1, 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `dni` int(11) NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `apellido` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL,
  `telefono` int(11) NOT NULL,
  `clave` varchar(15) NOT NULL,
  `rol` enum('cliente','admin') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `dni`, `nombre`, `apellido`, `email`, `telefono`, `clave`, `rol`) VALUES
(1, 65687204, 'Valentina', 'Lopez', 'valen12@gmail.com', 1147859623, 'Val1234**', 'cliente'),
(2, 95687204, 'Margarita', 'Campos', 'camposmar1@gmail.com', 1125879630, 'Marg4*012', 'cliente'),
(3, 95684209, 'Lucía', 'Sanchez', 'lucisan55@gmail.com', 1174852369, 'Lucia1567*', 'cliente'),
(17, 63258910, 'Carmen', 'Lozada', 'carmelozada@gmail.com', 1589456230, 'carlozada56', 'cliente'),
(19, 63258912, 'Rosa', 'Lozada', 'rosalozada@gmail.com', 1589456230, 'rosaaloz01', 'cliente'),
(20, 95987206, 'María Gabriela', 'Reyes', 'mgrm@gmail.com', 1141590447, 'maga0306**', 'admin'),
(21, 96895412, 'Mariana', 'González', 'marianag@gmail.com', 1189756230, 'MarGOn30', 'admin'),
(22, 56897420, 'Agustina', 'Funes', 'agussfunes@gmail.com', 1163987420, 'agustinaF45', 'admin'),
(23, 65892301, 'Lola', 'Serrano', 'lolaserrano@gmail.com', 1147859620, 'loserran0', 'admin'),
(24, 55896230, 'María Guadalupe', 'Piñeiro', 'guadapine12@gmail.com', 1165789420, 'GuaPi45', 'admin'),
(25, 45165236, 'Milena', 'Lorza', 'milena.hoy@outlook.com', 1155269860, 'milenateayuda01', 'cliente'),
(26, 36259632, 'Pedro', 'Peperoni', 'mamamia@outlook.com', 1179652325, 'pizzamia#01', 'cliente'),
(27, 98753123, 'Rogelio', 'Barto', 'elbarto36@outlook.com', 1179652325, 'bartop1235', 'cliente'),
(28, 95125366, 'Magali', 'Pérez', 'maguisp@outlook.com', 1123196895, 'maguis012', 'cliente'),
(29, 45623175, 'Jaime', 'Pérez', 'jaimelisto@hotmail.com', 1123196895, 'Eljaime@1', 'cliente'),
(30, 45222369, 'Nicolás', 'Ford', 'fordnic@gmail.com', 1123158895, 'Elnico123', 'cliente');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cupon`
--
ALTER TABLE `cupon`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo` (`codigo`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pedido_producto` (`id_producto`),
  ADD KEY `fk_pedido_cliente` (`id_usuario`),
  ADD KEY `fk_pedido_cupon` (`id_cupon`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `un_sku_producto` (`sku`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `un_dni_cliente` (`dni`),
  ADD UNIQUE KEY `un_email_cliente` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cupon`
--
ALTER TABLE `cupon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `fk_pedido_cliente` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `fk_pedido_cupon` FOREIGN KEY (`id_cupon`) REFERENCES `cupon` (`id`),
  ADD CONSTRAINT `fk_pedido_producto` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
