-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-10-2024 a las 20:50:35
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `music_player`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `genres`
--

CREATE TABLE `genres` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `año` int(11) NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `genres`
--

INSERT INTO `genres` (`id`, `nombre`, `año`, `descripcion`) VALUES
(1, 'Pop', 1926, 'El pop nace como género musical a mitad de la década de los 50 en Reino Unido y Estados Unidos. Aunque es cierto que unas décadas antes, en concreto en 1926, se comenzaron a utilizar las primeras expresiones referentes de popular music.'),
(2, 'Rock and Roll', 1945, 'El rock and roll como tal, tiene sus orígenes en los años 1950, pudiendo observarse, sin embargo, elementos propios de este género en producciones de Rhythm and blues que datan incluso de los años 1920. En los orígenes del rock and roll existía una combinación de elementos de blues, boogie woodgie, jazz y rhythm.'),
(3, 'Electro', 1950, 'La música electrónica se originó en la década de 1950 con el desarrollo de la tecnología de sintetizadores, y desde entonces ha evolucionado en una variedad de subgéneros, incluyendo el techno, el house, el trance, el dubstep y el mal nombrado EDM (Electronic Dance Music)');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `songs`
--

CREATE TABLE `songs` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `duration` time NOT NULL,
  `artist` varchar(100) NOT NULL,
  `lyrics` text NOT NULL,
  `link` text NOT NULL,
  `genre_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `songs`
--

INSERT INTO `songs` (`id`, `title`, `duration`, `artist`, `lyrics`, `link`, `genre_id`) VALUES
(1, 'Houdini', '03:05:00', 'Dua Lipa', '<br>Okay, huh<br>\r\nMm, ah<br>\r\n\r\n<br>I come and I go<br>\r\nTell me all the ways you need me<br>\r\nI\'m not here for long<br>\r\nCatch me or I go Houdini<br>\r\n\r\n<br>I come and I go<br>\r\nProve you got the right to please me<br>\r\nEverybody knows<br>\r\nCatch me or I go Houdini<br>\r\n\r\n<br>Time is passin\' like a solar eclipse<br>\r\nSee you watchin\' and you blow me a kiss<br>\r\nIt\'s your moment, baby, don\'t let it slip<br>\r\nCome in closer, are you readin\' my lips?<br>\r\n\r\n<br>They say I come and I go<br>\r\nTell me all the ways you need me<br>\r\nI\'m not here for long<br>\r\nCatch me or I go Houdini<br>\r\n\r\n<br>I come and I go<br>\r\nProve you got the right to please me<br>\r\nEverybody knows<br>\r\nCatch me or I go Houdini<br>\r\n\r\n<br>If you\'re good enough, you\'ll find a way<br>\r\nMaybe you could cause a girl to change (her ways)<br>\r\nDo you think about it night and day?<br>\r\nMaybe you could be the one to make me stay<br>\r\n\r\n<br>Everything you say is soundin\' so sweet (ah-ah)<br>\r\nBut do you practise everything that you preach? (Ah-ah)<br>\r\nI need something that\'ll make me believe (ah-ah)<br>\r\nIf you got it, baby, give it to me<br>\r\n\r\n<br>They say I come and I go<br>\r\nTell me all the ways you need me<br>\r\nI\'m not here for long<br>\r\nCatch me or I go Houdini<br>\r\n\r\n<br>I come and I go (I come and I go)<br>\r\nProve you got the right to please me<br>\r\nEverybody knows (I\'m not here for long)<br>\r\nCatch me or I go Houdini<br>\r\n\r\n<br>If you\'re good enough, you\'ll find a way<br>\r\nMaybe you could cause a girl to change (her ways)<br>\r\nDo you think about it night and day?<br>\r\nMaybe you could be the one to make me stay<br>\r\n\r\n<br>Oh-oh<br>\r\nOoh<br>\r\n\r\n<br>I come and I go<br>\r\nTell me all the ways you need me (ooh)<br>\r\nI\'m not here for long<br>\r\nCatch me or I go Houdini<br>\r\n\r\n<br>I come and I go (I come and I go)<br>\r\nProve you got the right to please me<br>\r\nEverybody knows (I\'m not here for long)<br>\r\nCatch me or I go Houdini<br>\r\n\r\n<br>Houdini (ah)<br>\r\nCatch me or I go Houdini<br>', 'https://open.spotify.com/embed/track/4OMJGnvZfDvsePyCwRGO7X?utm_source=generator&theme=0', 1),
(2, 'Otherside', '04:16:00', 'Red Hot Chilli Peppers', '<br>How long, how long will I slide?<br>\r\nSeparate my side, I don\'t<br>\r\nI don\'t believe it\'s bad<br>\r\nSlit my throat, it\'s all I ever<br>\r\n\r\n<br>I heard your voice through a photograph<br>\r\nI thought it up and brought up the past<br>\r\nOnce you know you can never go back<br>\r\nI gotta take it on the other side<br>\r\n\r\n<br>Well, centuries are what it meant to me<br>\r\nA cemetery where I marry the sea<br>\r\nA stranger thing could never change my mind<br>\r\nI gotta take it on the other side<br>\r\nTake it on the other side<br>\r\nTake it on, take it on<br>\r\n\r\n<br>How long, how long will I slide?<br>\r\nSeparate my side, I don\'t<br>\r\nI don\'t believe it\'s bad<br>\r\nSlit my throat, it\'s all I ever<br>\r\n\r\n<br>Pour my life into a paper cup<br>\r\nThe ashtray\'s full and I\'m spillin\' my guts<br>\r\nShe wanna know am I still a slut?<br>\r\nI\'ve got to take it on the other side<br>\r\n\r\n<br>A scarlet starlet and she\'s in my bed<br>\r\nA candidate for the soulmate bled<br>\r\nPush the trigger and pull the thread<br>\r\nI gotta take it on the other side<br>\r\nTake it on the other side<br>\r\nTake it on, take it on<br>\r\n\r\n<br>How long, how long will I slide?<br>\r\nSeparate my side, I don\'t<br>\r\nI don\'t believe it\'s bad<br>\r\nSlit my throat, it\'s all I ever<br>\r\n\r\n<br>Turn me on, take me for a hard ride<br>\r\nBurn me out, leave me on the other side<br>\r\nI yell and tell it that it\'s not my friend<br>\r\nI tear it down, I tear it down and then it\'s born again<br>\r\n\r\n<br>How long, how long will I slide?<br>\r\nSeparate my side, I don\'t<br>\r\nI don\'t believe it\'s bad<br>\r\nSlit my throat, it\'s all I ever had<br>\r\n(How long) I don\'t<br>\r\nI don\'t believe it\'s sad<br>\r\nSlit my throat, it\'s all I ever<br>', 'https://open.spotify.com/embed/track/64BbK9SFKH2jk86U3dGj2P?utm_source=generator&theme=0', 2),
(3, 'The Nights', '02:56:00', 'Avicii', '<br>Once upon a younger year<br>\r\nWhen all our shadows disappeared<br>\r\nThe animals inside came out to play<br>\r\nWent face to face with all our fears<br>\r\nLearned our lessons through the tears<br>\r\n<br>Made memories we knew would never fade<br>\r\nOne day, my father, he told me, \"Son, don\'t let it slip away\"<br>\r\nHe took me in his arms, I heard him say<br>\r\n\"When you get older your wild heart will live for younger days<br>\r\nThink of me if ever you\'re afraid\"<br>\r\n<br>He said, \"One day, you\'ll leave this world behind<br>\r\nSo live a life you will remember\"<br>\r\nMy father told me when I was just a child<br>\r\n\"These are the nights that never die\"<br>\r\nMy father told me<br>\r\n<br>\"When thunderclouds start pouring down<br>\r\nLight a fire they can\'t put out<br>\r\nCarve your name into those shining stars\"<br>\r\nHe said, \"Go venture far beyond the shores<br>\r\nDon\'t forsake this life of yours<br>\r\nI\'ll guide you home no matter where you are\"<br>\r\n<br>One day, my father, he told me, \"Son, don\'t let it slip away\"<br>\r\nWhen I was just a kid, I heard him say<br>\r\n\"When you get older your wild heart will live for younger days<br>\r\nThink of me if ever you\'re afraid\"<br>\r\n<br>He said, \"One day, you\'ll leave this world behind<br>\r\nSo live a life you will remember\"<br>\r\nMy father told me when I was just a child<br>\r\n\"These are the nights that never die\"<br>\r\nMy father told me<br>\r\n<br>\"These are the nights that never die\"<br>\r\nMy father told me<br>\r\n<br>My father told me<br>', 'https://open.spotify.com/embed/track/0ct6r3EGTcMLPtrXHDvVjc?utm_source=generator&theme=0', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'webadmin', '$2y$10$GT4vCZd8lRH/nWxEczQO1uccmVjBxvu9AYVQ/qp0DlmvSA.Cctqju');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `songs`
--
ALTER TABLE `songs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `genre_id` (`genre_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `genres`
--
ALTER TABLE `genres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `songs`
--
ALTER TABLE `songs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `songs`
--
ALTER TABLE `songs`
  ADD CONSTRAINT `songs_ibfk_1` FOREIGN KEY (`genre_id`) REFERENCES `genres` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
