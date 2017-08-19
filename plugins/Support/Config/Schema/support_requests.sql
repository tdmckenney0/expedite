-- --------------------------------------------------------
-- Host:                         cmb1mp002
-- Server version:               5.5.32-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             8.3.0.4817
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table expedite.support_requests
CREATE TABLE IF NOT EXISTS `support_requests` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `support_request_type_id` int(10) unsigned NOT NULL,
  `requested_user_id` int(10) unsigned NOT NULL,
  `closing_user_id` int(10) unsigned DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `is_closed` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `pinned` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `closing_date` datetime DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `notes` text,
  `file` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `support_request_type_id` (`support_request_type_id`),
  KEY `requested_user_id` (`requested_user_id`),
  KEY `closing_user_id` (`closing_user_id`),
  CONSTRAINT `FK_support_requests_support_request_types` FOREIGN KEY (`support_request_type_id`) REFERENCES `support_request_types` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_support_requests_users` FOREIGN KEY (`requested_user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_support_requests_users_2` FOREIGN KEY (`closing_user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='This stores all the Support Requests, Todo, Etc from the System';

-- Data exporting was unselected.


-- Dumping structure for table expedite.support_request_types
CREATE TABLE IF NOT EXISTS `support_request_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='This stores the Types of support requests';

-- Data exporting was unselected.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
