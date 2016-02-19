-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 19, 2016 at 05:54 PM
-- Server version: 5.5.47-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `alkalmazottak`
--

-- --------------------------------------------------------

--
-- Table structure for table `alkalmazottak_adatai`
--

CREATE TABLE IF NOT EXISTS `alkalmazottak_adatai` (
  `nev` varchar(50) NOT NULL,
  `irszam` varchar(4) NOT NULL,
  `telepules` varchar(30) NOT NULL,
  `cim` varchar(50) NOT NULL,
  `telefon` varchar(20) NOT NULL,
  `email` varchar(254) NOT NULL,
  `szuletesi_hely` varchar(30) NOT NULL,
  `szuletesi_ido` date NOT NULL,
  `anyja_neve` varchar(50) NOT NULL,
  `bankszamla` varchar(26) NOT NULL,
  `brutto_ber` int(11) NOT NULL,
  `munkaviszony_kezdete` date NOT NULL,
  `szemelyig_szam` varchar(8) NOT NULL,
  `heti_munkaora` float NOT NULL,
  PRIMARY KEY (`szemelyig_szam`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
