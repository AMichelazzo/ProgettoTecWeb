-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mag 11, 2023 alle 19:45
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

CREATE TABLE `categoria` (
  `id_categoria` int(100) NOT NULL,
  `Nome` varchar(100) NOT NULL,
  `Descrizione` varchar(500) DEFAULT NULL,
  `img_path` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELAZIONI PER TABELLA `categoria`:
--

--
-- Dump dei dati per la tabella `categoria`
--

INSERT INTO `categoria` (`id_categoria`, `Nome`, `Descrizione`, `img_path`) VALUES
(1, 'Lampadario', 'Lampadario da soffitto per tutte le stanze', NULL),
(2, 'Animale', 'Piccolo animale di vetro molto dettagliato', NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `immagini`
--

CREATE TABLE `immagini` (
  `id_prodotto` int(100) NOT NULL,
  `id_categoria` int(100) NOT NULL,
  `path` varchar(500) NOT NULL,
  `alt_img` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELAZIONI PER TABELLA `immagini`:
--   `id_prodotto`
--       `prodotti` -> `id_prodotto`
--   `id_categoria`
--       `prodotti` -> `id_categoria`
--

--
-- Dump dei dati per la tabella `immagini`
--

INSERT INTO `immagini` (`id_prodotto`, `id_categoria`, `path`, `alt_img`) VALUES
(1, 1, '../img/lampadario.jpg', 'Lampadario in vetro con 12 braccia, pendenti a forma di cristallo trasparente. '),
(1, 1, '../img/lampadario2.jpg', 'Lampadario in vetro con 12 braccia, pendenti a forma di cristallo trasparente, acceso.'),
(1, 1, '../img/lampadario3.jpg', 'Lampadario in vetro con 12 braccia, pendenti a forma di cristallo trasparente, acceso, da vicino.');

-- --------------------------------------------------------

--
-- Struttura della tabella `messaggi`
--

CREATE TABLE `messaggi` (
  `id_messaggio` int(100) NOT NULL,
  `msg` text NOT NULL,
  `data` date NOT NULL DEFAULT current_timestamp(),
  `id_prodotto` int(100) DEFAULT NULL,
  `id_categoria` int(100) DEFAULT NULL,
  `username` varchar(20) NOT NULL,
  `letto` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELAZIONI PER TABELLA `messaggi`:
--   `username`
--       `utente` -> `username`
--   `id_prodotto`
--       `prodotti` -> `id_prodotto`
--   `id_categoria`
--       `prodotti` -> `id_categoria`
--

--
-- Dump dei dati per la tabella `messaggi`
--

INSERT INTO `messaggi` (`id_messaggio`, `msg`, `data`, `id_prodotto`, `id_categoria`, `username`, `letto`) VALUES
(1, 'Volevo delle informazioni riguardanti il \"Lampadario di lusso\"', '2023-04-04', 1, 1, 'user', 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `prodotti`
--

CREATE TABLE `prodotti` (
  `id_prodotto` int(100) NOT NULL,
  `id_categoria` int(100) NOT NULL,
  `Nome` varchar(100) NOT NULL,
  `Descrizione` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELAZIONI PER TABELLA `prodotti`:
--   `id_categoria`
--       `categoria` -> `id_categoria`
--

--
-- Dump dei dati per la tabella `prodotti`
--

INSERT INTO `prodotti` (`id_prodotto`, `id_categoria`, `Nome`, `Descrizione`) VALUES
(1, 1, 'Lampadario di lusso', 'Lampadario di lusso composto da più di 1000 pezzi fatti a mano'),
(2, 1, 'Lampadario minimal', 'Lampadario semplice ed efficace'),
(3, 2, 'Cavalluccio Marino', 'Piccolo cavalluccio marino di diversi colori');

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

CREATE TABLE `utente` (
  `username` varchar(20) NOT NULL,
  `password` varchar(64) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `ruolo` varchar(10) NOT NULL DEFAULT 'user',
  `data_creazione` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELAZIONI PER TABELLA `utente`:
--

--
-- Dump dei dati per la tabella `utente`
--

INSERT INTO `utente` (`username`, `password`, `email`, `ruolo`, `data_creazione`) VALUES
('admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'admin@admin.com', 'admin', '2023-04-04'),
('guest', 'guest', 'guest@guest.com', 'guest', '2023-04-04'),
('user', '04f8996da763b7a969b1028ee3007569eaf3a635486ddab211d512c85b9df8fb', 'user@user.com', 'user', '2023-04-04');

-- --------------------------------------------------------

--
-- Struttura della tabella `wishlist`
--

CREATE TABLE `wishlist` (
  `username` varchar(20) NOT NULL,
  `id_prodotto` int(100) NOT NULL,
  `id_categoria` int(100) NOT NULL,
  `data_salvataggio` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELAZIONI PER TABELLA `wishlist`:
--   `username`
--       `utente` -> `username`
--   `id_prodotto`
--       `prodotti` -> `id_prodotto`
--   `id_categoria`
--       `prodotti` -> `id_categoria`
--

--
-- Dump dei dati per la tabella `wishlist`
--

INSERT INTO `wishlist` (`username`, `id_prodotto`, `id_categoria`, `data_salvataggio`) VALUES
('user', 2, 1, '2023-05-11'),
('user', 3, 2, '2023-05-11');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `categoria`
--
ALTER TABLE `categoria`
  ADD UNIQUE KEY `id_categoria` (`id_categoria`);

--
-- Indici per le tabelle `immagini`
--
ALTER TABLE `immagini`
  ADD UNIQUE KEY `path` (`path`),
  ADD KEY `id_prodotto` (`id_prodotto`,`id_categoria`);

--
-- Indici per le tabelle `messaggi`
--
ALTER TABLE `messaggi`
  ADD PRIMARY KEY (`id_messaggio`,`username`),
  ADD KEY `username` (`username`),
  ADD KEY `id_prodotto` (`id_prodotto`,`id_categoria`);

--
-- Indici per le tabelle `prodotti`
--
ALTER TABLE `prodotti`
  ADD PRIMARY KEY (`id_prodotto`,`id_categoria`),
  ADD KEY `prodotti` (`id_categoria`);

--
-- Indici per le tabelle `utente`
--
ALTER TABLE `utente`
  ADD PRIMARY KEY (`username`);

--
-- Indici per le tabelle `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`username`,`id_prodotto`,`id_categoria`),
  ADD KEY `id_prodotto` (`id_prodotto`,`id_categoria`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id_categoria` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `messaggi`
--
ALTER TABLE `messaggi`
  MODIFY `id_messaggio` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `prodotti`
--
ALTER TABLE `prodotti`
  MODIFY `id_prodotto` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `immagini`
--
ALTER TABLE `immagini`
  ADD CONSTRAINT `immagini_ibfk_1` FOREIGN KEY (`id_prodotto`,`id_categoria`) REFERENCES `prodotti` (`id_prodotto`, `id_categoria`);

--
-- Limiti per la tabella `messaggi`
--
ALTER TABLE `messaggi`
  ADD CONSTRAINT `messaggi_ibfk_1` FOREIGN KEY (`username`) REFERENCES `utente` (`username`),
  ADD CONSTRAINT `messaggi_ibfk_2` FOREIGN KEY (`id_prodotto`,`id_categoria`) REFERENCES `prodotti` (`id_prodotto`, `id_categoria`);

--
-- Limiti per la tabella `prodotti`
--
ALTER TABLE `prodotti`
  ADD CONSTRAINT `prodotti` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`);

--
-- Limiti per la tabella `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`username`) REFERENCES `utente` (`username`),
  ADD CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`id_prodotto`,`id_categoria`) REFERENCES `prodotti` (`id_prodotto`, `id_categoria`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
