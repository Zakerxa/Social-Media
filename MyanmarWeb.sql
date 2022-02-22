-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 04, 2021 at 08:44 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `MyanmarWeb`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `cm_id` int(11) NOT NULL,
  `cm_post_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cm_user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cm_content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `cm_photo` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `cm_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cm_created_date` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comment_likes`
--

CREATE TABLE `comment_likes` (
  `id` int(11) NOT NULL,
  `cm_text_id` int(11) NOT NULL,
  `cm_like_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comment_likes`
--

INSERT INTO `comment_likes` (`id`, `cm_text_id`, `cm_like_user_id`) VALUES
(8, 96, 1),
(11, 95, 1);

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE `friends` (
  `f_id` int(11) NOT NULL,
  `user_one` int(11) NOT NULL,
  `user_two` int(11) NOT NULL,
  `rskey` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `friends`
--

INSERT INTO `friends` (`f_id`, `user_one`, `user_two`, `rskey`, `start_date`) VALUES
(7, 1, 24, 'oMGuRH7dzEZeJX4vDAwi', '2021-06-04 01:11:21');

-- --------------------------------------------------------

--
-- Table structure for table `friend_request`
--

CREATE TABLE `friend_request` (
  `fr_id` int(11) NOT NULL,
  `sender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `receiver` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `req_state` int(11) NOT NULL,
  `time` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `friend_request`
--

INSERT INTO `friend_request` (`fr_id`, `sender`, `receiver`, `req_state`, `time`) VALUES
(72, '24', '1', 1, '2021-06-04 01:11:11');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `like_user_id` int(11) NOT NULL,
  `rid_fk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `token`, `like_user_id`, `rid_fk`) VALUES
(735, '105ZPV6D21BL3JS48U7Y', 3, 4),
(736, '105ZPV6D21BL3JS48U7Y', 24, 5),
(812, '1032RBZNUEYWTMSOLI7G', 24, 1),
(896, '10FAK43V8CRZLSY9P15J', 1, 3),
(897, '10FAK43V8CRZLSY9P15J', 24, 2);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `p_id` int(11) NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `share_post` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `video` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `region` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `report` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modified_date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`p_id`, `user_id`, `share_post`, `content`, `photo`, `video`, `link`, `category`, `post_token`, `path`, `type`, `region`, `report`, `created_date`, `modified_date`) VALUES
(136, '1', '', 'This is Global Post', '', '', '', 'Global', '105ZPV6D21BL3JS48U7Y', 'ybqnaVHGX1l5gRW4EUNK', 'post', '', '', '2021-05-31 16:34:43', '');

-- --------------------------------------------------------

--
-- Table structure for table `reactions`
--

CREATE TABLE `reactions` (
  `rid` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reactions`
--

INSERT INTO `reactions` (`rid`, `name`) VALUES
(1, 'Like'),
(2, 'Love'),
(3, 'Haha'),
(4, 'Wow'),
(5, 'Cool'),
(6, 'Confused '),
(7, 'Sad'),
(8, 'Angry ');

-- --------------------------------------------------------

--
-- Table structure for table `replys`
--

CREATE TABLE `replys` (
  `rp_id` int(11) NOT NULL,
  `cm_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rp_user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rp_content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `rp_photo` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `rp_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rp_created_date` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `saveposts`
--

CREATE TABLE `saveposts` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `s_category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `unlikes`
--

CREATE TABLE `unlikes` (
  `id` int(11) NOT NULL,
  `unlike_user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pic` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `cv` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `birth` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dark_mode` tinyint(4) NOT NULL,
  `state` tinyint(4) NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `friends` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `readme` tinyint(4) NOT NULL,
  `user_row` tinyint(4) NOT NULL,
  `get_start` tinyint(4) NOT NULL,
  `createdTime` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdDate` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_login` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `block` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `phone`, `pic`, `cv`, `birth`, `gender`, `password`, `country`, `city`, `dark_mode`, `state`, `token`, `profile`, `friends`, `readme`, `user_row`, `get_start`, `createdTime`, `createdDate`, `last_login`, `block`) VALUES
(1, 'Zin Min Htet', 'zinminhtet@gmail.com', '09687717764', 'helloworld@gmail.com/2c3XVD6po81622665527.png', 'CFCD', 'March 7 2000', 'Male', '$2y$10$u4peqDqWOHVQJvvnlQW3E.FnCB36B2Dsz1S6BQlcTzLOlohaQTN5S', 'Myanmar', 'Yangon', 0, 1, '210.14.105.210', 'helloworld@gmail.com', '', 0, 0, 1, '2021-05-04 11:50:24', '2021-May-04', '2021-06-03 23:42:25', 0),
(3, 'Acer-Zakerxa', 'koko@gmail.com', '09687717767', 'sample-photo1.png', '', '', '', '$2y$10$u4peqDqWOHVQJvvnlQW3E.FnCB36B2Dsz1S6BQlcTzLOlohaQTN5S', '', 'Pago', 0, 1, '116.206.137.115', 'CDCFCDFCGGGGGFHHH', '', 0, 0, 1, '2021-05-04 07:50:24', '2021-May-04', '', 0),
(23, 'Kyaw Thu Ya', 'zinmin.htet.zmh.00@gmail.com', '09687717767', 'sample-photo1.png', '', '', '', '$2y$10$i09QX7IefrJ7N/JRmpdjket4HbwNBKJUj9GVBtc8YEgjyoV6iOfxS', '', 'Pago', 0, 1, '210.14.105.74', 'GHBBBMKDVRTCDCGS', '', 0, 0, 1, '2021-05-13 01:50:24', '2021-May-13', '', 0),
(24, 'Mg Kyaw Thet', 'zekerxa@gmail.com', '09687717767', 'FVGTYTTTTTTCSDG/mUGOBA26rN1622627686.png', '', 'Invalid date', '', '$2y$10$ZjtlgawZ9vchhSk5ydkKhO7580OhU6qwFmON2TxKcjc8XUFFZaxFO', '', 'Yangon', 0, 1, '210.14.105.210', 'FVGTYTTTTTTCSDG', '', 0, 0, 1, '2021-05-14 11:50:24', '2021-May-14', '2021-06-04 00:03:15', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`cm_id`);

--
-- Indexes for table `comment_likes`
--
ALTER TABLE `comment_likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`f_id`);

--
-- Indexes for table `friend_request`
--
ALTER TABLE `friend_request`
  ADD PRIMARY KEY (`fr_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`p_id`);

--
-- Indexes for table `reactions`
--
ALTER TABLE `reactions`
  ADD PRIMARY KEY (`rid`);

--
-- Indexes for table `replys`
--
ALTER TABLE `replys`
  ADD PRIMARY KEY (`rp_id`);

--
-- Indexes for table `saveposts`
--
ALTER TABLE `saveposts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unlikes`
--
ALTER TABLE `unlikes`
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
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `cm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `comment_likes`
--
ALTER TABLE `comment_likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `friends`
--
ALTER TABLE `friends`
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `friend_request`
--
ALTER TABLE `friend_request`
  MODIFY `fr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=899;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT for table `reactions`
--
ALTER TABLE `reactions`
  MODIFY `rid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `replys`
--
ALTER TABLE `replys`
  MODIFY `rp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `saveposts`
--
ALTER TABLE `saveposts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `unlikes`
--
ALTER TABLE `unlikes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
