-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 08, 2024 at 01:22 PM
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
-- Database: `car_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `car_table`
--

CREATE TABLE `car_table` (
  `car_id` int(11) NOT NULL,
  `car_name` varchar(255) NOT NULL,
  `car_brand` varchar(255) NOT NULL,
  `car_type` varchar(255) NOT NULL,
  `car_color` varchar(255) NOT NULL,
  `car_price` int(11) NOT NULL,
  `file_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `car_table`
--

INSERT INTO `car_table` (`car_id`, `car_name`, `car_brand`, `car_type`, `car_color`, `car_price`, `file_path`) VALUES
(7, 'Honda Civic Type R', 'Toyota', 'Manual', 'White', 90000, './uploads/honda_civic_type_r.jpg'),
(8, 'Tesla ModelX', 'Hyundai', 'Automatic', 'White', 90500, './uploads/tesla_modelx.jpg'),
(9, 'Toyota Prius ', 'Toyota', 'Manual', 'White', 90000, './uploads/Toyota_Prius.jpg'),
(10, 'Raptor', 'Ford', 'Manual ', 'Red', 200500, './uploads/Ford_F-150_Raptor.jpg'),
(25, 'Supra mk4 1997', 'Toyota', 'Manual', 'Black', 90000, './uploads/1997-toyota-supra.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `car_table`
--
ALTER TABLE `car_table`
  ADD PRIMARY KEY (`car_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `car_table`
--
ALTER TABLE `car_table`
  MODIFY `car_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
