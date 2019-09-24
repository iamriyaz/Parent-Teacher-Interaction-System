-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 24, 2018 at 02:42 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ptis`
--
CREATE DATABASE `ptis` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `ptis`;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `password`) VALUES
('root', '12345');

-- --------------------------------------------------------

--
-- Table structure for table `assignclass`
--

CREATE TABLE IF NOT EXISTS `assignclass` (
  `std` int(10) NOT NULL,
  `div` varchar(5) NOT NULL,
  `sub` varchar(50) NOT NULL,
  `faculty_no` int(10) NOT NULL,
  `id` int(10) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `faculty_no` (`faculty_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE IF NOT EXISTS `attendance` (
  `regno` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `status` varchar(20) NOT NULL,
  `performance` text,
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`regno`, `date`, `status`, `performance`, `ID`) VALUES
('reg666', '2018-01-15', 'Present', NULL, 1),
('36', '2018-01-01', 'Present', NULL, 2),
('34', '2018-01-10', 'Present', 'good', 3),
('0', '2018-01-08', 'Present', 'wcd', 4),
('34', '2018-01-17', 'Absent', 'wsw', 5);

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE IF NOT EXISTS `chats` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `subject` varchar(50) NOT NULL,
  `from_user` varchar(25) NOT NULL,
  `recipient` varchar(25) NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE IF NOT EXISTS `event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `caption` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `description` varchar(100) NOT NULL,
  `photo` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id`, `caption`, `date`, `description`, `photo`) VALUES
(4, 'CYFEST', '2018-01-12', 'CY', '1280x720-dataout574406748-art-wallpaper.jpg'),
(5, 'nothing', '2016-02-23', 'dfghjk', 'Untitled-2t.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE IF NOT EXISTS `feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `feedback` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE IF NOT EXISTS `gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `photo` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `photo`, `description`) VALUES
(1, 'first.jpg', 'ngjghm'),
(4, 'android_motherboard-wallpaper-1920x1200.jpg', 'delkk'),
(5, 'Untitled-2.jpg', '12345');

-- --------------------------------------------------------

--
-- Table structure for table `groupmsg`
--

CREATE TABLE IF NOT EXISTS `groupmsg` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `sub` varchar(50) NOT NULL,
  `msg` text NOT NULL,
  `from` varchar(30) NOT NULL,
  `to` varchar(30) NOT NULL,
  `division` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `groupmsg`
--



-- --------------------------------------------------------

--
-- Table structure for table `parent`
--

CREATE TABLE IF NOT EXISTS `parent` (
  `Ration_card_no` varchar(20) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `address` varchar(150) NOT NULL,
  `phone_no` varchar(15) NOT NULL,
  `e_mail` varchar(15) NOT NULL,
  `relation` varchar(15) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `occupation` varchar(15) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `verified` tinyint(1) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `parent`
--



-- --------------------------------------------------------

--
-- Table structure for table `scoresheet`
--

CREATE TABLE IF NOT EXISTS `scoresheet` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `RegNO` varchar(15) NOT NULL,
  `Subject` int(11) NOT NULL,
  `Mark` decimal(4,2) NOT NULL,
  `Grade` char(1) NOT NULL,
  `Teacher` varchar(50) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `scoresheet`
--



-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `Ration_card_no` varchar(20) NOT NULL,
  `reg_no` varchar(15) NOT NULL,
  `roll_no` int(11) NOT NULL,
  `name` varchar(25) NOT NULL,
  `addres` varchar(150) NOT NULL,
  `admn_date` date NOT NULL,
  `gender` varchar(10) NOT NULL,
  `dob` date NOT NULL,
  `parent_username` varchar(25) NOT NULL,
  `standard` int(11) NOT NULL,
  `division` varchar(5) NOT NULL,
  `blood_group` varchar(5) NOT NULL,
  `religion` varchar(15) NOT NULL,
  `caste` varchar(15) NOT NULL,
  PRIMARY KEY (`reg_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--



-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE IF NOT EXISTS `subject` (
  `sub_code` int(11) NOT NULL AUTO_INCREMENT,
  `sub_name` varchar(25) NOT NULL,
  `standard` int(10) NOT NULL,
  PRIMARY KEY (`sub_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=326 ;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`sub_code`, `sub_name`, `standard`) VALUES
(12, 'C++', 12),
(13, 'C', 11),
(14, 'Physics', 8),
(325, 'java', 12);

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE IF NOT EXISTS `teacher` (
  `faculty_no` int(15) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `address` varchar(150) NOT NULL,
  `phone_no` varchar(15) NOT NULL,
  `e_mail` varchar(25) NOT NULL,
  `experience` int(11) NOT NULL,
  `qualification` varchar(30) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `is_class_teacher` tinyint(1) NOT NULL,
  `standard` varchar(5) DEFAULT NULL,
  `division` varchar(5) DEFAULT NULL,
  `username` varchar(15) NOT NULL,
  `password` varchar(15) NOT NULL,
  `subject` varchar(15) NOT NULL,
  PRIMARY KEY (`faculty_no`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `teacher`
--



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
