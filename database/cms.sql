-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 10, 2020 at 04:25 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(30) NOT NULL,
  `category` varchar(200) NOT NULL,
  `link` text NOT NULL,
  `type` int(1) NOT NULL DEFAULT 1 COMMENT '1=content, 2= list-page',
  `order_by` int(30) NOT NULL,
  `is_root` tinyint(1) NOT NULL DEFAULT 1,
  `parent_id` int(30) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`, `link`, `type`, `order_by`, `is_root`, `parent_id`, `date_created`) VALUES
(1, 'Navigation 1', 'index.php?page=list&c=navigation_1&cid=c4ca4238a0b923820dcc509a6f75849b', 1, 0, 1, 0, '2020-12-10 11:17:43'),
(2, 'Navigation 2', 'index.php?page=list&c=navigation_2&cid=c81e728d9d4c2f636f067f89cc14862c', 1, 3, 1, 0, '2020-12-10 11:18:17'),
(3, 'Sub Navigation 1', 'index.php?page=list&c=sub_navigation_1&cid=eccbc87e4b5ce2fe28308fd9f2a7baf3', 1, 1, 0, 1, '2020-12-10 11:30:42'),
(4, 'Sub Navigation 2', 'index.php?page=list&c=sub_navigation_2&cid=a87ff679a2f3e71d9181a67b7542122c', 1, 2, 0, 1, '2020-12-10 11:37:02');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(30) NOT NULL,
  `user_id` int(30) NOT NULL,
  `comment` text NOT NULL,
  `content_id` int(30) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_modified` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `user_id`, `comment`, `content_id`, `date_created`, `date_modified`) VALUES
(1, 1, '<p>sample</p>', 2, '2020-12-10 21:43:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contents`
--

CREATE TABLE `contents` (
  `id` int(30) NOT NULL,
  `title` text NOT NULL,
  `category_id` int(30) NOT NULL,
  `author_id` int(30) NOT NULL,
  `meta_keywords` text NOT NULL,
  `meta_description` text NOT NULL,
  `link` text NOT NULL,
  `banner_img` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_modified` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contents`
--

INSERT INTO `contents` (`id`, `title`, `category_id`, `author_id`, `meta_keywords`, `meta_description`, `link`, `banner_img`, `date_created`, `date_modified`) VALUES
(2, 'Sample Content', 3, 1, 'Tag 1,Tag 2,Tag 3,asdasd', 'SAMPLELorem ipsum dolor sit amet, consectetur adipiscing elit. Duis volutpat est imperdiet lobortis varius. Donec posuere, tortor quis maximus fringilla, tellus mauris porta lacus, vestibulum consequat lacus massa rutrum dui. Donec sagittis mauris semper nisi condimentum, non feugiat nisl vestibulum', '1_Sample-Content.html', '1607589840_47446233-clean-noir-et-gradient-sombre-image-de-fond-abstrait-.jpg', '2020-12-10 16:44:04', '2020-12-10 20:25:30'),
(3, 'Sample 101', 4, 1, 'tags', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla in felis viverra, tincidunt lacus eget, malesuada metus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Ut rhoncus est sed nisl rhoncus, et aliquam ante auctor. Aliquam egestas facilisis ex ', '3_Sample-101.html', '1607603820_1605604020_123065338-creative-dark-coding-background-with-text-programming-and-future-concept-3d-rendering.jpg', '2020-12-10 20:37:32', '2020-12-10 20:41:25');

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `banner_img` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`id`, `name`, `email`, `contact`, `address`, `banner_img`) VALUES
(1, 'Content Management System', 'info@sample.comm', '+6948 8542 623', '2102  Caldwell Road, Rochester, New York, 14608', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(30) NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `type` int(1) NOT NULL DEFAULT 3 COMMENT '1=admin,2=author3=subscriber',
  `avatar` text NOT NULL DEFAULT 'no-image-available.png',
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `password`, `type`, `avatar`, `date_created`) VALUES
(1, 'Administrator', '', 'admin@admin.com', '0192023a7bbd73250516f069df18b500', 1, '1607590140_avatar.jpg', '2020-11-26 10:57:04'),
(2, 'John', 'Smith', 'jsmith@sample.com', '1254737c076cf867dc53d60a0364f38e', 3, 'no-image-available.png', '2020-12-10 22:25:38');

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
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `contents`
--
ALTER TABLE `contents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contents`
--
ALTER TABLE `contents`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
