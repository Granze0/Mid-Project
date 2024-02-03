-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 03, 2024 at 05:56 PM
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
-- Database: `attendance_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` varchar(5) NOT NULL,
  `firstName` varchar(50) DEFAULT NULL,
  `lastName` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `passwordHash` varchar(32) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `bio` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `firstName`, `lastName`, `email`, `passwordHash`, `password`, `bio`) VALUES
('UD01', 'admin ', 'admin  ', 'admin@gmail.com', '0192023a7bbd73250516f069df18b500', 'admin123', 'This is admin');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` varchar(5) DEFAULT NULL,
  `photo` blob DEFAULT NULL,
  `firstName` varchar(50) DEFAULT NULL,
  `lastName` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `passwordHash` varchar(255) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `bio` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `photo`, `firstName`, `lastName`, `email`, `passwordHash`, `password`, `bio`) VALUES
('U003', 0x75706c6f6164732f534f454b41524e4f2e6a7067, 'Udin', 'Petot ', 'udinpetot123@gmail.com', '626d47988937e7ce40b788f72994a1da', 'udinpetot123', ''),
('U004', NULL, 'Ada', 'Wong', 'wongwong@gmail.com', NULL, NULL, ''),
('U005', NULL, 'Sugianto', 'Sutanto', 'SugiantoSutanto@binus.ac.id', NULL, NULL, 'aha'),
('U006', NULL, 'password hash test', 'test', 'pass@gmail.com', '$2y$10$m3rLA5SCOGAU1roiIKBGVOg/l2TEpZJnUNO7ugE9I81Yr8UGI51Uq', '12345', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
