-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 13, 2011 at 04:46 PM
-- Server version: 5.0.92
-- PHP Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `adam1234_class`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_Calendar`
--

CREATE TABLE IF NOT EXISTS `tbl_Calendar` (
  `cal_id` int(11) NOT NULL auto_increment,
  `cal_label` varchar(10) NOT NULL,
  `cal_code` varchar(2) NOT NULL,
  `cal_type` int(1) NOT NULL,
  PRIMARY KEY  (`cal_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `tbl_Calendar`
--

INSERT INTO `tbl_Calendar` (`cal_id`, `cal_label`, `cal_code`, `cal_type`) VALUES
(3, 'interterm', '01', 1),
(4, 'spring', '02', 1),
(5, 'summer I', '03', 1),
(6, 'summer II', '04', 1),
(7, 'fall', '05', 1),
(8, 'winter', '06', 2),
(9, 'spring', '07', 2),
(10, 'summer I', '08', 2),
(11, 'summer II', '09', 2),
(12, 'fall', '10', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ClassEntries`
--

CREATE TABLE IF NOT EXISTS `tbl_ClassEntries` (
  `ce_id` int(11) NOT NULL auto_increment,
  `ce_class_id` int(11) NOT NULL,
  `ce_recurrence` varchar(15) NOT NULL,
  `ce_start_time` varchar(5) NOT NULL,
  `ce_end_time` varchar(5) NOT NULL,
  `ce_professor_name` text NOT NULL,
  `ce_uid` int(11) NOT NULL,
  `ce_cal` int(11) NOT NULL,
  `ce_date_created` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`ce_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `tbl_ClassEntries`
--

INSERT INTO `tbl_ClassEntries` (`ce_id`, `ce_class_id`, `ce_recurrence`, `ce_start_time`, `ce_end_time`, `ce_professor_name`, `ce_uid`, `ce_cal`, `ce_date_created`) VALUES
(9, 13, 'm,w,f', '09:00', '09:50', 'Maxwell Oteng', 1, 1105, '2011-06-11 14:33:41'),
(10, 3, 'm', '11:00', '11:50', 'Tibor Machan', 1, 1105, '2011-06-11 14:33:41'),
(11, 5, 'm', '10:00', '10:50', 'Mike Moodian', 1, 1105, '2011-06-11 14:33:41'),
(12, 4, 'w', '11:00', '11:50', 'Mike Moodian', 1, 1105, '2011-06-11 14:33:41'),
(13, 14, 't,th', '13:00', '14:15', 'Wendy Adams', 1, 1105, '2011-06-11 18:16:09'),
(14, 13, 'm,w,f', '09:00', '09:50', 'Maxwell Oteng', 3, 1105, '2011-06-12 10:22:58'),
(15, 12, 'm,t,w,th', '09:00', '11:45', 'Ataman', 1, 1201, '2011-06-13 06:08:19');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ClassList`
--

CREATE TABLE IF NOT EXISTS `tbl_ClassList` (
  `cl_id` int(11) NOT NULL auto_increment,
  `cl_course_id` varchar(10) NOT NULL,
  `cl_college_id` int(11) NOT NULL,
  `cl_class_name` text NOT NULL,
  `cl_date_created` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`cl_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=47 ;

--
-- Dumping data for table `tbl_ClassList`
--

INSERT INTO `tbl_ClassList` (`cl_id`, `cl_course_id`, `cl_college_id`, `cl_class_name`, `cl_date_created`) VALUES
(1, 'BUS100', 1, 'Introduction to Business', '2011-06-10 12:49:15'),
(2, 'BUS215', 1, 'Legal Environment of Business', '2011-06-10 12:49:15'),
(3, 'BUS216', 1, 'Business Ethics', '2011-06-10 12:49:15'),
(4, 'BUS217', 1, 'Business Communication: Writing Skills', '2011-06-10 12:49:15'),
(5, 'BUS218', 1, 'Business Communication: Oral Skills', '2011-06-10 12:49:15'),
(6, 'BUS229', 1, 'Experimental Course', '2011-06-10 12:49:15'),
(7, 'BUS290', 1, 'Internship', '2011-06-10 12:49:15'),
(8, 'BUS299', 1, 'Individual Study', '2011-06-10 12:49:15'),
(9, 'BUS329', 1, 'Experimental Course', '2011-06-10 12:49:15'),
(10, 'BUS475', 1, 'Business Policy: An International Perspective', '2011-06-10 12:49:55'),
(11, 'BUS486', 1, 'Business Across Cultures', '2011-06-10 12:49:55'),
(12, 'ECON200', 1, 'Principles of Microeconomics', '2011-06-11 13:43:12'),
(13, 'ECON201', 1, 'Principles of Macroeconomics', '2011-06-11 13:47:33'),
(14, 'ACTG210', 1, 'Introduction to Financial Accounting', '2011-06-11 14:23:07'),
(15, 'ACTG211', 1, 'Introduction to Managerial Accounting', '2011-06-11 14:23:07'),
(16, 'ACTG299', 1, 'Individual Study', '2011-06-11 14:23:07'),
(17, 'ACTG312', 1, 'Financial Reporting and Statement Analysis', '2011-06-11 14:23:07'),
(18, 'ACTG320', 1, 'Cost Accounting I', '2011-06-11 14:23:07'),
(19, 'ACTG321', 1, 'Cost Accounting II', '2011-06-11 14:23:07'),
(20, 'ACTG330', 1, 'Intermediate Financial Accounting I', '2011-06-11 14:23:07'),
(21, 'ACTG331', 1, 'Intermediate Financial Accounting II', '2011-06-11 14:23:07'),
(22, 'ACTG439', 1, 'Accounting Information Systems', '2011-06-11 14:23:07'),
(23, 'ACTG440', 1, 'Advanced Financial Accounting', '2011-06-11 14:23:07'),
(24, 'ACTG450', 1, 'Individual Taxation', '2011-06-11 14:23:07'),
(25, 'ACTG451', 1, 'Taxation of Corporations and Other Entities', '2011-06-11 14:23:07'),
(26, 'ACTG460', 1, 'Auditing', '2011-06-11 14:23:07'),
(27, 'ACTG496', 1, 'Special Topics in Accounting', '2011-06-11 14:23:07'),
(28, 'ACTG499', 1, 'Individual Study', '2011-06-11 14:23:07'),
(29, 'ECON299', 1, 'Individual Study', '2011-06-11 14:30:37'),
(30, 'ECON314', 1, 'United States Economic and Entrepreneurial History', '2011-06-11 14:30:37'),
(31, 'ECON315', 1, 'Economics of Religion', '2011-06-11 14:30:37'),
(32, 'ECON329', 1, 'Experimental Course', '2011-06-11 14:30:37'),
(33, 'ECON350', 1, 'Intermediate Microeconomic Theory', '2011-06-11 14:30:37'),
(34, 'ECON351', 1, 'Intermediate Macroeconomic Theory', '2011-06-11 14:30:37'),
(35, 'ECON355', 1, 'Economics of Race and Culture in America', '2011-06-11 14:30:37'),
(36, 'ECON411', 1, 'International Economics', '2011-06-11 14:30:37'),
(37, 'ECON420', 1, 'Foundations of Economic Exchange', '2011-06-11 14:30:37'),
(38, 'ECON411', 1, 'Economic Development', '2011-06-11 14:30:37'),
(39, 'ECON448', 1, 'Managerial Economics', '2011-06-11 14:30:37'),
(40, 'ECON452', 1, 'Econometrics', '2011-06-11 14:30:37'),
(41, 'ECON465', 1, 'Environmental and Natural Resources Economics', '2011-06-11 14:30:37'),
(42, 'ECON471', 1, 'Experimental Economics I', '2011-06-11 14:30:37'),
(43, 'ECON472', 1, 'Experimental Economics II', '2011-06-11 14:30:37'),
(44, 'ECON481', 1, 'Economic Systems Design I: Principles and Experiments', '2011-06-11 14:30:37'),
(45, 'ECON496', 1, 'Special Topics in Economics', '2011-06-11 14:30:37'),
(46, 'ECON499', 1, 'Individual Study', '2011-06-11 14:30:37');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_Colleges`
--

CREATE TABLE IF NOT EXISTS `tbl_Colleges` (
  `c_id` int(11) NOT NULL auto_increment,
  `c_state` varchar(2) NOT NULL,
  `c_name` text NOT NULL,
  `c_term_type` int(11) NOT NULL,
  `c_date_created` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`c_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tbl_Colleges`
--

INSERT INTO `tbl_Colleges` (`c_id`, `c_state`, `c_name`, `c_term_type`, `c_date_created`) VALUES
(1, 'CA', 'Chapman University', 1, '2011-06-09 09:08:28'),
(2, 'CA', 'University of Southern California', 1, '2011-06-09 09:08:28'),
(3, 'CA', 'UCLA', 2, '2011-06-09 09:09:07'),
(4, 'CA', 'University of California - Santa Barbara', 2, '2011-06-09 09:09:07'),
(5, 'GA', 'University of Georgia', 1, '2011-06-09 09:09:18');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_Users`
--

CREATE TABLE IF NOT EXISTS `tbl_Users` (
  `u_id` int(11) NOT NULL auto_increment,
  `u_oauth_provider` enum('facebook','twitter','google') NOT NULL,
  `u_oauth_uid` int(11) NOT NULL,
  `u_email` text NOT NULL,
  `u_first_name` text NOT NULL,
  `u_last_name` text NOT NULL,
  `u_dob` varchar(10) NOT NULL,
  `u_gender` enum('male','female') NOT NULL,
  `u_profile_link` text NOT NULL,
  `u_college_id` int(11) NOT NULL,
  `u_date_created` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`u_id`),
  UNIQUE KEY `u_oauth_uid` (`u_oauth_uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tbl_Users`
--

INSERT INTO `tbl_Users` (`u_id`, `u_oauth_provider`, `u_oauth_uid`, `u_email`, `u_first_name`, `u_last_name`, `u_dob`, `u_gender`, `u_profile_link`, `u_college_id`, `u_date_created`) VALUES
(1, 'facebook', 534430388, 'funkymunky200@hotmail.com', 'Adam', 'Bedford', '1991-06-30', 'male', 'http://www.facebook.com/adam1234', 1, '2011-06-07 12:26:48'),
(2, 'facebook', 2147483647, 'designbyapex@live.com', 'Us', 'Er', '1991-06-30', 'male', 'http://www.facebook.com/profile.php?id=100002407738068', 0, '2011-06-08 13:47:39'),
(3, 'facebook', 501590300, 'agustin744@hotmail.com', 'Agustin', 'Moreno', '1983-03-02', 'male', 'http://www.facebook.com/agustin.moreno1', 1, '2011-06-09 18:40:35');
