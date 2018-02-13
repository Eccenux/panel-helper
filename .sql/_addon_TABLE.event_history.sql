--
-- Struktura tabeli dla tabeli `event_history`
--
--DROP TABLE IF EXISTS event_history;
CREATE TABLE IF NOT EXISTS `event_history` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,

  `uuid` varchar(50),
  `dt_create` DATETIME,
  `dt_change` DATETIME,
  `history_data` LONGTEXT,

  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`)
);
