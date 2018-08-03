-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Host: sql210.byethost.com
-- Generation Time: Aug 03, 2018 at 07:31 AM
-- Server version: 5.6.35-81.0
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `b4_17985098_tests`
--

-- --------------------------------------------------------

--
-- Table structure for table `Jautajumi`
--

CREATE TABLE IF NOT EXISTS `Jautajumi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jautajums` varchar(200) NOT NULL,
  `tests` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `Jautajumi`
--

INSERT INTO `Jautajumi` (`id`, `jautajums`, `tests`) VALUES
(1, '1. jautajums', 1),
(2, '2. jautajums', 1),
(3, '3. jautajums', 1),
(4, '4. jautajums', 1),
(5, '1. jautajums', 2),
(6, '2. jautajums', 2),
(7, '3. jautajums', 2),
(8, '1. jautajums', 3),
(9, '2. jautajums', 3),
(10, '3. jautajums', 3),
(11, '4. jautajums', 3);

-- --------------------------------------------------------

--
-- Table structure for table `Rezultati`
--

CREATE TABLE IF NOT EXISTS `Rezultati` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tests` int(11) NOT NULL,
  `jautajums` int(11) NOT NULL,
  `atbilde` int(11) NOT NULL,
  `lietotajs` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `testi`
--

CREATE TABLE IF NOT EXISTS `testi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8_latvian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_latvian_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `testi`
--

INSERT INTO `testi` (`id`, `name`) VALUES
(1, 'Pirmais tests'),
(2, 'Otrais tests'),
(3, 'Tresais tests');

-- --------------------------------------------------------

--
-- Table structure for table `VisasAtbildes`
--

CREATE TABLE IF NOT EXISTS `VisasAtbildes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tests` int(11) NOT NULL,
  `atbilde` varchar(100) NOT NULL,
  `pareiza` int(11) NOT NULL,
  `jautajums` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=51 ;

--
-- Dumping data for table `VisasAtbildes`
--

INSERT INTO `VisasAtbildes` (`id`, `tests`, `atbilde`, `pareiza`, `jautajums`) VALUES
(1, 1, 'Atbilde 1', 1, 1),
(2, 1, 'Atbilde 2', 0, 1),
(3, 1, 'Atbilde 3', 0, 1),
(4, 1, 'Atbilde 4', 0, 1),
(5, 1, 'Atbilde 1', 0, 2),
(6, 1, 'Atbilde 2', 1, 2),
(7, 1, 'Atbilde 3', 0, 2),
(8, 1, 'Atbilde 4', 0, 2),
(9, 1, 'Atbilde 1', 0, 3),
(10, 1, 'Atbilde 2', 0, 3),
(11, 1, 'Atbilde 3', 1, 3),
(12, 1, 'Atbilde 4', 0, 3),
(13, 1, 'Atbilde 1', 1, 4),
(14, 1, 'Atbilde 2', 0, 4),
(15, 1, 'Atbilde 3', 0, 4),
(16, 1, 'Atbilde 4', 0, 4),
(17, 2, 'Atbilde 1', 1, 5),
(18, 2, 'Atbilde 2', 0, 5),
(19, 2, 'Atbilde 3', 0, 5),
(20, 2, 'Atbilde 4', 0, 5),
(21, 2, 'Atbilde 1', 0, 6),
(22, 2, 'Atbilde 2', 0, 6),
(23, 2, 'Atbilde 3', 1, 6),
(24, 2, 'Atbilde 4', 0, 6),
(25, 2, 'Atbilde 1', 1, 7),
(26, 2, 'Atbilde 2', 0, 7),
(27, 2, 'Atbilde 3', 0, 7),
(28, 2, 'Atbilde 4', 0, 7),
(29, 3, 'Atbilde 1', 1, 8),
(30, 3, 'Atbilde 2', 0, 8),
(31, 3, 'Atbilde 3', 0, 8),
(32, 3, 'Atbilde 4', 0, 8),
(33, 3, 'Atbilde 1', 0, 9),
(34, 3, 'Atbilde 2', 1, 9),
(35, 3, 'Atbilde 3', 0, 9),
(36, 3, 'Atbilde 4', 0, 9),
(37, 3, 'Atbilde 1', 0, 10),
(38, 3, 'Atbilde 2', 0, 10),
(39, 3, 'Atbilde 3', 1, 10),
(40, 3, 'Atbilde 4', 0, 10),
(41, 3, 'Atbilde 1', 1, 11),
(42, 3, 'Atbilde 2', 0, 11),
(43, 3, 'Atbilde 3', 0, 11),
(44, 3, 'Atbilde 4', 0, 11),
(45, 1, 'Atbilde 5', 0, 1),
(46, 1, 'Atbilde 6', 0, 1),
(47, 1, 'Atbilde 7', 0, 1),
(48, 1, 'Atbilde 5', 0, 2),
(49, 1, 'Atbilde 6', 0, 2),
(50, 1, 'Atbilde 5', 0, 3);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
