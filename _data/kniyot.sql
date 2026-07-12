-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 12, 2026 at 02:01 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kniyot`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `nom`) VALUES
(8, 'Baies noires'),
(7, 'Baies vertes'),
(3, 'Cacao'),
(2, 'Café'),
(1, 'Fruits'),
(4, 'Granulés'),
(5, 'Légumes'),
(6, 'Salades');

-- --------------------------------------------------------

--
-- Table structure for table `produits`
--

CREATE TABLE `produits` (
  `id` int(11) NOT NULL,
  `categorie_id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `quantite_dispo` int(11) NOT NULL DEFAULT 0,
  `etoiles_1` int(11) DEFAULT 0,
  `etoiles_2` int(11) DEFAULT 0,
  `etoiles_3` int(11) DEFAULT 0,
  `etoiles_4` int(11) DEFAULT 0,
  `etoiles_5` int(11) DEFAULT 0,
  `nom_vendeur` varchar(150) NOT NULL,
  `lieu_vendeur` varchar(255) NOT NULL,
  `temps_boutique` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `produits`
--

INSERT INTO `produits` (`id`, `categorie_id`, `nom`, `image`, `prix`, `quantite_dispo`, `etoiles_1`, `etoiles_2`, `etoiles_3`, `etoiles_4`, `etoiles_5`, `nom_vendeur`, `lieu_vendeur`, `temps_boutique`) VALUES
(1, 1, 'Fruit de la passion', '/images/fruitDeLaPassion.png', 2.50, 50, 0, 0, 2, 8, 42, 'Jorge Duran Espinoza', 'Lima', '3 ans'),
(2, 1, 'Fruit de la passion jaune', '/images/fruitDeLaPassionJaune.png', 3.50, 45, 0, 1, 2, 10, 42, 'Luis Urquiza', 'Lima', '2 ans'),
(3, 1, 'Orange', '/images/orange.png', 3.00, 60, 0, 0, 3, 12, 42, 'Yuliana Huaman Perez', 'Amazonas', '4 ans'),
(4, 1, 'Citron vert', '/images/citronVert.png', 9.00, 35, 0, 0, 1, 7, 42, 'Yuliana Huaman Perez', 'Amazonas', '4 ans'),
(5, 6, 'Laitue', '/images/laitue.png', 9.90, 30, 0, 0, 2, 9, 42, 'Yuliana Huaman Perez', 'Amazonas', '4 ans'),
(6, 5, 'Citrouille', '/images/citrouille.png', 3.00, 40, 0, 0, 2, 10, 42, 'KNIYOT', 'Lima', '5 ans'),
(7, 7, 'Raisin vert', '/images/raisinVert.png', 5.50, 55, 0, 1, 2, 11, 42, 'Carlos Mendoza', 'Lima', '2 ans'),
(8, 1, 'Pomme rouge', '/images/pommeRouge.png', 4.20, 70, 0, 0, 2, 8, 42, 'Pedro Ruiz', 'Cusco', '3 ans'),
(9, 1, 'Pomme', '/images/pomme.png', 4.00, 65, 0, 0, 3, 9, 42, 'Ana Torres', 'Lima', '2 ans'),
(10, 1, 'Pêche', '/images/peche.png', 6.00, 40, 0, 1, 2, 10, 42, 'Maria Flores', 'Arequipa', '4 ans'),
(11, 7, 'Lime', '/images/lime.png', 5.00, 75, 0, 0, 2, 8, 42, 'Jose Ramirez', 'Amazonas', '3 ans'),
(12, 8, 'Myrtilles', '/images/myrtilles.png', 8.50, 25, 0, 0, 2, 11, 42, 'Rosa Castillo', 'Cusco', '5 ans'),
(13, 5, 'Tomate', '/images/tomate.png', 3.99, 80, 0, 0, 2, 8, 42, 'KNIYOT', 'Lima', '5 ans'),
(14, 5, 'Blette', '/images/blette.png', 3.99, 45, 0, 1, 2, 9, 42, 'KNIYOT', 'Lima', '5 ans'),
(15, 5, 'Épinards', '/images/epinards.png', 5.90, 60, 0, 0, 2, 10, 42, 'KNIYOT', 'Lima', '5 ans'),
(16, 5, 'Céleri', '/images/celeri.png', 5.90, 40, 0, 0, 2, 9, 42, 'KNIYOT', 'Lima', '5 ans'),
(17, 5, 'Oignon rouge', '/images/oignonRouge.png', 25.90, 30, 0, 0, 1, 8, 42, 'KNIYOT', 'Lima', '5 ans'),
(18, 1, 'Raisin vert clair', '/images/raisinVertClair.png', 3.50, 50, 0, 0, 2, 8, 42, 'Jhaser Meza', 'Ica', '2 ans'),
(19, 1, 'Grenade', '/images/grenade.png', 8.00, 35, 0, 1, 2, 10, 42, 'Carlos Mendoza', 'Lima', '3 ans'),
(20, 1, 'Mangue', '/images/mangue.png', 4.90, 60, 0, 0, 3, 11, 42, 'Yuliana Huaman Perez', 'Amazonas', '4 ans'),
(21, 1, 'Avocat', '/images/avocat.png', 8.50, 45, 0, 0, 2, 10, 42, 'Jorge Duran Espinoza', 'Lima', '3 ans');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nom` (`nom`);

--
-- Indexes for table `produits`
--
ALTER TABLE `produits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categorie_id` (`categorie_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `produits`
--
ALTER TABLE `produits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `produits`
--
ALTER TABLE `produits`
  ADD CONSTRAINT `produits_ibfk_1` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
