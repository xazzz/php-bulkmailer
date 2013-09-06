# ************************************************************
# Sequel Pro SQL dump
# Version 3408
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.5.29)
# Database: bulkemails
# Generation Time: 2013-06-14 09:19:50 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table files
# ------------------------------------------------------------

DROP TABLE IF EXISTS `files`;

CREATE TABLE `bulkmailer_files` (
  `file_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `file_guid` char(32) DEFAULT NULL,
  `file_name` varchar(256) DEFAULT NULL,
  `file_extension` varchar(32) DEFAULT NULL,
  `file_created` int(11) DEFAULT NULL,
  `file_processed` int(11) DEFAULT '0',
  PRIMARY KEY (`file_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table requests
# ------------------------------------------------------------

DROP TABLE IF EXISTS `requests`;

CREATE TABLE `bulkmailer_requests` (
  `request_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `request_guid` char(32) DEFAULT NULL,
  `file_guid` char(32) DEFAULT NULL,
  `request_email` varchar(128) DEFAULT NULL,
  `request_company` varchar(256) DEFAULT NULL,
  `request_contact_person` varchar(128) DEFAULT NULL,
  `request_location` varchar(512) DEFAULT NULL,
  `request_product1` decimal(11,2) DEFAULT NULL,
  `request_product2` decimal(11,2) DEFAULT NULL,
  `request_product3` decimal(11,2) DEFAULT NULL,
  `request_product4` decimal(11,2) DEFAULT NULL,
  `request_created` int(11) DEFAULT NULL,
  PRIMARY KEY (`request_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
