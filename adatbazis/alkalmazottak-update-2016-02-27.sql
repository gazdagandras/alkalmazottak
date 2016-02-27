-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 27, 2016 at 10:45 AM
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
-- Table structure for table `felhasznalok`
--

CREATE TABLE IF NOT EXISTS `felhasznalok` (
  `felhasznalonev` varchar(30) NOT NULL,
  `jelszo` varchar(32) NOT NULL,
  `email` varchar(254) NOT NULL,
  PRIMARY KEY (`felhasznalonev`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `felhasznalok`
--

INSERT INTO `felhasznalok` (`felhasznalonev`, `jelszo`, `email`) VALUES
('admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@localhost');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
