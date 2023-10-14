-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 19, 2019 at 11:10 PM
-- Server version: 5.7.24
-- PHP Version: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `256project`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(50) COLLATE utf8mb4_turkish_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `post_id` int(11) NOT NULL,
  PRIMARY KEY (`comment_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`comment_id`, `content`, `user_id`, `created_at`, `post_id`) VALUES
(15, 'fgh', 8, '2019-05-19 23:03:36', 120);

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

DROP TABLE IF EXISTS `likes`;
CREATE TABLE IF NOT EXISTS `likes` (
  `post_id` int(11) NOT NULL,
  `liker_id` int(11) NOT NULL,
  PRIMARY KEY (`post_id`,`liker_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`post_id`, `liker_id`) VALUES
(116, 16),
(119, 14);

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

DROP TABLE IF EXISTS `member`;
CREATE TABLE IF NOT EXISTS `member` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_email` varchar(50) COLLATE utf8mb4_turkish_ci NOT NULL,
  `user_name` varchar(50) COLLATE utf8mb4_turkish_ci NOT NULL,
  `user_surname` varchar(50) COLLATE utf8mb4_turkish_ci NOT NULL,
  `user_birthdate` date NOT NULL,
  `user_pass` varchar(60) COLLATE utf8mb4_turkish_ci NOT NULL,
  `user_gender` char(1) COLLATE utf8mb4_turkish_ci NOT NULL,
  `user_profilepic` varchar(50) COLLATE utf8mb4_turkish_ci NOT NULL,
  PRIMARY KEY (`user_id`) USING BTREE,
  UNIQUE KEY `user_email` (`user_email`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`user_id`, `user_email`, `user_name`, `user_surname`, `user_birthdate`, `user_pass`, `user_gender`, `user_profilepic`) VALUES
(14, 'nedkelly@me.com', 'Ned', 'Kelly', '1854-12-01', '$2y$10$5K/UYiA.rRoMtSGRqlKII.o66LKqG5m8cQYoEV2NOoYafy/YmzeHK', 'M', 'profilepics/5ccccf5e47047_1.png'),
(8, 'johndoe@me.com', 'John', 'Doe', '1970-01-01', '$2y$10$ecOCSFZnSCRQ0Qgb6SXyEOhD9vIYbmvfZhxcHURX.9b1ujPCubl7O', 'M', 'profilepics/5cc9f24f7eece_31.png'),
(13, 'jefcostello@me.com', 'Jef', 'Costello', '1935-11-08', '$2y$10$1Ai7Ok61XBHOpyXbe9btKeb9T97Eo6lLhkLg9R9bxm2kygYm3VTzu', 'M', 'profilepics/5cccce5fc6a09_index.jpg'),
(15, 'test@gmail.com', 'asdf', 'sadf2', '0003-02-01', '$2y$10$jOPpace/gbdW3Gnw3ZuI7OqwPWeSSvrKy8JvRuCqetDliRo4r0qZa', 'M', 'profilepics/5cd59e0b78da3_370.jpg'),
(16, 'test10@gmail.com', 'testing', 'testing2', '0242-03-23', '$2y$10$pjWEmfQzwIP6UWwTSxc7Uu/TojrSbCw/PAQxgrM1r/aR1.qo9ovze', 'M', 'profilepics/5cd6ea7929bda_4 (2).png');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(50) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `img_content` varchar(50) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `likes` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=134 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `content`, `img_content`, `user_id`, `created_at`, `likes`, `comment_id`) VALUES
(133, '123', '', 13, '2019-05-20 02:10:19', 0, 0),
(117, 'sdf', NULL, 14, '2019-05-19 16:03:06', 0, 0),
(119, '567', NULL, 14, '2019-05-19 16:03:58', 1, 0),
(120, '7667', NULL, 8, '2019-05-19 23:03:34', 0, 0),
(121, '765', NULL, 14, '2019-05-19 23:13:28', 0, 0),
(122, '77', NULL, 14, '2019-05-19 23:13:30', 0, 0),
(123, '34', NULL, 8, '2019-05-20 01:20:42', 0, 0),
(124, '34', NULL, 8, '2019-05-20 01:20:42', 0, 0),
(125, '6', NULL, 14, '2019-05-20 01:46:31', 0, 0),
(126, 'asd', NULL, 14, '2019-05-20 01:47:19', 0, 0),
(127, '567', NULL, 14, '2019-05-20 01:48:54', 0, 0),
(128, '567', NULL, 14, '2019-05-20 01:48:58', 0, 0),
(129, 'asd', '', 14, '2019-05-20 02:02:58', 0, 0),
(132, 'jghj', 'images/5ce1e0fc1f829_asd.png', 14, '2019-05-20 02:04:28', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `relationship`
--

DROP TABLE IF EXISTS `relationship`;
CREATE TABLE IF NOT EXISTS `relationship` (
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `status` char(1) COLLATE utf8mb4_turkish_ci NOT NULL DEFAULT 'P',
  PRIMARY KEY (`sender_id`,`receiver_id`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
