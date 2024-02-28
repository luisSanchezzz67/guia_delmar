/*
Navicat MySQL Data Transfer

Source Server         : Localhost
Source Server Version : 100406
Source Host           : localhost:3306
Source Database       : db_sistema_escolar

Target Server Type    : MYSQL
Target Server Version : 100406
File Encoding         : 65001

Date: 2021-08-05 16:37:47
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for grupos
-- ----------------------------
DROP TABLE IF EXISTS `grupos`;
CREATE TABLE `grupos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero` varchar(8) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `horario` varchar(255) DEFAULT NULL,
  `creado` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of grupos
-- ----------------------------
INSERT INTO `grupos` VALUES ('2', '280806', 'Primaria Primero B', 'Grupo de primaria B.', '6a0oskzztvhb-xmhbvb51punb-xdwizckq4sym.jpg', '2021-06-28 16:09:26');
INSERT INTO `grupos` VALUES ('3', '252536', 'Primaria Segundo A', 'un grupo nuevo.', null, '2021-07-05 16:06:06');
INSERT INTO `grupos` VALUES ('4', '640079', 'Universidad 1°', 'Alumnos de primer ingreso de universidad.', 'njgeuh37glyq-n3shhpadm8ad-yem0rwbtyqei.jpg', '2021-07-16 12:46:38');
INSERT INTO `grupos` VALUES ('5', '146570', 'Universidad 2°', 'Segundo grado de universidad', 'xwuvrgvpddiy-wtp1brwd5wow-wpc7wnmksbk5.jpg', '2021-07-16 12:46:49');
INSERT INTO `grupos` VALUES ('6', '516134', 'Universidad 3°', 'Tercer año de universidad.', 'ddyrs18vbltq-2hod2u9u2sgg-5xwmy7384tfe.jpg', '2021-07-16 12:46:58');

-- ----------------------------
-- Table structure for grupos_alumnos
-- ----------------------------
DROP TABLE IF EXISTS `grupos_alumnos`;
CREATE TABLE `grupos_alumnos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_grupo` int(11) NOT NULL DEFAULT 0,
  `id_alumno` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of grupos_alumnos
-- ----------------------------
INSERT INTO `grupos_alumnos` VALUES ('6', '3', '10');
INSERT INTO `grupos_alumnos` VALUES ('7', '3', '11');
INSERT INTO `grupos_alumnos` VALUES ('10', '3', '14');
INSERT INTO `grupos_alumnos` VALUES ('11', '2', '6');
INSERT INTO `grupos_alumnos` VALUES ('12', '2', '7');
INSERT INTO `grupos_alumnos` VALUES ('13', '4', '15');
INSERT INTO `grupos_alumnos` VALUES ('14', '5', '16');
INSERT INTO `grupos_alumnos` VALUES ('15', '6', '17');

-- ----------------------------
-- Table structure for grupos_materias
-- ----------------------------
DROP TABLE IF EXISTS `grupos_materias`;
CREATE TABLE `grupos_materias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_grupo` int(11) NOT NULL DEFAULT 0,
  `id_mp` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of grupos_materias
-- ----------------------------
INSERT INTO `grupos_materias` VALUES ('12', '2', '23');
INSERT INTO `grupos_materias` VALUES ('13', '2', '30');
INSERT INTO `grupos_materias` VALUES ('14', '2', '25');
INSERT INTO `grupos_materias` VALUES ('15', '3', '23');
INSERT INTO `grupos_materias` VALUES ('16', '3', '25');
INSERT INTO `grupos_materias` VALUES ('17', '3', '24');
INSERT INTO `grupos_materias` VALUES ('18', '3', '26');
INSERT INTO `grupos_materias` VALUES ('19', '3', '30');
INSERT INTO `grupos_materias` VALUES ('20', '2', '24');
INSERT INTO `grupos_materias` VALUES ('21', '2', '26');
INSERT INTO `grupos_materias` VALUES ('22', '3', '31');
INSERT INTO `grupos_materias` VALUES ('23', '4', '23');
INSERT INTO `grupos_materias` VALUES ('24', '4', '26');
INSERT INTO `grupos_materias` VALUES ('25', '4', '39');
INSERT INTO `grupos_materias` VALUES ('26', '4', '35');
INSERT INTO `grupos_materias` VALUES ('27', '4', '32');
INSERT INTO `grupos_materias` VALUES ('28', '5', '31');
INSERT INTO `grupos_materias` VALUES ('29', '5', '38');
INSERT INTO `grupos_materias` VALUES ('30', '5', '30');
INSERT INTO `grupos_materias` VALUES ('31', '5', '34');
INSERT INTO `grupos_materias` VALUES ('32', '5', '37');
INSERT INTO `grupos_materias` VALUES ('33', '6', '35');
INSERT INTO `grupos_materias` VALUES ('34', '6', '32');
INSERT INTO `grupos_materias` VALUES ('35', '6', '40');
INSERT INTO `grupos_materias` VALUES ('36', '6', '23');
INSERT INTO `grupos_materias` VALUES ('37', '6', '26');

-- ----------------------------
-- Table structure for lecciones
-- ----------------------------
DROP TABLE IF EXISTS `lecciones`;
CREATE TABLE `lecciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_materia` int(11) NOT NULL DEFAULT 0,
  `id_profesor` int(11) NOT NULL DEFAULT 0,
  `titulo` varchar(255) DEFAULT NULL,
  `video` text DEFAULT NULL,
  `contenido` text DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `fecha_disponible` datetime DEFAULT NULL,
  `creado` datetime DEFAULT NULL,
  `actualizado` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lecciones
-- ----------------------------
INSERT INTO `lecciones` VALUES ('1', '3', '2', 'Historia de PHP', null, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Sollicitudin nibh sit amet commodo nulla facilisi. Nulla facilisi cras fermentum odio eu feugiat pretium nibh. In hac habitasse platea dictumst quisque sagittis. Leo duis ut diam quam nulla porttitor. Ut sem nulla pharetra diam sit amet. Ipsum nunc aliquet bibendum enim facilisis gravida neque convallis a. Eget mi proin sed libero enim sed. Libero volutpat sed cras ornare arcu dui. Eu facilisis sed odio morbi quis commodo odio aenean. Amet commodo nulla facilisi nullam vehicula ipsum a arcu. Ultrices dui sapien eget mi proin sed libero enim. Eu nisl nunc mi ipsum faucibus. Nulla pharetra diam sit amet nisl suscipit adipiscing bibendum.\r\n\r\nEtiam sit amet nisl purus. Pretium nibh ipsum consequat nisl vel pretium. Nulla pharetra diam sit amet nisl suscipit adipiscing bibendum. Arcu risus quis varius quam quisque id diam vel quam. Vulputate mi sit amet mauris commodo quis imperdiet massa tincidunt. Nec ullamcorper sit amet risus nullam eget felis. Libero enim sed faucibus turpis in. Nulla facilisi nullam vehicula ipsum a arcu cursus vitae. Et netus et malesuada fames ac turpis egestas maecenas pharetra. Neque volutpat ac tincidunt vitae semper quis lectus. Id neque aliquam vestibulum morbi. Orci porta non pulvinar neque laoreet suspendisse interdum consectetur libero. Fusce ut placerat orci nulla pellentesque. Id aliquet lectus proin nibh nisl condimentum.\r\n\r\nTempus imperdiet nulla malesuada pellentesque elit eget gravida cum sociis. Luctus accumsan tortor posuere ac. Sit amet nisl purus in mollis nunc sed id semper. Enim eu turpis egestas pretium aenean pharetra magna ac placerat. Mauris augue neque gravida in. Rhoncus dolor purus non enim praesent elementum facilisis leo. Cras ornare arcu dui vivamus arcu felis. Interdum velit euismod in pellentesque massa placerat duis. Purus non enim praesent elementum facilisis. Suspendisse faucibus interdum posuere lorem ipsum dolor. Quis eleifend quam adipiscing vitae proin sagittis nisl. Adipiscing vitae proin sagittis nisl rhoncus mattis rhoncus. Faucibus et molestie ac feugiat. Risus commodo viverra maecenas accumsan lacus vel facilisis volutpat est. Consequat interdum varius sit amet mattis. Varius morbi enim nunc faucibus.\r\n\r\nSollicitudin tempor id eu nisl nunc mi ipsum faucibus. Cursus risus at ultrices mi tempus imperdiet. Facilisis leo vel fringilla est ullamcorper eget nulla facilisi. Neque aliquam vestibulum morbi blandit cursus risus. Turpis egestas sed tempus urna et pharetra. Tincidunt vitae semper quis lectus. Libero justo laoreet sit amet cursus sit amet. Aliquam eleifend mi in nulla posuere. Turpis egestas maecenas pharetra convallis posuere morbi leo. Morbi tempus iaculis urna id volutpat lacus laoreet non curabitur. In hac habitasse platea dictumst. Purus gravida quis blandit turpis cursus in. Non arcu risus quis varius. Cursus turpis massa tincidunt dui ut. Phasellus egestas tellus rutrum tellus pellentesque eu.\r\n\r\nQuam id leo in vitae turpis massa sed elementum. Ligula ullamcorper malesuada proin libero nunc consequat interdum. Pretium nibh ipsum consequat nisl vel pretium lectus quam. Amet porttitor eget dolor morbi non arcu risus quis varius. Fermentum posuere urna nec tincidunt praesent semper feugiat nibh sed. Massa tincidunt dui ut ornare lectus. Id volutpat lacus laoreet non curabitur. Laoreet suspendisse interdum consectetur libero. Convallis convallis tellus id interdum velit laoreet id donec ultrices. Tristique et egestas quis ipsum suspendisse ultrices. Aliquet eget sit amet tellus cras adipiscing. Nunc consequat interdum varius sit amet mattis vulputate enim. Faucibus purus in massa tempor nec feugiat. Imperdiet sed euismod nisi porta lorem mollis aliquam ut.', 'publica', '2021-07-19 15:17:58', '2021-07-16 15:18:06', '2021-07-16 15:29:51');
INSERT INTO `lecciones` VALUES ('2', '2', '2', 'La sintaxis de CSS3 editado', '', 'Lorem ipsum dolor sit amet consectetur adipiscing elit faucibus himenaeos cursus praesent, tortor turpis ultricies gravida morbi tellus viverra neque imperdiet curabitur. Diam purus dui faucibus enim mus tempus facilisis penatibus pharetra vulputate sagittis venenatis nec, lobortis aliquet lacus sociis laoreet neque dictum justo mauris eget hac.\r\n\r\nTempor sociosqu curabitur dis accumsan posuere urna augue, a dignissim magnis quisque hendrerit nullam metus, senectus mollis fringilla nostra porta gravida. Maecenas vel bibendum litora nibh sociis diam malesuada tempor est, molestie imperdiet congue fusce justo habitasse eu aptent ornare, hac vulputate commodo tempus egestas dignissim at donec. Urna lectus senectus volutpat dictum donec fames, suspendisse risus conubia curabitur nibh, montes sagittis cras velit varius.\r\n\r\nSem convallis himenaeos cum suscipit dignissim volutpat, natoque etiam magnis nostra lobortis at nascetur, taciti luctus aenean pulvinar felis. Ligula tortor nullam quam viverra sollicitudin libero velit, sapien potenti id habitant montes suscipit, ante mus pellentesque tristique nulla ad. Lectus sodales sapien eleifend malesuada torquent nam tristique curae aenean senectus, maecenas tortor faucibus in enim erat feugiat proin per libero imperdiet, convallis felis elementum suscipit himenaeos est posuere cum primis. Fringilla ad elementum tincidunt accumsan hendrerit laoreet semper ullamcorper nostra, eleifend id curae luctus aliquet consequat lectus mattis, at ornare dapibus sollicitudin porttitor montes iaculis vulputate.\r\n\r\nMauris tristique id iaculis quisque rutrum enim ultricies sed litora porta imperdiet, tellus habitant mi ante bibendum sollicitudin nascetur taciti nunc. Vulputate nullam commodo praesent malesuada quisque aliquet leo cum lacus, erat scelerisque luctus dictumst eros ultrices tristique magna massa magnis, sagittis sollicitudin cras dictum porttitor netus diam penatibus. Potenti hac taciti erat massa quis molestie blandit viverra, rhoncus lacinia tortor commodo tincidunt inceptos conubia a, imperdiet non augue ut vivamus laoreet sagittis.', 'publica', '2021-07-20 00:00:00', '2021-07-16 15:29:09', '2021-08-05 16:27:04');
INSERT INTO `lecciones` VALUES ('3', '2', '2', 'Selectores css3 básicos editado', 'https://youtu.be/0mcOVFjj_CA', 'Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una galería de textos y los mezcló de tal manera que logró hacer un libro de textos especimen. No sólo sobrevivió 500 años, sino que tambien ingresó como texto de relleno en documentos electrónicos, quedando esencialmente igual al original. Fue popularizado en los 60s con la creación de las hojas &quot;Letraset&quot;, las cuales contenian pasajes de Lorem Ipsum, y más recientemente con software de autoedición, como por ejemplo Aldus PageMaker, el cual incluye versiones de Lorem Ipsum.', 'borrador', '2021-08-21 00:00:00', '2021-08-05 15:04:50', '2021-08-05 16:27:18');
INSERT INTO `lecciones` VALUES ('4', '2', '2', 'Estilos básicos para elementos bloque', '', 'Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una galería de textos y los mezcló de tal manera que logró hacer un libro de textos especimen. No sólo sobrevivió 500 años, sino que tambien ingresó como texto de relleno en documentos electrónicos, quedando esencialmente igual al original. Fue popularizado en los 60s con la creación de las hojas &quot;Letraset&quot;, las cuales contenian pasajes de Lorem Ipsum, y más recientemente con software de autoedición, como por ejemplo Aldus PageMaker, el cual incluye versiones de Lorem Ipsum.', 'borrador', '2021-08-21 00:00:00', '2021-08-05 15:08:20', null);
INSERT INTO `lecciones` VALUES ('5', '7', '2', 'Continentes del mundo', 'https://youtu.be/0mcOVFjj_CA', 'Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una galería de textos y los mezcló de tal manera que logró hacer un libro de textos especimen. No sólo sobrevivió 500 años, sino que tambien ingresó como texto de relleno en documentos electrónicos, quedando esencialmente igual al original. Fue popularizado en los 60s con la creación de las hojas &quot;Letraset&quot;, las cuales contenian pasajes de Lorem Ipsum, y más recientemente con software de autoedición, como por ejemplo Aldus PageMaker, el cual incluye versiones de Lorem Ipsum.&lt;b&gt;esto es bold&lt;/b&gt;', 'borrador', '2021-08-14 00:00:00', '2021-08-05 15:22:03', null);

-- ----------------------------
-- Table structure for materias
-- ----------------------------
DROP TABLE IF EXISTS `materias`;
CREATE TABLE `materias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `creado` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of materias
-- ----------------------------
INSERT INTO `materias` VALUES ('1', 'HTML5 I', 'Descripción de la materia.', '2021-06-08 12:08:10');
INSERT INTO `materias` VALUES ('2', 'CSS3 I', 'Descripción de la materia.', '2021-06-08 12:10:11');
INSERT INTO `materias` VALUES ('3', 'PHP Básico I', 'Nueva descripción.', '2021-06-08 12:15:20');
INSERT INTO `materias` VALUES ('5', 'Diseño Gráfico 1', '', '2021-07-16 12:47:48');
INSERT INTO `materias` VALUES ('6', 'Figura Humana', '', '2021-07-16 12:47:55');
INSERT INTO `materias` VALUES ('7', 'Geografía', '', '2021-07-16 12:47:58');
INSERT INTO `materias` VALUES ('8', 'Matemáticas', '', '2021-07-16 12:48:02');
INSERT INTO `materias` VALUES ('9', 'Historia', '', '2021-07-16 12:48:15');
INSERT INTO `materias` VALUES ('10', 'Español', '', '2021-07-16 12:48:19');
INSERT INTO `materias` VALUES ('11', 'Educación financiera', '', '2021-07-16 12:48:31');

-- ----------------------------
-- Table structure for materias_profesores
-- ----------------------------
DROP TABLE IF EXISTS `materias_profesores`;
CREATE TABLE `materias_profesores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_materia` int(11) NOT NULL DEFAULT 0,
  `id_profesor` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of materias_profesores
-- ----------------------------
INSERT INTO `materias_profesores` VALUES ('23', '1', '3');
INSERT INTO `materias_profesores` VALUES ('24', '1', '2');
INSERT INTO `materias_profesores` VALUES ('25', '2', '2');
INSERT INTO `materias_profesores` VALUES ('26', '3', '2');
INSERT INTO `materias_profesores` VALUES ('30', '3', '3');
INSERT INTO `materias_profesores` VALUES ('31', '2', '3');
INSERT INTO `materias_profesores` VALUES ('32', '5', '5');
INSERT INTO `materias_profesores` VALUES ('33', '3', '5');
INSERT INTO `materias_profesores` VALUES ('34', '11', '5');
INSERT INTO `materias_profesores` VALUES ('35', '8', '3');
INSERT INTO `materias_profesores` VALUES ('36', '9', '3');
INSERT INTO `materias_profesores` VALUES ('37', '7', '2');
INSERT INTO `materias_profesores` VALUES ('38', '6', '2');
INSERT INTO `materias_profesores` VALUES ('39', '9', '5');
INSERT INTO `materias_profesores` VALUES ('40', '10', '5');

-- ----------------------------
-- Table structure for posts
-- ----------------------------
DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(100) DEFAULT NULL,
  `id_ref` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `contenido` longtext DEFAULT NULL,
  `permalink` text DEFAULT NULL,
  `creado` datetime DEFAULT NULL,
  `actualizado` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of posts
-- ----------------------------
INSERT INTO `posts` VALUES ('1', 'token_recuperacion', '0', '1', 'Token de recuperación de contraseña', 'b89332ab5645ebc2982265a21a8a2018660514d0be7f94f5f0c9a681ba58e540', 'http://localhost:8848/cursos/sistema_escolar/login/password?hook=aprende&action=doing-task&id=1&token=b89332ab5645ebc2982265a21a8a2018660514d0be7f94f5f0c9a681ba58e540', '2021-07-06 16:29:56', null);

-- ----------------------------
-- Table structure for usuarios
-- ----------------------------
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero` varchar(8) DEFAULT NULL,
  `nombres` varchar(100) DEFAULT NULL,
  `apellidos` varchar(100) DEFAULT NULL,
  `nombre_completo` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `hash` varchar(255) DEFAULT NULL,
  `rol` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `creado` datetime DEFAULT NULL,
  `actualizado` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of usuarios
-- ----------------------------
INSERT INTO `usuarios` VALUES ('1', '112233', 'Bee', 'Default', 'Bee Default', 'jslocal@localhost.com', '$2y$10$5O.0Nqod79ME0AfQeEIE0O2sfDwdoHo.uM/kWL4Xn0paauQNjwTH.', '1122334455', 'asfasfdasdfasdfasdfasd', 'root', 'activo', '2021-06-04 10:51:30', '2021-07-15 13:22:21');
INSERT INTO `usuarios` VALUES ('2', '223344', 'Profesor', 'Jhon', 'Profesor Jhon', 'jslocal3@localhost.com', '$2y$10$5O.0Nqod79ME0AfQeEIE0O2sfDwdoHo.uM/kWL4Xn0paauQNjwTH.', '22445566', 'sdfasdfasdfa341234143', 'profesor', 'activo', null, '2021-07-16 12:45:21');
INSERT INTO `usuarios` VALUES ('3', '275293', 'Profesor', 'Pancho', 'Profesor Pancho', 'jslocal@localhost.com', '$2y$10$22EHPy5CGREx/cR1tmzHHur7c1ayKiHqDMjukPehhmXivc5CJbghC', '', '8a7abeef6ebc1f241daea8d2dfc4b0c50e0f6395a4a1f0fcefee966a65fbd05c', 'profesor', 'pendiente', '2021-06-10 15:46:10', '2021-07-16 12:45:34');
INSERT INTO `usuarios` VALUES ('5', '125742', 'Profesor', 'Bobby', 'Profesor Bobby', 'jslocal@localhost.com', '$2y$10$5O.0Nqod79ME0AfQeEIE0O2sfDwdoHo.uM/kWL4Xn0paauQNjwTH.', null, 'b031b2d118324f662e68d20a154421c59278f73d9bc1e00835b4c901f09f24e9', 'profesor', 'pendiente', '2021-06-16 11:04:30', '2021-07-15 16:42:24');
INSERT INTO `usuarios` VALUES ('6', '556677', 'Alumno', 'Cools', 'Alumno Cools', 'jslocal4@localhost.com', '$2y$10$R18ASm3k90ln7SkPPa7kLObcRCYl7SvIPCPtnKMawDhOT6wPXVxTS', '', 'asdfa4a4f45ytsdfgsdfg', 'alumno', 'activo', '2021-06-30 16:45:13', '2021-07-15 16:42:34');
INSERT INTO `usuarios` VALUES ('7', '665577', 'Alumno', 'Nuevo', 'Alumno Nuevo', 'jslocal5@localhost.com', '$2y$10$R18ASm3k90ln7SkPPa7kLObcRCYl7SvIPCPtnKMawDhOT6wPXVxTS', '', 'asdfas8df7a64sdf7asd', 'alumno', 'activo', '2021-06-30 16:48:27', '2021-07-16 12:16:16');
INSERT INTO `usuarios` VALUES ('10', '942111', 'Johnn', 'Alumno', 'Johnn Alumno', 'jslocal@localhost.com', '$2y$10$jIrR88KX85GCY4iNGxUb4e/Z.hQ8LxaT.BwPtTG73RxD5IxU6jpae', '11223344', 'f843ecc4d282b14f6624b03c73e3ab8659fad3ec6fbc19a47e7ceab005c75baa', 'alumno', 'pendiente', '2021-07-05 16:28:40', '2021-07-05 16:32:26');
INSERT INTO `usuarios` VALUES ('11', '494275', 'Donatelo', 'Roberto', 'Donatelo Roberto', 'jslocal2@localhost.com', '$2y$10$62y7KnA1anHUyM8iMlHa5uDkK7QD33IpPK7wHXTSPOw9zdtmvFkbu', '123456', 'bf561add1e5a8ee85cd6ecca37d2652987472c0a5a7898e1e164cecc4c1d63fe', 'alumno', 'pendiente', '2021-07-05 16:33:25', null);
INSERT INTO `usuarios` VALUES ('14', '633176', 'Lucerito Editado', 'Ortega', 'Lucerito Editado Ortega', 'jslocal@localhost.com', '$2y$10$ajNN7/UBwtfzVFUudWu3dejKSN2qYyZTAnOoIx5E54WYSHHIsxowK', '11223344', '77056fe4dfbc1db565ced0e429413b0b6b6f19cd77fbc2ff1523d00eaa9f55d6', 'alumno', 'pendiente', '2021-07-06 13:25:26', '2021-07-06 13:39:10');
INSERT INTO `usuarios` VALUES ('15', '779542', 'Alumno', 'Universidad 1', 'Alumno Universidad 1', 'jslocal11@localhost.com', '$2y$10$tm8oCq3YYLdUwfACUkACSeltXKU9qYxClR.D7/hQ7fs029x6CcNWq', '', 'd561f34bfc1352ce991d8c5beee425953663e3cb0ccb933415609a159ae25457', 'alumno', 'activo', '2021-07-16 12:55:10', '2021-07-16 13:04:12');
INSERT INTO `usuarios` VALUES ('16', '618780', 'Alumno', 'Universidad 2', 'Alumno Universidad 2', 'jslocal12@localhost.com', '$2y$10$HbG/P68nOuLtKcgqbYJ4G.tX50v/zg1uZ7MHXB.uijOQqULNWquWa', '', '35714589f31589259f6ebc4411fe755b97a6b627e40bf27747b1060c50cdcb61', 'alumno', 'activo', '2021-07-16 12:55:36', '2021-07-16 13:04:12');
INSERT INTO `usuarios` VALUES ('17', '198735', 'Alumno', 'Universidad 3', 'Alumno Universidad 3', 'jslocal13@localhost.com', '$2y$10$lBNaSm6YKDl8GAL1hcT/1usGo8Ax9Pa/CnKwUtuQ2RrQ0/GtXuIaW', '', '7d73dc245808aaaa7e4ed6a477abf10c1e1255c83b5a84936b2e5b44562506c0', 'alumno', 'activo', '2021-07-16 13:02:32', '2021-07-16 13:04:12');
