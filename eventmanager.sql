-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Июн 21 2024 г., 09:15
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `eventmanager`
--

-- --------------------------------------------------------

--
-- Структура таблицы `event`
--

CREATE TABLE `event` (
  `event_name` varchar(20) NOT NULL,
  `event_type_id` int(100) NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `time_start` time(5) NOT NULL,
  `time_end` time(5) NOT NULL,
  `max_guests` int(100) NOT NULL,
  `entry_price` varchar(7) NOT NULL,
  `location` varchar(30) NOT NULL,
  `description` text DEFAULT NULL,
  `creator_id` varchar(14) NOT NULL,
  `event_id` varchar(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `event_type`
--

CREATE TABLE `event_type` (
  `et_id` int(100) NOT NULL,
  `et_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `event_type`
--

INSERT INTO `event_type` (`et_id`, `et_name`) VALUES
(8, 'Other'),
(9, 'Arts'),
(10, 'Business'),
(11, 'Economics'),
(12, 'Ecology'),
(13, 'Medicine');

-- --------------------------------------------------------

--
-- Структура таблицы `ticket`
--

CREATE TABLE `ticket` (
  `guest_id` varchar(14) NOT NULL,
  `event_id` varchar(14) NOT NULL,
  `ticket_id` varchar(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `email_addr` varchar(20) NOT NULL,
  `password` varchar(60) NOT NULL,
  `id` varchar(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`first_name`, `last_name`, `email_addr`, `password`, `id`) VALUES
('Jan', 'Kowalski', 'jk@example.org', '$2y$10$cfGhY78NFxcmm7C56CgyNOZI2w2v9iJ7Y4p0osquWreWjJKL0zIYS', 'a667311ac544b1'),
('Daniil', 'Zelik', 'dz@example.org', '$2y$10$OMIAyYD4rvnGLD6e1hBJru3NkdHi5wLI.OJt1gEI7UoSnxmAcCHOq', 'a66735c47777ce'),
('Dima', 'Vasylchuk', 'dv@example.org', '$2y$10$PkwEJER7l8/7ilpas8oLOOsMvO47uk9PJ4ZmGXEXJtP/NW/rCw9pq', 'a6674a5712484f'),
('Stepan', 'Rudiak', 'sr@example.org', '$2y$10$soeGEReAKD0.i6m9uwZCvuX19rmN/MNzTQG6azYBptfcy1YDIE57y', 'a6674a5baceab1');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `FK_creator_id` (`creator_id`),
  ADD KEY `fk_et_id` (`event_type_id`);

--
-- Индексы таблицы `event_type`
--
ALTER TABLE `event_type`
  ADD PRIMARY KEY (`et_id`);

--
-- Индексы таблицы `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`ticket_id`),
  ADD KEY `fk_guest_id` (`guest_id`),
  ADD KEY `fk_event_id` (`event_id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `event_type`
--
ALTER TABLE `event_type`
  MODIFY `et_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `FK_creator_id` FOREIGN KEY (`creator_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `event_FK_creator_id` FOREIGN KEY (`creator_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `fk_et_id` FOREIGN KEY (`event_type_id`) REFERENCES `event_type` (`et_id`);

--
-- Ограничения внешнего ключа таблицы `ticket`
--
ALTER TABLE `ticket`
  ADD CONSTRAINT `fk_event_id` FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`),
  ADD CONSTRAINT `fk_guest_id` FOREIGN KEY (`guest_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
