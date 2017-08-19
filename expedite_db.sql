-- --------------------------------------------------------
-- Host:                         cmb1mp002
-- Server version:               5.5.32-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             9.3.0.5107
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for expedite_dev
CREATE DATABASE IF NOT EXISTS `expedite` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `expedite`;

-- Dumping structure for table expedite_dev.expedite_logs
CREATE TABLE IF NOT EXISTS `expedite_logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NOT NULL,
  `created` datetime NOT NULL,
  `message` text NOT NULL,
  `notes` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1 COMMENT='This stores the new-and-improved Expedite Logging Feature. ';

-- Data exporting was unselected.
-- Dumping structure for table expedite_dev.cake_sessions
CREATE TABLE IF NOT EXISTS `cake_sessions` (
  `id` varchar(255) NOT NULL DEFAULT '',
  `data` text,
  `expires` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table expedite_dev.documents
CREATE TABLE IF NOT EXISTS `documents` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Unique ID',
  `user_id` int(10) unsigned DEFAULT NULL COMMENT 'Owner/Uploader/Creator',
  `usage` smallint(5) unsigned NOT NULL DEFAULT '1' COMMENT 'This stores the usage counter. If > 0, do not delete.',
  `filename` varchar(255) NOT NULL COMMENT 'SHA-256 Name',
  `description` varchar(255) NOT NULL COMMENT 'Either Manual, or Automated Entry',
  `created` datetime NOT NULL COMMENT 'Date Added to the System',
  `mimetype` varchar(255) NOT NULL COMMENT 'Internet Media Type',
  PRIMARY KEY (`id`),
  UNIQUE KEY `filename` (`filename`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `documents_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2094 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT COMMENT='This is the new File API that replaces using in-row file names and repeated code. This will serve, store, and index all binary files.';

-- Data exporting was unselected.
-- Dumping structure for table expedite_dev.document_types
CREATE TABLE IF NOT EXISTS `document_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COMMENT='This stores the DocumentType model for the Documents Module.';

-- Data exporting was unselected.
-- Dumping structure for table expedite_dev.messages
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL COMMENT 'NULL means automated',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `sent` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `subject` varchar(255) NOT NULL,
  `body` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `FK_messages_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3238 DEFAULT CHARSET=latin1 COMMENT='This is the framework for the expedite email gateway. ';

-- Data exporting was unselected.
-- Dumping structure for table expedite_dev.message_attachments
CREATE TABLE IF NOT EXISTS `message_attachments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `message_id` int(10) unsigned NOT NULL,
  `filename` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `message_id` (`message_id`),
  CONSTRAINT `FK_message_attachments_messages` FOREIGN KEY (`message_id`) REFERENCES `messages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1151 DEFAULT CHARSET=latin1 COMMENT='This stores the attachment interface for the Documents module.';

-- Data exporting was unselected.
-- Dumping structure for table expedite_dev.message_blind_copies
CREATE TABLE IF NOT EXISTS `message_blind_copies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `message_id` int(10) unsigned NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `message_id` (`message_id`),
  CONSTRAINT `FK_message_blind_copies_messages` FOREIGN KEY (`message_id`) REFERENCES `messages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT COMMENT='This stores the ''to'' part of the message';

-- Data exporting was unselected.
-- Dumping structure for table expedite_dev.message_copies
CREATE TABLE IF NOT EXISTS `message_copies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `message_id` int(10) unsigned NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `message_id` (`message_id`),
  CONSTRAINT `FK_message_copies_messages` FOREIGN KEY (`message_id`) REFERENCES `messages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1421 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT COMMENT='This stores the ''to'' part of the message';

-- Data exporting was unselected.
-- Dumping structure for table expedite_dev.message_recipients
CREATE TABLE IF NOT EXISTS `message_recipients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `message_id` int(10) unsigned NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `message_id` (`message_id`),
  CONSTRAINT `FK__messages` FOREIGN KEY (`message_id`) REFERENCES `messages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5172 DEFAULT CHARSET=latin1 COMMENT='This stores the ''to'' part of the message';

-- Data exporting was unselected.
-- Dumping structure for table expedite_dev.offices
CREATE TABLE IF NOT EXISTS `offices` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `address` varchar(50) NOT NULL,
  `address_2` varchar(50) DEFAULT NULL,
  `city` varchar(50) NOT NULL,
  `state` char(2) NOT NULL,
  `zip` varchar(10) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `fax` varchar(15) DEFAULT NULL,
  `notes` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `city` (`city`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1 COMMENT='This stores our Office Locations, making this the Hub of the Office Module. ';

-- Data exporting was unselected.
-- Dumping structure for table expedite_dev.regions
CREATE TABLE IF NOT EXISTS `regions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table expedite_dev.requested_urls
CREATE TABLE IF NOT EXISTS `requested_urls` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_group_id` int(10) unsigned DEFAULT NULL,
  `controller` varchar(100) NOT NULL,
  `action` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_group_id_controller_action` (`user_group_id`,`controller`,`action`),
  KEY `user_group_id` (`user_group_id`),
  CONSTRAINT `FK_requested_urls_user_groups` FOREIGN KEY (`user_group_id`) REFERENCES `user_groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=latin1 COMMENT='This is what controls the permission stack. Replacing the CakePHP ACL as this system will be tailored to our needs. ';

-- Data exporting was unselected.
-- Dumping structure for table expedite_dev.support_requests
CREATE TABLE IF NOT EXISTS `support_requests` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `support_request_type_id` int(10) unsigned NOT NULL,
  `support_request_status_id` int(10) unsigned NOT NULL,
  `requested_user_id` int(10) unsigned NOT NULL,
  `closing_user_id` int(10) unsigned DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `closing_date` datetime DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `notes` text,
  `file` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `support_request_type_id` (`support_request_type_id`),
  KEY `requested_user_id` (`requested_user_id`),
  KEY `closing_user_id` (`closing_user_id`),
  KEY `support_request_status_id` (`support_request_status_id`),
  CONSTRAINT `FK_support_requests_support_request_statuses` FOREIGN KEY (`support_request_status_id`) REFERENCES `support_request_statuses` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_support_requests_support_request_types` FOREIGN KEY (`support_request_type_id`) REFERENCES `support_request_types` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_support_requests_users` FOREIGN KEY (`requested_user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_support_requests_users_2` FOREIGN KEY (`closing_user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=latin1 COMMENT='This stores all the Support Requests, Todo, Etc from the System';

-- Data exporting was unselected.
-- Dumping structure for table expedite_dev.support_request_statuses
CREATE TABLE IF NOT EXISTS `support_request_statuses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `css_class` varchar(255) DEFAULT NULL,
  `sort` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `css_class` (`css_class`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COMMENT='This stores the status of a support request';

-- Data exporting was unselected.
-- Dumping structure for table expedite_dev.support_request_types
CREATE TABLE IF NOT EXISTS `support_request_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COMMENT='This stores the Types of support requests';

-- Data exporting was unselected.
-- Dumping structure for table expedite_dev.surveys
CREATE TABLE IF NOT EXISTS `surveys` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COMMENT='This is the primary table for the Survey Module.';

-- Data exporting was unselected.
-- Dumping structure for table expedite_dev.survey_questions
CREATE TABLE IF NOT EXISTS `survey_questions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `survey_section_id` int(10) unsigned NOT NULL,
  `survey_question_type_id` int(10) unsigned NOT NULL,
  `question` varchar(300) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `survey_id` (`survey_section_id`),
  KEY `survey_question_type_id` (`survey_question_type_id`),
  CONSTRAINT `FK_survey_questions_survey_question_types` FOREIGN KEY (`survey_question_type_id`) REFERENCES `survey_question_types` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_survey_questions_survey_sections` FOREIGN KEY (`survey_section_id`) REFERENCES `survey_sections` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1 COMMENT='This stores the questions for the survey module.';

-- Data exporting was unselected.
-- Dumping structure for table expedite_dev.survey_question_choices
CREATE TABLE IF NOT EXISTS `survey_question_choices` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `survey_question_id` int(10) unsigned NOT NULL,
  `choice` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `survey_question_id` (`survey_question_id`),
  CONSTRAINT `FK_survey_question_choices_survey_questions` FOREIGN KEY (`survey_question_id`) REFERENCES `survey_questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1 COMMENT='This stores the choices for questions that need them. ';

-- Data exporting was unselected.
-- Dumping structure for table expedite_dev.survey_question_responses
CREATE TABLE IF NOT EXISTS `survey_question_responses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `survey_question_id` int(10) unsigned NOT NULL,
  `response` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `survey_question_id` (`survey_question_id`),
  CONSTRAINT `FK_survey_question_reponses_survey_questions` FOREIGN KEY (`survey_question_id`) REFERENCES `survey_questions` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_survey_question_reponses_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='This stores the basic responses of the survey as a string. This is not meant for statistical analysis. ';

-- Data exporting was unselected.
-- Dumping structure for table expedite_dev.survey_question_types
CREATE TABLE IF NOT EXISTS `survey_question_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COMMENT='Determines how a question should be displayed and configured. ';

-- Data exporting was unselected.
-- Dumping structure for table expedite_dev.survey_sections
CREATE TABLE IF NOT EXISTS `survey_sections` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `survey_id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `survey_id` (`survey_id`),
  CONSTRAINT `FK__surveys` FOREIGN KEY (`survey_id`) REFERENCES `surveys` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COMMENT='SurveySection divides the questions into groups to better convey subject matter.';

-- Data exporting was unselected.
-- Dumping structure for table expedite_dev.templates
CREATE TABLE IF NOT EXISTS `templates` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `template_type_id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `body` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `template_type_id` (`template_type_id`),
  CONSTRAINT `FK_templates_template_types` FOREIGN KEY (`template_type_id`) REFERENCES `template_types` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 COMMENT='Email Templates that are pulled from the system. First Isolated Plugin.';

-- Data exporting was unselected.
-- Dumping structure for table expedite_dev.template_types
CREATE TABLE IF NOT EXISTS `template_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COMMENT='This stores the template Types';

-- Data exporting was unselected.
-- Dumping structure for table expedite_dev.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `is_superuser` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_manager` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `fax` varchar(15) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `show_tooltips` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `theme` varchar(255) NOT NULL DEFAULT 'expedite',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table expedite_dev.users_offices
CREATE TABLE IF NOT EXISTS `users_offices` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `office_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `office_id` (`office_id`),
  CONSTRAINT `FK_users_offices_offices` FOREIGN KEY (`office_id`) REFERENCES `offices` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_users_offices_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=latin1 COMMENT='This stores the relation between Users and Offices. ';

-- Data exporting was unselected.
-- Dumping structure for table expedite_dev.users_user_groups
CREATE TABLE IF NOT EXISTS `users_user_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `user_group_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `user_group_id` (`user_group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=198 DEFAULT CHARSET=latin1 COMMENT='Stores the HATBM relation between User and UserGroup';

-- Data exporting was unselected.
-- Dumping structure for table expedite_dev.user_groups
CREATE TABLE IF NOT EXISTS `user_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1 COMMENT='This stores the UserGroup model, which handles what users can see what. ';

-- Data exporting was unselected.
-- Dumping structure for table expedite_dev.user_group_permissions
CREATE TABLE IF NOT EXISTS `user_group_permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_group_id` int(10) unsigned DEFAULT NULL COMMENT 'NULL means it applies to all groups',
  `plugin` varchar(255) DEFAULT NULL COMMENT 'NULL means it applies to all plugins',
  `controller` varchar(255) DEFAULT NULL COMMENT 'NULL means it applies to all controllers',
  `action` varchar(255) DEFAULT NULL COMMENT 'NULL means it applies to all actions',
  PRIMARY KEY (`id`),
  KEY `user_group_id` (`user_group_id`),
  CONSTRAINT `FK_user_group_permissions_user_groups` FOREIGN KEY (`user_group_id`) REFERENCES `user_groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Stores the permission set for a UserGroup. Replaces RequestedURL. ';

-- Data exporting was unselected.
-- Dumping structure for table expedite_dev.user_tasks
CREATE TABLE IF NOT EXISTS `user_tasks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `user_task_status_id` int(10) unsigned NOT NULL,
  `client_task_id` int(10) unsigned NOT NULL,
  `body` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `user_task_status_id` (`user_task_status_id`),
  KEY `client_task_id` (`client_task_id`),
  CONSTRAINT `FK_user_tasks_client_tasks` FOREIGN KEY (`client_task_id`) REFERENCES `client_tasks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_user_tasks_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_user_tasks_user_task_statuses` FOREIGN KEY (`user_task_status_id`) REFERENCES `user_task_statuses` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COMMENT='This stores tasks that are assigned to the user.';

-- Data exporting was unselected.
-- Dumping structure for table expedite_dev.user_task_statuses
CREATE TABLE IF NOT EXISTS `user_task_statuses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COMMENT='This stores the Status of the UserTask';

-- Data exporting was unselected.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
