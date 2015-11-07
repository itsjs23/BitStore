-- phpMyAdmin SQL Dump
-- version 4.0.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 04, 2014 at 11:02 AM
-- Server version: 5.5.31-0ubuntu0.12.04.2
-- PHP Version: 5.3.10-1ubuntu3.8

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
-- Table structure for table `barcodes`
--

CREATE TABLE IF NOT EXISTS `barcodes` (
  `barcodes_id` int(11) NOT NULL AUTO_INCREMENT,
  `barcode` bigint(20) NOT NULL,
  `medicine_name` varchar(255) NOT NULL,
  `batch_code` varchar(50) NOT NULL,
  `mfg_date` date NOT NULL,
  `expiry_date` date NOT NULL,
  `mrp` decimal(15,5) NOT NULL,
  `store_key` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`barcodes_id`),
  KEY `mfg_date` (`mfg_date`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `barcodes`
--

INSERT INTO `barcodes` (`barcodes_id`, `barcode`, `medicine_name`, `batch_code`, `mfg_date`, `expiry_date`, `mrp`, `store_key`) VALUES
(1, 9135905620400, 'Tab', '2101', '2013-11-12', '2014-05-16', 10.00000, 'dhs_KSb'),
(2, 5508447743034, 'Tab', '2101', '2013-11-12', '2014-05-16', 10.00000, 'dhs_KSb'),
(3, 8825494770048, 'Tab', '2101', '2013-11-12', '2014-05-16', 10.00000, 'dhs_KSb'),
(4, 1148247237799, 'Tab', '2101', '2013-11-12', '2014-05-16', 10.00000, 'dhs_KSb'),
(5, 1112681803626, 'Tab', '2101', '2013-11-12', '2014-05-16', 10.00000, 'dhs_KSb'),
(6, 8796425436087, 'Tab', '2101', '2013-11-12', '2014-05-16', 10.00000, 'dhs_KSb'),
(7, 1221897996076, 'Tab', '2101', '2013-11-12', '2014-05-16', 10.00000, 'dhs_KSb');

-- --------------------------------------------------------

--
-- Table structure for table `billing`
--

CREATE TABLE IF NOT EXISTS `billing` (
  `billing_id` int(11) NOT NULL AUTO_INCREMENT,
  `bill_id` int(11) NOT NULL,
  `subtotal` decimal(15,5) NOT NULL,
  `tax` decimal(15,5) NOT NULL,
  `discount` decimal(15,5) NOT NULL,
  `total` decimal(15,5) NOT NULL,
  `store_key` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `created_date` datetime NOT NULL,
  PRIMARY KEY (`billing_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `billing`
--

INSERT INTO `billing` (`billing_id`, `bill_id`, `subtotal`, `tax`, `discount`, `total`, `store_key`, `created_date`) VALUES
(1, 1, 2700.00000, 0.00000, 0.00000, 2700.00000, 'dhs_KSb', '0000-00-00 00:00:00'),
(2, 2, 400.00000, 4.00000, 0.45000, 414.20000, 'dhs_KSb', '2013-12-13 00:00:00'),
(3, 3, 100.00000, 2.00000, 0.02000, 101.98000, 'dhs_KSb', '2013-12-13 00:00:00'),
(4, 4, 675.00000, 13.50000, 1.35000, 687.15000, 'dhs_KSb', '2013-12-13 00:00:00'),
(5, 5, 1350.00000, 0.00000, 0.00000, 1350.00000, 'dhs_KSb', '2013-12-24 00:00:00'),
(6, 6, 135.00000, 0.00000, 0.00000, 135.00000, 'dhs_KSb', '2013-12-24 00:00:00'),
(7, 7, 135.00000, 0.00000, 0.00000, 135.00000, 'dhs_KSb', '2013-12-24 00:00:00'),
(8, 8, 90.00000, 0.90000, 0.00000, 90.90000, 'dhs_KSb', '2013-12-24 00:00:00'),
(9, 11, 275.40000, 5.50800, 5.61816, 275.28983, 'dhs_KSb', '2013-12-26 00:00:00'),
(10, 12, 369.64200, 18.48210, 19.40620, 368.71790, 'dhs_KSb', '2013-12-26 00:00:00'),
(11, 13, 269.89200, 5.39784, 5.50580, 269.78403, 'dhs_KSb', '2013-12-26 00:00:00'),
(12, 14, 372.79200, 7.45584, 11.40744, 368.84040, 'dhs_KSb', '2013-12-26 00:00:00'),
(13, 15, 40.00000, 0.00000, 0.00000, 40.00000, 'dhs_KSb', '2013-12-28 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `store_key` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `name`, `status`, `store_key`) VALUES
(1, 'Tablets', 0, 'dhs_KSb'),
(2, 'Capsuls', 0, 'dhs_KSb'),
(3, 'Bottle', 1, 'dhs_KSb'),
(4, 'Powder', 1, 'dhs_KSb'),
(5, 'Hets', 1, 'dhs_KSb'),
(6, 'Demo Again', 0, 'dhs_KSb'),
(7, 'Level', 1, 'dhs_KSb'),
(8, 'api cat', 1, 'dhs_KSb'),
(9, 'xyz', 1, 'dhs_KSb'),
(10, 'gghhhdhdhdhdhdhdh', 0, 'dhs_KSb'),
(11, 'xyz', 0, 'dhs_KSb'),
(12, 'hhhh', 0, 'dhs_KSb');

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `config_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`config_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `config`
--

INSERT INTO `config` (`config_id`, `name`, `value`) VALUES
(1000, 'Company Name', 'N.K.R Medical Store'),
(1001, 'Company Mobile', '9886856547'),
(1002, 'Company Address', 'Jaipur (Raj.)'),
(1003, 'Stock Thershold Value', '10');

-- --------------------------------------------------------

--
-- Table structure for table `cust_inventory`
--

CREATE TABLE IF NOT EXISTS `cust_inventory` (
  `inventory_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(255) NOT NULL,
  `customer_mob` bigint(11) DEFAULT NULL,
  `doctor_name` varchar(255) DEFAULT NULL,
  `doctor_mob` bigint(11) DEFAULT NULL,
  `medicine_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_cost` decimal(15,5) NOT NULL,
  `subtotal` decimal(15,5) NOT NULL,
  `tax` decimal(15,5) NOT NULL,
  `discount` decimal(15,5) NOT NULL,
  `total` decimal(15,5) NOT NULL,
  `created_date` datetime NOT NULL,
  `mfg_date` datetime NOT NULL,
  `expiry_date` datetime NOT NULL,
  `bill_id` int(11) NOT NULL,
  `payment_mode` varchar(50) NOT NULL,
  `bill_created_by` int(11) NOT NULL,
  `cheque_no` varchar(255) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `branch_name` varchar(255) NOT NULL,
  `status` tinyint(3) NOT NULL,
  `store_key` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `barcode` bigint(20) NOT NULL,
  `batch_code` bigint(20) NOT NULL,
  PRIMARY KEY (`inventory_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `cust_inventory`
--

INSERT INTO `cust_inventory` (`inventory_id`, `customer_name`, `customer_mob`, `doctor_name`, `doctor_mob`, `medicine_id`, `quantity`, `unit_cost`, `subtotal`, `tax`, `discount`, `total`, `created_date`, `mfg_date`, `expiry_date`, `bill_id`, `payment_mode`, `bill_created_by`, `cheque_no`, `bank_name`, `branch_name`, `status`, `store_key`, `barcode`, `batch_code`) VALUES
(1, 'Puneet Singhal', 9887286731, '', 0, 57, 20, 135.00000, 2700.00000, 0.00000, 0.00000, 2700.00000, '2013-12-12 00:00:00', '2013-02-08 00:00:00', '2016-02-05 00:00:00', 1, 'Cash', 1, '0', '0', '0', 1, 'dhs_KSb', 44444444, 0),
(2, 'Puneet Singhal', 919887286731, '', 0, 60, 20, 20.00000, 400.00000, 0.00000, 0.00000, 400.00000, '2013-12-13 00:00:00', '2013-05-06 00:00:00', '2014-10-03 00:00:00', 2, 'Cash', 1, '0', '0', '0', 1, 'dhs_KSb', 88888888, 0),
(3, 'Puneet Singhal', 9887286731, '', 0, 60, 5, 20.00000, 100.00000, 0.00000, 0.00000, 100.00000, '2013-12-13 00:00:00', '2013-05-06 00:00:00', '2014-10-03 00:00:00', 3, 'Cash', 1, '0', '0', '0', 1, 'dhs_KSb', 88888888, 0),
(4, 'Puneet Singhal', 9887286731, '', 0, 57, 5, 135.00000, 675.00000, 0.00000, 0.00000, 675.00000, '2013-12-13 00:00:00', '2013-02-08 00:00:00', '2016-02-05 00:00:00', 4, 'Cash', 1, '0', '0', '0', 1, 'dhs_KSb', 44444444, 0),
(5, '', 0, '', 0, 57, 10, 135.00000, 1350.00000, 0.00000, 0.00000, 1350.00000, '2013-12-24 00:00:00', '2013-02-08 00:00:00', '2016-02-05 00:00:00', 5, '', 1, '', '', '', 1, 'dhs_KSb', 44444444, 0),
(6, '', 0, '', 0, 57, 1, 135.00000, 135.00000, 0.00000, 0.00000, 135.00000, '2013-12-24 00:00:00', '2013-02-08 00:00:00', '2016-02-05 00:00:00', 6, '', 1, '', '', '', 1, 'dhs_KSb', 44444444, 0),
(7, '', 0, '', 0, 57, 1, 135.00000, 135.00000, 0.00000, 0.00000, 135.00000, '2013-12-24 00:00:00', '2013-02-08 00:00:00', '2016-02-05 00:00:00', 7, 'Cash', 1, '0', '0', '0', 1, 'dhs_KSb', 44444444, 0),
(8, 'Local Bills', 0, '', 0, 43, 1, 90.00000, 90.00000, 0.00000, 0.00000, 90.00000, '2013-12-24 00:00:00', '2012-06-01 00:00:00', '2016-09-10 00:00:00', 8, 'Cash', 1, '0', '0', '0', 1, 'dhs_KSb', 77777777, 0),
(9, 'guru', 1234553355, '', 0, 57, 2, 135.00000, 270.00000, 2.00000, 2.00000, 269.89200, '2013-12-26 00:00:00', '2013-02-08 00:00:00', '2016-02-05 00:00:00', 9, 'Cash', 2, '', '', '', 1, 'dhs_KSb', 44444444, 0),
(10, 'amit', 345677755, '', 0, 57, 2, 135.00000, 270.00000, 2.00000, 2.00000, 269.89200, '2013-12-26 00:00:00', '2013-02-08 00:00:00', '2016-02-05 00:00:00', 10, 'Cash', 2, '', '', '', 1, 'dhs_KSb', 44444444, 0),
(11, 'amit', 36372636, '', 0, 57, 2, 135.00000, 270.00000, 2.00000, 2.00000, 275.40000, '2013-12-26 00:00:00', '2013-02-08 00:00:00', '2016-02-05 00:00:00', 11, 'Cash', 2, '', '', '', 1, 'dhs_KSb', 44444444, 0),
(12, 'amit', 3636373636, '', 0, 57, 2, 135.00000, 270.00000, 2.00000, 2.00000, 269.89200, '2013-12-26 00:00:00', '2013-02-08 00:00:00', '2016-02-05 00:00:00', 12, 'Cash', 2, '', '', '', 1, 'dhs_KSb', 44444444, 0),
(13, 'amit', 3636373636, '', 0, 60, 5, 20.00000, 100.00000, 5.00000, 5.00000, 99.75000, '2013-12-26 00:00:00', '2013-05-06 00:00:00', '2014-10-03 00:00:00', 12, 'Cash', 2, '', '', '', 1, 'dhs_KSb', 88888888, 0),
(14, 'amit', 345676556, '', 0, 57, 2, 135.00000, 270.00000, 2.00000, 2.00000, 269.89200, '2013-12-26 00:00:00', '2013-02-08 00:00:00', '2016-02-05 00:00:00', 13, 'Cash', 2, '', '', '', 1, 'dhs_KSb', 44444444, 0),
(15, 'amit', 234566754, '', 0, 57, 2, 135.00000, 270.00000, 2.00000, 2.00000, 269.89200, '2013-12-26 00:00:00', '2013-02-08 00:00:00', '2016-02-05 00:00:00', 14, 'Cash', 2, '', '', '', 1, 'dhs_KSb', 44444444, 0),
(16, 'amit', 234566754, '', 0, 60, 5, 20.00000, 100.00000, 5.00000, 2.00000, 102.90000, '2013-12-26 00:00:00', '2013-05-06 00:00:00', '2014-10-03 00:00:00', 14, 'Cash', 2, '', '', '', 1, 'dhs_KSb', 88888888, 0),
(17, 'Puneet Singhal', 9887286731, '', 0, 60, 2, 20.00000, 40.00000, 0.00000, 0.00000, 40.00000, '2013-12-28 00:00:00', '2013-05-06 00:00:00', '2014-10-03 00:00:00', 15, 'Cash', 1, '0', '0', '0', 1, 'dhs_KSb', 88888888, 0);

-- --------------------------------------------------------

--
-- Table structure for table `dhs_admin`
--

CREATE TABLE IF NOT EXISTS `dhs_admin` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_name` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `dhs_admin`
--

INSERT INTO `dhs_admin` (`admin_id`, `admin_name`, `password`, `status`) VALUES
(1, 'dhsadmin', 'dhsadmin', 1);

-- --------------------------------------------------------

--
-- Table structure for table `distributors`
--

CREATE TABLE IF NOT EXISTS `distributors` (
  `distributor_id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` bigint(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `shop_name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `username` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `password` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`distributor_id`),
  KEY `idx_name` (`fullname`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=49 ;

--
-- Dumping data for table `distributors`
--

INSERT INTO `distributors` (`distributor_id`, `fullname`, `email`, `mobile`, `address`, `city`, `state`, `country`, `shop_name`, `status`, `username`, `password`) VALUES
(1, 'puneet', 'punetsinghal@gmail.com', 2147483647, 'Jaipur', 'Jaipur', 'Rajasthan', 'India', 'Medical Store1', 1, 'puneet', '123456'),
(32, 'Distributor_demo', 'r72k576jimi@gmail.com', 890453, 'near', 'jaipur', 'raj', 'india', 'Demo shop', 1, 'distributor', 'distributor'),
(41, 'Demo medicine', 'check@gmail.com', 546546, 'as', 'Jaipur', 'Rajasthan', 'India', 'demo', 1, 'demo', 'demo'),
(48, 'rahul_v', '', 878787, 'rahul_v', 'rahul_v', 'rahul_v', 'rahul_v', 'rahul_v', 1, 'rahul_v', 'rahul_v');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE IF NOT EXISTS `doctors` (
  `doctor_id` int(11) NOT NULL AUTO_INCREMENT,
  `doctor_name` varchar(255) NOT NULL,
  `hospital_name` varchar(255) NOT NULL,
  `mobile` bigint(11) NOT NULL,
  `status` int(11) NOT NULL,
  `store_key` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`doctor_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`doctor_id`, `doctor_name`, `hospital_name`, `mobile`, `status`, `store_key`) VALUES
(1, 'Amiot', '', 8754562267, 1, 'dhs_KSb'),
(3, 'Ashok', '', 7145125489, 1, 'dhs_KSb'),
(4, 'Qaded', '', 3435566, 1, 'dhs_KSb'),
(5, 'Asedf', '', 4577898789, 1, 'dhs_KSb'),
(6, 'Testing', '', 7676767676, 1, 'dhs_KSb'),
(7, 'asas', '', 985755456, 0, 'dhs_KSb'),
(8, 'Ashok Sharma', '', 4545454578, 1, 'dhs_KSb'),
(9, 'Ashok Sharma', '', 4587544578, 1, 'dhs_KSb');

-- --------------------------------------------------------

--
-- Table structure for table `expenditure`
--

CREATE TABLE IF NOT EXISTS `expenditure` (
  `expenditure_id` int(11) NOT NULL AUTO_INCREMENT,
  `purpose` varchar(255) NOT NULL,
  `amount` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `expense_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `store_key` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`expenditure_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `expenditure`
--

INSERT INTO `expenditure` (`expenditure_id`, `purpose`, `amount`, `status`, `added_by`, `created_date`, `expense_date`, `modified_date`, `store_key`) VALUES
(1, '', 20, 0, 1, '2013-11-11 00:00:00', '2013-11-11 00:00:00', '0000-00-00 00:00:00', 'dhs_KSb'),
(2, 'Tea', 200, 1, 1, '2013-11-11 00:00:00', '2013-11-11 00:00:00', '0000-00-00 00:00:00', 'dhs_KSb'),
(3, 'Repairing', 421, 1, 2, '2013-11-23 00:00:00', '2013-11-02 00:00:00', '0000-00-00 00:00:00', 'dhs_KSb'),
(4, 'abs', 50, 1, 2, '2013-12-23 00:00:00', '2015-12-23 00:00:00', '0000-00-00 00:00:00', 'dhs_KSb');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE IF NOT EXISTS `inventory` (
  `inventory_id` int(11) NOT NULL AUTO_INCREMENT,
  `distributor_id` int(11) NOT NULL,
  `medicine_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_cost` decimal(15,5) NOT NULL,
  `buy_unit_cost` decimal(15,5) NOT NULL,
  `subtotal` decimal(15,5) NOT NULL,
  `tax` decimal(15,5) NOT NULL,
  `discount` decimal(15,5) NOT NULL,
  `total` decimal(15,5) NOT NULL,
  `status` int(3) NOT NULL,
  `requested_quantity` int(11) NOT NULL,
  `requested_date` datetime NOT NULL,
  `completed_date` datetime NOT NULL,
  `verified_date` datetime NOT NULL,
  `mfg_date` datetime NOT NULL,
  `expiry_date` datetime NOT NULL,
  `requested_by` int(11) NOT NULL,
  `verified_by` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `store_key` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `barcode` bigint(20) NOT NULL,
  `batch_code` varchar(50) NOT NULL,
  PRIMARY KEY (`inventory_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=42 ;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`inventory_id`, `distributor_id`, `medicine_id`, `quantity`, `unit_cost`, `buy_unit_cost`, `subtotal`, `tax`, `discount`, `total`, `status`, `requested_quantity`, `requested_date`, `completed_date`, `verified_date`, `mfg_date`, `expiry_date`, `requested_by`, `verified_by`, `message`, `store_key`, `barcode`, `batch_code`) VALUES
(27, 1, 57, 400, 135.00000, 110.00000, 54000.00000, 0.00000, 0.00000, 54000.00000, 30, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2013-02-08 00:00:00', '2016-02-05 00:00:00', 0, 0, '', 'dhs_KSb', 44444444, '0'),
(29, 1, 48, 400, 85.00000, 80.00000, 32000.00000, 0.00000, 0.00000, 32000.00000, 30, 400, '2013-12-12 00:00:00', '2013-12-21 00:00:00', '2013-12-21 00:00:00', '2013-03-12 00:00:00', '2015-12-17 00:00:00', 1, 1, '', 'dhs_KSb', 1414141414, '0'),
(30, 1, 60, 401, 20.00000, 15.75000, 6315.75000, 0.00000, 0.00000, 6315.75000, 30, 450, '2013-12-12 00:00:00', '2013-12-12 00:00:00', '2013-12-12 00:00:00', '2013-05-06 00:00:00', '2014-10-03 00:00:00', 1, 1, '', 'dhs_KSb', 88888888, '0'),
(31, 1, 58, 700, 0.00000, 120.00000, 84000.00000, 0.00000, 0.00000, 84000.00000, 20, 800, '2013-12-12 00:00:00', '2013-12-23 00:00:00', '0000-00-00 00:00:00', '2013-12-23 00:00:00', '2015-04-09 00:00:00', 1, 0, '', 'dhs_KSb', 15121512, '0'),
(32, 1, 43, 95, 90.00000, 75.00000, 7125.00000, 0.00000, 0.00000, 7125.00000, 30, 100, '2013-12-12 00:00:00', '2013-12-12 00:00:00', '2013-12-12 00:00:00', '2012-06-01 00:00:00', '2016-09-10 00:00:00', 1, 1, '', 'dhs_KSb', 77777777, '0'),
(33, 41, 48, 5, 10.00000, 8.00000, 50.00000, 0.00000, 0.00000, 50.00000, 30, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2013-12-14 00:00:00', '2013-12-12 00:00:00', '2013-12-12 00:00:00', 0, 0, '', 'dhs_KSb', 13131313, '0'),
(34, 41, 59, 3, 4.00000, 5.00000, 6.00000, 3.00000, 8.00000, 6.00000, 30, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2013-12-14 00:00:00', '2013-12-13 00:00:00', '2013-12-13 00:00:00', 0, 0, '', 'dhs_KSb', 8902579203016, '0'),
(35, 1, 57, 12, 55.00000, 50.00000, 660.00000, 0.00000, 0.00000, 660.00000, 30, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2013-12-17 00:00:00', '2015-02-12 00:00:00', 0, 0, '', 'dhs_KSb', 8545454545, '2123'),
(36, 41, 63, 0, 0.00000, 0.00000, 0.00000, 0.00000, 0.00000, 0.00000, 10, 12, '2013-12-19 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, '', 'dhs_KSb', 0, '0'),
(37, 1, 64, 800, 52.00000, 15.00000, 12000.00000, 0.00000, 0.00000, 12000.00000, 40, 800, '2013-12-21 00:00:00', '2013-12-23 00:00:00', '2013-12-24 00:00:00', '2013-08-01 00:00:00', '2014-10-17 00:00:00', 1, 2, 'dfghd gjjh dgkgdfhj dfh', 'dhs_KSb', 75757575, '0'),
(38, 1, 66, 0, 0.00000, 0.00000, 0.00000, 0.00000, 0.00000, 0.00000, 10, 450, '2013-12-21 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, '', 'dhs_KSb', 0, '0'),
(39, 1, 67, 350, 53.00000, 14.50000, 5075.00000, 0.00000, 0.00000, 5075.00000, 40, 350, '2013-12-21 00:00:00', '2013-12-23 00:00:00', '2013-12-24 00:00:00', '2013-08-03 00:00:00', '2015-04-17 00:00:00', 1, 2, '', 'dhs_KSb', 84547564854, '0'),
(40, 1, 71, 0, 0.00000, 0.00000, 0.00000, 0.00000, 0.00000, 0.00000, 10, 850, '2013-12-21 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, '', 'dhs_KSb', 0, '0'),
(41, 32, 62, 0, 0.00000, 0.00000, 0.00000, 0.00000, 0.00000, 0.00000, 10, 45, '2013-12-23 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2, 0, '', 'dhs_KSb', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `medicine`
--

CREATE TABLE IF NOT EXISTS `medicine` (
  `medicine_id` int(11) NOT NULL AUTO_INCREMENT,
  `medicine_name` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `ingrediants` varchar(255) NOT NULL,
  `is_generic` tinyint(1) NOT NULL,
  `manufacturer` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `store_key` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`medicine_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=76 ;

--
-- Dumping data for table `medicine`
--

INSERT INTO `medicine` (`medicine_id`, `medicine_name`, `category_id`, `ingrediants`, `is_generic`, `manufacturer`, `message`, `status`, `store_key`) VALUES
(57, 'sge', 4, 'sov', 1, 'no', 'hello', 0, 'dhs_KSb'),
(48, 'Tab', 2, 'no', 0, 'v', 'hello', 1, 'dhs_KSb'),
(60, 'Demo medicine', 4, 'no', 1, 'dfds', 'hello', 1, 'dhs_KSb'),
(59, 'demo medical', 4, '', 0, '', 'hello', 1, 'dhs_KSb'),
(58, 'Demo_medi', 4, 'no', 1, 'dfds', 'hello', 1, 'dhs_KSb'),
(43, 'Eye_capsul', 2, 'Demo', 0, 'tata', 'hello', 1, 'dhs_KSb'),
(61, 'Test A', 1, 'aas', 1, 'a', '', 0, 'dhs_KSb'),
(62, 'Testing B', 1, 'Testing B', 1, 'Testing B', '', 1, 'dhs_KSb'),
(63, 'New Medicine', 1, 'New Medicine', 1, 'A', '', 1, 'dhs_KSb'),
(64, 'sge', 4, 'noa', 1, 'no', '', 1, 'dhs_KSb'),
(65, 'sge', 4, 'no', 1, 'no', '', 0, 'dhs_KSb'),
(66, 'Level 1', 7, 'Level 1', 1, 'Level 1', '', 1, 'dhs_KSb'),
(67, 'one', 1, 'one test', 0, 'aa', '', 1, 'dhs_KSb'),
(68, 'one', 1, 'one test', 0, 'aa', '', 1, 'dhs_KSb'),
(69, 'one', 1, 'one test', 0, '0', '', 1, 'dhs_KSb'),
(70, 'xyz', 2, 'vv', 1, 'ppp', '', 1, ''),
(71, 'xyz', 2, 'vv', 1, 'ppp', '', 1, 'dhs_KSb'),
(72, 'two', 2, 'one test', 0, '0', '', 1, 'dhs_KSb'),
(73, 'Api Test', 2, 'one test', 0, '0', '', 1, 'dhs_KSb'),
(74, 'ggh', 2, 'ghh', 1, '0', '', 1, 'dhs_KSb'),
(75, 'cap 88', 3, 'no', 0, '0', '', 0, 'dhs_KSb');

-- --------------------------------------------------------

--
-- Table structure for table `paid_salary`
--

CREATE TABLE IF NOT EXISTS `paid_salary` (
  `paid_salary_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `salary` decimal(15,5) NOT NULL,
  `month` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `present_days` int(11) NOT NULL,
  `absent_days` int(11) NOT NULL,
  `month_days` int(11) NOT NULL,
  `actual_payment` decimal(15,5) NOT NULL,
  `paid_on_date` datetime NOT NULL,
  `created_date` datetime NOT NULL,
  `paid_by` int(11) NOT NULL,
  `store_key` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`paid_salary_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `paid_salary`
--

INSERT INTO `paid_salary` (`paid_salary_id`, `user_id`, `salary`, `month`, `year`, `present_days`, `absent_days`, `month_days`, `actual_payment`, `paid_on_date`, `created_date`, `paid_by`, `store_key`) VALUES
(1, 2, 10000.00000, 10, 2013, 25, 6, 31, 8064.51613, '2013-11-20 00:00:00', '2013-11-22 00:00:00', 0, 'dhs_KSb'),
(2, 2, 10000.00000, 12, 2013, 24, 7, 31, 7741.93548, '2013-12-07 00:00:00', '2013-12-07 00:00:00', 0, 'dhs_KSb');

-- --------------------------------------------------------

--
-- Table structure for table `return_stock`
--

CREATE TABLE IF NOT EXISTS `return_stock` (
  `return_id` int(11) NOT NULL AUTO_INCREMENT,
  `medicine_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `distributor_id` int(11) NOT NULL,
  `unit_cost` float(15,5) NOT NULL,
  `purchased_price` float(15,5) NOT NULL,
  `returning_total` float(15,5) NOT NULL,
  `loss` float(15,5) NOT NULL,
  `return_date` datetime NOT NULL,
  `created_date` datetime NOT NULL,
  `status` int(11) NOT NULL,
  `returned_by` int(11) NOT NULL,
  `store_key` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `barcode` bigint(20) NOT NULL,
  PRIMARY KEY (`return_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `return_stock`
--

INSERT INTO `return_stock` (`return_id`, `medicine_id`, `quantity`, `distributor_id`, `unit_cost`, `purchased_price`, `returning_total`, `loss`, `return_date`, `created_date`, `status`, `returned_by`, `store_key`, `barcode`) VALUES
(1, 48, 30, 1, 85.00000, 2550.00000, 2000.00000, 550.00000, '2013-12-23 00:00:00', '2013-12-22 00:00:00', 1, 1, 'dhs_KSb', 1414141414),
(2, 48, 5, 1, 85.00000, 425.00000, 32.00000, 393.00000, '2013-12-26 00:00:00', '2013-12-26 00:00:00', 1, 2, 'dhs_KSb', 1414141414);

-- --------------------------------------------------------

--
-- Table structure for table `salary`
--

CREATE TABLE IF NOT EXISTS `salary` (
  `salary_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `salary` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `notify_day` int(11) NOT NULL,
  `created_date` date NOT NULL,
  `store_key` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`salary_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `salary`
--

INSERT INTO `salary` (`salary_id`, `user_id`, `salary`, `status`, `notify_day`, `created_date`, `store_key`) VALUES
(1, 2, 12000, 1, 20, '2013-11-22', 'dhs_KSb'),
(4, 1, 50000, 1, 4, '2013-11-22', 'dhs_KSb');

-- --------------------------------------------------------

--
-- Table structure for table `store`
--

CREATE TABLE IF NOT EXISTS `store` (
  `store_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_key` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `store_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(150) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `mobile` bigint(11) NOT NULL,
  `person_name` varchar(100) NOT NULL,
  `created_date` date NOT NULL,
  `created_by` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`store_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `store`
--

INSERT INTO `store` (`store_id`, `store_key`, `store_name`, `email`, `address`, `city`, `state`, `country`, `mobile`, `person_name`, `created_date`, `created_by`, `status`) VALUES
(4, 'dhs_KSb', 'Mera Medical', 'rakesh@gtalk.com', 'jaipur', 'jaipur', 'Rajasthan', 'India', 85458745455, 'Rakesh', '0000-00-00', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `store_distributor_mapping`
--

CREATE TABLE IF NOT EXISTS `store_distributor_mapping` (
  `map_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_key` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `distributor_id` int(11) NOT NULL,
  PRIMARY KEY (`map_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `store_distributor_mapping`
--

INSERT INTO `store_distributor_mapping` (`map_id`, `store_key`, `distributor_id`) VALUES
(1, 'dhs_KSb', 1),
(2, 'dhs_KSb', 32);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `type` int(11) NOT NULL,
  `Enable` tinyint(1) NOT NULL,
  `register_date` datetime NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `store_key` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=58 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `type`, `Enable`, `register_date`, `status`, `store_key`) VALUES
(1, 'admin', 'admin', 301, 1, '0000-00-00 00:00:00', 1, 'dhs_KSb'),
(2, 'hospital', 'hospital', 302, 1, '0000-00-00 00:00:00', 1, 'dhs_KSb'),
(37, 'hospital_demo', '123456', 302, 0, '2013-10-29 06:50:47', 1, 'dhs_KSb'),
(53, 'xaxa', 'xaxa', 302, 0, '0000-00-00 00:00:00', 1, 'dhs_KSb'),
(54, 'testing', 'testing', 302, 1, '0000-00-00 00:00:00', 0, 'dhs_KSb'),
(55, 'rksharma', 'rksharma', 301, 1, '0000-00-00 00:00:00', 1, 'JSb'),
(56, 'rksarma1', 'rksarma1', 301, 1, '2013-11-28 00:00:00', 1, 'dhs_kSb'),
(57, 'rererere', 'rererere', 301, 1, '2013-11-28 00:00:00', 1, 'dhs_KSb');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
