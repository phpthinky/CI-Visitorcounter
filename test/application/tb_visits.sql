-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 18, 2019 at 03:29 AM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.0.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cacaov2`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_visits`
--

CREATE TABLE `tbl_visits` (
  `visit_id` int(11) NOT NULL,
  `country` varchar(25) NOT NULL,
  `date_of_visit` date NOT NULL,
  `counter` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_visits`
--

INSERT INTO `tbl_visits` (`visit_id`, `country`, `date_of_visit`, `counter`) VALUES
(1, 'AU', '2019-03-04', 6),
(2, 'EC', '2019-03-05', 1),
(3, 'JP', '2019-03-05', 2),
(4, 'PH', '2019-03-05', 2),
(5, 'US', '2019-03-05', 1),
(6, 'AU', '2019-03-05', 1),
(7, '', '2019-03-18', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_visits`
--
ALTER TABLE `tbl_visits`
  ADD PRIMARY KEY (`visit_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_visits`
--
ALTER TABLE `tbl_visits`
  MODIFY `visit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
