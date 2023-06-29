-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 29, 2023 at 07:16 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bank`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `accounts_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `mode` enum('Withdraw','Deposit') NOT NULL,
  `amount` int(11) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`accounts_id`, `user_id`, `mode`, `amount`, `created_on`) VALUES
(1, 1, 'Deposit', 500, '2023-06-28 17:44:44'),
(2, 1, 'Deposit', 400, '2023-06-28 17:44:50'),
(3, 1, 'Withdraw', 400, '2023-06-28 17:44:59'),
(4, 4, 'Deposit', 100, '2023-06-28 18:40:47');

-- --------------------------------------------------------

--
-- Table structure for table `total_amt`
--

CREATE TABLE `total_amt` (
  `amt_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `total_amt` int(11) NOT NULL,
  `created_on` timestamp NULL DEFAULT NULL,
  `updated_on` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `total_amt`
--

INSERT INTO `total_amt` (`amt_id`, `user_id`, `total_amt`, `created_on`, `updated_on`) VALUES
(1, 1, 500, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 4, 100, '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(12) NOT NULL,
  `usertype` enum('customer','banker') NOT NULL,
  `access_token` varchar(40) DEFAULT NULL,
  `created_on` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `username`, `password`, `email`, `mobile`, `usertype`, `access_token`, `created_on`) VALUES
(1, 'Ketan Vyas', 'ketan23', '25d55ad283aa400af464c76d713c07ad', 'ketanv23@gmail.com', '7895645895', 'customer', 'NsbW44qk6eJIYNQFVUxXmyU8yMXC8KMEOpfU', '2023-06-28 10:30:11'),
(2, 'Teju B', 'tejub23', '25d55ad283aa400af464c76d713c07ad', 'tejub@gmail.com', '7845895685', 'banker', NULL, '2023-06-28 17:46:40'),
(4, 'Vandana P', 'vandu12', '25d55ad283aa400af464c76d713c07ad', 'vandu2@gmail.com', '7456325412', 'customer', NULL, '2023-06-28 10:30:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`accounts_id`);

--
-- Indexes for table `total_amt`
--
ALTER TABLE `total_amt`
  ADD PRIMARY KEY (`amt_id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `mobile` (`mobile`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `access_token` (`access_token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `accounts_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `total_amt`
--
ALTER TABLE `total_amt`
  MODIFY `amt_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
