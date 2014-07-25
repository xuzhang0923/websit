-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 25, 2014 at 11:44 AM
-- Server version: 5.6.14
-- PHP Version: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `Users`
--

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE IF NOT EXISTS `cars` (
  `phone` varchar(13) NOT NULL,
  `day` varchar(20) NOT NULL,
  `time` varchar(32) NOT NULL,
  `fromto` int(11) NOT NULL,
  `totalseat` int(11) NOT NULL,
  `details` text NOT NULL,
  PRIMARY KEY (`phone`,`day`,`fromto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`phone`, `day`, `time`, `fromto`, `totalseat`, `details`) VALUES
('123456789', '2014-07-09', '1', 2, 4, 'gfdg'),
('123456789', '2014-07-10', '1', 1, 0, 'dsfa'),
('123456789', '2014-07-10', '1', 2, 0, 'dsfa'),
('123456789', '2014-07-11', '1', 1, 0, 'dfs'),
('123456789', '2014-07-11', '1', 2, 0, 'fgdg'),
('123456789', '2014-07-13', '1', 1, 4, 'sdfdsf'),
('18811799866', '2014-07-18', '1', 1, 44, 'fghdf'),
('18811799866', '2014-07-19', '1', 1, 84, '156'),
('18811799867', '2014-07-13', '1', 1, 6, 'cxv'),
('18811799867', '2014-07-13', '1', 2, 8, 'dsfs'),
('18811799867', '2014-07-15', '1', 1, 6, '000'),
('18811799867', '2014-07-15', '1', 2, 9, 'gj'),
('18811799867', '2014-07-18', '1', 1, 0, 'hngvj'),
('18811799867', '2014-07-18', '1', 2, 5, 'fg'),
('18811799867', '2014-07-22', '1', 1, 8, 'fghj'),
('18811799867', '2014-07-24', '1', 1, 9, 'dsfgdsg'),
('18811799867', '2014-07-24', '1', 2, 22, 'dgdsg');

-- --------------------------------------------------------

--
-- Table structure for table `subscribedInformation`
--

CREATE TABLE IF NOT EXISTS `subscribedInformation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subscriber` varchar(20) NOT NULL,
  `publisher` varchar(20) NOT NULL,
  `day` varchar(20) NOT NULL,
  `fromto` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=38 ;

--
-- Dumping data for table `subscribedInformation`
--

INSERT INTO `subscribedInformation` (`id`, `subscriber`, `publisher`, `day`, `fromto`) VALUES
(1, '18811799866', '18811799867', '2014-07-18', 1),
(2, '18811799866', '18811799867', '2014-07-18', 1),
(3, '18811799866', '18811799867', '2014-07-18', 1),
(36, '18811799867', '18811799867', '2014-07-24', 1),
(37, '18811799867', '18811799867', '2014-07-24', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `phone` varchar(20) NOT NULL,
  `name` text CHARACTER SET gbk NOT NULL,
  `password` varchar(20) NOT NULL,
  PRIMARY KEY (`phone`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`phone`, `name`, `password`) VALUES
('18811765234', 'test', '8226371'),
('18811799854', 'test', '8226371'),
('18811799866', 'test', '8226371'),
('18811799867', 'test', '8226371'),
('18811799868', 'test', '8226371');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
