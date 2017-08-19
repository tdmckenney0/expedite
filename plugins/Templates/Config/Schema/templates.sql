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

-- Dumping structure for table expedite.templates
CREATE TABLE IF NOT EXISTS `templates` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `template_type_id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `body` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `template_type_id` (`template_type_id`),
  CONSTRAINT `FK_templates_template_types` FOREIGN KEY (`template_type_id`) REFERENCES `template_types` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Email Templates that are pulled from the system. First Isolated Plugin.';

-- Data exporting was unselected.


-- Dumping structure for table expedite.template_types
CREATE TABLE IF NOT EXISTS `template_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='This stores the template Types';

-- Data exporting was unselected.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
