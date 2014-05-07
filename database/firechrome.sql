-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 07, 2014 at 07:04 PM
-- Server version: 5.5.32
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `firechrome`
--
CREATE DATABASE IF NOT EXISTS `firechrome` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `firechrome`;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Avaleht'),
(2, 'Enim vaadatumad'),
(3, 'Eesti'),
(4, 'Välismaa'),
(5, 'Kultuur'),
(6, 'Sport'),
(7, 'Majandus'),
(8, 'Tehnika');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `news_id` int(11) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `content` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_comments_to_users` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id`, `user_id`, `news_id`, `date`, `content`) VALUES
(1, 4, NULL, '2014-03-27 08:39:13', 'test'),
(2, 4, NULL, '2014-03-27 12:02:58', '13'),
(3, 4, NULL, '2014-03-27 12:02:59', 'dfbfdb'),
(4, 4, NULL, '2014-03-27 12:03:45', 'hngfngfn'),
(5, 4, NULL, '2014-03-27 12:04:57', 'tere'),
(6, 4, NULL, '2014-04-01 15:31:24', '21'),
(8, 4, 10, '2014-04-23 10:16:47', 'tere');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `content` longtext NOT NULL,
  `img_url` varchar(255) NOT NULL,
  `view_count` int(11) NOT NULL,
  `is_visible` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_news_to_users` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `user_id`, `category_id`, `title`, `date`, `content`, `img_url`, `view_count`, `is_visible`) VALUES
(9, 4, 3, 'Uudis 1', '2014-03-25 15:24:03', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam rhoncus ac nunc id bibendum. Quisque feugiat, justo quis molestie sagittis, velit risus viverra est, sit amet feugiat diam risus sit amet tortor. Sed ac ligula non lectus lobortis tempor in v', 'http://localhost/FireChrome/uploads/minion.jpg', 3, 1),
(10, 4, 3, 'Uudis 2', '2014-03-25 15:40:14', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam rhoncus ac nunc id bibendum. Quisque feugiat, justo quis molestie sagittis, velit risus viverra est, sit amet feugiat diam risus sit amet tortor. Sed ac ligula non lectus lobortis tempor in v', 'http://localhost/FireChrome/uploads/hmd_logo.jpg', 3, 1),
(11, 4, 3, 'Uudis 3', '2014-03-25 15:44:34', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam rhoncus ac nunc id bibendum. Quisque feugiat, justo quis molestie sagittis, velit risus viverra est, sit amet feugiat diam risus sit amet tortor. Sed ac ligula non lectus lobortis tempor in v', 'http://localhost/FireChrome/uploads/minion.jpg', 4, 1),
(12, 4, 3, 'Uudis 4', '2014-03-25 15:45:14', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam rhoncus ac nunc id bibendum. Quisque feugiat, justo quis molestie sagittis, velit risus viverra est, sit amet feugiat diam risus sit amet tortor. Sed ac ligula non lectus lobortis tempor in v', 'http://localhost/FireChrome/uploads/hmd_logo.jpg', 2, 1),
(13, 4, 4, 'Uudis 5', '2014-03-25 15:46:34', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam rhoncus ac nunc id bibendum. Quisque feugiat, justo quis molestie sagittis, velit risus viverra est, sit amet feugiat diam risus sit amet tortor. Sed ac ligula non lectus lobortis tempor in v', 'http://localhost/FireChrome/uploads/minion.jpg', 2, 1),
(14, 4, 4, 'Uudis 6', '2014-03-25 15:40:14', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam rhoncus ac nunc id bibendum. Quisque feugiat, justo quis molestie sagittis, velit risus viverra est, sit amet feugiat diam risus sit amet tortor. Sed ac ligula non lectus lobortis tempor in v', 'http://localhost/FireChrome/uploads/hmd_logo.jpg', 1, 1),
(15, 4, 7, 'Uudis 7', '2014-03-25 15:47:34', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam rhoncus ac nunc id bibendum. Quisque feugiat, justo quis molestie sagittis, velit risus viverra est, sit amet feugiat diam risus sit amet tortor. Sed ac ligula non lectus lobortis tempor in v', 'http://localhost/FireChrome/uploads/minion.jpg', 2, 1),
(16, 4, 6, 'Uudis 8', '0000-00-00 00:00:00', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam rhoncus ac nunc id bibendum. Quisque feugiat, justo quis molestie sagittis, velit risus viverra est, sit amet feugiat diam risus sit amet tortor. Sed ac ligula non lectus lobortis tempor in v', 'http://localhost/FireChrome/uploads/hmd_logo.jpg', 2, 1),
(17, 4, 3, 'Uudis 9', '2014-03-25 15:50:34', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam rhoncus ac nunc id bibendum. Quisque feugiat, justo quis molestie sagittis, velit risus viverra est, sit amet feugiat diam risus sit amet tortor. Sed ac ligula non lectus lobortis tempor in v', 'http://localhost/FireChrome/uploads/minion.jpg', 1, 1),
(18, 4, 5, 'Uudis 10', '2014-03-25 16:00:14', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam rhoncus ac nunc id bibendum. Quisque feugiat, justo quis molestie sagittis, velit risus viverra est, sit amet feugiat diam risus sit amet tortor. Sed ac ligula non lectus lobortis tempor in v', 'http://localhost/FireChrome/uploads/hmd_logo.jpg', 1, 1),
(19, 4, 4, 'Uudis 11', '2014-03-25 16:05:34', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam rhoncus ac nunc id bibendum. Quisque feugiat, justo quis molestie sagittis, velit risus viverra est, sit amet feugiat diam risus sit amet tortor. Sed ac ligula non lectus lobortis tempor in v', 'http://localhost/FireChrome/uploads/minion.jpg', 4, 1),
(20, 4, 5, 'Uudis 12', '2014-03-25 16:10:14', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam rhoncus ac nunc id bibendum. Quisque feugiat, justo quis molestie sagittis, velit risus viverra est, sit amet feugiat diam risus sit amet tortor. Sed ac ligula non lectus lobortis tempor in v', 'http://localhost/FireChrome/uploads/hmd_logo.jpg', 2, 1),
(21, 4, 3, 'Uudis 13', '2014-03-25 16:15:34', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam rhoncus ac nunc id bibendum. Quisque feugiat, justo quis molestie sagittis, velit risus viverra est, sit amet feugiat diam risus sit amet tortor. Sed ac ligula non lectus lobortis tempor in v', 'http://localhost/FireChrome/uploads/minion.jpg', 2, 1),
(22, 4, 4, 'Uudis 14', '2014-03-25 16:20:14', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam rhoncus ac nunc id bibendum. Quisque feugiat, justo quis molestie sagittis, velit risus viverra est, sit amet feugiat diam risus sit amet tortor. Sed ac ligula non lectus lobortis tempor in v', 'http://localhost/FireChrome/uploads/bc_cover.png', 4, 1),
(23, 4, 5, 'Uudis 15', '2014-03-25 16:25:34', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam rhoncus ac nunc id bibendum. Quisque feugiat, justo quis molestie sagittis, velit risus viverra est, sit amet feugiat diam risus sit amet tortor. Sed ac ligula non lectus lobortis tempor in vLorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam rhoncus ac nunc id bibendum. Quisque feugiat, justo quis molestie sagittis, velit risus viverra est, sit amet feugiat diam risus sit amet tortor. Sed ac ligula non lectus lobortis tempor in vLorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam rhoncus ac nunc id bibendum. Quisque feugiat, justo quis molestie sagittis, velit risus viverra est, sit amet feugiat diam risus sit amet tortor. Sed ac ligula non lectus lobortis tempor in vLorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam rhoncus ac nunc id bibendum. Quisque feugiat, justo quis molestie sagittis, velit risus viverra est, sit amet feugiat diam risus sit amet tortor. Sed ac ligula non lectus lobortis tempor in vLorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam rhoncus ac nunc id bibendum. Quisque feugiat, justo quis molestie sagittis, velit risus viverra est, sit amet feugiat diam risus sit amet tortor. Sed ac ligula non lectus lobortis tempor in vLorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam rhoncus ac nunc id bibendum. Quisque feugiat, justo quis molestie sagittis, velit risus viverra est, sit amet feugiat diam risus sit amet tortor. Sed ac ligula non lectus lobortis tempor in v', 'http://localhost/FireChrome/uploads/minion.jpg', 1, 1),
(26, 4, 8, 'test', '2014-04-23 10:17:20', 'joujou', 'http://localhost/FireChrome/uploads/pidu.jpg', 1, 1);

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
  `wants_newsletter` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `facebook_id` int(11) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `level` enum('1','5','10') NOT NULL,
  `wants_newsletter` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `facebook_id`, `username`, `password`, `email`, `level`, `wants_newsletter`) VALUES
(4, NULL, 'andres', 'e391ce69317202e6840cb217f7283b56', 'andres.taht@gmail.com', '10', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
