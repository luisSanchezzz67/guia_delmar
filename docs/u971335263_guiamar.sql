-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 23-02-2024 a las 03:50:51
-- Versión del servidor: 10.6.14-MariaDB-cll-lve
-- Versión de PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `u971335263_guiamar`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dosen`
--

CREATE TABLE `dosen` (
  `id_dosen` int(11) NOT NULL,
  `nip` char(12) NOT NULL,
  `nama_dosen` varchar(50) NOT NULL,
  `email` varchar(254) NOT NULL,
  `matkul_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `dosen`
--

INSERT INTO `dosen` (`id_dosen`, `nip`, `nama_dosen`, `email`, `matkul_id`) VALUES
(11, '21082023', 'Aaron Camacho', 'Aaron@guiadelmar.com', 13),
(12, '1234567890', 'luis', 'luiscrruzsanch3837@gmail.com', 13),
(13, '12345678901', 'alexis', 'alexis@gmail.com', 13),
(14, '12345677', 'fernando', 'fernando@gmail.com', 13),
(15, '11111111', 'Rolando', 'rolando@gmail.com', 14),
(16, '12121212', 'Natalia Morales', 'morales@natalia.com', 15);

--
-- Disparadores `dosen`
--
DELIMITER $$
CREATE TRIGGER `edit_user_dosen` BEFORE UPDATE ON `dosen` FOR EACH ROW UPDATE `users` SET `email` = NEW.email, `username` = NEW.nip WHERE `users`.`username` = OLD.nip
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `hapus_user_dosen` BEFORE DELETE ON `dosen` FOR EACH ROW DELETE FROM `users` WHERE `users`.`username` = OLD.nip
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `groups`
--

CREATE TABLE `groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'Lecturer', 'For making and checking Questions. And also conducting examinations'),
(3, 'Student', 'Exam Participants');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `h_ujian`
--

CREATE TABLE `h_ujian` (
  `id` int(11) NOT NULL,
  `ujian_id` int(11) NOT NULL,
  `mahasiswa_id` int(11) NOT NULL,
  `list_soal` longtext NOT NULL,
  `list_jawaban` longtext NOT NULL,
  `jml_benar` int(11) NOT NULL,
  `nilai` decimal(10,2) NOT NULL,
  `nilai_bobot` decimal(10,2) NOT NULL,
  `tgl_mulai` datetime NOT NULL,
  `tgl_selesai` datetime NOT NULL,
  `status` enum('Y','N') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `h_ujian`
--

INSERT INTO `h_ujian` (`id`, `ujian_id`, `mahasiswa_id`, `list_soal`, `list_jawaban`, `jml_benar`, `nilai`, `nilai_bobot`, `tgl_mulai`, `tgl_selesai`, `status`) VALUES
(10, 12, 9, '34,32,28,35,31,30,27,26,29,33', '34:B:N,32:B:N,28:D:N,35:D:N,31:A:N,30:D:N,27:A:N,26:C:N,29:A:N,33:C:N', 10, 100.00, 100.00, '2023-08-22 03:30:11', '2023-08-22 03:35:11', 'N'),
(11, 12, 8, '27,33,26,28,34,32,35,29,31,30', '27:A:N,33:C:N,26:C:N,28:A:N,34:A:N,32:B:N,35:D:N,29:A:N,31:B:N,30:D:N', 7, 70.00, 100.00, '2023-08-22 03:50:00', '2023-08-22 03:55:00', 'N'),
(12, 12, 10, '31,29,32,27,35,26,33,30,34,28', '31:A:N,29:A:N,32:B:N,27:B:N,35:E:N,26:C:N,33:C:N,30:B:N,34:B:N,28:D:N', 7, 70.00, 100.00, '2023-08-22 05:20:33', '2023-08-22 05:25:33', 'N'),
(13, 45, 12, '50', '50:A:Y', 1, 100.00, 100.00, '2024-01-23 03:52:27', '2024-01-23 04:17:27', 'N'),
(14, 46, 11, '36', '36:B:Y', 0, 0.00, 100.00, '2024-02-21 11:14:08', '2024-02-21 11:34:08', 'N'),
(15, 47, 11, '51', '51:C:Y', 1, 100.00, 100.00, '2024-02-21 11:19:58', '2024-02-21 11:44:58', 'N'),
(16, 48, 11, '51', '51:B:Y', 0, 0.00, 100.00, '2024-02-21 11:22:57', '2024-02-21 11:32:57', 'N'),
(17, 49, 11, '51', '51:C:Y', 1, 100.00, 100.00, '2024-02-21 11:25:27', '2024-02-21 11:35:27', 'N');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jurusan`
--

CREATE TABLE `jurusan` (
  `id_jurusan` int(11) NOT NULL,
  `nama_jurusan` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `jurusan`
--

INSERT INTO `jurusan` (`id_jurusan`, `nama_jurusan`) VALUES
(18, 'Cancún Test'),
(19, 'Buenos Aires'),
(20, 'Grupo de base de datos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jurusan_matkul`
--

CREATE TABLE `jurusan_matkul` (
  `id` int(11) NOT NULL,
  `matkul_id` int(11) NOT NULL,
  `jurusan_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `jurusan_matkul`
--

INSERT INTO `jurusan_matkul` (`id`, `matkul_id`, `jurusan_id`) VALUES
(12, 13, 18),
(13, 14, 19),
(14, 15, 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` int(11) NOT NULL,
  `nama_kelas` varchar(30) NOT NULL,
  `jurusan_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `kelas`
--

INSERT INTO `kelas` (`id_kelas`, `nama_kelas`, `jurusan_id`) VALUES
(12, 'Fisiología', 5),
(13, 'Textiles', 6),
(14, 'Contexto Social', 13),
(15, 'Pesca', 15),
(16, 'Patron de yate', 18),
(17, 'Clase para flotar', 19);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `kelas_dosen`
--

CREATE TABLE `kelas_dosen` (
  `id` int(11) NOT NULL,
  `kelas_id` int(11) NOT NULL,
  `dosen_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `kelas_dosen`
--

INSERT INTO `kelas_dosen` (`id`, `kelas_id`, `dosen_id`) VALUES
(17, 16, 11),
(18, 16, 12),
(19, 16, 13),
(20, 16, 14),
(21, 17, 15),
(22, 16, 16);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `id_mahasiswa` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `nim` char(20) NOT NULL,
  `email` varchar(254) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `kelas_id` int(11) NOT NULL COMMENT 'kelas&jurusan'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `mahasiswa`
--

INSERT INTO `mahasiswa` (`id_mahasiswa`, `nama`, `nim`, `email`, `jenis_kelamin`, `kelas_id`) VALUES
(1, 'Liam Moore', '12183018', 'liamoore@mail.com', '', 1),
(2, 'Demo Student', '01112004', 'demostd@mail.com', '', 9),
(4, 'Juan Estudiante', '62314152', 'jestudiante@cweb.com', '', 12),
(5, 'Pedro Estudiante', '34343434', 'pestudiante@cweb.com', '', 12),
(6, 'Andrés Estudiante', '14141418', 'aestudiante@cweb.com', '', 14),
(7, 'Luis', '123456789', 'luis@estudiante.com', '', 15),
(8, 'Genesis V', '987654321', 'genesis@curso.com', '', 16),
(9, 'Jorge Camacho', '11223344', 'jorge@curso.com', '', 16),
(10, 'Manuel', '99887766', 'manuel@curso.com', '', 16),
(11, 'asdasasda', '1234567890', 'toxichunter84@gmail.com', '', 16),
(12, 'Alvaro', '22222222', 'alvaro@gmail.com', '', 17),
(13, 'alvaro', '98989898', 'alvaro@alvaro.com', '', 16);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `matkul`
--

CREATE TABLE `matkul` (
  `id_matkul` int(11) NOT NULL,
  `nama_matkul` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `matkul`
--

INSERT INTO `matkul` (`id_matkul`, `nama_matkul`) VALUES
(13, 'NAV BAS TEST'),
(14, 'Curso de natacion'),
(15, 'Aprendiendo Mysql');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `m_ujian`
--

CREATE TABLE `m_ujian` (
  `id_ujian` int(11) NOT NULL,
  `dosen_id` int(11) NOT NULL,
  `matkul_id` int(11) NOT NULL,
  `nama_ujian` varchar(200) NOT NULL,
  `jumlah_soal` int(11) NOT NULL,
  `waktu` int(11) NOT NULL,
  `jenis` enum('Random','Sort') NOT NULL,
  `file` varchar(255) DEFAULT NULL,
  `tipe_file` varchar(50) DEFAULT NULL,
  `file_soal` varchar(255) DEFAULT NULL,
  `soal` longtext DEFAULT NULL,
  `enlace` longtext DEFAULT NULL,
  `tgl_mulai` datetime NOT NULL,
  `terlambat` datetime NOT NULL,
  `token` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `m_ujian`
--

INSERT INTO `m_ujian` (`id_ujian`, `dosen_id`, `matkul_id`, `nama_ujian`, `jumlah_soal`, `waktu`, `jenis`, `file`, `tipe_file`, `file_soal`, `soal`, `enlace`, `tgl_mulai`, `terlambat`, `token`) VALUES
(12, 11, 13, 'Evaluacion General', 10, 5, 'Random', NULL, NULL, NULL, NULL, NULL, '2023-08-21 14:22:18', '2023-08-22 14:22:24', 'IPRTN'),
(13, 12, 13, 'test2', 3, 40, 'Sort', NULL, NULL, NULL, NULL, NULL, '2023-09-16 00:50:35', '2023-09-18 05:42:41', 'PMTVN'),
(14, 12, 13, 'test', 2, 21, 'Random', NULL, NULL, NULL, NULL, NULL, '2023-09-24 01:26:49', '2023-09-25 01:26:52', 'XRCSN'),
(15, 12, 13, 'tes3', 1, 42, 'Random', NULL, NULL, NULL, NULL, NULL, '2023-09-24 01:54:49', '2023-09-25 01:54:52', 'XGNUZ'),
(40, 13, 13, 'poc10', 1, 15, 'Random', NULL, NULL, NULL, '<p>https://drive.google.com/file/d/1dC2o4XFx9p1Btb59Z7aP7pt85xM0W1HI/view?usp=drive_link<br></p>', '<p>Instrucciones: </p><ul><li>Descargar pdf</li><li>Abrir navegador</li><li>Estudiar<br></li></ul>', '2023-09-25 12:53:49', '2023-09-26 12:53:50', 'ZRAJN'),
(41, 13, 13, 'poc120', 1, 25, 'Random', NULL, NULL, NULL, '<p>Instrucciones:</p><ul><li>1</li><li>2</li><li>3</li><li>4</li><li>5</li></ul>', '<p>https://drive.google.com/file/d/1dC2o4XFx9p1Btb59Z7aP7pt85xM0W1HI/view?usp=drive_link<br></p>', '2023-09-25 13:15:18', '2023-09-26 13:15:20', 'ZLOBW'),
(42, 13, 13, 'enlace', 2, 25, 'Random', NULL, NULL, NULL, '<p>Instrucciones: </p><ul><li>1</li><li>2</li><li>3</li><li>4</li><li>5</li><li>7</li></ul>', 'https://drive.google.com/file/d/1dC2o4XFx9p1Btb59Z7aP7pt85xM0W1HI/view?usp=sharing', '2023-09-25 13:24:00', '2023-09-26 13:24:02', 'ZHQMW'),
(43, 13, 13, 'Nevegacion 1', 2, 25, 'Random', NULL, NULL, NULL, '<p>Instrucciones:</p><ul><li>Primero descargarse la guia de estudio</li><li>Tomar el examen en el tiempo que indica el sistema</li><li>Corroborar su conexion a internet<br></li></ul>', 'https://drive.google.com/file/d/1dC2o4XFx9p1Btb59Z7aP7pt85xM0W1HI/view?usp=sharing', '2023-09-25 13:39:30', '2023-09-26 13:39:32', 'ZEMIG'),
(44, 14, 13, 'examen prueba 2', 1, 25, 'Random', NULL, NULL, NULL, '<p>Instrucciones: </p><ul><li>Descargar la guia de estudio</li><li>Estudiar 25 min al dia<br></li></ul>', 'https://drive.google.com/file/d/1cLfj-Bd9cSpRN27e5O_ChsZX6Dc7F-pa/view?usp=sharing', '2023-10-01 20:11:48', '2023-10-02 20:11:51', 'LRSQO'),
(45, 15, 14, 'Examen de introduccion', 1, 25, 'Random', NULL, NULL, NULL, '<p>Prohibido copiar</p>', 'https://docs.google.com/forms/d/e/1FAIpQLSfX6dxUdptRz1tr5JWFUAJA9GCA8VVYuBD_bXipn-0D680MHA/viewform?usp=sharing', '2024-01-22 13:50:18', '2024-01-23 15:41:32', 'DBCVW'),
(46, 12, 13, 'Aprendo js', 1, 20, 'Random', NULL, NULL, NULL, '<p>No copiar</p>', '', '2024-02-20 21:15:43', '2024-02-21 22:11:59', 'OPIFM'),
(47, 12, 13, 'Aprendiendo php', 1, 25, 'Random', NULL, NULL, NULL, '', '', '2024-02-20 21:20:23', '2024-02-21 21:16:32', 'CVITX'),
(48, 12, 13, 'aprendiendo javascript E6', 1, 10, 'Random', NULL, NULL, NULL, '<p>no copiar</p>', 'www.facebook.com', '2024-02-20 21:25:36', '2024-02-21 21:21:48', 'ZUBLA'),
(49, 12, 13, 'aprendiendo css', 1, 10, 'Random', NULL, NULL, NULL, '<p>asdadas</p>', '12e1dsad', '2024-02-20 22:30:27', '2024-02-23 21:24:36', 'YVEHS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_soal`
--

CREATE TABLE `tb_soal` (
  `id_soal` int(11) NOT NULL,
  `dosen_id` int(11) NOT NULL,
  `matkul_id` int(11) NOT NULL,
  `bobot` int(11) NOT NULL,
  `file` varchar(255) NOT NULL,
  `tipe_file` varchar(50) NOT NULL,
  `soal` longtext NOT NULL,
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
  `jawaban` varchar(5) NOT NULL,
  `created_on` int(11) NOT NULL,
  `updated_on` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `tb_soal`
--

INSERT INTO `tb_soal` (`id_soal`, `dosen_id`, `matkul_id`, `bobot`, `file`, `tipe_file`, `soal`, `opsi_a`, `opsi_b`, `opsi_c`, `opsi_d`, `opsi_e`, `file_a`, `file_b`, `file_c`, `file_d`, `file_e`, `jawaban`, `created_on`, `updated_on`) VALUES
(21, 7, 8, 10, '4bf27efcf12574cccb52c6ec3e6a391c.jpg', 'image/jpeg', '<p>¿Cuáles son las tres partes principales de una célula humana?</p>', '<div> Núcleo, mitocondrias y lisosoma</div>', '<p>Núcleo, citoplasma y membrana plasmática.<br></p>', '<p>Mitocondrias, citoesqueleto y membrana plasmática.<br></p>', '<p>Mitocondrias, citoplasma y membrana plasmática.<br></p>', '<p>Citoesqueleto, núcleo y lisosoma.<br></p>', '66ba609b0fdb5be6a0f4b401eb156176.jpg', '', '', '', '', 'A', 1655356825, 1661451938),
(22, 7, 8, 1, '', '', '<p>¿Qué estructura celular es principalmente responsable de la capacidad de las células para comunicarse con su medio externo?</p>', '<p> Mitocondria</p>', '<p>Citoesqueleto<br></p>', '<p> Citoplasma<br></p>', '<p> Membrana plasmática<br></p>', '<p> Núcleo<br></p>', '', '', '', '', '', 'D', 1661452549, 1661452549),
(23, 9, 11, 1, '', '', '<p>¿ En que se concreta el hecho social?</p>', '<p>Es en si mismo un hecho natural y universal que ha existido siempre pero fu formas, modos de constitución y funcionamiento varian en distintos lugares y atraves del tiempo presentando caracteristicas distintas determinadas por motivos de indole cultural e historica.<br></p>', '<p>Las sociedades varían en el grado en que se ajustan a una u otra de estas clasificaciones.<br></p>', '<p>El de hecho social es un concepto básico en la sociología y la antropología se refiere a todo comportamiento o idea presente en un grupo social (sea respetado o no, sea subjetivamente compartido o no) que es transmitido de generación en generación a cada individuo por la sociedad.<br></p>', '<p>Charles Horton Cooley llamo al primer tipo grupos primarios y al segundo grupos secundarios.<br></p>', '<p>Se le atribuye a Robert Redfield<br></p>', '', '', '', '', '', 'C', 1661786435, 1661786435),
(24, 10, 12, 1, '', '', '<p>Como pescar en el oceano</p>', '<p>Con azuelos</p>', '<p>Con raya</p>', '<p>Con alfiler</p>', '', '', '', '', '', '', '', 'B', 1691695330, 1691695330),
(25, 10, 12, 1, '', '', '<p>Como parquear un barco</p>', '<p>a</p>', '<p>b</p>', '<p>c</p>', '<p>d</p>', '<p>E</p>', '', '', '', '', '', 'A', 1691695376, 1691695376),
(26, 11, 13, 1, '', '', '<p>EN LA TERMINOLOGIA NAUTICA, COMO SE LE CONOCE AL LADO DERECHO?</p>', '<p>Popa</p>', '<p>Babor</p>', '<p>Estribor</p>', '<p>Proa</p>', '<p>Borda</p>', '', '', '', '', '', 'C', 1692637265, 1692646638),
(27, 11, 13, 1, '', '', 'COMO SE LLAMA EL EQUIPO DE NAVEGACION QUE MIDE LA DISTANCIA DE LA QUILLA AL FONDO MARINO?', '<p>Ecosonda</p>', '<p>Profundimetro</p>', '<p>Radar</p>', '<p>Corredera</p>', '<p>EPIRB</p>', '', '', '', '', '', 'A', 1692641320, 1692646627),
(28, 11, 13, 1, '', '', 'COMO SE LE LLAMAN A LAS LUCES COLOR: VERDE Y ROJO EN UN BUQUE?', '<p>Luz de alcance</p>', '<p>Luces direccionales</p>', '<p>Luces de navegacion</p>', '<p>Luces de costados</p>', '<p>Luces de camino</p>', '', '', '', '', '', 'D', 1692641433, 1692646591),
(29, 11, 13, 1, '25e80dfb359f8158db363efb3e1f4e22.jpg', 'image/jpeg', 'COMO SE LLAMA ESTE TIPO DE ANCLA?', '<p>Danforth</p>', '<p>Bruce</p>', '<p>Almirantazgo</p>', '<p>Rezon</p>', '<p>Buff</p>', '', '', '', '', '', 'A', 1692641559, 1692646566),
(30, 11, 13, 1, '', '', 'COMO SE LLAMA EL EQUIPO DE COMUNICACION VIA RADIO?', '<p>Wallkitalki<br></p>', '<p>VHS</p>', '<p>Repetidores</p>', '<p>VHF</p>', '<p>Telegrafo</p>', '', '', '', '', '', 'D', 1692641672, 1692646539),
(31, 11, 13, 1, 'a5effde4ce7b8f946a78ee551e2b9269.jpg', 'image/jpeg', '<p>COMO SE LLAMA ESTE ELEMENTO?</p>', '<p>Biela</p>', '<p>Piston</p>', '<p>Pinza</p>', '<p>Llave</p>', '<p>Manivela</p>', '', '', '', '', '', 'A', 1692641825, 1692646523),
(32, 11, 13, 1, '', '', '<p>EN TERMINOLOGIA NAUTICA, COMO SE LLAMA AL LADO IZQUIERDO?</p>', '<p>Popa</p>', '<p>Babor</p>', '<p>Proa</p>', '<p>Estribor</p>', '<p>Borda</p>', '', '', '', '', '', 'B', 1692641908, 1692646499),
(33, 11, 13, 1, '', '', '<p>CUANTOS CETANOS TIENE EL COMBUSTIBLE DIESEL?</p>', '<p>20 - 30</p>', '<p>30 - 40</p>', '<p>40 - 55</p>', '<p>55 - 80</p>', '<p>80 - 95</p>', '', '', '', '', '', 'C', 1692642042, 1692646479),
(34, 11, 13, 1, '778d879bdbc7259ac4e80603df7beb4d.jpg', 'image/jpeg', 'COMO SE LLAMA ESTE ELEMENTO?', '<p>Brujula</p>', '<p>Barometro</p>', '<p>Reloj</p>', '<p>Girocompas</p>', '<p>Axiometro</p>', '', '', '', '', '', 'B', 1692642194, 1692646463),
(35, 11, 13, 1, 'c8a7b35a616a2c61e036d77cf241d548.png', 'image/png', 'CUAL ES EL SIGNIFICADO DE ESTA BANDERA?', '<p>Transporto carga peligrosa</p>', '<p>Precaucion</p>', '<p>Cargando o descargando combustible</p>', '<p>Buzos en el area</p>', '<p>Marea alta</p>', '', '', '', '', '', 'D', 1692642301, 1692646440),
(39, 13, 13, 1, '', '', '<p>asdasdsa<br></p>', '<p>1231sadasdasdsa<br></p>', '<p>sadas1212<br></p>', '<p>asd12312<br></p>', '<p>sadasd12<br></p>', '<p>asdas12<br></p>', '', '', '', '', '', 'B', 1695456356, 1695456356),
(40, 13, 13, 1, '7669f7a6038aad20da8dcf9c1b9b2e15.jpeg', 'image/jpeg', '<p>test4<br></p>', '<p>asdsad<br></p>', '<p>asdasa<br></p>', '<p>sdasda<br></p>', '<p>asdsa<br></p>', '<p>sadas<br></p>', '', '', '', '', '', 'C', 1695457060, 1695457060),
(41, 13, 13, 1, '48346da2f27ca00dcc20a518cb2c77df.jpeg', 'image/jpeg', '<p>k999<br></p>', '<p>aaaaa<br></p>', '<p>bbbb<br></p>', '<p>asdsada<br></p>', '<p>sadas<br></p>', '<p>asdas<br></p>', 'b06e302060d3938617d6031f789b4901.jpeg', 'd54c1bc8fa2d4efcdf8c4fc4fc01fb0d.jpeg', '', '', '', 'D', 1695457388, 1695457388),
(42, 13, 13, 1, '63a178f71e56defb40525b9261598cc0.jpeg', 'image/jpeg', '<p>teasa<br></p>', '<p>asdasa<br></p>', '<p>asdas<br></p>', '<p>asdas<br></p>', '<p>asdas<br></p>', '<p>asdas<br></p>', '', '', '', '', '', 'B', 1695520310, 1695520310),
(43, 13, 13, 1, '6285b9a993536a53d2f1625c1ee5c3fd.jpeg', 'image/jpeg', '<p>asa</p>', '<p>asdas</p>', '<p>121asas</p>', '<p>axas</p>', '<p>asxasxas</p>', '<p>asxas12</p>', '', '', '', '', '', 'B', 1695528849, 1695528849),
(44, 13, 13, 1, 'ada963890e12d1744303c021b2e8d7eb.jpeg', 'image/jpeg', '<p>test40</p>', '<p>asdsa</p>', '<p>asdas</p>', '<p>asdas</p>', '<p>sadsa</p>', '<p>sadas</p>', '', '', '', '', '', 'C', 1695528948, 1695528948),
(45, 13, 13, 1, '9690dddd577cf4dcb8a046dcc827119e.jpeg', 'image/jpeg', '<p>xzxas121</p>', '<p>asd121</p>', '<p>asdasdas</p>', '<p>asdas</p>', '<p>asdas</p>', '<p>sada</p>', '', '', '', '', '', 'D', 1695529231, 1695529231),
(46, 13, 13, 1, '30e5dec2a346e72763485f6c5543ba0e.jpeg', 'image/jpeg', '<p>examn12122</p>', '<p>asdasdas</p>', '<p>asdasdasa</p>', '<p>sdasdas</p>', '<p>asdasdas</p>', '<p>asdasdas</p>', '', '', '', '', '', 'D', 1695533597, 1695533597),
(47, 13, 13, 1, '4a49b6472de800c51d3f8c48a7c6e410.jpeg', 'image/jpeg', '<p>¿Cuanto pesa un barco?<br></p>', '<p>asadadas<br></p>', '<p>sadasdasdsa<br></p>', '<p>asdasdsa<br></p>', '<p>asdasd<br></p>', '<p>asdas<br></p>', '6b1a3741a39e2a1710ddaa7f948f3ec5.png', 'cd7063150e7fe123e39d5fad0a749624.png', '0189a55130288033209829dd3cdc5ec8.png', '727f9f0fa76c625f42bf5813377ddc7f.png', '', 'E', 1695584284, 1695584284),
(48, 11, 13, 1, 'e11315e36bb049ce3486d2fb0337a6a5.mp4', 'video/mp4', '<p>DE CUANTOS CABALLOS DE FUERZA ES EL MOTOR?</p>', '<p>200</p>', '<p>250</p>', '<p>300</p>', '<p>350</p>', '', '', '', '', '', '', 'D', 1695915246, 1695915246),
(49, 14, 13, 1, '16353788a77d15696a3895daee66446e.png', 'image/png', 'prueba 1<br>', '<p>asdsadasdsa<br></p>', '<p><b><p>asdsadasdsa<br></p></b></p>', '<p><b><p>asdsadasdsa<br></p></b></p>', '<p><b><p>asdsadasdsa<br></p></b></p>', '<p><b><p>asdsadasdsa<br></p></b></p>', '5c00f8243b3a1423159f628860a314e1.png', '', '', '', '', 'C', 1696126267, 1696126267),
(50, 15, 14, 1, '0307748090d98d8a6d83bed2abf09413.png', 'image/png', '<p>¿Como flotarias en el oceano?</p>', '<p>Con un salvavidas</p>', '<p>Flotando</p>', '<p>Pidiendo</p>', '<p>Progtramando con js</p>', '<p>Preguntandole a chatgpt</p>', '', '', '', '', '', 'A', 1705952200, 1705952200),
(51, 12, 13, 1, '', '', '<p>Como abrir una etiqueta con php</p>', '<p>const 1 = 1;</p>', '2<p>&lt;!--? php ?--&gt;</p>', '3<p>&lt;!--?php ?--&gt;</p>', '4<p>&lt;!--? end ?--&gt;</p>', '5<p><a href=\"www.google.com\"></a></p>', '', '', '', '', '', 'C', 1708485506, 1708485844);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `email`, `activation_selector`, `activation_code`, `forgotten_password_selector`, `forgotten_password_code`, `forgotten_password_time`, `remember_selector`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`) VALUES
(1, '127.0.0.1', 'Aaron', '$2y$12$HBerHsGmmIOrhqZp5PuE0ukb0AhRuQ/0.fcfP7kOVSVe4c2DVXu3C', 'aron@guiadelmar.com', NULL, '', NULL, NULL, NULL, NULL, NULL, 1268889823, 1708659186, 1, 'Aaron', 'Camacho', 'ADMIN', '0'),
(23, '2806:10be:a:31f8:f090:bd0a:a76f:5252', '21082023', '$2y$10$8UHPn6BXypF9y/TDnyL29uFe2/pFSuN7/4IvAOTX36PhhJG3HurHO', 'Aaron@guiadelmar.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1692636858, 1692646372, 1, 'Aaron', 'Camacho', NULL, NULL),
(24, '2806:10be:a:31f8:f090:bd0a:a76f:5252', '11223344', '$2y$10$2W6Ot.T8La3FYReh3LFHReN8GO55BSXNd0Vt7mTlUdX5X6J3Ss3w2', 'jorge@curso.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1692645631, 1695456184, 1, 'Jorge', 'Camacho', NULL, NULL),
(25, '2806:10be:a:31f8:f090:bd0a:a76f:5252', '987654321', '$2y$10$v/FO/3Xf4c0WUF6S7spbK.pBr3XjAUWwknWwmbPmRCFQavGhj7HWO', 'genesis@curso.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1692645634, 1692647310, 1, 'Genesis', 'V', NULL, NULL),
(26, '2806:10be:a:31f8:f090:bd0a:a76f:5252', '99887766', '$2y$10$1Hjy/f2zr2st5JFNouVnFOw6T8NDIGxCmT0TGQRgH46bAhs28apWm', 'manuel@curso.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1692652756, 1692652802, 1, 'Manuel', 'Manuel', NULL, NULL),
(27, '2806:268:489:8a20:7906:3e02:e3ec:e81c', '1234567890', '$2y$10$EIsE68rdRwcperMeI/oJ8emaKocEnUOBI/E5w4O6AM3loj8Pkkk1u', 'luiscrruzsanch3837@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1694845942, 1708485970, 1, 'luis', 'luis', NULL, NULL),
(28, '2806:268:489:8a20:7906:3e02:e3ec:e81c', '1234567890', '$2y$10$Z8s7o3BREU0fMWJ6mfeENeuM87flxSz7gtFqxlSzria6XYV32oMpW', 'toxichunter84@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1694846735, 1708485897, 1, 'asdasasda', 'asdasasda', NULL, NULL),
(29, '2806:268:489:8a20:7d29:19a0:6966:b2c', '12345678901', '$2y$10$WdmYPq5LjvIWPhLuixp0w.fQ4gyhSDvgi0dX04H.9t5Ld2pvNSnXC', 'alexis@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1695456315, 1705949055, 1, 'alexis', 'alexis', NULL, NULL),
(30, '2806:268:409:ba9:ddec:6703:e9ca:42ee', '12345677', '$2y$10$40WkIoHPftfWAQ7DDc9qBO5.0SyL/7TN5S48tLKIDi8JRqfM4o71K', 'fernando@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1696126161, 1706660316, 1, 'fernando', 'fernando', NULL, NULL),
(31, '2806:268:489:8a20:64d8:5f68:bc78:c2ae', '11111111', '$2y$10$dq5kL.KFb/9PlPDxMKyGL.WyMgX6rDPzrJeg6BkIBG5k8hWFOp/mS', 'rolando@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1705951908, 1706646258, 1, 'Rolando', 'Rolando', NULL, NULL),
(32, '2806:268:489:8a20:64d8:5f68:bc78:c2ae', '22222222', '$2y$10$qqhdbE2Vt3myrMkIdorin.vOWudjjPA5NKfB8Hpk9JOD3XlkUnQ/W', 'alvaro@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1705951965, 1705953090, 1, 'Alvaro', 'Alvaro', NULL, NULL),
(33, '2806:268:489:8a20:a085:e24d:92d4:ed10', '12121212', '$2y$10$smUvQYpJsXxFukpMHojUe.OI/G4zfHqv5yuc/3RTcWpSkjK3fv/KO', 'morales@natalia.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1708488855, NULL, 1, 'Natalia', 'Morales', NULL, NULL),
(34, '2806:268:489:8a20:a085:e24d:92d4:ed10', '98989898', '$2y$10$OrRVAZHvabJ0ajvx/oVCZON5wqE7fAFUcczi7vgIPByov2Eskyx.i', 'alvaro@alvaro.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1708489819, NULL, 1, 'alvaro', 'alvaro', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_groups`
--

CREATE TABLE `users_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

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
(36, 34, 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`id_dosen`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `nip` (`nip`),
  ADD KEY `matkul_id` (`matkul_id`);

--
-- Indices de la tabla `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `h_ujian`
--
ALTER TABLE `h_ujian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ujian_id` (`ujian_id`),
  ADD KEY `mahasiswa_id` (`mahasiswa_id`);

--
-- Indices de la tabla `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`id_jurusan`);

--
-- Indices de la tabla `jurusan_matkul`
--
ALTER TABLE `jurusan_matkul`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jurusan_id` (`jurusan_id`),
  ADD KEY `matkul_id` (`matkul_id`);

--
-- Indices de la tabla `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`),
  ADD KEY `jurusan_id` (`jurusan_id`);

--
-- Indices de la tabla `kelas_dosen`
--
ALTER TABLE `kelas_dosen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kelas_id` (`kelas_id`),
  ADD KEY `dosen_id` (`dosen_id`);

--
-- Indices de la tabla `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id_mahasiswa`),
  ADD UNIQUE KEY `nim` (`nim`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `kelas_id` (`kelas_id`);

--
-- Indices de la tabla `matkul`
--
ALTER TABLE `matkul`
  ADD PRIMARY KEY (`id_matkul`);

--
-- Indices de la tabla `m_ujian`
--
ALTER TABLE `m_ujian`
  ADD PRIMARY KEY (`id_ujian`),
  ADD KEY `matkul_id` (`matkul_id`),
  ADD KEY `dosen_id` (`dosen_id`);

--
-- Indices de la tabla `tb_soal`
--
ALTER TABLE `tb_soal`
  ADD PRIMARY KEY (`id_soal`),
  ADD KEY `matkul_id` (`matkul_id`),
  ADD KEY `dosen_id` (`dosen_id`);

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
-- AUTO_INCREMENT de la tabla `dosen`
--
ALTER TABLE `dosen`
  MODIFY `id_dosen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `groups`
--
ALTER TABLE `groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `h_ujian`
--
ALTER TABLE `h_ujian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `jurusan`
--
ALTER TABLE `jurusan`
  MODIFY `id_jurusan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `jurusan_matkul`
--
ALTER TABLE `jurusan_matkul`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id_kelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `kelas_dosen`
--
ALTER TABLE `kelas_dosen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT de la tabla `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id_mahasiswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `matkul`
--
ALTER TABLE `matkul`
  MODIFY `id_matkul` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `m_ujian`
--
ALTER TABLE `m_ujian`
  MODIFY `id_ujian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de la tabla `tb_soal`
--
ALTER TABLE `tb_soal`
  MODIFY `id_soal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `users_groups`
--
ALTER TABLE `users_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `dosen`
--
ALTER TABLE `dosen`
  ADD CONSTRAINT `dosen_ibfk_1` FOREIGN KEY (`matkul_id`) REFERENCES `matkul` (`id_matkul`) ON DELETE CASCADE;

--
-- Filtros para la tabla `h_ujian`
--
ALTER TABLE `h_ujian`
  ADD CONSTRAINT `h_ujian_ibfk_1` FOREIGN KEY (`ujian_id`) REFERENCES `m_ujian` (`id_ujian`) ON DELETE CASCADE,
  ADD CONSTRAINT `h_ujian_ibfk_2` FOREIGN KEY (`mahasiswa_id`) REFERENCES `mahasiswa` (`id_mahasiswa`) ON DELETE CASCADE;

--
-- Filtros para la tabla `jurusan_matkul`
--
ALTER TABLE `jurusan_matkul`
  ADD CONSTRAINT `jurusan_matkul_ibfk_1` FOREIGN KEY (`jurusan_id`) REFERENCES `jurusan` (`id_jurusan`) ON DELETE CASCADE,
  ADD CONSTRAINT `jurusan_matkul_ibfk_2` FOREIGN KEY (`matkul_id`) REFERENCES `matkul` (`id_matkul`) ON DELETE CASCADE;

--
-- Filtros para la tabla `kelas_dosen`
--
ALTER TABLE `kelas_dosen`
  ADD CONSTRAINT `kelas_dosen_ibfk_1` FOREIGN KEY (`dosen_id`) REFERENCES `dosen` (`id_dosen`) ON DELETE CASCADE,
  ADD CONSTRAINT `kelas_dosen_ibfk_2` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id_kelas`) ON DELETE CASCADE;

--
-- Filtros para la tabla `m_ujian`
--
ALTER TABLE `m_ujian`
  ADD CONSTRAINT `m_ujian_ibfk_1` FOREIGN KEY (`dosen_id`) REFERENCES `dosen` (`id_dosen`) ON DELETE CASCADE,
  ADD CONSTRAINT `m_ujian_ibfk_2` FOREIGN KEY (`matkul_id`) REFERENCES `matkul` (`id_matkul`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
