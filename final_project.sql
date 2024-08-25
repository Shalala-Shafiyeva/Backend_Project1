-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Авг 25 2024 г., 19:28
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
-- База данных: `final_project`
--

-- --------------------------------------------------------

--
-- Структура таблицы `blogs`
--

CREATE TABLE `blogs` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `category_id` bigint(20) DEFAULT NULL,
  `title` varchar(1000) NOT NULL,
  `description` mediumtext NOT NULL,
  `profile` varchar(255) NOT NULL,
  `is_publish` tinyint(1) DEFAULT 0,
  `view_count` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `blogs`
--

INSERT INTO `blogs` (`id`, `user_id`, `category_id`, `title`, `description`, `profile`, `is_publish`, `view_count`, `created_at`, `updated_at`) VALUES
(3, 7, 5, 'Hamby sues WNBA, Aces alleging discrimination', 'Sparks forward Dearica Hamby filed a federal lawsuit against the WNBA and her former team, the Aces, alleging unlawful retaliation from the Aces after she revealed she was pregnant.', '66bb58090ef9b6.86000199_1723553801.jpg', 1, 8, '2024-07-01 09:12:31', '2024-08-16 17:40:01'),
(5, 11, 7, 'Red Light Myopia', 'Over the last few years, low-level red light (LLRL) therapy has become popular to control myopia, or nearsightedness, especially in children. In LLRL therapy, children are instructed to look into a red light-emitting instrument for three minutes, twice a day, five days a week, for the duration of the treatment period, which could last years. ', '66bb91917bc8d0.61164189_1723568529.jpg', 1, 6, '2024-08-14 10:08:24', '2024-08-16 16:30:06'),
(7, 11, 7, 'Travel 1 1 1', 'A team of geophysicists has uncovered evidence of a massive underground water reservoir on Mars, potentially solving a long-standing mystery about the planet’s vanished oceans. Using seismic data from NASA’s Insight lander, researchers estimate the newly discovered water source could cover the entire Martian surface to a depth of 1-2 kilometers if brought to the surface.', '66b8cd42596851.49358694_1723387202.jpeg', 1, 25, '2024-08-13 11:13:28', '2024-08-13 14:45:26'),
(11, 7, 9, 'Exploring the Hidden Gems of Europe', 'Europe is full of hidden treasures waiting to be discovered. From quaint villages to lesser-known cities, this guide reveals the best off-the-beaten-path destinations for your next adventure.', '66bb5f49738294.10573694_1723555657.jpeg', 1, 1, '2024-08-14 13:27:37', '2024-08-16 12:50:02'),
(12, 7, 5, 'Mastering Remote Work', 'Remote work is here to stay. Find out how to stay productive while working from home with these essential tips and tools that will help you manage your time effectively.', '66bb5fb1a75e18.48527446_1723555761.jpeg', 1, 2, '2024-08-14 13:29:21', '2024-08-14 13:29:21'),
(13, 11, 7, 'The Future of Space Exploration', 'As technology advances, the boundaries of space exploration are expanding. This blog explores the latest developments in space travel and what the future holds for humanity beyond our solar system', '66bb6025342e51.71794211_1723555877.jpeg', 1, 3, '2024-08-06 13:31:17', '2024-08-08 13:31:17'),
(14, 11, 10, 'Navigating the Digital Transformation', 'Digital transformation is reshaping the business landscape. Learn about the essential strategies companies are using to stay competitive and thrive in this new era of digital innovation', '66bb60918ac119.28181782_1723555985.webp', 1, 0, '2024-07-01 13:33:05', '2024-07-10 13:33:05'),
(15, 11, 10, 'Business World', '    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Error doloribus porro laboriosam beatae, labore ducimus fuga aperiam, adipisci, impedit reprehenderit atque natus soluta ullam! Tempore sapiente quisquam vitae officiis ipsa!', '66be364bc5cfb9.89460608_1723741771.webp', 1, 0, '2024-08-15 17:09:31', '2024-08-15 17:09:31'),
(16, 11, 6, 'New Blog', 'edvdvfrbfrbvfrv', '66bf7de73b7854.61325101_1723825639.jpeg', 1, 0, '2024-08-16 16:27:19', '2024-08-16 16:27:19'),
(18, 11, 9, 'title4', 'description4', '66c3818a072710.68285085_1724088714.jpeg', 1, 0, '2024-08-19 17:31:54', '2024-08-19 17:31:54');

-- --------------------------------------------------------

--
-- Структура таблицы `catigories`
--

CREATE TABLE `catigories` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `catigories`
--

INSERT INTO `catigories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(5, 'Sport', '2024-08-12 10:21:01', '2024-08-12 10:21:01'),
(6, 'News', '2024-08-12 10:21:03', '2024-08-12 10:21:03'),
(7, 'Sience', '2024-08-12 22:23:11', '2024-08-12 22:23:11'),
(8, 'Technology', '2024-08-13 13:18:36', '2024-08-13 13:18:36'),
(9, 'Travel', '2024-08-13 13:20:15', '2024-08-13 13:20:15'),
(10, 'Business', '2024-08-13 13:32:05', '2024-08-13 13:32:05');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `gender` int(11) NOT NULL,
  `dob` date NOT NULL,
  `profile` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `active` int(11) DEFAULT 1,
  `role` int(11) DEFAULT 0,
  `otp` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `gender`, `dob`, `profile`, `email`, `password`, `active`, `role`, `otp`, `created_at`, `updated_at`) VALUES
(6, 'Shalala', 'Shafiyeva', 0, '2001-10-15', 'public/66b8d1afa54066.29715332_1723388335.jpeg', 'shalala@gmail.com', '$2y$10$Sid5G4jr1P8krbxtFmRDPOLkpvcQmb9CW8/CeTFSVDYRpHYmIs8Fu', 1, 1, NULL, '2024-08-11 14:58:55', '2024-08-11 14:58:55'),
(7, 'Aysun', 'Babayeva', 0, '2000-05-08', 'public/66b8d2451160c3.50925075_1723388485.jpeg', 'aysun@gmail.com', '$2y$10$iHyJ5GeXThuGxAF3hh6Ko.PUF8DqmIDRr3OhWD.w3ibegL9GV.Xmu', 0, 0, NULL, '2024-08-11 15:01:25', '2024-08-11 19:22:31'),
(11, 'Ferid', 'Nagiyev', 1, '1999-10-13', 'public/66b91defa71945.11190544_1723407855.jpeg', 'ferid@gmail.com', '$2y$10$wptm6gPk7IosJjc9B64bXuJaH39PbQrRTaAX/ZWGDpJ07RjNiEPTC', 1, 0, NULL, '2024-08-11 20:23:34', '2024-08-11 20:23:34');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Индексы таблицы `catigories`
--
ALTER TABLE `catigories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT для таблицы `catigories`
--
ALTER TABLE `catigories`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `blogs`
--
ALTER TABLE `blogs`
  ADD CONSTRAINT `blogs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `blogs_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `catigories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
