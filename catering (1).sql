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

INSERT INTO `addcard` (`id`, `name`, `rating`, `amount`, `description`, `img_src`, `status`) VALUES
(1, 'Elite Feast Catering', 4.8, 35000, 'Premium catering for weddings & corporate events.', 'images/elite-feast.png', 0),
(2, 'Spicy Spoon', 4.5, 18000, 'Best known for flavorful Indian vegetarian meals.', 'images/spicy-spoon.png', 0),
(3, 'Royal Dine', 4.7, 30000, 'Luxury buffet with live counters and mocktails.', 'images/royal-dine.png', 0),
(4, 'Veggie Delights', 4.2, 15000, 'Pure veg catering for family functions.', 'images/veggie-delights.png', 0),
(5, 'Non-Veg Nirvana', 4.6, 28000, 'Chicken, mutton, and seafood specialties.', 'images/nonveg-nirvana.png', 0),
(6, 'Grand Platter', 4.9, 40000, 'Multi-cuisine buffet with full-service staff.', 'images/grand-platter.png', 0),
(7, 'South Spice', 4.4, 16000, 'Authentic South Indian meals with banana leaf serving.', 'images/south-spice.png', 0),
(8, 'Taste & Toast', 4.3, 20000, 'Elegant catering for engagement parties.', 'images/taste-toast.png', 0),
(9, 'Urban Thali', 4.1, 13000, 'North Indian thali-style buffet for small events.', 'images/urban-thali.png', 0),
(10, 'The Grill Station', 4.5, 27000, 'BBQ and grilled delicacies with live counters.', 'images/grill-station.png', 0),
(11, 'Royal Rasoi', 4.6, 25000, 'Rajasthani & Gujarati wedding specials.', 'images/royal-rasoi.png', 0),
(12, 'Dine Divine', 4.7, 33000, 'Full-service catering with chef-curated menus.', 'images/dine-divine.png', 0),
(13, 'Flavors & Forks', 4.3, 19000, 'Indo-Chinese fusion and fast catering.', 'images/flavors-forks.png', 0),
(14, 'Continental Catering Co.', 4.8, 37000, 'Italian, Mexican, and continental specialties.', 'images/continental-catering.png', 0),
(15, 'Biryani Bistro', 4.4, 21000, 'Dum biryani, kebabs, and rich non-veg feasts.', 'images/biryani-bistro.png', 0),
(16, 'Sweet & Savory', 4.1, 17000, 'Snacks, sweets, and light meal catering.', 'images/sweet-savory.png', 0),
(17, 'Five Star Feasts', 5, 50000, '5-star hotel-style presentation and dishes.', 'images/five-star-feasts.png', 0),
(18, 'Harvest Catering', 4.2, 18500, 'Organic and healthy menu options.', 'images/harvest-catering.png', 0),
(19, 'IndoBites', 4.3, 22000, 'Fast Indian street-style catering with class.', 'images/indobites.png', 0),
(20, 'Maharaja Meals', 4.6, 29000, 'Royal Indian wedding spread with staff.', 'images/maharaja-meals.png', 0),
(21, 'kumar', 4, 1234, 'dtrjfythkjhtg', 'images/elite-feast.jpg', 1),
(22, 'adkumar', 3, 1234, 'abcdefghijklmnopqrstuvwxyz', 'images/elite-feast.jpg', 1),
(23, 'kumar', 4, 1234, 'abcdefghijklmnopqrstuvwxyz', 'images/elite-feast.jpg', 1),
(24, 'kumar', 4, 1234, 'abcdefghijklmnopqrstuvwxyz', 'images/elite-feast.jpg', 1),
(25, 'kumar', 4, 1234, 'asdfgdsv', 'images/elite-feast.jpg', 1),
(26, 'kumar', 4, 1234, 'asdfghjk', 'images/elite-feast.jpg', 1),
(27, 'kumar1', 4, 1234, 'asdfghjk', 'images/elite-feast.jpg', 1),
(28, 'kumar2', 4, 1234, 'asdfgbn', 'images/elite-feast.jpg', 1),
(29, 'kumar123', 5, 4356, 'jhkjh', 'images/elite-feast.jpg', 1),
(30, 'kumar555', 1, 1, '1', 'images/elite-feast.jpg', 1),
(31, 'kumar55', 1, 1, '1', 'images/elite-feast.jpg', 1),
(32, 'kumar551', 1, 1, '1', 'images/elite-feast.jpg', 1),
(33, 'kumar550', 1, 1, '1', 'images/elite-feast.jpg', 1),
(34, 'kumar549', 1, 1, '1', 'images/elite-feast.jpg', 1),
(35, '548', 1, 1, '1', 'images/elite-feast.jpg', 1),
(36, 'kumar548', 1, 1, '1', 'images/elite-feast.jpg', 1),
(37, 'kumar547', 1, 1, '1', 'images/elite-feast.jpg', 1),
(38, 'kumar546', 1, 1, '1', 'images/elite-feast.jpg', 1),
(39, 'kumar545', 1, 1, '1', 'images/elite-feast.jpg', 1),
(40, 'kumar544', 2, 2, '2', 'images/elite-feast.jpg', 1),
(41, 'kumar543', 2, 2, '2', 'images/elite-feast.jpg', 1),
(42, 'kumar542', 2, 12, '12', 'images/elite-feast.jpg', 1),
(43, 'kumar541', 1, 1, '1', 'images/elite-feast.jpg', 1),
(44, 'kumar540', 1, 1, '1', 'images/elite-feast.jpg', 1),
(45, 'kumar539', 1, 1, '1', 'images/elite-feast.jpg', 1),
(46, 'kumar538', 1, 1, '1', 'images/elite-feast.jpg', 1),
(47, 'kumar537', 1, 1, '1', 'images/elite-feast.jpg', 1);

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
(1, '4', 'Elite Feast Catering', 'adk972002@gmail.com', 'kumar', '1.00', '1.0', '1', 'C:\\wamp64\\www\\catering\\agent/uploads/1755845279_ChatGPT Image Jul 31, 2025, 06_30_22 PM.pdf', '2025-08-22 06:47:59');

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
(1, 2, 'Taste & Toast', '24500.00', 'marriage', '2025-08-20', 10, 0, 0, 'veg-2', '', '', 'Table Service', 40, 36, 'Aloo Gobi, Roti, Gulab Jamun', 0),
(2, 4, 'Grand Platter', '15500.00', 'marriage', '2025-08-31', 0, 20, 0, '', 'nonveg-2', '', 'Buffet', 10, 5, 'Mutton Masala, Fried Rice, Kebab, chicken biriyani, chicken 65, onion raita', 0),
(3, 1, 'Elite Feast Catering', '125000.00', 'marriage', '2025-08-20', 500, 0, 0, '', 'nonveg-2', '', 'Table Service', 0, 0, 'Mutton Masala, Fried Rice, Kebab', 0),
(4, 1, 'Veggie Delights', '50000.00', 'marriage', '2025-08-29', 500, 0, 0, '', '', 'mixed-2', 'Table Service', 0, 0, 'Chole, Jeera Rice, Mutton Masala, Fried Rice, Kebab', 0),
(5, 1, 'Veggie Delights', '12500.00', 'marriage', '2025-08-28', 0, 50, 0, '', 'nonveg-2', '', 'Table Service', 0, 0, 'Mutton Masala, Fried Rice, Kebab', 0),
(6, 1, 'Harvest Catering', '11000.00', 'marriage', '2025-08-31', 10, 0, 0, '', 'nonveg-1', '', 'Buffet', 10, 50, 'Chicken Curry, Chicken Biryani, Raita', 0),
(7, 1, 'Spicy Spoon', '50000.00', 'marriage', '2025-09-07', 500, 0, 0, 'veg-2', '', '', 'Table Service', 0, 0, 'Aloo Gobi, Roti, Gulab Jamun', 0),
(8, 1, 'Harvest Catering', '50000.00', 'marriage', '2025-09-12', 500, 0, 0, 'veg-1', '', '', 'Buffet', 0, 0, 'Paneer Butter Masala, Dal Tadka, Veg Pulao', 1),
(9, 1, 'Harvest Catering', '50000.00', 'marriage', '2025-09-01', 500, 0, 0, '', '', 'mixed-2', 'Table Service', 0, 0, 'Chole, Jeera Rice, Mutton Masala, Fried Rice, Kebab', 0),
(10, 1, 'Harvest Catering', '29500.00', 'marriage', '2025-09-03', 0, 90, 0, '', 'nonveg-1', '', 'Table Service', 10, 28, 'Chicken Curry, Chicken Biryani, Raita', 0),
(11, 1, 'Harvest Catering', '50000.00', 'marriage', '2025-09-04', 500, 0, 0, 'veg-1', '', '', 'Table Service', 0, 0, 'Paneer Butter Masala, Dal Tadka, Veg Pulao', 0),
(12, 1, 'Sweet & Savory', '9000.00', 'marriage', '2025-08-30', 0, 90, 0, '', '', 'mixed-2', 'Table Service', 0, 0, 'Chole, Jeera Rice, Mutton Masala, Fried Rice, Kebab', 0),
(13, 1, 'Elite Feast Catering', '29500.00', 'marriage', '2025-08-19', 0, 0, 60, '', '', 'mixed-2', 'Table Service', 40, 50, 'Chole, Jeera Rice, Mutton Masala, Fried Rice, Kebab', 0),
(14, 1, 'Royal Dine', '12500.00', 'marriage', '2025-08-19', 0, 50, 0, '', 'nonveg-1', '', 'Table Service', 0, 0, 'Chicken Curry, Chicken Biryani, Raita', 0),
(15, 1, 'Grand Platter', '125000.00', 'marriage', '2025-08-20', 500, 0, 0, '', 'nonveg-1', '', 'Table Service', 0, 0, 'Chicken Curry, Chicken Biryani, Raita', 0),
(16, 1, 'Spicy Spoon', '1000.00', 'marriage', '2025-08-30', 10, 0, 0, 'veg-2', '', '', 'Buffet', 0, 0, 'Aloo Gobi, Roti, Gulab Jamun', 0),
(17, 1, 'Non-Veg Nirvana', '125000.00', 'marriage', '2025-09-05', 500, 0, 0, '', 'nonveg-2', '', 'Table Service', 0, 0, 'Mutton Masala, Fried Rice, Kebab', 0),
(18, 1, 'IndoBites', '28000.00', 'marriage', '2025-08-29', 0, 0, 60, '', '', 'mixed-2', 'Table Service', 40, 28, 'Chole, Jeera Rice, Mutton Masala, Fried Rice, Kebab', 0),
(19, 1, 'Spicy Spoon', '125000.00', 'marriage', '2025-08-29', 500, 0, 0, '', 'nonveg-2', '', 'Table Service', 0, 0, 'Mutton Masala, Fried Rice, Kebab', 0),
(20, 1, 'Dine Divine', '150000.00', 'marriage', '2025-08-30', 0, 500, 0, '', 'nonveg-2', '', 'Table Service', 0, 0, 'Mutton Masala, Fried Rice, Kebab', 0),
(21, 1, 'Taste & Toast', '73500.00', 'marriage', '2025-08-30', 500, 0, 0, '', '', 'mixed-2', 'Table Service', 40, 50, 'Chole, Jeera Rice, Mutton Masala, Fried Rice, Kebab', 1),
(22, 1, 'Dine Divine', '1000.00', 'marriage', '2025-08-30', 10, 0, 0, 'veg-1', '', '', 'Table Service', 0, 0, 'Paneer Butter Masala, Dal Tadka, Veg Pulao', 0),
(23, 1, 'Dine Divine', '2000.00', 'marriage', '2025-08-30', 0, 20, 0, '', '', 'mixed-2', 'Table Service', 0, 0, 'Chole, Jeera Rice, Mutton Masala, Fried Rice, Kebab', 0),
(24, 1, 'Elite Feast Catering', '21000.00', 'marriage', '2025-09-13', 10, 20, 30, '', 'nonveg-2', '', 'Buffet', 5, 50, 'Mutton Masala, Fried Rice, Kebab', 0),
(25, 1, 'Elite Feast Catering', '50000.00', 'marriage', '2025-09-28', 500, 0, 0, '', '', 'mixed-2', 'Buffet', 0, 0, 'Chole, Jeera Rice, Mutton Masala, Fried Rice, Kebab', 0),
(26, 1, 'Elite Feast Catering', '24500.00', 'marriage', '2025-09-19', 10, 0, 0, '', '', 'mixed-2', 'Buffet', 40, 50, 'Chole, Jeera Rice, Mutton Masala, Fried Rice, Kebab', 0),
(27, 1, 'Elite Feast Catering', '170000.00', 'marriage', '2025-09-24', 0, 600, 0, '', 'nonveg-1', '', 'Table Service', 40, 0, 'Chicken Curry, Chicken Biryani, Raita', 0);

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
(1, 'kumar', '9573595935', 'kumaraveluad@gmail.com', 'kumar@123', 'user', '2025-08-19 12:26:24', 0),
(2, 'Admin', '1234567890', 'adk9720021@gmail.com', 'Admin@123', 'admin', '2025-08-20 06:17:56', 0),
(4, 'kumar', '9573595934', 'adk972002@gmail.com', 'Kumar@123', 'agent', '2025-08-20 15:31:08', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
