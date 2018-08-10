PRAGMA foreign_keys=OFF;
BEGIN TRANSACTION;
CREATE TABLE `expedite_logs` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `type` varchar(50) NOT NULL,
  `created` datetime NOT NULL,
  `message` text NOT NULL,
  `notes` text NOT NULL
);
CREATE TABLE `cake_sessions` (
  `id` varchar(255) NOT NULL DEFAULT '',
  `data` text,
  `expires` int(11) DEFAULT NULL
);
CREATE TABLE `document_types` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `name` varchar(255) NOT NULL
);
CREATE TABLE `message_attachments` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `message_id` int(10) NOT NULL,
  `filename` varchar(255) NOT NULL
);
CREATE TABLE `message_blind_copies` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `message_id` int(10) NOT NULL,
  `email` varchar(255) NOT NULL
);
CREATE TABLE `message_copies` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `message_id` int(10) NOT NULL,
  `email` varchar(255) NOT NULL
);
CREATE TABLE `message_recipients` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `message_id` int(10) NOT NULL,
  `email` varchar(255) NOT NULL
);
CREATE TABLE `requested_urls` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `user_group_id` int(10) DEFAULT NULL,
  `controller` varchar(100) NOT NULL,
  `action` varchar(100) NOT NULL
);
CREATE TABLE `support_requests` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `support_request_type_id` int(10) NOT NULL,
  `support_request_status_id` int(10) NOT NULL,
  `requested_user_id` int(10) NOT NULL,
  `closing_user_id` int(10) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `closing_date` datetime DEFAULT NULL,
  `title` varchar(255) NOT NULL,
	`type_of_action` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `notes` text,
  `file` varchar(255) DEFAULT NULL
);
CREATE TABLE `support_request_statuses` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `name` varchar(255) NOT NULL,
  `css_class` varchar(255) DEFAULT NULL,
  `sort` int(10) NOT NULL DEFAULT '0'
);
INSERT INTO `support_request_statuses` VALUES (1, 'default', 'info', 0);
CREATE TABLE `support_request_types` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `name` varchar(255) NOT NULL
);
INSERT INTO `support_request_types` VALUES (1, 'Normal');
CREATE TABLE `surveys` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `name` varchar(255) NOT NULL
);
INSERT INTO `surveys` VALUES (1, 'Test Survey');
CREATE TABLE `survey_questions` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `survey_section_id` int(10) NOT NULL,
  `survey_question_type_id` int(10) NOT NULL,
  `question` varchar(300) NOT NULL
);
INSERT INTO `survey_questions` VALUES (1, 1, 1, 'Is this a test question?');
INSERT INTO `survey_questions` VALUES (2, 1, 4, 'Favorite Color?');
CREATE TABLE `survey_question_choices` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `survey_question_id` int(10) NOT NULL,
  `choice` varchar(255) NOT NULL
);
INSERT INTO `survey_question_choices` VALUES (1, 2, 'Red');
INSERT INTO `survey_question_choices` VALUES (2, 2, 'Green');
INSERT INTO `survey_question_choices` VALUES (3, 2, 'Blue');
CREATE TABLE `survey_question_responses` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `user_id` int(10) NOT NULL,
  `survey_question_id` int(10) NOT NULL,
  `response` varchar(255) NOT NULL
);
CREATE TABLE `survey_question_types` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `name` varchar(255) NOT NULL
);
INSERT INTO `survey_question_types` VALUES (1, 'Boolean');
INSERT INTO `survey_question_types` VALUES (4, 'Multiple Choice');
CREATE TABLE `survey_sections` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `survey_id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL
);
INSERT INTO `survey_sections` VALUES (1, 1, 'Test Survey Section');
CREATE TABLE `templates` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `template_type_id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `body` text NOT NULL
);
CREATE TABLE `template_types` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `name` varchar(255) NOT NULL
);
INSERT INTO `template_types` VALUES(1, 'Default');
CREATE TABLE `users` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `is_superuser` tinyint(1) NOT NULL DEFAULT '0',
  `is_manager` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
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
  `show_tooltips` tinyint(1) NOT NULL DEFAULT '1',
  `theme` varchar(255) NOT NULL DEFAULT 'expedite'
);
INSERT INTO users VALUES(1,1,0,1,'expedite','8cf24d3c31179456740c6a2bb0b9b448e88ac55e','expedite','expedite','expedite@example.com',NULL,NULL,NULL,NULL,NULL,1,'expedite');
CREATE TABLE `users_offices` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `user_id` int(10) NOT NULL,
  `office_id` int(10) NOT NULL
);
INSERT INTO users_offices VALUES(1,1,1);
CREATE TABLE `users_user_groups` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `user_id` int(10) NOT NULL,
  `user_group_id` int(10) NOT NULL
);
INSERT INTO users_user_groups VALUES(1,1,1);
CREATE TABLE `user_groups` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `name` varchar(50) NOT NULL
);
INSERT INTO user_groups VALUES(1,'Expedite');
CREATE TABLE `user_tasks` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `user_id` int(10) NOT NULL,
  `user_task_status_id` int(10) NOT NULL,
  `client_task_id` int(10) NOT NULL,
  `body` text NOT NULL
);
CREATE TABLE `user_task_statuses` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `name` varchar(255) NOT NULL
);
CREATE TABLE `documents` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `user_id` int(10) DEFAULT NULL,
  `usage` smallint(5) NOT NULL DEFAULT '1',
  `filename` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `mimetype` varchar(255) NOT NULL
);
CREATE TABLE `messages` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `user_id` int(10) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `sent` tinyint(1) NOT NULL DEFAULT '0',
  `subject` varchar(255) NOT NULL,
  `body` text NOT NULL
);
CREATE TABLE `offices` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `address` varchar(50) NOT NULL,
  `address_2` varchar(50) DEFAULT NULL,
  `city` varchar(50) NOT NULL,
  `state` char(2) NOT NULL,
  `zip` varchar(10) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `fax` varchar(15) DEFAULT NULL,
  `notes` text
);
INSERT INTO offices VALUES(1,'123 Test Road','','San Diego','CA','92101','5553537','5553537',NULL);
CREATE TABLE `regions` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `name` varchar(255) NOT NULL
);
CREATE TABLE `user_group_permissions` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `user_group_id` int(10) DEFAULT NULL,
  `plugin` varchar(255) DEFAULT NULL,
  `controller` varchar(255) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL
);
DELETE FROM sqlite_sequence;
INSERT INTO sqlite_sequence VALUES('users',1);
INSERT INTO sqlite_sequence VALUES('offices',1);
INSERT INTO sqlite_sequence VALUES('users_offices',1);
INSERT INTO sqlite_sequence VALUES('user_groups',1);
INSERT INTO sqlite_sequence VALUES('users_user_groups',1);
COMMIT;
