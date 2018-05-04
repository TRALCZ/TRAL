-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Окт 16 2017 г., 13:26
-- Версия сервера: 5.7.16
-- Версия PHP: 5.6.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `d139451_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE `category` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `zkratka` varchar(50) NOT NULL,
  `poznamka` text NOT NULL,
  `parent_id` int(11) DEFAULT '0',
  `tree` int(11) DEFAULT NULL,
  `lft` int(11) NOT NULL,
  `rgt` int(11) NOT NULL,
  `lvl` int(11) NOT NULL,
  `position` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`id`, `name`, `zkratka`, `poznamka`, `parent_id`, `tree`, `lft`, `rgt`, `lvl`, `position`, `created_at`, `updated_at`) VALUES
(1, 'Standard', '', '', 0, 1, 1, 16, 0, 1, 1505729153, 1505729153),
(2, 'Stile', '', '', 0, 2, 1, 2, 0, 2, 1505729172, 1505729172),
(3, 'Twin', '', '', 0, 3, 1, 2, 0, 3, 1505729182, 1505729182),
(4, 'Aleja', '', '', 1, 1, 2, 11, 1, 0, 1505729193, 1505729193),
(5, 'Aleja lux', '', '', 1, 1, 12, 13, 1, 0, 1505729210, 1505729210),
(6, 'Brand', '', '', 1, 1, 14, 15, 1, 0, 1505729276, 1505729276),
(7, 'BB', '', '', 4, 1, 3, 4, 2, 0, 1505729290, 1505729290),
(8, 'PZ', '', '', 4, 1, 5, 6, 2, 0, 1505729342, 1505729342),
(9, 'WC', '', '', 4, 1, 7, 8, 2, 0, 1505729357, 1505729357),
(10, 'UZ', '', '', 4, 1, 9, 10, 2, 0, 1505729367, 1505729367);

-- --------------------------------------------------------

--
-- Структура таблицы `cenova_hladina`
--

CREATE TABLE `cenova_hladina` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `name` varchar(150) NOT NULL COMMENT 'Název',
  `procent` float NOT NULL DEFAULT '0' COMMENT 'Procenty'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Cenová hladina';

--
-- Дамп данных таблицы `cenova_hladina`
--

INSERT INTO `cenova_hladina` (`id`, `name`, `procent`) VALUES
(1, 'Hladina 10', 10),
(2, 'Hladina 20', 20);

-- --------------------------------------------------------

--
-- Структура таблицы `countries`
--

CREATE TABLE `countries` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `countries`
--

INSERT INTO `countries` (`id`, `name`) VALUES
(1, 'Česká republika'),
(2, 'Slovensko'),
(3, 'Polsko'),
(4, 'Německo');

-- --------------------------------------------------------

--
-- Структура таблицы `dlist`
--

CREATE TABLE `dlist` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `nabidky_id` int(11) DEFAULT '0' COMMENT 'Nabídka vystavená',
  `cislo` varchar(150) DEFAULT '0' COMMENT 'Číslo',
  `popis` varchar(250) DEFAULT NULL COMMENT 'Popis',
  `zpusoby_platby_id` smallint(6) NOT NULL COMMENT 'Způsoby platby',
  `zakazniky_id` int(11) NOT NULL COMMENT 'Zákazník',
  `user_id` int(11) NOT NULL COMMENT 'Vystavil',
  `vystaveno` date NOT NULL COMMENT 'Datum vystavení',
  `platnost` date NOT NULL COMMENT 'Platnost do',
  `datetime_add` datetime NOT NULL COMMENT 'Přidáno',
  `smazat` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Smazat'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Faktury vydané';

-- --------------------------------------------------------

--
-- Структура таблицы `dlist_prijaty`
--

CREATE TABLE `dlist_prijaty` (
  `id` int(11) UNSIGNED NOT NULL COMMENT 'ID',
  `objednavky_id` int(11) DEFAULT '0' COMMENT 'Nabídka vystavená',
  `cislo` varchar(150) DEFAULT '0' COMMENT 'Číslo',
  `popis` varchar(255) DEFAULT NULL COMMENT 'Popis',
  `zpusoby_platby_id` smallint(6) NOT NULL COMMENT 'Způsoby platby',
  `zakazniky_id` int(11) NOT NULL COMMENT 'Zákazník',
  `user_id` int(11) NOT NULL COMMENT 'Vystavil',
  `vystaveno` date NOT NULL COMMENT 'Datum vystavení',
  `platnost` date NOT NULL COMMENT 'Platnost do',
  `datetime_add` datetime NOT NULL COMMENT 'Přidáno',
  `smazat` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Smazat'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `dlist_prijaty_seznam`
--

CREATE TABLE `dlist_prijaty_seznam` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `dlist_prijaty_id` int(11) NOT NULL COMMENT 'ID Dodací list přijatý',
  `seznam_id` int(11) NOT NULL COMMENT 'ID Seznam',
  `pocet` int(11) DEFAULT '0' COMMENT 'Počet',
  `cena` decimal(15,2) DEFAULT '0.00' COMMENT 'Cena',
  `typ_ceny` varchar(20) NOT NULL COMMENT 'Typ ceny',
  `sazba_dph` smallint(6) DEFAULT NULL COMMENT 'Sazba DPH',
  `sleva` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT 'Sleva',
  `celkem` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT 'Celkem',
  `celkem_dph` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT 'Celkem DPH',
  `vcetne_dph` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT 'Včetně DPH'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Faktury seznam';

-- --------------------------------------------------------

--
-- Структура таблицы `dlist_seznam`
--

CREATE TABLE `dlist_seznam` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `dlist_id` int(11) NOT NULL COMMENT 'ID Faktury vydané',
  `seznam_id` int(11) NOT NULL COMMENT 'ID Seznam',
  `pocet` int(11) DEFAULT '0' COMMENT 'Počet',
  `cena` decimal(15,2) DEFAULT '0.00' COMMENT 'Cena',
  `typ_ceny` varchar(20) NOT NULL COMMENT 'Typ ceny',
  `sazba_dph` smallint(6) DEFAULT NULL COMMENT 'Sazba DPH',
  `sleva` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT 'Sleva',
  `celkem` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT 'Celkem',
  `celkem_dph` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT 'Celkem DPH',
  `vcetne_dph` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT 'Včetně DPH'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Faktury seznam';

-- --------------------------------------------------------

--
-- Структура таблицы `employee`
--

CREATE TABLE `employee` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
-- Структура таблицы `faktury`
--

CREATE TABLE `faktury` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `nabidky_id` int(11) DEFAULT '0' COMMENT 'Nabídka vystavená',
  `cislo` varchar(150) DEFAULT '0' COMMENT 'Číslo',
  `popis` varchar(250) DEFAULT NULL COMMENT 'Popis',
  `zpusoby_platby_id` smallint(6) NOT NULL COMMENT 'Způsoby platby',
  `zakazniky_id` int(11) NOT NULL COMMENT 'Zákazník',
  `user_id` int(11) NOT NULL COMMENT 'Vystavil',
  `vystaveno` date NOT NULL COMMENT 'Datum vystavení',
  `platnost` date NOT NULL COMMENT 'Platnost do',
  `datetime_add` datetime NOT NULL COMMENT 'Přidáno',
  `smazat` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Smazat'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Faktury vydané';

-- --------------------------------------------------------

--
-- Структура таблицы `faktury_prijate`
--

CREATE TABLE `faktury_prijate` (
  `id` int(11) UNSIGNED NOT NULL COMMENT 'ID',
  `objednavky_id` int(11) DEFAULT '0' COMMENT 'Objednávka vystavená',
  `cislo` varchar(150) DEFAULT '0' COMMENT 'Číslo',
  `popis` varchar(255) DEFAULT NULL COMMENT 'Popis',
  `zpusoby_platby_id` smallint(6) NOT NULL COMMENT 'Způsoby platby',
  `zakazniky_id` int(11) NOT NULL COMMENT 'Zákazník',
  `user_id` int(11) NOT NULL COMMENT 'Vystavil',
  `vystaveno` date NOT NULL COMMENT 'Datum vystavení',
  `platnost` date NOT NULL COMMENT 'Platnost do',
  `datetime_add` datetime NOT NULL COMMENT 'Přidáno',
  `smazat` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Smazat'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `faktury_prijate_seznam`
--

CREATE TABLE `faktury_prijate_seznam` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `faktury_prijate_id` int(11) NOT NULL COMMENT 'ID Faktury přijaté',
  `seznam_id` int(11) NOT NULL COMMENT 'ID Seznam',
  `pocet` int(11) DEFAULT '0' COMMENT 'Počet',
  `cena` decimal(15,2) DEFAULT '0.00' COMMENT 'Cena',
  `typ_ceny` varchar(20) NOT NULL COMMENT 'Typ ceny',
  `sazba_dph` smallint(6) DEFAULT NULL COMMENT 'Sazba DPH',
  `sleva` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT 'Sleva',
  `celkem` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT 'Celkem',
  `celkem_dph` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT 'Celkem DPH',
  `vcetne_dph` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT 'Včetně DPH'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Faktury seznam';

-- --------------------------------------------------------

--
-- Структура таблицы `faktury_seznam`
--

CREATE TABLE `faktury_seznam` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `faktury_id` int(11) NOT NULL COMMENT 'ID Faktury vydané',
  `seznam_id` int(11) NOT NULL COMMENT 'ID Seznam',
  `pocet` int(11) DEFAULT '0' COMMENT 'Počet',
  `cena` decimal(15,2) DEFAULT '0.00' COMMENT 'Cena',
  `typ_ceny` varchar(20) NOT NULL COMMENT 'Typ ceny',
  `sazba_dph` smallint(6) DEFAULT NULL COMMENT 'Sazba DPH',
  `sleva` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT 'Sleva',
  `celkem` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT 'Celkem',
  `celkem_dph` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT 'Celkem DPH',
  `vcetne_dph` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT 'Včetně DPH'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Faktury seznam';

-- --------------------------------------------------------

--
-- Структура таблицы `group`
--

CREATE TABLE `group` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `group`
--

INSERT INTO `group` (`id`, `name`) VALUES
(1, 'CZ'),
(2, 'USA');

-- --------------------------------------------------------

--
-- Структура таблицы `klice`
--

CREATE TABLE `klice` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `name` varchar(100) NOT NULL COMMENT 'Název',
  `zobrazovat` enum('Ano','Ne') NOT NULL DEFAULT 'Ano' COMMENT 'Zobrazovat'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Adresní klíče';

--
-- Дамп данных таблицы `klice`
--

INSERT INTO `klice` (`id`, `name`, `zobrazovat`) VALUES
(1, 'ABURKOV', 'Ano'),
(2, 'DOBIRKA', 'Ano'),
(3, 'ESOTSKOV', 'Ano'),
(4, 'OSOBNĚ', 'Ano'),
(5, 'PŘEPRAVA', 'Ano'),
(6, 'SPLATNOST', 'Ano'),
(7, 'VO-1', 'Ano'),
(8, 'ZÁL 50%', 'Ano');

-- --------------------------------------------------------

--
-- Структура таблицы `log`
--

CREATE TABLE `log` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `controller_name` varchar(150) NOT NULL COMMENT 'Controller',
  `action_name` varchar(150) DEFAULT NULL COMMENT 'Action',
  `user_id` int(11) NOT NULL COMMENT 'Uživatel',
  `item_id` int(11) DEFAULT NULL COMMENT 'Produkt',
  `message` text COMMENT 'Zpráva',
  `ip` varchar(150) DEFAULT NULL COMMENT 'IP',
  `datetime` datetime DEFAULT NULL COMMENT 'Datetime'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `log`
--

INSERT INTO `log` (`id`, `controller_name`, `action_name`, `user_id`, `item_id`, `message`, `ip`, `datetime`) VALUES
(1, 'nabidky', 'update', 1, 1, 'Opravil nabidku. Stara cena (bez DPH) 5589 Kč, nová cena 5589 Kč', '127.0.0.1', '2017-10-16 10:50:44'),
(2, 'nabidky', 'update', 1, 1, 'Opravil nabidku. Stara cena (bez DPH) 5589 Kč, nová cena 4968 Kč', '127.0.0.1', '2017-10-16 10:51:00'),
(3, 'nabidky', 'change', 1, 1, 'Změnil stáv (Nabídka -> Objednávka)', '127.0.0.1', '2017-10-16 10:53:34'),
(4, 'nabidky', 'update', 1, 1, 'Opravil nabidku. Stara cena (bez DPH) 4968 Kč, nová cena 6624 Kč', '127.0.0.1', '2017-10-16 11:04:07'),
(5, 'nabidky', 'update', 1, 1, 'Opravil nabidku. Stara cena (bez DPH) 6624 Kč, nová cena 4968 Kč', '127.0.0.1', '2017-10-16 11:04:34'),
(6, 'nabidky', 'change', 1, 1, 'Změnil stáv (Objednavka -> Nerealizováno)', '127.0.0.1', '2017-10-16 11:33:43'),
(7, 'nabidky', 'change', 1, 1, 'Změnil stáv (Nabídka -> Objednávka)', '127.0.0.1', '2017-10-16 11:36:07'),
(8, 'nabidky', 'update', 1, 1, 'Opravil nabidku. Stara cena (bez DPH) 4968 Kč, nová cena 6624 Kč', '127.0.0.1', '2017-10-16 11:36:41'),
(9, 'nabidky', 'update', 1, 1, 'Opravil nabidku. Stara cena (bez DPH) 6624 Kč, nová cena 4968 Kč', '127.0.0.1', '2017-10-16 11:37:07'),
(10, 'objednavky', 'create', 1, 1, 'Přidal objednavku vystavenou', '127.0.0.1', '2017-10-16 11:40:45'),
(11, 'nabidky', 'update', 1, 1, 'Opravil nabidku. Stara cena (bez DPH) 4968 Kč, nová cena 4968 Kč', '127.0.0.1', '2017-10-16 11:40:45'),
(12, 'objednavky', 'update', 1, 1, 'Opravil objednavku. Stara cena (bez DPH) 4968 Kč, nová cena 6624 Kč', '127.0.0.1', '2017-10-16 11:45:39'),
(13, 'objednavky', 'update', 1, 1, 'Opravil objednavku. Stara cena (bez DPH) 6624 Kč, nová cena 4968 Kč', '127.0.0.1', '2017-10-16 11:46:24'),
(14, 'objednavky', 'update', 1, 1, 'Opravil objednavku. Stara cena (bez DPH) 4968 Kč, nová cena 6624 Kč', '127.0.0.1', '2017-10-16 11:49:56'),
(15, 'objednavky', 'update', 1, 1, 'Opravil objednavku. Stara cena (bez DPH) 6624 Kč, nová cena 6624 Kč', '127.0.0.1', '2017-10-16 12:03:48'),
(16, 'objednavky', 'update', 1, 1, 'Opravil objednavku. Stara cena (bez DPH) 6624 Kč, nová cena 6624 Kč', '127.0.0.1', '2017-10-16 12:05:07'),
(17, 'objednavky', 'update', 1, 1, 'Opravil objednavku. Stara cena (bez DPH) 6624 Kč, nová cena 4968 Kč', '127.0.0.1', '2017-10-16 12:05:32'),
(18, 'objednavky', 'update', 1, 1, 'Opravil objednavku. Stara cena (bez DPH) 4968 Kč, nová cena 6624 Kč', '127.0.0.1', '2017-10-16 12:05:51'),
(19, 'objednavky', 'update', 1, 1, 'Opravil objednavku. Stara cena (bez DPH) 6624 Kč, nová cena 1656 Kč', '127.0.0.1', '2017-10-16 12:06:16'),
(20, 'objednavky', 'update', 1, 1, 'Opravil objednavku. Stara cena (bez DPH) 1656 Kč, nová cena 9936 Kč', '127.0.0.1', '2017-10-16 12:48:17');

-- --------------------------------------------------------

--
-- Структура таблицы `modely`
--

CREATE TABLE `modely` (
  `id` int(11) UNSIGNED NOT NULL COMMENT 'ID',
  `name` varchar(150) NOT NULL COMMENT 'Název',
  `rada_id` int(11) NOT NULL COMMENT 'Řada',
  `cena` float(15,2) DEFAULT '0.00' COMMENT 'Cena',
  `c_hladina` json DEFAULT NULL COMMENT 'Cenová hladina',
  `image` varchar(255) DEFAULT NULL COMMENT 'Obrázek',
  `file` varchar(255) DEFAULT NULL COMMENT 'File',
  `del_img` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Delete'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Model dveři';

--
-- Дамп данных таблицы `modely`
--

INSERT INTO `modely` (`id`, `name`, `rada_id`, `cena`, `c_hladina`, `image`, `file`, `del_img`) VALUES
(1, 'ALEJA 0/3', 1, 1970.00, '[\"1\", \"2\"]', '/images/models/thumbs/interierove-dvere-azalka-3.jpg', 'interierove-dvere-azalka-3.jpg', 0),
(2, 'ALEJA 1/3', 1, 1950.00, '[\"1\"]', NULL, '', 0),
(3, 'ALEJA 3/3', 1, 1950.00, NULL, NULL, '', 0),
(4, 'ALEJA LUX 0/3', 1, 3000.00, NULL, NULL, '', 0),
(5, 'ALEJA LUX 1/3', 1, 3000.00, NULL, NULL, '', 0),
(6, 'ALEJA LUX 3/3', 1, 3000.00, NULL, NULL, '', 0),
(7, 'ARALIE 1', 1, NULL, NULL, NULL, '', 0),
(8, 'ARALIE 2', 1, NULL, NULL, NULL, '', 0),
(9, 'ARALIE 3', 1, NULL, NULL, NULL, '', 0),
(10, 'AZALKA 1', 1, NULL, NULL, NULL, '', 0),
(11, 'AZALKA 2', 2, 1000.00, '[\"1\"]', NULL, '', 0),
(12, 'AZALKA 3', 1, NULL, NULL, NULL, '', 0),
(13, 'AZALKA 4', 1, NULL, NULL, NULL, '', 0),
(14, 'AZALKA 5', 1, NULL, NULL, NULL, '', 0),
(15, 'AZALKA 6', 1, NULL, NULL, NULL, '', 0),
(16, 'AZALKA 7', 1, NULL, NULL, NULL, '', 0),
(17, 'AZALKA 8', 1, NULL, NULL, NULL, '', 0),
(18, 'BERBERIS 1', 1, NULL, NULL, NULL, '', 0),
(19, 'BERBERIS 2', 1, NULL, NULL, NULL, '', 0),
(20, 'BERBERIS 3', 1, NULL, NULL, NULL, '', 0),
(21, 'BERBERIS 4', 1, NULL, NULL, NULL, '', 0),
(22, 'BERBERIS 5', 1, NULL, NULL, NULL, '', 0),
(23, 'BERBERIS 6', 1, NULL, NULL, NULL, '', 0),
(24, 'BERBERIS 7', 1, NULL, NULL, NULL, '', 0),
(25, 'BERBERIS 8', 1, NULL, NULL, NULL, '', 0),
(26, 'CETRA 0/3', 1, 2700.00, NULL, NULL, NULL, 1),
(27, 'BERBERIS 9', 2, 500.00, NULL, '/images/models/thumbs/DSC00069.jpg', 'DSC00069.jpg', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `modely_odstin`
--

CREATE TABLE `modely_odstin` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `modely_id` int(11) NOT NULL COMMENT 'Modely',
  `odstin_id` int(11) NOT NULL COMMENT 'Odstín',
  `cena_odstin` float(15,2) NOT NULL DEFAULT '0.00' COMMENT 'Cena odstínu'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `modely_odstin`
--

INSERT INTO `modely_odstin` (`id`, `modely_id`, `odstin_id`, `cena_odstin`) VALUES
(1, 2, 3, 100.00),
(2, 2, 6, 100.00),
(3, 1, 1, 100.00),
(4, 2, 2, 100.00),
(5, 4, 4, 100.00),
(6, 2, 5, 100.00),
(7, 1, 3, 100.00);

-- --------------------------------------------------------

--
-- Структура таблицы `nabidky`
--

CREATE TABLE `nabidky` (
  `id` int(11) UNSIGNED NOT NULL,
  `cislo` varchar(50) DEFAULT '0',
  `popis` varchar(255) DEFAULT NULL,
  `zpusoby_platby_id` smallint(6) NOT NULL,
  `zakazniky_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'Vystavil',
  `vystaveno` date NOT NULL,
  `platnost` date NOT NULL,
  `datetime_add` datetime NOT NULL,
  `status_id` smallint(6) DEFAULT '1' COMMENT 'Typ nabídky',
  `objednavka_vystavena` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Objednávka vystavená',
  `faktura_vydana` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Faktura vydaná',
  `dlist_vydany` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Dodací list vydaný',
  `smazat` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Smazat'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `nabidky`
--

INSERT INTO `nabidky` (`id`, `cislo`, `popis`, `zpusoby_platby_id`, `zakazniky_id`, `user_id`, `vystaveno`, `platnost`, `datetime_add`, `status_id`, `objednavka_vystavena`, `faktura_vydana`, `dlist_vydany`, `smazat`) VALUES
(1, 'N-1', '111', 1, 1, 1, '2017-10-16', '2017-11-06', '2017-10-16 11:36:58', 2, '1', '0', '0', '0');

-- --------------------------------------------------------

--
-- Структура таблицы `nabidky_seznam`
--

CREATE TABLE `nabidky_seznam` (
  `id` int(11) UNSIGNED NOT NULL,
  `nabidky_id` int(11) NOT NULL COMMENT 'ID Nabídky',
  `seznam_id` int(11) NOT NULL COMMENT 'ID Seznam',
  `pocet` int(11) DEFAULT NULL,
  `cena` decimal(15,2) NOT NULL DEFAULT '0.00',
  `typ_ceny` varchar(20) CHARACTER SET utf8 NOT NULL,
  `sazba_dph` int(11) DEFAULT NULL,
  `sleva` decimal(15,2) DEFAULT '0.00',
  `celkem` decimal(15,2) DEFAULT '0.00',
  `celkem_dph` decimal(15,2) DEFAULT '0.00',
  `vcetne_dph` decimal(15,2) DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Дамп данных таблицы `nabidky_seznam`
--

INSERT INTO `nabidky_seznam` (`id`, `nabidky_id`, `seznam_id`, `pocet`, `cena`, `typ_ceny`, `sazba_dph`, `sleva`, `celkem`, `celkem_dph`, `vcetne_dph`) VALUES
(13, 1, 1, 1, '1656.00', 'bez_dph', 21, '0.00', '1656.00', '347.76', '2003.76'),
(14, 1, 2, 2, '1656.00', 'bez_dph', 21, '0.00', '3312.00', '695.52', '4007.52');

-- --------------------------------------------------------

--
-- Структура таблицы `norma`
--

CREATE TABLE `norma` (
  `id` int(11) UNSIGNED NOT NULL COMMENT 'ID',
  `name` varchar(100) NOT NULL COMMENT 'Název',
  `zkratka` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Norma dveři';

--
-- Дамп данных таблицы `norma`
--

INSERT INTO `norma` (`id`, `name`, `zkratka`) VALUES
(1, 'Česká', 'CZ'),
(2, 'Polská', 'PL');

-- --------------------------------------------------------

--
-- Структура таблицы `objednavky`
--

CREATE TABLE `objednavky` (
  `id` int(11) UNSIGNED NOT NULL COMMENT 'ID',
  `nabidky_id` int(11) DEFAULT '0' COMMENT 'Nabídka vystavená',
  `cislo` varchar(150) DEFAULT '0' COMMENT 'Číslo',
  `popis` varchar(255) DEFAULT NULL COMMENT 'Popis',
  `zpusoby_platby_id` smallint(6) NOT NULL COMMENT 'Způsoby platby',
  `zakazniky_id` int(11) NOT NULL COMMENT 'Zákazník',
  `user_id` int(11) NOT NULL COMMENT 'Vystavil',
  `vystaveno` date NOT NULL COMMENT 'Datum vystavení',
  `platnost` date NOT NULL COMMENT 'Platnost do',
  `datetime_add` datetime NOT NULL COMMENT 'Přidáno',
  `smazat` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Smazat'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `objednavky`
--

INSERT INTO `objednavky` (`id`, `nabidky_id`, `cislo`, `popis`, `zpusoby_platby_id`, `zakazniky_id`, `user_id`, `vystaveno`, `platnost`, `datetime_add`, `smazat`) VALUES
(1, 1, 'O-1', '111', 1, 1, 1, '2017-10-16', '2017-11-06', '2017-10-16 12:48:01', '0');

-- --------------------------------------------------------

--
-- Структура таблицы `objednavky_seznam`
--

CREATE TABLE `objednavky_seznam` (
  `id` int(11) UNSIGNED NOT NULL COMMENT 'ID',
  `objednavky_id` int(11) NOT NULL COMMENT 'ID Objednávky',
  `seznam_id` int(11) NOT NULL COMMENT 'ID Seznam',
  `pocet` int(11) DEFAULT NULL COMMENT 'Počet',
  `prijato` int(11) DEFAULT '0' COMMENT 'Příjato',
  `cena` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT 'Cena',
  `typ_ceny` varchar(20) NOT NULL COMMENT 'Typ ceny',
  `sazba_dph` smallint(6) DEFAULT NULL COMMENT 'Sazba DPH',
  `sleva` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT 'Sleva',
  `celkem` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT 'Celkem',
  `celkem_dph` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT 'Celkem DPH',
  `vcetne_dph` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT 'Včetně DPH'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `objednavky_seznam`
--

INSERT INTO `objednavky_seznam` (`id`, `objednavky_id`, `seznam_id`, `pocet`, `prijato`, `cena`, `typ_ceny`, `sazba_dph`, `sleva`, `celkem`, `celkem_dph`, `vcetne_dph`) VALUES
(18, 1, 1, 1, 0, '1656.00', 'bez_dph', 21, '0.00', '1656.00', '347.76', '2003.76'),
(19, 1, 2, 5, NULL, '1656.00', 'bez_dph', 21, '0.00', '8280.00', '1738.80', '10018.80');

-- --------------------------------------------------------

--
-- Структура таблицы `odstin`
--

CREATE TABLE `odstin` (
  `id` int(11) UNSIGNED NOT NULL COMMENT 'ID',
  `name` varchar(150) NOT NULL COMMENT 'Název'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

CREATE TABLE `otevirani` (
  `id` int(11) UNSIGNED NOT NULL COMMENT 'ID',
  `name` varchar(50) NOT NULL COMMENT 'Název',
  `zkratka` varchar(20) NOT NULL COMMENT 'Zkratka'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `otevirani`
--

INSERT INTO `otevirani` (`id`, `name`, `zkratka`) VALUES
(1, 'Pravé', 'P'),
(2, 'Levé', 'L');

-- --------------------------------------------------------

--
-- Структура таблицы `prevzit`
--

CREATE TABLE `prevzit` (
  `id` int(11) UNSIGNED NOT NULL COMMENT 'ID',
  `name` varchar(255) DEFAULT NULL COMMENT 'Název'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `prevzit`
--

INSERT INTO `prevzit` (`id`, `name`) VALUES
(1, 'Objednávka vystavená'),
(2, 'Faktura vydaná'),
(3, 'Dodací list vydaný');

-- --------------------------------------------------------

--
-- Структура таблицы `rada`
--

CREATE TABLE `rada` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `name` varchar(100) DEFAULT NULL COMMENT 'Název'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `rada`
--

INSERT INTO `rada` (`id`, `name`) VALUES
(1, 'Standard'),
(2, 'Stile'),
(3, 'Twin'),
(4, 'Celosklo Graf');

-- --------------------------------------------------------

--
-- Структура таблицы `rozmer`
--

CREATE TABLE `rozmer` (
  `id` int(11) UNSIGNED NOT NULL COMMENT 'ID',
  `name` tinyint(4) NOT NULL COMMENT 'Název',
  `cena` float(15,2) NOT NULL DEFAULT '0.00' COMMENT 'Cena'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `rozmer`
--

INSERT INTO `rozmer` (`id`, `name`, `cena`) VALUES
(1, 60, 0.00),
(2, 70, 0.00),
(3, 80, 0.00),
(4, 90, 0.00),
(5, 100, 400.00);

-- --------------------------------------------------------

--
-- Структура таблицы `seznam`
--

CREATE TABLE `seznam` (
  `id` int(11) UNSIGNED NOT NULL,
  `popis` varchar(255) NOT NULL,
  `typ_id` int(11) DEFAULT NULL COMMENT 'Typ',
  `norma_id` int(11) NOT NULL DEFAULT '1' COMMENT 'Norma',
  `modely_id` int(11) DEFAULT NULL COMMENT 'Model',
  `odstin_id` int(11) DEFAULT NULL COMMENT 'Odstín',
  `rozmer_id` int(11) DEFAULT NULL COMMENT 'Rozměr',
  `otevirani_id` int(11) DEFAULT NULL COMMENT 'Typ otevírání dveří',
  `typzamku_id` int(11) DEFAULT NULL COMMENT 'Typ zámku',
  `vypln_id` int(11) DEFAULT NULL COMMENT 'Výplň',
  `ventilace_id` int(11) DEFAULT NULL COMMENT 'Ventilace',
  `plu` varchar(255) NOT NULL DEFAULT '000000' COMMENT 'PLU',
  `stav` int(11) DEFAULT '0',
  `objednano` int(11) DEFAULT '0',
  `rezerva` int(11) DEFAULT '0',
  `predpoklad_stav` int(11) DEFAULT '0',
  `cena_bez_dph` decimal(15,2) NOT NULL DEFAULT '0.00',
  `min_limit` int(11) DEFAULT '0',
  `cena_s_dph` decimal(15,2) NOT NULL DEFAULT '0.00',
  `category_id` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `seznam`
--

INSERT INTO `seznam` (`id`, `popis`, `typ_id`, `norma_id`, `modely_id`, `odstin_id`, `rozmer_id`, `otevirani_id`, `typzamku_id`, `vypln_id`, `ventilace_id`, `plu`, `stav`, `objednano`, `rezerva`, `predpoklad_stav`, `cena_bez_dph`, `min_limit`, `cena_s_dph`, `category_id`) VALUES
(1, 'Interiérové dveře ALEJA 0/3 60 P olše LAK BB CZ', 1, 1, 1, 1, 1, 1, 1, 1, 1, '000001', 0, 1, 1, 0, '2070.00', 1, '2505.00', 7),
(2, 'Interiérové dveře ALEJA 0/3 70 P olše LAK BB CZ', 1, 1, 1, 1, 2, 1, 1, 1, 1, '000002', 0, 5, 2, 3, '2070.00', 1, '2505.00', 7);

-- --------------------------------------------------------

--
-- Структура таблицы `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `name` varchar(50) NOT NULL COMMENT 'Název',
  `zkratka` varchar(10) NOT NULL COMMENT 'Zkratka'
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

--
-- Дамп данных таблицы `status`
--

INSERT INTO `status` (`id`, `name`, `zkratka`) VALUES
(1, 'Nabídka', 'nb'),
(2, 'Objednávka', 'ob'),
(3, 'Nerealizováno', 'nr'),
(4, 'Dokončeno', 'dk');

-- --------------------------------------------------------

--
-- Структура таблицы `typ`
--

CREATE TABLE `typ` (
  `id` int(11) UNSIGNED NOT NULL COMMENT 'ID',
  `name` varchar(250) NOT NULL COMMENT 'Název'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `typ`
--

INSERT INTO `typ` (`id`, `name`) VALUES
(1, 'Interiérové dveře');

-- --------------------------------------------------------

--
-- Структура таблицы `typzamku`
--

CREATE TABLE `typzamku` (
  `id` int(11) UNSIGNED NOT NULL COMMENT 'ID',
  `name` varchar(150) NOT NULL COMMENT 'Název',
  `zkratka` varchar(50) NOT NULL COMMENT 'Zkratka'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

CREATE TABLE `user` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(32) NOT NULL,
  `auth_key` varchar(32) DEFAULT NULL,
  `access_token` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `name`, `username`, `password`, `auth_key`, `access_token`) VALUES
(1, 'Yuriy Trofymets', 'root', '63a9f0ea7bb98050796b649e85481845', NULL, NULL),
(2, 'Alex Burkov', 'admin', '21232f297a57a5a743894a0e4a801fc3', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `ventilace`
--

CREATE TABLE `ventilace` (
  `id` int(11) UNSIGNED NOT NULL COMMENT 'ID',
  `name` varchar(255) NOT NULL COMMENT 'Název',
  `zkratka` varchar(10) NOT NULL COMMENT 'Zkratka',
  `cena` float(15,2) NOT NULL DEFAULT '0.00' COMMENT 'Cena (bez DPH)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `ventilace`
--

INSERT INTO `ventilace` (`id`, `name`, `zkratka`, `cena`) VALUES
(1, 'Bez ventilace', '-', 0.00),
(2, 'Plastové průduchy', 'pp', 150.00),
(3, 'Ventilační mřižka', 'vm', 150.00),
(4, 'Ventilační podříznutí', 'vp', 150.00);

-- --------------------------------------------------------

--
-- Структура таблицы `vypln`
--

CREATE TABLE `vypln` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL COMMENT 'Název',
  `zkratka` varchar(10) NOT NULL COMMENT 'Zkratka',
  `cena` float(15,2) NOT NULL DEFAULT '0.00' COMMENT 'Cena (bez DPH)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `vypln`
--

INSERT INTO `vypln` (`id`, `name`, `zkratka`, `cena`) VALUES
(1, 'Voština (základní)', '-', 0.00),
(2, 'HOMALIGHT', 'PLT', 700.00);

-- --------------------------------------------------------

--
-- Структура таблицы `zakazniky`
--

CREATE TABLE `zakazniky` (
  `id` int(11) UNSIGNED NOT NULL COMMENT 'ID',
  `zakazniky_skupina_id` int(11) DEFAULT NULL COMMENT 'Zákazníky ID',
  `name` varchar(255) NOT NULL COMMENT 'Název',
  `phone` varchar(100) DEFAULT NULL COMMENT 'Telefon',
  `mobil` varchar(150) DEFAULT NULL COMMENT 'Mobil',
  `web` varchar(255) DEFAULT NULL COMMENT 'Web',
  `email` varchar(150) DEFAULT NULL COMMENT 'Email',
  `ico` varchar(50) DEFAULT NULL COMMENT 'IČO',
  `dic` varchar(50) DEFAULT NULL COMMENT 'DIČ',
  `kontaktni_osoba` varchar(255) DEFAULT NULL COMMENT 'Kontaktní osoba',
  `f_ulice` varchar(150) DEFAULT NULL COMMENT 'Ulice a číslo',
  `f_mesto` varchar(150) DEFAULT NULL COMMENT 'Město',
  `f_psc` varchar(50) DEFAULT NULL COMMENT 'PSČ',
  `f_countries_id` int(11) NOT NULL COMMENT 'Země',
  `d_ulice` varchar(150) DEFAULT NULL COMMENT 'Ulice a číslo',
  `d_mesto` varchar(150) DEFAULT NULL COMMENT 'Město',
  `d_psc` varchar(50) DEFAULT NULL COMMENT 'PSČ',
  `d_countries_id` int(11) NOT NULL COMMENT 'Země',
  `klice` json DEFAULT NULL COMMENT 'Adresní klíče',
  `poznamka` text COMMENT 'Poznámka',
  `splatnost` tinyint(4) DEFAULT '30' COMMENT 'Splatnost (dnů)',
  `c_hladina` json DEFAULT NULL COMMENT 'Cenová hladina',
  `ceniky` json DEFAULT NULL COMMENT 'Ceníky',
  `datetime` datetime DEFAULT NULL COMMENT 'Přidano'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `zakazniky`
--

INSERT INTO `zakazniky` (`id`, `zakazniky_skupina_id`, `name`, `phone`, `mobil`, `web`, `email`, `ico`, `dic`, `kontaktni_osoba`, `f_ulice`, `f_mesto`, `f_psc`, `f_countries_id`, `d_ulice`, `d_mesto`, `d_psc`, `d_countries_id`, `klice`, `poznamka`, `splatnost`, `c_hladina`, `ceniky`, `datetime`) VALUES
(1, 5, 'Asseco Central Europe, a.s.', '777777777777', '', '', 'info@nostra.cz', '27074358', 'CZ27074358', 'Yurgen', 'Budějovická 778/3a', 'Praha', '14000', 1, 'Budějovická 778/3a', 'Praha', '14000', 1, '[\"5\", \"7\", \"8\"]', 'apt: trefná poznámka → apt remark. late: poznámka za pozdní příchod do třídní knihy → late mark. marginal: poznámky na okraji stránky → marginal notes.', 30, '[\"1\", \"2\"]', '{\"5\": \"2050.00\"}', '2017-09-18 17:39:35'),
(2, 3, 'ERKADO CZ s.r.o.', '777777777777', '', '', 'info@nostra.cz', '27909590', 'CZ27909590', 'Yurgen', 'Krausova 604', 'Praha', '19900', 3, 'Test 123', 'Brno', '12589', 3, '[\"2\", \"3\", \"4\", \"6\"]', '', 30, 'null', '{\"8\": \"1957.00\"}', '2017-07-24 12:34:14'),
(3, 2, 'Seznam.cz, a.s.', '777777777777', '', '', 'info@nostra.cz', '26168685', 'CZ26168685', 'Yurgen', 'Radlická 3294/10', 'Praha', '15000', 1, 'Test 123', 'Brno', '12589', 3, NULL, NULL, 30, NULL, NULL, '2017-07-19 18:43:43'),
(4, 2, 'STV GROUP a.s.', '777777777777', '5555555555', 'stv.cz', 'info@nostra.cz', '26181134', 'CZ26181134', 'Yurgen', 'Žitná 1656/45', 'Praha', '11000', 1, 'Test 123', 'Brno', '12589', 1, '[\"4\", \"6\"]', '', 30, 'null', '{\"13\": \"2950.00\"}', '2017-07-21 17:49:36'),
(5, 3, 'CPL Jobs s.r.o.', '7541548202', '548804745', 'www.cpl.cz', 'info@cpl.cz', '26687038', 'CZ26687038', 'Test', 'Jindřišská 937/16', 'Praha', '11000', 1, 'Jindřišská 937/16', 'Praha', '11000', 1, '[\"4\", \"1\", \"5\"]', '', 30, '[\"1\"]', NULL, '2017-10-13 09:55:28'),
(6, 4, 'Mlékárna Hlinsko, a.s.', '1234567', '5555555555', 'mleko.cz', 'test@test.cz', '48169188', 'CZ48169188', 'Mleko', ' 53', 'Hlinsko', '53901', 1, ' 53', 'Hlinsko', '53901', 1, '[\"3\"]', 'Test', 21, '[\"2\"]', '{\"9\": \"2958.50\", \"10\": \"555\"}', '2017-07-21 18:14:05'),
(7, 5, 'DFB s.r.o.', '11111111', '2222222222', '33333333', 'test@test.cz', '64824446', '', 'LLL', 'Vanišova 188', 'Horní Jelení', '53374', 1, 'Vanišova 188', 'Horní Jelení', '53374', 1, '[\"3\", \"1\"]', 'Test', 30, '[\"2\", \"1\"]', '{\"13\": \"12\", \"15\": \"14\"}', '2017-07-21 18:16:22'),
(8, 5, 'DFB s.r.o.', '11111111', '2222222222', '33333333', 'test@test.cz', '64824446', '', 'LLL', 'Vanišova 188', 'Horní Jelení', '53374', 1, 'Vanišova 188', 'Horní Jelení', '53374', 1, '[\"3\", \"1\"]', 'Test', 30, '[\"2\", \"1\"]', '{\"13\": \"12\", \"15\": \"14\"}', '2017-07-21 18:16:22'),
(9, 3, 'CPL Jobs s.r.o.', '11111111', '2222222222', '33333333', 'test@test.cz', '26687038', 'CZ26687038', 'Test', 'Jindřišská 937/16', 'Praha', '11000', 1, 'Jindřišská 937/16', 'Praha', '11000', 1, '[\"4\", \"1\", \"5\"]', '', 30, '[\"1\"]', NULL, '2017-07-21 17:49:01'),
(10, 4, 'Mlékárna Hlinsko, a.s.', '1234567', '5555555555', 'mleko.cz', 'test@test.cz', '48169188', 'CZ48169188', 'Mleko', ' 53', 'Hlinsko', '53901', 1, ' 53', 'Hlinsko', '53901', 1, '[\"3\"]', 'Test', 21, '[\"2\"]', '{\"9\": \"2958.50\", \"10\": \"555\"}', '2017-07-21 18:14:05'),
(11, 5, 'DFB s.r.o.', '11111111', '2222222222', '33333333', 'test@test.cz', '64824446', '', 'LLL', 'Vanišova 188', 'Horní Jelení', '53374', 1, 'Vanišova 188', 'Horní Jelení', '53374', 1, '[\"3\", \"1\"]', 'Test', 30, '[\"2\", \"1\"]', '{\"13\": \"12\", \"15\": \"14\"}', '2017-07-21 18:16:22'),
(12, 5, 'DFB s.r.o.', '11111111', '2222222222', '33333333', 'test@test.cz', '64824446', '', 'LLL', 'Vanišova 188', 'Horní Jelení', '53374', 1, 'Vanišova 188', 'Horní Jelení', '53374', 1, '[\"3\", \"1\"]', 'Test', 30, '[\"2\", \"1\"]', '{\"13\": \"12\", \"15\": \"14\"}', '2017-07-21 18:16:22'),
(13, 5, 'DFB s.r.o.', '11111111', '2222222222', '33333333', 'test@test.cz', '64824446', '', 'LLL', 'Vanišova 188', 'Horní Jelení', '53374', 1, 'Vanišova 188', 'Horní Jelení', '53374', 1, '[\"3\", \"1\"]', 'Test', 30, '[\"2\", \"1\"]', '{\"13\": \"12\", \"15\": \"14\"}', '2017-07-21 18:16:22'),
(14, 5, 'DFB s.r.o.', '11111111', '2222222222', '33333333', 'test@test.cz', '64824446', '', 'LLL', 'Vanišova 188', 'Horní Jelení', '53374', 1, 'Vanišova 188', 'Horní Jelení', '53374', 1, '[\"3\", \"1\"]', 'Test', 30, '[\"2\", \"1\"]', '{\"13\": \"12\", \"15\": \"14\"}', '2017-07-21 18:16:22'),
(15, 5, 'DFB s.r.o.', '11111111', '2222222222', '33333333', 'test@test.cz', '64824446', '', 'LLL', 'Vanišova 188', 'Horní Jelení', '53374', 1, 'Vanišova 188', 'Horní Jelení', '53374', 1, '[\"3\", \"1\"]', 'Test', 30, '[\"2\", \"1\"]', '{\"13\": \"12\", \"15\": \"14\"}', '2017-07-21 18:16:22'),
(16, 5, 'DFB s.r.o.', '11111111', '2222222222', '33333333', 'test@test.cz', '64824446', '', 'LLL', 'Vanišova 188', 'Horní Jelení', '53374', 1, 'Vanišova 188', 'Horní Jelení', '53374', 1, '[\"3\", \"1\"]', 'Test', 30, '[\"2\", \"1\"]', '{\"13\": \"12\", \"15\": \"14\"}', '2017-07-21 18:16:22'),
(17, 5, 'DFB s.r.o.', '11111111', '2222222222', '33333333', 'test@test.cz', '64824446', '', 'LLL', 'Vanišova 188', 'Horní Jelení', '53374', 1, 'Vanišova 188', 'Horní Jelení', '53374', 1, '[\"3\", \"1\"]', 'Test', 30, '[\"2\", \"1\"]', '{\"13\": \"12\", \"15\": \"14\"}', '2017-07-21 18:16:22'),
(18, 5, 'DFB s.r.o.', '11111111', '2222222222', '33333333', 'test@test.cz', '64824446', '', 'LLL', 'Vanišova 188', 'Horní Jelení', '53374', 1, 'Vanišova 188', 'Horní Jelení', '53374', 1, '[\"3\", \"1\"]', 'Test', 30, '[\"2\", \"1\"]', '{\"13\": \"12\", \"15\": \"14\"}', '2017-07-21 18:16:22'),
(19, 5, 'DFB s.r.o.', '11111111', '2222222222', '33333333', 'test@test.cz', '64824446', '', 'LLL', 'Vanišova 188', 'Horní Jelení', '53374', 1, 'Vanišova 188', 'Horní Jelení', '53374', 1, '[\"3\", \"1\"]', 'Test', 30, '[\"2\", \"1\"]', '{\"13\": \"12\", \"15\": \"14\"}', '2017-07-21 18:16:22'),
(20, 5, 'DFB s.r.o.', '11111111', '2222222222', '33333333', 'test@test.cz', '64824446', '', 'LLL', 'Vanišova 188', 'Horní Jelení', '53374', 1, 'Vanišova 188', 'Horní Jelení', '53374', 1, '[\"3\", \"1\"]', 'Test', 30, '[\"2\", \"1\"]', '{\"13\": \"12\", \"15\": \"14\"}', '2017-07-21 18:16:22'),
(21, 5, 'DFB s.r.o.', '11111111', '2222222222', '33333333', 'test@test.cz', '64824446', '', 'LLL', 'Vanišova 188', 'Horní Jelení', '53374', 1, 'Vanišova 188', 'Horní Jelení', '53374', 1, '[\"3\", \"1\"]', 'Test', 30, '[\"2\", \"1\"]', '{\"13\": \"12\", \"15\": \"14\"}', '2017-07-21 18:16:22'),
(22, 5, 'DFB s.r.o.', '11111111', '2222222222', '33333333', 'test@test.cz', '64824446', '', 'LLL', 'Vanišova 188', 'Horní Jelení', '53374', 1, 'Vanišova 188', 'Horní Jelení', '53374', 1, '[\"3\", \"1\"]', 'Test', 30, '[\"2\", \"1\"]', '{\"13\": \"12\", \"15\": \"14\"}', '2017-07-21 18:16:22'),
(23, 3, 'Mlékárna Kunín a.s.', '11111111', '5555555555', 'mleko.cz', 'test@test.cz', '45192294', 'Skupinove_DPH', 'Vasya', ' 291', 'Kunín', '74253', 1, ' 291', 'Kunín', '74253', 1, '[\"1\", \"5\"]', 'Poznamka', 30, '[\"2\"]', '{\"38\": \"2200\"}', '2017-10-03 14:31:14');

-- --------------------------------------------------------

--
-- Структура таблицы `zakazniky_skupina`
--

CREATE TABLE `zakazniky_skupina` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `radek` tinyint(4) NOT NULL COMMENT 'Řádek',
  `name` varchar(150) NOT NULL COMMENT 'Skupina',
  `zkratka` varchar(50) NOT NULL COMMENT 'Zkratka'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `zakazniky_skupina`
--

INSERT INTO `zakazniky_skupina` (`id`, `radek`, `name`, `zkratka`) VALUES
(1, 0, 'Nezařazeno', 'NEZAŘAZENO'),
(2, 1, 'Dodavatelé', 'DOD'),
(3, 2, 'Velkoobchod', 'VO'),
(4, 3, 'Maloobchod', 'MO'),
(5, 4, 'Mzda', 'MZDA'),
(6, 5, 'Firma', 'F'),
(7, 6, 'Dodací adresy', 'DOD.ADR');

-- --------------------------------------------------------

--
-- Структура таблицы `zpusoby_platby`
--

CREATE TABLE `zpusoby_platby` (
  `id` int(11) UNSIGNED NOT NULL COMMENT 'ID',
  `name` varchar(100) NOT NULL COMMENT 'Způsob platby'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `zpusoby_platby`
--

INSERT INTO `zpusoby_platby` (`id`, `name`) VALUES
(1, 'Hotově'),
(2, 'Převodem'),
(3, 'Složenkou'),
(4, 'Dobírkou'),
(5, 'Platební kartou');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `cenova_hladina`
--
ALTER TABLE `cenova_hladina`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `dlist`
--
ALTER TABLE `dlist`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `dlist_prijaty`
--
ALTER TABLE `dlist_prijaty`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `dlist_prijaty_seznam`
--
ALTER TABLE `dlist_prijaty_seznam`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `dlist_seznam`
--
ALTER TABLE `dlist_seznam`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `faktury`
--
ALTER TABLE `faktury`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `faktury_prijate`
--
ALTER TABLE `faktury_prijate`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `faktury_prijate_seznam`
--
ALTER TABLE `faktury_prijate_seznam`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `faktury_seznam`
--
ALTER TABLE `faktury_seznam`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `group`
--
ALTER TABLE `group`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `klice`
--
ALTER TABLE `klice`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `modely`
--
ALTER TABLE `modely`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `modely_odstin`
--
ALTER TABLE `modely_odstin`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Индексы таблицы `nabidky`
--
ALTER TABLE `nabidky`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Индексы таблицы `nabidky_seznam`
--
ALTER TABLE `nabidky_seznam`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Индексы таблицы `norma`
--
ALTER TABLE `norma`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `objednavky`
--
ALTER TABLE `objednavky`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `objednavky_seznam`
--
ALTER TABLE `objednavky_seznam`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `odstin`
--
ALTER TABLE `odstin`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `otevirani`
--
ALTER TABLE `otevirani`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `prevzit`
--
ALTER TABLE `prevzit`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `rada`
--
ALTER TABLE `rada`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `rozmer`
--
ALTER TABLE `rozmer`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `seznam`
--
ALTER TABLE `seznam`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Индексы таблицы `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `typ`
--
ALTER TABLE `typ`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `typzamku`
--
ALTER TABLE `typzamku`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `ventilace`
--
ALTER TABLE `ventilace`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `vypln`
--
ALTER TABLE `vypln`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `zakazniky`
--
ALTER TABLE `zakazniky`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Индексы таблицы `zakazniky_skupina`
--
ALTER TABLE `zakazniky_skupina`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `zpusoby_platby`
--
ALTER TABLE `zpusoby_platby`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT для таблицы `cenova_hladina`
--
ALTER TABLE `cenova_hladina`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблицы `dlist`
--
ALTER TABLE `dlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';
--
-- AUTO_INCREMENT для таблицы `dlist_prijaty`
--
ALTER TABLE `dlist_prijaty`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID';
--
-- AUTO_INCREMENT для таблицы `dlist_prijaty_seznam`
--
ALTER TABLE `dlist_prijaty_seznam`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';
--
-- AUTO_INCREMENT для таблицы `dlist_seznam`
--
ALTER TABLE `dlist_seznam`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';
--
-- AUTO_INCREMENT для таблицы `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT для таблицы `faktury`
--
ALTER TABLE `faktury`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';
--
-- AUTO_INCREMENT для таблицы `faktury_prijate`
--
ALTER TABLE `faktury_prijate`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID';
--
-- AUTO_INCREMENT для таблицы `faktury_prijate_seznam`
--
ALTER TABLE `faktury_prijate_seznam`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';
--
-- AUTO_INCREMENT для таблицы `faktury_seznam`
--
ALTER TABLE `faktury_seznam`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';
--
-- AUTO_INCREMENT для таблицы `group`
--
ALTER TABLE `group`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `klice`
--
ALTER TABLE `klice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT для таблицы `log`
--
ALTER TABLE `log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT для таблицы `modely`
--
ALTER TABLE `modely`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT для таблицы `modely_odstin`
--
ALTER TABLE `modely_odstin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT для таблицы `nabidky`
--
ALTER TABLE `nabidky`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `nabidky_seznam`
--
ALTER TABLE `nabidky_seznam`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT для таблицы `norma`
--
ALTER TABLE `norma`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `objednavky`
--
ALTER TABLE `objednavky`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `objednavky_seznam`
--
ALTER TABLE `objednavky_seznam`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT для таблицы `odstin`
--
ALTER TABLE `odstin`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT для таблицы `otevirani`
--
ALTER TABLE `otevirani`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `prevzit`
--
ALTER TABLE `prevzit`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `rada`
--
ALTER TABLE `rada`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблицы `rozmer`
--
ALTER TABLE `rozmer`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT для таблицы `seznam`
--
ALTER TABLE `seznam`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблицы `typ`
--
ALTER TABLE `typ`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `typzamku`
--
ALTER TABLE `typzamku`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `ventilace`
--
ALTER TABLE `ventilace`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблицы `vypln`
--
ALTER TABLE `vypln`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `zakazniky`
--
ALTER TABLE `zakazniky`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT для таблицы `zakazniky_skupina`
--
ALTER TABLE `zakazniky_skupina`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT для таблицы `zpusoby_platby`
--
ALTER TABLE `zpusoby_platby`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=6;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
