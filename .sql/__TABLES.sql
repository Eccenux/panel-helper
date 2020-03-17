/*
INSERT INTO personal (`id`, `dt`, `imie`, `nazwisko`, `nr_tel`, `e_mail`)
INSERT INTO ids (`id`, `dt`, `ankieta_id`)

INSERT INTO profile (`id`, `dt`, `miejsce`, 											   `plec`, `rok`, 			  `wyksztalcenie`, `ankieta_id`)
INSERT INTO profile (`id`, `dt`, `miejsce`, `kod_rej_ym`, `kod_rej_id`, `kod_rejestracji`, `plec`, `wiek`, `data_ur`, `wyksztalcenie`, `ankieta_id`)

*/
-- Parametry statystyczne (kryteria).
DROP TABLE IF EXISTS profile;
CREATE TABLE profile (
	id	int UNSIGNED NOT NULL,
	dt	varchar(19),
	
	`miejsce`	varchar(200),
	`kod_rej_ym`	varchar(20),
	`kod_rej_id`	varchar(20),
	`kod_rejestracji`	varchar(30),
	`plec`	varchar(20),
	`wiek`	varchar(10),
	`data_ur`	varchar(20),
	`wyksztalcenie`	varchar(10),
	`transport`	varchar(50),
	
	`ankieta_id`	varchar(20),
	
	`grupa`	varchar(20) DEFAULT 'w puli',
	`dt_change` datetime DEFAULT NULL,
	
	PRIMARY KEY (id),
	KEY (id)
);

-- dodatkowa kolumna w profilach z rejestracji
ALTER TABLE profile ADD COLUMN `search_profile_id` int(10) unsigned DEFAULT NULL AFTER grupa;

-- Dane osobowe i preferencje.
DROP TABLE IF EXISTS personal;
CREATE TABLE personal (
	id	int UNSIGNED NOT NULL,
	dt	varchar(19),
	
	`imie`	varchar(200),
	`nazwisko`	varchar(200),
	`nr_tel`	varchar(200),
	`e_mail`	varchar(200),
	`jedzenie`	varchar(500),
	`jedzenie_inne`	varchar(500),
	`dziecko_opieka`	varchar(200),
	`niepelnosprawnosc`	varchar(500),
	
	`ankieta_id`	varchar(20),
	
	PRIMARY KEY (id)
);

DROP TABLE IF EXISTS ids;
CREATE TABLE ids (
	id	int UNSIGNED NOT NULL,
	dt	varchar(19),
	
	`ankieta_id`	varchar(20),
	
	PRIMARY KEY (id),
	KEY (ankieta_id)
);

