-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Nov 08, 2024 alle 03:52
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tennisbooking`
--
CREATE DATABASE IF NOT EXISTS `tennisbooking` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `tennisbooking`;

-- --------------------------------------------------------

--
-- Struttura della tabella `campi`
--

DROP TABLE IF EXISTS `campi`;
CREATE TABLE `campi` (
  `nome` varchar(50) NOT NULL,
  `tipo` enum('erba','cemento','terra') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `campi`
--

INSERT INTO `campi` (`nome`, `tipo`) VALUES
('Campo ATP', 'cemento'),
('Campo Australian Open', 'terra'),
('Campo US Open', 'erba');

-- --------------------------------------------------------

--
-- Struttura della tabella `partecipanti_torneo`
--

DROP TABLE IF EXISTS `partecipanti_torneo`;
CREATE TABLE `partecipanti_torneo` (
  `num_partecipazione` int(11) NOT NULL,
  `utente_id` int(11) NOT NULL,
  `torneo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `partecipanti_torneo`
--

INSERT INTO `partecipanti_torneo` (`num_partecipazione`, `utente_id`, `torneo_id`) VALUES
(4, 1, 10);

-- --------------------------------------------------------

--
-- Struttura della tabella `prenotazioni`
--

DROP TABLE IF EXISTS `prenotazioni`;
CREATE TABLE `prenotazioni` (
  `id_prenotazione` int(11) NOT NULL,
  `utente_id` int(11) NOT NULL,
  `campo_id` varchar(50) NOT NULL,
  `orario` time DEFAULT NULL,
  `data_prenotazione` date DEFAULT NULL,
  `stato` enum('prenotata','annullata') DEFAULT 'prenotata'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `prenotazioni`
--

INSERT INTO `prenotazioni` (`id_prenotazione`, `utente_id`, `campo_id`, `orario`, `data_prenotazione`, `stato`) VALUES
(183, 1, 'Campo ATP', '19:00:00', '2024-11-15', 'prenotata'),
(184, 1, 'Campo US Open', '20:00:00', '2024-11-15', 'prenotata'),
(185, 1, 'Campo Australian Open', '22:00:00', '2024-11-15', 'prenotata'),
(186, 1, 'Campo Australian Open', '20:00:00', '2024-11-15', 'prenotata');

-- --------------------------------------------------------

--
-- Struttura della tabella `tornei`
--

DROP TABLE IF EXISTS `tornei`;
CREATE TABLE `tornei` (
  `id_torneo` int(11) NOT NULL,
  `nome_torneo` varchar(100) NOT NULL,
  `data_inizio` date NOT NULL,
  `data_fine` date NOT NULL,
  `stato` enum('in corso','annullato') DEFAULT 'in corso',
  `proprietario_id` int(11) DEFAULT NULL,
  `tipo_campo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `tornei`
--

INSERT INTO `tornei` (`id_torneo`, `nome_torneo`, `data_inizio`, `data_fine`, `stato`, `proprietario_id`, `tipo_campo`) VALUES
(10, 'ole chico', '2024-11-15', '2024-11-22', 'annullato', 1, 'Campo ATP');

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

DROP TABLE IF EXISTS `utenti`;
CREATE TABLE `utenti` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `cognome` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `ruolo` enum('cliente','proprietario') DEFAULT 'cliente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `utenti`
--

INSERT INTO `utenti` (`id`, `nome`, `cognome`, `email`, `password`, `ruolo`) VALUES
(1, 'francesco', 'venditto', 'kekko.venditto@gmail.com', '$2y$10$rwRZ9RQStZUa4jEgqi7N4usoytjOVk271Wm/Owor7YMXmNfxS0HHC', 'proprietario'),
(2, 'kekko', 'ven', 'kekkovenditto67@gmail.com', '$2y$10$zsOb4gvhbo3laATd5CsB.ej//4mBghJFDZYeWO2YGBaHCQ3avZ0K6', 'cliente');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `campi`
--
ALTER TABLE `campi`
  ADD PRIMARY KEY (`nome`);

--
-- Indici per le tabelle `partecipanti_torneo`
--
ALTER TABLE `partecipanti_torneo`
  ADD PRIMARY KEY (`num_partecipazione`),
  ADD KEY `partecipanti_torneo_fk_2` (`torneo_id`),
  ADD KEY `fk_utente_id` (`utente_id`);

--
-- Indici per le tabelle `prenotazioni`
--
ALTER TABLE `prenotazioni`
  ADD PRIMARY KEY (`id_prenotazione`),
  ADD KEY `fk_prenotazioni_campo` (`campo_id`),
  ADD KEY `fk_prenotazioni_utente` (`utente_id`);

--
-- Indici per le tabelle `tornei`
--
ALTER TABLE `tornei`
  ADD PRIMARY KEY (`id_torneo`),
  ADD KEY `proprietario_id` (`proprietario_id`);

--
-- Indici per le tabelle `utenti`
--
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `partecipanti_torneo`
--
ALTER TABLE `partecipanti_torneo`
  MODIFY `num_partecipazione` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la tabella `prenotazioni`
--
ALTER TABLE `prenotazioni`
  MODIFY `id_prenotazione` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=187;

--
-- AUTO_INCREMENT per la tabella `tornei`
--
ALTER TABLE `tornei`
  MODIFY `id_torneo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT per la tabella `utenti`
--
ALTER TABLE `utenti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `partecipanti_torneo`
--
ALTER TABLE `partecipanti_torneo`
  ADD CONSTRAINT `fk_partecipanti_torneo_torneo` FOREIGN KEY (`torneo_id`) REFERENCES `tornei` (`id_torneo`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_utente_id` FOREIGN KEY (`utente_id`) REFERENCES `utenti` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `prenotazioni`
--
ALTER TABLE `prenotazioni`
  ADD CONSTRAINT `fk_prenotazioni_campo` FOREIGN KEY (`campo_id`) REFERENCES `campi` (`nome`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_prenotazioni_utente` FOREIGN KEY (`utente_id`) REFERENCES `utenti` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `prenotazioni_ibfk_1` FOREIGN KEY (`utente_id`) REFERENCES `utenti` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `prenotazioni_ibfk_2` FOREIGN KEY (`campo_id`) REFERENCES `campi` (`nome`) ON DELETE CASCADE,
  ADD CONSTRAINT `prenotazioni_ibfk_3` FOREIGN KEY (`campo_id`) REFERENCES `campi` (`nome`) ON DELETE CASCADE;

--
-- Limiti per la tabella `tornei`
--
ALTER TABLE `tornei`
  ADD CONSTRAINT `tornei_ibfk_1` FOREIGN KEY (`proprietario_id`) REFERENCES `utenti` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
