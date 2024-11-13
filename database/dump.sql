-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 14, 2024 at 12:20 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tinklaiit`
--

-- --------------------------------------------------------

--
-- Table structure for table `apskritys`
--

CREATE TABLE `apskritys` (
  `id_Apskritis` int(11) NOT NULL,
  `Pavadinimas` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `apskritys`
--

INSERT INTO `apskritys` (`id_Apskritis`, `Pavadinimas`) VALUES
(1, 'Alytaus apskritis'),
(2, 'Kauno apskritis'),
(3, 'Klaipėdos apskritis'),
(4, 'Marijampolės apskritis'),
(5, 'Panevėžio apskritis'),
(6, 'Šiaulių apskritis'),
(7, 'Tauragės apskritis'),
(8, 'Telšių apskritis'),
(9, 'Utenos apskritis'),
(10, 'Vilniaus apskritis');

-- --------------------------------------------------------

--
-- Table structure for table `koordinates`
--

CREATE TABLE `koordinates` (
  `id_Koordinate` int(11) NOT NULL,
  `Platuma` float NOT NULL,
  `Ilguma` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leidimai`
--

CREATE TABLE `leidimai` (
  `id_Leidimas` int(11) NOT NULL,
  `Data` date NOT NULL,
  `fk_Administratorius` int(11) NOT NULL,
  `fk_Naikintojas` int(11) NOT NULL,
  `fk_Vieta` int(11) NOT NULL,
  `Sunaikinimo_data` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leidimai`
--

INSERT INTO `leidimai` (`id_Leidimas`, `Data`, `fk_Administratorius`, `fk_Naikintojas`, `fk_Vieta`, `Sunaikinimo_data`) VALUES
(1, '2024-11-07', 3, 6, 6, NULL),
(2, '2024-11-07', 3, 6, 5, NULL),
(6, '2024-11-08', 3, 5, 6, NULL),
(8, '2024-11-08', 3, 6, 8, NULL),
(10, '2024-11-13', 3, 10, 15, NULL),
(11, '2024-11-13', 11, 5, 14, NULL),
(12, '2024-11-13', 11, 6, 14, NULL),
(21, '2024-11-13', 11, 6, 19, NULL),
(22, '2024-11-13', 11, 5, 18, NULL),
(23, '2024-11-13', 11, 6, 18, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `naudotojai`
--

CREATE TABLE `naudotojai` (
  `id_Naudotojas` int(11) NOT NULL,
  `Vardas` varchar(100) NOT NULL,
  `Pavarde` varchar(100) NOT NULL,
  `El_pastas` varchar(100) NOT NULL,
  `Tipas` enum('Administratorius','Naikintojas','Paprastas') NOT NULL,
  `Slaptazodis` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `naudotojai`
--

INSERT INTO `naudotojai` (`id_Naudotojas`, `Vardas`, `Pavarde`, `El_pastas`, `Tipas`, `Slaptazodis`) VALUES
(3, 'Arvydas', 'Vingis', 'arvydas.vingis1@gmail.com', 'Administratorius', '$2y$10$7kMZazTldav0Nll5xFlu/.84KxyauHB/n3lsK5jgsmaiI6AP2gvfq'),
(5, 'Tadas', 'Atmazas', 'tadas@gmail.com', 'Naikintojas', '$2y$10$o0aOOc9h2wW9nJJnswa8b.ZcFkfW.Ylo/CGObIw6UWGcWWwZfu/Ky'),
(6, 'Marius', 'Tabalius', 'marius@gmail.com', 'Naikintojas', '$2y$10$c43Z8k4eCAxjbrmy7FUP1OYDHnqIXNLIej0oQbWczHJ/390Y9vBBu'),
(7, 'Tomas', 'Ramonas', 'tomas@gmail.com', 'Administratorius', '$2y$10$1IXPEwQyr6SBW1UNwHqtD.Dll/Q/uBEf/ZPKiVFzq5ktmQOrIPDwC'),
(8, 'Rimas', 'Nurimes', 'rimas@gmail.com', 'Paprastas', '$2y$10$5IX0GeCuVxt6o9dsfNRQbOC5e7wT2rHnlQe/jQTr5/dXqS5VFpbHm'),
(9, 'Paprastas', 'Paprastas', 'paprastas@gmail.com', 'Paprastas', '$2y$10$tHxQgwp3ZMRVaSKe.Ehx2uLjkUvwDgdwUwnARvl0hPfLpStla1j1u'),
(10, 'Naikintojas', 'Naikintojas', 'naikintojas@gmail.com', 'Naikintojas', '$2y$10$kVl8y7wIIqsDIorIfw9SH.gryEWN1ZKV9bT8QmPwCDxRhdcCdzBs2'),
(11, 'Administratorius', 'administratorius', 'admin@gmail.com', 'Administratorius', '$2y$10$OZtDsKjBzDykGjZ29VGKmeHhIZyPodfCB4thXu.QwKfFTTvfjLKVO');

-- --------------------------------------------------------

--
-- Table structure for table `savivaldybes`
--

CREATE TABLE `savivaldybes` (
  `id_Savivaldybe` int(11) NOT NULL,
  `Pavadinimas` varchar(100) NOT NULL,
  `fk_Apskritis` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `savivaldybes`
--

INSERT INTO `savivaldybes` (`id_Savivaldybe`, `Pavadinimas`, `fk_Apskritis`) VALUES
(1, 'Akmenės rajono savivaldybė', 10),
(2, 'Alytaus miesto savivaldybė', 1),
(3, 'Alytaus rajono savivaldybė', 1),
(4, 'Anykščių rajono savivaldybė', 10),
(5, 'Birštono savivaldybė', 2),
(6, 'Biržų rajono savivaldybė', 5),
(7, 'Druskininkų savivaldybė', 1),
(8, 'Elektrėnų savivaldybė', 2),
(9, 'Ignalinos rajono savivaldybė', 9),
(10, 'Jonavos rajono savivaldybė', 2),
(11, 'Joniškio rajono savivaldybė', 6),
(12, 'Jurbarko rajono savivaldybė', 7),
(13, 'Kaišiadorių rajono savivaldybė', 2),
(14, 'Kalvarijos savivaldybė', 4),
(15, 'Kauno miesto savivaldybė', 2),
(16, 'Kauno rajono savivaldybė', 2),
(17, 'Kazlų Rūdos savivaldybė', 2),
(18, 'Kėdainių rajono savivaldybė', 2),
(19, 'Kelmės rajono savivaldybė', 10),
(20, 'Klaipėdos miesto savivaldybė', 3),
(21, 'Klaipėdos rajono savivaldybė', 3),
(22, 'Kretingos rajono savivaldybė', 3),
(23, 'Kupiškio rajono savivaldybė', 5),
(24, 'Lazdijų rajono savivaldybė', 1),
(25, 'Marijampolės savivaldybė', 4),
(26, 'Mažeikių rajono savivaldybė', 8),
(27, 'Molėtų rajono savivaldybė', 9),
(28, 'Neringos savivaldybė', 3),
(29, 'Pagėgių savivaldybė', 3),
(30, 'Pakruojo rajono savivaldybė', 6),
(31, 'Palangos miesto savivaldybė', 3),
(32, 'Panevėžio miesto savivaldybė', 5),
(33, 'Panevėžio rajono savivaldybė', 5),
(34, 'Pasvalio rajono savivaldybė', 5),
(35, 'Plungės rajono savivaldybė', 8),
(36, 'Prienų rajono savivaldybė', 2),
(37, 'Radviliškio rajono savivaldybė', 6),
(38, 'Raseinių rajono savivaldybė', 2),
(39, 'Rietavo savivaldybė', 7),
(40, 'Rokiškio rajono savivaldybė', 5),
(41, 'Skuodo rajono savivaldybė', 6),
(42, 'Šakių rajono savivaldybė', 4),
(43, 'Šalčininkų rajono savivaldybė', 10),
(44, 'Šiaulių miesto savivaldybė', 6),
(45, 'Šiaulių rajono savivaldybė', 6),
(46, 'Šilalės rajono savivaldybė', 7),
(47, 'Šilutės rajono savivaldybė', 3),
(48, 'Širvintų rajono savivaldybė', 10),
(49, 'Švenčionių rajono savivaldybė', 10),
(50, 'Tauragės rajono savivaldybė', 7),
(51, 'Telšių rajono savivaldybė', 8),
(52, 'Trakų rajono savivaldybė', 10),
(53, 'Ukmergės rajono savivaldybė', 10),
(54, 'Utenos rajono savivaldybė', 9),
(55, 'Varėnos rajono savivaldybė', 1),
(56, 'Vilkaviškio rajono savivaldybė', 4),
(57, 'Vilniaus miesto savivaldybė', 10),
(58, 'Vilniaus rajono savivaldybė', 10),
(59, 'Visagino savivaldybė', 10),
(60, 'Zarasų rajono savivaldybė', 9);

-- --------------------------------------------------------

--
-- Table structure for table `vietos`
--

CREATE TABLE `vietos` (
  `id_Vieta` int(11) NOT NULL,
  `Sunaikinta` tinyint(4) NOT NULL,
  `Kurimo_data` date NOT NULL,
  `Naikinimo_data` date DEFAULT NULL,
  `Miestas_Kaimas` varchar(100) NOT NULL,
  `Gatve` varchar(100) NOT NULL,
  `Plotas` int(11) NOT NULL,
  `Nuotrauka` varchar(255) DEFAULT NULL,
  `fk_Apskritis` int(11) NOT NULL,
  `fk_Savivaldybe` int(11) NOT NULL,
  `fk_Koordinate` int(11) DEFAULT NULL,
  `fk_Savininkas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vietos`
--

INSERT INTO `vietos` (`id_Vieta`, `Sunaikinta`, `Kurimo_data`, `Naikinimo_data`, `Miestas_Kaimas`, `Gatve`, `Plotas`, `Nuotrauka`, `fk_Apskritis`, `fk_Savivaldybe`, `fk_Koordinate`, `fk_Savininkas`) VALUES
(8, 0, '2024-11-07', NULL, 'Saulinciai', 'debesu', 5, '/uploads/sos1.jfif', 5, 33, NULL, 6),
(12, 0, '2024-11-13', NULL, 'Birštonas', 'relakso', 8, '/uploads/sos3.jfif', 2, 5, NULL, 9),
(13, 0, '2024-11-13', NULL, 'Šilalė', 'rasos', 9, '/uploads/sos4.jfif', 3, 47, NULL, 9),
(14, 0, '2024-11-13', '2024-11-13', 'Kaunas', 'pieniu', 16, '/uploads/barstis.jpg', 2, 8, NULL, 9),
(19, 0, '2024-11-13', NULL, 'g', 'g', 54, '/uploads/sos2.jfif', 6, 30, NULL, 10),
(30, 0, '2024-11-13', NULL, 's', 's', 1, '/uploads/sos10.jfif', 2, 5, NULL, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `apskritys`
--
ALTER TABLE `apskritys`
  ADD PRIMARY KEY (`id_Apskritis`);

--
-- Indexes for table `koordinates`
--
ALTER TABLE `koordinates`
  ADD PRIMARY KEY (`id_Koordinate`);

--
-- Indexes for table `leidimai`
--
ALTER TABLE `leidimai`
  ADD PRIMARY KEY (`id_Leidimas`),
  ADD UNIQUE KEY `unique_permit` (`fk_Administratorius`,`fk_Naikintojas`,`fk_Vieta`),
  ADD KEY `fk_Naikintojas` (`fk_Naikintojas`);

--
-- Indexes for table `naudotojai`
--
ALTER TABLE `naudotojai`
  ADD PRIMARY KEY (`id_Naudotojas`);

--
-- Indexes for table `savivaldybes`
--
ALTER TABLE `savivaldybes`
  ADD PRIMARY KEY (`id_Savivaldybe`),
  ADD KEY `fk_Apskritis` (`fk_Apskritis`);

--
-- Indexes for table `vietos`
--
ALTER TABLE `vietos`
  ADD PRIMARY KEY (`id_Vieta`),
  ADD KEY `fk_Apskritis` (`fk_Apskritis`),
  ADD KEY `fk_Koordinate` (`fk_Koordinate`),
  ADD KEY `fk_Savivaldybe` (`fk_Savivaldybe`),
  ADD KEY `fk_Savininkas` (`fk_Savininkas`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `apskritys`
--
ALTER TABLE `apskritys`
  MODIFY `id_Apskritis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `koordinates`
--
ALTER TABLE `koordinates`
  MODIFY `id_Koordinate` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leidimai`
--
ALTER TABLE `leidimai`
  MODIFY `id_Leidimas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `naudotojai`
--
ALTER TABLE `naudotojai`
  MODIFY `id_Naudotojas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `savivaldybes`
--
ALTER TABLE `savivaldybes`
  MODIFY `id_Savivaldybe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `vietos`
--
ALTER TABLE `vietos`
  MODIFY `id_Vieta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `leidimai`
--
ALTER TABLE `leidimai`
  ADD CONSTRAINT `leidimai_ibfk_1` FOREIGN KEY (`fk_Administratorius`) REFERENCES `naudotojai` (`id_Naudotojas`),
  ADD CONSTRAINT `leidimai_ibfk_2` FOREIGN KEY (`fk_Naikintojas`) REFERENCES `naudotojai` (`id_Naudotojas`);

--
-- Constraints for table `savivaldybes`
--
ALTER TABLE `savivaldybes`
  ADD CONSTRAINT `savivaldybes_ibfk_1` FOREIGN KEY (`fk_Apskritis`) REFERENCES `apskritys` (`id_Apskritis`);

--
-- Constraints for table `vietos`
--
ALTER TABLE `vietos`
  ADD CONSTRAINT `vietos_ibfk_1` FOREIGN KEY (`fk_Apskritis`) REFERENCES `apskritys` (`id_Apskritis`),
  ADD CONSTRAINT `vietos_ibfk_2` FOREIGN KEY (`fk_Koordinate`) REFERENCES `koordinates` (`id_Koordinate`),
  ADD CONSTRAINT `vietos_ibfk_4` FOREIGN KEY (`fk_Savivaldybe`) REFERENCES `savivaldybes` (`id_Savivaldybe`),
  ADD CONSTRAINT `vietos_ibfk_5` FOREIGN KEY (`fk_Savininkas`) REFERENCES `naudotojai` (`id_Naudotojas`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
