-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Wersja serwera:               10.2.9-MariaDB - mariadb.org binary distribution
-- Serwer OS:                    Win64
-- HeidiSQL Wersja:              9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Zrzut struktury bazy danych hotel_db
CREATE DATABASE IF NOT EXISTS `hotel_db` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `hotel_db`;

-- Zrzut struktury tabela hotel_db.history
CREATE TABLE IF NOT EXISTS `history` (
  `id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli hotel_db.history: ~0 rows (około)
DELETE FROM `history`;
/*!40000 ALTER TABLE `history` DISABLE KEYS */;
/*!40000 ALTER TABLE `history` ENABLE KEYS */;

-- Zrzut struktury tabela hotel_db.hotel
CREATE TABLE IF NOT EXISTS `hotel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `num_of_floors` int(30) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli hotel_db.hotel: ~1 rows (około)
DELETE FROM `hotel`;
/*!40000 ALTER TABLE `hotel` DISABLE KEYS */;
INSERT INTO `hotel` (`id`, `num_of_floors`) VALUES
	(1, 5);
/*!40000 ALTER TABLE `hotel` ENABLE KEYS */;

-- Zrzut struktury tabela hotel_db.reservations
CREATE TABLE IF NOT EXISTS `reservations` (
  `id` int(11) NOT NULL,
  `status` enum('PENDING','ACCEPTED','CANCELED','CONFIRMED') NOT NULL,
  `user_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `date_of_rent` datetime NOT NULL,
  `date_of_confirm` datetime DEFAULT NULL,
  `date_of_statement` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `FK_reservations_users` (`user_id`),
  KEY `FK_reservations_rooms` (`room_id`),
  CONSTRAINT `FK_reservations_rooms` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`),
  CONSTRAINT `FK_reservations_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli hotel_db.reservations: ~0 rows (około)
DELETE FROM `reservations`;
/*!40000 ALTER TABLE `reservations` DISABLE KEYS */;
/*!40000 ALTER TABLE `reservations` ENABLE KEYS */;

-- Zrzut struktury tabela hotel_db.rooms
CREATE TABLE IF NOT EXISTS `rooms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` enum('FREE','RESERVED') DEFAULT 'FREE',
  `number_of_beds` smallint(10) DEFAULT 1,
  `floor` smallint(5) DEFAULT 1,
  `room_number` mediumint(60) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli hotel_db.rooms: ~4 rows (około)
DELETE FROM `rooms`;
/*!40000 ALTER TABLE `rooms` DISABLE KEYS */;
INSERT INTO `rooms` (`id`, `status`, `number_of_beds`, `floor`, `room_number`) VALUES
	(1, 'FREE', 3, 1, 11),
	(2, 'FREE', 4, 1, 12),
	(3, 'RESERVED', 2, 1, 13),
	(4, 'FREE', 2, 2, 23);
/*!40000 ALTER TABLE `rooms` ENABLE KEYS */;

-- Zrzut struktury tabela hotel_db.sec
CREATE TABLE IF NOT EXISTS `sec` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hash` varchar(150) NOT NULL DEFAULT '0',
  `mode` varchar(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli hotel_db.sec: ~0 rows (około)
DELETE FROM `sec`;
/*!40000 ALTER TABLE `sec` DISABLE KEYS */;
INSERT INTO `sec` (`id`, `hash`, `mode`) VALUES
	(1, 'aaa', 'aes-128-gcm');
/*!40000 ALTER TABLE `sec` ENABLE KEYS */;

-- Zrzut struktury tabela hotel_db.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `register_date` datetime NOT NULL DEFAULT current_timestamp(),
  `last_login_date` datetime DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `status` enum('USER','WORKER','ADMIN') NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli hotel_db.users: ~2 rows (około)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `register_date`, `last_login_date`, `password`, `email`, `status`, `phone`) VALUES
	(1, '2018-01-29 18:58:04', NULL, '$2y$10$yO./DclhkUJSnYz7nGyALOvD4MIhqxo26fjTFuI7kaz.aVUgPsML.', 'aaa@aaa.pl', 'USER', NULL),
	(5, '2018-02-02 17:06:20', NULL, '$2y$10$7GVToyDAiUlj3WQY1aQM/eASesqogzjF./GAuGPjAGR.rVXO4MNV2', 'someone@o2.pl', 'USER', NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
