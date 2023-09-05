-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Set 04, 2023 alle 11:23
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
  UNIQUE KEY `id_categoria` (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `categoria`
--

INSERT INTO `categoria` (`id_categoria`, `Nome`, `Descrizione`) VALUES
(1, 'Lampadario', 'Lampadario da soffitto per tutte le stanze'),
(2, 'Animale', 'Piccolo animale di vetro molto dettagliato'),
(3, 'Oggettistica', 'Oggettistica varia, da bicchieri a piccoli soprammobili.'),
(4, 'Gioielli', 'Gioielli vari, bracciali, anelli, collane, orecchini e molto altro.'),
(5, 'Vasi', 'Vasi di varie dimensioni e colori');

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
-- Dump dei dati per la tabella `immagini`
--

INSERT INTO `immagini` (`id_prodotto`, `id_categoria`, `path`, `alt_img`) VALUES
(5, 3, 'img/bicchieri.jpg', 'Bicchieri in vetro di colore vario.'),
(5, 3, 'img/bicchieri2.jpg', 'Bicchieri in vetro di colore vario.'),
(5, 3, 'img/bicchieri3.jpg', 'Bicchieri in vetro di colore vario.'),
(5, 3, 'img/bicchieri4.jpg', 'Bicchieri in vetro di colore vario.'),
(6, 4, 'img/bracciale-vetro-murano.jpg', 'Bracciale di vetro di murano con stoffa.'),
(7, 2, 'img/cavallo.jpg', 'Cavallo di vetro galoppante a due colori.'),
(7, 2, 'img/cavallo2.jpg', 'Cavallo di vetro ruspante.'),
(3, 2, 'img/cavallucciomarino.jpg', 'Cavalluccio marino di vetro azzurro.'),
(8, 4, 'img/collana.png', 'Collana di vetro con più di 20 pezzi.'),
(9, 2, 'img/galloMulticolor.png', 'Gallo arcobaleno di vetro.'),
(1, 1, 'img/lampadario.jpg', 'Lampadario in vetro con 12 braccia, pendenti a forma di cristallo. '),
(1, 1, 'img/lampadario2.jpg', 'Lampadario in vetro con 12 braccia, pendenti a forma di cristallo, acceso.'),
(1, 1, 'img/lampadario3.jpg', 'Lampadario in vetro, 12 braccia, pendenti a forma di cristallo, acceso.'),
(4, 1, 'img/lampadarioblue.png', 'Lampadario di vetro blue con braccia di metallo.'),
(2, 1, 'img/lampadariominimal.png', 'Lampadario minimal di vetro.'),
(10, 1, 'img/lampadariorosso.jpg', 'Lampadario di vetro rosso, composto da più di 100 pezzi.'),
(11, 2, 'img/muflone.png', 'Testa di muflone dalle lunghe corna.'),
(11, 2, 'img/muflone2.jpeg', 'Testa di muflone dalle lunghe corna.'),
(11, 2, 'img/muflone3.jpeg', 'Testa di muflone dalle lunghe corna.'),
(12, 5, 'img/vasogoccia.png', 'Vaso a forma di goccia multicolore.'),
(12, 5, 'img/vasogoccia2.png', 'Vaso a forma di goccia multicolore.'),
(12, 5, 'img/vasogoccia3.png', 'Vaso a forma di goccia multicolore.'),
(14, 5, 'img/vasorosso.jpg', 'Vaso di forma classica colore rosso.'),
(13, 5, 'img/vasosfera.png', 'Vaso a sfera di diverse dimensione.');

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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `messaggi`
--

INSERT INTO `messaggi` (`id_messaggio`, `msg`, `data`, `id_prodotto`, `id_categoria`, `email`, `letto`) VALUES
(7, 'Buongiorno, vorrei avere informazioni riguardo a questo prodotto. Il vaso c\'è solamente a forma di sfera?', '2023-09-04', 13, 5, 'user@user.com', 1),
(8, 'Buongiorno, per il cavallo c\'è percaso anche di dimensioni reali?', '2023-09-04', 7, 2, 'user@user.com', 0),
(9, 'Quanto costa il Gallo?', '2023-09-04', NULL, NULL, 'mario.rossi@gmail.com', 0);

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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `prodotti`
--

INSERT INTO `prodotti` (`id_prodotto`, `id_categoria`, `Nome`, `Descrizione`) VALUES
(1, 1, 'Lampadario a goccia', 'Lampadario da soffitto con 12 punti di illuminazione, diametro 80 centimetri. In stile classico, realizzato a mano e composto da 1000 pezzi, adatto a camere da letto ma anche zona pranzo. Ha uno stelo centrale da cui si dipartono 12 bracci ricurvi che portano alla candela led e molteplici pendenti a forma di cristallo.'),
(2, 1, 'Lampadario moderno', 'Lampadario da soffitto, con 9 punti di illuminazione, diametro 40 centimetri. Stile moderno per queste campane che partono dalla base comune in metallo di forma circolare e, attraverso un cavo di diversa lunghezza, si aprono verso il basso assicurando un’illuminazione moderna all’interno ambiente.'),
(3, 2, 'Cavalluccio Marino', 'Piccolo cavalluccio marino alto 25 centimetri in vetro di Murano. Prodotto a mano dai maestri vetrai in diverse colorazioni, poggia su una base a stella trasparente. Lavorato sfruttando le antiche tecniche dei maestri muranesi e confezionato in apposita scatola con garanzia.'),
(4, 1, 'Lampadario blu', 'Lampadario da soffitto, a molteplici punti di illuminazione, diametro 50 centimetri. Stile moderno per un lampadario caratterizzato da una struttura metallica in lega di forma lineare. Disposizione a raggiera su più livelli per i punti luce costituiti da piccole tazzine in vetro soffiato blu elegantemente lavorato.'),
(5, 3, 'Bicchieri', 'Servizio di 6 bicchieri artistici realizzati a mano in vetro soffiato, con foglia d’argento, filigrane e murrine. Ogni bicchiere è un prodotto unico, anche per i colori, e pertanto può differire leggermente nella forma. Confezionato accuratamente in apposita scatola con allegata garanzia. '),
(6, 4, 'Bracciale', 'Bracciale costituito da cordino in stoffa colorata su cui si inseriscono inserti sferici in vetro di Murano realizzati a mano. Elegantemente chiuso da un gancetto d’argento. Ideale per un regalo: viene fornito all’interno di una pregiata scatola nera con opzione dedica.'),
(7, 2, 'Cavallo', 'Piccolo cavallo in vetro dal mantello blu notte. Decorazioni in cristallo e oro su criniera e coda. Lavorato sfruttando le antiche tecniche dei maestri muranesi e confezionato in apposita scatola con garanzia.'),
(8, 4, 'Collana', 'Collana creata con perle in vetro di Murano soffiato in filigrana bicolore blu e verde. Lunga 40 centimetri, si adatta perfettamente allo stile di qualsiasi persona. Prodotto esclusivamente artigianale realizzato a mano: le piccole imperfezioni dimostrano l’assoluta unicità del prodotto.'),
(9, 2, 'Gallo multicolore', 'Riproduzione di gallo fissato ad una base semisferica. Prodotto dell’artigianato veneziano, mostra tutti i colori dell’arcobaleno. Perfetto per creare giochi di luce quando illuminato dalla luce del sole.'),
(10, 1, 'Lampadario rosso', 'Lampadario da soffitto, classico ed elegante, diametro 50 centimetri. Realizzato in vetro rosso, ma disponibile in altri colori. Presenta 6 punti luce disposti a raggiera intorno all’asse centrale decorato con foglie. I bracci ricurvi hanno dei piccoli pendenti.'),
(11, 2, 'Muflone', 'Testa di muflone alta 30 cm. Prodotta in vetro pieno mescolando il verde del collo al rosso delle testa e all’arancio delle lunghe corna ricurve. Elemento ideale per accentrare l’attenzione in una stanza tramite i suoi colori brillanti quando illuminati dal sole.'),
(12, 5, 'Vaso goccia', 'Il vaso goccia è realizzato con canne e murrine secondo la tradizione artigianale dei maestri vetrai di Murano. Realizzato interamente a mano, risulta unico nei colori, nella forma e nelle misure. Costituisce naturale elemento d’arredo per una casa moderna e giovane.'),
(13, 5, 'Vaso a sfera', 'Il vaso a sfera ha una forma semplice ed elegante nel contempo. Realizzato in vetro di Murano satinato, appare opaco e comunque luminoso. Il colore rosso si sfuma alla base verso il giallo chiaro, prendendo un aspetto vellutato e morbido al tatto. '),
(14, 5, 'Vaso classico rosso', 'Vaso in vetro dal collo allungato, alto 40 centimetri . Di colore rosso, trasmette sensazioni di movimento con le sue striature marcato che lo avvolgono vorticosamente. Si inserisce in tutti gli ambienti dal classico, al contemporaneo, al moderno.');

-- --------------------------------------------------------

--
-- Struttura della tabella `tags`
--

DROP TABLE IF EXISTS `tags`;
CREATE TABLE IF NOT EXISTS `tags` (
  `tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `Nome` varchar(255) NOT NULL,
  `prodotto` int(11) DEFAULT NULL,
  `categoria` int(11) DEFAULT NULL,
  PRIMARY KEY (`tag_id`),
  KEY `prodotto` (`prodotto`,`categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `tags`
--

INSERT INTO `tags` (`tag_id`, `Nome`, `prodotto`, `categoria`) VALUES
(2, 'Lampadario di lusso', 1, 1),
(6, 'Lampadario minimal', 2, 1),
(7, 'Cavalluccio Marino', 3, 2),
(8, 'Lampadario blue', 4, 1),
(9, 'Bicchieri', 5, 3),
(10, 'Bracciale', 6, 4),
(11, 'Cavallo', 7, 2),
(12, 'Collana', 8, 4),
(13, 'Gallo', 9, 2),
(14, 'Lampadario rosso', 10, 1),
(15, 'Muflone', 11, 2),
(16, 'Vaso goccia', 12, 5),
(17, 'Vaso a sfera', 13, 5),
(18, 'Vaso classico rosso', 14, 5);

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
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `utente`
--

INSERT INTO `utente` (`username`, `password`, `email`, `ruolo`) VALUES
('admin', '$2y$10$f53.u6E5rAtZC44t.8SHs.GFYFUrZrZFeEcL7m5Zxftrs3tHEO4xG', 'admin@admin.com', 'admin'),
('user', '$2y$10$WsN.xGDn9xbYf00RYdoZUe2NGCFZQWfTs8pqh3h/EGY1N7w1GxNm.', 'user@user.com', 'user');

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
-- Dump dei dati per la tabella `wishlist`
--

INSERT INTO `wishlist` (`username`, `id_prodotto`, `id_categoria`, `data_salvataggio`) VALUES
('user', 1, 1, '2023-09-04'),
('user', 3, 2, '2023-09-04'),
('user', 4, 1, '2023-09-04'),
('user', 9, 2, '2023-09-04'),
('user', 12, 5, '2023-09-04');

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
