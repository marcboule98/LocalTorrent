-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 07-05-2018 a las 10:45:13
-- Versión del servidor: 5.6.38
-- Versión de PHP: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de datos: `LocalTorrent`
--

CREATE DATABASE IF NOT EXISTS LocalTorrent DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE LocalTorrent;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Configuracion`
--

CREATE TABLE `Configuracion` (
  `rutaDescargas` varchar(500) DEFAULT NULL,
  `recibirEmailFinalizados` int(1) NOT NULL DEFAULT '0',
  `host` varchar(200) NOT NULL,
  `usuario` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Estadisticas`
--

CREATE TABLE `Estadisticas` (
  `fechaInstalacion` date DEFAULT NULL,
  `archivosDescargados` int(11) DEFAULT NULL,
  `sizeTotalDescargas` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Torrent`
--

CREATE TABLE `Torrent` (
  `idTorrent` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `codigoTorrent` int(11) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `calidad` int(11) NOT NULL,
  `idioma` varchar(255) NOT NULL,
  `finalizado` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Usuario`
--

CREATE TABLE `Usuario` (
  `idUsuario` int(11) NOT NULL,
  `nombre` varchar(32) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fechaNacimiento` date DEFAULT NULL,
  `emailValidado` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Torrent`
--
ALTER TABLE `Torrent`
  ADD PRIMARY KEY (`idTorrent`),
  ADD KEY `FK_TorrentUsuario` (`idUsuario`);

--
-- Indices de la tabla `Usuario`
--
ALTER TABLE `Usuario`
  ADD PRIMARY KEY (`idUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `Torrent`
--
ALTER TABLE `Torrent`
  MODIFY `idTorrent` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Usuario`
--
ALTER TABLE `Usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `Torrent`
--
ALTER TABLE `Torrent`
  ADD CONSTRAINT `FK_TorrentUsuario` FOREIGN KEY (`idUsuario`) REFERENCES `Usuario` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;
