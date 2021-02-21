-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Dec 15, 2019 at 09:32 PM
-- Server version: 5.5.62
-- PHP Version: 7.2.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `enth_docker`
--
CREATE DATABASE IF NOT EXISTS `enth_docker` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `enth_docker`;

-- --------------------------------------------------------

--
-- Table structure for table `affiliates`
--

DROP TABLE IF EXISTS `affiliates`;
CREATE TABLE `affiliates` (
  `affiliateid` int(5) NOT NULL,
  `url` varchar(254) NOT NULL DEFAULT '',
  `title` varchar(254) NOT NULL DEFAULT '',
  `imagefile` varchar(254) DEFAULT NULL,
  `email` varchar(255) NOT NULL DEFAULT '',
  `added` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `catid` int(5) NOT NULL,
  `catname` varchar(255) NOT NULL DEFAULT '',
  `parent` int(5) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`catid`, `catname`, `parent`) VALUES
(1, 'Academia', 0),
(2, 'Actors', 0),
(3, 'Actresses', 0),
(4, 'Adult', 0),
(5, 'Advertising/TV Channels', 0),
(6, 'Albums', 0),
(7, 'Animals', 0),
(8, 'Animation', 0),
(9, 'Anime/Manga: Adult', 0),
(10, 'Anime/Manga: Characters 0-M', 0),
(11, 'Anime/Manga: Characters N-Z', 0),
(12, 'Anime/Manga: Companies', 0),
(13, 'Anime/Manga: Episodes', 0),
(14, 'Anime/Manga: Fanstuff', 0),
(15, 'Anime/Manga: General', 0),
(16, 'Anime/Manga: Items/Locations', 0),
(17, 'Anime/Manga: Magazines', 0),
(18, 'Anime/Manga: Manga-ka/Directors', 0),
(19, 'Anime/Manga: Movies/OVAs', 0),
(20, 'Anime/Manga: Music', 0),
(21, 'Anime/Manga: Relationships', 0),
(22, 'Anime/Manga: Rivalries', 0),
(23, 'Anime/Manga: Series', 0),
(24, 'Anime/Manga: Songs', 0),
(25, 'Anime/Manga: Toys/Collectibles', 0),
(26, 'Anime/Manga: Websites', 0),
(27, 'Arts and Design', 0),
(28, 'Authors/Writers', 0),
(29, 'Characters: Book/Movie', 0),
(30, 'Characters: TV', 0),
(31, 'Comics', 0),
(32, 'Computer Miscellany and Internet', 0),
(33, 'Directors/Producers', 0),
(34, 'Episodes', 0),
(35, 'Fan Works', 0),
(36, 'Fashion/Beauty', 0),
(37, 'Food/Drinks', 0),
(38, 'Games', 0),
(39, 'History/Royalty', 0),
(40, 'Hobbies and Recreation', 0),
(41, 'Literature', 0),
(42, 'Magazines/Newspapers', 0),
(43, 'Miscellaneous', 0),
(44, 'Models', 0),
(45, 'Movies', 0),
(46, 'Music Miscellany', 0),
(47, 'Musicians: Bands/Groups', 0),
(48, 'Musicians: Female', 0),
(49, 'Musicians: Male', 0),
(50, 'Mythology/Religion', 0),
(51, 'Nature', 0),
(52, 'Objects', 0),
(53, 'People Miscellany', 0),
(54, 'Places', 0),
(55, 'Politics and Organisations', 0),
(56, 'Radio', 0),
(57, 'Relationships: Book/Movie', 0),
(58, 'Relationships: Real Life', 0),
(59, 'Relationships: TV', 0),
(60, 'Songs: Bands/Groups 0-M', 0),
(61, 'Songs: Bands/Groups N-Z', 0),
(62, 'Songs: Female Solo', 0),
(63, 'Songs: Male Solo', 0),
(64, 'Songs: Various', 0),
(65, 'Sports', 0),
(66, 'Sports Entertainment', 0),
(67, 'Stage/Theatre', 0),
(68, 'Toys/Collectibles', 0),
(69, 'Transportation', 0),
(70, 'TV/Stage Personalities', 0),
(71, 'TV Shows', 0),
(72, 'TV/Movie/Book Miscellany', 0),
(73, 'Webmasters', 0),
(74, 'Websites', 0);

-- --------------------------------------------------------

--
-- Table structure for table `emailtemplate`
--

DROP TABLE IF EXISTS `emailtemplate`;
CREATE TABLE `emailtemplate` (
  `templateid` int(3) NOT NULL,
  `templatename` varchar(255) NOT NULL DEFAULT '',
  `subject` varchar(255) NOT NULL DEFAULT '',
  `content` mediumtext NOT NULL,
  `deletable` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `emailtemplate`
--

INSERT INTO `emailtemplate` (`templateid`, `templatename`, `subject`, `content`, `deletable`) VALUES
(1, 'Add Affiliate Template', 'Affiliation with $$site_title$$', 'Hello!\r\n\r\nThis is a notification for you to know that I have just added your site, $$site_aff_title$$ ($$site_aff_url$$) as an affiliate at $$site_title$$, found at $$site_url$$. :)\r\n\r\nSincerely,\r\n$$site_owner$$', 0);

-- --------------------------------------------------------

--
-- Table structure for table `errorlog`
--

DROP TABLE IF EXISTS `errorlog`;
CREATE TABLE `errorlog` (
  `date` datetime NOT NULL,
  `source` varchar(100) NOT NULL,
  `log` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `joined`
--

DROP TABLE IF EXISTS `joined`;
CREATE TABLE `joined` (
  `joinedid` int(10) NOT NULL,
  `catid` varchar(255) NOT NULL DEFAULT '0',
  `url` varchar(255) NOT NULL DEFAULT '',
  `subject` varchar(255) NOT NULL DEFAULT '',
  `desc` mediumtext,
  `comments` mediumtext,
  `imagefile` varchar(255) DEFAULT NULL,
  `added` date DEFAULT NULL,
  `pending` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `joined`
--

INSERT INTO `joined` (`joinedid`, `catid`, `url`, `subject`, `desc`, `comments`, `imagefile`, `added`, `pending`) VALUES
(1, '|1|', 'http://1234.com', 'Subj1', '', '', '', '2019-02-17', 0),
(2, '|2|', 'http://12344.com', 'Subj2', '', '', '', '2019-02-19', 0);

-- --------------------------------------------------------

--
-- Table structure for table `owned`
--

DROP TABLE IF EXISTS `owned`;
CREATE TABLE `owned` (
  `listingid` int(8) NOT NULL,
  `dbserver` varchar(255) NOT NULL DEFAULT '',
  `dbuser` varchar(255) NOT NULL DEFAULT '',
  `dbpassword` varchar(255) NOT NULL DEFAULT '',
  `dbdatabase` varchar(255) NOT NULL DEFAULT '',
  `dbtable` varchar(255) NOT NULL DEFAULT '',
  `title` varchar(255) DEFAULT NULL,
  `subject` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `url` varchar(255) DEFAULT NULL,
  `imagefile` varchar(255) DEFAULT NULL,
  `desc` mediumtext,
  `catid` varchar(255) NOT NULL DEFAULT '0',
  `listingtype` varchar(255) NOT NULL DEFAULT 'fanlisting',
  `country` tinyint(1) NOT NULL DEFAULT '1',
  `affiliates` tinyint(1) NOT NULL DEFAULT '0',
  `affiliatesdir` varchar(255) DEFAULT NULL,
  `dropdown` tinyint(1) NOT NULL DEFAULT '1',
  `sort` varchar(255) NOT NULL DEFAULT 'country',
  `perpage` int(3) NOT NULL DEFAULT '25',
  `linktarget` varchar(255) NOT NULL DEFAULT '_top',
  `additional` mediumtext,
  `joinpage` varchar(255) NOT NULL DEFAULT 'join.php',
  `listpage` varchar(255) NOT NULL DEFAULT 'list.php',
  `updatepage` varchar(255) NOT NULL DEFAULT 'update.php',
  `lostpasspage` varchar(255) NOT NULL DEFAULT 'lostpass.php',
  `emailsignup` mediumtext NOT NULL,
  `emailapproved` mediumtext NOT NULL,
  `emailupdate` mediumtext NOT NULL,
  `emaillostpass` mediumtext NOT NULL,
  `listtemplate` mediumtext NOT NULL,
  `affiliatestemplate` mediumtext,
  `statstemplate` mediumtext,
  `notifynew` tinyint(1) NOT NULL DEFAULT '1',
  `holdupdate` tinyint(1) NOT NULL DEFAULT '0',
  `opened` date DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `owned`
--

INSERT INTO `owned` (`listingid`, `dbserver`, `dbuser`, `dbpassword`, `dbdatabase`, `dbtable`, `title`, `subject`, `email`, `url`, `imagefile`, `desc`, `catid`, `listingtype`, `country`, `affiliates`, `affiliatesdir`, `dropdown`, `sort`, `perpage`, `linktarget`, `additional`, `joinpage`, `listpage`, `updatepage`, `lostpasspage`, `emailsignup`, `emailapproved`, `emailupdate`, `emaillostpass`, `listtemplate`, `affiliatestemplate`, `statstemplate`, `notifynew`, `holdupdate`, `opened`, `status`) VALUES
(1, 'mysql', 'enth_docker', 'password', 'enth_docker', 'table1', 'FL1', 'subj1', 'password@password.com', 'http://localhost:8081/samplefl', NULL, NULL, '|2|30|', 'fanlisting', 1, 1, '/app/public/images/', 1, 'country', 25, '_top', 'extra_field', 'join.php', 'list.php', 'update.php', 'lostpass.php', 'Hello, $$fan_name$$,\r\n\r\nWelcome to the $$fanlisting_title$$ $$listing_type$$, a $$listing_type$$ for $$fanlisting_subject$$.\r\n\r\nYou have received this email because you (or someone else) used this email address to sign up as a member of the $$fanlisting_title$$ $$listing_type$$. If this is in error, please reply to this email and tell us and we will remove you from the $$listing_type$$ as soon as possible.\r\n\r\nCurrently, you have been placed on the members queue for approval. You are not yet part of the $$listing_type$$. If in two weeks, you have not yet been notified of your approval and you are not yet listed at the members list, please feel free to email us and check up on your application.\r\n\r\nThe information you submitted to this fanlisting is shown below. Please keep this information, as you will need your password to change your information listed on the $$listing_type$$. If any of this is in error, feel free to update your information at $$fanlisting_url$$/$$fanlisting_update$$.\r\n\r\nName: $$fan_name$$\r\nEmail address: $$fan_email$$\r\nCountry: $$fan_country$$\r\nURL: $$fan_url$$\r\nPassword: $$fan_password$$\r\n\r\nThank you for joining!\r\n\r\nSincerely yours, \r\n$$owner_name$$\r\n\r\n--\r\n$$fanlisting_title$$\r\n$$fanlisting_url$$\r\n', 'Hello, $$fan_name$$,\r\n\r\nThank you for joining $$fanlisting_title$$, a $$listing_type$$ for $$fanlisting_subject$$. You have been moved from the members queue to the fans list, and you should now be able to see your information on the site at $$fanlisting_url$$/$$fanlisting_list$$. Please do not lose the email that was earlier sent to you when you first joined, as it contains your information as well as your password for changing this information, which you can do so by going to $$fanlisting_url$$/$$fanlisting_update$$.\r\n\r\nIf you ever forget your password, you can reset and retrieve your password by going to $$fanlisting_url$$/$$fanlisting_lostpass$$. \r\n\r\nSincerely,\r\n$$owner_name$$\r\n\r\n--\r\n$$fanlisting_title$$\r\n$$fanlisting_url$$\r\n', 'Hello $$fan_name$$,\r\n\r\nYou have received this email because you (or someone else) has recently changed your information on the $$fanlisting_subject$$ $$listing_type$$ ($$fanlisting_url$$). Your new information is below. If this is in error and you did not change your information, please secure your information immediately (especially by changing your password) and tell us immediately of this error.\r\n\r\n(Note: if you did not change your password, the password field will show up as blank. This is not an error; your password will still be the same when you joined or last updated it.)\r\n\r\nName: $$fan_name$$ \r\nEmail address: $$fan_email$$ \r\nCountry: $$fan_country$$ \r\nURL: $$fan_url$$\r\nPassword: $$fan_password$$\r\n\r\nThank you for keeping your information up to date!\r\n\r\nSincerely,\r\n$$owner_name$$\r\n\r\n--\r\n$$fanlisting_title$$ \r\n$$fanlisting_url$$\r\n', 'Hello $$fan_name$$, \r\n\r\nYou have received this email because you are a member of the $$fanlisting_subject$$ $$listing_type$$ and you (or someone else) has recently requested for a password reset on the $$listing_type$$. Your new password is shown below. If this is in error and you did not reset your password, please secure your information immediately and tell us immediately of this error.\r\n\r\nEmail address: $$fan_email$$\r\nPassword: $$fan_password$$\r\n\r\nYou can change your password to something easier to remember by going to the update form at $$fanlisting_url$$/$$fanlisting_update$$\r\n\r\nSincerely,\r\n$$owner_name$$\r\n\r\n--\r\n$$fanlisting_title$$\r\n$$fanlisting_url$$\r\n', '<p><b>$$fan_name$$</b> ($$fan_country$$)<br />\r\n$$fan_email_generic$$ - $$fan_url_generic$$</p>', '<a href=\"$$aff_url$$\" target=_blank><img src=\"$$aff_image$$\" width=\"$$aff_width$$\" height=\"$$aff_height$$\" border=\"0\" alt=\" $$aff_title$$\" title=\"$$aff_title$$\" /></a>', '<blockquote class=stat>Enthusiast mantainer: <a href=\"http://scripts.robotess.net\" target=\"_blank\">Ekaterina</a>\r\n<br />Opened: $$stat_opened$$<br />Last updated: $$stat_updated$$<br />\r\nMember count: $$stat_approved$$, from $$stat_countries$$ countries<br />\r\nPending members: $$stat_pending$$<br />\r\nNewest members: $$stat_newmembers$$<br />\r\nGrowth rate: $$stat_average$$ fans/day</blockquote>', 1, 0, '2010-02-17', 2),
(2, 'mysql', 'enth_docker', 'password', 'enth_docker', 'tab2', 'FL2', 'subj2', 'password@password.com', 'http://localhost:8081/samplefl300members', NULL, NULL, '|30|', 'fanlisting', 1, 0, NULL, 1, 'country', 25, '_top', '', 'join.php', 'list.php', 'update.php', 'lostpass.php', 'Hello, $$fan_name$$,\r\n\r\nWelcome to the $$fanlisting_title$$ $$listing_type$$, a $$listing_type$$ for $$fanlisting_subject$$.\r\n\r\nYou have received this email because you (or someone else) used this email address to sign up as a member of the $$fanlisting_title$$ $$listing_type$$. If this is in error, please reply to this email and tell us and we will remove you from the $$listing_type$$ as soon as possible.\r\n\r\nCurrently, you have been placed on the members queue for approval. You are not yet part of the $$listing_type$$. If in two weeks, you have not yet been notified of your approval and you are not yet listed at the members list, please feel free to email us and check up on your application.\r\n\r\nThe information you submitted to this fanlisting is shown below. Please keep this information, as you will need your password to change your information listed on the $$listing_type$$. If any of this is in error, feel free to update your information at $$fanlisting_url$$/$$fanlisting_update$$.\r\n\r\nName: $$fan_name$$\r\nEmail address: $$fan_email$$\r\nCountry: $$fan_country$$\r\nURL: $$fan_url$$\r\nPassword: $$fan_password$$\r\n\r\nThank you for joining!\r\n\r\nSincerely yours, \r\n$$owner_name$$\r\n\r\n--\r\n$$fanlisting_title$$\r\n$$fanlisting_url$$\r\n', 'Hello, $$fan_name$$,\r\n\r\nThank you for joining $$fanlisting_title$$, a $$listing_type$$ for $$fanlisting_subject$$. You have been moved from the members queue to the fans list, and you should now be able to see your information on the site at $$fanlisting_url$$/$$fanlisting_list$$. Please do not lose the email that was earlier sent to you when you first joined, as it contains your information as well as your password for changing this information, which you can do so by going to $$fanlisting_url$$/$$fanlisting_update$$.\r\n\r\nIf you ever forget your password, you can reset and retrieve your password by going to $$fanlisting_url$$/$$fanlisting_lostpass$$. \r\n\r\nSincerely,\r\n$$owner_name$$\r\n\r\n--\r\n$$fanlisting_title$$\r\n$$fanlisting_url$$\r\n', 'Hello $$fan_name$$,\r\n\r\nYou have received this email because you (or someone else) has recently changed your information on the $$fanlisting_subject$$ $$listing_type$$ ($$fanlisting_url$$). Your new information is below. If this is in error and you did not change your information, please secure your information immediately (especially by changing your password) and tell us immediately of this error.\r\n\r\n(Note: if you did not change your password, the password field will show up as blank. This is not an error; your password will still be the same when you joined or last updated it.)\r\n\r\nName: $$fan_name$$ \r\nEmail address: $$fan_email$$ \r\nCountry: $$fan_country$$ \r\nURL: $$fan_url$$\r\nPassword: $$fan_password$$\r\n\r\nThank you for keeping your information up to date!\r\n\r\nSincerely,\r\n$$owner_name$$\r\n\r\n--\r\n$$fanlisting_title$$ \r\n$$fanlisting_url$$\r\n', 'Hello $$fan_name$$, \r\n\r\nYou have received this email because you are a member of the $$fanlisting_subject$$ $$listing_type$$ and you (or someone else) has recently requested for a password reset on the $$listing_type$$. Your new password is shown below. If this is in error and you did not reset your password, please secure your information immediately and tell us immediately of this error.\r\n\r\nEmail address: $$fan_email$$\r\nPassword: $$fan_password$$\r\n\r\nYou can change your password to something easier to remember by going to the update form at $$fanlisting_url$$/$$fanlisting_update$$\r\n\r\nSincerely,\r\n$$owner_name$$\r\n\r\n--\r\n$$fanlisting_title$$\r\n$$fanlisting_url$$\r\n', '$$fan_name_td$$ $$fan_country_td$$ $$fan_url_generic_td$$', '<a href=\"$$aff_url$$\" target=_blank><img src=\"$$aff_image$$\" width=\"$$aff_width$$\" height=\"$$aff_height$$\" border=\"0\" alt=\" $$aff_title$$\" title=\"$$aff_title$$\" /></a>', '<blockquote class=stat>Enthusiast mantainer: <a href=\"http://scripts.robotess.net\" target=\"_blank\">Ekaterina</a>\r\n<br />Opened: $$stat_opened$$<br />Last updated: $$stat_updated$$<br />\r\nMember count: $$stat_approved$$, from $$stat_countries$$ countries<br />\r\nPending members: $$stat_pending$$<br />\r\nNewest members: $$stat_newmembers$$<br />\r\nGrowth rate: $$stat_average$$ fans/day</blockquote>', 1, 0, '2010-02-17', 2),
(3, 'mysql', 'enth_docker', 'password', 'enth_docker', 'subj3', NULL, 'subj3', 'sub3@sub.com', NULL, NULL, NULL, '|3|18|39|', 'fanlisting', 1, 0, NULL, 1, 'country', 25, '_top', NULL, 'join.php', 'list.php', 'update.php', 'lostpass.php', 'Hello, $$fan_name$$,\r\n\r\nWelcome to the $$fanlisting_title$$ $$listing_type$$, a $$listing_type$$ for $$fanlisting_subject$$.\r\n\r\nYou have received this email because you (or someone else) used this email address to sign up as a member of the $$fanlisting_title$$ $$listing_type$$. If this is in error, please reply to this email and tell us and we will remove you from the $$listing_type$$ as soon as possible.\r\n\r\nCurrently, you have been placed on the members queue for approval. You are not yet part of the $$listing_type$$. If in two weeks, you have not yet been notified of your approval and you are not yet listed at the members list, please feel free to email us and check up on your application.\r\n\r\nThe information you submitted to this fanlisting is shown below. Please keep this information, as you will need your password to change your information listed on the $$listing_type$$. If any of this is in error, feel free to update your information at $$fanlisting_url$$/$$fanlisting_update$$.\r\n\r\nName: $$fan_name$$\r\nEmail address: $$fan_email$$\r\nCountry: $$fan_country$$\r\nURL: $$fan_url$$\r\nPassword: $$fan_password$$\r\n\r\nThank you for joining!\r\n\r\nSincerely yours, \r\n$$owner_name$$\r\n\r\n--\r\n$$fanlisting_title$$\r\n$$fanlisting_url$$\r\n', 'Hello, $$fan_name$$,\r\n\r\nThank you for joining $$fanlisting_title$$, a $$listing_type$$ for $$fanlisting_subject$$. You have been moved from the members queue to the fans list, and you should now be able to see your information on the site at $$fanlisting_url$$/$$fanlisting_list$$. Please do not lose the email that was earlier sent to you when you first joined, as it contains your information as well as your password for changing this information, which you can do so by going to $$fanlisting_url$$/$$fanlisting_update$$.\r\n\r\nIf you ever forget your password, you can reset and retrieve your password by going to $$fanlisting_url$$/$$fanlisting_lostpass$$. \r\n\r\nSincerely,\r\n$$owner_name$$\r\n\r\n--\r\n$$fanlisting_title$$\r\n$$fanlisting_url$$\r\n', 'Hello $$fan_name$$,\r\n\r\nYou have received this email because you (or someone else) has recently changed your information on the $$fanlisting_subject$$ $$listing_type$$ ($$fanlisting_url$$). Your new information is below. If this is in error and you did not change your information, please secure your information immediately (especially by changing your password) and tell us immediately of this error.\r\n\r\n(Note: if you did not change your password, the password field will show up as blank. This is not an error; your password will still be the same when you joined or last updated it.)\r\n\r\nName: $$fan_name$$ \r\nEmail address: $$fan_email$$ \r\nCountry: $$fan_country$$ \r\nURL: $$fan_url$$\r\nPassword: $$fan_password$$\r\n\r\nThank you for keeping your information up to date!\r\n\r\nSincerely,\r\n$$owner_name$$\r\n\r\n--\r\n$$fanlisting_title$$ \r\n$$fanlisting_url$$\r\n', 'Hello $$fan_name$$, \r\n\r\nYou have received this email because you are a member of the $$fanlisting_subject$$ $$listing_type$$ and you (or someone else) has recently requested for a password reset on the $$listing_type$$. Your new password is shown below. If this is in error and you did not reset your password, please secure your information immediately and tell us immediately of this error.\r\n\r\nEmail address: $$fan_email$$\r\nPassword: $$fan_password$$\r\n\r\nYou can change your password to something easier to remember by going to the update form at $$fanlisting_url$$/$$fanlisting_update$$\r\n\r\nSincerely,\r\n$$owner_name$$\r\n\r\n--\r\n$$fanlisting_title$$\r\n$$fanlisting_url$$\r\n', '<p><b>$$fan_name$$</b> ($$fan_country$$)<br />\r\n$$fan_email_generic$$ - $$fan_url_generic$$</p>', '<a href=\"$$aff_url$$\" target=_blank><img src=\"$$aff_image$$\" width=\"$$aff_width$$\" height=\"$$aff_height$$\" border=\"0\" alt=\" $$aff_title$$\" title=\"$$aff_title$$\" /></a>', '<blockquote class=stat>Enthusiast mantainer: <a href=\"http://scripts.robotess.net\" target=\"_blank\">Ekaterina</a>\r\n<br />Opened: $$stat_opened$$<br />Last updated: $$stat_updated$$<br />\r\nMember count: $$stat_approved$$, from $$stat_countries$$ countries<br />\r\nPending members: $$stat_pending$$<br />\r\nNewest members: $$stat_newmembers$$<br />\r\nGrowth rate: $$stat_average$$ fans/day</blockquote>', 1, 0, '2010-02-17', 2);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `setting` varchar(255) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `value` mediumtext NOT NULL,
  `help` mediumtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`setting`, `title`, `value`, `help`) VALUES
('affiliates_template', 'Collective affiliates template', '<a href=\"enth3-url\"><img src=\"enth3-image\" width=\"enth3-width\" height=\"enth3-height\" border=\"0\" alt=\" enth3-title\" /></a> ', 'Template for showing collective affiliates.'),
('affiliates_template_footer', 'Affiliates template footer', '</p>', 'Text that is inserted directly after the collective affiliates are shown.'),
('affiliates_template_header', 'Affiliates template header', '<p class=\"center\">', 'Text inserted directly before collective affiliates are shown.'),
('joined_template', 'Joined fanlistings template', '<a href=\"enth3-url\"><img src=\"enth3-image\" width=\"enth3-width\" height=\"enth3-height\" border=\"0\" alt=\" enth3-subject: enth3-desc\" /></a> ', 'Template for showing joined fanlistings.'),
('joined_template_footer', 'Joined template footer', '</p>', 'Text that is inserted directly after the joined listings are shown.'),
('joined_template_header', 'Joined template header', '<p class=\"center\">', 'Text inserted directly before joined listings are shown.'),
('owned_template', 'Owned fanlistings template', '<p class=\"center\"><a href=\"enth3-url\"><img src=\"enth3-image\" width=\"enth3-width\" height=\"enth3-height\" border=\"0\" alt=\" enth3-title\" /></a><br />\r\n<b>enth3-title: enth3-subject</b><br />\r\n<b><a href=\"enth3-url\">enth3-url</a></b><br />\r\nenth3-desc</p>', 'Template for showing owned fanlistings.'),
('owned_template_footer', 'Owned template footer', '</p>', 'owned listings are shown.'),
('owned_template_header', 'Owned template header', '<p class=\"center\">', 'Text inserted directly before owned listings are shown.'),
('owner_name', 'Your name', 'Your Name', 'Your name for outgoing emails.'),
('owner_email', 'Your email', 'user@domain.tld', 'Your email address for outgoing emails.'),
('collective_title', 'Collective Title', 'My collective', 'Your collective title.'),
('collective_url', 'Collective URL', 'http://localhost:8081', 'Web address of your collective.'),
('password', 'Password', '5f4dcc3b5aa765d61d8327deb882cf99', 'The password used to log into this installation of Enthusiast 3.'),
('log_errors', 'Log errors?', 'no', 'Turn error logging on or off.'),
('installation_path', 'Installation Path (Absolute)', '/builds/tfl-php-scripts/enthusiast/public/enthusiast/', 'Installation path (absolute path) for this installation of Enthusiast 3.'),
('root_path_absolute', 'Root absolute path', '/builds/tfl-php-scripts/enthusiast/public/', 'Absolute path of your root directory (i.e., /home/username/public_html/)'),
('root_path_web', 'Root web address', 'http://localhost:8081/', 'Web address of your root directory (i.e.,http://yourdomain.com)'),
('date_format', 'Date format', 'dS F Y', 'Date format (same as PHP variables).'),
('per_page', 'Number of items per page', '30', 'Number of items shown per page on any given view.'),
('mail_settings', 'Mail interface setting', 'mail', 'Which mail interface to use (or PHP&quot;s native mail() function)'),
('sendmail_args', 'Additional sendmail arguments', '', 'Additional parameters to pass to the sendmail.'),
('sendmail_path', 'Sendmail path', '/usr/bin/sendmail', 'The location of the sendmail program on the filesystem. '),
('smtp_host', 'SMTP host', 'mail.mysql:8081', 'The SMTP server to connect to.'),
('smtp_port', 'SMTP port', '25', 'The port to connect to on the SMTP server.'),
('smtp_username', 'SMTP username', '', 'The username to use for SMTP authentication.'),
('smtp_password', 'SMTP password', '', 'The password to use for SMTP authentication.'),
('affiliates_dir', 'Collective Affiliates Directory', '/builds/tfl-php-scripts/enthusiast/public/images/affiliates/', 'Directory where your collective affiliates images (if any) are stored.'),
('joined_images_dir', 'Joined images directory', '/builds/tfl-php-scripts/enthusiast/public/images/joined/', 'Directory where your joined images will be stored. This should be an absolute path, and a trailing slash is important.'),
('owned_images_dir', 'Owned images directory', '/builds/tfl-php-scripts/enthusiast/public/images/owned/', 'Directory where your owned listing images will be stored. This should be an absolute path, and a trailing slash is important.');

-- --------------------------------------------------------

--
-- Table structure for table `subj3`
--

DROP TABLE IF EXISTS `subj3`;
CREATE TABLE `subj3` (
  `email` varchar(64) NOT NULL DEFAULT '',
  `name` varchar(128) NOT NULL DEFAULT '',
  `country` varchar(128) NOT NULL DEFAULT '',
  `url` varchar(255) DEFAULT NULL,
  `pending` tinyint(1) NOT NULL DEFAULT '0',
  `password` varchar(255) NOT NULL DEFAULT '',
  `showemail` tinyint(1) NOT NULL DEFAULT '1',
  `showurl` tinyint(1) NOT NULL DEFAULT '1',
  `added` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Dumping data for table `subj3`
--

INSERT INTO `subj3` (`email`, `name`, `country`, `url`, `pending`, `password`, `showemail`, `showurl`, `added`) VALUES
    ('normalEmail@localhost123456.com', 'Test', 'United States', NULL, 1, '5f4dcc3b5aa765d61d8327deb882cf99', 1, 1, '0000-00-00'),
    ('normalEmailPending@localhost123456.com', 'Test2 Pending', 'United States', NULL, 1, '5f4dcc3b5aa765d61d8327deb882cf99', 1, 1, NULL);

--
-- Table structure for table `tab2`
--

DROP TABLE IF EXISTS `tab2`;
CREATE TABLE `tab2` (
  `email` varchar(64) NOT NULL DEFAULT '',
  `name` varchar(128) NOT NULL DEFAULT '',
  `country` varchar(128) NOT NULL DEFAULT '',
  `url` varchar(255) DEFAULT NULL,
  `pending` tinyint(1) NOT NULL DEFAULT '0',
  `password` varchar(255) NOT NULL DEFAULT '',
  `showemail` tinyint(1) NOT NULL DEFAULT '1',
  `showurl` tinyint(1) NOT NULL DEFAULT '1',
  `added` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP procedure if exists InsertRand;

DELIMITER $$
CREATE PROCEDURE InsertRand(IN NumRows INT, IN EmailId INT, IN Country varchar(15))
    BEGIN
        DECLARE i INT;
        DECLARE email VARCHAR(40);
        SET i = 1;
        START TRANSACTION;
        WHILE i <= NumRows DO
            SET email = CONCAT('email', EmailId, '.', CEIL(RAND() * 100), '.', i, '@loca123456.com');
    		INSERT INTO `tab2` (`email`, `name`, `country`, `url`, `pending`, `password`, `showemail`, `showurl`, `added`) VALUES (email, 'Test', Country, '', 0, '5f4dcc3b5aa765d61d8327deb882cf99', 1, 1, '2019-06-24');
            SET i = i + 1;
        END WHILE;
        COMMIT;
    END$$
DELIMITER ;

CALL InsertRand(500, 1, 'United States');
CALL InsertRand(500, 2, 'Canada');
CALL InsertRand(500, 3, 'England');
CALL InsertRand(500, 4, 'Italy');

INSERT INTO `tab2` (`email`, `name`, `country`, `url`, `pending`, `password`, `showemail`, `showurl`, `added`) VALUES ('fgjdfhghgdifhjfgjghjghd@ujgdghnjjkdf.com', 'Testpending', 'United States', '', 1, '5f4dcc3b5aa765d61d8327deb882cf99', 1, 1, '0000-00-00');
INSERT INTO `tab2` (`email`, `name`, `country`, `url`, `pending`, `password`, `showemail`, `showurl`, `added`) VALUES ('fgjdfhghgdifhjfgd@ujgdghnjjkdf.com', 'Testpending2', 'United States', '', 1, '5f4dcc3b5aa765d61d8327deb882cf99', 1, 1, '0000-00-00');
-- --------------------------------------------------------

--
-- Table structure for table `table1`
--

DROP TABLE IF EXISTS `table1`;
CREATE TABLE `table1` (
  `email` varchar(64) NOT NULL DEFAULT '',
  `name` varchar(128) NOT NULL DEFAULT '',
  `country` varchar(128) NOT NULL DEFAULT '',
  `url` varchar(255) DEFAULT NULL,
  `extra_field` varchar(255) DEFAULT NULL,
  `pending` tinyint(1) NOT NULL DEFAULT '0',
  `password` varchar(255) NOT NULL DEFAULT '',
  `showemail` tinyint(1) NOT NULL DEFAULT '1',
  `showurl` tinyint(1) NOT NULL DEFAULT '1',
  `added` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `table1`
--

INSERT INTO `table1` (`email`, `name`, `country`, `url`, `extra_field`, `pending`, `password`, `showemail`, `showurl`, `added`) VALUES
('normalEmail@localhost123456.com', 'Test', 'United States', '', NULL, 0, '5f4dcc3b5aa765d61d8327deb882cf99', 1, 1, '2019-06-24'),
('normalEmailPending@localhost123456.com', 'Test2 Pending', 'United States', '', NULL, 1, '5f4dcc3b5aa765d61d8327deb882cf99', 1, 1, NULL),
('with+plus@localhost123456.com', 'Plus Pending', 'United States', '', NULL, 1, '5f4dcc3b5aa765d61d8327deb882cf99', 1, 1, NULL),
('pendinguser@localhost123456.com', 'Pending', 'United States', '', NULL, 1, '5f4dcc3b5aa765d61d8327deb882cf99', 1, 1, NULL),
('user1@user.com', 'abc', 'United States', '', NULL, 0, '5f4dcc3b5aa765d61d8327deb882cf99', 1, 1, '2019-01-24'),
('user2@user.com', 'cab', 'United States', '', NULL, 0, '5f4dcc3b5aa765d61d8327deb882cf99', 1, 1, '2019-02-24'),
('user3@user.com', 'abc', 'Canada', '', NULL, 0, '5f4dcc3b5aa765d61d8327deb882cf99', 1, 1, '2019-05-24'),
('user4@user.com', 'cab', 'England', '', NULL, 0, '5f4dcc3b5aa765d61d8327deb882cf99', 1, 1, '2019-03-24');

-- --------------------------------------------------------

--
-- Table structure for table `table1_affiliates`
--

DROP TABLE IF EXISTS `table1_affiliates`;
CREATE TABLE `table1_affiliates` (
  `affiliateid` int(5) NOT NULL,
  `url` varchar(255) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `imagefile` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL DEFAULT '',
  `added` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `affiliates`
--
ALTER TABLE `affiliates`
  ADD PRIMARY KEY (`affiliateid`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`catid`);

--
-- Indexes for table `emailtemplate`
--
ALTER TABLE `emailtemplate`
  ADD PRIMARY KEY (`templateid`);

--
-- Indexes for table `joined`
--
ALTER TABLE `joined`
  ADD PRIMARY KEY (`joinedid`);
ALTER TABLE `joined` ADD FULLTEXT KEY `subject` (`subject`,`desc`,`comments`);

--
-- Indexes for table `owned`
--
ALTER TABLE `owned`
  ADD PRIMARY KEY (`listingid`);
ALTER TABLE `owned` ADD FULLTEXT KEY `title` (`title`,`subject`,`url`,`desc`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`setting`);

--
-- Indexes for table `subj3`
--
ALTER TABLE `subj3`
  ADD PRIMARY KEY (`email`);
ALTER TABLE `subj3` ADD FULLTEXT KEY `email` (`email`,`name`,`country`,`url`);

--
-- Indexes for table `tab2`
--
ALTER TABLE `tab2`
  ADD PRIMARY KEY (`email`);
ALTER TABLE `tab2` ADD FULLTEXT KEY `email` (`email`,`name`,`country`,`url`);

--
-- Indexes for table `table1`
--
ALTER TABLE `table1`
  ADD PRIMARY KEY (`email`);
ALTER TABLE `table1` ADD FULLTEXT KEY `email` (`email`,`name`,`country`,`url`);

--
-- Indexes for table `table1_affiliates`
--
ALTER TABLE `table1_affiliates`
  ADD PRIMARY KEY (`affiliateid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `affiliates`
--
ALTER TABLE `affiliates`
  MODIFY `affiliateid` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `catid` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `emailtemplate`
--
ALTER TABLE `emailtemplate`
  MODIFY `templateid` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `joined`
--
ALTER TABLE `joined`
  MODIFY `joinedid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `owned`
--
ALTER TABLE `owned`
  MODIFY `listingid` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `table1_affiliates`
--
ALTER TABLE `table1_affiliates`
  MODIFY `affiliateid` int(5) NOT NULL AUTO_INCREMENT;
COMMIT;
