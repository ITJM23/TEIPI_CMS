-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 05, 2024 at 04:48 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `teipi_emp3`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `Act_Log_Id` int(11) NOT NULL,
  `Act_name` varchar(255) NOT NULL,
  `User_Id` int(11) NOT NULL,
  `Emp_Id` int(11) NOT NULL,
  `Date_added` date NOT NULL,
  `Time_added` time NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `Emp_Id` int(11) NOT NULL,
  `Emp_Hash` text NOT NULL,
  `Emp_Num` text NOT NULL,
  `Emp_Type` int(11) NOT NULL,
  `Status` int(11) NOT NULL,
  `Image` text NOT NULL,
  `randSalt1` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `emp_accounts`
--

CREATE TABLE `emp_accounts` (
  `Emp_Acc_Id` int(11) NOT NULL,
  `Emp_Id` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` text NOT NULL,
  `User_lvl_Id` int(11) NOT NULL,
  `Date_added` date NOT NULL,
  `Time_added` time NOT NULL,
  `Status` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `emp_contact`
--

CREATE TABLE `emp_contact` (
  `Emp_Cont_Id` int(11) NOT NULL,
  `Emp_Id` int(11) NOT NULL,
  `Contact_No` varchar(255) NOT NULL,
  `Emp_peraddr` varchar(255) NOT NULL,
  `Emp_curaddr` varchar(255) NOT NULL,
  `Emerg_cont` varchar(255) NOT NULL,
  `Emerg_contno` varchar(255) NOT NULL,
  `Status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `emp_dept`
--

CREATE TABLE `emp_dept` (
  `Emp_Dept_Id` int(11) NOT NULL,
  `Emp_Dept` varchar(255) NOT NULL,
  `Date_added` date NOT NULL,
  `Time_added` time NOT NULL,
  `Status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `emp_desig`
--

CREATE TABLE `emp_desig` (
  `Emp_Des_Id` int(11) NOT NULL,
  `Emp_Id` int(11) NOT NULL,
  `Dept_Id` int(11) NOT NULL,
  `Date_hired` date DEFAULT NULL,
  `Date_regular` date DEFAULT NULL,
  `Pos_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `emp_info`
--

CREATE TABLE `emp_info` (
  `Emp_Info_Id` int(11) NOT NULL,
  `Emp_Id` int(11) NOT NULL,
  `Lname` varchar(255) NOT NULL,
  `Fname` varchar(255) NOT NULL,
  `Mname` varchar(255) NOT NULL,
  `Nickname` varchar(255) DEFAULT NULL,
  `Birthdate` date DEFAULT NULL,
  `Sex` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `emp_position`
--

CREATE TABLE `emp_position` (
  `Emp_Pos_Id` int(11) NOT NULL,
  `Emp_pos` varchar(255) NOT NULL,
  `Date_added` date NOT NULL,
  `Time_added` time NOT NULL,
  `Status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `emp_req`
--

CREATE TABLE `emp_req` (
  `Emp_Req_Id` int(11) NOT NULL,
  `Emp_Id` int(11) NOT NULL,
  `SSS` varchar(255) NOT NULL,
  `Philhealth` varchar(255) NOT NULL,
  `Pagibig` varchar(255) NOT NULL,
  `TIN` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `emp_type`
--

CREATE TABLE `emp_type` (
  `Emp_Type_Id` int(11) NOT NULL,
  `Emp_Type` varchar(255) NOT NULL,
  `Date_added` date DEFAULT NULL,
  `Time_added` time DEFAULT NULL,
  `Status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_level`
--

CREATE TABLE `user_level` (
  `User_lvl_Id` int(11) NOT NULL,
  `User_level` varchar(255) NOT NULL,
  `Status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`Act_Log_Id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`Emp_Id`);

--
-- Indexes for table `emp_accounts`
--
ALTER TABLE `emp_accounts`
  ADD PRIMARY KEY (`Emp_Acc_Id`);

--
-- Indexes for table `emp_contact`
--
ALTER TABLE `emp_contact`
  ADD PRIMARY KEY (`Emp_Cont_Id`);

--
-- Indexes for table `emp_dept`
--
ALTER TABLE `emp_dept`
  ADD PRIMARY KEY (`Emp_Dept_Id`);

--
-- Indexes for table `emp_desig`
--
ALTER TABLE `emp_desig`
  ADD PRIMARY KEY (`Emp_Des_Id`);

--
-- Indexes for table `emp_info`
--
ALTER TABLE `emp_info`
  ADD PRIMARY KEY (`Emp_Info_Id`);

--
-- Indexes for table `emp_position`
--
ALTER TABLE `emp_position`
  ADD PRIMARY KEY (`Emp_Pos_Id`);

--
-- Indexes for table `emp_req`
--
ALTER TABLE `emp_req`
  ADD PRIMARY KEY (`Emp_Req_Id`);

--
-- Indexes for table `emp_type`
--
ALTER TABLE `emp_type`
  ADD PRIMARY KEY (`Emp_Type_Id`);

--
-- Indexes for table `user_level`
--
ALTER TABLE `user_level`
  ADD PRIMARY KEY (`User_lvl_Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `Act_Log_Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `Emp_Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emp_accounts`
--
ALTER TABLE `emp_accounts`
  MODIFY `Emp_Acc_Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emp_contact`
--
ALTER TABLE `emp_contact`
  MODIFY `Emp_Cont_Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emp_dept`
--
ALTER TABLE `emp_dept`
  MODIFY `Emp_Dept_Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emp_desig`
--
ALTER TABLE `emp_desig`
  MODIFY `Emp_Des_Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emp_info`
--
ALTER TABLE `emp_info`
  MODIFY `Emp_Info_Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emp_position`
--
ALTER TABLE `emp_position`
  MODIFY `Emp_Pos_Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emp_req`
--
ALTER TABLE `emp_req`
  MODIFY `Emp_Req_Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emp_type`
--
ALTER TABLE `emp_type`
  MODIFY `Emp_Type_Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_level`
--
ALTER TABLE `user_level`
  MODIFY `User_lvl_Id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
