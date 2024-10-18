-- Adminer 4.8.1 MySQL 8.0.28 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE TABLE `assemblies` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `assembly_code` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
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


CREATE TABLE `customfields` (
  `id` int NOT NULL AUTO_INCREMENT,
  `denomination_id` int DEFAULT NULL,
  `field_name` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `field_code` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `helptip` longtext CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `table_name` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `type` enum('string','text','float','date','datetime','timestamp','password','numeric','email','dropdown','boolean') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'string',
  `options` longtext NOT NULL,
  `feature_id` int NOT NULL,
  `field_order` int DEFAULT '0',
  `visible` enum('yes','no') NOT NULL DEFAULT 'yes',
  `query_builder` json DEFAULT NULL,
  `code_builder` longtext CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `created_at` datetime DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`field_name`),
  KEY `feature_id` (`feature_id`),
  KEY `denomination_id` (`denomination_id`),
  CONSTRAINT `customfields_ibfk_1` FOREIGN KEY (`feature_id`) REFERENCES `features` (`id`),
  CONSTRAINT `customfields_ibfk_2` FOREIGN KEY (`denomination_id`) REFERENCES `denominations` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `customfields` (`id`, `denomination_id`, `field_name`, `field_code`, `helptip`, `table_name`, `type`, `options`, `feature_id`, `field_order`, `visible`, `query_builder`, `code_builder`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(8,	3,	'Total Membership',	'total_membership',	'Enter the total number of members',	'reports',	'numeric',	'',	18,	1,	'yes',	'[{\"table\": \"members\", \"select\": \"count\", \"conditions\": [{\"key\": \"assembly_id\", \"operator\": \"equals\"}]}]',	NULL,	'2024-10-17 12:19:49',	0,	'2024-10-17 12:19:49',	0,	NULL,	NULL),
(9,	3,	'Number Saved',	'number_saved',	'Enter the total number of members saved',	'reports',	'numeric',	'',	18,	2,	'yes',	'[{\"table\": \"members\", \"select\": \"count\", \"conditions\": [{\"key\": \"assembly_id\", \"operator\": \"equals\"}, {\"key\": \"saved_date\", \"operator\": \"in_month\"}]}]',	'',	'2024-10-17 12:19:49',	0,	'2024-10-17 12:19:49',	0,	NULL,	NULL),
(10,	3,	'Number Sanctified',	'number_sanctified',	'Enter the total number of members sanctified',	'reports',	'numeric',	'',	18,	3,	'yes',	'[{\"table\": \"members\", \"select\": \"count\", \"conditions\": [{\"key\": \"assembly_id\", \"operator\": \"equals\"}, {\"key\": \"c__sanctified_date\", \"operator\": \"in_month\"}]}]',	NULL,	'2024-10-17 12:19:49',	0,	'2024-10-17 12:19:49',	0,	NULL,	NULL),
(11,	3,	'Enclosed any news to share?',	'enclosed_news',	'Indicate \"Yes\" if news report has been sent to the head quarter',	'reports',	'boolean',	'yes\r\nno',	18,	4,	'yes',	'[]',	NULL,	'2024-10-17 12:19:49',	0,	'2024-10-17 12:19:49',	0,	NULL,	NULL),
(12,	3,	'Total Female Members',	'female_members',	'Count of Female Members',	'',	'numeric',	'',	18,	5,	'yes',	'[{\"table\": \"members\", \"select\": \"count\", \"conditions\": [{\"key\": \"assembly_id\", \"operator\": \"equals\"}, {\"key\": \"gender\", \"value\": \"female\", \"operator\": \"equals\"}]}]',	NULL,	NULL,	NULL,	'2024-10-17 13:55:31',	NULL,	NULL,	NULL),
(13,	3,	'Sanctified Date',	'sanctified_date',	'The date the member was sanctified',	'members',	'date',	'',	11,	1,	'yes',	'[]',	NULL,	NULL,	NULL,	'2024-10-17 17:25:08',	NULL,	NULL,	NULL),
(14,	3,	'Number filled with Holy Ghost',	'holy_ghost_filled',	'The number filled with the Holy Ghost in the month',	'reports',	'numeric',	'',	18,	6,	'yes',	'[{\"table\": \"members\", \"select\": \"count\", \"conditions\": [{\"key\": \"assembly_id\", \"operator\": \"equals\"}, {\"key\": \"c__date_filled_of_holy_ghost\", \"operator\": \"in_month\"}]}]',	NULL,	NULL,	NULL,	'2024-10-18 14:44:10',	NULL,	NULL,	NULL),
(15,	3,	'Number of people baptised in water',	'water_baptised',	'Number of people baptised of water in the month',	'reports',	'numeric',	'',	18,	7,	'yes',	'[{\"table\": \"members\", \"select\": \"count\", \"conditions\": [{\"key\": \"assembly_id\", \"operator\": \"equals\"}, {\"key\": \"c__date_water_baptism\", \"operator\": \"in_month\"}]}]',	NULL,	NULL,	NULL,	'2024-10-18 14:45:34',	NULL,	NULL,	NULL),
(16,	3,	'Members Transferred Away',	'transfered_away',	'Number of members transferred away in the month',	'reports',	'numeric',	'',	18,	8,	'yes',	NULL,	NULL,	NULL,	NULL,	'2024-10-18 14:46:48',	NULL,	NULL,	NULL),
(17,	3,	'Members transferred in',	'members_transferred_in',	'Number of members transferred in the month',	'reports',	'numeric',	'',	18,	9,	'yes',	NULL,	NULL,	NULL,	NULL,	'2024-10-18 14:48:02',	NULL,	NULL,	NULL),
(18,	3,	'Number Deceased',	'number_deceased',	'Number of members deceased in the month',	'reports',	'numeric',	'',	18,	10,	'yes',	'[{\"table\": \"members\", \"select\": \"count\", \"conditions\": [{\"key\": \"assembly_id\", \"operator\": \"equals\"}, {\"key\": \"inactivation_reason\", \"value\": \"deceased\", \"operator\": \"equals\"}, {\"key\": \"inactivation_date\", \"operator\": \"in_month\"}]}]',	NULL,	NULL,	NULL,	'2024-10-18 14:48:58',	NULL,	NULL,	NULL),
(19,	3,	'Number Added',	'number_added',	'Number of new members from other Churches outside COGOP',	'reports',	'numeric',	'',	18,	11,	'yes',	'[{\"table\": \"members\", \"select\": \"count\", \"conditions\": [{\"key\": \"assembly_id\", \"operator\": \"equals\"}, {\"key\": \"membership_date\", \"operator\": \"in_month\"}]}]',	NULL,	NULL,	NULL,	'2024-10-18 14:50:25',	NULL,	NULL,	NULL),
(20,	3,	'Number Excluded',	'number_excluded',	'Number of members who moved outside COGOP churches',	'reports',	'numeric',	'',	18,	12,	'yes',	'[{\"table\": \"members\", \"select\": \"count\", \"conditions\": [{\"key\": \"assembly_id\", \"operator\": \"equals\"}, {\"key\": \"inactivation_reason\", \"value\": \"excluded\", \"operator\": \"equals\"}, {\"key\": \"inactivation_date\", \"operator\": \"in_month\"}]}]',	NULL,	NULL,	NULL,	'2024-10-18 14:53:18',	NULL,	NULL,	NULL),
(21,	3,	'Average Sunday School Attendance',	'avg_sunday_school_attendance',	'Average count of Sunday School children attending classes in the month',	'reports',	'numeric',	'',	18,	13,	'yes',	NULL,	NULL,	NULL,	NULL,	'2024-10-18 14:56:13',	NULL,	NULL,	NULL),
(23,	3,	'Number of weekly attendance',	'weekly_attendance',	'Number of weekly attendance being ministered including children, youth, people attending outreach ministries in the month',	'reports',	'numeric',	'',	18,	14,	'yes',	NULL,	NULL,	NULL,	NULL,	'2024-10-18 14:58:33',	NULL,	NULL,	NULL),
(24,	3,	'Proportion of attendance who are children and youth ',	'',	'Proportion of attendance who are children and youth e.g. one third, one half',	'reports',	'text',	'',	18,	15,	'yes',	NULL,	NULL,	NULL,	NULL,	'2024-10-18 15:00:55',	NULL,	NULL,	NULL),
(25,	3,	'Department of Pastoral Care',	'check_department_pastoral_care',	'Check if there is leadership for department of pastoral care in the local church in the month',	'reports',	'boolean',	'Yes\r\nNo',	18,	16,	'yes',	'[{\"join\": [{\"table\": \"designations\", \"relation_id\": \"id\", \"relation_order\": 1, \"relation_table\": {\"table\": \"members\", \"relation_id\": \"designation_id\"}}, {\"table\": \"departments\", \"relation_id\": \"id\", \"relation_order\": 2, \"relation_table\": {\"table\": \"designations\", \"relation_id\": \"department_id\"}}], \"table\": \"members\", \"select\": \"count\", \"conditions\": [{\"key\": \"assembly_id\", \"operator\": \"equals\"}, {\"key\": \"department_code\", \"value\": \"pastoral_care\", \"operator\": \"equals\"}]}]',	NULL,	NULL,	NULL,	'2024-10-18 15:03:07',	NULL,	NULL,	NULL),
(26,	3,	'Youth Ministries',	'check_youth_ministries',	'Check if there is leadership for Youth Ministry in the local church',	'reports',	'boolean',	'Yes\r\nNo',	18,	17,	'yes',	'[{\"join\": [{\"table\": \"designations\", \"relation_id\": \"id\", \"relation_order\": 1, \"relation_table\": {\"table\": \"members\", \"relation_id\": \"designation_id\"}}, {\"table\": \"departments\", \"relation_id\": \"id\", \"relation_order\": 2, \"relation_table\": {\"table\": \"designations\", \"relation_id\": \"department_id\"}}], \"table\": \"members\", \"select\": \"count\", \"conditions\": [{\"key\": \"assembly_id\", \"operator\": \"equals\"}, {\"key\": \"department_code\", \"value\": \"youth_ministry\", \"operator\": \"equals\"}]}]',	NULL,	NULL,	NULL,	'2024-10-18 15:04:02',	NULL,	NULL,	NULL),
(27,	3,	'Children Ministries',	'check_children_ministries',	'Check if the local church has children ministry leadership in place in the month',	'reports',	'boolean',	'Yes\r\nNo',	18,	18,	'yes',	'[{\"join\": [{\"table\": \"designations\", \"relation_id\": \"id\", \"relation_order\": 1, \"relation_table\": {\"table\": \"members\", \"relation_id\": \"designation_id\"}}, {\"table\": \"departments\", \"relation_id\": \"id\", \"relation_order\": 2, \"relation_table\": {\"table\": \"designations\", \"relation_id\": \"department_id\"}}], \"table\": \"members\", \"select\": \"count\", \"conditions\": [{\"key\": \"assembly_id\", \"operator\": \"equals\"}, {\"key\": \"department_code\", \"value\": \"children_ministry\", \"operator\": \"equals\"}]}]',	NULL,	NULL,	NULL,	'2024-10-18 15:06:33',	NULL,	NULL,	NULL),
(28,	3,	'Christian Education (Sunday School)',	'check_christian_education',	'Check if local church has Sunday School leadership in place in the month',	'reports',	'boolean',	'Yes\r\nNo',	18,	19,	'yes',	'[{\"join\": [{\"table\": \"designations\", \"relation_id\": \"id\", \"relation_order\": 1, \"relation_table\": {\"table\": \"members\", \"relation_id\": \"designation_id\"}}, {\"table\": \"departments\", \"relation_id\": \"id\", \"relation_order\": 2, \"relation_table\": {\"table\": \"designations\", \"relation_id\": \"department_id\"}}], \"table\": \"members\", \"select\": \"count\", \"conditions\": [{\"key\": \"assembly_id\", \"operator\": \"equals\"}, {\"key\": \"department_code\", \"value\": \"sunday_school_ministry\", \"operator\": \"equals\"}]}]',	NULL,	NULL,	NULL,	'2024-10-18 15:08:01',	NULL,	NULL,	NULL),
(29,	3,	'Women\'s Ministries',	'check_women_ministries',	'Check if local church women ministries leadership in place in the month',	'reports',	'boolean',	'Yes\r\nNo',	18,	20,	'yes',	'[{\"join\": [{\"table\": \"designations\", \"relation_id\": \"id\", \"relation_order\": 1, \"relation_table\": {\"table\": \"members\", \"relation_id\": \"designation_id\"}}, {\"table\": \"departments\", \"relation_id\": \"id\", \"relation_order\": 2, \"relation_table\": {\"table\": \"designations\", \"relation_id\": \"department_id\"}}], \"table\": \"members\", \"select\": \"count\", \"conditions\": [{\"key\": \"assembly_id\", \"operator\": \"equals\"}, {\"key\": \"department_code\", \"value\": \"women_ministry\", \"operator\": \"equals\"}]}]',	NULL,	NULL,	NULL,	'2024-10-18 15:10:59',	NULL,	NULL,	NULL),
(30,	3,	'First Sunday Offerings',	'first_sunday_offerings',	'Check if there was a collection for first sunday offering ',	'reports',	'boolean',	'Yes\r\nNo',	18,	21,	'yes',	NULL,	NULL,	NULL,	NULL,	'2024-10-18 15:13:27',	NULL,	NULL,	NULL),
(31,	3,	'Second Sunday Missions',	'second_sunday_missions',	'Check if a local church had second Sunday missions collection in the month',	'reports',	'boolean',	'Yes\r\nNo',	18,	22,	'yes',	NULL,	NULL,	NULL,	NULL,	'2024-10-18 15:16:50',	NULL,	NULL,	NULL),
(32,	3,	'Fourth Sunday ',	'fourth_sunday',	'Check if local church had fourth Sunday collection',	'reports',	'boolean',	'Yes\r\nNo',	18,	23,	'yes',	NULL,	NULL,	NULL,	NULL,	'2024-10-18 15:18:11',	NULL,	NULL,	NULL),
(33,	3,	'Did you have revival this month?',	'had_revival_in_month',	'Check if the local church had a revival in the month',	'reports',	'boolean',	'Yes\r\nNo',	18,	24,	'yes',	NULL,	NULL,	NULL,	NULL,	'2024-10-18 15:19:49',	NULL,	NULL,	NULL),
(34,	3,	'Number of Bible Study and/or Training programs this month?',	'bible_study_and_training',	'Number of Bible Study and/or Training programs this month?',	'reports',	'numeric',	'',	18,	25,	'yes',	NULL,	NULL,	NULL,	NULL,	'2024-10-18 15:21:12',	NULL,	NULL,	NULL),
(35,	3,	'Date Filled Of the Holy Ghost',	'date_filled_of_holy_ghost',	'The date the member was filled with the Holy Ghost',	'members',	'date',	'',	11,	2,	'yes',	NULL,	NULL,	NULL,	NULL,	'2024-10-18 15:38:03',	NULL,	NULL,	NULL),
(36,	3,	'Date of Water Baptism',	'date_water_baptism',	'The date the member was baptised of water',	'members',	'date',	'',	11,	3,	'yes',	NULL,	NULL,	NULL,	NULL,	'2024-10-18 16:17:54',	NULL,	NULL,	NULL);

CREATE TABLE `customvalues` (
  `id` int NOT NULL AUTO_INCREMENT,
  `feature_id` int NOT NULL,
  `record_id` int NOT NULL,
  `customfield_id` int DEFAULT NULL,
  `value` json DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customfield_id` (`customfield_id`),
  KEY `feature_id` (`feature_id`),
  CONSTRAINT `customvalues_ibfk_1` FOREIGN KEY (`customfield_id`) REFERENCES `customfields` (`id`),
  CONSTRAINT `customvalues_ibfk_2` FOREIGN KEY (`feature_id`) REFERENCES `features` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


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


CREATE TABLE `departments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `denomination_id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `department_code` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
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

INSERT INTO `departments` (`id`, `denomination_id`, `name`, `department_code`, `description`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(1,	3,	'Pastoral Care',	'pastoral_care',	'Pastoral Care',	'0000-00-00 00:00:00',	0,	'0000-00-00 00:00:00',	0,	NULL,	0),
(2,	3,	'Youth Ministry',	'youth_ministry',	'Youth Ministry',	'0000-00-00 00:00:00',	0,	'0000-00-00 00:00:00',	0,	NULL,	0),
(3,	3,	'Children Ministry',	'children_ministry',	'Children Ministry',	'0000-00-00 00:00:00',	0,	'0000-00-00 00:00:00',	0,	NULL,	0),
(4,	3,	'Sunday School Ministry',	'sunday_school_ministry',	'Sunday School Ministry',	'0000-00-00 00:00:00',	0,	'0000-00-00 00:00:00',	0,	NULL,	0),
(5,	3,	'Women Ministry',	'women_ministry',	'Women Ministry',	'0000-00-00 00:00:00',	0,	'0000-00-00 00:00:00',	0,	NULL,	0),
(6,	3,	'Development',	'development',	'Development',	'0000-00-00 00:00:00',	0,	'0000-00-00 00:00:00',	0,	NULL,	0);

CREATE TABLE `designations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `denomination_id` int NOT NULL,
  `is_hierarchy_leader_designation` enum('no','yes') CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `is_department_leader_designation` enum('no','yes') CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `is_minister_title_designation` enum('no','yes') CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `department_id` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `denomination_id` (`denomination_id`),
  KEY `department_id` (`department_id`),
  CONSTRAINT `designations_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


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


CREATE TABLE `events` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `meeting_id` int DEFAULT '1',
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `code` varchar(10) NOT NULL,
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

INSERT INTO `features` (`id`, `name`, `description`, `allowable_permission_labels`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(1,	'dashboard',	'Dashboard',	'[\"read\"]',	'2024-06-26 20:26:16',	1,	'2024-06-26 20:26:16',	1,	NULL,	NULL),
(2,	'hierarchy',	'Hierarchy',	'[\"create\", \"read\", \"update\", \"delete\"]',	'2024-06-26 20:34:21',	1,	'2024-06-26 20:34:21',	1,	NULL,	NULL),
(3,	'entity',	'Entity',	'[\"create\", \"read\", \"update\", \"delete\"]',	'2024-06-26 20:34:21',	1,	'2024-06-26 20:34:21',	1,	NULL,	NULL),
(4,	'assembly',	'Assembly',	'[\"create\", \"read\", \"update\", \"delete\"]',	'2024-06-26 20:34:21',	1,	'2024-06-26 20:34:21',	1,	NULL,	NULL),
(5,	'denomination',	'Denomination',	'[\"create\", \"read\", \"update\", \"delete\"]',	'2024-06-26 20:34:21',	1,	'2024-06-26 20:34:21',	1,	NULL,	NULL),
(6,	'collection',	'Collection',	'[\"create\", \"read\", \"update\", \"delete\"]',	'2024-06-26 20:34:21',	1,	'2024-06-26 20:34:21',	1,	NULL,	NULL),
(7,	'revenue',	'Revenue',	'[\"create\", \"read\", \"update\", \"delete\"]',	'2024-06-26 20:34:21',	1,	'2024-06-26 20:34:21',	1,	NULL,	NULL),
(8,	'designation',	'Designation',	'[\"create\", \"read\", \"update\", \"delete\"]',	'2024-06-26 20:34:21',	1,	'2024-06-26 20:34:21',	1,	NULL,	NULL),
(9,	'event',	'Events',	'[\"create\", \"read\", \"update\", \"delete\"]',	'2024-06-26 20:34:21',	1,	'2024-06-26 20:34:21',	1,	NULL,	NULL),
(10,	'meeting',	'Meetings',	'[\"create\", \"read\", \"update\", \"delete\"]',	'2024-06-26 20:34:21',	1,	'2024-06-26 20:34:21',	1,	NULL,	NULL),
(11,	'member',	'Members',	'[\"create\", \"read\", \"update\", \"delete\"]',	'2024-06-26 20:34:21',	1,	'2024-06-26 20:34:21',	1,	NULL,	NULL),
(12,	'participant',	'Participants',	'[\"create\", \"read\", \"update\", \"delete\"]',	'2024-06-26 20:34:21',	1,	'2024-06-26 20:34:21',	1,	NULL,	NULL),
(13,	'role',	'Roles',	'[\"create\", \"read\", \"update\", \"delete\"]',	'2024-06-26 20:34:21',	1,	'2024-06-26 20:34:21',	1,	NULL,	NULL),
(14,	'subscription',	'Subscriptions',	'[\"create\", \"read\", \"update\", \"delete\"]',	'2024-06-26 20:34:21',	1,	'2024-06-26 20:34:21',	1,	NULL,	NULL),
(15,	'subscription_type',	'Subscription Types',	'[\"create\", \"read\", \"update\", \"delete\"]',	'2024-06-26 20:34:21',	1,	'2024-06-26 20:34:21',	1,	NULL,	NULL),
(16,	'user',	'Users',	'[\"create\", \"read\", \"update\", \"delete\"]',	'2024-06-26 20:34:21',	1,	'2024-06-26 20:34:21',	1,	NULL,	NULL),
(17,	'setting',	'Settings',	'[\"read\"]',	'2024-06-26 20:34:21',	1,	'2024-06-26 20:34:21',	1,	NULL,	NULL),
(18,	'report',	'Reports',	'[\"create\", \"read\", \"update\", \"delete\"]',	'2024-06-26 20:34:21',	1,	'2024-06-26 20:34:21',	1,	NULL,	NULL),
(19,	'type',	'Reports Types',	'[\"create\", \"read\", \"update\", \"delete\"]',	'2024-06-26 20:34:21',	1,	'2024-06-26 20:34:21',	1,	NULL,	NULL),
(22,	'attendance',	'Meeting Attendance',	'[\"create\", \"read\", \"update\", \"delete\"]',	'2024-06-26 20:34:21',	1,	'2024-06-26 20:34:21',	1,	NULL,	NULL),
(24,	'field',	'Custom Fields',	'[\"create\", \"read\", \"update\", \"delete\"]',	'2024-06-26 20:34:21',	1,	'2024-06-26 20:34:21',	1,	NULL,	NULL),
(25,	'value',	'Custom values',	'[\"create\", \"read\", \"update\", \"delete\"]',	'2024-06-26 20:34:21',	1,	'2024-06-26 20:34:21',	1,	NULL,	NULL),
(26,	'department',	'Departments',	'[\"create\", \"read\", \"update\", \"delete\"]',	'2024-06-26 20:34:21',	1,	'2024-06-26 20:34:21',	1,	NULL,	NULL),
(27,	'section',	'Report Sections',	'[\"create\", \"read\", \"update\", \"delete\"]',	'2024-06-26 20:34:21',	1,	'2024-06-26 20:34:21',	1,	NULL,	NULL),
(28,	'visitor',	'Event Visitors',	'[\"create\", \"read\", \"update\", \"delete\"]',	'2024-06-26 20:34:21',	1,	'2024-06-26 20:34:21',	1,	NULL,	NULL),
(29,	'payment',	'Event payments',	'[\"read\"]',	'2024-06-26 20:34:21',	1,	'2024-06-26 20:34:21',	1,	NULL,	NULL),
(30,	'minister',	'ministers',	'[\"create\", \"read\", \"update\", \"delete\"]',	'2024-06-26 20:34:21',	1,	'2024-06-26 20:34:21',	1,	NULL,	NULL),
(31,	'trash',	'trash',	'[\"read\"]',	'2024-06-26 20:34:21',	1,	'2024-06-26 20:34:21',	1,	NULL,	NULL),
(32,	'task',	'Task',	'[\"create\", \"read\", \"update\", \"delete\"]',	'2024-10-02 12:57:43',	1,	'2024-10-02 12:57:43',	1,	NULL,	NULL),
(33,	'status',	'Status',	'[\"create\", \"read\", \"update\", \"delete\"]',	'2024-10-02 12:58:43',	1,	'2024-10-02 12:58:43',	1,	NULL,	NULL);

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


CREATE TABLE `hierarchies` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `denomination_id` int NOT NULL,
  `hierarchy_code` varchar(10) NOT NULL,
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


CREATE TABLE `members` (
  `id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `gender` enum('male','female') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `membership_date` date DEFAULT NULL,
  `member_number` varchar(100) DEFAULT NULL,
  `designation_id` int DEFAULT NULL,
  `parent_id` int DEFAULT NULL,
  `date_of_birth` date NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(100) NOT NULL,
  `saved_date` date DEFAULT NULL,
  `inactivation_reason` enum('deceased','excluded','other') DEFAULT NULL,
  `inactivation_date` date DEFAULT NULL,
  `is_active` enum('yes','no') NOT NULL DEFAULT 'yes',
  `assembly_id` int NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `assembly_id` (`assembly_id`),
  KEY `designation_id` (`designation_id`),
  CONSTRAINT `members_ibfk_1` FOREIGN KEY (`assembly_id`) REFERENCES `assemblies` (`id`),
  CONSTRAINT `members_ibfk_2` FOREIGN KEY (`designation_id`) REFERENCES `designations` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


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


CREATE TABLE `reports` (
  `id` int NOT NULL AUTO_INCREMENT,
  `assembly_id` int DEFAULT NULL,
  `reports_type_id` int NOT NULL,
  `report_period` date NOT NULL,
  `report_date` date NOT NULL,
  `status` enum('draft','submitted','approved') NOT NULL DEFAULT 'draft',
  `created_at` datetime DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reports_type_id` (`reports_type_id`),
  KEY `assembly_id` (`assembly_id`),
  CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`reports_type_id`) REFERENCES `reporttypes` (`id`),
  CONSTRAINT `reports_ibfk_2` FOREIGN KEY (`assembly_id`) REFERENCES `assemblies` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `reporttypes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `type_code` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `denomination_id` int NOT NULL,
  `report_layout` json DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `denomination_id` (`denomination_id`),
  CONSTRAINT `reporttypes_ibfk_1` FOREIGN KEY (`denomination_id`) REFERENCES `denominations` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `reporttypes` (`id`, `name`, `type_code`, `denomination_id`, `report_layout`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(1,	'Assembly Monthly Report',	'monthly_report',	3,	'[{\"section_parts\": [{\"part_title\": \"Part A\", \"part_fields\": [\"8,10,12\"]}, {\"part_title\": \"Part B\", \"part_fields\": [\"11,9\"]}], \"section_title\": \"Section A\"}, {\"section_parts\": [{\"part_title\": \"Part C\", \"part_fields\": [\"9,11\"]}, {\"part_title\": \"Part D\", \"part_fields\": [\"8,10\"]}], \"section_title\": \"Section B\"}]',	'2024-10-16 16:00:04',	0,	'2024-10-16 16:00:04',	0,	NULL,	NULL),
(7,	'Quarterly',	'quarterly_report',	3,	'[{\"section_parts\": [{\"part_title\": \"Part 1\", \"part_fields\": [\"8,9\"]}, {\"part_title\": \"Part 2\", \"part_fields\": [\"10,11\"]}], \"section_title\": \"Pastor Report\"}, {\"section_parts\": [{\"part_title\": \"Part 3\", \"part_fields\": [\"8,10,11,9\"]}], \"section_title\": \"Deacon Report\"}, {\"section_parts\": [{\"part_title\": \"\", \"part_fields\": [\"8,10\"]}, {\"part_title\": \"\", \"part_fields\": [\"8,11\"]}, {\"part_title\": \"\", \"part_fields\": [\"10,11\"]}], \"section_title\": \"Treasurer Report\"}]',	'2024-10-16 16:00:04',	0,	'2024-10-16 16:00:04',	0,	NULL,	NULL),
(8,	'Local Church Monthly Report',	'local_church_monthly_report',	3,	'[{\"section_parts\": [{\"part_title\": \"Membership\", \"part_fields\": [\"8,9,10,14,15,16,17,18,19,20,21,23,24,11\"]}, {\"part_title\": \"Are these auxillaries operating in the local Church?\", \"part_fields\": [\"25,26,27,28,29\"]}, {\"part_title\": \"Did the church take the following offerings?\", \"part_fields\": [\"30,31,32\"]}, {\"part_title\": \"Others\", \"part_fields\": [\"33,34\"]}], \"section_title\": \"Pastor\'s Local Church Report\"}]',	NULL,	NULL,	'2024-10-18 15:27:01',	NULL,	NULL,	NULL);

CREATE TABLE `reportvalues` (
  `id` int NOT NULL AUTO_INCREMENT,
  `report_id` int DEFAULT NULL,
  `customfield_id` int DEFAULT NULL,
  `report_value` longtext NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int NOT NULL,
  `deleted_at` datetime NOT NULL,
  `deleted_by` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `report_field_id` (`customfield_id`),
  KEY `report_id` (`report_id`),
  CONSTRAINT `reportvalues_ibfk_2` FOREIGN KEY (`report_id`) REFERENCES `reports` (`id`),
  CONSTRAINT `reportvalues_ibfk_3` FOREIGN KEY (`customfield_id`) REFERENCES `customfields` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


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


CREATE TABLE `trashes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `feature_id` int DEFAULT NULL,
  `feature_name` int DEFAULT NULL,
  `item_id` int NOT NULL,
  `item_name` longtext CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `item_deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `feature_name` (`feature_name`),
  KEY `feature_id` (`feature_id`),
  CONSTRAINT `trashes_ibfk_1` FOREIGN KEY (`feature_name`) REFERENCES `features` (`id`),
  CONSTRAINT `trashes_ibfk_2` FOREIGN KEY (`feature_id`) REFERENCES `features` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


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


-- 2024-10-18 17:48:16
