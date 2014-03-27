-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2014 at 12:34 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `firechrome`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `content` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_comments_to_users` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `content` varchar(255) NOT NULL,
  `img_url` varchar(255) NOT NULL,
  `is_visible` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_news_to_users` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `user_id`, `title`, `date`, `content`, `img_url`, `is_visible`) VALUES
(3, 5, 'asodj', '2014-03-20 07:33:06', 'sdfiosd', 'http://localhost/FireChrome/FireChrome/uploads/logo2.jpg', NULL),
(4, 5, 'sdf', '2014-03-20 07:34:11', 'sdfsd', 'http://localhost/FireChrome/FireChrome/uploads/logo2.jpg', NULL),
(5, 5, 'sdgsdgsgg', '2014-03-20 07:35:06', 'sddfsdf', 'http://localhost/FireChrome/FireChrome/uploads/logo2.jpg', NULL),
(6, 5, 'sdffsdf', '2014-03-20 11:01:43', 'sdfdsfsdf', 'http://localhost/FireChrome/FireChrome/uploads/logo2.jpg', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `news_to_comment`
--

CREATE TABLE IF NOT EXISTS `news_to_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `news_id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `news_id` (`news_id`),
  KEY `comments_id` (`comment_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `temp_user`
--

CREATE TABLE IF NOT EXISTS `temp_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `key` varchar(255) CHARACTER SET ucs2 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `level` enum('1','5','10') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`, `level`) VALUES
(4, 'andres', '69fb46f4c18463dd25002aeffc0257d1', 'andres.taht@gmail.com', '10'),
(5, 'CoolestAdminEstPure22', '723e968696be2584f0b56a88d2c26091', 'pagel.marek@gmail.com', '10'),
(6, 'Raiko95', 'ae00e1441125999f6d6d8fcc41ebab3e', 'raiko.ilula@gmail.com', '1'),
(7, 'heavenzeyez1', 'a6878f2d8d0ccac81a675f294acb833b', 'eerik.muuli@gmail.com', '10'),
(8, 'hannes', 'c4ca4238a0b923820dcc509a6f75849b', 'hannesss81@gmail.com', '1'),
(9, 'u', '098f6bcd4621d373cade4e832627b4f6', 'u@u.com', '1'),
(10, 'e', '098f6bcd4621d373cade4e832627b4f6', 'e@e.com', '5');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
