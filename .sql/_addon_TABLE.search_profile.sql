--
-- Profil wyszukiwawczy (na podstawie tabeli z Polosa).
--

--DROP TABLE IF EXISTS `search_profile`;

CREATE TABLE IF NOT EXISTS `search_profile` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`dt_create` datetime DEFAULT NULL,
	`dt_change` datetime DEFAULT NULL,

	`group_name` varchar(20) DEFAULT NULL,
	
	-- kryteria
	`sex` varchar(100) DEFAULT NULL,
	`age_min` int(11) DEFAULT NULL,
	`age_max` int(11) DEFAULT NULL,
	`region` varchar(200) DEFAULT NULL,
	`education` varchar(10) DEFAULT NULL,
	`transport` varchar(50) DEFAULT NULL,

	-- w³aœciwie niepotrzebne (Polos specific)
	`invites_no` int(11) DEFAULT NULL,
	`row_state` int(11) DEFAULT '0',

	`csv_row` text,
	`csv_file` int(10) unsigned DEFAULT NULL,
	PRIMARY KEY (`id`),
	KEY `csv_file` (`csv_file`)
);