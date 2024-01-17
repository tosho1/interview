-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 18, 2024 at 06:36 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `employee_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `EmployeeID` int(11) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `HireDate` date NOT NULL,
  `Role` varchar(50) DEFAULT NULL,
  `Department` varchar(50) NOT NULL,
  `status` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`EmployeeID`, `FirstName`, `LastName`, `HireDate`, `Role`, `Department`, `status`) VALUES
(1, 'Omotosho', 'Adewale', '1997-01-01', 'developer', 'IT', 'fired'),
(2, 'John', 'Doe', '2023-01-01', NULL, 'IT', NULL),
(3, 'ola', 'ola', '2000-01-01', 'design', 'IT', 'fired'),
(4, 'Esther', 'mark', '1994-01-01', NULL, 'IT', NULL),
(6, 'wummi', 'Bola', '2024-01-18', NULL, 'IT', NULL),
(7, 'Blessing', 'Adewale', '2024-01-18', 'design', 'IT', NULL),
(19, 'Blessing', 'Adewale', '2024-01-18', NULL, 'IT', NULL),
(20, 'Adebolawale', 'tobi', '2024-01-18', NULL, 'IT', NULL),
(21, 'Adebolawale', 'tobi', '2024-01-18', NULL, 'IT', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`EmployeeID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `EmployeeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
