-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 03, 2025 at 12:37 PM
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
-- Table structure for table `medicines`
--

CREATE TABLE `medicines` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `dosage` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `expiry_date` date NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medicines`
--

INSERT INTO `medicines` (`id`, `name`, `dosage`, `quantity`, `expiry_date`, `description`) VALUES
(1, 'Fallon Knox', 'Reprehenderit optio', 57, '0000-00-00', 'Voluptatem Providen'),
(2, 'Biogesic', 'Nam proident non qu', 800, '0000-00-00', 'Reiciendis voluptate'),
(3, 'Reese Bender', 'Quod quam ea optio ', 815, '0000-00-00', 'Illum sint libero a'),
(4, 'Halee Monroe', 'Distinctio Iste ten', 70, '1986-03-23', 'Est debitis labore ');

-- --------------------------------------------------------

--
-- Table structure for table `medicine_dispenses`
--

CREATE TABLE `medicine_dispenses` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `medicine_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `dispense_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medicine_dispenses`
--

INSERT INTO `medicine_dispenses` (`id`, `patient_id`, `medicine_id`, `quantity`, `dispense_date`) VALUES
(1, 6, 4, 5, '2025-05-03 10:31:41'),
(2, 8, 2, 64, '2025-05-03 10:32:47');

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
(1, 'Declan Walley', '2003-09-28', 'Male', '+1 (465) 843-19', 'kegomo@mailinator.com', 'Incididunt voluptate', 'Sunt conse', 'Ad mollit mollit ex ', 'Possimus cillum aut', 'Fuga Autem exceptur', 'Rerum dolor anim odi', 'In voluptatem Sunt', 'Voluptates commodo q', 'Fuga Facere in culp', 'Charles Carpenter', 'Quia aut atque sint ', '+1 (316) 913-17', '2025-05-03 08:31:26'),
(2, 'Kenyon Jimenez', '1971-12-30', 'Female', '+1 (424) 666-42', 'kohoqepu@mailinator.com', 'Porro expedita ut ad', 'Magna labo', 'Harum quis fugit ad', 'Voluptas et et odio ', 'Quam eligendi quam o', 'Aut explicabo Asper', 'Minima mollit laboru', 'Earum est excepturi ', 'Reprehenderit commo', 'Echo Kline', 'Nostrud tempor praes', '+1 (353) 522-31', '2025-03-10 15:33:20'),
(3, 'Lee Sherman', '1993-10-21', 'Other', '+1 (708) 892-52', 'mupepawigo@mailinator.com', 'Maxime provident mi', 'Doloribus ', 'Odit commodo non dol', 'Libero a numquam eaq', 'Sit ut labore illum', 'Explicabo Eiusmod u', 'Veniam quis eaque d', 'Debitis qui enim ess', 'Unde magnam voluptat', 'Jayme Reeves', 'Volupt atibus ipsum q', '+1 (798) 739-58', '2025-03-10 15:40:00'),
(4, 'Barry Hodges', '2023-11-24', 'Female', '+1 (931) 971-82', 'subij@mailinator.com', 'Aut eu consequatur t', 'Ipsum sint', 'Aut ut quo enim corp', 'Unde illo veritatis ', 'Aliquip commodi et a', 'Mollit esse in id n', 'Molestiae enim totam', 'Ex natus fugiat fug', 'Nihil culpa molestia', 'Mary Zamora', 'Voluptas animi adip', '+1 (903) 134-41', '2025-03-10 15:44:07'),
(6, 'Yawa Jangad', '2018-10-10', 'Female', '+1 (958) 948-67', 'huzy@mailinator.com', 'Aliquam sequi autem ', 'Non quibus', 'Explicabo Cupiditat', 'At esse aspernatur ', 'Porro accusamus quis', 'Aut dolor fugiat ev', 'Eum eius sequi disti', 'Est labore ab volup', 'Illum corrupti mol', 'Lev Mcbride', 'Laborum dolore aut q', '+1 (554) 723-52', '2025-05-03 08:34:56'),
(7, 'Destiny Salazar', '2008-11-04', 'Female', '+1 (785) 888-66', 'darejuh@mailinator.com', 'Rem quo velit et min', 'Nostrum pe', 'Pariatur Asperiores', 'Autem cumque cum aut', 'Duis repellendus Ve', 'A eligendi ex aliqui', 'Reprehenderit earum', 'Eaque provident nob', 'Cum corporis velit ', 'Evan Bird', 'Placeat ea quisquam', '+1 (178) 833-26', '2025-05-03 08:40:26'),
(8, 'Vince Omaque Yawa', '1994-10-20', 'Female', '+1 (809) 549-77', 'gecanucoli@mailinator.com', 'Fugiat ducimus eos ', 'Exercitati', 'Velit vel dolores au', 'Laudantium irure de', 'Ullamco ad reprehend', 'Neque sunt laudantiu', 'Pariatur Cumque lab', 'Qui sit nemo sunt v', 'Labore sed quo in de', 'Benjamin Kline', 'Quaerat enim illum ', '+1 (504) 244-73', '2025-05-03 10:32:29');

-- --------------------------------------------------------

--
-- Table structure for table `users_acc`
--

CREATE TABLE `users_acc` (
  `id` int(20) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `account` enum('admin','staff') NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_acc`
--

INSERT INTO `users_acc` (`id`, `username`, `password`, `account`, `created_at`) VALUES
(1, 'cedricjade13', 'gwapoko', 'admin', '0000-00-00 00:00:00.000000'),
(2, 'cedricjade13', 'gwapoko1', 'staff', '2025-03-10 14:18:53.000000'),
(3, 'cedricjade13', '$2y$10$87jn0p76Fdmd.lW6L7Ni3egfb7kmZQ4nNZgbl.hQiSmxzUkTLyx7C', 'admin', '2025-03-10 14:30:59.546677'),
(4, 'jade', '$2y$10$4vKTBw/QA0USfNNM07z1g.hFhxzGZqJwmE8vvjKFJj5W64iEBoiBu', 'staff', '2025-03-10 14:31:38.948976'),
(5, 'admin', '$2y$10$oI4Isu6heUdtOHkafpEa4OK6gk99BhdSY.ZvkKXkvZ4ls5KgaXudO', 'admin', '2025-05-03 05:28:44.989840'),
(6, 'staff', '$2y$10$pA3LXD3tjP1Ze9EVLjucv.z6Rpk/TT7aakTzw200hFa4LjwDyLOo.', 'staff', '2025-05-03 05:30:21.553415');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `medicines`
--
ALTER TABLE `medicines`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medicine_dispenses`
--
ALTER TABLE `medicine_dispenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `medicine_id` (`medicine_id`);

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
-- AUTO_INCREMENT for table `medicines`
--
ALTER TABLE `medicines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `medicine_dispenses`
--
ALTER TABLE `medicine_dispenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users_acc`
--
ALTER TABLE `users_acc`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `medicine_dispenses`
--
ALTER TABLE `medicine_dispenses`
  ADD CONSTRAINT `medicine_dispenses_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`),
  ADD CONSTRAINT `medicine_dispenses_ibfk_2` FOREIGN KEY (`medicine_id`) REFERENCES `medicines` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
