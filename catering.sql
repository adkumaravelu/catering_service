-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 25, 2025 at 02:27 PM
-- Server version: 5.7.24
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `catering`
--

-- --------------------------------------------------------

--
-- Table structure for table `addcard`
--

DROP TABLE IF EXISTS `addcard`;
CREATE TABLE IF NOT EXISTS `addcard` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `rating` float NOT NULL,
  `amount` int(11) DEFAULT NULL,
  `description` text,
  `img_src` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `addcard`
--

INSERT INTO `addcard` (`id`, `name`, `rating`, `amount`, `description`, `img_src`, `status`) VALUES ();

-- --------------------------------------------------------

--
-- Table structure for table `agent_request`
--

DROP TABLE IF EXISTS `agent_request`;
CREATE TABLE IF NOT EXISTS `agent_request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agent_id` varchar(50) NOT NULL,
  `agent_name` varchar(100) NOT NULL,
  `agent_email` varchar(150) NOT NULL,
  `catering_name` varchar(150) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `rating` decimal(2,1) NOT NULL,
  `description` text,
  `pdf_file` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `agent_request`
--

INSERT INTO `agent_request` (`id`, `agent_id`, `agent_name`, `agent_email`, `catering_name`, `amount`, `rating`, `description`, `pdf_file`, `created_at`) VALUES
();

-- --------------------------------------------------------

--
-- Table structure for table `register`
--

DROP TABLE IF EXISTS `register`;
CREATE TABLE IF NOT EXISTS `register` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `service_name` varchar(255) NOT NULL DEFAULT 'Unknown Service',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `event_name` varchar(255) NOT NULL DEFAULT 'Unknown Event',
  `event_date` date NOT NULL DEFAULT '2025-01-01',
  `morning_persons` int(11) DEFAULT '0',
  `afternoon_persons` int(11) DEFAULT '0',
  `night_persons` int(11) DEFAULT '0',
  `veg_menu` varchar(255) DEFAULT '',
  `nonveg_menu` varchar(255) DEFAULT '',
  `mixed_menu` varchar(255) DEFAULT '',
  `service_type` varchar(255) DEFAULT '',
  `cating_service` int(11) DEFAULT '0',
  `traveling_distance` int(11) DEFAULT '0',
  `menu_items` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `register`
--

INSERT INTO `register` (`id`, `user_id`, `service_name`, `amount`, `event_name`, `event_date`, `morning_persons`, `afternoon_persons`, `night_persons`, `veg_menu`, `nonveg_menu`, `mixed_menu`, `service_type`, `cating_service`, `traveling_distance`, `menu_items`, `status`) VALUES
();

-- --------------------------------------------------------

--
-- Table structure for table `signup`
--

DROP TABLE IF EXISTS `signup`;
CREATE TABLE IF NOT EXISTS `signup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `signup`
--

INSERT INTO `signup` (`id`, `name`, `phone`, `email`, `password`, `role`, `created_at`, `status`) VALUES
();
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
