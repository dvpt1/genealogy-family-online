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
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL DEFAULT '',
  `pass` varchar(128) NOT NULL DEFAULT '',
  `pwd` varchar(100) NOT NULL DEFAULT '',
  `fio` varchar(160) NOT NULL DEFAULT '',
  `country` varchar(40) NOT NULL DEFAULT '',
  `postcode` varchar(20) NOT NULL DEFAULT '',
  `city` varchar(40) NOT NULL DEFAULT '',
  `address` varchar(160) NOT NULL DEFAULT '',
  `phone` varchar(30) NOT NULL DEFAULT '',
  `http` varchar(160) NOT NULL DEFAULT '',
  `activation` varchar(255) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '0',
  `two_factor_code` varchar(6) NOT NULL DEFAULT '',
  `two_factor_expires_at` varchar(11) NOT NULL DEFAULT '',
  `notes` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `pass`, `pwd`, `fio`, `country`, `postcode`, `city`, `address`, `phone`, `http`, `activation`, `status`, `two_factor_code`, `two_factor_expires_at`, `notes`) VALUES
(1, 'dvpt@narod.ru', '2829865477dd27df2b6c20d6fc039c5d96677bfc316fae6fd6665ed383c40db7', 'diMas1','KDL', 'Россия', '620023', 'Ekaterinburg', 'Altaiskaj street 70-48, Ekaterinburg city, Russia', '89222058030', '', '0a1c4346f325cb6c79d3f5623ba7ed1c', '1', '', '', ''),
(2, 'dvpt@yandex.ru', '2829865477dd27df2b6c20d6fc039c5d96677bfc316fae6fd6665ed383c40db7', 'diMas1','', '', '', '', '', '', '', 'c925daf75b2394a8b76936f4961e13c5', '1', '', '', '');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `users`
--
ALTER TABLE `users` ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
