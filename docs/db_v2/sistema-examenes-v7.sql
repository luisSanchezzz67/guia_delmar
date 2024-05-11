-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-05-2024 a las 06:03:50
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sistema-examenes`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clase`
--

CREATE TABLE `clase` (
  `id_clase` int(11) NOT NULL,
  `nombre_clase` varchar(30) NOT NULL,
  `grupo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `clase`
--

INSERT INTO `clase` (`id_clase`, `nombre_clase`, `grupo_id`) VALUES
(1, 'Aprendiendo JS', 1),
(2, 'Aprendiendo Photoshop', 2),
(12, 'Clase Premium', 15);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clase_profesor`
--

CREATE TABLE `clase_profesor` (
  `id` int(11) NOT NULL,
  `clase_id` int(11) NOT NULL,
  `profesor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso`
--

CREATE TABLE `curso` (
  `id_curso` int(11) NOT NULL,
  `nombre_curso` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `curso`
--

INSERT INTO `curso` (`id_curso`, `nombre_curso`) VALUES
(1, 'Curso WEB'),
(2, 'Curso Design ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiante`
--

CREATE TABLE `estudiante` (
  `id_estudiante` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `nim` char(20) NOT NULL,
  `email` varchar(254) NOT NULL,
  `genero` enum('L','P') NOT NULL,
  `clase_id` int(11) NOT NULL COMMENT 'kelas&jurusan'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `estudiante`
--

INSERT INTO `estudiante` (`id_estudiante`, `nombre`, `nim`, `email`, `genero`, `clase_id`) VALUES
(1, 'Alvaro', '10101010', 'alvaro@gmail.com', '', 1),
(2, 'Estudiante26', '11221122', '26@gmail.com', '', 2),
(3, 'Raul', '12312332', 'raul@gmail.com', '', 2),
(4, 'Piyi', '33221122', 'piyi@gmail.com', '', 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo`
--

CREATE TABLE `grupo` (
  `id_grupo` int(11) NOT NULL,
  `nombre_grupo` varchar(30) NOT NULL,
  `curso_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `grupo`
--

INSERT INTO `grupo` (`id_grupo`, `nombre_grupo`, `curso_id`) VALUES
(2, 'Diseño 4D', 1),
(8, 'Desarrollo', 1),
(15, 'Grupo Cartel', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo_curso`
--

CREATE TABLE `grupo_curso` (
  `id` int(11) NOT NULL,
  `curso_id` int(11) NOT NULL,
  `grupo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `grupo_curso`
--

INSERT INTO `grupo_curso` (`id`, `curso_id`, `grupo_id`) VALUES
(6, 1, 2),
(7, 2, 8),
(8, 2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `h_prueba`
--

CREATE TABLE `h_prueba` (
  `id` int(11) NOT NULL,
  `prueba_id` int(11) NOT NULL,
  `estudiante_id` int(11) NOT NULL,
  `list_banco_preguntas` longtext NOT NULL,
  `list_respuesta` longtext NOT NULL,
  `cantidad_verdadera` int(11) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `valor_peso` decimal(10,2) NOT NULL,
  `fecha_inicio` datetime NOT NULL,
  `fecha_terminacion` datetime NOT NULL,
  `status` enum('Y','N') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lecciones`
--

CREATE TABLE `lecciones` (
  `id` int(11) NOT NULL,
  `id_curso` int(11) NOT NULL DEFAULT 0,
  `id_profesor` int(11) NOT NULL DEFAULT 0,
  `titulo` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `video` text CHARACTER SET utf8 DEFAULT NULL,
  `contenido` text CHARACTER SET utf8 DEFAULT NULL,
  `status` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `fecha_inicial` datetime DEFAULT NULL,
  `fecha_disponible` datetime DEFAULT NULL,
  `creado` datetime DEFAULT NULL,
  `actualizado` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `lecciones`
--

INSERT INTO `lecciones` (`id`, `id_curso`, `id_profesor`, `titulo`, `video`, `contenido`, `status`, `fecha_inicial`, `fecha_disponible`, `creado`, `actualizado`) VALUES
(38, 1, 3, 'Leccion 1 Web', 'https://www.youtube.com/watch?v=fZY3zJJOajo', 'Porfavor mira el siguiente video y elabora un resumen acerca de dicho video haciendo una prueba de este texto. 2', 'Borrador', '2024-05-03 18:44:22', '2024-05-03 18:50:23', NULL, '2024-05-10 00:07:36'),
(39, 2, 3, 'Leccion 2 Diseño', 'https://youtu.be/GPpo0EYg4EM', 'Realizar un resumen del video', 'Publicada', '2024-05-04 12:23:49', '2024-05-11 12:23:50', NULL, '2024-05-10 00:37:38'),
(41, 1, 1, 'Leccion desde otro Profe', '', 'Resumen del Libro El Nini 19', 'Borrador', '2024-05-04 14:11:19', '2024-05-18 14:11:21', NULL, '2024-05-08 00:45:10'),
(55, 1, 3, 'Titulo 1', '', '', 'Borrador', '2024-05-09 18:44:55', '2024-05-09 18:44:56', NULL, NULL),
(56, 2, 3, 'Diseño 2.4', 'https://youtu.be/W66-oLcatYk?t=347', 'Ver el video y mapa conceptual', 'Publicada', '2024-05-10 21:58:24', '2024-05-17 21:58:25', NULL, '2024-05-11 03:58:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `m_prueba`
--

CREATE TABLE `m_prueba` (
  `id_prueba` int(11) NOT NULL,
  `profesor_id` int(11) NOT NULL,
  `curso_id` int(11) NOT NULL,
  `nombre_prueba` varchar(200) NOT NULL,
  `cantidad_banco_preguntas` int(11) NOT NULL,
  `tiempo` int(11) NOT NULL,
  `tipo` enum('Random','Sort') NOT NULL,
  `file` varchar(255) DEFAULT NULL,
  `tipe_file` varchar(50) DEFAULT NULL,
  `file_banco_preguntas` varchar(255) DEFAULT NULL,
  `banco_preguntas` longtext DEFAULT NULL,
  `enlace` longtext DEFAULT NULL,
  `fecha_inicio` datetime NOT NULL,
  `tarde` datetime NOT NULL,
  `token` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesor`
--

CREATE TABLE `profesor` (
  `id_profesor` int(11) NOT NULL,
  `nip` char(12) NOT NULL,
  `nombre_profesor` varchar(50) NOT NULL,
  `email` varchar(254) NOT NULL,
  `curso_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `profesor`
--

INSERT INTO `profesor` (`id_profesor`, `nip`, `nombre_profesor`, `email`, `curso_id`) VALUES
(1, '11223344', 'Luis', 'luis@gmail.com', 1),
(3, '123123123', 'Ernesto', 'ernesto@gmail.com', 2),
(5, '321231241', 'Reuss32', 'raul22@gmail.com', 1);

--
-- Disparadores `profesor`
--
DELIMITER $$
CREATE TRIGGER `edit_user_dosen` BEFORE UPDATE ON `profesor` FOR EACH ROW UPDATE `users` SET `email` = NEW.email, `username` = NEW.nip WHERE `users`.`username` = OLD.nip
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `hapus_user_dosen` BEFORE DELETE ON `profesor` FOR EACH ROW DELETE FROM `users` WHERE `users`.`username` = OLD.nip
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'Lecturer', 'For making and checking Questions. And also conducting examinations'),
(3, 'Student', 'Exam Participants');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_banco_preguntas`
--

CREATE TABLE `tb_banco_preguntas` (
  `id_banco_preguntas` int(11) NOT NULL,
  `profesor_id` int(11) NOT NULL,
  `curso_id` int(11) NOT NULL,
  `peso` int(11) NOT NULL,
  `file` varchar(255) NOT NULL,
  `tipe_file` varchar(50) NOT NULL,
  `banco_preguntas` longtext NOT NULL,
  `opsi_a` longtext NOT NULL,
  `opsi_b` longtext NOT NULL,
  `opsi_c` longtext NOT NULL,
  `opsi_d` longtext NOT NULL,
  `opsi_e` longtext NOT NULL,
  `file_a` varchar(255) NOT NULL,
  `file_b` varchar(255) NOT NULL,
  `file_c` varchar(255) NOT NULL,
  `file_d` varchar(255) NOT NULL,
  `file_e` varchar(255) NOT NULL,
  `respuesta` varchar(5) NOT NULL,
  `created_on` int(11) NOT NULL,
  `updated_on` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tb_banco_preguntas`
--

INSERT INTO `tb_banco_preguntas` (`id_banco_preguntas`, `profesor_id`, `curso_id`, `peso`, `file`, `tipe_file`, `banco_preguntas`, `opsi_a`, `opsi_b`, `opsi_c`, `opsi_d`, `opsi_e`, `file_a`, `file_b`, `file_c`, `file_d`, `file_e`, `respuesta`, `created_on`, `updated_on`) VALUES
(24, 1, 1, 1, '8001d9ec422f8ff377e76887868d3ca9.png', 'image/png', '<p>PREGUNTA CON IMG</p>', '<p>A</p>', '<p>B</p>', '<p>C</p>', '<p>D</p>', '<p>E</p>', 'd1d6d7a108364beda7794fa536ba3404.png', '', '', '', '', 'A', 1711223673, 1711223710),
(25, 1, 1, 1, '7d492e43a098fff540f317fd3df57b55.png', 'image/png', '<p>PREGUNTA SIN IMG</p>', '<p>A</p>', '<p>B</p>', '<p>C</p>', '<p>D</p>', '<p>E</p>', '', 'f532cf7935e952de4587d9f050c3865a.png', '707ae167727a14a44a2d4d896b08fc0a.png', '', '', 'A', 1711223744, 1714180279);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` text NOT NULL,
  `email` varchar(254) DEFAULT NULL,
  `activation_selector` varchar(255) DEFAULT NULL,
  `activation_code` varchar(255) DEFAULT NULL,
  `forgotten_password_selector` varchar(255) DEFAULT NULL,
  `forgotten_password_code` varchar(255) DEFAULT NULL,
  `forgotten_password_time` int(11) UNSIGNED DEFAULT NULL,
  `remember_selector` varchar(255) DEFAULT NULL,
  `remember_code` varchar(255) DEFAULT NULL,
  `created_on` int(11) UNSIGNED NOT NULL,
  `last_login` int(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) UNSIGNED DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `email`, `activation_selector`, `activation_code`, `forgotten_password_selector`, `forgotten_password_code`, `forgotten_password_time`, `remember_selector`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`) VALUES
(1, '127.0.0.1', 'Aaron', '$2y$12$HBerHsGmmIOrhqZp5PuE0ukb0AhRuQ/0.fcfP7kOVSVe4c2DVXu3C', 'aron@guiadelmar.com', NULL, '', NULL, NULL, NULL, NULL, NULL, 1268889823, 1715398744, 1, 'Aaron', 'Camacho', 'ADMIN', '0'),
(83, '::1', '11223344', '$2y$10$ke4lGcQQ3EkwaQjX0x4BEOtD9BthQ3oUaPKKeCY0UhNaIuZ53M8na', 'luis@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1714180431, 1715129051, 1, 'Luis', 'Luis', NULL, NULL),
(84, '::1', '123123123', '$2y$10$6r6DhjNA6OZ56MhTORHjbunJsTcYNhHPlxTCpndPNf2FIh6eqjofi', 'ernesto@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1714180434, 1715399578, 1, 'Ernesto', 'Ernesto', NULL, NULL),
(85, '::1', '11221122', '$2y$10$3Qj.J67Cz/9zMcjiaBwjk.XhLhgUBKYyQxuGP558tM80tbdaUvBEq', '26@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1714180722, 1715219434, 1, 'Estudiante26', 'Estudiante26', NULL, NULL),
(86, '::1', '12312332', '$2y$10$pSbew4GpFQ/qP11RkXiF6Om4B28NbGmq3o9re5dQZoP0yWsoRXr96', 'raul@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1714180752, NULL, 1, 'Raul', 'Raul', NULL, NULL),
(87, '::1', '321231241', '$2y$10$f50vJ7TaNh3CN3N2ko/Tv.YBTkQ5IAeoTOt.4Ll614VlrPX7PW8UW', 'raul22@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1714180817, NULL, 1, 'Reus', 'Reus', NULL, NULL),
(88, '::1', '33221122', '$2y$10$yK8lyMj4RTtKGPRm48ogKugmGlcJj6apDLPjvB65PkbYDWr5JrGNO', 'piyi@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1715131534, NULL, 1, 'Piyi', 'Piyi', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_groups`
--

CREATE TABLE `users_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(3, 1, 1),
(23, 21, 2),
(25, 23, 2),
(26, 24, 3),
(27, 25, 3),
(28, 26, 3),
(29, 27, 2),
(30, 28, 3),
(31, 29, 2),
(32, 30, 2),
(33, 31, 2),
(34, 32, 3),
(35, 33, 2),
(36, 34, 3),
(37, 35, 2),
(38, 36, 3),
(39, 37, 3),
(40, 38, 2),
(41, 39, 2),
(42, 40, 2),
(43, 41, 2),
(44, 42, 2),
(45, 43, 3),
(46, 44, 3),
(49, 47, 2),
(50, 48, 3),
(51, 49, 3),
(52, 50, 3),
(53, 51, 2),
(54, 52, 3),
(55, 53, 3),
(56, 54, 3),
(57, 55, 3),
(58, 56, 3),
(59, 57, 3),
(60, 58, 2),
(61, 59, 3),
(62, 60, 3),
(63, 61, 3),
(64, 62, 3),
(65, 63, 3),
(70, 68, 2),
(74, 72, 2),
(75, 73, 3),
(76, 74, 3),
(77, 75, 2),
(78, 76, 2),
(79, 77, 2),
(80, 78, 2),
(82, 80, 2),
(83, 81, 2),
(84, 82, 3),
(85, 83, 2),
(86, 84, 2),
(87, 85, 3),
(88, 86, 3),
(89, 87, 2),
(90, 88, 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clase`
--
ALTER TABLE `clase`
  ADD PRIMARY KEY (`id_clase`),
  ADD KEY `jurusan_id` (`grupo_id`);

--
-- Indices de la tabla `clase_profesor`
--
ALTER TABLE `clase_profesor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kelas_id` (`clase_id`),
  ADD KEY `dosen_id` (`profesor_id`);

--
-- Indices de la tabla `curso`
--
ALTER TABLE `curso`
  ADD PRIMARY KEY (`id_curso`);

--
-- Indices de la tabla `estudiante`
--
ALTER TABLE `estudiante`
  ADD PRIMARY KEY (`id_estudiante`),
  ADD UNIQUE KEY `nim` (`nim`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `kelas_id` (`clase_id`);

--
-- Indices de la tabla `grupo`
--
ALTER TABLE `grupo`
  ADD PRIMARY KEY (`id_grupo`),
  ADD KEY `curso_id` (`curso_id`);

--
-- Indices de la tabla `grupo_curso`
--
ALTER TABLE `grupo_curso`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jurusan_id` (`grupo_id`),
  ADD KEY `matkul_id` (`curso_id`);

--
-- Indices de la tabla `h_prueba`
--
ALTER TABLE `h_prueba`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ujian_id` (`prueba_id`),
  ADD KEY `mahasiswa_id` (`estudiante_id`);

--
-- Indices de la tabla `lecciones`
--
ALTER TABLE `lecciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `m_prueba`
--
ALTER TABLE `m_prueba`
  ADD PRIMARY KEY (`id_prueba`),
  ADD KEY `matkul_id` (`curso_id`),
  ADD KEY `dosen_id` (`profesor_id`);

--
-- Indices de la tabla `profesor`
--
ALTER TABLE `profesor`
  ADD PRIMARY KEY (`id_profesor`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `nip` (`nip`),
  ADD KEY `matkul_id` (`curso_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tb_banco_preguntas`
--
ALTER TABLE `tb_banco_preguntas`
  ADD PRIMARY KEY (`id_banco_preguntas`),
  ADD KEY `matkul_id` (`curso_id`),
  ADD KEY `dosen_id` (`profesor_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_activation_selector` (`activation_selector`),
  ADD UNIQUE KEY `uc_forgotten_password_selector` (`forgotten_password_selector`),
  ADD UNIQUE KEY `uc_remember_selector` (`remember_selector`),
  ADD UNIQUE KEY `uc_email` (`email`) USING BTREE;

--
-- Indices de la tabla `users_groups`
--
ALTER TABLE `users_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  ADD KEY `fk_users_groups_users1_idx` (`user_id`),
  ADD KEY `fk_users_groups_groups1_idx` (`group_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clase`
--
ALTER TABLE `clase`
  MODIFY `id_clase` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `clase_profesor`
--
ALTER TABLE `clase_profesor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `curso`
--
ALTER TABLE `curso`
  MODIFY `id_curso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `estudiante`
--
ALTER TABLE `estudiante`
  MODIFY `id_estudiante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `grupo`
--
ALTER TABLE `grupo`
  MODIFY `id_grupo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `grupo_curso`
--
ALTER TABLE `grupo_curso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `h_prueba`
--
ALTER TABLE `h_prueba`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `lecciones`
--
ALTER TABLE `lecciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT de la tabla `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT de la tabla `m_prueba`
--
ALTER TABLE `m_prueba`
  MODIFY `id_prueba` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `profesor`
--
ALTER TABLE `profesor`
  MODIFY `id_profesor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tb_banco_preguntas`
--
ALTER TABLE `tb_banco_preguntas`
  MODIFY `id_banco_preguntas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT de la tabla `users_groups`
--
ALTER TABLE `users_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `clase_profesor`
--
ALTER TABLE `clase_profesor`
  ADD CONSTRAINT `clase_profesor_ibfk_1` FOREIGN KEY (`profesor_id`) REFERENCES `profesor` (`id_profesor`) ON DELETE CASCADE,
  ADD CONSTRAINT `clase_profesor_ibfk_2` FOREIGN KEY (`clase_id`) REFERENCES `clase` (`id_clase`) ON DELETE CASCADE;

--
-- Filtros para la tabla `grupo_curso`
--
ALTER TABLE `grupo_curso`
  ADD CONSTRAINT `grupo_curso_ibfk_1` FOREIGN KEY (`grupo_id`) REFERENCES `grupo` (`id_grupo`) ON DELETE CASCADE,
  ADD CONSTRAINT `grupo_curso_ibfk_2` FOREIGN KEY (`curso_id`) REFERENCES `curso` (`id_curso`) ON DELETE CASCADE;

--
-- Filtros para la tabla `h_prueba`
--
ALTER TABLE `h_prueba`
  ADD CONSTRAINT `h_prueba_ibfk_1` FOREIGN KEY (`prueba_id`) REFERENCES `m_prueba` (`id_prueba`) ON DELETE CASCADE,
  ADD CONSTRAINT `h_prueba_ibfk_2` FOREIGN KEY (`estudiante_id`) REFERENCES `estudiante` (`id_estudiante`) ON DELETE CASCADE;

--
-- Filtros para la tabla `m_prueba`
--
ALTER TABLE `m_prueba`
  ADD CONSTRAINT `m_prueba_ibfk_1` FOREIGN KEY (`profesor_id`) REFERENCES `profesor` (`id_profesor`) ON DELETE CASCADE,
  ADD CONSTRAINT `m_prueba_ibfk_2` FOREIGN KEY (`curso_id`) REFERENCES `curso` (`id_curso`) ON DELETE CASCADE;

--
-- Filtros para la tabla `profesor`
--
ALTER TABLE `profesor`
  ADD CONSTRAINT `profesor_ibfk_1` FOREIGN KEY (`curso_id`) REFERENCES `curso` (`id_curso`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
