<?php
/** @var PDO $pdo */
require_once './pdo_ini.php';

$sql = <<<'SQL'
DROP TABLE IF EXISTS `todo_lists`;
CREATE TABLE `todo_lists` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`created_at` DATETIME NOT NULL DEFAULT current_timestamp(),
	PRIMARY KEY (`id`)
);
SQL;
$pdo->exec($sql);

$sql = <<<'SQL'
DROP TABLE IF EXISTS `todo_tasks`;
CREATE TABLE `todo_tasks` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
 	`todo_list_id` INT(10) UNSIGNED NOT NULL,
	`is_done` TINYINT(1) NOT NULL,
	`title` VARCHAR(100) NOT NULL COLLATE 'utf8_general_ci',
	`created_at` DATETIME NOT NULL DEFAULT current_timestamp(),
--	`user_id` INT(10) UNSIGNED,
	PRIMARY KEY (`id`),
 	FOREIGN KEY (`todo_list_id`) REFERENCES todo_lists(id) ON DELETE CASCADE
);
SQL;
$pdo->exec($sql);

//$sql = <<<'SQL'
//DROP TABLE IF EXISTS `users`;
//CREATE TABLE `users` (
//	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
//	`username` VARCHAR(25) NOT NULL COLLATE 'utf8_general_ci',
//	`password` VARCHAR(25) NOT NULL COLLATE 'utf8_general_ci',
//	`email` VARCHAR(25) NOT NULL COLLATE 'utf8_general_ci',
//	PRIMARY KEY (`id`)
//);
//SQL;
//$pdo->exec($sql);


