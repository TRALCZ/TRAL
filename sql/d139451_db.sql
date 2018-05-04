-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Хост: wm127.wedos.net:3306
-- Время создания: Июн 05 2017 г., 17:02
-- Версия сервера: 10.0.21-MariaDB
-- Версия PHP: 5.4.23

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `d139451_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `zkratka` varchar(50) NOT NULL,
  `poznamka` text NOT NULL,
  `parent_id` int(11) DEFAULT '0',
  `tree` int(11) NOT NULL,
  `lft` int(11) NOT NULL,
  `rgt` int(11) NOT NULL,
  `lvl` int(11) NOT NULL,
  `position` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=57 ;

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`id`, `name`, `zkratka`, `poznamka`, `parent_id`, `tree`, `lft`, `rgt`, `lvl`, `position`, `created_at`, `updated_at`) VALUES
(1, 'ERKADO CZ norma', '12DVCZ', '', 0, 1, 1, 22, 0, 0, 1490279611, 1490279611),
(2, 'MP-Kování', '111MP', '', 0, 2, 1, 2, 0, 0, 1490279818, 1490279818),
(3, 'ERKADO PL norma', '14DVPL', '', 0, 3, 1, 2, 0, 0, 1490279870, 1490279870),
(4, 'STAVEBNÍ POUZDRO SCRIGNO', '11AL', '', 0, 4, 1, 2, 0, 0, 1490279901, 1490279901),
(5, 'GERBRICH Protipož, Bežpeč, Atyp', '27GER', '', 0, 5, 1, 2, 0, 0, 1490280031, 1490280031),
(6, 'Služby a montáž DVEŘE', '282SLUZBA', '', 0, 6, 1, 2, 0, 0, 1490280075, 1490280075),
(7, 'RUSKO dveře', '19RU', '', 0, 7, 1, 2, 0, 0, 1490280097, 1490280097),
(8, 'Přechodové lišty hlinik', '24PRECHOD', '', 0, 8, 1, 2, 0, 0, 1490280124, 1490280124),
(9, 'BOULIT dveře', '25BOU', 'adresa výroby: Nová Farma 1863, Jirkov, Šárku Latinákovou OV: boulit@boulit.cz 734 249 263', 0, 9, 1, 14, 0, 0, 1490280172, 1490282372),
(10, 'KERVAL ocel. zárubně', '21KER', '', 0, 10, 1, 2, 0, 0, 1490280213, 1490280213),
(11, 'OKNA-DVEŘE plastové', '23OKNA', '', 0, 11, 1, 2, 0, 0, 1490280245, 1490280245),
(12, 'xdelete', '1DEL', '', 0, 12, 1, 2, 0, 0, 1490280269, 1490280269),
(13, 'ERKADO vchodové dveře venkovní', '15ERVCH', '', 0, 13, 1, 2, 0, 0, 1490280305, 1490280305),
(14, 'STAVEBNÍ POUZDRO JAP', '110JAP', '', 0, 14, 1, 2, 0, 0, 1490280332, 1490280332),
(15, 'SHRNOVACÍ dveře', '16VIVALDI', '', 0, 15, 1, 2, 0, 0, 1490280366, 1490280366),
(16, 'ERKADO KOVÁNÍ, DOPLŇKY', '112ERKOV', '', 0, 16, 1, 2, 0, 0, 1490280399, 1490280399),
(17, 'CARMAN dveře', '28CAR', '', 0, 17, 1, 12, 0, 0, 1490280524, 1490280524),
(18, 'ERKADO požární dveře a zar.', '13ERPOZAR', '', 0, 18, 1, 2, 0, 0, 1490280595, 1490280595),
(19, 'HOBES ZÁMKY na UNO PLT', '20HOBES', '', 0, 19, 1, 2, 0, 0, 1490280631, 1490280631),
(20, 'ERKADO ocel bezpeč zar BT2 a BT3', '132ZRB', '', 0, 20, 1, 2, 0, 0, 1490280666, 1490280666),
(21, 'Služby a montáž OKNA', '29SLUOKN', '', 0, 21, 1, 2, 0, 0, 1490280705, 1490280705),
(22, 'VP TREND Výplň plastové', '280DELVP', '', 0, 22, 1, 2, 0, 0, 1490280734, 1490280734),
(23, 'Služby AKCE', '282SLAKCE', '', 0, 23, 1, 2, 0, 0, 1490280762, 1490280762),
(24, 'Služby ÚPRAVA SKLAD', '282SLUUPR', '', 0, 24, 1, 2, 0, 0, 1490280797, 1490280797),
(25, 'Kování COBRA, ACT, EUROLATON, DOMINO', '280JINEKOV', '', 0, 25, 1, 2, 0, 0, 1490280829, 1490280829),
(26, 'ERKADO dveře BT2, BT3', '131ERPOZAR', '', 0, 26, 1, 6, 0, 0, 1490280855, 1490280855),
(27, 'REKLAMACE PL', 'REPL', '', 0, 27, 1, 2, 0, 0, 1490280892, 1490280892),
(28, 'PODLAHY', 'PODL', '', 0, 28, 1, 2, 0, 0, 1490280912, 1490280912),
(29, 'Služby REKLAMACE', '283REK', '', 0, 29, 1, 2, 0, 0, 1490280957, 1490280957),
(30, 'Služby a montáž PODLAHA', '29SLUPOD', '', 0, 30, 1, 2, 0, 0, 1490281003, 1490281003),
(31, 'PARAPETY', 'PARAPETY', '', 0, 31, 1, 2, 0, 0, 1490281042, 1490281042),
(32, 'Služby a dopňky ATYP SVĚTLIKY', '29SATYP SV', '', 0, 32, 1, 2, 0, 0, 1490281066, 1490281066),
(33, 'Nezařazeno', 'NEZAŘAZENO', '', 0, 33, 1, 2, 0, 0, 1490281113, 1490281113),
(34, 'DVEŘE bezpečnostní BT2, BT3, 92mm', '12BOU', 'jen barvy ktery není v ERKADO, barvy podle vzorniku BOULIT', 9, 9, 2, 3, 1, 0, 1490282470, 1490282470),
(35, 'DVEŘE protipožární, 72 rozteč', '10BOU', '', 9, 9, 4, 5, 1, 0, 1490282802, 1490282802),
(36, 'POSUVNE DVEŘE', '16BOU', '', 9, 9, 6, 7, 1, 0, 1490283058, 1490283058),
(37, 'STANDARD DVEŘE + ATYP', '14BOU', '', 9, 9, 8, 9, 1, 0, 1490283086, 1490283086),
(38, 'ZÁRUBEŇ protipožární', '20BOU', '', 9, 9, 10, 11, 1, 0, 1490283132, 1490283132),
(39, 'ZÁRUBEŇ STANDARD, POSUV, ATYP', '18BOU', '', 9, 9, 12, 13, 1, 0, 1490283163, 1490283163),
(40, 'DVEŘE protipožární', '01POZAR', '', 17, 17, 2, 3, 1, 0, 1490283784, 1490283784),
(41, 'nepoužit', '5NE2', '', 17, 17, 4, 5, 1, 0, 1490283815, 1490283815),
(42, 'STANDARD DVEŘE', '03STN', '', 17, 17, 6, 7, 1, 0, 1490283848, 1490283848),
(43, 'STANDARD ZÁRUBEŇ', '031STNZAR', '', 17, 17, 8, 9, 1, 0, 1490284469, 1490284469),
(44, 'ZÁRUBEŇ protipožární', '02POZARZAR', '', 17, 17, 10, 11, 1, 0, 1490284507, 1490284507),
(45, 'CPL', '14CPL', '', 1, 1, 2, 3, 1, 0, 1490623235, 1490623235),
(46, 'FINISH - LAK', '11FINISH', '', 1, 1, 4, 5, 1, 0, 1490623293, 1490623293),
(47, 'GRAF', '16GR', '', 1, 1, 6, 7, 1, 0, 1490623322, 1490623322),
(48, 'GREKO STANDART', '13GRS', '', 1, 1, 8, 9, 1, 0, 1490623345, 1490623345),
(49, 'GREKO STILE', '12GREKST', '', 1, 1, 10, 11, 1, 0, 1490623370, 1490623370),
(50, 'HERSE', '15HR', '', 1, 1, 12, 13, 1, 0, 1490623400, 1490623400),
(51, 'OCELOVÁ ZÁRUBEŇ ERKADO', 'OCZABECZ', '', 1, 1, 14, 15, 1, 0, 1490623424, 1490623424),
(52, 'OSTATNÍ', '18OSTATNI', '', 1, 1, 16, 17, 1, 0, 1490623448, 1490623448),
(53, 'PREMIUM', 'PREM', '', 1, 1, 18, 19, 1, 0, 1490623471, 1490623471),
(54, 'TWIN', '17TW', '', 1, 1, 20, 21, 1, 0, 1490623501, 1490623501),
(55, 'DVEŘE BT2, 92 rozteč', '03ERBEZDV', '', 26, 26, 2, 3, 1, 0, 1490624061, 1490624061),
(56, 'DVEŘE BT3, 92 rozteč', '031ERBEZDV', '', 26, 26, 4, 5, 1, 0, 1490624108, 1490624108);

-- --------------------------------------------------------

--
-- Структура таблицы `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `countries`
--

INSERT INTO `countries` (`id`, `name`) VALUES
(1, 'Česká republika'),
(2, 'USA'),
(3, 'Spain'),
(4, 'Test');

-- --------------------------------------------------------

--
-- Структура таблицы `employee`
--

CREATE TABLE IF NOT EXISTS `employee` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `employee`
--

INSERT INTO `employee` (`id`, `name`, `group_id`) VALUES
(1, 'CZ_1', 1),
(2, 'CZ_2', 1),
(3, 'USA_1', 2),
(4, 'USA_2', 2),
(5, 'USA_3', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `group`
--

CREATE TABLE IF NOT EXISTS `group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `group`
--

INSERT INTO `group` (`id`, `name`) VALUES
(1, 'CZ'),
(2, 'USA');

-- --------------------------------------------------------

--
-- Структура таблицы `modely`
--

CREATE TABLE IF NOT EXISTS `modely` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(150) NOT NULL COMMENT 'Název',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Model dveři' AUTO_INCREMENT=26 ;

--
-- Дамп данных таблицы `modely`
--

INSERT INTO `modely` (`id`, `name`) VALUES
(1, 'ALEJA 0/3'),
(2, 'ALEJA 1/3'),
(3, 'ALEJA 3/3'),
(4, 'ALEJA LUX 0/3'),
(5, 'ALEJA LUX 1/3'),
(6, 'ALEJA LUX 3/3'),
(7, 'ARALIE 1'),
(8, 'ARALIE 2'),
(9, 'ARALIE 3'),
(10, 'AZALKA 1'),
(11, 'AZALKA 2'),
(12, 'AZALKA 3'),
(13, 'AZALKA 4'),
(14, 'AZALKA 5'),
(15, 'AZALKA 6'),
(16, 'AZALKA 7'),
(17, 'AZALKA 8'),
(18, 'BERBERIS 1'),
(19, 'BERBERIS 2'),
(20, 'BERBERIS 3'),
(21, 'BERBERIS 4'),
(22, 'BERBERIS 5'),
(23, 'BERBERIS 6'),
(24, 'BERBERIS 7'),
(25, 'BERBERIS 8');

-- --------------------------------------------------------

--
-- Структура таблицы `nabidky`
--

CREATE TABLE IF NOT EXISTS `nabidky` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cislo` varchar(50) NOT NULL,
  `popis` varchar(255) NOT NULL,
  `zpusoby_platby_id` smallint(6) NOT NULL,
  `zakazniky_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'Vystavil',
  `vystaveno` date NOT NULL,
  `platnost` date NOT NULL,
  `datetime_add` datetime NOT NULL,
  `status_id` smallint(6) NOT NULL DEFAULT '1' COMMENT 'Typ nabídky',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `nabidky`
--

INSERT INTO `nabidky` (`id`, `cislo`, `popis`, `zpusoby_platby_id`, `zakazniky_id`, `user_id`, `vystaveno`, `platnost`, `datetime_add`, `status_id`) VALUES
(1, 'NV16-01', 'Test 1', 3, 2, 1, '2017-05-06', '2017-05-27', '2017-05-06 13:51:07', 1),
(2, 'NV16-01', 'sds', 2, 2, 1, '2017-05-06', '2017-05-27', '2017-05-06 13:54:11', 1),
(3, 'NV16-01', 'sds', 2, 2, 1, '2017-05-06', '2017-05-27', '2017-05-30 17:38:41', 1),
(4, 'NV16-01', 'New 7', 3, 2, 1, '2017-06-01', '2017-06-22', '2017-06-01 16:33:50', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `nabidky_seznam`
--

CREATE TABLE IF NOT EXISTS `nabidky_seznam` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nabidky_id` int(11) NOT NULL COMMENT 'ID Nabídky',
  `seznam_id` int(11) NOT NULL COMMENT 'ID Seznam',
  `pocet` int(11) DEFAULT NULL,
  `cena` decimal(15,2) NOT NULL DEFAULT '0.00',
  `typ_ceny` varchar(20) CHARACTER SET utf8 NOT NULL,
  `sazba_dph` int(11) DEFAULT NULL,
  `sleva` decimal(15,2) DEFAULT '0.00',
  `celkem` decimal(15,2) DEFAULT '0.00',
  `celkem_dph` decimal(15,2) DEFAULT '0.00',
  `vcetne_dph` decimal(15,2) DEFAULT '0.00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=34 ;

--
-- Дамп данных таблицы `nabidky_seznam`
--

INSERT INTO `nabidky_seznam` (`id`, `nabidky_id`, `seznam_id`, `pocet`, `cena`, `typ_ceny`, `sazba_dph`, `sleva`, `celkem`, `celkem_dph`, `vcetne_dph`) VALUES
(1, 1, 2, 2, 2951.00, 'bez_dph', 21, 0.00, 5902.00, 1239.42, 7141.42),
(2, 1, 4, 1, 2953.00, 'bez_dph', 21, 0.00, 2953.00, 620.13, 3573.13),
(4, 3, 23, 1, 1970.00, 'bez_dph', 21, 0.00, 1970.00, 413.70, 2383.70),
(32, 4, 16, 1, 2953.00, 'bez_dph', 21, 0.00, 2953.00, 620.13, 3573.13),
(33, 4, 13, 1, 2950.00, 'bez_dph', 21, 0.00, 2950.00, 619.50, 3569.50);

-- --------------------------------------------------------

--
-- Структура таблицы `norma`
--

CREATE TABLE IF NOT EXISTS `norma` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(100) NOT NULL COMMENT 'Název',
  `zkratka` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Norma dveři' AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `norma`
--

INSERT INTO `norma` (`id`, `name`, `zkratka`) VALUES
(1, 'Česká', 'CZ'),
(2, 'Polská', 'PL');

-- --------------------------------------------------------

--
-- Структура таблицы `odstin`
--

CREATE TABLE IF NOT EXISTS `odstin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(150) NOT NULL COMMENT 'Název',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Дамп данных таблицы `odstin`
--

INSERT INTO `odstin` (`id`, `name`) VALUES
(1, 'olše LAK'),
(2, 'calvados LAK'),
(3, 'dub LAK'),
(4, 'buk LAK'),
(5, 'buk FINISH'),
(6, 'ořech FINISH'),
(7, 'wenge FINISH'),
(8, 'akácie FINISH'),
(9, 'bílý FINISH'),
(10, 'světlá akácie FINISH'),
(11, 'ořech GREKO'),
(12, 'sanremo GREKO'),
(13, 'dub GREKO'),
(14, 'dub střední GREKO'),
(15, 'akácie CPL'),
(16, 'dub šedý CPL'),
(17, 'wenge CPL');

-- --------------------------------------------------------

--
-- Структура таблицы `otevirani`
--

CREATE TABLE IF NOT EXISTS `otevirani` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(50) NOT NULL COMMENT 'Název',
  `zkratka` varchar(20) NOT NULL COMMENT 'Zkratka',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `otevirani`
--

INSERT INTO `otevirani` (`id`, `name`, `zkratka`) VALUES
(1, 'Pravé', 'P'),
(2, 'Levé', 'L');

-- --------------------------------------------------------

--
-- Структура таблицы `rozmer`
--

CREATE TABLE IF NOT EXISTS `rozmer` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` tinyint(4) NOT NULL COMMENT 'Název',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `rozmer`
--

INSERT INTO `rozmer` (`id`, `name`) VALUES
(1, 60),
(2, 70),
(3, 80),
(4, 90),
(5, 100);

-- --------------------------------------------------------

--
-- Структура таблицы `seznam`
--

CREATE TABLE IF NOT EXISTS `seznam` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `popis` varchar(255) NOT NULL,
  `plu` int(11) NOT NULL COMMENT 'PLU',
  `stav` int(11) DEFAULT '0',
  `rezerva` int(11) DEFAULT '0',
  `objednano` int(11) DEFAULT '0',
  `predpoklad_stav` int(11) DEFAULT '0',
  `cena_bez_dph` decimal(15,2) NOT NULL DEFAULT '0.00',
  `min_limit` int(11) DEFAULT '0',
  `cena_s_dph` decimal(15,2) NOT NULL DEFAULT '0.00',
  `category_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Дамп данных таблицы `seznam`
--

INSERT INTO `seznam` (`id`, `popis`, `plu`, `stav`, `rezerva`, `objednano`, `predpoklad_stav`, `cena_bez_dph`, `min_limit`, `cena_s_dph`, `category_id`) VALUES
(1, 'Interiérové dveře ALEJA 0/3 100 L buk LAK PZ PLT vm CZ', 161496, 0, 0, 0, 0, 1750.00, 0, 2360.00, 1),
(2, 'Interiérové dveře AZALKA 1 70 l ořech cpl BB', 1614971, 0, 2, 2, 0, 2951.00, 0, 3360.00, 1),
(3, 'Interiérové dveře AZALKA 2 70 l ořech cpl BB', 1614972, 0, 0, 0, 0, 2952.00, 0, 3360.00, 2),
(4, 'Interiérové dveře AZALKA 3 70 l ořech cpl BB', 1614973, 0, 1, 1, 0, 2953.00, 0, 3360.00, 0),
(5, 'Interiérové dveře AZALKA 4 70 l ořech cpl BB', 1614974, 0, 0, 0, 0, 2954.00, 0, 3360.00, 0),
(6, 'Interiérové dveře AZALKA 5 70 l ořech cpl BB', 1614975, 0, 0, 0, 0, 2955.00, 0, 3360.00, 0),
(7, 'Interiérové dveře AZALKA 6 70 l ořech cpl BB', 1614976, 0, 0, 0, 0, 2956.00, 0, 3360.00, 0),
(8, 'Interiérové dveře AZALKA 7 70 l ořech cpl BB', 1614977, 0, 2, 1, -1, 2957.00, 0, 3360.00, 0),
(9, 'Interiérové dveře AZALKA 8 70 l ořech cpl BB', 1614978, 0, 0, 0, 0, 2958.00, 0, 3360.00, 1),
(10, 'Interiérové dveře AZALKA 9 70 l ořech cpl BB', 1614979, 0, 0, 0, 0, 2959.00, 0, 3360.00, 0),
(11, 'Interiérové dveře AZALKA 10 70 l ořech cpl BB', 16149710, 0, 0, 0, 0, 2950.00, 0, 3360.00, 0),
(12, 'Interiérové dveře AZALKA 11 70 l ořech cpl BB', 16149711, 0, 0, 0, 0, 712.50, 0, 3360.00, 0),
(13, 'Interiérové dveře AZALKA 12 70 l ořech cpl BB', 16149712, 0, 0, 0, 0, 2950.00, 0, 3360.00, 0),
(14, 'Interiérové dveře AZALKA 13 70 l ořech cpl BB', 16149713, 0, 0, 0, 0, 2951.00, 0, 3360.00, 0),
(15, 'Interiérové dveře AZALKA 14 70 l ořech cpl BB', 16149714, 0, 0, 0, 0, 2952.00, 0, 3360.00, 0),
(16, 'Interiérové dveře AZALKA 15 70 l ořech cpl BB', 16149715, 0, 0, 0, 0, 2953.00, 0, 3360.00, 0),
(17, 'Interiérové dveře AZALKA 16 70 l ořech cpl BB', 16149716, 0, 0, 0, 0, 2954.00, 0, 3360.00, 0),
(18, 'Interiérové dveře AZALKA 17 70 l ořech cpl BB', 16149717, 0, 0, 0, 0, 2955.00, 0, 3360.00, 0),
(19, 'Interiérové dveře AZALKA 18 70 l ořech cpl BB', 16149718, 0, 0, 0, 0, 2956.00, 0, 3360.00, 0),
(20, 'Interiérové dveře AZALKA 19 70 l ořech cpl BB', 16149719, 0, 0, 0, 0, 2957.00, 0, 3360.00, 0),
(21, 'Interiérové dveře AZALKA 20 70 l ořech cpl BB', 16149720, 0, 0, 0, 0, 2958.00, 0, 3360.00, 0),
(22, 'Interiérové dveře ALEJA LUX 1/3 80 L dub LAK WC CZ', 12345, NULL, NULL, NULL, NULL, 100.00, NULL, 123.00, 0),
(23, 'Interiérové dveře ALEJA 1/3 70 L calvados LAK PZ CZ', 1234512345, 1, 0, 1, 12, 1970.00, 1, 2120.00, 45),
(24, 'Interiérové dveře ALEJA LUX 0/3 90 L buk LAK PZ CZ', 12345, 0, 0, 0, 0, 333.00, 1, 555.00, 49);

-- --------------------------------------------------------

--
-- Структура таблицы `status`
--

CREATE TABLE IF NOT EXISTS `status` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(50) NOT NULL COMMENT 'Název',
  `zkratka` varchar(10) NOT NULL COMMENT 'Zkratka',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf16 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `status`
--

INSERT INTO `status` (`id`, `name`, `zkratka`) VALUES
(1, 'Nabídka', 'nb'),
(2, 'Objednávka', 'ob'),
(3, 'Dokončeno', 'dk'),
(4, 'Nerealizováno', 'nr');

-- --------------------------------------------------------

--
-- Структура таблицы `typ`
--

CREATE TABLE IF NOT EXISTS `typ` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(250) NOT NULL COMMENT 'Název',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `typ`
--

INSERT INTO `typ` (`id`, `name`) VALUES
(1, 'Interiérové dveře');

-- --------------------------------------------------------

--
-- Структура таблицы `typzamku`
--

CREATE TABLE IF NOT EXISTS `typzamku` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(150) NOT NULL COMMENT 'Název',
  `zkratka` varchar(50) NOT NULL COMMENT 'Zkratka',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `typzamku`
--

INSERT INTO `typzamku` (`id`, `name`, `zkratka`) VALUES
(1, 'BB - otvor pro klíč', 'BB'),
(2, 'PZ - otvor pro vložku', 'PZ'),
(3, 'WC - sada wc', 'WC'),
(4, 'UZ - jen klika', 'UZ');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(32) NOT NULL,
  `auth_key` varchar(32) DEFAULT NULL,
  `access_token` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `name`, `username`, `password`, `auth_key`, `access_token`) VALUES
(1, 'Admin', 'admin', '21232f297a57a5a743894a0e4a801fc3', NULL, NULL),
(2, 'Den Brown', 'den', '32ce9c04a986b6360b0ea1984ed86c6c', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `ventilace`
--

CREATE TABLE IF NOT EXISTS `ventilace` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(255) NOT NULL COMMENT 'Název',
  `zkratka` varchar(10) NOT NULL COMMENT 'Zkratka',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `ventilace`
--

INSERT INTO `ventilace` (`id`, `name`, `zkratka`) VALUES
(1, 'Bez ventilace', '-'),
(2, 'Plastové průduchy', 'pp'),
(3, 'Ventilační mřižka', 'vm'),
(4, 'Ventilační podříznutí', 'vp');

-- --------------------------------------------------------

--
-- Структура таблицы `vypln`
--

CREATE TABLE IF NOT EXISTS `vypln` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL COMMENT 'Název',
  `zkratka` varchar(10) NOT NULL COMMENT 'Zkratka',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `vypln`
--

INSERT INTO `vypln` (`id`, `name`, `zkratka`) VALUES
(1, 'Voština (základní)', '-'),
(2, 'HOMALIGHT', 'PLT');

-- --------------------------------------------------------

--
-- Структура таблицы `zakazniky`
--

CREATE TABLE IF NOT EXISTS `zakazniky` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(255) NOT NULL COMMENT 'Název',
  `phone` varchar(100) DEFAULT NULL COMMENT 'Telefon',
  `email` varchar(150) DEFAULT NULL COMMENT 'Email',
  `ico` varchar(50) DEFAULT NULL COMMENT 'IČO',
  `dic` varchar(50) DEFAULT NULL COMMENT 'DIČ',
  `kontaktni_osoba` varchar(255) DEFAULT NULL COMMENT 'Kontaktní osoba',
  `f_ulice` varchar(150) DEFAULT NULL COMMENT 'Ulice a číslo',
  `f_mesto` varchar(150) DEFAULT NULL COMMENT 'Město',
  `f_psc` varchar(50) DEFAULT NULL COMMENT 'PSČ',
  `f_zeme` varchar(100) DEFAULT NULL COMMENT 'Země',
  `d_ulice` varchar(150) DEFAULT NULL COMMENT 'Ulice a číslo',
  `d_mesto` varchar(150) DEFAULT NULL COMMENT 'Město',
  `d_psc` varchar(50) DEFAULT NULL COMMENT 'PSČ',
  `d_zeme` varchar(150) DEFAULT NULL COMMENT 'Země',
  `datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Přidano',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `zakazniky`
--

INSERT INTO `zakazniky` (`id`, `name`, `phone`, `email`, `ico`, `dic`, `kontaktni_osoba`, `f_ulice`, `f_mesto`, `f_psc`, `f_zeme`, `d_ulice`, `d_mesto`, `d_psc`, `d_zeme`, `datetime`) VALUES
(1, 'Nostra 1', '777777777777', 'info@nostra.cz', '1234567', 'CZ1234567', 'Yurgen', 'Test 123', 'Praha', '111 00', 'Česká republika', 'Test 123', 'Brno', '12589', 'Česká republika', '2017-03-06 11:41:33'),
(2, 'Nostra 2', '777777777777', 'info@nostra.cz', '1234567', 'CZ1234567', 'Yurgen', 'Test 123', 'Praha', '111 00', 'Česká republika', 'Test 123', 'Brno', '12589', 'Česká republika', '2017-03-06 11:41:33'),
(3, 'Nostra 3', '777777777777', 'info@nostra.cz', '1234567', 'CZ1234567', 'Yurgen', 'Test 123', 'Praha', '111 00', 'Česká republika', 'Test 123', 'Brno', '12589', 'Česká republika', '2017-03-06 11:41:33');

-- --------------------------------------------------------

--
-- Структура таблицы `zpusoby_platby`
--

CREATE TABLE IF NOT EXISTS `zpusoby_platby` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(100) NOT NULL COMMENT 'Způsob platby',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `zpusoby_platby`
--

INSERT INTO `zpusoby_platby` (`id`, `name`) VALUES
(1, 'Hotově'),
(2, 'Převodem'),
(3, 'Složenkou'),
(4, 'Dobírkou'),
(5, 'Platební kartou');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
