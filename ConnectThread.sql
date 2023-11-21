-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 20, 2023 at 06:08 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `connectthread`
--

-- --------------------------------------------------------

--
-- Table structure for table `app_config`
--

CREATE TABLE `app_config` (
    `key` varchar(15) NOT NULL,
    `value` tinyint(1) DEFAULT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `app_config`
--

INSERT INTO `app_config` (`key`, `value`, `created_at`) VALUES
    ('initialized', 1, '2019-04-30 07:13:37');

-- --------------------------------------------------------

--
-- Table structure for table `communications`
--

CREATE TABLE `communications` (
                                  `id` int(11) NOT NULL,
                                  `sender_id` int(10) UNSIGNED NOT NULL,
                                  `recipient_id` int(10) UNSIGNED NOT NULL,
                                  `title` varchar(64) NOT NULL,
                                  `message` text NOT NULL,
                                  `send_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `communications`
--

INSERT INTO `communications` (`id`, `sender_id`, `recipient_id`, `title`, `message`, `send_at`) VALUES
(2, 1, 1, 'Important Request', 'Dear admin,\r\nwe need backup now!\r\nA virus is attacking and we are low on supply! SOS!', '2019-05-03 06:02:33'),
(3, 1, 4, 'Score Recap Request', 'Dude, please send me score recap from last night. Need it for the boss. Thanks!', '2019-05-03 06:13:10'),
(4, 2, 3, 'superbum', '123123', '2019-08-02 05:22:25'),
(5, 2, 2, 'qweqwe', 'dasdadasd', '2019-08-02 05:23:36');

-- --------------------------------------------------------

--
-- Table structure for table `thread`
--

CREATE TABLE `thread` (
                          `thread_id` int(11) NOT NULL,
                          `title` varchar(255) NOT NULL,
                          `content` longtext NOT NULL,
                          `user_id` int(11) NOT NULL,
                          `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                          `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `thread`
--

INSERT INTO `thread` (`thread_id`, `title`, `content`, `user_id`, `created_at`, `deleted_at`) VALUES
                    (1, 'EZ EZ EDIT', 'asdasdjksahdjkas', 6, '2023-11-20 16:49:46', NULL),
                    (2, 'EDITT', 'HALOO NAMA SAYA ASEP', 6, '2023-11-20 16:50:15', NULL),
                    (3, 'ini yang buat asep', 'sepp sep codl play', 7, '2023-11-20 16:09:23', NULL),
                    (4, 'TIDE', 'TIDE', 6, '2023-11-20 17:00:49', '2023-11-20 17:00:49'),
                    (5, 'ITED', 'ITED', 6, '2023-11-20 17:01:42', '2023-11-20 17:01:42');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
                         `id` int(10) UNSIGNED NOT NULL,
                         `fullname` varchar(255) NOT NULL,
                         `username` varchar(255) NOT NULL,
                         `email` varchar(255) NOT NULL,
                         `role` varchar(16) NOT NULL,
                         `password` varchar(100) NOT NULL,
                         `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
                         `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                         `attempt` int(11) NOT NULL DEFAULT 0,
                         `last_login_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `username`, `email`, `role`, `password`, `created_at`, `updated_at`, `attempt`, `last_login_time`) VALUES
                    (1, 'dummy1', 'dummy1', 'dummy1@dummy.com', 'user', 'dummy1dummy1', '2019-04-30 07:13:37', '2019-08-02 04:49:24', 0, NULL),
                    (2, 'dummy2', 'dummy2', 'dummy2@dummy.com', 'user', 'dummy2dummy2', '2019-04-30 07:13:37', '2019-08-02 04:49:24', 0, NULL),
                    (3, 'dummy3', 'dummy3', 'dummy3@dummy.com', 'user', 'dummy3dummy3', '2019-04-30 07:13:37', '2019-08-02 04:49:25', 0, NULL),
                    (5, 'admin', 'admin', 'admin@gmail.com', 'admin', 'supers3cretp4sswordOyeah123', '2019-04-30 07:13:37', '2019-08-02 04:49:25', 0, NULL),
                    (6, '', 'username', 'emailnyasijeremy@as.so', '', '$2y$10$ICtnz47XlQeV/a2qbemPSuXa8jCSXr9KpBpbgA9Wkyklc3Oiuk4KK', '2023-11-20 07:48:49', '2023-11-20 16:58:03', 0, '2023-11-20 16:58:03'),
                    (7, '', 'asep', 'asep@gmail.com', '', '$2y$10$LuXkRahBgRpb7EjqEATZ2um8P1Buh0k08vROCOjst8Fu3p1emx8dq', '2023-11-20 14:51:12', '2023-11-20 16:02:37', 0, '2023-11-20 16:02:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `app_config`
--
ALTER TABLE `app_config`
    ADD PRIMARY KEY (`key`);

--
-- Indexes for table `communications`
--
ALTER TABLE `communications`
    ADD PRIMARY KEY (`id`),
    ADD KEY `foreign_constraint_recipient` (`recipient_id`),
    ADD KEY `foreign_constraint_sender` (`sender_id`);

--
-- Indexes for table `thread`
--
ALTER TABLE `thread`
    ADD PRIMARY KEY (`thread_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
    ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `communications`
--
ALTER TABLE `communications`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `thread`
--
ALTER TABLE `thread`
    MODIFY `thread_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
    MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `communications`
--
ALTER TABLE `communications`
    ADD CONSTRAINT `foreign_constraint_sender` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
