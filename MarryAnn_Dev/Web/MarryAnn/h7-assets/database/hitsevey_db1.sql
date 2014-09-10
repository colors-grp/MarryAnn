-- phpMyAdmin SQL Dump
-- version 4.1.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 10, 2014 at 02:21 AM
-- Server version: 5.5.37-cll
-- PHP Version: 5.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `hitsevey_db1`
--

-- --------------------------------------------------------

--
-- Table structure for table `active_scoreboard`
--

DROP TABLE IF EXISTS `active_scoreboard`;
CREATE TABLE IF NOT EXISTS `active_scoreboard` (
  `category_id` int(11) NOT NULL,
  `active_table` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `activity_type`
--

DROP TABLE IF EXISTS `activity_type`;
CREATE TABLE IF NOT EXISTS `activity_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `activity` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `card`
--

DROP TABLE IF EXISTS `card`;
CREATE TABLE IF NOT EXISTS `card` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `category_id` int(11) NOT NULL,
  `created` date DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `type_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`,`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `cardTemp`
--

DROP TABLE IF EXISTS `cardTemp`;
CREATE TABLE IF NOT EXISTS `cardTemp` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `created` date DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `type_id` int(11) NOT NULL DEFAULT '0' COMMENT '0->normal card,1->silver card ...'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `card_type`
--

DROP TABLE IF EXISTS `card_type`;
CREATE TABLE IF NOT EXISTS `card_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `created` date DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `total_score` int(11) NOT NULL,
  `num_of_cards` int(11) NOT NULL,
  `rank` int(11) NOT NULL,
  `color` varchar(7) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `category_card_game`
--

DROP TABLE IF EXISTS `category_card_game`;
CREATE TABLE IF NOT EXISTS `category_card_game` (
  `category_id` int(11) NOT NULL,
  `card_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  UNIQUE KEY `category_id` (`category_id`,`card_id`,`game_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `category_rank`
--

DROP TABLE IF EXISTS `category_rank`;
CREATE TABLE IF NOT EXISTS `category_rank` (
  `category_id` int(11) NOT NULL,
  `rank_id` int(11) NOT NULL,
  UNIQUE KEY `category_id` (`category_id`,`rank_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

DROP TABLE IF EXISTS `ci_sessions`;
CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `competition_round`
--

DROP TABLE IF EXISTS `competition_round`;
CREATE TABLE IF NOT EXISTS `competition_round` (
  `competition_id` int(11) NOT NULL,
  `round_id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  UNIQUE KEY `round_id` (`round_id`,`competition_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `credit_price`
--

DROP TABLE IF EXISTS `credit_price`;
CREATE TABLE IF NOT EXISTS `credit_price` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `credit` int(11) NOT NULL COMMENT 'hit 7 credit point',
  `price` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `duration`
--

DROP TABLE IF EXISTS `duration`;
CREATE TABLE IF NOT EXISTS `duration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `event_id` int(11) NOT NULL,
  `event_type` varchar(280) NOT NULL,
  `event_value` int(11) NOT NULL,
  `max_credit` int(11) NOT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `game`
--

DROP TABLE IF EXISTS `game`;
CREATE TABLE IF NOT EXISTS `game` (
  `game_id` int(11) NOT NULL AUTO_INCREMENT,
  `game_type` varchar(50) NOT NULL,
  PRIMARY KEY (`game_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=141 ;

-- --------------------------------------------------------

--
-- Table structure for table `game_object_positions`
--

DROP TABLE IF EXISTS `game_object_positions`;
CREATE TABLE IF NOT EXISTS `game_object_positions` (
  `game_id` int(11) NOT NULL,
  `width` int(11) NOT NULL,
  `top` int(11) NOT NULL,
  `left` int(11) NOT NULL,
  `bottle_top` int(11) NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `iphone4x` int(11) NOT NULL,
  `iphone4y` int(11) NOT NULL,
  `iphone5x` int(11) NOT NULL,
  `iphone5y` int(11) NOT NULL,
  UNIQUE KEY `game_id` (`game_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `game_question`
--

DROP TABLE IF EXISTS `game_question`;
CREATE TABLE IF NOT EXISTS `game_question` (
  `game_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`game_id`,`question_id`),
  KEY `question_id` (`question_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=211 ;

-- --------------------------------------------------------

--
-- Table structure for table `game_words`
--

DROP TABLE IF EXISTS `game_words`;
CREATE TABLE IF NOT EXISTS `game_words` (
  `game_id` int(11) NOT NULL,
  `words` text CHARACTER SET utf8 NOT NULL,
  UNIQUE KEY `game_id` (`game_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

DROP TABLE IF EXISTS `media`;
CREATE TABLE IF NOT EXISTS `media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `created` date DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT NULL,
  `card_id` int(11) NOT NULL,
  `type` enum('video','audio','image') NOT NULL,
  `file` varchar(50) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

DROP TABLE IF EXISTS `notification`;
CREATE TABLE IF NOT EXISTS `notification` (
  `notification_id` int(11) NOT NULL AUTO_INCREMENT,
  `notification_type` varchar(280) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` varchar(500) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`notification_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `pack`
--

DROP TABLE IF EXISTS `pack`;
CREATE TABLE IF NOT EXISTS `pack` (
  `pack_id` int(11) NOT NULL,
  `pack_type` int(11) NOT NULL,
  `cards_num` int(11) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `pack_price` int(11) NOT NULL,
  PRIMARY KEY (`pack_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `platform_credit`
--

DROP TABLE IF EXISTS `platform_credit`;
CREATE TABLE IF NOT EXISTS `platform_credit` (
  `platform_id` int(11) NOT NULL,
  `day` int(11) NOT NULL,
  `platform_name` varchar(280) NOT NULL,
  `daily_credit` int(11) NOT NULL,
  UNIQUE KEY `platform_id` (`platform_id`,`day`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `platform_type`
--

DROP TABLE IF EXISTS `platform_type`;
CREATE TABLE IF NOT EXISTS `platform_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `round` enum('Daily','Weekly','Monthly','Annual') NOT NULL,
  `url` varchar(255) NOT NULL,
  `start_credit` varchar(6) NOT NULL,
  `type` varchar(12) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `puzzle`
--

DROP TABLE IF EXISTS `puzzle`;
CREATE TABLE IF NOT EXISTS `puzzle` (
  `game_id` int(11) NOT NULL,
  `image_name` varchar(50) NOT NULL,
  `image_length` int(11) NOT NULL,
  `image_width` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  PRIMARY KEY (`game_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

DROP TABLE IF EXISTS `question`;
CREATE TABLE IF NOT EXISTS `question` (
  `question_id` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(255) NOT NULL,
  `choice1` varchar(255) NOT NULL,
  `choice2` varchar(255) NOT NULL,
  `choice3` varchar(255) NOT NULL,
  `choice4` varchar(255) NOT NULL,
  `correct_answer` enum('0','1','2','3') NOT NULL,
  PRIMARY KEY (`question_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=181 ;

-- --------------------------------------------------------

--
-- Table structure for table `rank`
--

DROP TABLE IF EXISTS `rank`;
CREATE TABLE IF NOT EXISTS `rank` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

-- --------------------------------------------------------

--
-- Table structure for table `ref_country`
--

DROP TABLE IF EXISTS `ref_country`;
CREATE TABLE IF NOT EXISTS `ref_country` (
  `alpha2` char(2) NOT NULL,
  `alpha3` char(3) NOT NULL,
  `numeric` varchar(3) NOT NULL,
  `country` varchar(80) NOT NULL,
  PRIMARY KEY (`alpha2`),
  UNIQUE KEY `alpha3` (`alpha3`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ref_currency`
--

DROP TABLE IF EXISTS `ref_currency`;
CREATE TABLE IF NOT EXISTS `ref_currency` (
  `alpha` char(3) NOT NULL,
  `numeric` varchar(3) DEFAULT NULL,
  `currency` varchar(80) NOT NULL,
  PRIMARY KEY (`alpha`),
  KEY `numeric` (`numeric`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `ref_iptocountry`
--

DROP TABLE IF EXISTS `ref_iptocountry`;
CREATE TABLE IF NOT EXISTS `ref_iptocountry` (
  `ip_from` int(10) unsigned NOT NULL,
  `ip_to` int(10) unsigned NOT NULL,
  `country_code` char(2) NOT NULL,
  KEY `country_code` (`country_code`),
  KEY `ip_to` (`ip_to`),
  KEY `ip_from` (`ip_from`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ref_language`
--

DROP TABLE IF EXISTS `ref_language`;
CREATE TABLE IF NOT EXISTS `ref_language` (
  `one` char(2) NOT NULL,
  `two` char(3) NOT NULL,
  `language` varchar(120) NOT NULL,
  `native` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`one`),
  KEY `two` (`two`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ref_zoneinfo`
--

DROP TABLE IF EXISTS `ref_zoneinfo`;
CREATE TABLE IF NOT EXISTS `ref_zoneinfo` (
  `zoneinfo` varchar(40) NOT NULL,
  `offset` varchar(16) DEFAULT NULL,
  `summer` varchar(16) DEFAULT NULL,
  `country` char(2) NOT NULL,
  `cicode` varchar(6) NOT NULL,
  `cicodesummer` varchar(6) DEFAULT NULL,
  PRIMARY KEY (`zoneinfo`),
  KEY `country` (`country`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

DROP TABLE IF EXISTS `request`;
CREATE TABLE IF NOT EXISTS `request` (
  `request_id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `request_demand` varchar(500) NOT NULL,
  `request_offer` varchar(500) NOT NULL,
  `message` varchar(500) NOT NULL,
  `status` int(11) NOT NULL,
  `request_date` datetime NOT NULL,
  `demand_value` int(11) NOT NULL,
  `offer_value` int(11) NOT NULL,
  PRIMARY KEY (`request_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Table structure for table `singers_scoreboard`
--

DROP TABLE IF EXISTS `temp_scoreboard`;
CREATE TABLE IF NOT EXISTS `temp_scoreboard` (
  `rank` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `user_name` varchar(32) NOT NULL,
  `score` int(10) unsigned NOT NULL DEFAULT '0',
  `change` char(1) NOT NULL DEFAULT 'n'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tb_adv`
--

DROP TABLE IF EXISTS `tb_adv`;
CREATE TABLE IF NOT EXISTS `tb_adv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `company` varchar(150) NOT NULL,
  `comment` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
CREATE TABLE IF NOT EXISTS `transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `card_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `price_paid` int(11) NOT NULL,
  `created` date DEFAULT NULL,
  `payment_method_id` int(11) DEFAULT NULL,
  `score` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `trsnsaction_type`
--

DROP TABLE IF EXISTS `trsnsaction_type`;
CREATE TABLE IF NOT EXISTS `trsnsaction_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tv_guide`
--

DROP TABLE IF EXISTS `tv_guide`;
CREATE TABLE IF NOT EXISTS `tv_guide` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=112 ;

-- --------------------------------------------------------

--
-- Table structure for table `tv_guide_detail`
--

DROP TABLE IF EXISTS `tv_guide_detail`;
CREATE TABLE IF NOT EXISTS `tv_guide_detail` (
  `show_id` int(11) NOT NULL,
  `channel_name` varchar(50) NOT NULL,
  `time` varchar(15) NOT NULL,
  KEY `show_id` (`show_id`),
  KEY `show_id_2` (`show_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `fb_id` varchar(50) NOT NULL,
  `credit` int(11) NOT NULL DEFAULT '0',
  `email` varchar(50) DEFAULT NULL,
  `created` date DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT NULL,
  `type` enum('user','admin') NOT NULL DEFAULT 'user',
  `gender` enum('male','female') DEFAULT NULL,
  `cover_id` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_activity`
--

DROP TABLE IF EXISTS `user_activity`;
CREATE TABLE IF NOT EXISTS `user_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL,
  `time` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=485 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_card`
--

DROP TABLE IF EXISTS `user_card`;
CREATE TABLE IF NOT EXISTS `user_card` (
  `card_serial` int(11) NOT NULL AUTO_INCREMENT,
  `card_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `card_state` int(11) NOT NULL,
  PRIMARY KEY (`card_serial`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=449 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_category`
--

DROP TABLE IF EXISTS `user_category`;
CREATE TABLE IF NOT EXISTS `user_category` (
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `created` date DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT NULL,
  `score` int(11) NOT NULL DEFAULT '0',
  `change` enum('up','down','unchanged') NOT NULL,
  `num_of_cards` int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY `user_id` (`user_id`,`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_day`
--

DROP TABLE IF EXISTS `user_day`;
CREATE TABLE IF NOT EXISTS `user_day` (
  `user_id` int(11) NOT NULL,
  `lastsignedin` datetime NOT NULL,
  `days` int(11) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_events`
--

DROP TABLE IF EXISTS `user_events`;
CREATE TABLE IF NOT EXISTS `user_events` (
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `credit_won` int(11) NOT NULL,
  UNIQUE KEY `user_id` (`user_id`,`event_id`,`date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_game`
--

DROP TABLE IF EXISTS `user_game`;
CREATE TABLE IF NOT EXISTS `user_game` (
  `user_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `max_score` enum('yes','no') NOT NULL DEFAULT 'no',
  `time` varchar(50) NOT NULL,
  PRIMARY KEY (`user_id`,`game_id`,`score`,`time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_gift_cards`
--

DROP TABLE IF EXISTS `user_gift_cards`;
CREATE TABLE IF NOT EXISTS `user_gift_cards` (
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `card_id` int(11) NOT NULL,
  `seen` tinyint(1) NOT NULL,
  `date` date NOT NULL,
  UNIQUE KEY `sender_id` (`sender_id`,`receiver_id`,`date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_old`
--

DROP TABLE IF EXISTS `user_old`;
CREATE TABLE IF NOT EXISTS `user_old` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `fb_id` varchar(50) NOT NULL,
  `credit` int(11) NOT NULL DEFAULT '0',
  `email` varchar(50) DEFAULT NULL,
  `created` date DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT NULL,
  `type` enum('user','admin') NOT NULL DEFAULT 'user',
  `gender` enum('male','female') DEFAULT NULL,
  `cover_id` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_pack`
--

DROP TABLE IF EXISTS `user_pack`;
CREATE TABLE IF NOT EXISTS `user_pack` (
  `user_id` int(11) NOT NULL,
  `pack_id` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  UNIQUE KEY `user_id` (`user_id`,`pack_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_request_locks`
--

DROP TABLE IF EXISTS `user_request_locks`;
CREATE TABLE IF NOT EXISTS `user_request_locks` (
  `user_id` int(11) NOT NULL,
  `lock` int(11) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
