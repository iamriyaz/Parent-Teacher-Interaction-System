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

INSERT INTO `groupmsg` (`id`, `sub`, `msg`, `from`, `to`, `division`) VALUES
(1, 'ytrhy', 'ytrhy', 'ytrhy', 'ytrhy', ''),
(2, 'hi', 'jhgjhg', 'swapna123', '8', 'C'),
(3, 'hi', 'hgfjh', 'swapna123', '8', 'C');

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

INSERT INTO `parent` (`Ration_card_no`, `first_name`, `last_name`, `address`, `phone_no`, `e_mail`, `relation`, `gender`, `occupation`, `username`, `password`, `verified`) VALUES
('', 'ajay', 'anand', 'tyggh', '123456678', 'a@g.c', 'Father', 'Male', 'director', 'ajay1', '123456', 1),
('', 'dfsd', 'dfgd', 'dfgfh\r\nftyj\r\n', '3456787654', 'vbcvbvf', 'Father', 'Other', 'fxfgb', 'asd', 'asdfgh', 1),
('', 'biju', 'vr', 'ambadi housecherakkapparamb postangadippuramperinthalmannamalappuramkerala', '9867753244', 'biju123@gmail.c', 'Father', 'Male', 'police officer', 'biju123', 'biju123', 1),
('', 'raman', 'v', 'vailongara', '8790876543', 'raman12@gmail.c', 'Father', 'Male', 'bjhcysdfcuy', 'raman', '1234567', 1),
('', 'Ravindran', 'V', 'Vailongara\r\ncherakkapparamb\r\nangadippuram\r\nperinthalamanna', '9539150320', 'ravindran@g.c', 'Father', 'Male', 'Dance Master', 'ravi123', 'kkkkk', 1),
('', 'ravindran', 'v', 'vailonrgar \r\ncherakkapparamb\r\nangadippuram', '9539150320', 'ravindran@gmail', 'Father', 'Male', 'dance master', 'ravindran123', 'zxcvb', 1),
('', 'sukumaran', 't', 'thekknkittil houe', '8075344314', 'sukumaran123@gm', 'Father', 'Male', 'driver', 'suku', 'suku', 1),
('', 'vijay', 'v', 'crgvcgv ', '4567898765', 'vgfdg  kjj', 'Gardian', 'Male', 'biu', 'vij12', 'asdfghjkl', 1);

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

INSERT INTO `scoresheet` (`ID`, `RegNO`, `Subject`, `Mark`, `Grade`, `Teacher`) VALUES
(1, '36', 14, '25.00', 'C', 'swapna123');

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

INSERT INTO `student` (`Ration_card_no`, `reg_no`, `roll_no`, `name`, `addres`, `admn_date`, `gender`, `dob`, `parent_username`, `standard`, `division`, `blood_group`, `religion`, `caste`) VALUES
('', '34', 0, 'ghmncgh', 'hjm,hj', '0000-00-00', 'Male', '0000-00-00', '', 10, 'A', 'B+', 'tyjyt', 'tyjtyj'),
('', '36', 10, 'riyas', 'melathodu house\r\nkaringallathani\r\nkerala', '2016-09-06', 'Male', '2015-03-02', 'suku', 8, 'C', 'O-', 'islam', 'h'),
('', '456', 7, 'gireesh', 'aalakkat house\r\ncherrakkaparambu post\r\nangadippuram via\r\nmalappuram dt', '2015-02-24', 'Male', '1996-10-24', 'suku', 9, 'A', 'O+', 'hindu', 'nair'),
('', 'bh1234', 5, 'aju', 'hgf', '2014-02-23', 'Male', '2015-02-23', 'ajay1', 6, 'A', 'A+', 'h', 'n'),
('', 'nza12345', 12, 'jaggu', 'gghh', '2018-02-23', 'Male', '2017-02-23', 'vij12', 7, 'A', 'A+', 'h', 'n'),
('', 'nzapbca009', 12, 'ramesh', 'thekkethil house\r\ncherakkapparambu po\r\nangadippuram via\r\nmalappuram dt\r\n679321 pin', '2016-01-19', 'Male', '1997-12-25', 'ravi123', 10, 'A', 'O+', 'hindu', 'nair'),
('', 'nzapbca016', 0, 'vishnu', 'vailoh\r\nang\r\nperin', '2016-01-13', 'Male', '1996-09-06', '', 6, 'C', 'A-', 'h', 'a'),
('', 'reg666', 0, 'vvvvv', 'thhjhf\r\nxghgjk\r\nbfvvbhfgy\r\njhijmk', '2009-06-07', 'Male', '1998-07-08', '', 3, 'C', 'O+', 'hgff', 'uygf');

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

INSERT INTO `teacher` (`faculty_no`, `first_name`, `last_name`, `address`, `phone_no`, `e_mail`, `experience`, `qualification`, `gender`, `is_class_teacher`, `standard`, `division`, `username`, `password`, `subject`) VALUES
(23, 'adc sx', 'cv zdf', 'dgbsfhng\r\nfhnx\r\nfvgh mn', '4567865456', 'ghncfghm', 3, 'fgn cxfghmncgh\r\nhmgvbmvjh\r\n', 'Female', 0, NULL, NULL, 'zxdfgbzxdf', 'qwert', 'cv zdf'),
(33, 'summa', 'ya', 'dffgfghfg\r\nghjfhgj\r\ngyjgh\r\n', '365464565476', 'grdgn@g.c', 3, 'phd', 'Female', 0, NULL, NULL, 'suma123', 'qwerty', 'ya'),
(223, 'swapnaa', 'mohan', 'vattamkulangarea hmalappuramkerala', '9856755432', 'swapnamohan123@gmail.com', 5, 'pgphd', 'Female', 0, '12', 'B', 'swapna123', 'asdfg', 'mohan');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
