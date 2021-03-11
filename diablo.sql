-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2021. Már 07. 20:54
-- Kiszolgáló verziója: 10.4.17-MariaDB
-- PHP verzió: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `diablo`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(8) NOT NULL,
  `cat_name` varchar(50) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `uploaded_by_name` varchar(50) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `uploaded_by_id` int(8) NOT NULL,
  `cat_description` varchar(255) COLLATE utf8mb4_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_name`, `uploaded_by_name`, `uploaded_by_id`, `cat_description`) VALUES
(39, 'Class-ok', 'rmeszes', 1, 'A már kiadott classokról való infók'),
(41, 'Játék mechanikák', 'rmeszes', 1, 'Mit lehet eddig tudni/mit gondolsz a játékban tervezett mechanikákról'),
(42, 'Játékmenet', 'rmeszes', 1, 'A várható játék élményről általánosságban'),
(43, 'Karakterek', 'rmeszes', 1, 'A sztori szereplőiről szóló témák gyűjteménye'),
(44, 'Lehetséges build-ek', 'rmeszes', 1, 'Tippek hogy mi működhet majd a játékban, ötletek hogy mi lenne jó'),
(45, 'Sztori', 'rmeszes', 1, 'Minden téma ami sztorival kapcsolatos'),
(46, 'Újdonságok', 'rmeszes', 1, 'A különböző új hírekről szóló témák'),
(47, 'Egyéb', 'rmeszes', 1, 'Témák amik más kategóriába nem fértek bele');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `news`
--

CREATE TABLE `news` (
  `new_id` int(8) NOT NULL,
  `picture` varchar(255) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `new_name` varchar(255) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `new_description` varchar(255) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `new_link` varchar(255) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `new_date` datetime NOT NULL,
  `uploaded_by` varchar(50) COLLATE utf8mb4_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `news`
--

INSERT INTO `news` (`new_id`, `picture`, `new_name`, `new_description`, `new_link`, `new_date`, `uploaded_by`) VALUES
(12, 'img/diablo1_small.webp', '1. hír', 'Quisque cursus sodales erat et facilisis. Praesent et libero vulputate, efficitur nunc eu, pharetra dui. Fusce ornare, augue at ultrices lobortis, ante mi facilisis sapien, nec vehicula nisl purus id.', 'https://diablo4.blizzard.com', '2021-02-24 20:58:18', 'rmeszes'),
(13, 'img/diablo2_small.webp', '2. hír', 'Fusce nec ante tortor. Integer elementum dolor in efficitur ultricies. Sed sit amet nulla facilisis, vulputate turpis ac, malesuada arcu. Aenean et ipsum et justo vehicula ultrices quis vitae velit.', 'https://diablo4.blizzard.com', '2021-02-24 20:58:40', 'rmeszes'),
(14, 'img/diablo3_small.webp', '3. hír', 'Fusce porttitor ante a leo rutrum tempor. Proin nec interdum lectus, eu ultricies elit. Maecenas tincidunt, elit id cursus sollicitudin, velit tellus auctor urna, facilisis tincidunt turpis nulla a massa.', 'https://diablo4.blizzard.com', '2021-02-24 20:58:54', 'rmeszes'),
(30, 'img/diablo4_small.webp', '4. hír', 'Morbi viverra lacinia lorem, eget tincidunt risus auctor ac. Ut maximus pharetra enim, ut mattis eros consectetur vulputate. Sed nec.', 'https://diablo4.blizzard.com', '2021-03-02 19:34:04', 'rmeszes');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `topics`
--

CREATE TABLE `topics` (
  `topic_id` int(8) NOT NULL,
  `topic_name` varchar(50) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `topic_description` varchar(255) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `uploaded_by_name` varchar(255) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `uploaded_by_id` int(8) NOT NULL,
  `cat_id` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `topics`
--

INSERT INTO `topics` (`topic_id`, `topic_name`, `topic_description`, `uploaded_by_name`, `uploaded_by_id`, `cat_id`) VALUES
(5, 'Barbarian', '', 'rmeszes', 1, 39),
(6, 'Sorceress', '', 'rmeszes', 1, 39),
(7, 'Rogue', '', 'rmeszes', 1, 39),
(8, 'Druid', '', 'rmeszes', 1, 39),
(9, 'Lilith', '', 'rmeszes', 1, 43),
(10, 'Barbarian', '', 'rmeszes', 1, 44),
(11, 'Sorceress', '', 'rmeszes', 1, 44),
(12, 'Druid', '', 'rmeszes', 1, 44),
(13, 'Rogue', '', 'rmeszes', 1, 44);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

CREATE TABLE `users` (
  `id` int(8) NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `pass` varchar(255) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `user_role` int(1) NOT NULL DEFAULT 0,
  `confirm_code` varchar(255) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `wrong_logins` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `users`
--

INSERT INTO `users` (`id`, `email`, `pass`, `username`, `user_role`, `confirm_code`, `wrong_logins`) VALUES
(1, 'rmeszes1@gmail.com', '$2y$10$7udeDQizbuuf4zKy0UCqSOCbGpPiULv1Jf9EPYYJaAuPzH69d7vbO', 'rmeszes', 1, '1', 0),
(3, 'rmeszes3@gmail.com', '$2y$10$wNR1idpOei06WQzx9CtSUe9IlCeB1pCb5qbRu.ELZ/7F//cSpOvpq', 'rmeszes3', 0, '$2y$10$f4XuiBgFDijrM.wQrL4cZuJoAjpDo41xNl0bsSvvN05joqx58ksCa', 1),
(4, 'admin@diablo.com', '$2y$10$L65n/BSUXe86o/.v/4vKweTF50E9Uu6UK1q8yQ9WwcKrivl9Bmd3m', 'admin', 0, '$2y$10$9Wl5KWZAFlqvPPbxMaJhHeuv7X61rvp2JEMbnvjdyCIxXcH0TVOjm', 0),
(8, 'rmeszes2@gmail.com', '$2y$10$/z8bUYnu0NvlMIflSHwHEe6lO03xtitezRovUs7PZXwhEBavobAkC', 'rmeszes2', 0, '1', 0);

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`),
  ADD UNIQUE KEY `cat_name` (`cat_name`),
  ADD KEY `uploaded_by` (`uploaded_by_name`);

--
-- A tábla indexei `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`new_id`),
  ADD KEY `uploaded_by` (`uploaded_by`);

--
-- A tábla indexei `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`topic_id`),
  ADD KEY `cat_id` (`cat_id`);

--
-- A tábla indexei `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT a táblához `news`
--
ALTER TABLE `news`
  MODIFY `new_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT a táblához `topics`
--
ALTER TABLE `topics`
  MODIFY `topic_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT a táblához `users`
--
ALTER TABLE `users`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `topics`
--
ALTER TABLE `topics`
  ADD CONSTRAINT `topics_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`cat_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
