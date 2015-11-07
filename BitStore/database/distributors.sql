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
-- Table structure for table `distributors`
--

CREATE TABLE IF NOT EXISTS `bk_distributors` (
  `distributor_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` bigint(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `shop_name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `store_key` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`distributor_id`),
  KEY `idx_name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=119 ;

--
-- Dumping data for table `distributors`
--

INSERT INTO `bk_distributors` (`distributor_id`, `user_id`, `name`, `email`, `mobile`, `address`, `city`, `state`, `country`, `shop_name`, `status`, `store_key`) VALUES
(1, 38, 'puneet', 'punetsinghal@gmail.com', 2147483647, 'Jaipur', 'Jaipur', 'Rajasthan', 'India', 'Medical Store1', 1, 'dhs_KSb'),
(32, 36, 'Distributor_demo', 'r72k576jimi@gmail.com', 890453, 'near', 'jaipur', 'raj', 'india', 'Demo shop', 1, 'dhs_KSb'),
(41, 3, 'Demo medicine', 'check@gmail.com', 546546, 'as', 'Jaipur', 'Rajasthan', 'India', 'demo', 0, 'dhs_KSb'),
(48, 52, 'rahul_v', '', 878787, 'rahul_v', 'rahul_v', 'rahul_v', 'rahul_v', 'rahul_v', 1, 'dhs_KSb'),
(49, 55, 'he', '', 3284678, 'fejkvfb', 'bwf', 'fn', 'fnekm ', 'carefree', 0, 'dhs_KSb'),
(50, 66, 'amitabh', 'abc@gmail.com', 123456789, 'nallasopara-east', 'thane', 'maharashtra', 'india', 'medical store', 0, 'dhs_MSb'),
(51, 69, 'dev ', 'dev@dev.com', 8888888888, 'virar', 'Thane', 'Maharashtra ', 'India', 'dev pharma', 0, 'dhs_mSb'),
(52, 70, 'prathmesh', 'prathmesh2009@gmail.com', 9833853509, 'R. no 4 nency colony borivali east', 'MUMBAI', 'MAHARASHTRA', 'INDIA', 'bharati', 0, 'dhs_MSb'),
(53, 73, 'sanket', 'sanku1189@gmail.com', 8080197507, 'ganesh chawl near behrampada\r\nBandra west', 'mumbai', 'maharashtra', 'india', 'amby valley', 0, 'dhs_MSb'),
(54, 75, 'amitabh', '1', 1, '1', '1', '1', '1', '1', 0, 'dhs_MSb'),
(55, 76, 'SANKET', 'sanket4@gmail.com', 9004978179, 'm 4 nency colony borivali ', 'mumbai', 'maharashtra', 'INDIA', 'MAHAVIR', 0, 'dhs_MSb'),
(56, 79, 'zen pharmaceuticals', '', 9273551893, 'b,27 & 28, basement mirza nagar, opp rly station virar esat -401303', 'thane', 'maharashtra', 'india', 'zen pharmaceuticals', 1, 'dhs_nSb'),
(57, 80, 'sai pharmaceutical distributors', '', 0, '42,parulekar compound, shree r.k. parulekar marg, palghar 401404', 'thane', 'maharashtra', 'india', 'sai pharmaceutical', 1, 'dhs_nSb'),
(58, 81, 'A.n.pharma', '', 25032519691, 'G-1 kanti empire, lal godown, vartak college road vasai west 401202', 'thane', 'maharashtra', 'india', 'A.n.pharma', 1, 'dhs_nSb'),
(59, 82, 'pranic enterprises', 'pranicenterprisespalghar@gmaIL.com', 9226883177, '01,kalpataru classic, near hareshwar mandir, chakradhar nagar st-depo road nallasopara west', 'thane', 'maharashtra', 'india', 'pranic enterprises', 1, 'dhs_nSb'),
(60, 83, 'indian distributors', '', 9987305511, '25, bhavesh plaza, laxmiben chedda road, nallasopara west, 401203', 'thane', 'maharashtra', 'india', 'indian distributors', 1, 'dhs_nSb'),
(61, 84, 'western hasmukh marketing pvt.ltd', '', 2228193251, '10, baldev sadan, maharana pratap[ road bhyander west 401101', 'thane', 'maharashtra', 'india', 'western hasmukh', 1, 'dhs_nSb'),
(62, 85, 'G.s.pharmaceuticals', 'g.s.pharmaa@gmail.com', 2500332341, '102,jaya apt, navghar vasai, vartak college road, near sheetal bar, vasai west.', 'thane', 'maharashtra', 'india', 'G.s.pharmaceuticals', 1, 'dhs_nSb'),
(63, 86, 'mukesh sales agency', '', 9223445613, '5, pancharatna co.hsg.soc., opp railway station bhyander east 401105', 'thane', 'maharashtra', 'india', 'mukesh sales agency', 1, 'dhs_nSb'),
(64, 87, 'arihant marketing', '', 952500344163, '1-A, sharda palace, navghar vasai west. 401202', 'thane', 'maharashtra', 'india', 'arihant marketing', 1, 'dhs_nSb'),
(65, 88, 'parasnath distributors', 'parasnathdistributors@gmail.com', 8888500081, 'prasad ricemill,, nr. vatar school, vatar, virar west.401209', 'thane', 'maharashtra', 'india', 'parasnath distributors', 1, 'dhs_nSb'),
(66, 89, 'vimal distributors', '', 9960891217, '1, sai deep apartment, shirdi nagar, chandresh lodha marg, nallasopara east, 410209', 'thane', 'maharashtra', 'india', 'vimal distributors', 1, 'dhs_nSb'),
(67, 90, 'avani distributors', 'avanidistributors1967@gmail.com', 0, '104, viva mall, pushpa nagar, pp road virar west 401303', 'thane', 'maharashtra', 'india', 'avani distributors', 1, 'dhs_nSb'),
(68, 91, 'siddharth pharma', 'pharma.siddharth@gmail.com', 9322325562, '109, b wing pp.marg, virar west-401303', 'thane', 'maharashtra', 'india', 'siddharth pharma', 1, 'dhs_nSb'),
(69, 92, 'mayank enterprise', 'vimal_agency@jnjin.com', 22, '12,vardhman apartment, laxmiben chedda marg, nallasopara west 401203', 'thane', 'maharashtra', 'india', 'mayank enterprise', 1, 'dhs_nSb'),
(70, 93, 'nayak agencies', 'nayakagencies2013@gmail.com', 2228190441, '4, akash deep, opp ram bhavan, station road, bhyander west', 'thane', 'maharashtra', 'india', 'nayak agencies', 1, 'dhs_nSb'),
(71, 94, 'mahadev agency', 'mahadevagency623@gmail.com', 8805491290, '10, kailash darshan-1 alkapuri road. nalasopara east-401209', 'thane', 'maharashtra', 'india', 'mahadev agency', 1, 'dhs_nSb'),
(72, 95, 'arpit pharma', 'arpit_pharma@yahoo.com', 2228194832, 'c-111, sai mangalam, balram patel road, bhyander east', 'thane', 'maharashtra', 'india', 'arpit pharma', 1, 'dhs_nSb'),
(73, 96, 'garodia distributors', 'agarwal_bhavani@yahoo.com', 22281879737, 'g,garodia sadan,shop no1, maharaja agrasen marg, modi patel road, bhyander west', 'thane', 'maharashtra', 'india', 'garodia distributors', 1, 'dhs_nSb'),
(74, 97, 'R.P.Pharma', 'R.P.Pharma9@gmail.com', 2228162487, '22-B, divine sheration plaza, jesal park, sector c/2b, bhyander east 401105', 'thane', 'maharashtra', 'india', 'R.P.Pharma', 1, 'dhs_nSb'),
(75, 98, 'kirtikumar & company', 'kirtikumar.co@gmail.com', 7498544101, '2,kanti annex, prop-34, lal godown, vartak college road, vasai west. 401202', 'thane', 'maharashtra', 'india', 'kirtikumar & company', 1, 'dhs_nSb'),
(76, 99, 'veena agencies', 'veena_agencies@yahoo.com', 7276063631, 'G-1, kanti enclave, lal godown, vartak college road, vasai west. 401202', 'thane', 'maharashtra', 'india', 'veena agencies', 1, 'dhs_nSb'),
(77, 100, 'sakhi enterprises', 'sakhient93@gmail.com', 2500337146, 'B-11, marutidham, anand nagar, vasai west 401202', 'thane', 'maharashtra', 'india', 'sakhi enterprises', 1, 'dhs_nSb'),
(78, 101, 'Hari om Distributors', '', 9322047339, '01, n-wing, civic center, station road, nallasopara west 410203', 'thane', 'maharashtra', 'india', 'Hari om Distributors', 1, 'dhs_nSb'),
(79, 102, 'pharmalink distributors', '', 2228132197, 'B-10 shanti shopping centre, near mira road station , mira road east ', 'thane', 'maharashtra', 'india', 'pharmalink distributors', 1, 'dhs_nSb'),
(80, 103, 'shree enterprise', 'shreerushient@yahoo.in', 952506451267, '201, dhuri commerce plaza, next to vasai janta bank, vasai (e). 401210.', 'thane', 'Maharashtra', 'India', 'shree enterprise', 1, 'dhs_nSb'),
(81, 104, 'rushi enterprise', 'N/a', 952506451267, '206,207, dhuri commerece plaza, next vasai janta bank, vasai(e). 401210', 'Thane', 'Maharashtra', 'India', 'rushi enterprise', 1, 'dhs_nSb'),
(82, 105, 'metro pharma', 'metropharma1@gmail.com', 9224542338, '6, bharat jyot chs, narayan nagar, bhayander (w).', 'Mumbai', 'Maharashtra', 'India', 'metro pharma', 1, 'dhs_nSb'),
(83, 106, 'western pharma', 'westernpharma1980@gmail.com', 9223358975, 'A1, gracy chs, prakash market rd., narayan nagar, cross rd., bhayander(w). 401101', 'Mumbai', 'Maharashtra', 'India', 'western pharma', 1, 'dhs_nSb'),
(84, 107, 'avani distributor', 'avanidistributors1967@gmail.com', 0, '104, viva mall, pushpa nagar, pp  rd., virar(w). 401303', 'Thane', 'Maharashtra', 'India', 'avani distributor', 1, 'dhs_nSb'),
(85, 108, 'namrata agencies', 'n/a', 22, '117, o.p commerce center, opp railway station, bhayander (e).401105', 'Mumbai', 'Maharashtra', 'India', 'namrata agencies', 1, 'dhs_nSb'),
(86, 109, 'padam disributors', 'padamd@gmail.com', 22, 'g-6/b1, saraswasti park, s.v. rd., off. navghar rd., bhayander(e), ', 'Mumbai', 'Maharashtra', 'India', 'padam disributors', 1, 'dhs_nSb'),
(87, 110, 'gautam pharma', 'n/a', 9324885890, '3, sai krishma apt.,behind post office,b.p. rd., bhayander (e).', 'Mumbai', 'Maharashtra', 'India', 'gautam pharma', 1, 'dhs_nSb'),
(88, 111, 'rajnikant keshavlal & sons', 'n/a', 250, '1-4, mahashakti apt., navghar, vasai (w).', 'Thane ', 'Maharashtra', ' India', 'rajnikant keshavlal & sons', 1, 'dhs_nSb'),
(89, 112, 'lotus pharma', 'lotuspharmavasai@gmail.com', 9209534734, 'shop G-1, kanti annex, lal godwon, vartak college rd.,vasai (w).', 'Thane', 'Maharashtra', 'India', 'lotus pharma', 1, 'dhs_nSb'),
(90, 113, 'shree jasubai', 'n/a', 9272647773, '101, shushila apt., behind desai hospital, station rd., virar (w).', 'Thane', 'Maharashtra', 'India', 'shree jasubai', 1, 'dhs_nSb'),
(91, 115, 'rishabh agency', 'n/a', 250, 'devibhakti bulding, behind new life supermarket, jivdani rd., virar(e). \r\n', 'Thane', 'Maharashtra', 'India', 'rishabh agency', 1, 'dhs_nSb'),
(92, 116, 'jyoti distributors', 'n /a', 22, '11, venkateshwar, station rd., bhayander (w).401101', 'Mumbai', 'Maharashtra', 'India', 'jyoti distributors', 1, 'dhs_nSb'),
(93, 117, 'meher distributors', 'vasai@meherdistributors.com', 250, '108-12b, lawrence trade center, navghar rd., behind, bassein catholic bank, vasai (w).', 'Thane', 'Maharashtra', 'India', 'meher distributors', 1, 'dhs_nSb'),
(94, 118, 'chaitali distributor', 'chaitali.dist@ymail.com', 22, 'g1/g2, hinglaaj bulding, vinayak nagar rd., bhayander (w). 401101', 'Mumbai', 'Maharashtra', 'India', 'chaitali distributor', 1, 'dhs_nSb'),
(95, 119, 'sachin enterprises', 'n/a', 9270901930, '13, nand dham apt., viva college rd., opp. indian overseas bank , virar (w).', 'Thane', 'Maharashtra', 'India', 'sachin enterprises', 1, 'dhs_nSb'),
(96, 120, 'balaji marketing ', 'n/a', 9820836787, '14, kishor kunj, building no. 4, viva college rd., virar (w) 401303', 'Thane', 'Maharashtra', 'India', 'balaji marketing', 1, 'dhs_nSb'),
(97, 121, 'desai pharrma agency', 'desaipharrmaagency@gmail.com', 9987695310, '5, yamunotri bldg, near railway station, sanyukta nagar, achole, nallasopara (e) 401209', 'thane', 'maharashtra', 'india', 'desai pharrma agency', 1, 'dhs_nSb'),
(98, 122, 'mahavir enterprises', 'n/a', 0, '10, sukh sagar soc., next vidhya vihar school, virat nagar, virar (w)', 'Thane ', 'Maharashtra', 'India', 'mahavir enterprises', 1, 'dhs_nSb'),
(99, 123, 'jihan enterprises', 'n/a', 8108936822, '18, laxmi sadan building, Y.K. nagar nx, near expert school, virar (w).', 'Thane', 'Maharashtra', 'India', 'jihan enterprises', 1, 'dhs_nSb'),
(100, 124, 'Royal pharma', 'n/a', 9890295312, '3, siddhart apt., jain mandir rd., virar(w). 401303', 'Thane', 'Maharashtra', 'India', 'Royal pharma', 1, 'dhs_nSb'),
(101, 125, 'satyam marketing', 'satyammarketing92@yahoo.com', 250, 'A-1 nutan niwas, chs., veer shawarkar nagar, opp vishwakarma hall, navghar vasai (w).401202', 'Thane', 'Maharashtra', 'India', 'satyam marketing', 1, 'dhs_nSb'),
(102, 126, 'vitrag dist', 'n/a', 9321986966, '34, aster apt., behind viva super market, patankar park, station rd., nalasopara(w)', 'Thane', 'Maharashtra', 'India', 'vitrag dist', 1, 'dhs_nSb'),
(103, 127, 'sunrise agencies', 'n/A', 2506958456, '23, regal heights, vasant nagri, vasai (e).', 'Thane', 'Maharashtra', 'India', 'sunrise agencies', 1, 'dhs_nSb'),
(104, 128, 'shah trading co.', 'n/a', 9325394806, 'parshwanath apt., behind jain manbdir, opp. railway station, nalasopara(E)', 'Thane', 'Maharashtra', 'India', 'shah trading co.', 1, 'dhs_nSb'),
(105, 129, 'dist 1', 'dist1@dist1.com', 1234567890, 'nsp', 'thane', 'Maharashtra ', 'India', 'dist 1', 0, 'dhs_mSb'),
(106, 132, 'sumit sundram', '321321', 521321, '521321', '5213213', '2313213', '321321', '13214', 0, 'dhs_mSb'),
(107, 133, 'sundaram', 'par@1234', 123456789, 'xyz', 'mumbai', 'maharastra', 'india', 'jai ho', 1, 'dhs_mSb'),
(108, 136, 'suarj', '1', 1, '1', '1', '1', '1', 'a', 0, 'dhs_MSb'),
(109, 138, 'Ram Sales', 'ram.sales@gmail.com', 9999999999, 'Jaipur', 'Jaipur', 'Rajsthan', 'India', '41', 0, 'dhs_NSb'),
(110, 139, 'S.k ', 'sharmaagency@gmail.com', 9999999999, 'Jaipur', 'Jaipur', 'Rajasthan', 'India', 'Sharma Agency', 0, 'dhs_NSb'),
(111, 140, 'SUNIL', 'sunil.21@gmail.com', 9999999999, 'jaipur', 'Jaipur', 'Rajasthan', 'India', 'Sunil enterprises', 0, 'dhs_NSb'),
(112, 141, 'Pratap', 'pratap.987@gmail.com', 9999999999, 'Jhajhar', 'Jaipur', 'Rajasthan', 'India', 'Pratap medicoj', 0, 'dhs_NSb'),
(113, 142, 'Rahul', 'rahul.20@gmail.com', 9999999999, 'Jaipur', 'Jaipur', 'Rajasthan', 'India', 'Rahul Medical', 0, 'dhs_NSb'),
(114, 148, 'ganesh', 'ganesh@gmail.com', 9890592694, 'office', 'jaipur', 'rajasthan', 'india', 'ganpeti ent', 1, 'dhs_oSb'),
(115, 149, 'shankar', 'shanger@gmail.com', 9890592694, 'jaipur', 'jaipur', 'rajasthan', 'india', 'sh', 1, 'dhs_oSb'),
(116, 150, 'ram', 'sham@gmail.com', 7738887773, 'office', 'jaipur', 'rajasthan', 'india', 'ram sham', 1, 'dhs_oSb'),
(117, 152, 'Rakesh', 'rakesh@gmail.com', 1234567810, 'virar east', 'thane ', 'maharashtra', 'india', '101', 1, 'dhs_MSb'),
(118, 153, 'Kishan', 'kishan @gmail.com', 12345678910, 'nallasopara-east', 'thane', 'maharashtra', 'india', '102', 1, 'dhs_MSb');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
