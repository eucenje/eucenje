-- phpMyAdmin SQL Dump
-- version 3.3.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 30, 2012 at 10:37 AM
-- Server version: 5.1.62
-- PHP Version: 5.3.5-1ubuntu7.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `eucenje`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE IF NOT EXISTS `admins` (
  `adminId` int(11) NOT NULL AUTO_INCREMENT,
  `adminFirstName` varchar(120) DEFAULT NULL,
  `adminLastName` varchar(120) DEFAULT NULL,
  `adminUserId` int(11) DEFAULT NULL,
  `adminEmail` varchar(160) DEFAULT NULL,
  `adminStatus` enum('active','inactive','deleted') DEFAULT NULL,
  PRIMARY KEY (`adminId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`adminId`, `adminFirstName`, `adminLastName`, `adminUserId`, `adminEmail`, `adminStatus`) VALUES
(1, 'Јован', 'Крстев', 1, 'admin@admin.com', 'active'),
(2, 'Некој', 'Ласт', 3, 'email@easd.asd', 'active'),
(3, 'Некdsојsa', 'sssda', 2, 'email@easd.asd', 'active'),
(4, 'Some', 'Kid', 6, '', 'inactive'),
(5, 'Никола', 'Тесла', 7, 'nikola.10521@gmail.com', 'active'),
(6, 'Pero', 'Hristov', 8, '', 'deleted'),
(7, 'Sinalko', 'Kokalanov', 9, '', 'deleted'),
(8, 'Spase55', 'Kostadinov', 10, '', 'active'),
(9, 'Kelasd', 'asdasd', 11, '', 'deleted'),
(10, 'sssasdasd', 'jkhaskdhkjh', 12, '', 'active'),
(11, 'Смона', 'Горачинова', 13, '', 'inactive'),
(12, 'asdasdas', 'testdasdasd', 14, '', 'deleted'),
(13, 'Ладна', 'Вода', 15, 'asd@asd.asd', 'deleted'),
(14, 'sdf', 'sdf', 16, '', 'active'),
(15, 'asdasd', 'asdasdsssss', 17, '', 'active'),
(16, '123qasds', 'asdasda', 18, '', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `fakulteti`
--

CREATE TABLE IF NOT EXISTS `fakulteti` (
  `fakultetId` int(11) NOT NULL AUTO_INCREMENT,
  `fakultetName` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `fakultetType` enum('diplomski','postdiplomski') NOT NULL,
  `fakultetYears` int(2) DEFAULT NULL,
  `fakultetStatus` enum('active','inactive','deleted') NOT NULL,
  PRIMARY KEY (`fakultetId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `fakulteti`
--

INSERT INTO `fakulteti` (`fakultetId`, `fakultetName`, `fakultetType`, `fakultetYears`, `fakultetStatus`) VALUES
(1, 'Информатика', 'diplomski', 4, 'active'),
(2, 'Хемика', 'diplomski', 3, 'active'),
(3, 'Психолошки', 'diplomski', 42, 'inactive'),
(4, 'Информатика', 'postdiplomski', 4, 'active'),
(5, 'Хемика', 'postdiplomski', 3, 'deleted'),
(6, 'Хемика', 'postdiplomski', 32, 'deleted'),
(7, 'Хемика', 'postdiplomski', 32, 'deleted'),
(8, 'њњњњ', 'diplomski', 12, 'deleted');

-- --------------------------------------------------------

--
-- Table structure for table `predmeti`
--

CREATE TABLE IF NOT EXISTS `predmeti` (
  `predmetId` int(11) NOT NULL AUTO_INCREMENT,
  `predmetName` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `predmetProfesorId` int(11) DEFAULT NULL,
  `predmetFakultetId` int(11) DEFAULT NULL,
  `predmetStatus` enum('active','inactive','deleted') NOT NULL,
  PRIMARY KEY (`predmetId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `predmeti`
--

INSERT INTO `predmeti` (`predmetId`, `predmetName`, `predmetProfesorId`, `predmetFakultetId`, `predmetStatus`) VALUES
(1, 'Matematika', 1, 1, 'active'),
(2, 'asdasdasd', 18, 1, 'active'),
(3, 'Kompjuterski mrezi', 19, 2, 'active'),
(6, 'Nik', 23, 1, 'deleted'),
(5, 'Bazi na podatoci', 23, 1, 'active'),
(7, 'Kompjutersa Arhitektura', 23, 1, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `profesors`
--

CREATE TABLE IF NOT EXISTS `profesors` (
  `profesorId` int(11) NOT NULL AUTO_INCREMENT,
  `profesorFirstName` varchar(120) DEFAULT NULL,
  `profesorLastName` varchar(120) DEFAULT NULL,
  `profesorUserId` int(11) DEFAULT NULL,
  `profesorEmail` varchar(160) DEFAULT NULL,
  `profesorStatus` enum('active','inactive','deleted') DEFAULT NULL,
  PRIMARY KEY (`profesorId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `profesors`
--

INSERT INTO `profesors` (`profesorId`, `profesorFirstName`, `profesorLastName`, `profesorUserId`, `profesorEmail`, `profesorStatus`) VALUES
(17, 'EEEE', 'asd', 12, 'asadas@asdas.asd', 'deleted'),
(18, 'Перко', 'asd22', 19, '', 'active'),
(19, 'Перко123', 'asd222', 20, '', 'active'),
(20, 'asdass', 'ssss', 21, '', 'deleted'),
(21, 'asd', 'asd', 22, '', 'active'),
(22, 'asdasda', 'dasadas', 23, '', 'active'),
(23, 'Nekoja', 'Petrov', 26, '', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE IF NOT EXISTS `students` (
  `studentId` int(11) NOT NULL AUTO_INCREMENT,
  `studentFirstName` varchar(120) DEFAULT NULL,
  `studentLastName` varchar(120) DEFAULT NULL,
  `studentUserId` int(11) DEFAULT NULL,
  `studentEmail` varchar(160) DEFAULT NULL,
  `studentStatus` enum('active','inactive','deleted') DEFAULT NULL,
  PRIMARY KEY (`studentId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`studentId`, `studentFirstName`, `studentLastName`, `studentUserId`, `studentEmail`, `studentStatus`) VALUES
(17, 'Jovan', 'Krsteb', 24, '', 'active'),
(18, 'Nikola', 'asasd', 25, '', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  `userName` varchar(120) DEFAULT NULL,
  `userPassword` varchar(120) DEFAULT NULL,
  `userStatus` enum('active','inactive','deleted') NOT NULL,
  `userType` enum('admin','profesor','student') NOT NULL,
  PRIMARY KEY (`userId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `userName`, `userPassword`, `userStatus`, `userType`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'active', 'admin'),
(2, 'adminsasd', 'asdasd', 'active', 'admin'),
(3, 'asd', 'dsa', 'active', 'admin'),
(4, 'test', '098f6bcd4621d373cade4e832627b4f6', 'active', 'admin'),
(5, 'test', '098f6bcd4621d373cade4e832627b4f6', 'active', 'admin'),
(6, 'ggg', '35399dceba61a9de3a6b8db700cc7af2', 'inactive', 'admin'),
(7, 'nikolce', '5cfee8964aaa5a5bb71cd366c4e7b819', 'active', 'admin'),
(8, 'pero.123@ugd.edu.mk', '80582fc13085d3e3d7f4c5a702f055e3', 'deleted', 'admin'),
(9, 'sinalko', '79183c7c23d806120fdd322b4d1e2569', 'deleted', 'admin'),
(10, 'space', 'c822c1b63853ed273b89687ac505f9fa', 'active', 'admin'),
(11, 'asdasdklj', '8f1c9bda9d4f5f1d0255903b6b45b4a6', 'deleted', 'admin'),
(12, 'kjsahkjh', '2284cc774583c48064a84275c03d9145', 'deleted', 'admin'),
(13, 'popo', 'e54a443cabe111d55487ca7435b01400', 'inactive', 'admin'),
(14, 'test123', '16d7a4fca7442dda3ad93c9a726597e4', 'deleted', 'admin'),
(15, 'bossgold', '578f9eb6a6e7bcbcafb03011f93ee532', 'deleted', 'admin'),
(16, 'sdf', '6a47faa0b711f4b1c8c5ce81c32617b8', 'active', 'admin'),
(17, 'dasdasd', '274d077be8eb3db162b74775051e4f36', 'active', 'admin'),
(18, 'sdqe312', 'bfd59291e825b5f2bbf1eb76569f8fe7', 'active', 'admin'),
(19, '123', 'f5bb0c8de146c67b44babbf4e6584cc0', 'active', ''),
(20, '123ssd', 'f5bb0c8de146c67b44babbf4e6584cc0', 'active', ''),
(21, 'adsads', '3c183a30cffcda1408daf1c61d47b274', 'deleted', ''),
(22, '123asdasd', '1b2b87ec6c751ccb06eb18e3ac4d65e0', 'active', ''),
(23, 'dasdas', '0df01ae7dd51cec48fed56952f40842b', 'active', 'profesor'),
(24, 'john.123', '4297f44b13955235245b2497399d7a93', 'active', 'student'),
(25, 'asdasadas', 'dc83f235dfffb3dea0bc9f6424d4afa7', 'active', 'student'),
(26, 'profesor', '793741d54b00253006453742ad4ed534', 'active', 'profesor');
