-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 10, 2025 at 04:44 PM
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
-- Database: `users`
--

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` int(20) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `contact_number` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `blood_type` varchar(10) NOT NULL,
  `allergies` varchar(100) NOT NULL,
  `conditions` varchar(100) NOT NULL,
  `surgeries` varchar(100) NOT NULL,
  `medications` varchar(100) NOT NULL,
  `family_history` varchar(100) NOT NULL,
  `assigned_doctor` varchar(100) NOT NULL,
  `reason_for_visit` text NOT NULL,
  `emergency_contact_name` varchar(100) NOT NULL,
  `relationship` varchar(100) NOT NULL,
  `emergency_contact_number` varchar(15) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `full_name`, `dob`, `gender`, `contact_number`, `email`, `address`, `blood_type`, `allergies`, `conditions`, `surgeries`, `medications`, `family_history`, `assigned_doctor`, `reason_for_visit`, `emergency_contact_name`, `relationship`, `emergency_contact_number`, `created_at`) VALUES
(1, 'Declan Wall', '2003-09-28', 'Male', '+1 (465) 843-19', 'kegomo@mailinator.com', 'Incididunt voluptate', 'Sunt conse', 'Ad mollit mollit ex ', 'Possimus cillum aut', 'Fuga Autem exceptur', 'Rerum dolor anim odi', 'In voluptatem Sunt', 'Voluptates commodo q', 'Fuga Facere in culp', 'Charles Carpenter', 'Quia aut atque sint ', '+1 (316) 913-17', '2025-03-10 15:30:57'),
(2, 'Kenyon Jimenez', '1971-12-30', 'Female', '+1 (424) 666-42', 'kohoqepu@mailinator.com', 'Porro expedita ut ad', 'Magna labo', 'Harum quis fugit ad', 'Voluptas et et odio ', 'Quam eligendi quam o', 'Aut explicabo Asper', 'Minima mollit laboru', 'Earum est excepturi ', 'Reprehenderit commo', 'Echo Kline', 'Nostrud tempor praes', '+1 (353) 522-31', '2025-03-10 15:33:20'),
(3, 'Lee Sherman', '1993-10-21', 'Other', '+1 (708) 892-52', 'mupepawigo@mailinator.com', 'Maxime provident mi', 'Doloribus ', 'Odit commodo non dol', 'Libero a numquam eaq', 'Sit ut labore illum', 'Explicabo Eiusmod u', 'Veniam quis eaque d', 'Debitis qui enim ess', 'Unde magnam voluptat', 'Jayme Reeves', 'Voluptatibus ipsum q', '+1 (798) 739-58', '2025-03-10 15:33:40'),
(4, 'Barry Hodges', '2023-11-24', 'Female', '+1 (931) 971-82', 'subij@mailinator.com', 'Aut eu consequatur t', 'Ipsum sint', 'Aut ut quo enim corp', 'Unde illo veritatis ', 'Aliquip commodi et a', 'Mollit esse in id n', 'Molestiae enim totam', 'Ex natus fugiat fug', 'Nihil culpa molestia', 'Mary Zamora', 'Voluptas animi adip', '+1 (903) 134-41', '2025-03-10 15:44:07');

-- --------------------------------------------------------

--
-- Table structure for table `users_acc`
--

CREATE TABLE `users_acc` (
  `id` int(20) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_acc`
--

INSERT INTO `users_acc` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'cedricjade13', 'gwapoko', '0000-00-00 00:00:00.000000'),
(2, 'cedricjade13', 'gwapoko1', '2025-03-10 14:18:53.000000'),
(3, 'cedricjade13', '$2y$10$87jn0p76Fdmd.lW6L7Ni3egfb7kmZQ4nNZgbl.hQiSmxzUkTLyx7C', '2025-03-10 14:30:59.546677'),
(4, 'jade', '$2y$10$4vKTBw/QA0USfNNM07z1g.hFhxzGZqJwmE8vvjKFJj5W64iEBoiBu', '2025-03-10 14:31:38.948976');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_acc`
--
ALTER TABLE `users_acc`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users_acc`
--
ALTER TABLE `users_acc`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
