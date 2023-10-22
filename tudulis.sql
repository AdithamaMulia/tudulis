-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 22, 2023 at 06:22 PM
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
-- Database: `tudulis`
--

-- --------------------------------------------------------

--
-- Table structure for table `listudu`
--

CREATE TABLE `listudu` (
  `id_task` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `task_name` varchar(255) NOT NULL,
  `task_status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `listudu`
--

INSERT INTO `listudu` (`id_task`, `id_user`, `task_name`, `task_status`) VALUES
(3, 2, 'aada', 'Not Yet'),
(8, 1, 'test', 'Done');

-- --------------------------------------------------------

--
-- Table structure for table `userdata`
--

CREATE TABLE `userdata` (
  `id_user` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userdata`
--

INSERT INTO `userdata` (`id_user`, `username`, `password`) VALUES
(1, 'SHIN', '$2y$10$1Ve7ZVq3SzlhsLeBFf6eDO1nt8HMCwDnNcTC6wJ.0VlRvH1aJZAY2'),
(2, 'SHINN', '$2y$10$SWE9QLYFhmwkmwxlNdTo7e./bbd.eQk/TCVofOFhGsy88ACc7kBY2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `listudu`
--
ALTER TABLE `listudu`
  ADD PRIMARY KEY (`id_task`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `userdata`
--
ALTER TABLE `userdata`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `listudu`
--
ALTER TABLE `listudu`
  MODIFY `id_task` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `userdata`
--
ALTER TABLE `userdata`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `listudu`
--
ALTER TABLE `listudu`
  ADD CONSTRAINT `listudu_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `userdata` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
