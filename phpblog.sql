-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 15, 2025 at 01:14 PM
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
-- Database: `phpblog`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`) VALUES
(2, 'Mobile', 'Black Iphone 17 ProMax', '2025-11-03 17:36:20'),
(3, 'gyrty', 'yyhedgdtyyyyyyyyyyyyyy', '2025-11-15 12:11:02');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `comment` text NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `name`, `email`, `comment`, `status`, `created_at`) VALUES
(1, 2, 'habiba', 'elshimyhabiba23@gmail.com', 'its delaciouce!', 'approved', '2025-11-05 08:27:45'),
(2, 9, 'vfghfn', 'elshimyhabiba23@gmail.com', 'vggjjnm ', 'rejected', '2025-11-05 08:28:02'),
(3, 9, 'habiba', 'elshimyhabiba23@gmail.com', ' gnm', 'approved', '2025-11-05 08:28:30'),
(7, 9, 'habiba', 'elshimyhabiba23@gmail.com', 'sqdSDw', 'approved', '2025-11-05 12:24:27'),
(8, 9, 'habiba', 'elshimyhabiba23@gmail.com', 'sqdSDw', 'approved', '2025-11-05 12:24:33'),
(9, 9, 'habiba', 'elshimyhabiba23@gmail.com', 'sqdSDw', 'approved', '2025-11-05 12:24:34'),
(10, 9, 'habiba', 'elshimyhabiba23@gmail.com', 'sqdSDw', 'rejected', '2025-11-05 12:24:54'),
(11, 9, 'habiba', 'elshimyhabiba23@gmail.com', 'sqdSDw', 'approved', '2025-11-05 12:24:57'),
(13, 9, 'we', 'we@school.com', 'ay haga', 'approved', '2025-11-05 12:25:46'),
(20, 2, 'we', 'we@school.com', 'ssssssssssssssssssssssssss', 'rejected', '2025-11-12 07:46:40');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `views` int(11) DEFAULT 0,
  `status` enum('draft','puplished') DEFAULT 'draft',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `content`, `image`, `category_id`, `views`, `status`, `created_at`, `updated_at`, `user_id`) VALUES
(2, 'red velvet cake', 'frosting. It has a mild chocolate flavor combined with a slight tanginess from buttermilk and vinegar, giving it a unique taste that’s both sweet and slightly tart. The cake’s soft texture and vibrant color make it perfect for special occasions like birthdays, weddings, and celebrations. When layered and frosted, it looks elegant and tastes absolutely delicious.', 'download (1).jpeg', 2, 15, 'puplished', '2025-11-04 13:16:56', '2025-11-12 07:47:09', NULL),
(5, 'Post1', 'we have one category with name mobile', '1763208502_c662fe2e06ef1750ff88e39e4d651ec4.jpg', 2, 0, 'draft', '2025-11-03 18:04:24', '2025-11-15 12:08:22', NULL),
(7, 'pizza', 'italian pizza with tomatoes & cheese', 'download.jpeg', 2, 0, 'puplished', '2025-11-04 13:09:32', '2025-11-04 13:09:32', NULL),
(8, 'red vilved cake', 'ggfsfjjhm', 'download (1).jpeg', 2, 0, '', '2025-11-04 13:16:15', '2025-11-04 13:16:15', NULL),
(9, 'Post1', 'k;jdhsgv cmkfrjugfvfvbv vlldi', 'download.jpeg', 2, 19, 'puplished', '2025-11-05 07:51:45', '2025-11-12 07:44:14', NULL),
(11, 'pizza2', 'jkm,l.;/', '1762950103_04.11.2025_19.16.13_REC.png', 2, 2, 'puplished', '2025-11-12 12:21:43', '2025-11-15 12:09:59', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
