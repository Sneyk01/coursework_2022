-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Янв 13 2023 г., 16:50
-- Версия сервера: 5.7.36
-- Версия PHP: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `kpp_coursework`
--

-- --------------------------------------------------------

--
-- Структура таблицы `admin_table`
--

DROP TABLE IF EXISTS `admin_table`;
CREATE TABLE IF NOT EXISTS `admin_table` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `salt` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `admin_table`
--

INSERT INTO `admin_table` (`id`, `login`, `password`, `salt`, `token`, `time`) VALUES
(1, 'admin', '866c9a454e9a553c50286863da98ec84', '4nEJ3rp39D', 'V2kQAXtyxFdEE0Y73P5Q', 1673624610);

-- --------------------------------------------------------

--
-- Структура таблицы `parameters`
--

DROP TABLE IF EXISTS `parameters`;
CREATE TABLE IF NOT EXISTS `parameters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Value` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `parameters`
--

INSERT INTO `parameters` (`id`, `Name`, `Value`) VALUES
(1, 'token_time', '3600'),
(2, 'visitors_time', '86400');

-- --------------------------------------------------------

--
-- Структура таблицы `resident_table`
--

DROP TABLE IF EXISTS `resident_table`;
CREATE TABLE IF NOT EXISTS `resident_table` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `car_numbers` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `house_number` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telegram_id` varchar(9) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret_key` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `resident_table`
--

INSERT INTO `resident_table` (`id`, `first_name`, `last_name`, `car_numbers`, `house_number`, `telegram_id`, `secret_key`) VALUES
(14, 'Глеб', 'Прохоров', 'с202рх;х765ур', '8', '800457635', ''),
(15, 'Полина', 'Прохорова', 'а888бу', '9', '', 'Z8HT2lGZYg'),
(6, 'Роман', 'Романов', 'з878рм', '23', '', '1234567890'),
(7, 'Иван', 'Иванов', 'к435ул', '5а', '', '5Cp8vAM6st'),
(8, 'Гена', 'Лукин', 'г102лу', '23', '', 'Op4ZLchQfZ'),
(11, 'Екатерина', 'Кукушкина', 'е341ку', '73', '', 'P8NVKOSjJX'),
(10, 'Ваня', 'Лукин', 'г105рв', '23', '', 'XYrIToCehu'),
(21, '2', '1', '1111111', '1', '', 'LcE9y8pAzK'),
(13, 'Аня', 'Ракушкина', 'т000ст', '15', '', 'd6PDphu=aK'),
(20, '1', '1', '11', '1', '', 'rpooujhhRR'),
(23, 'Новый', 'резидент', 'н333нт', '1а', '', 'ZdSn1wHbYH'),
(25, 'Ирина', 'Ершова', 'и126ва', '12б', '', 'PfxkOeevl4'),
(28, 'Михаил', 'Крюков', 'м760кр', '17', '', 'ffffffffff'),
(29, 'Марина', 'Абрамова', 'м444аб;р154мо', '4', '', 'QR3DvLeP7v');

-- --------------------------------------------------------

--
-- Структура таблицы `visitors_table`
--

DROP TABLE IF EXISTS `visitors_table`;
CREATE TABLE IF NOT EXISTS `visitors_table` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `car_number` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `inviting_id` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creation_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `visitors_table`
--

INSERT INTO `visitors_table` (`id`, `car_number`, `inviting_id`, `creation_time`) VALUES
(1, 'р203ша', '1', 11111),
(2, ' е321лп', '2', 1671305718),
(3, ' Н123ра', '2', 1671305972),
(4, ' р456ол', '2', 1671306033),
(6, ' г668ла', '5', 1671364888),
(37, ' м777чп', '14', 1673472132),
(15, ' т222ст', 'Администратор', 1673025172),
(16, ' т223ст', 'Администратор', 1673025274),
(17, ' т224ст', 'Администратор', 1673025414),
(18, ' т225ст', 'Администратор', 1673025527),
(36, ' к123рг', '14', 1673462510),
(21, ' тест1', 'Администратор', 1673025618),
(22, 'тест1', 'Администратор', 1673025633),
(23, 'тест1', 'Администратор', 1673025691),
(24, ' тест2', 'Администратор', 1673028096),
(30, ' б123вб', '14', 1673456346),
(29, ' а111аа', '14', 1673456268),
(31, 'г543вс', 'Администратор', 1673457019),
(32, 'т111ст47', 'Администратор', 1673457567),
(33, 'т111ст48', 'Администратор', 1673457592),
(34, 'т111ст', 'Администратор', 1673459162),
(38, 'т111ст49', 'Администратор', 1673472580),
(39, ' ура777', '14', 1673472692);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
