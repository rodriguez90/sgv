-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-03-2019 a las 10:49:51
-- Versión del servidor: 10.1.31-MariaDB
-- Versión de PHP: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sgv`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auth_assignment`
--

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('Candidato', '4', 1551092008);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auth_item`
--

CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('Administrador', 1, 'Acceso copleto al sistema', NULL, NULL, 1551091434, 1551091434),
('Candidato', 1, 'Usuario del tipo candidato', NULL, NULL, 1551091477, 1551091477);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auth_item_child`
--

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auth_rule`
--

CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `canton`
--

CREATE TABLE `canton` (
  `id` int(11) NOT NULL,
  `province_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `canton`
--

INSERT INTO `canton` (`id`, `province_id`, `name`) VALUES
(1, 1, 'ESMERALDAS'),
(2, 1, 'ESMERALDAS'),
(3, 1, 'SAN LORENZO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eleccion`
--

CREATE TABLE `eleccion` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `delivery_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `eleccion`
--

INSERT INTO `eleccion` (`id`, `name`, `delivery_date`) VALUES
(1, 'Democracia Si', '2019-03-22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `junta`
--

CREATE TABLE `junta` (
  `id` int(11) NOT NULL,
  `recinto_eleccion_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `null_vote` int(11) NOT NULL DEFAULT '0',
  `blank_vote` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `junta`
--

INSERT INTO `junta` (`id`, `recinto_eleccion_id`, `name`, `type`, `null_vote`, `blank_vote`) VALUES
(2, 1, 'Junta1', 1, 0, 0),
(3, 1, 'Junta2', 2, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('Da\\User\\Migration\\m000000_000001_create_user_table', 1550316096),
('Da\\User\\Migration\\m000000_000002_create_profile_table', 1550316097),
('Da\\User\\Migration\\m000000_000003_create_social_account_table', 1550316097),
('Da\\User\\Migration\\m000000_000004_create_token_table', 1550316097),
('Da\\User\\Migration\\m000000_000005_add_last_login_at', 1550316097),
('Da\\User\\Migration\\m000000_000006_add_two_factor_fields', 1550316097),
('Da\\User\\Migration\\m000000_000007_enable_password_expiration', 1550316097),
('m000000_000000_base', 1550316094),
('m140506_102106_rbac_init', 1550316115),
('m170907_052038_rbac_add_index_on_auth_assignment_user_id', 1550316115),
('m190218_221350_create_province_table', 1550530673),
('m190218_221607_create_canton_table', 1550530673),
('m190218_223239_create_parroquia_table', 1550530673),
('m190218_225135_create_zona_table', 1550530673),
('m190218_225139_create_recinto_electoral_table', 1550530673),
('m190218_230154_create_eleccion_table', 1550531666),
('m190218_230506_create_persona_table', 1550531666),
('m190218_230647_create_recinto_eleccion_table', 1550533526),
('m190218_231651_create_partido_table', 1550533526),
('m190218_231840_create_postulacion_table', 1550533526),
('m190218_232914_create_voto_table', 1550533825),
('m190307_140234_create_table_juntas', 1551972283),
('m190307_140748_alter_table_voto', 1551972284),
('m190310_181731_alter_table_voto_junta', 1552242133),
('m190313_135055_alter_table_canton_parroquia', 1552486728);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parroquia`
--

CREATE TABLE `parroquia` (
  `id` int(11) NOT NULL,
  `canton_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `parroquia`
--

INSERT INTO `parroquia` (`id`, `canton_id`, `name`, `type`) VALUES
(1, 2, 'Esmeraldas', 1),
(2, 2, '5 de Agosto', 1),
(3, 1, 'SAN MATEO', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partido`
--

CREATE TABLE `partido` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `list` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `number` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `partido`
--

INSERT INTO `partido` (`id`, `name`, `list`, `number`) VALUES
(1, 'PCC', 'B', '2'),
(2, 'PCU', 'A', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gender` char(1) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`id`, `first_name`, `last_name`, `phone_number`, `gender`) VALUES
(1, 'Pedro', 'dsds', '52231415', 'M');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `postulacion`
--

CREATE TABLE `postulacion` (
  `id` int(11) NOT NULL,
  `partido_id` int(11) NOT NULL,
  `candidate_id` int(11) NOT NULL,
  `eleccion_id` int(11) NOT NULL,
  `role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `postulacion`
--

INSERT INTO `postulacion` (`id`, `partido_id`, `candidate_id`, `eleccion_id`, `role`) VALUES
(1, 1, 3, 1, 1),
(2, 2, 4, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profile`
--

CREATE TABLE `profile` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `public_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gravatar_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gravatar_id` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `timezone` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `profile`
--

INSERT INTO `profile` (`user_id`, `name`, `public_email`, `gravatar_email`, `gravatar_id`, `location`, `website`, `timezone`, `bio`) VALUES
(2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'candidato1', 'candidato1@gmail.com', '', 'd41d8cd98f00b204e9800998ecf8427e', '', '', NULL, ''),
(4, 'candidato2', '', '', 'd41d8cd98f00b204e9800998ecf8427e', '', '', NULL, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `province`
--

CREATE TABLE `province` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `province`
--

INSERT INTO `province` (`id`, `name`) VALUES
(1, 'Esmeraldas'),
(2, 'QUITO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recinto_eleccion`
--

CREATE TABLE `recinto_eleccion` (
  `id` int(11) NOT NULL,
  `recinto_id` int(11) NOT NULL,
  `coordinator_jr_man` int(11) NOT NULL,
  `coordinator_jr_woman` int(11) NOT NULL,
  `eleccion_id` int(11) NOT NULL,
  `jr_woman` int(11) DEFAULT NULL,
  `jr_man` int(11) DEFAULT NULL,
  `count_elector` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `recinto_eleccion`
--

INSERT INTO `recinto_eleccion` (`id`, `recinto_id`, `coordinator_jr_man`, `coordinator_jr_woman`, `eleccion_id`, `jr_woman`, `jr_man`, `count_elector`) VALUES
(1, 1, 1, 1, 1, 5, 5, 25),
(2, 2, 1, 1, 1, 3, 3, 100);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recinto_electoral`
--

CREATE TABLE `recinto_electoral` (
  `id` int(11) NOT NULL,
  `zona_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `recinto_electoral`
--

INSERT INTO `recinto_electoral` (`id`, `zona_id`, `name`, `address`) VALUES
(1, 1, 'ESCUELA HISPANO AMÉRICA', 'Alguna dirección'),
(2, 1, 'Unidad Educativa 21 de Septiembre', 'Alguna dirección');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `social_account`
--

CREATE TABLE `social_account` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `client_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `token`
--

CREATE TABLE `token` (
  `user_id` int(11) DEFAULT NULL,
  `code` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `unconfirmed_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `registration_ip` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `flags` int(11) NOT NULL DEFAULT '0',
  `confirmed_at` int(11) DEFAULT NULL,
  `blocked_at` int(11) DEFAULT NULL,
  `updated_at` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `last_login_at` int(11) DEFAULT NULL,
  `auth_tf_key` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `auth_tf_enabled` tinyint(1) DEFAULT '0',
  `password_changed_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password_hash`, `auth_key`, `unconfirmed_email`, `registration_ip`, `flags`, `confirmed_at`, `blocked_at`, `updated_at`, `created_at`, `last_login_at`, `auth_tf_key`, `auth_tf_enabled`, `password_changed_at`) VALUES
(2, 'root', 'root@test.com', '$2y$10$HNH5JlhNXcWX./4vw.00eepvv476ZE/xGRt6mJvIEBwnuZKNLhDoa', 'dZXC6tDMSYd8xV_mtd3qNiwTeZe422ek', NULL, NULL, 0, 1550966991, NULL, 1550966991, 1550966991, 1550967072, '', 0, 1550966991),
(3, 'candidato1', 'candidato1@gmail.com', '$2y$10$TAXCkkpOYh1BhHzMAF2SoeYV.q/oY4a/mv83TbKZ.WXgkrcItLjU6', '1AoPSfYMef5p8PcVMnbb7zwx2Z6B8gOo', NULL, '::1', 0, 1551091374, NULL, 1551091374, 1551091374, NULL, '', 0, 1551091374),
(4, 'candidato2', 'candidato2@gmail.com', '$2y$10$ImPxt4Owznu7iFKuN6CftOYvkl6RIUUmqAws9mWRqMUjalhGRFbiW', 'KlEJtmA5XX1eiPpGzEkJ3QGLenrUAsum', NULL, '::1', 0, 1551091869, NULL, 1551091869, 1551091869, NULL, '', 0, 1551091869);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `voto`
--

CREATE TABLE `voto` (
  `id` int(11) NOT NULL,
  `postulacion_id` int(11) NOT NULL,
  `junta_id` int(11) NOT NULL,
  `vote` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `voto`
--

INSERT INTO `voto` (`id`, `postulacion_id`, `junta_id`, `vote`, `user_id`) VALUES
(4, 1, 2, 24, 2),
(7, 2, 3, 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zona`
--

CREATE TABLE `zona` (
  `id` int(11) NOT NULL,
  `parroquia_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `zona`
--

INSERT INTO `zona` (`id`, `parroquia_id`, `name`) VALUES
(1, 1, 'IGLESIA CATEGRAL');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`),
  ADD KEY `auth_assignment_user_id_idx` (`user_id`);

--
-- Indices de la tabla `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `idx-auth_item-type` (`type`);

--
-- Indices de la tabla `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Indices de la tabla `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Indices de la tabla `canton`
--
ALTER TABLE `canton`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_canton_province` (`province_id`);

--
-- Indices de la tabla `eleccion`
--
ALTER TABLE `eleccion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `junta`
--
ALTER TABLE `junta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_junta_recinto_eleccion` (`recinto_eleccion_id`);

--
-- Indices de la tabla `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indices de la tabla `parroquia`
--
ALTER TABLE `parroquia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_parroquia_canton` (`canton_id`);

--
-- Indices de la tabla `partido`
--
ALTER TABLE `partido`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `postulacion`
--
ALTER TABLE `postulacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_postulacion_partido` (`partido_id`),
  ADD KEY `fk_postulacion_eleccion` (`eleccion_id`),
  ADD KEY `fk_postulacion_candidate` (`candidate_id`);

--
-- Indices de la tabla `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`user_id`);

--
-- Indices de la tabla `province`
--
ALTER TABLE `province`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `recinto_eleccion`
--
ALTER TABLE `recinto_eleccion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_recinto_eleccion_recinto` (`recinto_id`),
  ADD KEY `fk_recinto_eleccion_coordinador_m` (`coordinator_jr_man`),
  ADD KEY `fk_recinto_eleccion_coordinador_w` (`coordinator_jr_woman`),
  ADD KEY `fk_recinto_eleccion_eleccion` (`eleccion_id`);

--
-- Indices de la tabla `recinto_electoral`
--
ALTER TABLE `recinto_electoral`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_recinto_electoral_zona` (`zona_id`);

--
-- Indices de la tabla `social_account`
--
ALTER TABLE `social_account`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_social_account_provider_client_id` (`provider`,`client_id`),
  ADD UNIQUE KEY `idx_social_account_code` (`code`),
  ADD KEY `fk_social_account_user` (`user_id`);

--
-- Indices de la tabla `token`
--
ALTER TABLE `token`
  ADD UNIQUE KEY `idx_token_user_id_code_type` (`user_id`,`code`,`type`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_user_username` (`username`),
  ADD UNIQUE KEY `idx_user_email` (`email`);

--
-- Indices de la tabla `voto`
--
ALTER TABLE `voto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_voto_postulacion` (`postulacion_id`),
  ADD KEY `fk_vote_junta` (`junta_id`),
  ADD KEY `fk_vote_user` (`user_id`);

--
-- Indices de la tabla `zona`
--
ALTER TABLE `zona`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_zona_parroquia` (`parroquia_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `canton`
--
ALTER TABLE `canton`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `eleccion`
--
ALTER TABLE `eleccion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `junta`
--
ALTER TABLE `junta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `parroquia`
--
ALTER TABLE `parroquia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `partido`
--
ALTER TABLE `partido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `postulacion`
--
ALTER TABLE `postulacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `profile`
--
ALTER TABLE `profile`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `province`
--
ALTER TABLE `province`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `recinto_eleccion`
--
ALTER TABLE `recinto_eleccion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `recinto_electoral`
--
ALTER TABLE `recinto_electoral`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `social_account`
--
ALTER TABLE `social_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `voto`
--
ALTER TABLE `voto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `zona`
--
ALTER TABLE `zona`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `canton`
--
ALTER TABLE `canton`
  ADD CONSTRAINT `fk_canton_province` FOREIGN KEY (`province_id`) REFERENCES `province` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `junta`
--
ALTER TABLE `junta`
  ADD CONSTRAINT `fk_junta_recinto_eleccion` FOREIGN KEY (`recinto_eleccion_id`) REFERENCES `recinto_eleccion` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `parroquia`
--
ALTER TABLE `parroquia`
  ADD CONSTRAINT `fk_parroquia_canton` FOREIGN KEY (`canton_id`) REFERENCES `canton` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `postulacion`
--
ALTER TABLE `postulacion`
  ADD CONSTRAINT `fk_postulacion_candidate` FOREIGN KEY (`candidate_id`) REFERENCES `profile` (`user_id`),
  ADD CONSTRAINT `fk_postulacion_eleccion` FOREIGN KEY (`eleccion_id`) REFERENCES `eleccion` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_postulacion_partido` FOREIGN KEY (`partido_id`) REFERENCES `partido` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `fk_profile_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `recinto_eleccion`
--
ALTER TABLE `recinto_eleccion`
  ADD CONSTRAINT `fk_recinto_eleccion_coordinador_m` FOREIGN KEY (`coordinator_jr_man`) REFERENCES `persona` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_recinto_eleccion_coordinador_w` FOREIGN KEY (`coordinator_jr_woman`) REFERENCES `persona` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_recinto_eleccion_eleccion` FOREIGN KEY (`eleccion_id`) REFERENCES `eleccion` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_recinto_eleccion_recinto` FOREIGN KEY (`recinto_id`) REFERENCES `recinto_electoral` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `recinto_electoral`
--
ALTER TABLE `recinto_electoral`
  ADD CONSTRAINT `fk_recinto_electoral_zona` FOREIGN KEY (`zona_id`) REFERENCES `zona` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `social_account`
--
ALTER TABLE `social_account`
  ADD CONSTRAINT `fk_social_account_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `token`
--
ALTER TABLE `token`
  ADD CONSTRAINT `fk_token_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `voto`
--
ALTER TABLE `voto`
  ADD CONSTRAINT `fk_vote_junta` FOREIGN KEY (`junta_id`) REFERENCES `junta` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_vote_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_voto_postulacion` FOREIGN KEY (`postulacion_id`) REFERENCES `postulacion` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `zona`
--
ALTER TABLE `zona`
  ADD CONSTRAINT `fk_zona_parroquia` FOREIGN KEY (`parroquia_id`) REFERENCES `parroquia` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
