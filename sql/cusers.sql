-- phpMyAdmin SQL Dump
-- version 5.2.1-1.el8
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Апр 27 2025 г., 11:45
-- Версия сервера: 8.0.26
-- Версия PHP: 7.2.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `user8865_1`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cusers`
--

CREATE TABLE `cusers` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL DEFAULT '',
  `pass` varchar(128) NOT NULL DEFAULT '',
  `fio` varchar(160) NOT NULL DEFAULT '',
  `country` varchar(40) NOT NULL DEFAULT '',
  `postcode` varchar(20) NOT NULL DEFAULT '',
  `city` varchar(40) NOT NULL DEFAULT '',
  `address` varchar(160) NOT NULL DEFAULT '',
  `phone` varchar(30) NOT NULL DEFAULT '',
  `http` varchar(160) NOT NULL DEFAULT '',
  `activation` varchar(255) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '0',
  `acces` enum('0','1','2') NOT NULL DEFAULT '0',
  `two_factor_code` varchar(6) NOT NULL DEFAULT '',
  `two_factor_expires_at` varchar(11) NOT NULL DEFAULT '',
  `notes` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `cusers`
--

INSERT INTO `cusers` (`id`, `name`, `pass`, `fio`, `country`, `postcode`, `city`, `address`, `phone`, `http`, `activation`, `status`, `two_factor_code`, `two_factor_expires_at`, `notes`) VALUES
(1, '', '','', '', '', '', '', '', '', '', '', '', '', '');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `cusers`
--
ALTER TABLE `cusers` ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `cusers`
--
ALTER TABLE `cusers`  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
