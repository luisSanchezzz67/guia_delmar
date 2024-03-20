-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-03-2024 a las 05:07:07
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
(4, 'aprendiendo diseño 2', 1),
(5, 'Aprendiendo js', 2),
(6, 'Clase base datos', 2),
(7, 'Clase en Desarrollo', 2),
(8, 'Clase en diseño', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clase_profesor`
--

CREATE TABLE `clase_profesor` (
  `id` int(11) NOT NULL,
  `clase_id` int(11) NOT NULL,
  `profesor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `clase_profesor`
--

INSERT INTO `clase_profesor` (`id`, `clase_id`, `profesor_id`) VALUES
(4, 4, 3);

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
(5, 'curso 1'),
(6, 'curso 2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiante`
--

CREATE TABLE `estudiante` (
  `id_estudiante` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `nim` char(20) NOT NULL,
  `email` varchar(254) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `clase_id` int(11) NOT NULL COMMENT 'kelas&jurusan'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `estudiante`
--

INSERT INTO `estudiante` (`id_estudiante`, `nombre`, `nim`, `email`, `jenis_kelamin`, `clase_id`) VALUES
(9, 'Ovidio', '123123124', 'ovidio@gmail.com', '', 5),
(10, 'Estudiante 1', '232121212', '1@gmail.com', '', 5),
(11, 'Nestor', '21212134', 'nab@gmail.com', '', 5),
(12, 'Nestor1', '12345678', 'n1@gmail.com', '', 4),
(13, 'Juan', '03030303', 'juan@gmail.com', '', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `groups`
--

CREATE TABLE `groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'Lecturer', 'For making and checking Questions. And also conducting examinations'),
(3, 'Student', 'Exam Participants');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo`
--

CREATE TABLE `grupo` (
  `id_grupo` int(11) NOT NULL,
  `nombre_grupo` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `grupo`
--

INSERT INTO `grupo` (`id_grupo`, `nombre_grupo`) VALUES
(1, 'Diseño'),
(2, 'Desarrollo'),
(3, 'Grupo 3');

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
(13, 5, 1),
(14, 5, 2);

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
  `jml_benar` int(11) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `valor_peso` decimal(10,2) NOT NULL,
  `fecha_inicio` datetime NOT NULL,
  `fecha_terminacion` datetime NOT NULL,
  `status` enum('Y','N') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

--
-- Volcado de datos para la tabla `login_attempts`
--

INSERT INTO `login_attempts` (`id`, `ip_address`, `login`, `time`) VALUES
(69, '::1', 'fernando@gmail.com', 1710904755),
(70, '::1', 'fernando@gmail.com', 1710904768);

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

--
-- Volcado de datos para la tabla `m_prueba`
--

INSERT INTO `m_prueba` (`id_prueba`, `profesor_id`, `curso_id`, `nombre_prueba`, `cantidad_banco_preguntas`, `tiempo`, `tipo`, `file`, `tipe_file`, `file_banco_preguntas`, `banco_preguntas`, `enlace`, `fecha_inicio`, `tarde`, `token`) VALUES
(1, 3, 5, 'Examen 1', 1, 2, 'Sort', NULL, NULL, NULL, '<p>LEEEER</p>', '', '2024-03-19 22:00:09', '2024-03-19 22:00:15', 'QKHWF'),
(2, 3, 5, 'EXAMEN 2', 1, 5, 'Sort', NULL, NULL, NULL, '<p>REAAD</p>', '', '2024-03-19 22:01:51', '2024-03-21 22:02:01', 'YDHLQ'),
(3, 3, 5, 'EXAMEN 2', 1, 5, 'Sort', NULL, NULL, NULL, '<p>REAAD</p>', '', '2024-03-19 22:01:51', '2024-03-21 22:02:01', 'HCETB'),
(4, 3, 5, 'EXAMEN 2', 1, 5, 'Sort', NULL, NULL, NULL, '<p>REAAD</p>', '', '2024-03-19 22:01:51', '2024-03-21 22:02:01', 'DKKOJ');

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
(3, '111222333', 'Profesor 1', 'profe1@gmail.com', 5),
(5, '12121212', 'Profesor 3', 'profe3@gmail.com', 6),
(6, '12121312', 'Luis', 'luis2@gmail.com', 5);

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
(2, 3, 5, 1, '', '', '<p>¿Qué es diagrama ER?</p>', '<p>Diagrama Entidad-Relacion</p>', '<p>Diagrama Especial Relacion</p>', '<p>Diagrama Entero Rapido</p>', '<p>Diagrama Especial Rapido</p>', '<p>Diagrama Enterprise Result</p>', '', '', '', '', '', 'A', 1710813896, 1710896950),
(5, 6, 5, 1, 'd5fece930ac456af11314f78a8b4e0a1.png', 'image/png', '<p>¿Que es un VSC? // Editado</p>', '<p>Visual Studio Code</p>', '<p>Visual Enter Code</p>', '<p>Visual Enterprise Call</p>', '<p>Visual Enter Close</p>', '', '60d7f90aa9c0045c1b6d2ab02291ec9d.png', '', '', '', '', 'A', 1710894727, 1710895906),
(6, 3, 5, 1, '', '', '<p>Prueba de Pregunta</p>', '<p>A</p>', '<p>B</p>', '<p>C</p>', '<p>D</p>', '<p>E</p>', '', '', '', '', '', 'A', 1710904850, 1710904850);

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
(1, '127.0.0.1', 'Aaron', '$2y$12$HBerHsGmmIOrhqZp5PuE0ukb0AhRuQ/0.fcfP7kOVSVe4c2DVXu3C', 'aron@guiadelmar.com', NULL, '', NULL, NULL, NULL, NULL, NULL, 1268889823, 1710904780, 1, 'Aaron', 'Camacho', 'ADMIN', '0'),
(41, '::1', '111222333', '$2y$10$dWtsDAmWb7pLmf./XQPpZ.1wNmZbioZUxoXDq/t/KS1sAIwj.Rgki', 'profe1@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1710461823, 1710904818, 1, 'Profesor', '1', NULL, NULL),
(43, '::1', '12345678', '$2y$10$y0y5OrFyAWpjIHTxMqUbpOOvhLbo47.678r5fzquhaPJF9X17j4fa', 'estudiante1@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1710465994, NULL, 1, 'Estudiante', '1', NULL, NULL),
(44, '::1', '12345678910', '$2y$10$oTH47dq6p3whJftcmMWwzO2Mjd43WDtxHBfsgV/OdA5VUfywCRHuK', 'estudiante2@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1710465997, NULL, 1, 'Estudiante', '2', NULL, NULL),
(47, '::1', '12121212', '$2y$10$3iYpU2CcfEEATujjC7jHB.yQHPTy3MFPktiAOUftyzelmR9el5kPi', 'profe3@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1710473846, NULL, 1, 'Profesor', '3', NULL, NULL),
(48, '::1', '123456784', '$2y$10$neMzWRb.eW4W4UnSi7.GAuXeI1HGS1JBaZFxmpA5hu3EZ24qJkkgS', 'estudiante3@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1710473978, NULL, 1, 'Estudiante', '2', NULL, NULL),
(49, '::1', '123456788', '$2y$10$orBCH1X73ka/KV9x5MpB7eDBoWD.F0BChQQ9us.UdbOxb3IPgwCXy', 'ismael@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1710550261, NULL, 1, 'Ismael', 'Ismael', NULL, NULL),
(50, '::1', '12345670', '$2y$10$1Sg5gp1V3GCIgnUD70WdXeuliFsxmkvMIafRBopzOF4Z8QKVxvEgi', 'ismael2@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1710550361, NULL, 1, 'Ismael2', 'Ismael2', NULL, NULL),
(51, '::1', '12121312', '$2y$10$60/vjz1uKa9DG8rMYVP7rOW6LwRnyGUWJJuH7dPX/BC0I.tlQw9ta', 'luis2@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1710551084, NULL, 1, 'Luis', 'Luis', NULL, NULL),
(52, '::1', '22222222', '$2y$10$d4re/4Atz3xtdhocxpYTfO3uzDDhL7nTxc/oCNiyxgBpJO6h5T3FW', 'joaquin@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1710552527, NULL, 1, 'Joaquin', 'Joaquin', NULL, NULL),
(53, '::1', '12345677', '$2y$10$Rcgzl4ikl5maIQLEviZuFORcl4CFZH7DCTyNgmboXoMyWFn5M0d76', 'kc@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1710553014, NULL, 1, 'Kevin', 'Kevin', NULL, NULL),
(54, '::1', '1234567892', '$2y$10$CJTUMIEnKnUlVTRxycQcJumoidxxB3OBnk7vS5aUUBcodWU636T.G', 'joaquin2@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1710553162, NULL, 1, 'Joaquin', 'Joaquin', NULL, NULL),
(55, '::1', '23232323', '$2y$10$tmDUIXTHML124pF.tAuwp.6TkxuUgd34MsdeTwgReULMr.fPCWDuC', 'nestor@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1710553381, NULL, 1, 'Nestor', 'Nestor', NULL, NULL),
(56, '::1', '123123123', '$2y$10$Qp/dt.2X4efb4i3GAsctN.2yoHaSUElfdxnciGWaFCW3YOiEYJTg.', 'ovidio@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1710553680, NULL, 1, 'Ovidio', 'Ovidio', NULL, NULL),
(57, '::1', '123123124', '$2y$10$w0sxFAsg0gqPrmm/.1qLTeRBCPPm2Am87QU9YtjTS5Ynur9q6RMrq', 'ovidio2@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1710553760, NULL, 1, 'Ovidio', 'Ovidio', NULL, NULL),
(58, '::1', '23212121', '$2y$10$nKJmibdQP2OuXWcMnItRD.8O1C/7k/sxzz14I/YCrr5KrVjjvQ0cu', 'study@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1710554314, NULL, 1, 'Estudiant', 'Pro', NULL, NULL),
(59, '::1', '21212121', '$2y$10$LphCCZ3NmWJzE9ug7395xO0TyftRP2EPMQ1UWIiR7BsXKD6ZAtSxe', 'n@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1710559227, NULL, 1, 'Nestor', 'Nestor', NULL, NULL),
(60, '::1', '21212134', '$2y$10$4RSUBPICFUKxARGx2X97TuohkNf8IRGcszCS/TJJbxVv7fxQBVphC', 'nab@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1710559257, NULL, 1, 'Nestor', 'Nestor', NULL, NULL),
(61, '::1', '03030303', '$2y$10$XGHVR6QESG44q1/tLJP3Aulux8bQin11KijaFY6el6npyZrz.900K', 'juan@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1710559307, NULL, 1, 'Juan', 'Juan', NULL, NULL);

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
(63, 61, 3);

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
-- Indices de la tabla `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `grupo`
--
ALTER TABLE `grupo`
  ADD PRIMARY KEY (`id_grupo`);

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
  MODIFY `id_clase` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `clase_profesor`
--
ALTER TABLE `clase_profesor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `curso`
--
ALTER TABLE `curso`
  MODIFY `id_curso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `estudiante`
--
ALTER TABLE `estudiante`
  MODIFY `id_estudiante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `groups`
--
ALTER TABLE `groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `grupo`
--
ALTER TABLE `grupo`
  MODIFY `id_grupo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `grupo_curso`
--
ALTER TABLE `grupo_curso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `h_prueba`
--
ALTER TABLE `h_prueba`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT de la tabla `m_prueba`
--
ALTER TABLE `m_prueba`
  MODIFY `id_prueba` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `profesor`
--
ALTER TABLE `profesor`
  MODIFY `id_profesor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tb_banco_preguntas`
--
ALTER TABLE `tb_banco_preguntas`
  MODIFY `id_banco_preguntas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT de la tabla `users_groups`
--
ALTER TABLE `users_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

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
