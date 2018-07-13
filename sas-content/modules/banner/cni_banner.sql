-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 09, 2017 at 10:36 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `aprofile`
--

-- --------------------------------------------------------

--
-- Table structure for table `sas_banner`
--

CREATE TABLE IF NOT EXISTS `sas_banner` (
  `banner_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `banner_title` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `banner_link` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `banner_image` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `banner_order` tinyint(3) unsigned NOT NULL,
  `banner_position` enum('top','left','bottom','right') COLLATE latin1_general_ci NOT NULL,
  `publish` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`banner_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=90 ;

--
-- Dumping data for table `sas_banner`
--

INSERT INTO `sas_banner` (`banner_id`, `banner_title`, `banner_link`, `banner_image`, `banner_order`, `banner_position`, `publish`) VALUES
(87, 'blablabla', '#', '20150901073018.png', 0, 'right', 1),
(88, 'vdsvds', '#', '20161117032109.jpg', 0, 'top', 0),
(89, 'ugut', '#', '20161117032618.jpg', 0, 'bottom', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
