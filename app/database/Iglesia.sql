-- phpMyAdmin SQL Dump
-- version 4.3.2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 19-12-2014 a las 07:18:17
-- Versión del servidor: 5.6.20
-- Versión de PHP: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `gbook_iglesiaquepos`
--
CREATE DATABASE IF NOT EXISTS `gbook_iglesiaquepos` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `gbook_iglesiaquepos`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cheques`
--

CREATE TABLE IF NOT EXISTS `cheques` (
  `id` int(11) NOT NULL,
  `numero` varchar(45) NOT NULL,
  `name` varchar(150) NOT NULL,
  `date` date NOT NULL,
  `datalle` varchar(255) NOT NULL,
  `monto` decimal(20,2) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
  `updated_at` timestamp(6) NOT NULL DEFAULT '0000-00-00 00:00:00.000000',
  `tipos_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos`
--

CREATE TABLE IF NOT EXISTS `departamentos` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
  `updated_at` timestamp(6) NOT NULL DEFAULT '0000-00-00 00:00:00.000000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gastos`
--

CREATE TABLE IF NOT EXISTS `gastos` (
  `id` int(11) NOT NULL,
  `num_factura` varchar(45) NOT NULL,
  `date` date NOT NULL,
  `datefactura` date NOT NULL,
  `monto` decimal(20,2) NOT NULL,
  `descripcion` text NOT NULL,
  `departamentos_id` int(11) NOT NULL,
  `iglesias_id` int(11) NOT NULL,
  `iglesias_users_id` int(11) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
  `updated_at` timestamp(6) NOT NULL DEFAULT '0000-00-00 00:00:00.000000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `iglesias`
--

CREATE TABLE IF NOT EXISTS `iglesias` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `address` varchar(45) NOT NULL,
  `users_id` int(11) NOT NULL,
  `misions_id` int(11) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
  `updated_at` timestamp(6) NOT NULL DEFAULT '0000-00-00 00:00:00.000000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingresos`
--

CREATE TABLE IF NOT EXISTS `ingresos` (
  `id` int(11) NOT NULL,
  `num_sobre` int(11) NOT NULL,
  `num_control` int(11) NOT NULL,
  `date` date NOT NULL,
  `monto` decimal(20,2) NOT NULL,
  `tipos_id` int(11) NOT NULL,
  `iglesias_id` int(11) NOT NULL,
  `iglesias_users_id` int(11) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
  `updated_at` timestamp(6) NOT NULL DEFAULT '0000-00-00 00:00:00.000000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `miembros`
--

CREATE TABLE IF NOT EXISTS `miembros` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `date_bautizmo` date NOT NULL,
  `date_nacimiento` date NOT NULL,
  `phone` varchar(13) NOT NULL,
  `celular` varchar(13) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
  `updated_at` timestamp(6) NOT NULL DEFAULT '0000-00-00 00:00:00.000000',
  `iglesias_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `miembros_has_ingresos`
--

CREATE TABLE IF NOT EXISTS `miembros_has_ingresos` (
  `miembros_id` int(11) NOT NULL,
  `ingresos_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `misions`
--

CREATE TABLE IF NOT EXISTS `misions` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `unions_id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
  `updated_at` timestamp(6) NOT NULL DEFAULT '0000-00-00 00:00:00.000000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos`
--

CREATE TABLE IF NOT EXISTS `tipos` (
  `id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
  `updated_at` timestamp(6) NOT NULL DEFAULT '0000-00-00 00:00:00.000000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unions`
--

CREATE TABLE IF NOT EXISTS `unions` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `users_id` int(11) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
  `updated_at` timestamp(6) NOT NULL DEFAULT '0000-00-00 00:00:00.000000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(85) NOT NULL,
  `email` varchar(60) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` text NOT NULL,
  `user_type` int(11) NOT NULL,
  `remember_token` text,
  `created_at` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
  `updated_at` timestamp(6) NOT NULL DEFAULT '0000-00-00 00:00:00.000000'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `username`, `password`, `user_type`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Anwar Sarmiento Ramos', '', 'admin', '$2y$10$VH4oLn5YMrbignBnxCGJr.MsnkDamTIN0UKiU9B/ilYW789/ovtRi', 0, NULL, '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cheques`
--
ALTER TABLE `cheques`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_cheques_tipos1_idx` (`tipos_id`);

--
-- Indices de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `gastos`
--
ALTER TABLE `gastos`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_gastos_departamentos1_idx` (`departamentos_id`), ADD KEY `fk_gastos_iglesias1_idx` (`iglesias_id`,`iglesias_users_id`);

--
-- Indices de la tabla `iglesias`
--
ALTER TABLE `iglesias`
  ADD PRIMARY KEY (`id`,`users_id`), ADD KEY `fk_iglesias_misions_idx` (`misions_id`), ADD KEY `fk_iglesias_users1_idx` (`users_id`);

--
-- Indices de la tabla `ingresos`
--
ALTER TABLE `ingresos`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_ingresos_tipos1_idx` (`tipos_id`), ADD KEY `fk_ingresos_iglesias1_idx` (`iglesias_id`,`iglesias_users_id`);

--
-- Indices de la tabla `miembros`
--
ALTER TABLE `miembros`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_miembros_iglesias1_idx` (`iglesias_id`);

--
-- Indices de la tabla `miembros_has_ingresos`
--
ALTER TABLE `miembros_has_ingresos`
  ADD PRIMARY KEY (`miembros_id`,`ingresos_id`), ADD KEY `fk_miembros_has_ingresos_ingresos1_idx` (`ingresos_id`), ADD KEY `fk_miembros_has_ingresos_miembros1_idx` (`miembros_id`);

--
-- Indices de la tabla `misions`
--
ALTER TABLE `misions`
  ADD PRIMARY KEY (`id`,`users_id`), ADD KEY `fk_misions_unions1_idx` (`unions_id`), ADD KEY `fk_misions_users1_idx` (`users_id`);

--
-- Indices de la tabla `tipos`
--
ALTER TABLE `tipos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `unions`
--
ALTER TABLE `unions`
  ADD PRIMARY KEY (`id`,`users_id`), ADD KEY `fk_unions_users1_idx` (`users_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cheques`
--
ALTER TABLE `cheques`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `gastos`
--
ALTER TABLE `gastos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `iglesias`
--
ALTER TABLE `iglesias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `ingresos`
--
ALTER TABLE `ingresos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `miembros`
--
ALTER TABLE `miembros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `misions`
--
ALTER TABLE `misions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `tipos`
--
ALTER TABLE `tipos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `unions`
--
ALTER TABLE `unions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cheques`
--
ALTER TABLE `cheques`
ADD CONSTRAINT `fk_cheques_tipos1` FOREIGN KEY (`tipos_id`) REFERENCES `tipos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `gastos`
--
ALTER TABLE `gastos`
ADD CONSTRAINT `fk_gastos_departamentos1` FOREIGN KEY (`departamentos_id`) REFERENCES `departamentos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_gastos_iglesias1` FOREIGN KEY (`iglesias_id`, `iglesias_users_id`) REFERENCES `iglesias` (`id`, `users_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `iglesias`
--
ALTER TABLE `iglesias`
ADD CONSTRAINT `fk_iglesias_misions` FOREIGN KEY (`misions_id`) REFERENCES `misions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_iglesias_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ingresos`
--
ALTER TABLE `ingresos`
ADD CONSTRAINT `fk_ingresos_iglesias1` FOREIGN KEY (`iglesias_id`, `iglesias_users_id`) REFERENCES `iglesias` (`id`, `users_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_ingresos_tipos1` FOREIGN KEY (`tipos_id`) REFERENCES `tipos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `miembros`
--
ALTER TABLE `miembros`
ADD CONSTRAINT `fk_miembros_iglesias1` FOREIGN KEY (`iglesias_id`) REFERENCES `iglesias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `miembros_has_ingresos`
--
ALTER TABLE `miembros_has_ingresos`
ADD CONSTRAINT `fk_miembros_has_ingresos_ingresos1` FOREIGN KEY (`ingresos_id`) REFERENCES `ingresos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_miembros_has_ingresos_miembros1` FOREIGN KEY (`miembros_id`) REFERENCES `miembros` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `misions`
--
ALTER TABLE `misions`
ADD CONSTRAINT `fk_misions_unions1` FOREIGN KEY (`unions_id`) REFERENCES `unions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_misions_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `unions`
--
ALTER TABLE `unions`
ADD CONSTRAINT `fk_unions_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
