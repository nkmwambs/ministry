-- Adminer 4.8.1 MySQL 9.0.1 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `assemblies`;
CREATE TABLE `assemblies` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `planted_at` date NOT NULL,
  `location` varchar(200) NOT NULL,
  `entity_id` int NOT NULL COMMENT 'Assemblies belong to lowest entity which belong to level 1 hierarchy',
  `assembly_leader` int DEFAULT NULL,
  `is_active` enum('yes','no') DEFAULT 'yes',
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `entity_id` (`entity_id`),
  CONSTRAINT `assemblies_ibfk_1` FOREIGN KEY (`entity_id`) REFERENCES `entities` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `attendances`;
CREATE TABLE `attendances` (
  `id` int NOT NULL AUTO_INCREMENT,
  `member_id` int NOT NULL,
  `meeting_id` int NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`),
  KEY `meeting_id` (`meeting_id`),
  CONSTRAINT `attendances_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`),
  CONSTRAINT `attendances_ibfk_2` FOREIGN KEY (`meeting_id`) REFERENCES `meetings` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `collections`;
CREATE TABLE `collections` (
  `id` int NOT NULL AUTO_INCREMENT,
  `return_date` datetime NOT NULL,
  `period_start_date` datetime NOT NULL,
  `period_end_date` datetime NOT NULL,
  `revenue_id` int DEFAULT NULL,
  `assembly_id` int NOT NULL,
  `amount` decimal(50,2) NOT NULL,
  `status` enum('submitted','approved') NOT NULL DEFAULT 'submitted',
  `collection_reference` longtext NOT NULL,
  `description` longtext NOT NULL,
  `collection_method` enum('banking','mobile','in-person') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'in-person',
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int NOT NULL,
  `deleted_at` datetime NOT NULL,
  `deleted_by` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `revenue_id` (`revenue_id`),
  KEY `assembly_id` (`assembly_id`),
  CONSTRAINT `collections_ibfk_1` FOREIGN KEY (`revenue_id`) REFERENCES `revenues` (`id`),
  CONSTRAINT `collections_ibfk_2` FOREIGN KEY (`assembly_id`) REFERENCES `assemblies` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


SET NAMES utf8mb4;

DROP TABLE IF EXISTS `collectiontypes`;
CREATE TABLE `collectiontypes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `denomination_id` int NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` longtext NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int NOT NULL,
  `deleted_at` datetime NOT NULL,
  `deleted_by` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `denomination_id` (`denomination_id`),
  CONSTRAINT `collectiontypes_ibfk_1` FOREIGN KEY (`denomination_id`) REFERENCES `denominations` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `customfields`;
CREATE TABLE `customfields` (
  `id` int NOT NULL AUTO_INCREMENT,
  `denomination_id` int DEFAULT NULL,
  `field_name` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `table_name` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `type` enum('string','text','float','date','datetime','timestamp','password','numeric','email','dropdown') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'string',
  `options` longtext NOT NULL,
  `feature_id` int NOT NULL,
  `field_order` int DEFAULT '0',
  `visible` enum('yes','no') NOT NULL DEFAULT 'yes',
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`field_name`),
  KEY `feature_id` (`feature_id`),
  KEY `denomination_id` (`denomination_id`),
  CONSTRAINT `customfields_ibfk_1` FOREIGN KEY (`feature_id`) REFERENCES `features` (`id`),
  CONSTRAINT `customfields_ibfk_2` FOREIGN KEY (`denomination_id`) REFERENCES `denominations` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `customvalues`;
CREATE TABLE `customvalues` (
  `id` int NOT NULL AUTO_INCREMENT,
  `table_name` varchar(100) NOT NULL,
  `record_id` int NOT NULL,
  `customfield_id` int DEFAULT NULL,
  `value` json DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customfield_id` (`customfield_id`),
  CONSTRAINT `customvalues_ibfk_1` FOREIGN KEY (`customfield_id`) REFERENCES `customfields` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `dashboards`;
CREATE TABLE `dashboards` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `values` longtext NOT NULL,
  `roles` longtext,
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `denominations`;
CREATE TABLE `denominations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `code` varchar(20) DEFAULT NULL,
  `registration_date` date NOT NULL,
  `head_office` varchar(200) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `departments`;
CREATE TABLE `departments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `denomination_id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` longtext NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `denomination_id` (`denomination_id`),
  CONSTRAINT `departments_ibfk_1` FOREIGN KEY (`denomination_id`) REFERENCES `denominations` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `designations`;
CREATE TABLE `designations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `denomination_id` int NOT NULL,
  `hierarchy_id` int DEFAULT NULL,
  `department_id` int DEFAULT NULL,
  `minister_title_designation` enum('no','yes') DEFAULT 'no',
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int NOT NULL,
  `deleted_at` datetime NOT NULL,
  `deleted_by` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `denomination_id` (`denomination_id`),
  KEY `department_id` (`department_id`),
  CONSTRAINT `designations_ibfk_1` FOREIGN KEY (`denomination_id`) REFERENCES `denominations` (`id`),
  CONSTRAINT `designations_ibfk_2` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `entities`;
CREATE TABLE `entities` (
  `id` int NOT NULL AUTO_INCREMENT,
  `hierarchy_id` int NOT NULL,
  `entity_number` varchar(50) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `parent_id` int DEFAULT NULL,
  `entity_leader` int DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hierarchy_id` (`hierarchy_id`),
  KEY `entity_number` (`entity_number`),
  CONSTRAINT `entities_ibfk_1` FOREIGN KEY (`hierarchy_id`) REFERENCES `hierarchies` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `events`;
CREATE TABLE `events` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `meeting_id` int DEFAULT '1',
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `location` varchar(100) NOT NULL,
  `description` longtext,
  `denomination_id` int NOT NULL,
  `registration_fees` decimal(10,2) NOT NULL DEFAULT '0.00',
  `assemblies` longtext,
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `denomination_id` (`denomination_id`),
  KEY `meeting_id` (`meeting_id`),
  CONSTRAINT `events_ibfk_1` FOREIGN KEY (`denomination_id`) REFERENCES `denominations` (`id`),
  CONSTRAINT `events_ibfk_2` FOREIGN KEY (`meeting_id`) REFERENCES `meetings` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `features`;
CREATE TABLE `features` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `description` longtext NOT NULL,
  `allowable_permission_labels` json NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `gatherings`;
CREATE TABLE `gatherings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `assembly_id` int NOT NULL,
  `meeting_id` int NOT NULL,
  `meeting_date` date NOT NULL,
  `description` longtext NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int NOT NULL,
  `deleted_at` datetime NOT NULL,
  `deleted_by` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `assembly_id` (`assembly_id`),
  KEY `meeting_id` (`meeting_id`),
  CONSTRAINT `gatherings_ibfk_1` FOREIGN KEY (`assembly_id`) REFERENCES `assemblies` (`id`),
  CONSTRAINT `gatherings_ibfk_2` FOREIGN KEY (`meeting_id`) REFERENCES `meetings` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `gatheringtypes`;
CREATE TABLE `gatheringtypes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `denomination_id` int NOT NULL,
  `description` longtext,
  `name` varchar(200) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `denomination_id` (`denomination_id`),
  CONSTRAINT `gatheringtypes_ibfk_1` FOREIGN KEY (`denomination_id`) REFERENCES `denominations` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `hierarchies`;
CREATE TABLE `hierarchies` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `denomination_id` int NOT NULL,
  `level` int NOT NULL DEFAULT '1' COMMENT 'starts from 1,2,3,....n: 1 being the lowest',
  `description` longtext,
  `created_at` timestamp NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `denomination_id` (`denomination_id`),
  CONSTRAINT `hierarchies_ibfk_1` FOREIGN KEY (`denomination_id`) REFERENCES `denominations` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `logmails`;
CREATE TABLE `logmails` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email_to` varchar(150) NOT NULL,
  `subject` longtext NOT NULL,
  `email_body` longtext NOT NULL,
  `send_status` enum('new','sent','failed') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'new',
  `count_failure` int DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `meetings`;
CREATE TABLE `meetings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `denomination_id` int NOT NULL,
  `name` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `description` longtext CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `denomination_id` (`denomination_id`),
  CONSTRAINT `meetings_ibfk_1` FOREIGN KEY (`denomination_id`) REFERENCES `denominations` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `members`;
CREATE TABLE `members` (
  `id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `member_number` varchar(100) DEFAULT NULL,
  `designation_id` int DEFAULT NULL,
  `parent_id` int DEFAULT NULL,
  `date_of_birth` date NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(100) NOT NULL,
  `is_active` enum('yes','no') NOT NULL DEFAULT 'yes',
  `assembly_id` int NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int NOT NULL,
  `deleted_at` datetime NOT NULL,
  `deleted_by` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `assembly_id` (`assembly_id`),
  KEY `designation_id` (`designation_id`),
  CONSTRAINT `members_ibfk_1` FOREIGN KEY (`assembly_id`) REFERENCES `assemblies` (`id`),
  CONSTRAINT `members_ibfk_2` FOREIGN KEY (`designation_id`) REFERENCES `designations` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `menus`;
CREATE TABLE `menus` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `icon` varchar(100) NOT NULL DEFAULT 'entypo-home',
  `feature_id` int NOT NULL,
  `parent_id` int NOT NULL DEFAULT '0',
  `visible` enum('yes','no') NOT NULL DEFAULT 'yes',
  `order` int DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `feature_id` (`feature_id`),
  CONSTRAINT `menus_ibfk_1` FOREIGN KEY (`feature_id`) REFERENCES `features` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int NOT NULL,
  `batch` int unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `ministers`;
CREATE TABLE `ministers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `minister_number` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `assembly_id` int NOT NULL,
  `designation_id` int DEFAULT NULL,
  `phone` varchar(50) NOT NULL,
  `is_active` enum('yes','no') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'yes',
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `minister_number` (`minister_number`),
  KEY `assembly_id` (`assembly_id`),
  KEY `designation_id` (`designation_id`),
  CONSTRAINT `ministers_ibfk_1` FOREIGN KEY (`assembly_id`) REFERENCES `assemblies` (`id`),
  CONSTRAINT `ministers_ibfk_2` FOREIGN KEY (`designation_id`) REFERENCES `designations` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `participants`;
CREATE TABLE `participants` (
  `id` int NOT NULL AUTO_INCREMENT,
  `member_id` int DEFAULT NULL,
  `event_id` int NOT NULL,
  `payment_id` int DEFAULT NULL,
  `payment_code` varchar(50) DEFAULT NULL,
  `registration_amount` decimal(10,2) DEFAULT '0.00',
  `status` enum('registered','attended','cancelled') NOT NULL DEFAULT 'registered',
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int NOT NULL,
  `deleted_at` datetime NOT NULL,
  `deleted_by` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`),
  KEY `event_id` (`event_id`),
  KEY `payment_id` (`payment_id`),
  CONSTRAINT `participants_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`),
  CONSTRAINT `participants_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`),
  CONSTRAINT `participants_ibfk_3` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `payments`;
CREATE TABLE `payments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `phone` varchar(50) NOT NULL,
  `payment_code` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `redeemed_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `payment_status` enum('waiting','success','failed','confirmed') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'waiting',
  `denomination_id` int DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `denomination_id` (`denomination_id`),
  CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`denomination_id`) REFERENCES `denominations` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `feature_id` int NOT NULL,
  `role_id` int NOT NULL,
  `permission_label` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  `updated_by` datetime DEFAULT NULL,
  `deleted_at` int DEFAULT NULL,
  `deleted_by` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `feature_id_role_id` (`feature_id`,`role_id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `permissions_ibfk_1` FOREIGN KEY (`feature_id`) REFERENCES `features` (`id`),
  CONSTRAINT `permissions_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `permissions` (`id`, `feature_id`, `role_id`, `permission_label`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(1,	5,	1,	'delete',	'2024-09-12 07:21:14',	NULL,	NULL,	NULL,	NULL,	NULL),
(2,	2,	1,	'update',	'2024-09-12 07:21:36',	NULL,	NULL,	NULL,	NULL,	NULL),
(3,	3,	1,	'update',	'2024-09-12 07:21:52',	NULL,	NULL,	NULL,	NULL,	NULL),
(4,	4,	1,	'read',	'2024-09-12 07:22:02',	NULL,	NULL,	NULL,	NULL,	NULL),
(5,	11,	1,	'create',	'2024-09-12 07:22:14',	NULL,	NULL,	NULL,	NULL,	NULL),
(6,	12,	1,	'update',	'2024-09-14 17:18:27',	NULL,	NULL,	NULL,	NULL,	NULL),
(7,	14,	1,	'read',	'2024-09-14 17:18:36',	NULL,	NULL,	NULL,	NULL,	NULL),
(8,	28,	1,	'update',	'2024-09-14 17:18:51',	NULL,	NULL,	NULL,	NULL,	NULL);

DROP TABLE IF EXISTS `queue_jobs`;
CREATE TABLE `queue_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(64) NOT NULL,
  `payload` text NOT NULL,
  `priority` varchar(64) NOT NULL DEFAULT 'default',
  `status` tinyint unsigned NOT NULL DEFAULT '0',
  `attempts` tinyint unsigned NOT NULL DEFAULT '0',
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `queue_priority_status_available_at` (`queue`,`priority`,`status`,`available_at`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `queue_jobs_failed`;
CREATE TABLE `queue_jobs_failed` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `connection` varchar(64) NOT NULL,
  `queue` varchar(64) NOT NULL,
  `payload` text NOT NULL,
  `priority` varchar(64) NOT NULL DEFAULT 'default',
  `exception` text NOT NULL,
  `failed_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `queue` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `reportfields`;
CREATE TABLE `reportfields` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `report_id` int NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `placeholder` varchar(100) DEFAULT NULL,
  `type` enum('text','select','checkbox','radio','textarea') NOT NULL DEFAULT 'text',
  `options` longtext,
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `report_id` (`report_id`),
  CONSTRAINT `reportfields_ibfk_1` FOREIGN KEY (`report_id`) REFERENCES `reports` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `reports`;
CREATE TABLE `reports` (
  `id` int NOT NULL AUTO_INCREMENT,
  `reports_type_id` int NOT NULL,
  `report_period` int NOT NULL,
  `report_date` int NOT NULL,
  `status` enum('draft','submitted','approved') NOT NULL DEFAULT 'draft',
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int NOT NULL,
  `deleted_at` datetime NOT NULL,
  `deleted_by` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `reports_type_id` (`reports_type_id`),
  KEY `report_period` (`report_period`),
  KEY `report_date` (`report_date`),
  CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`reports_type_id`) REFERENCES `reporttypes` (`id`),
  CONSTRAINT `reports_ibfk_2` FOREIGN KEY (`report_period`) REFERENCES `reporttypes` (`id`),
  CONSTRAINT `reports_ibfk_3` FOREIGN KEY (`report_date`) REFERENCES `reporttypes` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `reporttypes`;
CREATE TABLE `reporttypes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` longtext NOT NULL,
  `denomination_id` int NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `denomination_id` (`denomination_id`),
  CONSTRAINT `reporttypes_ibfk_1` FOREIGN KEY (`denomination_id`) REFERENCES `denominations` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `reportvalues`;
CREATE TABLE `reportvalues` (
  `id` int NOT NULL AUTO_INCREMENT,
  `report_field_id` int NOT NULL,
  `report_value` longtext NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int NOT NULL,
  `deleted_at` datetime NOT NULL,
  `deleted_by` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `report_field_id` (`report_field_id`),
  CONSTRAINT `reportvalues_ibfk_1` FOREIGN KEY (`report_field_id`) REFERENCES `reportfields` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `revenues`;
CREATE TABLE `revenues` (
  `id` int NOT NULL AUTO_INCREMENT,
  `denomination_id` int NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` longtext NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int NOT NULL,
  `deleted_at` datetime NOT NULL,
  `deleted_by` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `denomination_id` (`denomination_id`),
  CONSTRAINT `revenues_ibfk_1` FOREIGN KEY (`denomination_id`) REFERENCES `denominations` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `permissions` longtext,
  `default_role` enum('yes','no') DEFAULT 'no',
  `denomination_id` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `denomination_id` (`denomination_id`),
  CONSTRAINT `roles_ibfk_1` FOREIGN KEY (`denomination_id`) REFERENCES `denominations` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `sections`;
CREATE TABLE `sections` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `order` int NOT NULL DEFAULT '1',
  `customfield_id` int NOT NULL,
  `reporttype_id` int NOT NULL,
  `created_by` int NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_by` int DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customfield_id` (`customfield_id`),
  KEY `reporttype_id` (`reporttype_id`),
  CONSTRAINT `sections_ibfk_1` FOREIGN KEY (`customfield_id`) REFERENCES `customfields` (`id`),
  CONSTRAINT `sections_ibfk_2` FOREIGN KEY (`reporttype_id`) REFERENCES `reporttypes` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `class` varchar(255) NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text,
  `type` varchar(31) NOT NULL DEFAULT 'string',
  `context` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `statuses`;
CREATE TABLE `statuses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `task_id` int NOT NULL,
  `status_label` varchar(15) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int NOT NULL,
  `deleted_at` int DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `task_id` (`task_id`),
  CONSTRAINT `statuses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `statuses_ibfk_2` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `subscriptions`;
CREATE TABLE `subscriptions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `denomination_id` int NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `subscription_type_id` int NOT NULL,
  `status` enum('active','terminated') NOT NULL DEFAULT 'active',
  `is_auto_renewal` enum('yes','no') NOT NULL DEFAULT 'no',
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int NOT NULL,
  `deleted_at` datetime NOT NULL,
  `deleted_by` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `denomination_id` (`denomination_id`),
  KEY `subscription_type_id` (`subscription_type_id`),
  CONSTRAINT `subscriptions_ibfk_1` FOREIGN KEY (`denomination_id`) REFERENCES `denominations` (`id`),
  CONSTRAINT `subscriptions_ibfk_2` FOREIGN KEY (`subscription_type_id`) REFERENCES `subscriptiontypes` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `subscriptiontypes`;
CREATE TABLE `subscriptiontypes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `features` longtext NOT NULL,
  `description` longtext NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int NOT NULL,
  `deleted_at` datetime NOT NULL,
  `deleted_by` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `tasks`;
CREATE TABLE `tasks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `status` enum('Not Started','In Progress','Completed','Rejected') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'Not Started',
  `allowable_status_labels` json NOT NULL,
  `user_id` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int NOT NULL,
  `deleted_at` int DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `templates`;
CREATE TABLE `templates` (
  `id` int NOT NULL AUTO_INCREMENT,
  `denomination_id` int DEFAULT NULL,
  `short_name` varchar(255) NOT NULL,
  `template_vars` longtext NOT NULL,
  `template_subject` longtext CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `template_body` longtext NOT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `denomination_id` (`denomination_id`),
  CONSTRAINT `templates_ibfk_1` FOREIGN KEY (`denomination_id`) REFERENCES `denominations` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `trashes`;
CREATE TABLE `trashes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `feature_name` int DEFAULT NULL,
  `item_id` int NOT NULL,
  `item_name` longtext CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `item_deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `feature_name` (`feature_name`),
  CONSTRAINT `trashes_ibfk_1` FOREIGN KEY (`feature_name`) REFERENCES `features` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `denomination_id` int DEFAULT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `biography` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `date_of_birth` date NOT NULL,
  `gender` enum('male','female') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `roles` longtext,
  `is_system_admin` enum('yes','no') DEFAULT 'no',
  `access_count` int DEFAULT NULL,
  `accessed_at` datetime DEFAULT NULL,
  `last_password_reset_at` datetime DEFAULT NULL,
  `is_active` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'yes',
  `associated_member_id` int DEFAULT NULL,
  `permitted_entities` longtext,
  `permitted_assemblies` longtext,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `denomination_id` (`denomination_id`),
  KEY `associated_member_id` (`associated_member_id`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`denomination_id`) REFERENCES `denominations` (`id`),
  CONSTRAINT `users_ibfk_2` FOREIGN KEY (`associated_member_id`) REFERENCES `members` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `visitors`;
CREATE TABLE `visitors` (
  `id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(200) NOT NULL,
  `last_name` varchar(200) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `gender` enum('male','female') NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `event_id` int NOT NULL,
  `payment_id` int DEFAULT NULL,
  `payment_code` varchar(50) DEFAULT NULL,
  `registration_amount` decimal(10,2) DEFAULT NULL,
  `status` enum('registered','attended','cancelled') CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT 'registered',
  `created_by` int NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_by` int DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `event_id` (`event_id`),
  KEY `payment_id` (`payment_id`),
  CONSTRAINT `visitors_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`),
  CONSTRAINT `visitors_ibfk_2` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- 2024-10-04 13:06:19
