-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2025 at 04:54 PM
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
-- Database: `multi_user`
--

-- --------------------------------------------------------

--
-- Table structure for table `class_schedule`
--

CREATE TABLE `class_schedule` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `time_slot` varchar(20) NOT NULL,
  `monday` varchar(50) DEFAULT NULL,
  `tuesday` varchar(50) DEFAULT NULL,
  `wednesday` varchar(50) DEFAULT NULL,
  `thursday` varchar(50) DEFAULT NULL,
  `friday` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `class_schedule`
--

INSERT INTO `class_schedule` (`id`, `user_id`, `time_slot`, `monday`, `tuesday`, `wednesday`, `thursday`, `friday`) VALUES
(5, 5, '13:00-14:00', 'SIM', 'PW', 'SIMBAD', 'Komunikasi Data', 'PBO II');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id_events` int(11) NOT NULL,
  `event_date` date DEFAULT NULL,
  `note` text NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `media_upload`
--

CREATE TABLE `media_upload` (
  `id_media` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `filepath` varchar(255) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `media_upload`
--

INSERT INTO `media_upload` (`id_media`, `id_user`, `filename`, `filepath`, `uploaded_at`) VALUES
(1, 5, 'background.jpg', 'uploads/1764605101_4413_background.jpg', '2025-12-01 16:05:01');

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `id_note` int(255) NOT NULL,
  `id` int(11) DEFAULT NULL,
  `note` text NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp(),
  `updated at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`id_note`, `id`, `note`, `created_at`, `updated at`) VALUES
(0, 5, 'hai gais', '2025-11-25', '2025-11-29 19:23:40');

-- --------------------------------------------------------

--
-- Table structure for table `project_manager`
--

CREATE TABLE `project_manager` (
  `id` int(255) DEFAULT NULL,
  `id_project` int(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` enum('In Progress','Completed') DEFAULT NULL,
  `deadline` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project_manager`
--

INSERT INTO `project_manager` (`id`, `id_project`, `name`, `status`, `deadline`) VALUES
(5, 9, 'game ular tangga', 'Completed', '2025-12-01 17:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `studyplanner`
--

CREATE TABLE `studyplanner` (
  `id_studyplanner` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `time_range` varchar(50) NOT NULL,
  `activity` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `studyplanner`
--

INSERT INTO `studyplanner` (`id_studyplanner`, `id_user`, `time_range`, `activity`) VALUES
(3, 5, '06:00-07:00', 'bangun'),
(4, 5, '07:00-08:00', 'sarapan');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id_tasks` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `task_text` varchar(255) NOT NULL,
  `is_done` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `todo`
--

CREATE TABLE `todo` (
  `id_todo` int(11) NOT NULL,
  `id` int(11) DEFAULT NULL,
  `isi_todo` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `todo`
--

INSERT INTO `todo` (`id_todo`, `id`, `isi_todo`, `status`) VALUES
(3, 5, 'persiapan uas', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tugas`
--

CREATE TABLE `tugas` (
  `id_tugas` int(11) NOT NULL,
  `id` int(255) NOT NULL,
  `mapel` varchar(100) NOT NULL,
  `detail` text NOT NULL,
  `deadline` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `level` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama`, `email`, `username`, `password`, `level`) VALUES
(5, 'sopi', 'ashofy20@gmail.com', NULL, '$2y$10$EiIrQgQN8wvC9y6sMrKyN.T3jyVaS6WpKY6kkqOaH5ixYlL03XCOG', 'user'),
(8, 'admin sopi', 'shofyaulia@students.polmed.ac.id', NULL, '$2y$10$NAHD681dFkniRf0xPVPzf.pgwFPS0Ykhy5MvJIFBZSJ8bR4hzINSq', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `class_schedule`
--
ALTER TABLE `class_schedule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id_events`),
  ADD KEY `fk_events_user` (`id_user`);

--
-- Indexes for table `media_upload`
--
ALTER TABLE `media_upload`
  ADD PRIMARY KEY (`id_media`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id_note`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `project_manager`
--
ALTER TABLE `project_manager`
  ADD PRIMARY KEY (`id_project`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `studyplanner`
--
ALTER TABLE `studyplanner`
  ADD PRIMARY KEY (`id_studyplanner`),
  ADD KEY `id` (`id_user`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id_tasks`),
  ADD KEY `user_id` (`id`);

--
-- Indexes for table `todo`
--
ALTER TABLE `todo`
  ADD PRIMARY KEY (`id_todo`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `tugas`
--
ALTER TABLE `tugas`
  ADD PRIMARY KEY (`id_tugas`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `class_schedule`
--
ALTER TABLE `class_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id_events` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `media_upload`
--
ALTER TABLE `media_upload`
  MODIFY `id_media` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `id_note` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `project_manager`
--
ALTER TABLE `project_manager`
  MODIFY `id_project` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `studyplanner`
--
ALTER TABLE `studyplanner`
  MODIFY `id_studyplanner` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id_tasks` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `todo`
--
ALTER TABLE `todo`
  MODIFY `id_todo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tugas`
--
ALTER TABLE `tugas`
  MODIFY `id_tugas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `fk_events_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `media_upload`
--
ALTER TABLE `media_upload`
  ADD CONSTRAINT `media_upload_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `project_manager`
--
ALTER TABLE `project_manager`
  ADD CONSTRAINT `fk_projectmanager_user` FOREIGN KEY (`id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_user_project` FOREIGN KEY (`id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `project_manager_ibfk_1` FOREIGN KEY (`id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `studyplanner`
--
ALTER TABLE `studyplanner`
  ADD CONSTRAINT `studyplanner_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `todo`
--
ALTER TABLE `todo`
  ADD CONSTRAINT `todo_ibfk_1` FOREIGN KEY (`id`) REFERENCES `user` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
