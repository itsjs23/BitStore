-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 04, 2014 at 07:40 AM
-- Server version: 5.5.32
-- PHP Version: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `medical`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `bk_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `type` int(11) NOT NULL,
  `Enable` tinyint(1) NOT NULL,
  `register_date` datetime NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `store_key` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=157 ;

--
-- Dumping data for table `users`
--

INSERT INTO `bk_users` (`user_id`, `username`, `password`, `type`, `Enable`, `register_date`, `status`, `store_key`) VALUES
(1, 'admin', 'admin', 301, 1, '0000-00-00 00:00:00', 1, 'dhs_KSb'),
(2, 'hospital', 'hospital', 302, 1, '0000-00-00 00:00:00', 1, 'dhs_KSb'),
(3, 'distributor', 'distributor', 303, 1, '0000-00-00 00:00:00', 1, 'dhs_KSb'),
(48, 'fdfk', '1', 303, 0, '2013-10-31 15:06:17', 1, 'dhs_KSb'),
(37, 'hospital_demo', '123456', 302, 0, '2013-10-29 06:50:47', 1, 'dhs_KSb'),
(38, 'puneet', '123456', 303, 1, '2013-10-29 06:55:35', 1, 'dhs_KSb'),
(39, 'Aganin', '12', 303, 1, '2013-10-30 11:48:38', 1, 'dhs_KSb'),
(40, 'hello', '123', 303, 0, '2013-10-30 12:33:23', 1, 'dhs_KSb'),
(49, 'dsffd', 'sdfsdf', 303, 1, '2013-10-31 15:26:09', 1, 'dhs_KSb'),
(47, 'check', '123456', 303, 0, '2013-10-31 15:03:52', 1, 'dhs_KSb'),
(46, 'h', 'h', 303, 0, '2013-10-31 14:59:43', 0, 'dhs_KSb'),
(50, 'dsegds', 'ert', 303, 1, '2013-10-31 15:32:43', 1, 'dhs_KSb'),
(51, 'ksfhsu', 'huhuh', 303, 1, '2013-10-31 15:33:43', 1, 'dhs_KSb'),
(52, 'rahul_v12', 'rahul_v', 303, 1, '2013-11-13 00:00:00', 1, 'dhs_KSb'),
(53, 'xaxa', 'xaxa', 302, 0, '0000-00-00 00:00:00', 1, 'dhs_KSb'),
(54, 'testing', 'testing', 302, 1, '0000-00-00 00:00:00', 0, 'dhs_KSb'),
(55, 'hema', 'hema', 303, 1, '2013-11-15 00:00:00', 0, 'dhs_KSb'),
(56, 'su', 'su', 302, 1, '0000-00-00 00:00:00', 1, 'dhs_KSb'),
(57, 'Daga', 'daga', 302, 1, '0000-00-00 00:00:00', 1, 'dhs_KSb'),
(58, 'Da', 'da', 301, 1, '0000-00-00 00:00:00', 0, 'dhs_KSb'),
(59, 'Dagaa', 'dagaa', 301, 1, '0000-00-00 00:00:00', 1, 'dhs_KSb'),
(60, 'Dhs', 'dhs', 302, 1, '0000-00-00 00:00:00', 1, 'dhs_KSb'),
(61, 'mau', 'mau', 301, 1, '2013-12-02 00:00:00', 1, 'dhs_lSb'),
(62, 'mau12', 'mau123', 302, 1, '0000-00-00 00:00:00', 1, 'dhs_lSb'),
(63, 'dhsadmin12', '1234', 301, 1, '2013-12-03 00:00:00', 1, 'dhs_LSb'),
(64, 'par', 'par', 301, 1, '2013-12-05 00:00:00', 1, 'dhs_mSb'),
(65, 'payal', 'payal123', 301, 1, '2013-12-06 00:00:00', 0, 'dhs_MSb'),
(66, 'abc', 'abc123', 303, 1, '2013-12-06 00:00:00', 0, 'dhs_MSb'),
(67, 'Raju', 'raju123', 302, 1, '0000-00-00 00:00:00', 0, 'dhs_MSb'),
(68, 'asha', 'asha123', 302, 0, '0000-00-00 00:00:00', 0, 'dhs_MSb'),
(69, 'windows', '12345', 303, 1, '2013-12-09 00:00:00', 1, 'dhs_mSb'),
(70, 'prathmesh', 'bunty', 303, 0, '2013-12-09 00:00:00', 0, 'dhs_MSb'),
(71, 'AMOGH', 'SANDHYAS', 303, 1, '0000-00-00 00:00:00', 0, 'dhs_MSb'),
(72, 'sanket', 'pooja', 301, 1, '0000-00-00 00:00:00', 0, 'dhs_MSb'),
(73, 'neeraj', 'chayamita', 303, 1, '2013-12-09 00:00:00', 0, 'dhs_MSb'),
(74, 'prem', 'prem123', 302, 1, '0000-00-00 00:00:00', 0, 'dhs_MSb'),
(75, 'amitabh', '123456', 303, 1, '2013-12-10 00:00:00', 0, 'dhs_MSb'),
(76, 'abhishek', 'sandhyas', 303, 1, '2013-12-11 00:00:00', 0, 'dhs_MSb'),
(77, 'ram', '1234', 302, 1, '0000-00-00 00:00:00', 1, 'dhs_KSb'),
(78, 'sheeyash', '123456', 301, 1, '2013-12-13 00:00:00', 1, 'dhs_nSb'),
(79, 'zen', 'zen', 303, 1, '2013-12-13 00:00:00', 1, 'dhs_nSb'),
(80, 'saipharma', 'saipharma', 303, 1, '2013-12-13 00:00:00', 1, 'dhs_nSb'),
(81, 'anpharma', 'anpharma', 303, 1, '2013-12-13 00:00:00', 1, 'dhs_nSb'),
(82, 'pranic', 'pranic', 303, 1, '2013-12-13 00:00:00', 1, 'dhs_nSb'),
(83, 'indian', 'indian', 303, 1, '2013-12-13 00:00:00', 1, 'dhs_nSb'),
(84, 'westernhasmukh', 'westernhasmukh', 303, 1, '2013-12-13 00:00:00', 1, 'dhs_nSb'),
(85, 'gspharma', 'gspharma', 303, 1, '2013-12-13 00:00:00', 1, 'dhs_nSb'),
(86, 'mukeshsales', 'mukeshsales', 303, 1, '2013-12-13 00:00:00', 1, 'dhs_nSb'),
(87, 'arihantmarketing', 'arihantmarketing', 303, 1, '2013-12-13 00:00:00', 1, 'dhs_nSb'),
(88, 'parasnath', 'parasnath', 303, 1, '2013-12-13 00:00:00', 1, 'dhs_nSb'),
(89, 'vimal', 'vimal', 303, 1, '2013-12-13 00:00:00', 1, 'dhs_nSb'),
(90, 'avani', 'avani', 303, 1, '2013-12-13 00:00:00', 1, 'dhs_nSb'),
(91, 'siddharth', 'siddharth', 303, 1, '2013-12-13 00:00:00', 1, 'dhs_nSb'),
(92, 'mayank', 'mayank', 303, 1, '2013-12-13 00:00:00', 1, 'dhs_nSb'),
(93, 'nayakagencies', 'nayakagencies', 303, 1, '2013-12-13 00:00:00', 1, 'dhs_nSb'),
(94, 'mahadevagency', 'mahadevagency', 303, 1, '2013-12-13 00:00:00', 1, 'dhs_nSb'),
(95, 'arpitpharma', 'arpitpharma', 303, 1, '2013-12-13 00:00:00', 1, 'dhs_nSb'),
(96, 'garodia', 'garodia', 303, 1, '2013-12-13 00:00:00', 1, 'dhs_nSb'),
(97, 'rppharma', 'rppharma', 303, 1, '2013-12-13 00:00:00', 1, 'dhs_nSb'),
(98, 'kirtikumar', 'kirtikumar', 303, 1, '2013-12-13 00:00:00', 1, 'dhs_nSb'),
(99, 'veenaagencies', 'veenaagencies', 303, 1, '2013-12-13 00:00:00', 1, 'dhs_nSb'),
(100, 'sakhi', 'sakhi', 303, 1, '2013-12-13 00:00:00', 1, 'dhs_nSb'),
(101, 'hariom', 'hariom', 303, 1, '2013-12-13 00:00:00', 1, 'dhs_nSb'),
(102, 'pharmalink', 'pharmalink', 303, 1, '2013-12-13 00:00:00', 1, 'dhs_nSb'),
(103, 'shreeent', 'shreeent', 303, 1, '2013-12-19 00:00:00', 1, 'dhs_nSb'),
(104, 'rushient', 'rushient', 303, 1, '2013-12-19 00:00:00', 1, 'dhs_nSb'),
(105, 'metropharma', 'metropharma', 303, 1, '2013-12-19 00:00:00', 1, 'dhs_nSb'),
(106, 'westernpharma', 'westernpharma', 303, 1, '2013-12-19 00:00:00', 1, 'dhs_nSb'),
(107, 'avanidist', 'avanidist', 303, 1, '2013-12-19 00:00:00', 1, 'dhs_nSb'),
(108, 'namrata', 'namrata', 303, 1, '2013-12-19 00:00:00', 1, 'dhs_nSb'),
(109, 'padam', 'padam', 303, 1, '2013-12-19 00:00:00', 1, 'dhs_nSb'),
(110, 'gautampharma', 'gautampharma', 303, 1, '2013-12-19 00:00:00', 1, 'dhs_nSb'),
(111, 'rajnikant', 'rajnikant', 303, 1, '2013-12-19 00:00:00', 1, 'dhs_nSb'),
(112, 'lotuspharma', 'lotuspharma', 303, 1, '2013-12-19 00:00:00', 1, 'dhs_nSb'),
(113, 'shreejasubai', 'shreejasubai', 303, 1, '2013-12-19 00:00:00', 1, 'dhs_nSb'),
(114, 'swetadist', 'swetadist', 303, 1, '2013-12-19 00:00:00', 1, 'dhs_nSb'),
(115, 'rishabh', 'rishabh', 303, 1, '2013-12-19 00:00:00', 1, 'dhs_nSb'),
(116, 'jyotidist', 'jyotidist', 303, 1, '2013-12-19 00:00:00', 1, 'dhs_nSb'),
(117, 'meherdist', 'meherdist', 303, 1, '2013-12-19 00:00:00', 1, 'dhs_nSb'),
(118, 'chaitali', 'chaitali', 303, 1, '2013-12-19 00:00:00', 1, 'dhs_nSb'),
(119, 'sachinent', 'sachinent', 303, 1, '2013-12-19 00:00:00', 1, 'dhs_nSb'),
(120, 'balajimarketing', 'balajimarketing', 303, 1, '2013-12-19 00:00:00', 1, 'dhs_nSb'),
(121, 'desaipharrma', 'desaipharrma', 303, 1, '2013-12-19 00:00:00', 1, 'dhs_nSb'),
(122, 'mahavirent', 'mahavirent', 303, 1, '2013-12-19 00:00:00', 1, 'dhs_nSb'),
(123, 'jihanent', 'jihanent', 303, 1, '2013-12-19 00:00:00', 1, 'dhs_nSb'),
(124, 'Royalpharma', 'Royalpharma', 303, 1, '2013-12-19 00:00:00', 1, 'dhs_nSb'),
(125, 'satyammarketing', 'satyammarketing', 303, 1, '2013-12-19 00:00:00', 1, 'dhs_nSb'),
(126, 'vitragdist', 'vitragdist', 303, 1, '2013-12-19 00:00:00', 1, 'dhs_nSb'),
(127, 'sunrise', 'sunrise', 303, 1, '2013-12-19 00:00:00', 1, 'dhs_nSb'),
(128, 'shahtrading', 'shahtrading', 303, 1, '2013-12-19 00:00:00', 1, 'dhs_nSb'),
(129, 'dist', 'dist', 303, 1, '2013-12-21 00:00:00', 1, 'dhs_mSb'),
(130, 'su', 'sumau', 302, 1, '0000-00-00 00:00:00', 1, 'dhs_mSb'),
(131, 'ffty', '99999', 302, 1, '0000-00-00 00:00:00', 1, 'dhs_mSb'),
(132, 'sumit', 'sumit', 303, 1, '2013-12-27 00:00:00', 1, 'dhs_mSb'),
(133, 'mmm', 'par', 303, 1, '2013-12-27 00:00:00', 1, 'dhs_mSb'),
(134, 'extra', 'extra', 302, 1, '0000-00-00 00:00:00', 1, 'dhs_mSb'),
(135, 'test', 'test', 301, 1, '0000-00-00 00:00:00', 1, 'dhs_mSb'),
(136, 'suraj', '123', 303, 1, '2013-12-28 00:00:00', 0, 'dhs_MSb'),
(137, 'ravi', '123456', 301, 1, '2013-12-28 00:00:00', 0, 'dhs_NSb'),
(138, 'RamSales', '123456', 303, 1, '2013-12-28 00:00:00', 0, 'dhs_NSb'),
(139, 'Sharma', '123456', 303, 1, '2013-12-28 00:00:00', 0, 'dhs_NSb'),
(140, 'Sunil', '123456', 303, 1, '2013-12-28 00:00:00', 0, 'dhs_NSb'),
(141, 'Pratap', '123456', 303, 1, '2013-12-28 00:00:00', 0, 'dhs_NSb'),
(142, 'Rahul', '123456', 303, 0, '2013-12-28 00:00:00', 0, 'dhs_NSb'),
(143, 'ramu', '12345', 301, 0, '0000-00-00 00:00:00', 0, 'dhs_NSb'),
(144, 'rahul', '123456', 301, 0, '0000-00-00 00:00:00', 0, 'dhs_NSb'),
(145, 'sham', '1234', 302, 1, '0000-00-00 00:00:00', 0, 'dhs_NSb'),
(146, 'gops', '1234', 302, 1, '0000-00-00 00:00:00', 1, 'dhs_mSb'),
(147, 'ravindra', '1234', 301, 1, '2013-12-30 00:00:00', 1, 'dhs_oSb'),
(148, 'ganpati', '1234', 303, 1, '2013-12-30 00:00:00', 1, 'dhs_oSb'),
(149, 'shankar', '1234', 303, 1, '2013-12-30 00:00:00', 1, 'dhs_oSb'),
(150, 'ram', '1234', 303, 1, '2013-12-30 00:00:00', 1, 'dhs_oSb'),
(151, 'labour', '12345', 302, 1, '0000-00-00 00:00:00', 1, 'dhs_mSb'),
(152, 'rakesh', 'rakesh', 303, 1, '2013-12-31 00:00:00', 1, 'dhs_MSb'),
(153, 'kishan', 'kishan', 303, 1, '2013-12-31 00:00:00', 1, 'dhs_MSb'),
(154, 'man', '12345', 302, 1, '0000-00-00 00:00:00', 1, 'dhs_mSb'),
(155, 'demo', 'demo', 301, 1, '2014-01-02 00:00:00', 1, 'dhs_OSb'),
(156, 'sai', '1234', 302, 1, '0000-00-00 00:00:00', 1, 'dhs_mSb');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
