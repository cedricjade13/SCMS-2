-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 05, 2025 at 05:46 PM
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
(1, 'Fallon Knox', 'Reprehenderit optio', 54, '0000-00-00', 'Voluptatem Providen'),
(2, 'Biogesic', 'Nam proident non qu', 794, '0000-00-00', 'Reiciendis voluptate'),
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
(2, 8, 2, 64, '2025-05-03 10:32:47'),
(3, 56, 2, 1, '2025-05-05 14:34:12'),
(4, 56, 2, 1, '2025-05-05 14:34:18'),
(5, 56, 2, 1, '2025-05-05 14:34:23'),
(6, 23, 2, 1, '2025-05-05 14:44:48'),
(7, 23, 2, 2, '2025-05-05 14:44:53'),
(8, 23, 1, 3, '2025-05-05 14:45:03');

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `course` enum('BSIT','BSCRIM','BSBA','BSED','BEED','BSTM','BSHM') NOT NULL,
  `year_level` enum('1','2','3','4') NOT NULL,
  `section` enum('A','B','C','D','E','F','G') NOT NULL,
  `semester` enum('1st','2nd') NOT NULL,
  `academic_year` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `full_name`, `dob`, `gender`, `contact_number`, `email`, `address`, `blood_type`, `allergies`, `conditions`, `surgeries`, `medications`, `family_history`, `assigned_doctor`, `reason_for_visit`, `emergency_contact_name`, `relationship`, `emergency_contact_number`, `created_at`, `course`, `year_level`, `section`, `semester`, `academic_year`) VALUES
(1, 'Declan Walley', '2003-09-28', 'Male', '+1 (465) 843-19', 'kegomo@mailinator.com', 'Incididunt voluptate', 'Sunt conse', 'Ad mollit mollit ex ', 'Possimus cillum aut', 'Fuga Autem exceptur', 'Rerum dolor anim odi', 'In voluptatem Sunt', 'Voluptates commodo q', 'Fuga Facere in culp', 'Charles Carpenter', 'Quia aut atque sint ', '+1 (316) 913-17', '2025-05-03 08:31:26', 'BSIT', '1', 'A', '1st', ''),
(2, 'Kenyon Jimenez', '1971-12-30', 'Female', '+1 (424) 666-42', 'kohoqepu@mailinator.com', 'Porro expedita ut ad', 'Magna labo', 'Harum quis fugit ad', 'Voluptas et et odio ', 'Quam eligendi quam o', 'Aut explicabo Asper', 'Minima mollit laboru', 'Earum est excepturi ', 'Reprehenderit commo', 'Echo Kline', 'Nostrud tempor praes', '+1 (353) 522-31', '2025-03-10 15:33:20', 'BSIT', '1', 'A', '1st', ''),
(3, 'Lee Sherman', '1993-10-21', 'Other', '+1 (708) 892-52', 'mupepawigo@mailinator.com', 'Maxime provident mi', 'Doloribus ', 'Odit commodo non dol', 'Libero a numquam eaq', 'Sit ut labore illum', 'Explicabo Eiusmod u', 'Veniam quis eaque d', 'Debitis qui enim ess', 'Unde magnam voluptat', 'Jayme Reeves', 'Volupt atibus ipsum q', '+1 (798) 739-58', '2025-03-10 15:40:00', 'BSIT', '1', 'A', '1st', ''),
(4, 'Barry Hodges', '2023-11-24', 'Female', '+1 (931) 971-82', 'subij@mailinator.com', 'Aut eu consequatur t', 'Ipsum sint', 'Aut ut quo enim corp', 'Unde illo veritatis ', 'Aliquip commodi et a', 'Mollit esse in id n', 'Molestiae enim totam', 'Ex natus fugiat fug', 'Nihil culpa molestia', 'Mary Zamora', 'Voluptas animi adip', '+1 (903) 134-41', '2025-03-10 15:44:07', 'BSIT', '1', 'A', '1st', ''),
(6, 'Yawa Jangad', '2018-10-10', 'Female', '+1 (958) 948-67', 'huzy@mailinator.com', 'Aliquam sequi autem ', 'Non quibus', 'Explicabo Cupiditat', 'At esse aspernatur ', 'Porro accusamus quis', 'Aut dolor fugiat ev', 'Eum eius sequi disti', 'Est labore ab volup', 'Illum corrupti mol', 'Lev Mcbride', 'Laborum dolore aut q', '+1 (554) 723-52', '2025-05-03 08:34:56', 'BSIT', '1', 'A', '1st', ''),
(7, 'Destiny Salazar', '2008-11-04', 'Female', '+1 (785) 888-66', 'darejuh@mailinator.com', 'Rem quo velit et min', 'Nostrum pe', 'Pariatur Asperiores', 'Autem cumque cum aut', 'Duis repellendus Ve', 'A eligendi ex aliqui', 'Reprehenderit earum', 'Eaque provident nob', 'Cum corporis velit ', 'Evan Bird', 'Placeat ea quisquam', '+1 (178) 833-26', '2025-05-03 08:40:26', 'BSIT', '1', 'A', '1st', ''),
(8, 'Vince Omaque Yawa', '1994-10-20', 'Female', '+1 (809) 549-77', 'gecanucoli@mailinator.com', 'Fugiat ducimus eos ', 'Exercitati', 'Velit vel dolores au', 'Laudantium irure de', 'Ullamco ad reprehend', 'Neque sunt laudantiu', 'Pariatur Cumque lab', 'Qui sit nemo sunt v', 'Labore sed quo in de', 'Benjamin Kline', 'Quaerat enim illum ', '+1 (504) 244-73', '2025-05-03 10:32:29', 'BSIT', '1', 'A', '1st', ''),
(9, 'Jade Vince Jaynu', '1975-03-28', 'Male', '+1 (351) 955-45', 'pemedecupi@mailinator.com', 'Aliquid atque adipis', 'Excepteur ', 'Culpa numquam quae ', 'Nostrum distinctio ', 'Eaque duis qui et in', 'Aut minim iste molli', 'Unde molestiae aperi', 'Voluptatem doloremq', 'Unde quia placeat i', 'Geraldine Carson', 'Deserunt est animi ', '+1 (519) 437-74', '2025-05-05 11:52:30', 'BSIT', '3', 'C', '2nd', '2025-2026'),
(10, 'Julie Marquez', '1974-03-05', 'Other', '+1 (665) 334-31', 'towup@mailinator.com', 'In iure autem ea sus', 'Rerum amet', 'Nulla aut et sunt si', 'Et porro corporis vo', 'Est et tempora omnis', 'Dolorem blanditiis c', 'Et in consequatur au', 'Quasi eveniet modi ', 'Fugit quia dolor id', 'Orlando Walton', 'Quaerat voluptas nis', '+1 (749) 399-25', '2025-05-05 14:06:33', 'BSBA', '4', 'B', '2nd', '2028-2029'),
(11, 'Tobias Leblanc', '1970-06-26', 'Male', '+1 (754) 914-14', 'lijeromuz@mailinator.com', 'Veniam architecto d', 'Placeat qu', 'Soluta voluptas laud', 'Veniam minus dolor ', 'Cillum non quis nost', 'Illum ad obcaecati ', 'Rem sunt illo id u', 'Ducimus quo ut mini', 'Dolore atque minima ', 'Kelly Woodard', 'Non aliquam deserunt', '+1 (937) 168-84', '2025-05-05 14:06:59', 'BSIT', '1', 'B', '2nd', '2027-2028'),
(12, 'Ross Lamb', '2011-04-18', 'Male', '+1 (998) 582-62', 'qezeqaciz@mailinator.com', 'Sed eligendi dolor e', 'Enim neces', 'Nobis nisi consequat', 'Sit itaque voluptate', 'Et pariatur Eum fug', 'Duis culpa ea eius ', 'Officiis aut maiores', 'Iure asperiores odio', 'Occaecat amet dolor', 'Merritt Owen', 'Aliquip impedit qua', '+1 (232) 351-78', '2025-05-05 14:07:04', 'BSCRIM', '1', 'G', '1st', '2026-2027'),
(13, 'Merrill Mcgowan', '1995-11-11', 'Male', '+1 (193) 772-40', 'hujicus@mailinator.com', 'Recusandae Asperior', 'Aliqua Eos', 'Quia ut unde qui rep', 'Porro animi deserun', 'Laboris officia ipsu', 'Amet animi aperiam', 'Incidunt adipisicin', 'Occaecat quis sint ', 'Quisquam rerum sint', 'Raymond Mckinney', 'Dolore sed in iste v', '+1 (476) 866-34', '2025-05-05 14:07:08', 'BSCRIM', '3', 'A', '1st', '2026-2027'),
(14, 'Sonia Parker', '1984-10-20', 'Male', '+1 (822) 826-39', 'hyrumujat@mailinator.com', 'In sed incididunt ip', 'Vel except', 'Temporibus itaque au', 'Ipsa eos suscipit ', 'Esse blanditiis labo', 'Vitae magna distinct', 'Adipisicing accusant', 'Tempor voluptatem vo', 'Elit voluptate ipsa', 'Emery Wynn', 'Dolore quae qui nost', '+1 (367) 577-66', '2025-05-05 14:07:14', 'BSCRIM', '2', 'C', '1st', '2029-2030'),
(15, 'Abra Bowman', '1989-08-01', 'Other', '+1 (169) 766-95', 'ryvipukaku@mailinator.com', 'Minima eiusmod sed u', 'Velit quib', 'Mollit ad aliquid po', 'Voluptate eaque non ', 'Atque delectus volu', 'Et officia illo culp', 'Ratione asperiores e', 'Totam nisi numquam e', 'Enim ut suscipit con', 'Roth Leblanc', 'Suscipit ullam aut i', '+1 (599) 691-67', '2025-05-05 14:07:26', 'BSED', '2', 'E', '2nd', '2025-2026'),
(16, 'Igor Vaughan', '1985-09-30', 'Other', '+1 (129) 294-63', 'kabadymel@mailinator.com', 'Dignissimos voluptat', 'Inventore ', 'Itaque irure dolor d', 'Vel in voluptatem s', 'Occaecat repellendus', 'Sunt dolor molestia', 'Dolore aspernatur in', 'Ducimus nesciunt q', 'Animi libero veniam', 'Minerva Weber', 'Officia velit sunt s', '+1 (467) 575-19', '2025-05-05 14:07:32', 'BSCRIM', '2', 'B', '2nd', '2026-2027'),
(17, 'Ethan Campos', '1994-08-28', 'Male', '+1 (378) 892-21', 'vigod@mailinator.com', 'Voluptatibus est vo', 'Iure ipsum', 'Eaque voluptate veni', 'Adipisci eveniet au', 'Reiciendis natus est', 'Explicabo Fuga Fug', 'Omnis minim fuga Is', 'Mollit distinctio A', 'Eos eaque rem velit', 'Grant Kane', 'Recusandae Porro qu', '+1 (117) 946-91', '2025-05-05 14:07:36', 'BSIT', '1', 'A', '2nd', '2028-2029'),
(18, 'Nathaniel Tucker', '2021-11-20', 'Male', '+1 (943) 539-70', 'wirezano@mailinator.com', 'Reprehenderit aut a', 'Aut facili', 'Labore aut aute ipsa', 'Et aliqua Consequat', 'Vitae tempora modi v', 'Est et et porro vol', 'Est ullam quo cum iu', 'In recusandae Obcae', 'Cum ut quasi sit nis', 'Nathan Conrad', 'Fuga Autem voluptat', '+1 (986) 662-75', '2025-05-05 14:07:46', 'BSIT', '3', 'B', '1st', '2027-2028'),
(19, 'Ryder Chaney', '1979-01-16', 'Other', '+1 (146) 302-21', 'mike@mailinator.com', 'Consequatur est quo', 'Nihil exer', 'Molestiae omnis dolo', 'Consectetur magna e', 'Fugiat praesentium e', 'Beatae beatae et rer', 'Et nobis veniam lab', 'Molestiae sunt hic v', 'Incididunt quia quia', 'Tad Malone', 'Ipsum aliqua Offic', '+1 (738) 655-63', '2025-05-05 14:07:52', 'BSIT', '1', 'F', '2nd', '2029-2030'),
(20, 'Rose Manning', '2001-08-21', 'Other', '+1 (233) 776-16', 'rusowe@mailinator.com', 'Omnis numquam at sit', 'Est except', 'Eaque accusamus erro', 'Recusandae Proident', 'Veniam hic odit ven', 'Dolor pariatur Enim', 'Asperiores sint cons', 'Iusto nihil et do du', 'Facere enim elit id', 'Guy Slater', 'Omnis laborum qui oc', '+1 (452) 409-24', '2025-05-05 14:07:59', 'BSBA', '1', 'F', '2nd', '2026-2027'),
(21, 'Flavia Jarvis', '2006-05-08', 'Other', '+1 (782) 997-85', 'nozosaty@mailinator.com', 'Est recusandae Ad i', 'Sit fugiat', 'Exercitation officii', 'Cupiditate eius irur', 'Proident ad optio ', 'Qui sit necessitati', 'Obcaecati repellendu', 'Adipisicing veritati', 'Voluptatem ut veniam', 'Jessamine Cole', 'Quo vel repudiandae ', '+1 (642) 276-95', '2025-05-05 14:08:04', 'BSTM', '3', 'G', '2nd', '2027-2028'),
(22, 'Penelope Atkins', '2023-08-30', 'Other', '+1 (509) 466-47', 'benogej@mailinator.com', 'Aspernatur nihil at ', 'Veniam mol', 'Dolor asperiores par', 'Cupidatat deserunt e', 'Error voluptatibus e', 'Exercitationem quia ', 'Tenetur voluptas est', 'Cupidatat porro rati', 'Enim velit aute corr', 'Lenore Hodge', 'Mollitia aliquam com', '+1 (658) 166-18', '2025-05-05 14:08:09', 'BSTM', '3', 'B', '1st', '2026-2027'),
(23, 'Ali Hensley', '2010-01-24', 'Female', '+1 (836) 481-38', 'wisyf@mailinator.com', 'Eos hic totam possi', 'Atque cons', 'Alias consectetur c', 'Aperiam voluptatem n', 'Est laboriosam fugi', 'Eu sint et qui et n', 'Itaque doloribus sus', 'Odit ipsa consequat', 'Eu doloribus quo ips', 'Ivor Stewart', 'Magnam a qui alias c', '+1 (237) 474-69', '2025-05-05 14:08:15', 'BSHM', '4', 'G', '1st', '2027-2028'),
(24, 'Wynter Silva', '2014-02-28', 'Female', '+1 (638) 104-45', 'dyxafu@mailinator.com', 'Aliquam voluptatem ', 'Dolore ea ', 'Vitae aut asperiores', 'Dolor laboris volupt', 'Do voluptatem minim ', 'Ratione laudantium ', 'Magni incidunt ut q', 'Ut sequi architecto ', 'Esse ut optio quae', 'Prescott Summers', 'Adipisci illo pariat', '+1 (943) 425-45', '2025-05-05 14:08:20', 'BSHM', '3', 'B', '2nd', '2026-2027'),
(25, 'Rooney Acosta', '1975-07-15', 'Male', '+1 (872) 188-45', 'senywu@mailinator.com', 'Atque non libero mag', 'Sequi quid', 'Cumque error maiores', 'Magnam rerum quidem ', 'Animi tempora ratio', 'Et qui sit aut labo', 'Accusantium omnis ni', 'Autem itaque volupta', 'Eum ipsa ex magna c', 'Tiger Harris', 'Aliquip sunt est id', '+1 (604) 998-85', '2025-05-05 14:08:26', 'BSTM', '1', 'C', '2nd', '2027-2028'),
(26, 'Tanya Gilmore', '2006-07-01', 'Female', '+1 (285) 783-91', 'ziveryf@mailinator.com', 'Esse ea itaque dolo', 'Debitis as', 'Magni vel exercitati', 'Qui ipsum quia volup', 'Cillum esse sit dist', 'Omnis voluptas esse ', 'Aut at tenetur commo', 'Aliquip ratione obca', 'Iusto sint aut nisi ', 'Winifred Snow', 'Porro ipsam dolorem ', '+1 (723) 389-67', '2025-05-05 14:08:59', 'BEED', '3', 'A', '2nd', '2026-2027'),
(27, 'Shay Buck', '2008-12-27', 'Other', '+1 (995) 599-87', 'zeqasy@mailinator.com', 'In at mollit porro l', 'Error rem ', 'Repudiandae cupidita', 'Iure sapiente eos et', 'Libero aute vitae om', 'Repudiandae eius aut', 'Cum est incidunt s', 'Consectetur numquam', 'Et in iusto aut aut ', 'Judah Stafford', 'Voluptas ea perferen', '+1 (287) 357-63', '2025-05-05 14:09:04', 'BSIT', '4', 'G', '1st', '2028-2029'),
(28, 'Acton Mcfarland', '2017-11-19', 'Other', '+1 (149) 179-20', 'sefybyso@mailinator.com', 'Consectetur accusant', 'Enim tempo', 'Quis duis odit totam', 'Dolor error ex harum', 'Aliquam aliquam ex e', 'Sapiente laboris con', 'Ea anim vitae volupt', 'Ad est aut fugit n', 'Nemo velit id eu ab', 'Drew Kerr', 'Quis vel consequatur', '+1 (604) 169-83', '2025-05-05 14:09:10', 'BSED', '3', 'B', '1st', '2028-2029'),
(29, 'Ralph Collins', '2025-05-02', 'Female', '+1 (256) 485-22', 'mava@mailinator.com', 'Non porro dicta in a', 'Enim dolor', 'Ipsa ipsa sint har', 'Et id dolor corrupti', 'Adipisicing ullam au', 'Ex culpa consectetu', 'Rerum dolor in offic', 'Quia velit expedita ', 'Accusamus illo aute ', 'Aretha Pena', 'Voluptatem Expedita', '+1 (814) 753-70', '2025-05-05 14:09:14', 'BSED', '1', 'F', '1st', '2026-2027'),
(30, 'Candace Black', '1973-03-07', 'Other', '+1 (887) 559-53', 'metogex@mailinator.com', 'Ut illo provident u', 'In et volu', 'Voluptatem Enim sun', 'Nisi eu reprehenderi', 'Temporibus aute qui ', 'Eos sit veniam quis', 'Asperiores dolorem i', 'Voluptate autem id v', 'Qui veritatis sunt d', 'Lewis Stevens', 'Eligendi quo et non ', '+1 (477) 196-57', '2025-05-05 14:09:20', 'BSHM', '1', 'E', '1st', '2028-2029'),
(31, 'Mollie Tanner', '1986-10-01', 'Male', '+1 (374) 864-11', 'lyzabucona@mailinator.com', 'Non nisi iure est ad', 'Ea vero od', 'Cupidatat beatae mol', 'Aut labore dolore cu', 'Maiores maxime iste ', 'Laborum Dicta quam ', 'Irure rerum adipisic', 'Nesciunt quia paria', 'Ipsum fugiat ab con', 'Yeo Floyd', 'Laborum qui perspici', '+1 (443) 801-64', '2025-05-05 14:09:25', 'BSHM', '3', 'C', '2nd', '2026-2027'),
(32, 'Curran Sloan', '2009-10-17', 'Other', '+1 (777) 111-61', 'fihonopypy@mailinator.com', 'Molestiae voluptates', 'Sint exerc', 'Inventore perspiciat', 'Eos veniam accusant', 'Reprehenderit ipsa ', 'Possimus duis et si', 'Ea ea repudiandae ul', 'Laborum cillum dolor', 'Minima magnam qui la', 'Kasimir Acevedo', 'Ut quidem anim sunt ', '+1 (554) 814-42', '2025-05-05 14:10:03', 'BSIT', '3', 'F', '1st', '2026-2027'),
(33, 'Travis Shaw', '1985-08-18', 'Female', '+1 (259) 242-17', 'qalepyro@mailinator.com', 'Incididunt ut autem ', 'Eveniet vo', 'Qui commodo ut tempo', 'Voluptatem sit exerc', 'Sapiente ut cumque n', 'Deserunt nulla in es', 'Esse voluptatibus v', 'Quas fugiat officia', 'Officia amet illum', 'Raja Faulkner', 'Repellendus Volupta', '+1 (926) 615-54', '2025-05-05 14:10:08', 'BSTM', '2', 'E', '2nd', '2028-2029'),
(34, 'Garrison Combs', '1972-02-25', 'Other', '+1 (639) 438-26', 'vofa@mailinator.com', 'Ea dicta debitis min', 'Expedita a', 'Ab velit iure expedi', 'Numquam dolorem magn', 'Tempore nihil et qu', 'Voluptatibus cupidit', 'Non ut non aut enim', 'Officia rem consequa', 'Dolores sed porro es', 'Hannah Hurley', 'Dolorem omnis ipsam ', '+1 (219) 886-60', '2025-05-05 14:10:12', 'BSTM', '2', 'E', '2nd', '2029-2030'),
(35, 'Dora Browning', '1977-08-15', 'Female', '+1 (296) 874-20', 'miracypaz@mailinator.com', 'Voluptas est obcaeca', 'Quo labori', 'Corporis aut cumque ', 'Nam ullamco commodo ', 'Tenetur amet error ', 'Deserunt non sunt e', 'Eum quis ratione vel', 'Ad et aut ad invento', 'Id maiores aliqua I', 'Jescie Humphrey', 'Earum praesentium fa', '+1 (206) 637-35', '2025-05-05 14:10:17', 'BSCRIM', '3', 'D', '2nd', '2029-2030'),
(36, 'Hilel Gamble', '1990-06-26', 'Male', '+1 (516) 789-41', 'vimunon@mailinator.com', 'Mollitia sint qui es', 'In eligend', 'Dolores dolorem iure', 'Voluptas aperiam nob', 'Corrupti modi commo', 'Nulla eligendi sit ', 'Consequat Iusto qui', 'Id laboriosam proid', 'Amet assumenda arch', 'Drake Burns', 'Quo eum error dolor ', '+1 (713) 729-76', '2025-05-05 14:10:22', 'BSTM', '3', 'G', '1st', '2029-2030'),
(37, 'Emma Harvey', '2017-12-02', 'Female', '+1 (544) 306-22', 'daqaji@mailinator.com', 'Aut molestiae laudan', 'Dolor debi', 'Ex error ut sint aut', 'Do deleniti omnis ut', 'Exercitation proiden', 'Aliquam vitae nostru', 'Quis ut quasi perspi', 'Et proident aliquid', 'Maiores dolor reicie', 'Melodie Lewis', 'Repudiandae obcaecat', '+1 (864) 949-19', '2025-05-05 14:10:27', 'BSED', '4', 'C', '2nd', '2029-2030'),
(38, 'Mara Hill', '2002-04-03', 'Other', '+1 (675) 821-83', 'lozin@mailinator.com', 'Ea sed atque eligend', 'Odit sit n', 'Omnis assumenda dolo', 'Ipsa unde inventore', 'Vero possimus elige', 'Temporibus doloremqu', 'Possimus incididunt', 'Molestiae alias eum ', 'Ea minim voluptas nu', 'Avye Berger', 'Vel dolore mollit re', '+1 (411) 943-20', '2025-05-05 14:10:32', 'BSCRIM', '3', 'A', '2nd', '2025-2026'),
(39, 'Gareth Mayo', '2018-04-18', 'Other', '+1 (692) 701-52', 'xykarobu@mailinator.com', 'Veniam non distinct', 'Nisi maxim', 'Sunt aut qui ut aper', 'Dolor ea neque iste ', 'Placeat est blandi', 'Dicta culpa ut nequ', 'Est aliqua Est proi', 'Quis et voluptatem ', 'Qui dolores et velit', 'Ashton Cox', 'Sit quibusdam incidi', '+1 (284) 376-94', '2025-05-05 14:10:46', 'BSIT', '1', 'E', '1st', '2025-2026'),
(40, 'Maggie Tate', '1991-03-05', 'Female', '+1 (709) 762-72', 'kynuc@mailinator.com', 'Et voluptate volupta', 'Adipisicin', 'Commodo sunt deserun', 'Sit voluptas autem e', 'Nulla ut molestias e', 'Laboriosam laboris ', 'Sunt nobis aut qui d', 'Sit neque sunt esse', 'Ex officia enim fugi', 'Casey Kerr', 'Quibusdam vitae fuga', '+1 (599) 933-82', '2025-05-05 14:10:52', 'BSBA', '4', 'G', '2nd', '2027-2028'),
(41, 'Norman Pearson', '2007-05-30', 'Male', '+1 (228) 712-26', 'xyweheko@mailinator.com', 'Dolore id voluptas i', 'Velit dolo', 'Sequi rerum id dele', 'Reiciendis enim faci', 'Cum veritatis hic te', 'Nemo accusamus enim ', 'Provident vel nemo ', 'Deserunt veritatis i', 'Ea qui atque distinc', 'Talon Barnett', 'Aut corrupti veniam', '+1 (644) 693-91', '2025-05-05 14:10:56', 'BSCRIM', '2', 'B', '1st', '2025-2026'),
(42, 'Sydnee Schmidt', '2011-08-08', 'Female', '+1 (859) 927-36', 'jofydym@mailinator.com', 'Quisquam qui sit ill', 'Cumque ver', 'Enim laborum Conseq', 'Voluptates nostrum e', 'Officiis qui veritat', 'Qui eos consequatur', 'Maxime doloribus occ', 'Mollitia ut aliquam ', 'Nihil blanditiis dol', 'Natalie Cote', 'Libero impedit maio', '+1 (197) 263-34', '2025-05-05 14:11:03', 'BSIT', '1', 'D', '1st', '2025-2026'),
(43, 'Melissa Gilliam', '2005-07-06', 'Female', '+1 (133) 737-87', 'rygygimu@mailinator.com', 'Provident praesenti', 'Velit ea m', 'Mollit eu laboriosam', 'Nesciunt nisi ut qu', 'Est omnis et numquam', 'Pariatur Consequatu', 'Et culpa vitae corru', 'A ea consequatur id', 'Tempore consectetur', 'Salvador Hahn', 'Recusandae Providen', '+1 (616) 931-81', '2025-05-05 14:11:09', 'BSCRIM', '1', 'G', '1st', '2028-2029'),
(44, 'Callie Delgado', '2000-11-23', 'Male', '+1 (974) 671-31', 'zuzywytu@mailinator.com', 'Dignissimos et quaer', 'Nobis magn', 'Fugiat placeat aliq', 'Molestias animi qui', 'Magnam maxime sunt f', 'Omnis mollit eos sit', 'Veritatis voluptatem', 'Sequi eos illum se', 'Sit cupidatat deseru', 'Susan David', 'Rerum dolor ut aut a', '+1 (469) 238-91', '2025-05-05 14:11:15', 'BEED', '1', 'G', '1st', '2028-2029'),
(45, 'Janna Kane', '2007-02-23', 'Other', '+1 (453) 566-57', 'vecojujasy@mailinator.com', 'Aut architecto venia', 'Alias aut ', 'Nulla do et quo non ', 'Et velit et odio mo', 'Qui praesentium amet', 'Omnis accusantium se', 'Minima cillum culpa', 'Iste dolorum volupta', 'Recusandae Molestia', 'Hayfa Benson', 'Nihil laboris volupt', '+1 (547) 476-26', '2025-05-05 14:11:21', 'BSED', '3', 'D', '2nd', '2025-2026'),
(46, 'Ezra Charles', '2011-02-22', 'Female', '+1 (471) 385-83', 'tuqygilo@mailinator.com', 'Error doloremque eos', 'Est explic', 'Ea et voluptatem Qu', 'Aut voluptatum quide', 'Asperiores quibusdam', 'Incidunt debitis nu', 'Eum adipisicing cons', 'Veniam eligendi et ', 'Iste laudantium vol', 'Serina Hardy', 'Et praesentium tempo', '+1 (182) 306-36', '2025-05-05 14:11:25', 'BSED', '2', 'A', '1st', '2028-2029'),
(47, 'Kevyn Mooney', '2002-06-04', 'Male', '+1 (518) 542-15', 'daryhetej@mailinator.com', 'Maxime sit aliqua E', 'Qui vitae ', 'Quia corrupti fugia', 'Lorem quod ut hic ne', 'Modi cupiditate erro', 'Eu voluptatem quide', 'Esse autem irure exp', 'Dolor provident lor', 'Consequatur consequ', 'Basil Marshall', 'Laborum Quia id a n', '+1 (436) 704-31', '2025-05-05 14:11:29', 'BSCRIM', '1', 'G', '2nd', '2029-2030'),
(48, 'Flavia Wall', '2020-03-16', 'Other', '+1 (308) 457-80', 'sopaba@mailinator.com', 'Blanditiis amet nul', 'Ab est eos', 'Libero et qui vel ut', 'Quis rerum soluta du', 'Minus eius voluptati', 'Neque ea fuga In su', 'Duis rerum excepteur', 'Amet aspernatur con', 'Irure deserunt elige', 'Eliana Flores', 'Vel reiciendis lorem', '+1 (338) 852-90', '2025-05-05 14:11:35', 'BSCRIM', '1', 'G', '2nd', '2026-2027'),
(49, 'Alec Mccormick', '2002-09-26', 'Male', '+1 (846) 542-96', 'dynaze@mailinator.com', 'Voluptatem sapiente ', 'Quia obcae', 'Excepturi neque enim', 'Quis iusto maiores c', 'Labore sed ullamco t', 'Veniam irure dolore', 'Deleniti aut consequ', 'Quis quia rerum qui ', 'Proident reiciendis', 'Herman Santiago', 'Nam voluptate cum qu', '+1 (101) 708-30', '2025-05-05 14:11:40', 'BSBA', '2', 'E', '2nd', '2027-2028'),
(50, 'Megan Knowles', '1973-08-15', 'Female', '+1 (596) 218-41', 'puxaw@mailinator.com', 'Nostrum perspiciatis', 'Soluta qui', 'Minim perferendis in', 'Vitae ut qui et dolo', 'Doloribus distinctio', 'Do necessitatibus mi', 'Et nemo neque maiore', 'Sint voluptas facil', 'Est ullam aliquip ei', 'Chase Bender', 'Voluptate voluptatem', '+1 (307) 644-91', '2025-05-05 14:11:58', 'BSED', '1', 'F', '2nd', '2025-2026'),
(51, 'Adria Wong', '1986-04-16', 'Female', '+1 (163) 937-47', 'conapynep@mailinator.com', 'Aut enim dignissimos', 'Aut evenie', 'Debitis quas nihil l', 'Dicta dolorum vitae ', 'Voluptas dolor eos ', 'Fugiat et dicta nece', 'Ex accusamus necessi', 'Quia quis voluptate ', 'Tenetur dolore ut Na', 'Naida Buckner', 'Vero qui minim simil', '+1 (218) 136-51', '2025-05-05 14:12:03', 'BSHM', '1', 'G', '2nd', '2028-2029'),
(52, 'Brynne Fox', '2003-10-07', 'Male', '+1 (217) 129-39', 'gaxutyveg@mailinator.com', 'Dolore amet qui qui', 'Ea nesciun', 'Doloremque ea quia d', 'Velit consequat Exe', 'Adipisci neque cupid', 'Repudiandae esse ex', 'Aute praesentium ess', 'Sed quis labore eius', 'Ullam ducimus ab re', 'Mercedes Tate', 'Incidunt aut qui es', '+1 (508) 537-98', '2025-05-05 14:12:07', 'BSCRIM', '3', 'F', '2nd', '2028-2029'),
(53, 'Channing Figueroa', '1979-08-12', 'Female', '+1 (606) 636-65', 'sedyhaw@mailinator.com', 'Voluptatem culpa mi', 'Do perfere', 'Officia sed nihil qu', 'Earum molestiae reru', 'Aliqua Voluptatem s', 'Modi dolor nisi est', 'Voluptas et asperior', 'Ipsum hic et libero', 'Alias molestiae non ', 'Grady Irwin', 'Officia omnis ut quo', '+1 (992) 549-10', '2025-05-05 14:12:12', 'BSHM', '1', 'A', '2nd', '2025-2026'),
(54, 'Irene Vang', '1984-11-16', 'Other', '+1 (671) 181-44', 'pogejoxasu@mailinator.com', 'Ut iure porro velit ', 'Nostrum om', 'Fugiat inventore dol', 'Nam culpa quo sapien', 'Et vel ea esse repre', 'Tenetur ipsa labori', 'Minima eos consequu', 'Occaecat eveniet ni', 'Maxime consequatur n', 'Anne Pitts', 'Consequat Beatae es', '+1 (416) 406-87', '2025-05-05 14:12:16', 'BSTM', '1', 'A', '2nd', '2028-2029'),
(55, 'Amena Wood', '1981-11-06', 'Female', '+1 (796) 371-23', 'bidiv@mailinator.com', 'Rem ut dolores qui v', 'Quis imped', 'Debitis voluptatem c', 'Ullam assumenda qui ', 'Aut delectus in sus', 'Asperiores neque id', 'Dolorem quia iusto v', 'Lorem est a voluptat', 'Consequat Officia s', 'Darrel Snider', 'Eos labore asperior', '+1 (601) 853-29', '2025-05-05 14:12:20', 'BSCRIM', '3', 'B', '2nd', '2027-2028'),
(56, 'Abel Norman', '2017-09-05', 'Female', '+1 (493) 486-58', 'dumup@mailinator.com', 'Harum nisi quia in a', 'Qui iste e', 'Ullamco ut doloribus', 'Cupiditate facilis e', 'Dolor dicta do iusto', 'Natus minus natus mi', 'Dolore ullamco at et', 'Et iste elit nisi i', 'Voluptatum velit ali', 'Audra Hoffman', 'Quas ut culpa iure i', '+1 (776) 428-70', '2025-05-05 14:12:24', 'BSTM', '1', 'A', '1st', '2029-2030'),
(57, 'Aretha Sargent', '2014-03-12', 'Male', '+1 (712) 469-17', 'wydup@mailinator.com', 'Dolores dolorem dese', 'Dolore eni', 'Numquam maiores hic ', 'Qui culpa at qui re', 'Sunt et eos quo qua', 'Autem enim rerum qui', 'Laudantium dolore u', 'Dolorem sit sed rec', 'Quis est aut commodo', 'Brock Johns', 'Reprehenderit error ', '+1 (329) 609-24', '2025-05-05 14:12:32', 'BEED', '1', 'G', '2nd', '2029-2030'),
(58, 'Jaynu', '1996-12-04', 'Female', '+1 (932) 532-30', 'xaby@mailinator.com', 'Aut et ipsum est lab', 'Ut at volu', 'Ipsum error volupta', 'Maiores facere aliqu', 'Quis ut adipisicing ', 'Adipisci et unde dic', 'Cum voluptatum vitae', 'Neque qui tempora id', 'Non blanditiis ea ev', 'Imelda Conner', 'Tempor vel accusamus', '+1 (903) 594-67', '2025-05-05 14:28:04', 'BSBA', '3', 'G', '1st', '2027-2028'),
(59, 'Jaynu', '2000-02-08', 'Female', '+1 (641) 673-73', 'qitywurygi@mailinator.com', 'Ullam omnis soluta b', 'Ut enim ve', 'Qui non quasi volupt', 'Quis autem ut atque ', 'Quibusdam velit con', 'Error a nostrum quo ', 'Molestiae itaque nis', 'Cum reprehenderit a', 'Eos doloremque fuga', 'Abel Mckay', 'Laboris est dolorum', '+1 (806) 233-61', '2025-05-05 14:28:13', 'BSCRIM', '1', 'A', '2nd', '2029-2030'),
(60, 'Jaynu', '1981-06-25', 'Male', '+1 (961) 965-42', 'henapijomu@mailinator.com', 'Animi beatae alias ', 'Nihil in q', 'Cum tempora labore d', 'Odit saepe praesenti', 'Quo ex quis velit e', 'Vero quo aut vitae o', 'Corrupti do ea temp', 'Quasi ex totam conse', 'Debitis aliqua Dolo', 'Mannix Green', 'Dolores dicta fuga ', '+1 (631) 874-98', '2025-05-05 14:28:21', 'BSTM', '4', 'F', '1st', '2025-2026'),
(61, 'Jaynu', '2014-05-17', 'Female', '+1 (692) 853-99', 'luwomyvep@mailinator.com', 'Nihil enim ut aut fu', 'Provident ', 'Repellendus Minus e', 'Dignissimos neque au', 'Magna aperiam adipis', 'Id earum exercitatio', 'Et voluptatibus cupi', 'Enim aut consequatur', 'Recusandae Quaerat ', 'Ignatius Lloyd', 'Pariatur Dolor numq', '+1 (742) 853-79', '2025-05-05 14:28:28', 'BSHM', '2', 'B', '1st', '2025-2026'),
(62, 'asd', '2025-05-05', 'Female', '123', 'asd@gmail.com', 'asd', 'asd', 'asd', 'asd', 'asd', 'asd', 'asd', 'asd', 'asd', 'asd', 'asd', '123', '2025-05-05 14:29:54', 'BSIT', '3', 'C', '2nd', '2025-2026'),
(63, 'asd', '2025-05-05', 'Male', '123', 'asd@gmail.com', 'asd', 'asd', 'asd', 'asd', 'asd', 'asd', 'asd', 'asd', 'asd', 'asd', 'asd', '123', '2025-05-05 14:31:23', 'BSIT', '3', 'C', '2nd', '2025-2026'),
(64, 'asd', '2025-05-05', 'Male', '123', 'asd@gmail.com', 'asd', 'asd', 'asd', 'asd', 'asd', 'asd', 'asd', 'asd', 'asd', 'asd', 'asd', '123', '2025-05-05 14:32:41', 'BSIT', '3', 'C', '2nd', '2025-2026');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

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
