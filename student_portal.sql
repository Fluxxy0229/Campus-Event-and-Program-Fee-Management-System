-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 09, 2024 at 01:13 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `student_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(1, 'cepfmsAdmin1@gmail.com', 'cepfmsAdmin1'),
(2, 'cepfmsAdmin2@gmail.com', 'cepfmsAdmin2'),
(3, 'cepfmsAdmin3@gmail.com', 'cepfmsAdmin3'),
(4, 'cepfmsAdmin4@gmail.com', 'cepfmsAdmin4'),
(5, 'cepfmsAdmin5@gmail.com', 'cepfmsAdmin5');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `date` date DEFAULT NULL,
  `description` text NOT NULL,
  `registration_fee` decimal(10,2) NOT NULL,
  `due_date` date DEFAULT NULL,
  `fee_amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `name`, `date`, `description`, `registration_fee`, `due_date`, `fee_amount`) VALUES
(1, 'Campus Intramurals 2025', '2025-01-01', 'A', 0.00, '2025-01-11', 150.00),
(2, 'Mr. and Mrs. ISU - San Mateo 2025', '2025-02-02', 'B', 0.00, '2025-02-12', 50.00),
(3, 'Teachers\' Day 2025', '2025-03-03', 'C', 0.00, '2025-03-13', 100.00),
(4, 'Students\' Week 2025', '2025-04-04', 'D', 0.00, '2025-04-14', 50.00);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `payment_status` enum('paid','unpaid') NOT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `student_id` varchar(20) NOT NULL,
  `course` varchar(100) NOT NULL,
  `year` varchar(10) NOT NULL,
  `section` varchar(10) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `guardian_name` varchar(255) NOT NULL,
  `guardian_phone_number` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `full_name`, `student_id`, `course`, `year`, `section`, `phone_number`, `guardian_name`, `guardian_phone_number`, `password`, `photo`) VALUES
(1, 'Mark Vince F. Gammad', '10-0001', 'BSED: Major in Social Studies', '1st Year', 'A', '1', 'Mr. Gammad', '1', '$2y$10$zmRR0nTMT96urbI2/ET07.sfd5dmOK8g2rCc6dT1lBE4kLOVWTkNK', 'IMG_20241027_222304_934.webp'),
(2, 'Jhoe Renz G. Nitura', '10-0002', 'BSED: Major in Mathematics', '2nd Year', 'B', '2', 'Mr. Nitura', '2', '$2y$10$EVJvpt6Z25yLPXteiiXu1.WS5EmjGJFRlNmtWVCfJMDBWgVtyX032', 'Picsart_24-12-07_09-59-06-052.jpg'),
(3, 'Mark Oaren G. Fayosal', '10-0003', 'BTVTED: Major in Garments Fashion and Design', '3rd Year', 'C', '3', 'Mr. Fayosal', '3', '$2y$10$n5cN2aKhv7cmK/HxGaHXE.eu4zQEOM.2eadbcAodMysT.cyT9SUJC', 'Picsart_24-12-07_09-59-53-226.jpg'),
(4, 'Marphil G. Galapon', '10-0004', 'BTVTED: Major in Electrical Technology', '4th Year', 'D', '4', 'Mr. Galapon', '4', '$2y$10$URrtCB0hbo.Zk.eR64wgdOZhUowjFCP2R6zFy2KeslkgDL72ywwHm', 'Picsart_24-12-07_09-59-20-132.jpg'),
(5, 'Maricar S. Domingcil', '10-0005', 'BTVTED: Major in Electronics Technology', '1st Year', 'A', '5', 'Mr. Domingcil', '5', '$2y$10$hRbMSomiRc7fRxjoV.PHOe60ILUefWmMjkDq15pJYkXb4FHqIY/He', 'Picsart_24-12-07_09-58-51-624.jpg'),
(6, 'Jocel V. De Vera', '10-0006', 'BSIT', '2nd Year', 'B', '6', 'Mr. De Vera', '6', '$2y$10$MHtGPB3Ui5BCnHWW9.goBeEesIyjoc8b4DCRYYRhuIyYMFeTstueu', 'Picsart_24-12-07_09-59-34-455.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`),
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
