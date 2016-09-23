-- phpMyAdmin SQL Dump
-- version 4.6.1
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Sep 07, 2016 at 04:25 PM
-- Server version: 5.5.50-0ubuntu0.14.04.1
-- PHP Version: 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kimochiiapi_anime`
--

-- --------------------------------------------------------

--
-- Table structure for table `ib_fansub_anime`
--

CREATE TABLE `ib_fansub_anime` (
  `aid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `vid` text NOT NULL,
  `episode` text NOT NULL,
  `gdrive` text NOT NULL,
  `gdrive_encode` text NOT NULL,
  `linkcontent` text NOT NULL,
  `view` int(11) NOT NULL DEFAULT '1',
  `report` int(11) NOT NULL DEFAULT '1',
  `date` int(11) NOT NULL,
  `lastdate` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ib_fansub_anime_genre`
--

CREATE TABLE `ib_fansub_anime_genre` (
  `agid` int(11) NOT NULL,
  `aid` int(11) NOT NULL,
  `genreid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ib_fansub_download`
--

CREATE TABLE `ib_fansub_download` (
  `link_id` int(11) NOT NULL,
  `link_title` text NOT NULL,
  `link_d_active` int(11) NOT NULL,
  `link_w_active` int(11) NOT NULL,
  `link_date` int(11) NOT NULL,
  `link_active` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ib_fansub_genre`
--

CREATE TABLE `ib_fansub_genre` (
  `genreid` int(11) NOT NULL,
  `genre` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ib_fansub_genre`
--

INSERT INTO `ib_fansub_genre` (`genreid`, `genre`) VALUES
(1, 'Action'),
(2, 'Adventure'),
(3, 'Comedy'),
(4, 'Drama'),
(5, 'Harem'),
(6, 'Slice of Life'),
(7, 'Fantasy'),
(8, 'Erotica'),
(9, 'Horror'),
(10, 'Mystery'),
(11, 'Psychological'),
(12, 'Romance'),
(13, 'Science Fiction'),
(14, 'Thriller'),
(15, 'Tournament');

-- --------------------------------------------------------

--
-- Table structure for table `ib_fansub_nav`
--

CREATE TABLE `ib_fansub_nav` (
  `mid` int(11) NOT NULL,
  `menu` text NOT NULL,
  `link` text NOT NULL,
  `icon` text NOT NULL,
  `mtype` int(11) NOT NULL,
  `menudate` int(11) NOT NULL,
  `mstatus` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ib_fansub_project`
--

CREATE TABLE `ib_fansub_project` (
  `pid` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `title` text NOT NULL,
  `summary` text NOT NULL,
  `co_work` text NOT NULL,
  `thumbnail` text NOT NULL,
  `data_json` text NOT NULL,
  `trailer` text NOT NULL,
  `onair` int(11) NOT NULL,
  `day` int(11) NOT NULL,
  `dateline` int(11) NOT NULL,
  `lastupdate` int(11) NOT NULL,
  `pjviews` int(11) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ib_fansub_reply`
--

CREATE TABLE `ib_fansub_reply` (
  `reply_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `reply_message` text NOT NULL,
  `reply_auther` text NOT NULL,
  `reply_date` int(11) NOT NULL,
  `reply_type` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ib_fansub_season`
--

CREATE TABLE `ib_fansub_season` (
  `sid` int(11) NOT NULL,
  `season` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ib_fansub_setting`
--

CREATE TABLE `ib_fansub_setting` (
  `sitename` text NOT NULL,
  `sitefavicon` text NOT NULL,
  `siteurl` text NOT NULL,
  `sitetitle` text NOT NULL,
  `sitekeywords` text NOT NULL,
  `sitedescription` text NOT NULL,
  `sitetheme` text NOT NULL,
  `siteanno` int(11) NOT NULL,
  `siteanno_text` text NOT NULL,
  `video_cover` text NOT NULL,
  `video_wait` text NOT NULL,
  `video_false` text NOT NULL,
  `facebook` text NOT NULL,
  `animeshow` int(11) NOT NULL,
  `animecount` int(11) NOT NULL,
  `pic_header` text NOT NULL,
  `bg_color` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ib_fansub_setting`
--

INSERT INTO `ib_fansub_setting` (`sitename`, `sitefavicon`, `siteurl`, `sitetitle`, `sitekeywords`, `sitedescription`, `sitetheme`, `siteanno`, `siteanno_text`, `video_cover`, `video_wait`, `video_false`, `facebook`, `animeshow`, `animecount`, `pic_header`, `bg_color`) VALUES
('FSbelieve', 'http://i.imgur.com/cZriYSr.png', 'http://localhost/', 'FSbelieve | เว็บแฟนซับ', 'fsbelieve,iambelieve', 'fsbelieve iambelieve', 'pure', 0, '', 'http://i.imgur.com/qGuNDYn.png', 'http://i.imgur.com/YwH1ume.png', 'http://i.imgur.com/0ofbXMP.png', 'believe.dsth', 1, 9, 'http://i.imgur.com/CvIAfX0.png', 'FFFFFF');

-- --------------------------------------------------------

--
-- Table structure for table `ib_fansub_topic`
--

CREATE TABLE `ib_fansub_topic` (
  `tid` int(11) NOT NULL,
  `topic` text NOT NULL,
  `message` text NOT NULL,
  `author` text NOT NULL,
  `date` int(11) NOT NULL,
  `tread` int(11) DEFAULT '1',
  `topic_type` int(11) NOT NULL,
  `topic_reply` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ib_fansub_user`
--

CREATE TABLE `ib_fansub_user` (
  `uid` int(11) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `email` text NOT NULL,
  `permission` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ib_fansub_user`
--

INSERT INTO `ib_fansub_user` (`uid`, `username`, `password`, `email`, `permission`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@admin.com', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ib_fansub_anime`
--
ALTER TABLE `ib_fansub_anime`
  ADD PRIMARY KEY (`aid`);

--
-- Indexes for table `ib_fansub_anime_genre`
--
ALTER TABLE `ib_fansub_anime_genre`
  ADD PRIMARY KEY (`agid`);

--
-- Indexes for table `ib_fansub_download`
--
ALTER TABLE `ib_fansub_download`
  ADD PRIMARY KEY (`link_id`);

--
-- Indexes for table `ib_fansub_genre`
--
ALTER TABLE `ib_fansub_genre`
  ADD PRIMARY KEY (`genreid`);

--
-- Indexes for table `ib_fansub_nav`
--
ALTER TABLE `ib_fansub_nav`
  ADD PRIMARY KEY (`mid`);

--
-- Indexes for table `ib_fansub_project`
--
ALTER TABLE `ib_fansub_project`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `ib_fansub_reply`
--
ALTER TABLE `ib_fansub_reply`
  ADD PRIMARY KEY (`reply_id`);

--
-- Indexes for table `ib_fansub_season`
--
ALTER TABLE `ib_fansub_season`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `ib_fansub_topic`
--
ALTER TABLE `ib_fansub_topic`
  ADD PRIMARY KEY (`tid`);

--
-- Indexes for table `ib_fansub_user`
--
ALTER TABLE `ib_fansub_user`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ib_fansub_anime`
--
ALTER TABLE `ib_fansub_anime`
  MODIFY `aid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ib_fansub_anime_genre`
--
ALTER TABLE `ib_fansub_anime_genre`
  MODIFY `agid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ib_fansub_download`
--
ALTER TABLE `ib_fansub_download`
  MODIFY `link_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ib_fansub_genre`
--
ALTER TABLE `ib_fansub_genre`
  MODIFY `genreid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `ib_fansub_nav`
--
ALTER TABLE `ib_fansub_nav`
  MODIFY `mid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ib_fansub_project`
--
ALTER TABLE `ib_fansub_project`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ib_fansub_reply`
--
ALTER TABLE `ib_fansub_reply`
  MODIFY `reply_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ib_fansub_season`
--
ALTER TABLE `ib_fansub_season`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ib_fansub_topic`
--
ALTER TABLE `ib_fansub_topic`
  MODIFY `tid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ib_fansub_user`
--
ALTER TABLE `ib_fansub_user`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
