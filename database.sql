-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Ago 21, 2023 alle 13:44
-- Versione del server: 10.4.28-MariaDB
-- Versione PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tecweb`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `categoria`
--

DROP TABLE IF EXISTS `categoria`;
CREATE TABLE IF NOT EXISTS `categoria` (
  `id_categoria` int(100) NOT NULL AUTO_INCREMENT,
  `Nome` varchar(100) NOT NULL,
  `Descrizione` varchar(500) DEFAULT NULL,
  `img_path` varchar(100) DEFAULT NULL,
  `alt_img` varchar(255) NOT NULL,
  UNIQUE KEY `id_categoria` (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Svuota la tabella prima dell'inserimento `categoria`
--

TRUNCATE TABLE `categoria`;
--
-- Dump dei dati per la tabella `categoria`
--

INSERT INTO `categoria` (`id_categoria`, `Nome`, `Descrizione`, `img_path`, `alt_img`) VALUES
(1, 'Lampadario', 'Lampadario da soffitto per tutte le stanze', 'img/lampa_categ.jpg', 'test lampadario'),
(2, 'Animale', 'Piccolo animale di vetro molto dettagliato', 'img/animale_categ.jpg', 'test animale');

-- --------------------------------------------------------

--
-- Struttura della tabella `immagini`
--

DROP TABLE IF EXISTS `immagini`;
CREATE TABLE IF NOT EXISTS `immagini` (
  `id_prodotto` int(100) NOT NULL,
  `id_categoria` int(100) NOT NULL,
  `path` varchar(500) NOT NULL,
  `alt_img` text DEFAULT NULL,
  UNIQUE KEY `path` (`path`),
  KEY `id_prodotto` (`id_prodotto`,`id_categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Svuota la tabella prima dell'inserimento `immagini`
--

TRUNCATE TABLE `immagini`;
--
-- Dump dei dati per la tabella `immagini`
--

INSERT INTO `immagini` (`id_prodotto`, `id_categoria`, `path`, `alt_img`) VALUES
(1, 1, 'img/lampadario.jpg', 'Lampadario in vetro con 12 braccia, pendenti a forma di cristallo trasparente. '),
(1, 1, 'img/lampadario2.jpg', 'Lampadario in vetro con 12 braccia, pendenti a forma di cristallo trasparente, acceso.'),
(1, 1, 'img/lampadario3.jpg', 'Lampadario in vetro con 12 braccia, pendenti a forma di cristallo trasparente, acceso, da vicino.');

-- --------------------------------------------------------

--
-- Struttura della tabella `messaggi`
--

DROP TABLE IF EXISTS `messaggi`;
CREATE TABLE IF NOT EXISTS `messaggi` (
  `id_messaggio` int(100) NOT NULL AUTO_INCREMENT,
  `msg` text NOT NULL,
  `data` date NOT NULL DEFAULT current_timestamp(),
  `id_prodotto` int(100) DEFAULT NULL,
  `id_categoria` int(100) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `letto` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_messaggio`,`email`),
  KEY `id_prodotto` (`id_prodotto`,`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Svuota la tabella prima dell'inserimento `messaggi`
--

TRUNCATE TABLE `messaggi`;
--
-- Dump dei dati per la tabella `messaggi`
--

INSERT INTO `messaggi` (`id_messaggio`, `msg`, `data`, `id_prodotto`, `id_categoria`, `email`, `letto`) VALUES
(2, 'dsadfsafsafsa', '2023-06-05', 1, 1, 'user@user.com', 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `prodotti`
--

DROP TABLE IF EXISTS `prodotti`;
CREATE TABLE IF NOT EXISTS `prodotti` (
  `id_prodotto` int(100) NOT NULL AUTO_INCREMENT,
  `id_categoria` int(100) NOT NULL,
  `Nome` varchar(100) NOT NULL,
  `Descrizione` varchar(500) NOT NULL,
  PRIMARY KEY (`id_prodotto`,`id_categoria`),
  KEY `prodotti` (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Svuota la tabella prima dell'inserimento `prodotti`
--

TRUNCATE TABLE `prodotti`;
--
-- Dump dei dati per la tabella `prodotti`
--

INSERT INTO `prodotti` (`id_prodotto`, `id_categoria`, `Nome`, `Descrizione`) VALUES
(1, 1, 'Lampadario di lusso', 'Lampadario di lusso composto da più di 1000 pezzi fatti a mano'),
(2, 1, 'Lampadario minimal', 'Lampadario semplice ed efficace'),
(3, 2, 'Cavalluccio Marino', 'Piccolo cavalluccio marino di diversi colori');

-- --------------------------------------------------------

--
-- Struttura della tabella `tags`
--

DROP TABLE IF EXISTS `tags`;
CREATE TABLE IF NOT EXISTS `tags` (
  `tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `Nome` varchar(255) NOT NULL,
  `Pagina` varchar(255) NOT NULL,
  `prodotto` int(11) DEFAULT NULL,
  `categoria` int(11) DEFAULT NULL,
  PRIMARY KEY (`tag_id`),
  KEY `prodotto` (`prodotto`,`categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Svuota la tabella prima dell'inserimento `tags`
--

TRUNCATE TABLE `tags`;
--
-- Dump dei dati per la tabella `tags`
--

INSERT INTO `tags` (`tag_id`, `Nome`, `Pagina`, `prodotto`, `categoria`) VALUES
(2, 'Lampadario di vetro', 'prodotto', 1, 1),
(3, 'fsafas', 'fasdfas', 2, 1),
(4, 'vfafas', 'fsafas', 3, 2),
(5, 'Lusso', 'prodotto', 1, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

DROP TABLE IF EXISTS `utente`;
CREATE TABLE IF NOT EXISTS `utente` (
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `ruolo` varchar(10) NOT NULL DEFAULT 'user',
  `data_creazione` date NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Svuota la tabella prima dell'inserimento `utente`
--

TRUNCATE TABLE `utente`;
--
-- Dump dei dati per la tabella `utente`
--

INSERT INTO `utente` (`username`, `password`, `email`, `ruolo`, `data_creazione`) VALUES
('admin', '$2y$10$f53.u6E5rAtZC44t.8SHs.GFYFUrZrZFeEcL7m5Zxftrs3tHEO4xG', 'admin@admin.com', 'admin', '2023-05-25'),
('guest', '$2y$10$yebql9GbhZP/t0i4p6vRK.RL/L.pfgpZvZer7wtGi7IAFtuvpEWfq', 'guest@guest.com', 'user', '2023-05-25'),
('user', '$2y$10$WsN.xGDn9xbYf00RYdoZUe2NGCFZQWfTs8pqh3h/EGY1N7w1GxNm.', 'user@user.com', 'user', '2023-05-25');

-- --------------------------------------------------------

--
-- Struttura della tabella `wishlist`
--

DROP TABLE IF EXISTS `wishlist`;
CREATE TABLE IF NOT EXISTS `wishlist` (
  `username` varchar(20) NOT NULL,
  `id_prodotto` int(100) NOT NULL,
  `id_categoria` int(100) NOT NULL,
  `data_salvataggio` date NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`username`,`id_prodotto`,`id_categoria`),
  KEY `id_prodotto` (`id_prodotto`,`id_categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Svuota la tabella prima dell'inserimento `wishlist`
--

TRUNCATE TABLE `wishlist`;
--
-- Dump dei dati per la tabella `wishlist`
--

INSERT INTO `wishlist` (`username`, `id_prodotto`, `id_categoria`, `data_salvataggio`) VALUES
('user', 1, 1, '2023-06-07');

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `immagini`
--
ALTER TABLE `immagini`
  ADD CONSTRAINT `immagini_ibfk_1` FOREIGN KEY (`id_prodotto`,`id_categoria`) REFERENCES `prodotti` (`id_prodotto`, `id_categoria`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `messaggi`
--
ALTER TABLE `messaggi`
  ADD CONSTRAINT `messaggi_ibfk_2` FOREIGN KEY (`id_prodotto`,`id_categoria`) REFERENCES `prodotti` (`id_prodotto`, `id_categoria`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `prodotti`
--
ALTER TABLE `prodotti`
  ADD CONSTRAINT `prodotti` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `tags`
--
ALTER TABLE `tags`
  ADD CONSTRAINT `tags_ibfk_1` FOREIGN KEY (`prodotto`,`categoria`) REFERENCES `prodotti` (`id_prodotto`, `id_categoria`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`username`) REFERENCES `utente` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`id_prodotto`,`id_categoria`) REFERENCES `prodotti` (`id_prodotto`, `id_categoria`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
