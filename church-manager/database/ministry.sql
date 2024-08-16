-- Adminer 4.8.1 MySQL 8.0.28 dump

SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `assemblies`;
CREATE TABLE `assemblies` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `planted_at` date NOT NULL,
  `location` varchar(200)  NOT NULL,
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
);


DROP TABLE IF EXISTS `attendances`;
CREATE TABLE `attendances` (
  `id` int NOT NULL AUTO_INCREMENT,
  `member_id` int NOT NULL,
  `gathering_id` int NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`),
  KEY `gathering_id` (`gathering_id`),
  CONSTRAINT `attendances_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`),
  CONSTRAINT `attendances_ibfk_2` FOREIGN KEY (`gathering_id`) REFERENCES `gatherings` (`id`)
);


DROP TABLE IF EXISTS `collections`;
CREATE TABLE `collections` (
  `id` int NOT NULL AUTO_INCREMENT,
  `return_date` datetime NOT NULL,
  `period_start_date` datetime NOT NULL,
  `period_end_date` datetime NOT NULL,
  `collection_type_id` int NOT NULL,
  `amount` decimal(50,2) NOT NULL,
  `status` enum('submitted','approved') NOT NULL DEFAULT 'submitted',
  `collection_reference` longtext NOT NULL,
  `description` longtext NOT NULL,
  `collection_method` enum('banking','mobile','in-persion') NOT NULL DEFAULT 'in-persion',
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int NOT NULL,
  `deleted_at` datetime NOT NULL,
  `deleted_by` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `collection_type_id` (`collection_type_id`),
  CONSTRAINT `collections_ibfk_1` FOREIGN KEY (`collection_type_id`) REFERENCES `collectiontypes` (`id`)
);


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
);


DROP TABLE IF EXISTS `customfields`;
CREATE TABLE `customfields` (
  `id` int NOT NULL AUTO_INCREMENT,
  `denomination_id` int DEFAULT NULL,
  `name` varchar(200) NOT NULL,
  `type` enum('string','text','date','datetime','timestamp','password','numeric','email','dropdown')  NOT NULL DEFAULT 'string',
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
  UNIQUE KEY `name` (`name`),
  KEY `feature_id` (`feature_id`),
  KEY `denomination_id` (`denomination_id`),
  CONSTRAINT `customfields_ibfk_1` FOREIGN KEY (`feature_id`) REFERENCES `features` (`id`),
  CONSTRAINT `customfields_ibfk_2` FOREIGN KEY (`denomination_id`) REFERENCES `denominations` (`id`)
);


DROP TABLE IF EXISTS `customvalues`;
CREATE TABLE `customvalues` (
  `id` int NOT NULL AUTO_INCREMENT,
  `record_id` int NOT NULL,
  `value` json DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  PRIMARY KEY (`id`)
);


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
);


DROP TABLE IF EXISTS `denominations`;
CREATE TABLE `denominations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `code` varchar(20)  DEFAULT NULL,
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
);


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
);


DROP TABLE IF EXISTS `designations`;
CREATE TABLE `designations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `denomination_id` int NOT NULL,
  `hierarchy_id` int DEFAULT NULL,
  `department_id` int DEFAULT NULL,
  `minister_title_designation` enum('no','yes')  DEFAULT 'no',
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
);


DROP TABLE IF EXISTS `entities`;
CREATE TABLE `entities` (
  `id` int NOT NULL AUTO_INCREMENT,
  `hierarchy_id` int NOT NULL,
  `entity_number` varchar(50) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `parent_id` int NOT NULL,
  `entity_leader` int DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `entity_number` (`entity_number`),
  KEY `hierarchy_id` (`hierarchy_id`),
  CONSTRAINT `entities_ibfk_1` FOREIGN KEY (`hierarchy_id`) REFERENCES `hierarchies` (`id`)
);


DROP TABLE IF EXISTS `events`;
CREATE TABLE `events` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `gatheringtype_id` int NOT NULL DEFAULT '1',
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `location` varchar(100) NOT NULL,
  `description` longtext ,
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
  KEY `gatheringtype_id` (`gatheringtype_id`),
  CONSTRAINT `events_ibfk_1` FOREIGN KEY (`denomination_id`) REFERENCES `denominations` (`id`),
  CONSTRAINT `events_ibfk_2` FOREIGN KEY (`gatheringtype_id`) REFERENCES `gatheringtypes` (`id`)
);


DROP TABLE IF EXISTS `features`;
CREATE TABLE `features` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `description` longtext  NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  PRIMARY KEY (`id`)
);

INSERT INTO `features` (`id`, `name`, `description`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(1,	'dashboard',	'Dashboard',	'2024-06-26 20:26:16',	1,	'2024-06-26 20:26:16',	1,	NULL,	NULL),
(2,	'hierarchy',	'Hierarchy',	'2024-06-26 20:34:21',	1,	'2024-06-26 20:34:21',	1,	NULL,	NULL),
(3,	'entity',	'Entity',	'2024-06-26 20:34:21',	1,	'2024-06-26 20:34:21',	1,	NULL,	NULL),
(4,	'assembly',	'Assembly',	'2024-06-26 20:34:21',	1,	'2024-06-26 20:34:21',	1,	NULL,	NULL),
(5,	'denomination',	'Denomination',	'2024-06-26 20:34:21',	1,	'2024-06-26 20:34:21',	1,	NULL,	NULL),
(6,	'collection',	'Collection',	'2024-06-26 20:34:21',	1,	'2024-06-26 20:34:21',	1,	NULL,	NULL),
(7,	'collection_type',	'Collection Types',	'2024-06-26 20:34:21',	1,	'2024-06-26 20:34:21',	1,	NULL,	NULL),
(8,	'designation',	'Designation',	'2024-06-26 20:34:21',	1,	'2024-06-26 20:34:21',	1,	NULL,	NULL),
(9,	'event',	'Events',	'2024-06-26 20:34:21',	1,	'2024-06-26 20:34:21',	1,	NULL,	NULL),
(10,	'gathering',	'Gatherings',	'2024-06-26 20:34:21',	1,	'2024-06-26 20:34:21',	1,	NULL,	NULL),
(11,	'member',	'Members',	'2024-06-26 20:34:21',	1,	'2024-06-26 20:34:21',	1,	NULL,	NULL),
(12,	'participant',	'Participants',	'2024-06-26 20:34:21',	1,	'2024-06-26 20:34:21',	1,	NULL,	NULL),
(13,	'role',	'Roles',	'2024-06-26 20:34:21',	1,	'2024-06-26 20:34:21',	1,	NULL,	NULL),
(14,	'subscription',	'Subscriptions',	'2024-06-26 20:34:21',	1,	'2024-06-26 20:34:21',	1,	NULL,	NULL),
(15,	'subscription_type',	'Subscription Types',	'2024-06-26 20:34:21',	1,	'2024-06-26 20:34:21',	1,	NULL,	NULL),
(16,	'user',	'Users',	'2024-06-26 20:34:21',	1,	'2024-06-26 20:34:21',	1,	NULL,	NULL),
(17,	'setting',	'Settings',	'2024-06-26 20:34:21',	1,	'2024-06-26 20:34:21',	1,	NULL,	NULL),
(18,	'report',	'Reports',	'2024-06-26 20:34:21',	1,	'2024-06-26 20:34:21',	1,	NULL,	NULL),
(19,	'report_type',	'Reports Types',	'2024-06-26 20:34:21',	1,	'2024-06-26 20:34:21',	1,	NULL,	NULL),
(22,	'attendance',	'Gathering Attendance',	'2024-06-26 20:34:21',	1,	'2024-06-26 20:34:21',	1,	NULL,	NULL),
(23,	'gathering_type',	'Gathering types',	'2024-06-26 20:34:21',	1,	'2024-06-26 20:34:21',	1,	NULL,	NULL),
(24,	'custom_field',	'Custom Fields',	'2024-06-26 20:34:21',	1,	'2024-06-26 20:34:21',	1,	NULL,	NULL),
(25,	'custom_value',	'Custom values',	'2024-06-26 20:34:21',	1,	'2024-06-26 20:34:21',	1,	NULL,	NULL),
(26,	'department',	'Departments',	'2024-06-26 20:34:21',	1,	'2024-06-26 20:34:21',	1,	NULL,	NULL),
(27,	'section',	'Report Sections',	'2024-06-26 20:34:21',	1,	'2024-06-26 20:34:21',	1,	NULL,	NULL),
(28,	'visitor',	'Event Visitors',	'2024-06-26 20:34:21',	1,	'2024-06-26 20:34:21',	1,	NULL,	NULL),
(29,	'payment',	'Event payments',	'2024-06-26 20:34:21',	1,	'2024-06-26 20:34:21',	1,	NULL,	NULL),
(30,	'minister',	'ministers',	'2024-06-26 20:34:21',	1,	'2024-06-26 20:34:21',	1,	NULL,	NULL);

DROP TABLE IF EXISTS `gatherings`;
CREATE TABLE `gatherings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `assembly_id` int NOT NULL,
  `gathering_type_id` int NOT NULL,
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
  KEY `gathering_type_id` (`gathering_type_id`),
  CONSTRAINT `gatherings_ibfk_1` FOREIGN KEY (`assembly_id`) REFERENCES `assemblies` (`id`),
  CONSTRAINT `gatherings_ibfk_2` FOREIGN KEY (`gathering_type_id`) REFERENCES `gatheringtypes` (`id`)
);


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
);


DROP TABLE IF EXISTS `hierarchies`;
CREATE TABLE `hierarchies` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `denomination_id` int NOT NULL,
  `level` int NOT NULL DEFAULT '1' COMMENT 'starts from 1,2,3,....n: 1 being the lowest',
  `created_at` timestamp NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `denomination_id` (`denomination_id`),
  CONSTRAINT `hierarchies_ibfk_1` FOREIGN KEY (`denomination_id`) REFERENCES `denominations` (`id`)
);


DROP TABLE IF EXISTS `members`;
CREATE TABLE `members` (
  `id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `member_number` varchar(100)  DEFAULT NULL,
  `designation_id` int NOT NULL,
  `date_of_birth` date NOT NULL,
  `email` varchar(100)  DEFAULT NULL,
  `phone` varchar(100) NOT NULL,
  `is_active` enum('yes','no')  NOT NULL DEFAULT 'yes',
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
);


DROP TABLE IF EXISTS `menus`;
CREATE TABLE `menus` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `icon` varchar(100)  NOT NULL DEFAULT 'entypo-home',
  `feature_id` int NOT NULL,
  `parent_id` int NOT NULL DEFAULT '0',
  `visible` enum('yes','no')  NOT NULL DEFAULT 'yes',
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
);

INSERT INTO `menus` (`id`, `name`, `icon`, `feature_id`, `parent_id`, `visible`, `order`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(1,	'dashboard',	'entypo-gauge',	1,	0,	'yes',	1,	'2024-06-26 20:27:20',	1,	'2024-06-26 20:27:20',	1,	NULL,	NULL),
(2,	'hierarchy',	'entypo-flow-tree',	2,	4,	'yes',	5,	'2024-06-26 20:27:20',	1,	'2024-06-26 20:27:20',	1,	NULL,	NULL),
(3,	'assembly',	'entypo-users',	4,	0,	'yes',	4,	'2024-06-26 20:27:20',	1,	'2024-06-26 20:27:20',	1,	NULL,	NULL),
(4,	'denomination',	'entypo-feather',	5,	0,	'yes',	2,	'2024-06-26 20:27:20',	1,	'2024-06-26 20:27:20',	1,	NULL,	NULL),
(5,	'collection',	'entypo-database',	6,	0,	'no',	6,	'2024-06-26 20:27:20',	1,	'2024-06-26 20:27:20',	1,	NULL,	NULL),
(6,	'setting',	'entypo-cog',	17,	0,	'no',	50,	'2024-06-26 20:27:20',	1,	'2024-06-26 20:27:20',	1,	NULL,	NULL),
(7,	'event',	'entypo-cog',	9,	0,	'yes',	7,	'2024-06-26 20:27:20',	1,	'2024-06-26 20:27:20',	1,	NULL,	NULL),
(8,	'attendance',	'entypo-folder',	22,	7,	'no',	8,	'2024-06-26 20:27:20',	1,	'2024-06-26 20:27:20',	1,	NULL,	NULL),
(9,	'member',	'entypo-basket',	11,	3,	'yes',	9,	'2024-06-26 20:27:20',	1,	'2024-06-26 20:27:20',	1,	NULL,	NULL),
(10,	'role',	'entypo-bookmark',	13,	12,	'yes',	10,	'2024-06-26 20:27:20',	1,	'2024-06-26 20:27:20',	1,	NULL,	NULL),
(11,	'subscription',	'entypo-link',	14,	0,	'no',	11,	'2024-06-26 20:27:20',	1,	'2024-06-26 20:27:20',	1,	NULL,	NULL),
(12,	'user',	'entypo-user',	16,	0,	'yes',	12,	'2024-06-26 20:27:20',	1,	'2024-06-26 20:27:20',	1,	NULL,	NULL),
(13,	'report',	'entypo-print',	18,	0,	'yes',	13,	'2024-06-26 20:27:20',	1,	'2024-06-26 20:27:20',	1,	NULL,	NULL),
(14,	'entity',	'entypo-docs',	3,	4,	'yes',	3,	'2024-06-26 20:27:20',	1,	'2024-06-26 20:27:20',	1,	NULL,	NULL),
(16,	'collection_type',	'entypo-vcard',	7,	6,	'no',	52,	'2024-06-26 20:27:20',	1,	'2024-06-26 20:27:20',	1,	NULL,	NULL),
(17,	'report_type',	'entypo-bag',	19,	4,	'yes',	53,	'2024-06-26 20:27:20',	1,	'2024-06-26 20:27:20',	1,	NULL,	NULL),
(18,	'subscription_type',	'entypo-list',	15,	6,	'no',	54,	'2024-06-26 20:27:20',	1,	'2024-06-26 20:27:20',	1,	NULL,	NULL),
(20,	'designation',	'entypo-star',	8,	4,	'yes',	54,	'2024-06-26 20:27:20',	1,	'2024-06-26 20:27:20',	1,	NULL,	NULL),
(21,	'participant',	'entypo-user-add',	12,	7,	'no',	7,	'2024-06-26 20:27:20',	1,	'2024-06-26 20:27:20',	1,	NULL,	NULL),
(22,	'gathering',	'entypo-bell',	10,	7,	'no',	7,	'2024-06-26 20:27:20',	1,	'2024-06-26 20:27:20',	1,	NULL,	NULL),
(23,	'gathering_type',	'entypo-tag',	23,	4,	'yes',	52,	'2024-06-26 20:27:20',	1,	'2024-06-26 20:27:20',	1,	NULL,	NULL),
(24,	'custom_field',	'entypo-lamp',	24,	0,	'yes',	52,	'2024-06-26 20:27:20',	1,	'2024-06-26 20:27:20',	1,	NULL,	NULL),
(25,	'department',	'entypo-archive',	26,	4,	'yes',	10,	'2024-06-26 20:27:20',	1,	'2024-06-26 20:27:20',	1,	NULL,	NULL),
(26,	'section',	'entypo-map',	27,	13,	'yes',	10,	'2024-06-26 20:27:20',	1,	'2024-06-26 20:27:20',	1,	NULL,	NULL),
(27,	'visitor',	'entypo-heart',	28,	7,	'no',	10,	'2024-06-26 20:27:20',	1,	'2024-06-26 20:27:20',	1,	NULL,	NULL),
(28,	'payment',	'entypo-flag',	29,	0,	'yes',	7,	'2024-06-26 20:27:20',	1,	'2024-06-26 20:27:20',	1,	NULL,	NULL),
(29,	'minister',	'entypo-flag',	30,	0,	'yes',	2,	'2024-06-26 20:27:20',	1,	'2024-06-26 20:27:20',	1,	NULL,	NULL);

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) NOT NULL,
  `class` varchar(255)  NOT NULL,
  `group` varchar(255)  NOT NULL,
  `namespace` varchar(255)  NOT NULL,
  `time` int NOT NULL,
  `batch` int unsigned NOT NULL,
  PRIMARY KEY (`id`)
);


DROP TABLE IF EXISTS `ministers`;
CREATE TABLE `ministers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `minister_number` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `assembly_id` int NOT NULL,
  `designation_id` int NOT NULL,
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
);


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
);


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
);


DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `feature_id` int NOT NULL,
  `label` enum('create','read','update','delete')  NOT NULL DEFAULT 'read' COMMENT 'create,read,update,delete',
  `global_permission` enum('yes','no')  NOT NULL DEFAULT 'no',
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `feature_id_label` (`feature_id`,`label`),
  CONSTRAINT `permissions_ibfk_1` FOREIGN KEY (`feature_id`) REFERENCES `features` (`id`)
);

INSERT INTO `permissions` (`id`, `name`, `feature_id`, `label`, `global_permission`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(1,	'Create Denomination',	5,	'create',	'yes',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(2,	'Read Denomination',	5,	'read',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(3,	'Update Denomination',	5,	'update',	'yes',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(4,	'Delete Denomination',	5,	'delete',	'yes',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(5,	'Create Hierarchy',	2,	'create',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(6,	'Read Hierarchy',	2,	'read',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(7,	'Update Hierarchy',	2,	'update',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(8,	'Delete Hierarchy',	2,	'delete',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(10,	'Create Event',	9,	'create',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(11,	'Read Event',	9,	'read',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(12,	'Update Event',	9,	'update',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(13,	'Delete Event',	9,	'delete',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(14,	'Create User',	16,	'create',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(15,	'Read User',	16,	'read',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(16,	'Update User',	16,	'update',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(17,	'Delete User',	16,	'delete',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(21,	'Create Dashboard',	1,	'create',	'yes',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(22,	'Read Dashboard',	1,	'read',	'yes',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(23,	'Update Dashboard',	1,	'update',	'yes',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(24,	'Delete Dashboard',	1,	'delete',	'yes',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(28,	'Create Entity',	3,	'create',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(29,	'Read Entity',	3,	'read',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(30,	'Update Entity',	3,	'update',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(31,	'Delete Entity',	3,	'delete',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(35,	'Create Assembly',	4,	'create',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(36,	'Read Assembly',	4,	'read',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(37,	'Update Assembly',	4,	'update',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(38,	'Delete Assembly',	4,	'delete',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(42,	'Create Collection',	6,	'create',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(43,	'Read Collection',	6,	'read',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(44,	'Update Collection',	6,	'update',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(45,	'Delete Collection',	6,	'delete',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(49,	'Create Collection Type',	7,	'create',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(50,	'Read Collection Type',	7,	'read',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(51,	'Update Collection Type',	7,	'update',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(52,	'Delete Collection Type',	7,	'delete',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(56,	'Create Designation',	8,	'create',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(57,	'Read Designation',	8,	'read',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(58,	'Update Designation',	8,	'update',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(59,	'Delete Designation',	8,	'delete',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(63,	'Create Gathering',	10,	'create',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(64,	'Read Gathering',	10,	'read',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(65,	'Update Gathering',	10,	'update',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(66,	'Delete Gathering',	10,	'delete',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(70,	'Create Member',	11,	'create',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(71,	'Read Member',	11,	'read',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(72,	'Update Member',	11,	'update',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(73,	'Delete Member',	11,	'delete',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(77,	'Create Participant',	12,	'create',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(78,	'Read Participant',	12,	'read',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(79,	'Update Participant',	12,	'update',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(80,	'Delete Participant',	12,	'delete',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(84,	'Create Role',	13,	'create',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(85,	'Read Role',	13,	'read',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(86,	'Update Role',	13,	'update',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(87,	'Delete Role',	13,	'delete',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(91,	'Create Subscription',	14,	'create',	'yes',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(92,	'Read Subscription',	14,	'read',	'yes',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(93,	'Update Subscription',	14,	'update',	'yes',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(94,	'Delete Subscription',	14,	'delete',	'yes',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(98,	'Create Subscription Type',	15,	'create',	'yes',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(99,	'Read Subscription Type',	15,	'read',	'yes',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(100,	'Update Subscription Type',	15,	'update',	'yes',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(101,	'Delete Subscription Type',	15,	'delete',	'yes',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(105,	'Create Setting',	17,	'create',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(106,	'Read Setting',	17,	'read',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(107,	'Update Setting',	17,	'update',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(108,	'Delete Setting',	17,	'delete',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(112,	'Create Report',	18,	'create',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(113,	'Read Report',	18,	'read',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(114,	'Update Report',	18,	'update',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(115,	'Delete Report',	18,	'delete',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(119,	'Create Report Type',	19,	'create',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(120,	'Read Report Type',	19,	'read',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(121,	'Update Report Type',	19,	'update',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(122,	'Delete Report Type',	19,	'delete',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(126,	'Create Attendance',	22,	'create',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(127,	'Read Attendance',	22,	'read',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(128,	'Update Attendance',	22,	'update',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(129,	'Delete Attendance',	22,	'delete',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(133,	'Create Gathering Type',	23,	'create',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(134,	'Read Gathering Type',	23,	'read',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(135,	'Update Gathering Type',	23,	'update',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(136,	'Delete Gathering Type',	23,	'delete',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(140,	'Create Custom Field',	24,	'create',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(141,	'Read Custom Field',	24,	'read',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(142,	'Update Custom Field',	24,	'update',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(143,	'Delete Custom Field',	24,	'delete',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(147,	'Create Custom Value',	25,	'create',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(148,	'Read Custom Value',	25,	'read',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(149,	'Update Custom Value',	25,	'update',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(150,	'Delete Custom Value',	25,	'delete',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(151,	'Create Department',	26,	'create',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(152,	'Read Department',	26,	'read',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(153,	'Update Department',	26,	'update',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(154,	'Delete Department',	26,	'delete',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(155,	'Create Section',	27,	'create',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(156,	'Read Section',	27,	'read',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(157,	'Update Section',	27,	'update',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(158,	'Delete Section',	27,	'delete',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(159,	'Create Visitor',	28,	'create',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(160,	'Read Visitor',	28,	'read',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(161,	'Update Visitor',	28,	'update',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(162,	'Delete Visitor',	28,	'delete',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(166,	'Create Payment',	29,	'create',	'yes',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(167,	'Read Payment',	29,	'read',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(168,	'Update Payment',	29,	'update',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(169,	'Delete Payment',	29,	'delete',	'yes',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(170,	'Create Minister',	30,	'create',	'yes',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(171,	'Read Minister',	30,	'read',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(172,	'Update Minister',	30,	'update',	'no',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL),
(173,	'Delete Minister',	30,	'delete',	'yes',	'2024-06-27 22:06:28',	1,	'2024-06-27 22:06:28',	1,	NULL,	NULL);

DROP TABLE IF EXISTS `queue_jobs`;
CREATE TABLE `queue_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(64)  NOT NULL,
  `payload` text  NOT NULL,
  `priority` varchar(64)  NOT NULL DEFAULT 'default',
  `status` tinyint unsigned NOT NULL DEFAULT '0',
  `attempts` tinyint unsigned NOT NULL DEFAULT '0',
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `queue_priority_status_available_at` (`queue`,`priority`,`status`,`available_at`)
);


DROP TABLE IF EXISTS `queue_jobs_failed`;
CREATE TABLE `queue_jobs_failed` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `connection` varchar(64)  NOT NULL,
  `queue` varchar(64)  NOT NULL,
  `payload` text  NOT NULL,
  `priority` varchar(64)  NOT NULL DEFAULT 'default',
  `exception` text  NOT NULL,
  `failed_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `queue` (`queue`)
);


DROP TABLE IF EXISTS `reportfields`;
CREATE TABLE `reportfields` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `report_id` int NOT NULL,
  `description` varchar(100)  DEFAULT NULL,
  `placeholder` varchar(100)  DEFAULT NULL,
  `type` enum('text','select','checkbox','radio','textarea') NOT NULL DEFAULT 'text',
  `options` longtext ,
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `report_id` (`report_id`),
  CONSTRAINT `reportfields_ibfk_1` FOREIGN KEY (`report_id`) REFERENCES `reports` (`id`)
);


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
);


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
);


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
);


DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `permissions` longtext,
  `default_role` enum('yes','no') DEFAULT 'no',
  `denomination_id` int DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `denomination_id` (`denomination_id`),
  CONSTRAINT `roles_ibfk_1` FOREIGN KEY (`denomination_id`) REFERENCES `denominations` (`id`)
);


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
);


DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `class` varchar(255)  NOT NULL,
  `key` varchar(255)  NOT NULL,
  `value` text ,
  `type` varchar(31)  NOT NULL DEFAULT 'string',
  `context` varchar(255)  DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
);


DROP TABLE IF EXISTS `subscriptions`;
CREATE TABLE `subscriptions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `denomination_id` int NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `subscription_type_id` int NOT NULL,
  `status` enum('active','terminated') NOT NULL DEFAULT 'active',
  `is_auto_renewal` enum('yes','no')  NOT NULL DEFAULT 'no',
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
);


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
);


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `denomination_id` int DEFAULT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `date_of_birth` date NOT NULL,
  `gender` enum('male','female')  NOT NULL,
  `phone` varchar(20)  DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100)  DEFAULT NULL,
  `roles` longtext,
  `is_system_admin` enum('yes','no') DEFAULT 'no',
  `access_count` int DEFAULT NULL,
  `accessed_at` datetime DEFAULT NULL,
  `last_password_reset_at` datetime DEFAULT NULL,
  `is_active` enum('yes','no')  NOT NULL DEFAULT 'yes',
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
);


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
);


-- 2024-08-12 14:49:53
