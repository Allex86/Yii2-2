-- --------------------------------------------------------
-- Хост:                         192.168.83.137
-- Версия сервера:               5.7.23-0ubuntu0.16.04.1 - (Ubuntu)
-- Операционная система:         Linux
-- HeidiSQL Версия:              9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Дамп структуры базы данных yii2advanced
CREATE DATABASE IF NOT EXISTS `yii2advanced` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `yii2advanced`;

-- Дамп структуры для таблица yii2advanced.migration
CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Дамп данных таблицы yii2advanced.migration: ~8 rows (приблизительно)
/*!40000 ALTER TABLE `migration` DISABLE KEYS */;
INSERT INTO `migration` (`version`, `apply_time`) VALUES
	('m000000_000000_base', 1534950535),
	('m130524_201442_init', 1534950540),
	('m180826_072502_create_task_table', 1535273090),
	('m180826_072613_create_project_table', 1535273090),
	('m180826_072650_create_project_user_table', 1535273090),
	('m180903_060426_add_active_column_to_project_table', 1535954707),
	('m180903_060437_add_project_id_column_to_task_table', 1535954707),
	('m180904_063854_add_avatar_column_to_user_table', 1536043152);
/*!40000 ALTER TABLE `migration` ENABLE KEYS */;

-- Дамп структуры для таблица yii2advanced.project
CREATE TABLE IF NOT EXISTS `project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `active` tinyint(1) DEFAULT '0',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk-project-created_by` (`created_by`),
  KEY `fk-project-updated_by` (`updated_by`),
  CONSTRAINT `fk-project-created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`),
  CONSTRAINT `fk-project-updated_by` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Дамп данных таблицы yii2advanced.project: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `project` DISABLE KEYS */;
/*!40000 ALTER TABLE `project` ENABLE KEYS */;

-- Дамп структуры для таблица yii2advanced.project_user
CREATE TABLE IF NOT EXISTS `project_user` (
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role` enum('manager','developer','tester') DEFAULT NULL,
  KEY `fk-project_user-user_id` (`user_id`),
  KEY `fk-project_user-project_id` (`project_id`),
  CONSTRAINT `fk-project_user-project_id` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`),
  CONSTRAINT `fk-project_user-user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Дамп данных таблицы yii2advanced.project_user: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `project_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `project_user` ENABLE KEYS */;

-- Дамп структуры для таблица yii2advanced.task
CREATE TABLE IF NOT EXISTS `task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `estimation` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `executor_id` int(11) DEFAULT NULL,
  `started_at` int(11) DEFAULT NULL,
  `completed_at` int(11) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk-task-executor_id` (`executor_id`),
  KEY `fk-task-created_by` (`created_by`),
  KEY `fk-task-updated_by` (`updated_by`),
  KEY `idx-task-project_id` (`project_id`),
  CONSTRAINT `fk-task-created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`),
  CONSTRAINT `fk-task-executor_id` FOREIGN KEY (`executor_id`) REFERENCES `user` (`id`),
  CONSTRAINT `fk-task-project_id` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-task-updated_by` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Дамп данных таблицы yii2advanced.task: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `task` DISABLE KEYS */;
/*!40000 ALTER TABLE `task` ENABLE KEYS */;

-- Дамп структуры для таблица yii2advanced.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `avatar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Дамп данных таблицы yii2advanced.user: ~3 rows (приблизительно)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `avatar`, `created_at`, `updated_at`) VALUES
	(1, 'Username1', 'ZY6O5Amd08eL7qFdbjHjMa1SyKXKpMIg', '$2y$13$kDeO5mT.2UW/JDvRAYqu2ehxjOYFBLoytfMw4fRcNRgwYnHxcX9TO', NULL, 'Username@mail.ru', 10, '5b8f7efbb0d7e.jpg', 1534950662, 1536130811),
	(2, 'Username2', 'l0AGugNSPcTZWNZleU37cxImzBKf8vOr', '$2y$13$6XA0LREnX3BAhpyYXWyYIODuVxthBNAWu5xF/26lZVEdN9BptCqaW', NULL, 'Username2@link.com', 10, '5b8f7f1b7335d.jpg', 1535961551, 1536131230),
	(4, 'Username3', 'W_se_r9-RFdWTBpFBWF1ZhJTued166S1', '$2y$13$2JH4lxb1VwC7RuNACQoiXOOqd5nMBoUyEM5ytVkO8m/laWiTCBPKu', NULL, 'Username3@link.com', 10, '5b8f7f3093000.jpg', 1536054080, 1536131246);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
